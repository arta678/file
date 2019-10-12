<?php 

session_start();
$sadmin = $_SESSION['akses'];
if(!($sadmin=="admin")){
    header("location:../login.php");
  }
require '../functions/functions.php';
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
  <title>TRANSAKSI</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include '../dist/link.php'; ?>
    <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" type="text/css" href="../plugins/toastr/toastr.min.css">
  <link rel="stylesheet" type="text/css" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<link rel="stylesheet" type="text/css" href="../dist/css/select2.css">
<link rel="stylesheet" type="text/css" href="../dist/css/select2-bootstrap.css">
  

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
            <h1>Transaksi Setoran Sampah</h1>
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
            </div>
            <div class="card-body">
                <form method="post">
                <div id="container">
                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-1 col-form-label">Nasabah</label>
                    <div class="col-sm-4">
                      <select class="form-control" name="id_nasabah" required id="id_nasabah">
                      <option disabled selected>Pilih Nasabah</option>
                      <?php $input = "SELECT * FROM tb_nasabah where status = 'Aktif'";
                      $hasil = mysqli_query($conn, $input);
                      while ( $baris = mysqli_fetch_array($hasil) ) { ?>
                        <option value="<?php echo $baris['id'] ?>"><?php echo $baris['nama']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword" class="col-sm-1 col-form-label">Sampah</label>
                    <div class="col-sm-4">
                        <select class="form-control "  name="id_sampah[]" required id="select_sampah">
                          <option disabled selected>Pilih Sampah</option>
                          <?php $input = "SELECT * FROM tb_sampah where id <> ''";?>
                          <?php $hasil = mysqli_query($conn, $input);?>
                          <?php while ( $baris = mysqli_fetch_array($hasil) ) { ?>
                            <option value="<?= $baris['id'] ?>" data-harga="<?=  $baris["harga_sampah"]; ?>"><?= $baris['nama_sampah'] ."    (Rp.". $baris["harga_sampah"]; ?>) </option>
                          <?php } ?>
                        </select>
                    </div>
                    <label for="berat" class="col-sm-1 col-form-label">Berat</label>
                    <input type="text" name="kg[]" class="col-sm-1 form-control" required placeholder="kg" id="berat">
                    &nbsp;
                    &nbsp;
                    <button type="button" data-toggle="tooltip" data-placement="botton" title="Tooltip on top" class="btn btn-info col-sm-1 form-control" id="add" ><i class="fas fa-plus"></i></button>
              
                  </div>
                </div>
                <button type="submit" class="btn btn-success" name="submit_tambah"><i class="fas fa-save mr-2"></i>Simpan</button>
              </form>
            



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
 <?php
      if( isset($_POST["submit_tambah"]) ) {
        if( tambahSetoran($_POST) > 0 ) {
         echo '<script>
                toastr.options.timeOut= 7000;
                toastr["success"]("Melakukan Setoran Sampah!", "Success");
            </script>';
        } else {
          gagalTambah();
        }
      }
?>

<script>
  var i = 1;
  $(document).ready(function(e){

      var html = '<p /><div>Make : <input type="text" name="make[]"> MOdel: <input type="text" name="model[]">Serial: <input type="text" name="serial[]"><button type="button" class="btn btn-danger" id="remove"><i class="fas fa-plus "></i></button></div>';
      var html2 = '<div><div class="form-group"><div class="row"> </div><div class="row">Sampah : <input type="text" name="sampah[]" class="col-sm-4 form-group">Kg: <input type="text" name="kg[]" class="col-sm-1 form-group"><button type="button" class="btn btn-danger col-sm-1 form-group" id="remove" >-</button></div></div></div>';
      var html3 = '<div><div class="form-group"><div class="row"> </div><div class="row">Sampah : <select class="form-control col-md-4" style="width: 100%;" name="id_sampah[]" required><option disabled >Pilih Jenis Kategori</option><?php $input = "SELECT * FROM tb_sampah ";?><?php $hasil = mysqli_query($conn, $input);?><?php while ( $baris = mysqli_fetch_array($hasil) ) { ?><option value="<?= $baris['id'] ?>" data-harga="<?=  $baris["harga_sampah"]; ?>"><?= $baris['nama_sampah'] ;  ?></option><?php } ?></select>harga: <input type="text" name="harga[]" class="col-sm-1 form-group" id="harga1" readonly> Kg: <input type="text" name="kg[]" class="col-sm-1 form-group"><button type="button" class="btn btn-danger col-sm-1 form-group" id="remove" >-</button></div></div></div>';
      var html4 ='<div class="form-group row"><label for="inputPassword" class="col-sm-1 col-form-label">Sampah</label><div class="col-sm-4"><select class="form-control "  name="id_sampah[]" required id="select_sampah['+i+']"><option disabled selected>Pilih Sampah</option><?php $input = "SELECT * FROM tb_sampah where id <> ''";?><?php $hasil = mysqli_query($conn, $input);?><?php while ( $baris = mysqli_fetch_array($hasil) ) { ?><option value="<?= $baris['id'] ?>" data-harga="<?=  $baris["harga_sampah"]; ?>"><?= $baris['nama_sampah'] ."    (Rp.". $baris["harga_sampah"]; ?>) </option><?php } ?></select></div><label for="berat" class="col-sm-1 col-form-label">Berat</label><input type="text" name="kg[]" class="col-sm-1 form-control" required placeholder="kg" id="berat">&nbsp; &nbsp;<button type="button" class="btn btn-danger col-sm-1 form-control" id="remove" >-</button></div>';
        i++;

      $("#add").click(function(e){
        $('#container').append(html4);
      })

      $('#container').on('click','#remove',function(e){
        $(this).parent('div').remove();
      })
    });

    $('#select_sampah').on('change', function() {
          var selectedOption = $(this).find('option:selected');
          $('#harga').val(selectedOption[0].dataset.harga);
          $('#harga1').val(selectedOption[0].dataset.harga);
    });

    $(document).ready(function() {
    $('#id_nasabah').select2({
      theme: "bootstrap"
    });
    $('#select_sampah').select2({
      theme: "bootstrap"
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
    $("#berat").inputFilter(function(value) {
      return /^-?\d*[.]?\d*$/.test(value); });
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

