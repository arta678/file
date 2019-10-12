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
            <h1>Transaksi Penarikan Saldo</h1>
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
                      <?php $input = "select * from tb_rekening 
                      inner join tb_nasabah
                      on tb_rekening.id_nasabah = tb_nasabah.id
                      where status = 'Aktif'";
                      $hasil = mysqli_query($conn, $input);
                      while ( $baris = mysqli_fetch_array($hasil) ) { ?>
                        <?php 
                        $setoran = getTotalSetoran($baris["id_nasabah"]);
                        $penarikan = getTotalPenarikan($baris["id_nasabah"]);
                        $saldo_akhir = $setoran - $penarikan;
                       ?>
                        <option value="<?php echo $baris['id'] ?>" data-saldo="<?=  $saldo_akhir; ?>"><?php echo $baris["nama"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                  </div>
              <!--     <div class="form-group row">
                    <label for="inputPassword" class="col-sm-1 col-form-label">Saldo</label>
                    <div class="col-sm-4">
                      <input type="text" name="saldo" class=" form-control" required placeholder="Rp.0" id="saldo" readonly>
                       
                    </div>
                    
                  </div> -->
                  <!-- <div class="form-group row">
                    <label for="inputPassword" class="col-sm-1 col-form-label">Tarik</label>
                    <div class="col-sm-4">
                      <input type="text" name="penarikan" class=" form-control" required placeholder="Rp." id="inputPenarikan" >
                       
                    </div>
                    
                  </div> -->
                  <div class="form-group row">
                    <label for="inputPassword" class="col-sm-1 col-form-label">Saldo</label>
                    <!-- <label class="sr-only" for="inlineFormInputGroup">sdasdas</label> -->
                    <div class="input-group mb-2 col-sm-4">
                      <div class="input-group-prepend">
                        <div class="input-group-text">Rp.</div>
                      </div>
                      <input type="text" name="saldo" id="saldo" class="form-control" style="font-size: 27px; font-weight: 1000px;" disabled >
                    </div>
                    
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword" class="col-sm-1 col-form-label">Tarik</label>
                    <!-- <label class="sr-only" for="inlineFormInputGroup">sdasdas</label> -->
                    <div class="input-group mb-2 col-sm-4">
                      <div class="input-group-prepend">
                        <div class="input-group-text">Rp.</div>
                      </div>
                      <input type="text" name="penarikan" id="penarikan" class="form-control" style="font-size: 27px; font-weight: 1000px;" >

                    </div>
                    
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
      $id_nasabah = $_POST['id_nasabah'];
      $saldo = getTotalSaldo($id_nasabah);
      $penarikan = $_POST['penarikan'];

      if( isset($_POST["submit_tambah"]) ) {
        if ($saldo<$penarikan) {
          echo '<script>
              alert("Saldo belum cukup ditarik!");
              </script>';
        }else{
           if (tambahPenarikan($_POST) > 0) {
                    echo '<script>
                      toastr.options.timeOut= 7000;
                      toastr["success"]("Berhasil Menarik Saldo!", "Success!");
                    </script>';
            }else {
                echo '<script>
                      toastr.options.timeOut= 7000;
                      toastr["error"]("Gagal Menarik Saldo!", "Error!");
                    </script>';
            }

        }


        
        
        

        


















          // if ($saldo<$penarikan) {
          //   alert("Saldo Tidak Cukup Untuk Ditarik!");
          // }else{
          //   if (tambahPenarikan($_POST) > 0) {
          //           echo '<script>
          //             toastr.options.onHidden = function() { window.location.href = "dataTransaksi.php" }
          //             toastr.options.timeOut = 4000;
          //             toastr.options.timeOut= 1000;
          //             toastr["success"]("Berhasil Menambahkan Data!", "Success");
          //           </script>';
          //   }else {
          //       gagalTambah();
          //   }

          // }
         
        } 
      
?>

<script>


  
  var i = 1;


    $('#id_nasabah').on('change', function() {
      var selectedOption = $(this).find('option:selected');
      
      $('#saldo').val(selectedOption[0].dataset.saldo);
    });

    $(document).ready(function() {
    $('#id_nasabah').select2({
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
    $("#penarikan").inputFilter(function(value) {
      return /^\d*$/.test(value); });
</script>
</body>

</html>

