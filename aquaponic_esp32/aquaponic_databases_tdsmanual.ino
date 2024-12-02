#define BLYNK_TEMPLATE_ID "TMPL6RZMhw8J5"
#define BLYNK_TEMPLATE_NAME "Aquaponic System"
#define BLYNK_AUTH_TOKEN "4mNH7QejML8PoFzNbJiJMMoM1_Eh5HZp"

#include <WiFi.h>
#include <HTTPClient.h>
#include <WiFiClient.h>
#include <BlynkSimpleEsp32.h>

#include <OneWire.h>
#include <Wire.h>
#include <DallasTemperature.h>
#include <GravityTDS.h>


WiFiClient wifiClient;

//tds
#define TdsSensorPin 35
#define VREF 3.3              // analog reference voltage(Volt) of the ADC
#define SCOUNT  30             // sum of sample point

int analogBuffer[SCOUNT];     // store the analog value in the array, read from ADC
int analogBufferTemp[SCOUNT];
int analogBufferIndex = 0;
int copyIndex = 0;

float averageVoltage = 0;
float tdsValue = 0;
float temperature = 25;       // current temperature for compensation

//ph meter
float ph;
int ph_value;
float voltage;
float b = 21.34;
float m = -5.7;

//pin ultrasonic
const int trigPin = 33;
const int echoPin = 32;
// ultrasonic
#define SOUND_VELOCITY 0.034
#define CM_TO_INCH 0.393701

float max_air = 80;
long duration;
float distanceCm;
float distanceInch;
float ketinggianAir;
float volume;
int r = 20;
float pi = 3.14159265359;


// GPIO where the DS18B20 is connected to
const int oneWireBus = 5; 

// Setup a oneWire instance to communicate with any OneWire devices
OneWire oneWire(oneWireBus);

// Pass our oneWire reference to Dallas Temperature sensor 
DallasTemperature sensors(&oneWire);


char auth[] = BLYNK_AUTH_TOKEN;
char ssid[] = "tselhome-E638";
char pass[] = "Unikom2000";
// char ssid[] = "Samsung";
// char pass[] = "12345678";

int getMedianNum(int bArray[], int iFilterLen){
  int bTab[iFilterLen];
  for (byte i = 0; i<iFilterLen; i++)
  bTab[i] = bArray[i];
  int i, j, bTemp;
  for (j = 0; j < iFilterLen - 1; j++) {
    for (i = 0; i < iFilterLen - j - 1; i++) {
      if (bTab[i] > bTab[i + 1]) {
        bTemp = bTab[i];
        bTab[i] = bTab[i + 1];
        bTab[i + 1] = bTemp;
      }
    }
  }
  if ((iFilterLen & 1) > 0){
    bTemp = bTab[(iFilterLen - 1) / 2];
  }
  else {
    bTemp = (bTab[iFilterLen / 2] + bTab[iFilterLen / 2 - 1]) / 2;
  }
  return bTemp;
}
 

void setup(){
  Serial.begin(115200);
  Blynk.begin(auth,ssid,pass);
  connectWifi();
  pinMode(ph_value, INPUT);
  pinMode(trigPin, OUTPUT); // Sets the trigPin as an Output
  pinMode(echoPin, INPUT); // Sets the echoPin as an Input
  sensors.begin();
}

void connectWifi(){
  WiFi.mode(WIFI_OFF); //mencegah masalah koneksi yang terlalu lama
  delay(1000);
  WiFi.mode(WIFI_STA); //menjaga esp tidak terlihat sebagai hotspot
  WiFi.begin(ssid,pass);
  Serial.println("");
  Serial.print("Connecting");
  while(WiFi.status() !=WL_CONNECTED){
    delay(500);
    Serial.print(".");
    Serial.print(WiFi.status());; 
  }

  Serial.print(" ");
  Serial.print("Connected to ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP()); //IP address ESP kita
}

void loop(){
      sendData();
}

void sendData(){
  HTTPClient http;
  String postData;
  delay(1000);

   // ph
    ph_value = analogRead(34);
    voltage = ph_value *(3.3/4095.0);
    ph =  m * voltage + b;
      
      //ultrasonic
    // Clears the trigPin
    digitalWrite(trigPin, LOW);
    delayMicroseconds(2);
    // Sets the trigPin on HIGH state for 10 micro seconds
    digitalWrite(trigPin, HIGH);
    delayMicroseconds(10);
    digitalWrite(trigPin, LOW);
      
    // Reads the echoPin, returns the sound wave travel time in microseconds
    duration = pulseIn(echoPin, HIGH);
      
    // Calculate the distance
    distanceCm = duration * SOUND_VELOCITY/2;
    ketinggianAir = max_air - distanceCm ;
    volume = pi * pow(r,2)* max_air;
    
      
    // Convert to inches
    distanceInch = distanceCm * CM_TO_INCH;  
      
    // suhu ds
    sensors.requestTemperatures(); 
    float temperatureC = sensors.getTempCByIndex(0);
      //Serial.print("voltage:");
      //Serial.print(averageVoltage,2);
      //Serial.print("V   ");

      Blynk.run();
      Blynk.virtualWrite(V0,temperatureC); 
      Blynk.virtualWrite(V1,ph); 
      Blynk.virtualWrite(V2,tdsValue); 
      Blynk.virtualWrite(V3,distanceCm); 
      
      //temperature = readTemperature();
    static unsigned long analogSampleTimepoint = millis();
    if(millis()-analogSampleTimepoint > 40U){     //every 40 milliseconds,read the analog value from the ADC
      analogSampleTimepoint = millis();
      analogBuffer[analogBufferIndex] = analogRead(TdsSensorPin);    //read the analog value and store into the buffer
      analogBufferIndex++;
      if(analogBufferIndex == SCOUNT){ 
        analogBufferIndex = 0;
      }
    }   

      
    static unsigned long printTimepoint = millis();
    if(millis()-printTimepoint > 800U){
      printTimepoint = millis();
      for(copyIndex=0; copyIndex<SCOUNT; copyIndex++){
        analogBufferTemp[copyIndex] = analogBuffer[copyIndex];
        
        // read the analog value more stable by the median filtering algorithm, and convert to voltage value
        averageVoltage = getMedianNum(analogBufferTemp,SCOUNT) * (float)VREF / 4096.0;
        
        //temperature compensation formula: fFinalResult(25^C) = fFinalResult(current)/(1.0+0.02*(fTP-25.0)); 
        float compensationCoefficient = 1.0+0.05*(temperature-25.0);
        //temperature compensation
        float compensationVoltage=averageVoltage/compensationCoefficient;
        
        //convert voltage value to tds value
        tdsValue=(133.42*compensationVoltage*compensationVoltage*compensationVoltage - 255.86*compensationVoltage*compensationVoltage + 857.39*compensationVoltage)*0.7;
      }
    }

      Serial.print("TDS value:");
      Serial.print(tdsValue,0);
      Serial.print("ppm");

      // Serial.print(" | ");
      // Serial.print(ph_value);
      // Serial.print(" | ");
      // Serial.print(voltage);
      Serial.print(" | ");
      Serial.print("pH value :");
      Serial.print(ph);
      Serial.print("pH ");

      // Prints the distance on the Serial Monitor
      Serial.print(" | ");
      Serial.print("Jarak Sensor (cm): ");
      Serial.print(distanceCm);
      Serial.print(" Ketinggian Air (cm): ");
      Serial.print(ketinggianAir);
      Serial.print(" Volume Air (cm): ");
      Serial.print(volume);
      Serial.print(" | ");
      Serial.print("Temperature :");
      Serial.print(temperatureC);
      Serial.println("ºC");

  String sensorData1 = String(temperatureC);
  String sensorData2 = String(ph);
  String sensorData3 = String(tdsValue);
  String sensorData4 = String(ketinggianAir);

postData = "sensor1=" + sensorData1 + "&sensor2=" + sensorData2 + "&sensor3=" + sensorData3 + "&sensor4=" + sensorData4; 


  //masukkan IP server dan path program PHP
  http.begin( wifiClient,"http://192.168.8.148/esp/postData.php");
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpCode = http.POST(postData);
  String payload = http.getString();

  Serial.println(httpCode);
  Serial.println(payload);

  http.end();

  delay(30000);
}

