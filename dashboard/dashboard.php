<?php 

require '../functions/functions.php';
session_start();
$sadmin = $_SESSION['akses'];
if(!($sadmin=="admin")){
    header("location:../login.php");
  }


$nasabah = query("
  SELECT * FROM tb_transaksi 
  INNER JOIN tb_nasabah
  ON tb_transaksi.id_nasabah = tb_nasabah.id order by id_transaksi desc
-- //   INNER JOIN tb_sampah
-- //   ON tb_transaksi.id_sampah = tb_sampah.id

  ");

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
            <h1><strong>Dashboard</strong></h1>
          </div>
        </div>
      </div>
    </section>
    <!-- Main content dalam table-->
   <section class="content ">
     <!--  <div class="row ">
        <div class="col-12">
          <div class="card card-info card-outline">
            <div class="card-body" >
                <div id="container">
                  <form method="POST" action=""> 
                  <div class="form-group row">
                      <label class="col-form-label mr-2 ">Dari</label>
                      <input type="date" name="tanggal_awal" class="form-control col-sm-2 mr-2" value="<?php echo date('Y-m-d') ?>">
                      <label class="col-form-label mr-2">Sampai</label>
                      <input type="date" name="tanggal_akhir" class="form-control col-sm-2 mr-2" value="<?php echo date('Y-m-d') ?>" >
                     
                      
                      <button class="btn btn-default" type="submit" name="cari">Lihat</button>
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
                        $labelTanggal = "Bulan Ini";
                      
                    }?>   

    
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
                    <div class=" col-md-8 text-center">

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
          </div>
        </div>
      </div>  -->


      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fas fa-user-friends"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Nasabah</span>
                <span class="info-box-number"><?= jumlahNasabah(); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-success"><i class="fas fa-wine-bottle"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Sampah(Kg)</span>
                <span class="info-box-number"><?= jumlahSampah(); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-warning"><i class="fas fa-wallet"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Setoran</span>
                <span class="info-box-number"><?= rupiah(jumlahSetoran()) ; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-danger"><i class="fas fa-wallet"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Penarikan</span>
                <span class="info-box-number"><?= rupiah(jumlahPenarikan()) ; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <div class="row">
           <div class=" col-md-9">
            <div class="card ">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 lass="card-title">Sampah</h3>
                  <a href="grafik.php">View Report</a>
                </div>
              </div>
              <div class="card-body">
                <!-- <div class="chart">
                  <canvas id="sampah" style="height:50px; min-height:50"></canvas>
                </div> -->
                <div class="position-relative mb-4">
                  <canvas id="sampah" height="100"></canvas>
                </div>


              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="info-box mb-3 bg-warning">
              <span class="info-box-icon"><i class="fas fa-tag"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Inventory</span>
                <span class="info-box-number">5,200</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="far fa-heart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Mentions</span>
                <span class="info-box-number">92,050</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-danger">
              <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Downloads</span>
                <span class="info-box-number">114,381</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-info">
              <span class="info-box-icon"><i class="far fa-comment"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Direct Messages</span>
                <span class="info-box-number">163,921</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            
          </div>
        </div>



        <div class="row">
           <div class=" col-md-9">
            <div class="card ">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 lass="card-title">Setoran/Penarikan</h3>
                  <a href="grafik.php">View Report</a>
                </div>
              </div>
              <div class="card-body">
                <!-- <div class="chart">
                  <canvas id="sampah" style="height:50px; min-height:50"></canvas>
                </div> -->
                <div class="position-relative mb-4">
                  <canvas id="grafikSetoran" height="100"></canvas>
                </div>


              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="info-box mb-3 bg-warning">
              <span class="info-box-icon"><i class="fas fa-tag"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Inventory</span>
                <span class="info-box-number">5,200</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="far fa-heart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Mentions</span>
                <span class="info-box-number">92,050</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-danger">
              <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Downloads</span>
                <span class="info-box-number">114,381</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-info">
              <span class="info-box-icon"><i class="far fa-comment"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Direct Messages</span>
                <span class="info-box-number">163,921</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            
          </div>
        </div>
        <!-- /.row -->

        
        <!-- /.row -->
      </div><!-- /.container-fluid -->


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
  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var ctx = document.getElementById("sampah");
   var setoran = document.getElementById("grafikSetoran");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                    "Januari",
                    "Februari",
                    "Maret",
                    "April",
                    "Mei",
                    "Juni",
                    "Juli",
                    "Agustus",
                    "September",
                    "Oktober",
                    "November",
                    "Desember",

                    ],
                    datasets: [{
                            label: [
                            '<?php echo date('Y'); ?>'
          ] ,
                            data: [
                            <?php 
                                $data =  showDataSampah(date('Y'));
                                for ($i=0; $i <count($data) ; $i++) { 
                                  echo  $data[$i].',';
                                }
                           ?>
                            ],
                            backgroundColor:'rgba(54, 162, 235, 1)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2
                        },{
                            label: [
                            '<?php echo date('Y')-1; ?>'
          ] ,
                            data: [
                            <?php 
                                $data =  showDataSampah(date('Y')-1);
                                for ($i=0; $i <count($data) ; $i++) { 
                                  echo  $data[$i].',';
                                }
                           ?>
                            ],
                            backgroundColor:'#BFBFBF',
                            borderColor: '#BFBFBF',
                            borderWidth: 2
                        }]
                },
                options: {
                    scales: {
                        yAxes: [{
                              gridLines: {
                                display      : true,
                                lineWidth    : '4px',
                                color        : 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                              },
                              ticks    : $.extend({
                                beginAtZero: true,

                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                  if (value >= 1000) {
                                    value /= 1000
                                    value += 'k'
                                  }
                                  return  value + ' Kg'
                                }
                              }, ticksStyle)
                            }],
                              xAxes: [{
                                display  : true,
                                gridLines: {
                                  display: false
                                },
                                ticks    : ticksStyle
                              }]
                    }
                }
            });


            var myChart = new Chart(setoran, {
                type: 'bar',
                data: {
                    labels: [
                    "Januari",
                    "Februari",
                    "Maret",
                    "April",
                    "Mei",
                    "Juni",
                    "Juli",
                    "Agustus",
                    "September",
                    "Oktober",
                    "November",
                    "Desember",

                    ],
                    datasets: [{
                            label: [
                            'Setoran Sampah'
          ] ,
                            data: [
                            <?php 
                                $data =  showDataSetoran(date('Y'));
                                for ($i=0; $i <count($data) ; $i++) { 
                                  echo  $data[$i].',';
                                }
                           ?>
                            ],
                            backgroundColor:'#00BB3F',
                            borderColor: '#00BB3F',
                            borderWidth: 2
                        },{
                            label: [
                            'Penarikan Saldo'
          ] ,
                            data: [
                            <?php 
                                $data =  showDataPenarikan(date('Y'));
                                for ($i=0; $i <count($data) ; $i++) { 
                                  echo  $data[$i].',';
                                }
                           ?>
                            ],
                            backgroundColor:'#FFA790',
                            borderColor: '#FFA790',
                            borderWidth: 2
                        }]
                },
                options: {
                    scales: {
                        yAxes: [{
                              gridLines: {
                                display      : true,
                                lineWidth    : '4px',
                                color        : 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                              },
                              ticks    : $.extend({
                                beginAtZero: true,

                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                  // if (value >= 1000) {
                                  //   value /= 1000
                                  //   value += 'k'
                                  // }
                                  return 'Rp.' + value 
                                }
                              }, ticksStyle)
                            }],
                              xAxes: [{
                                display  : true,
                                gridLines: {
                                  display: false
                                },
                                ticks    : ticksStyle
                              }]
                    }
                }
            });


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

