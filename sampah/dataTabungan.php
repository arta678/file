<?php 
session_start();
$sadmin = $_SESSION['akses'];
if(!($sadmin=="admin")){
    header("location:../login.php");
  }
require '../functions/functions.php';
$nasabah = query("
  SELECT * FROM tb_rekening r
  INNER JOIN tb_nasabah n
  ON r.id_nasabah = n.id
  "
);
  
?>
<!DOCTYPE html>
<html>
<head>
  <title>TABUNGAN NASABAH</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include '../dist/link.php'; ?>
  <link rel="stylesheet" type="text/css" href="../plugins/toastr/toastr.min.css">

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
  <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Tabungan Nasabah</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
              <li class="breadcrumb-item active">Data Nasabah</li>
            </ol>
          </div>
        </div>
      </div>
    </section>


    <!-- Main content dalam table-->
    <section class="content ">
      <div class="row ">
        <div class="col-12">
          <div class="card ">
            <!-- /.card-header -->
          
            <div class="card-body">
              <table id="tabel_nasabah" class="table table-bordered  table-hover table-sm table-responsive-sm">
                <thead >
                <tr class="table-active">
                  <th style="width: 50px;"  class="text-center">No</th>
                  <th   class="text-center">Nasabah</th>
                  <th style="width: 250px;" class="text-center">Saldo</th>
                  <th  class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody >
                  <?php $i = 1; ?>
                  <?php foreach( $nasabah as $row ) : ?>
                  <tr >
                    <?php 
                      $setoran = getTotalSetoran($row["id_nasabah"]);
                      $penarikan = getTotalPenarikan($row["id_nasabah"]);
                      $saldo_akhir = $setoran - $penarikan;
                     ?>
                    <td class="text-center"><?= $i ?></td>
                    <td ><?= $row["nama"]; ?></td>
                    <td>Rp.  <?= number_format($saldo_akhir,0,',','.'); ?></td>
                    <td class="text-center">
                      <form method="post" action="dataDetailTabungan.php">
                        <a >
                          <button class="btn btn-info btn-sm" name="id_nasabah" value="<?= $row["id_nasabah"]?>">
                            <!-- <i class="nav-icon fas fa-edit"></i> -->
                            Tabungan
                          </button>
                      </a>
                      </form>
                      
                    </td>
                  </tr>
                      <?php $i++; ?>


                     
                  <?php endforeach; ?>
                </tbody>
              </table>
              <!-- </form> -->
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
<script type="text/javascript" src="../dist/main.js"></script>

<!-- TAMBAH NASABAH -->
 <?php
      if( isset($_POST["submit_tambah"]) ) {
        if( tambahNasabah($_POST) > 0 ) {
          echo '
              <script>
                  toastr.options.onHidden = function() { window.location.href = "dataNasabah.php" }
                  toastr.options.timeOut = 4000;
                  toastr.options.timeOut= 1000;
                  toastr["success"]("Berhasil Menambahkan Data!", "Success");
              </script>
            ';
        } else {
          echo '
              <script>
                      toastr.options.onHidden = function() { window.location.href = "dataNasabah.php" }
                    toastr.options.timeOut = 4000;
                      toastr.options.timeOut= 4000;
                      toastr["error"]("Gagal Menambahkan Data!", "Error");
               </script>
            ';
        }

      
      }
?>

<?php
      if( isset($_POST["submit_edit"]) ) {
        if( ubahNasabah($_POST) > 0 ) {
          echo '
            <script>
                toastr.options.onHidden = function() {window.location.href = "dataNasabah.php"}
                toastr.options.timeOut = 4000;
                toastr.options.timeOut= 1000;
                toastr["success"]("Berhasil Mengedit Data!", "Success");
            </script>
          ';
        } else {
         echo "
            <script>
                    toastr.options.onHidden = function() { window.location.href = 'dataNasabah.php' }
                  toastr.options.timeOut = 4000;
                    toastr.options.timeOut= 1000;
                    toastr['error']('Gagal Mengedit Data!', 'Error');
                </script>
          ";
        }
      }
?>

<?php 
      if( isset($_POST["submit_hapus"]) ) {
        if( hapusNasabah($id) > 0 ) {
          echo '
          <script>
                toastr.options.onHidden = function() { window.location.href = "dataNasabah.php" }
                toastr.options.timeOut = 4000;
                toastr.options.timeOut= 1000;
                toastr["success"]("Berhasil Mengahapus Data!", "Success");
            </script>
          ';
        } else {
          echo '
            <script>
                    toastr.options.onHidden = function() { window.location.href = "dataNasabah.php" }
                    toastr.options.timeOut = 4000;
                    toastr.options.timeOut= 1000;
                    toastr["error"]("Gagal Mengahapus Data!", "Error");
                </script>
          ';
        }
      }
 ?>
<script type="text/javascript">
    
    $('#modal-default').on('shown.bs.modal', function() {
      $('#nama').focus();
    })
  // INPUT TYPE 
    (function($) {
      $.fn.inputFilter = function(inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
          if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
          } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
          }
        });
      };
    }(jQuery));



    // Install input filters.
    $("#uintTextBox").inputFilter(function(value) {
      return /^\d*$/.test(value); });
    $("#input_edit").inputFilter(function(value) {
      return /^\d*$/.test(value); });
    $("#intLimitTextBox").inputFilter(function(value) {
      return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 500); });
    $("#intTextBox").inputFilter(function(value) {
      return /^-?\d*$/.test(value); });
    $("#floatTextBox").inputFilter(function(value) {
      return /^-?\d*[.,]?\d*$/.test(value); });
    $("#currencyTextBox").inputFilter(function(value) {
      return /^-?\d*[.,]?\d{0,2}$/.test(value); });
    $("#basicLatinTextBox").inputFilter(function(value) {
      return /^[a-z]*$/i.test(value); });
    $("#extendedLatinTextBox").inputFilter(function(value) {
      return /^[a-z\u00c0-\u024f]*$/i.test(value); });
    $("#hexTextBox").inputFilter(function(value) {
      return /^[0-9a-f]*$/i.test(value); });




</script>

</body>

</html>

