<?php 

require '../functions/functions.php';
session_start();
$sadmin = $_SESSION['akses'];
if(!($sadmin=="admin")){
    header("location:../login.php");
  }

?>


<!DOCTYPE html>
<html>
<head>
  <title>GRAFIK SAMPAH</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include '../dist/link.php'; ?>
    <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" type="text/css" href="../plugins/toastr/toastr.min.css">
  <link rel="stylesheet" type="text/css" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" /> -->

<script src="../plugins/chart.js/Chart.bundle.js"></script>
  

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<!-- Site wrapper -->
<div class="wrapper">

  <?php include '../dist/header.php'; ?>


  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="../dist/img/sampah.png"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">SIBASAH</span>
    </a>
    <?php include '../dist/sidebarAdmin.php'; ?>
  </aside>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><strong>Grafik Sampah</strong></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Data Transaksi</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <!-- Main content dalam table-->
   <section class="content ">
      <div class="row ">
        <div class="col-12">
          <div class="card card-secondary card-outline">
           <!--  <div class="card-header">
              <h3 class="card-title">
                  <i class="nav-icon fas fa-chart-bar"></i>
                  Grafik Berat Sampah 
                </h3>
              
            </div> -->
            <div class="card-body" >
                <div id="container">
                  <form method="POST" action=""> 
                  <div class="form-group row">
                      <label class="col-form-label mr-2 ">Dari</label>
                      <input type="date" name="tanggal_awal" class="form-control col-sm-2 mr-2 bg-secondary" value="<?php echo date('Y-m-d') ?>">
                      <label class="col-form-label mr-2">-</label>
                      <input type="date" name="tanggal_akhir" class="form-control col-sm-2 mr-2 bg-secondary" value="<?php echo date('Y-m-d') ?>" >
                     
                      
                      <button class="btn bg-secondary" type="submit" name="cari">Lihat</button>
                  </div>
                  <hr>
                </form>

                <?php 
                    $no = 1;
                    if(isset($_POST["cari"])){
                      $tgl1 = $_POST["tanggal_awal"];
                      $tgl2 = $_POST["tanggal_akhir"];
                      $laporan_total_sampah = query("
                          SELECT tb_sampah.nama_sampah as sampah, SUM(tb_detail_transaksi.berat_sampah) as jumlah FROM tb_sampah
                          INNER JOIN tb_detail_transaksi
                          ON tb_sampah.id = tb_detail_transaksi.id_sampah
                           INNER JOIN tb_transaksi
                          ON tb_detail_transaksi.id_transaksi = tb_transaksi.id_transaksi
                          where tb_sampah.id <> '' AND tb_transaksi.tanggal_transaksi 
                          BETWEEN  '".$tgl1."' and '".$tgl2."'                          
                          GROUP by tb_sampah.nama_sampah

                      ");
                       $laporan_sampah = query("SELECT tb_transaksi.tanggal_transaksi as tanggal, nama_sampah as sampah , tb_detail_transaksi.berat_sampah as Berat FROM tb_detail_transaksi
                              INNER JOIN tb_transaksi 
                              ON tb_detail_transaksi.id_transaksi = tb_transaksi.id_transaksi
                              INNER JOIN tb_sampah
                              ON tb_detail_transaksi.id_sampah = tb_sampah.id
                              WHERE id_sampah <> '' and tb_transaksi.tanggal_transaksi 
                              BETWEEN '".$tgl1."' and '".$tgl2."'
                              ");
                       $totalBeratSampah = totalBeratSampah($tgl1,$tgl1);
                       $labelTanggal = bulanTanggal($tgl1).' - '.bulanTanggal($tgl2);
                    }else{
                      $laporan_total_sampah = query("
                          SELECT tb_sampah.nama_sampah as sampah, SUM(tb_detail_transaksi.berat_sampah) as jumlah FROM tb_sampah
                          INNER JOIN tb_detail_transaksi
                          ON tb_sampah.id = tb_detail_transaksi.id_sampah
                           INNER JOIN tb_transaksi
                          ON tb_detail_transaksi.id_transaksi = tb_transaksi.id_transaksi
                          where tb_sampah.id <> ''
                          GROUP by tb_sampah.nama_sampah
                          ");
                       $laporan_sampah = query("SELECT tb_transaksi.tanggal_transaksi as tanggal, nama_sampah as sampah , tb_detail_transaksi.berat_sampah as Berat FROM tb_detail_transaksi
                              INNER JOIN tb_transaksi 
                              ON tb_detail_transaksi.id_transaksi = tb_transaksi.id_transaksi
                              INNER JOIN tb_sampah
                              ON tb_detail_transaksi.id_sampah = tb_sampah.id
                              WHERE id_sampah <> '' 
                             
                              ");
                        $totalBeratSampah = totalBeratSampah('2019-10-20','2019-10-20');
                        $labelTanggal = "";
                        $jumlahBerat = "200Kg";
                      
                    }?>   

            <!--  <?php 
                    $no = 1;
                    if(isset($_GET["cari"])){
                      $tgl1 = $_GET["bulan"];
                      $query = query("
                          SELECT tb_sampah.nama_sampah as sampah, SUM(tb_detail_transaksi.berat_sampah) as jumlah
                          FROM tb_sampah
                          INNER JOIN tb_detail_transaksi
                          ON tb_sampah.id = tb_detail_transaksi.id_sampah
                          INNER JOIN tb_transaksi
                          ON tb_detail_transaksi.id_transaksi = tb_transaksi.id_transaksi
                          where tb_sampah.id <> '' and 
                          month(tanggal_transaksi) = '$tgl1'
                          GROUP by tb_sampah.nama_sampah
                      ");

                    }else{
                      $query = query("
                          SELECT  tb_sampah.nama_sampah as sampah, SUM(tb_detail_transaksi.berat_sampah) as jumlah
                          FROM tb_sampah
                          INNER JOIN tb_detail_transaksi
                          ON tb_sampah.id = tb_detail_transaksi.id_sampah
                          INNER JOIN tb_transaksi
                          ON tb_detail_transaksi.id_transaksi = tb_transaksi.id_transaksi
                          INNER JOIN tb_kategori
                          ON tb_sampah.id_kategori = tb_kategori.id_kategori
                          where tb_sampah.id <> '' and 
                          year(tanggal_transaksi) = year(now())
                          GROUP by tb_sampah.nama_sampah
                          ");
                    }?>   -->
                    <?php 
                    $bulan = bulanBelakang();
                    $query2 = query("
                          SELECT  tb_sampah.nama_sampah as sampah, SUM(tb_detail_transaksi.berat_sampah) as jumlah
                          FROM tb_sampah
                          INNER JOIN tb_detail_transaksi
                          ON tb_sampah.id = tb_detail_transaksi.id_sampah
                          INNER JOIN tb_transaksi
                          ON tb_detail_transaksi.id_transaksi = tb_transaksi.id_transaksi
                          INNER JOIN tb_kategori
                          ON tb_sampah.id_kategori = tb_kategori.id_kategori
                          where tb_sampah.id <> '' and 
                          month(tanggal_transaksi) = '$bulan'
                          GROUP by tb_sampah.nama_sampah
                          "); ?>
                   <div class="form-group row ">
                    <div class=" col-md-12 text-center">

                      <label for="laporan_sampah" class="text-center"><h4>Laporan Sampah <?=  $labelTanggal?></h4></label>
                      <table id="laporan_sampah" class="table table-bordered  table-hover table-sm  ">
                        <thead>
                          <tr class="table-active text-center">
                            <th>Tanggal</th>
                            <th >Jenis Sampah</th>
                            <th > Berat Sampah</th>
                          </tr>
                        </thead>
                        <tbody>
                         
                          <?php $i = 1; ?>
                          <?php foreach( $laporan_sampah as $row ) : ?>
                          <tr>
                            <td><?= $row["tanggal"] ?></td>
                            <td class="text-left"><?= $row["sampah"]; ?></td>
                           
                            <td class="text-right" ><?php echo $row["Berat"];?> Kg</td>
                          </tr>
                              <?php $i++; ?>
                               <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="2" class="table-active"><strong>Total Berat Sampah</strong></td>
                            <td class="text-right "  ><strong>200 Kg</strong></td>
                          </tr>
                          
                        </tfoot>
                      </table>
                   </div>
                    <div class=" col-md-4 text-center">
                      <label for="laporan_total_sampah"><h4>Total Berat Sampah</h4></label>
                      <table id="laporan_total_sampah" class="table table-bordered  table-hover table-sm  ">
                        <thead>
                          <tr class="table-active text-center">
                            <th >Sampah</th>
                            <th >Total Kg</th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php $i = 1; ?>
                          <?php foreach( $laporan_total_sampah as $row ) : ?>
                          <tr>
                            <td class="text-left"><?= $row["sampah"]; ?></td>
                           
                            <td class="text-right" ><?php echo $row["jumlah"] ?> Kg</td>
                          </tr>
                              <?php $i++; ?>
                               <?php endforeach; ?>
                          <tr>
                            <td>Total</td>
                            <td class="text-right bg-primary"><?php echo $totalBeratSampah ?> Kg</td>
                          </tr>
                        </tbody>
                      </table>
                   </div>
                 </div>
                  <div class="form-group row ">
                    <div class=" col-md-8">
                      <div class="card ">
                        <div class="card-header " style=" background-color: #E5E5E5">
                          <h3 class="card-title">Grafik Berat Sampah</h3>
                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                          </div>
                        </div>
                        <div class="card-body" style=" background-color: #F1F1F1">
                          <div class="chart">
                            <canvas id="sampah" style="height:50px; min-height:50"></canvas>
                          </div>
                        </div>
                      </div>
                    </div>
                    </div>


                </div>
            </div>
          </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

  </div>
  <?php include '../dist/footer.php'; ?>
</div>
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script>
<script src="../dist/js/demo.js"></script>
<script src="../plugins/datatables/jquery.dataTables.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script type="text/javascript" src="../plugins/sw2.js"></script>
<script type="text/javascript" src="../plugins/toastr/toastr.min.js"></script>
<script src="../plugins/select2/js/select2.full.min.js"></script>



<script>
 

  var ctx = document.getElementById("sampah");
   // var kategori = document.getElementById("kategori_sampah");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                            <?php 
                                foreach ($laporan_total_sampah as $a) {
                                  echo '"'.$a['sampah'].'",';
                                }
                           ?>
                    ],
                    datasets: [{
                            label: [
                            '<?php echo $labelTanggal; ?>'
          ] ,
                            data: [
                            <?php 
                                foreach ($laporan_total_sampah as $a) {
                                  echo '"'.$a['jumlah'].'",';
                                }


                           ?>
                            ],
                            backgroundColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                '#61D92A',
                                '#FF9723',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderColor:  [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                '#61D92A',
                                '#FF9723',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 2
                        }]
                },
                options: {
                    scales: {
                        yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                    }
                }
            });

            // var myChart = new Chart(kategori, {
            //     type: 'bar',
            //     data: {
            //         labels: [
            //                 <?php 
            //                     foreach ($query as $a) {
            //                       echo '"'.$a['sampah'].'",';
            //                     }
            //                ?>
            //         ],
            //         datasets: [{
            //                 label: "Berat ", 
            //                 data: [
            //                 <?php 
            //                     foreach ($query as $a) {
            //                       echo '"'.$a['jumlah'].'",';
            //                     }
            //                ?>
            //                 ],
            //                 backgroundColor: [
            //                     'rgba(255, 99, 132, 0.2)',
            //                     'rgba(54, 162, 235, 0.2)',
            //                     'rgba(255, 206, 86, 0.2)',
            //                     'rgba(75, 192, 192, 0.2)',
            //                     'rgba(153, 102, 255, 0.2)',
            //                     'rgba(75, 192, 192, 0.2)',
            //                     'rgba(153, 102, 255, 0.2)',
            //                     'rgba(255, 159, 64, 0.2)'
            //                 ],
            //                 borderColor: [
            //                     'rgba(255,99,132,1)',
            //                     'rgba(54, 162, 235, 1)',
            //                     'rgba(255, 206, 86, 1)',
            //                     'rgba(75, 192, 192, 1)',
            //                     'rgba(153, 102, 255, 1)',
            //                     'rgba(75, 192, 192, 1)',
            //                     'rgba(153, 102, 255, 1)',
            //                     'rgba(255, 159, 64, 1)'
            //                 ],
            //                 borderWidth: 2
            //             }]
            //     },
            //     options: {
            //         scales: {
            //             yAxes: [{
            //                     ticks: {
            //                         beginAtZero: true
            //                     }
            //                 }]
            //         }
            //     }
            // });

    $(function () {
    $("#laporan_sampah").DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": false,
      "autoWidth": true

    });
    $("#laporan_total_sampah").DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": false,
      "autoWidth": true

    });
  });



 var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = {
      labels: [
          'Chrome', 
          'IE',
          'FireFox'
      ],
      datasets: [
        {
          data: [
          700,500,400
          ],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var pieOptions     = {
      legend: {
        display: false
      }
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'doughnut',
      data: pieData,
      options: pieOptions      
    })

</script>
</body>

</html>

