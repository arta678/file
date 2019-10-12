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
            <h1>Transaksi</h1>
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
              <a href="addSetoran.php"><button type="button" class="btn btn-success" ><i class="fas fa-plus mr-2"></i>Setoran</button></a>
              <a href="addPenarikan.php"><button type="button" class="btn btn-success" ><i class="fas fa-plus mr-2"></i>Penarikan</button></a>
              
              <button type="button" title="Refresh" class="btn btn-light" onclick='window.location.reload();'><i class="fas  fa-sync"></i></button></a>
            </div>
            <div class="card-body">
              <table id="tabel_transaksi" class="table table-bordered  table-hover table-sm ">
                <thead >
                <tr class="table-active text-center">
                  <th >Tanggal</th>
                  <th >Kode Transaksi</th>
                  <th >Nama</th>
                  <th >Jenis Transaksi</th>
                  <th > Setoran</th>
                  <th > Penarikan</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody >
                  <?php $i = 1; ?>
                  <?php foreach( $nasabah as $row ) : ?>
                  <tr>
                    <td><?= $row["tanggal_transaksi"];?></td>
                    <td><?= $row["id_transaksi"];?></td>
                    <td><?= $row["nama"]; ?></td>
                    <td><?= $row["tipe_transaksi"]; ?></td>
                   
                    <td class="text-left" >Rp.<?= number_format($row["total_setoran"],0,',','.'); ?></td>
                    <td class="text-left" >Rp.<?= number_format($row["total_penarikan"],0,',','.'); ?></td>

                    <?php if ($row["tipe_transaksi"]=="Setoran") {?>
                      <td class="text-center">
                       <form action="dataDetailSetoran.php" method="GET">
                         <input type="hidden" name="id_transaksi" value="<?= $row["id_transaksi"] ?>">
                         <button type="submit" class="btn btn-info btn-sm">Detail</button>
                       </form>
                      </td>
                    <?php }else{?>
                      <td class="text-center">
                       <form action="dataDetailPenarikan.php" method="GET">
                         <input type="hidden" name="id_transaksi" value="<?= $row["id_transaksi"] ?>">
                         <button type="submit" class="btn btn-info btn-sm">Detail</button>
                       </form>
                      </td>
                   <?php } ?>
                    
                  </tr>
                      <?php $i++; ?>
<span style="color: #006FFF #006FFF  #006FFF #006FFF "></span>   
<span style="color: #006FFF #006FFF  #006FFF #006FFF "></span>                        
<!-- MODAL TAMBAH -->
<div class="modal " id="modal-default" >
  <div class="modal-dialog ">
    <div class="modal-content">
       <form  action="" method="post">
          <div class="modal-header bg-info">
            <h4 class="modal-title">Tambah Setoran Sampah</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="card-body">
            <div class="form-group">
            <div class="row">
              <div class="col-md-3"><label for="">Nasabah</label></div>
             <!--  <input type="text" class="form-control col-md-6" id="" placeholder="Nama" name="id_rekening" required maxlength = "49" > -->
           <select class="form-control col-md-8" style="width: 100%;" name="id_nasabah" required>
                    <option disabled >Pilih Jenis Kategori</option>

                    <?php 
                    $input = "SELECT * FROM tb_nasabah where status = 'Aktif'";
                    $hasil = mysqli_query($conn, $input);
                    while ( $baris = mysqli_fetch_array($hasil) ) { ?>
                      <option value="<?php echo $baris['id'] ?>"><?php echo $baris['nama']; ?></option>
                      <?php 
                    }
                   ?>
                  </select>
            </div>
            </div>
        <div id="kotak">
           <div class="form-group" >
              <div class="row">
                <div class="col-md-3"><label for="">Sampah</label></div>
                  <select class="form-control col-md-4" style="width: 100%;" name="id_sampah[]" required>
                      <option disabled >Pilih Jenis Kategori</option>
                      <?php $input = "SELECT * FROM tb_sampah ";?>
                      <?php $hasil = mysqli_query($conn, $input);?>
                      <?php while ( $baris = mysqli_fetch_array($hasil) ) { ?>
                        <option value="<?= $baris['id'] ?>"><?= $baris['nama_sampah'] ;  ?></option>
                      <?php } ?>
                    </select>
                <div class="col-md-1" ><label  >Kg </label></div>
                <input type="text" class="form-control col-md-2" name="kg[]" required maxlength = "49" >
                
                <button type="button" id="addRow" class=" btn btn-info col-md-1" > + </button>
          
              </div>
            </div>
        </div>    
        <!-- <div class="form-group" >
              <div class="row">
                <div class="col-md-3"><label for="">Sampah</label></div>
                  <select class="form-control col-md-4" style="width: 100%;" name="id_sampah[]" required>
                      <option disabled >Pilih Jenis Kategori</option>
                      <?php $input = "SELECT * FROM tb_sampah ";?>
                      <?php $hasil = mysqli_query($conn, $input);?>
                      <?php while ( $baris = mysqli_fetch_array($hasil) ) { ?>
                        <option value="<?= $baris['id'] ?>"><?= $baris['nama_sampah'] ;  ?></option>
                      <?php } ?>
                    </select>
                <div class="col-md-1" ><label  >Kg </label></div>
                <input type="text" class="form-control col-md-2" name="kg[]" required maxlength = "49" >
                
                <button type="button" id="addRow" class=" btn btn-info col-md-1" > + </button>
          
              </div>
            </div>  -->
            <div id="last"></div>

            


          </div>  
          <div class="modal-footer justify-content-between">
              <input type="reset" value="Hapus" class="btn btn-default">
              <button type="submit" name="submit_tambah" class="btn btn-info">Tambah Data!</button>
          </div>
      </form>
    </div>
  </div>
</div>


<span style="color: #DFFFFE #DFFFFE  #DFFFFE #DFFFFE "></span> 
<span style="color: #DFFFFE #DFFFFE  #DFFFFE #DFFFFE "></span> 
<!-- modaldetail -->
<div class="modal " id="modal_detail_<?php echo $row['id']; ?>" >
    <div class="modal-dialog ">
      <div class="modal-content">
         <form  action="" method="post">
            <div class="modal-header bg-info ">
              <h4 class="modal-title">DETAIL TRANSAKSI </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
              <div class="form-group">    
              <div class="row">
                <input type="hidden" name="id_transaksi" value="<?= $row["id_transaksi"] ?>">
              </div>
            </div>
            </div>
            <div class="modal-footer justify-content-between">
          
           <button type="button" class="btn " data-dismiss="modal">Close</button>
      </div>
        </form>
      </div>
    </div>
</div>

                     
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
            '<div class="row" id="tes">'+
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
    $('#kotak').on('click','#del',function(e){
      $(this).parent('<button').remove();
    })
    

    $(function () {
    $("#tabel_transaksi").DataTable({
      "paging": true,
      "lengthChange": true,
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

