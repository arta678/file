<?php 

session_start();
$sadmin = $_SESSION['akses'];
if(!($sadmin=="admin")){
    header("location:../login.php");
  }
require '../functions/functions.php';

$id_transaksi = $_GET["id_transaksi"];
$transaksi = "
  SELECT * FROM tb_transaksi dt
  INNER JOIN tb_nasabah 
  ON dt.id_nasabah = tb_nasabah.id
  where id_transaksi ='".$id_transaksi."'
  ";
 $total = "select sum(total_transaksi) as tot from tb_detail_transaksi
  where id_transaksi ='".$id_transaksi."'";
$detail_transaksi = query("
  SELECT * FROM tb_detail_transaksi dt
  INNER JOIN tb_sampah
  ON dt.id_sampah = tb_sampah.id
  INNER JOIN tb_transaksi 
  ON dt.id_transaksi = tb_transaksi.id_transaksi
  where dt.id_transaksi ='".$id_transaksi."'
  ");

  

?>

<!DOCTYPE html>
<html>
<head>
  <title>DETAIL TRANSAKSI</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include '../dist/link.php'; ?>
    <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" type="text/css" href="../plugins/toastr/toastr.min.css">
  <link rel="stylesheet" type="text/css" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  

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
            <h1>Detail Transaksi</h1>
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
          <div class="card ">
            <!-- /.card-header -->
            <div class="card-header">
              <a href="dataTransaksi.php"><button type="button" class="btn btn-info" ><i class="fas fa-angle-left mr-2"></i>Kembali</button></a>
              <a href="cetak.php" target="_blank"><button type="button" title="Cetak Data Nasabah" class="btn btn-warning" ><i class="fas fa-print mr-2"  ></i>Cetak</button></a>
              <button type="button" title="Refresh" class="btn btn-light" onclick='window.location.reload();'><i class="fas  fa-sync"></i></button></a>
            </div>
            <div class="card-body">
              <div class="form-group">
                <div class="row">
                  <p class="col-md-2">ID Transaksi </p>
                  <p>:</p>
                  <p class="col-md-8"><?php echo $id_transaksi ?></p>
                </div>
                <div class="row">
                  <p class="col-md-2">Tanggal </p>
                  <p>:</p>
                  <?php $hasil = mysqli_query($conn,$transaksi); 
                        while ( $tol = mysqli_fetch_assoc($hasil)) { ?>
                          <p class="col-md-8"><?= $tol["tanggal_transaksi"] ?></p>
                  
                  
                  
                  
                  
                  
                </div>
                <div class="row">
                  <p class="col-md-2">Nasabah </p>
                  <p>:</p>
                  <p class="col-md-8"><?php echo $tol["nama"]; ?></p>
                </div>
              </div>
              <?php  }?>
              
              <table id="tabel_transaksi" class="table table-bordered  table-sm  col-sm-8">
                <thead >
                <tr class="text-center">
                  <th >Jenis Sampah</th>
                  <th>Harga Sampah</th>
                  <th >Berat</th>
                  <th >Total Jumlah</th>
                </tr>
                </thead>
                <tbody >
                  <?php $i = 1; ?>
                  <?php foreach( $detail_transaksi as $row ) : ?>
                  <tr>
                    <td><?= $row["nama_sampah"];?></td>
                    <td class="text-right">Rp. <?= $row["harga_sampah"];?></td>
                    <td class="text-right"><?= $row["berat_sampah"]; ?> Kg</td>
                    <td class="text-right">Rp. <?= $row["total_transaksi"]; ?></td>
                  </tr>
                      <?php $i++; ?>

                     
                  <?php endforeach; ?>
                </tbody>
                <tbody>
                  <td colspan="3" class="text-center " >Total </td>
                  <?php $hasil = mysqli_query($conn,$total); ?>
                  <?php while ($total = mysqli_fetch_assoc($hasil)) {?>
                    <td class="bg-secondary text-right" >Rp. <?php echo $total["tot"];  ?></td>
                  <?php } ?>
                  
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
<script src="../plugins/select2/js/select2.full.min.js"></script>


<!-- TAMBAH NASABAH -->
 <?php
      if( isset($_POST["submit_tambah"]) ) {
        if( tambahSetoran($_POST) > 0 ) {
         echo '<script>
                toastr.options.onHidden = function() { window.location.href = "dataTransaksi.php" }
                toastr.options.timeOut = 4000;
                toastr.options.timeOut= 1000;
                toastr["success"]("Berhasil Menambahkan Data!", "Success");
            </script>';
        } else {
          gagalTambah();
        }
      }
?>

<script>
    var i = 1;
  
$(function(){
    $("#addRow").click(function(){
    row = '<div class="form-group" >'+
            '<div class="row">'+
              '<div class="col-md-3"><label for="">Sampah</label></div>'+
              '<select class="form-control col-md-4" style="width: 100%;" name="id_sampah[]" required>'+
                      '<option disabled >Pilih Jenis Kategori</option>'+
                      '<?php $input = "SELECT * FROM tb_sampah ";?>'+
                      '<?php $hasil = mysqli_query($conn, $input);?>'+
                      '<?php while ( $baris = mysqli_fetch_array($hasil) ) { ?>'+
                        '<option value="<?= $baris['id'] ?>"><?= $baris['nama_sampah'] ;  ?></option>'+
                      '<?php } ?>'+
                   '</select>'+
              '<div class="col-md-1"><label for="">Kg </label></div>'+
              '<input type="text" class="form-control col-md-2"  name="kg[]" required maxlength = "49" >'+
              '<button type="button" id="del" class="form-control btn btn-danger col-md-1" > - </button>'+
            '</div>'+
          '</div>';
        $(row).insertBefore("#last");
        i++;
        });
    });
    $("#del").live('click', function(){
        $(this).parent().parent().remove();
        });


    $(function () {
    $("#tabel_transaksi").DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": false,
      "autoWidth": true

    });
  });

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

