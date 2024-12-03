<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- icon -->
    <link rel="icon" href="image/favicon.ico" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-SOMETHING_LONG_HERE" crossorigin="anonymous" /> -->
    <!-- Bootstrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <!-- Data table -->
    <link
      rel="stylesheet"
      type="text/css"
      href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      type="text/css"
      href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css"
    />
    <link rel="stylesheet" href="css/styles.css" />
    <title>Data Sensor Akuaponik</title>
  </head>
  <body>
    <section id="readTimeData">
      <div class="container-fluid mt-5" style="text-align: center">
        <h2>Monitoring Akuaponik</h2>

        <div style="display: flex">
          <div class="card text-center">
            <div class="card-header table-responsive">Suhu Air (°C)</div>
            <div class="card-body">
              <h1><span id="suhu">0</span></h1>
            </div>
          </div>

          <div class="card text-center">
            <div class="card-header">pH Air (pH)</div>
            <div class="card-body">
              <h1><span id="ph">0</span></h1>
            </div>
          </div>

          <div class="card text-center">
            <div class="card-header">TDS Air (ppm)</div>
            <div class="card-body">
              <h1><span id="tds">0</span></h1>
            </div>
          </div>

          <div class="card text-center">
            <div class="card-header">Volume Air Cm<sup>3</sup></div>
            <div class="card-body">
              <h1><span id="ketinggian">0</span></h1>
            </div>
          </div>
        </div>
      </div>
    </section>
    <br />

    <section id="grafik" class="container-fluid">
      <div class="container-fluid border mt-2">
        <h3 class="text-center">Grafik Data Sensor Akuaponik</h3>
        <select id="dataLimit" onchange="fetchAndRenderData()">
          <option value="10">10 Data Terakhir</option>
          <option value="100">100 Data Terakhir</option>
          <option value="1000">1000 Data Terakhir</option>
        </select>
        <div class="row text-center">
          <div class="col-md-6 mb-4 border">
            <canvas id="chartDataSuhu"></canvas>
          </div>
          <div class="col-md-6 mb-4 border">
            <canvas id="chartDataph"></canvas>
          </div>
          <div class="col-md-6 mb-4 border">
            <canvas id="chartDataTds"></canvas>
          </div>
          <div class="col-md-6 mb-4 border">
            <canvas id="chartDataKetinggian"></canvas>
          </div>
        </div>
      </div>
    </section>

    <br />

    <section id="table Data">
      <div class="container border">
        <div class="row">
          <div class="col-12">
            <div
              class="card-mb-4 mt-2 border-0 text-center"
              style="border-radius: 10px"
            >
              <h3>Data Table Monitoring Akuaponik</h3>
              <div class="card-body">
                <div class="table-responsive p-4">
                  <table
                    class="table table-striped table-border align-items-center mb-0"
                    id="myTable"
                  >
                    <thead class="text-center">
                      <tr>
                        <th>No.</th>
                        <th>Suhu</th>
                        <th>pH</th>
                        <th>TDS</th>
                        <th>Ketinggian Air</th>
                        <th>Waktu</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                    include 'koneksi.php';
                    $no = 1;
                    $query = mysqli_query($conn,$sql);
                    while($row = mysqli_fetch_array($query)){
                    ?>

                      <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $row['suhu'] ?></td>
                        <td><?php echo $row['ph'] ?></td>
                        <td><?php echo $row['tds'] ?></td>
                        <td><?php echo $row['ketinggianAir'] ?></td>
                        <td><?php echo $row['waktu_baca'] ?></td>
                      </tr>

                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- jQuery first, then Popper.js, then Bootstrap JS-->
    <!-- <script
      src="https://code.jquery.com/jquery-3.7.1.js"
      integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
      crossorigin="anonymous"
    ></script> -->

    <!-- Bootstrap -->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <script type="text/javascript" src="Jquery/jquery-3.7.1.min.js"></script>
    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Data table Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script
      type="text/javascript"
      src="https://cdn.datatables.net/2.1.8/js/dataTables.js"
    ></script>
    <script
      type="text/javascript"
      src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"
    ></script>
    <script>
      $(document).ready(function () {
        $("#myTable").DataTable();
      });
    </script>
    <script>
      $(document).ready(function () {
        setInterval(function () {
          // Ambil data dari file PHP
          $.getJSON("data.php", function (data) {
            // Update elemen dengan data dari PHP
            $("#suhu").text(data.suhu);
            $("#ph").text(data.ph);
            $("#tds").text(data.tds);
            $("#ketinggian").text(data.ketinggian);
          }).fail(function () {
            console.error("Gagal memuat data");
          });
        }, 1000); // Memperbarui setiap 1 detik
        
        // Ambil data dari PHP
        function fecthAndRenderData() {
          const limit = document.getElementById("dataLimit").value;
          $.ajax({
            url: `getSensorData.php?limit=${limit}`, // Endpoint PHP
            method: "GET",
            success: function (response) {
              const labels = [];
              const suhuData = [];
              const phData = [];
              const tdsData = [];
              const ketinggianData = [];

              // Iterasi melalui data yang diambil
              response.forEach((row) => {
                labels.push(row.waktu_baca); // Menambahkan waktu ke label
                suhuData.push(row.suhu); // Menambahkan suhu ke data
                phData.push(row.ph); // Menambahkan ph ke data
                tdsData.push(row.tds); // Menambahkan tds ke data
                ketinggianData.push(row.ketinggianAir); // Menambahkan ketinggian ke data
              });

              // Membuat Chart
              const suhuCtx = document
                .getElementById("chartDataSuhu")
                .getContext("2d");
              new Chart(suhuCtx, {
                type: "line", // Tipe chart
                data: {
                  labels: labels, // Waktu baca
                  datasets: [
                    {
                      label: "Suhu (°C)",
                      fill: true,
                      data: suhuData, // Data suhu
                      borderColor: "rgb(219, 26, 26)",
                      backgroundColor: "rgb(219, 26, 26)",
                      borderWidth: 1,
                    },
                  ],
                },
                options: {
                  scales: {
                    y: {
                      beginAtZero: true,
                    },
                  },
                },
              });

              const phCtx = document
                .getElementById("chartDataph")
                .getContext("2d");
              new Chart(phCtx, {
                type: "line",
                data: {
                  labels: labels,
                  datasets: [
                    {
                      label: "pH",
                      fill: true,
                      data: phData,
                      borderColor: "rgba(26, 219, 55, 1)",
                      backgroundColor: "rgba(26, 219, 55, 0.2)",
                      borderWidth: 1,
                    },
                  ],
                },
                options: {
                  scales: {
                    y: {
                      beginAtZero: true,
                    },
                  },
                },
              });

              const tdsCtx = document
                .getElementById("chartDataTds")
                .getContext("2d");
              new Chart(tdsCtx, {
                type: "line",
                data: {
                  labels: labels,
                  datasets: [
                    {
                      label: "TDS (ppm)",
                      fill: true,
                      data: tdsData,
                      borderColor: "rgba(54, 162, 235, 1)",
                      backgroundColor: "rgba(54, 162, 235, 0.2)",
                      borderWidth: 1,
                    },
                  ],
                },
                options: {
                  scales: {
                    y: {
                      beginAtZero: true,
                    },
                  },
                },
              });

              const ketinggianCtx = document
                .getElementById("chartDataKetinggian")
                .getContext("2d");
              new Chart(ketinggianCtx, {
                type: "line",
                data: {
                  labels: labels,
                  datasets: [
                    {
                      label: "Volume air (Cm)",
                      fill: true,
                      data: ketinggianData,
                      borderColor: "rgba(219, 213, 26, 1)",
                      backgroundColor: "rgba(219, 213, 26, 0.2)",
                      borderWidth: 1,
                    },
                  ],
                },
                options: {
                  scales: {
                    y: {
                      beginAtZero: true,
                    },
                  },
                },
              });
            },
            error: function (err) {
              console.error("Error:", err);
            },
          });
        }

        // Fungsi untuk memperbarui chart
        function updateChart(
          canvasId,
          label,
          labels,
          data,
          borderColor,
          backgroundColor
        ) {
          const ctx = document.getElementById(canvasId).getContext("2d");
          new Chart(ctx, {
            type: "line",
            data: {
              labels: labels,
              datasets: [
                {
                  label: label,
                  fill: true,
                  data: data,
                  borderColor: borderColor,
                  backgroundColor: backgroundColor,
                  borderWidth: 1,
                },
              ],
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true,
                },
              },
            },
          });
        }
        // Panggil fetchAndRenderData saat halaman pertama kali dimuat
        fetchAndRenderData();
      });
    </script>
  </body>
</html>
