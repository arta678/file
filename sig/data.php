<?php 
$title = "Daftar Penyedia Jasa Web";
include_once "header.php";
include_once "koneksi.php"; ?>

      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-info panel-dashboard">
            <div class="panel-heading centered">
              <h2 class="panel-title"><strong> - <?php echo $title ?> - </strong></h2>
            </div>
            <div class="panel-body">
              <table class="table table-bordered table-striped table-admin">
              <thead>
                <tr>
                  <th width="10%">No.</th>
                  <th width="30%">Nama Bengkel</th>
                  <th width="10%">Bengkel</th>
                  <th width="30%">Alamat</th>
                  <th width="10%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Bengkel Kasih Motor</td>
                  <td>Motor</td>
                  <td>Jl. Raya Anyar No.2, Kerobokan, Kec. Kuta Utara, Kabupaten Badung, Bali 80361</td>
                  <td class="text-center">
                   <div class="btn-group">
                    <a target="_blank" href="detail.php?id=<?php echo $item->id_perusahaan; ?>" rel="tooltip" data-original-title="Lihat File" data-placement="top" class="btn btn-primary">
                    <i class="fa fa-map-marker"> </i> Detail dan Lokasi</a>&nbsp;
                  </div>
                  </td>

                </tr>
                <tr>
                  <td>2</td>
                  <td>Bengkel Sari Merta</td>
                  <td>Motor</td>
                  <td>Kerobokan, Kec. Kuta Utara, Kabupaten Badung, Bali 80361</td>
                  <td class="text-center">
                   <div class="btn-group">
                    <a target="_blank" href="detail.php?id=<?php echo $item->id_perusahaan; ?>" rel="tooltip" data-original-title="Lihat File" data-placement="top" class="btn btn-primary">
                    <i class="fa fa-map-marker"> </i> Detail dan Lokasi</a>&nbsp;
                  </div>
                  </td>

                </tr>
                <tr>
                  <td>3</td>
                  <td>Bengkel Bella Motor</td>
                  <td>Motor</td>
                  <td>Jl. Raya Anyar No.2, Kerobokan, Kec. Kuta Utara, Kabupaten Badung, Bali 80361</td>
                  <td class="text-center">
                   <div class="btn-group">
                    <a target="_blank" href="detail.php?id=<?php echo $item->id_perusahaan; ?>" rel="tooltip" data-original-title="Lihat File" data-placement="top" class="btn btn-primary">
                    <i class="fa fa-map-marker"> </i> Detail dan Lokasi</a>&nbsp;
                  </div>
                  </td>

                </tr>
                <tr>
                  <td>4</td>
                  <td>Bengkel Mahasari</td>
                  <td>Motor</td>
                  <td>Jl. Gunung Tangkuban Perahu, Griya Permai Br. Teges No.2, Padangsambian Klod, Kec. Denpasar Bar., Kota Denpasar, Bali 80117</td>
                  <td class="text-center">
                   <div class="btn-group">
                    <a target="_blank" href="detail.php?id=<?php echo $item->id_perusahaan; ?>" rel="tooltip" data-original-title="Lihat File" data-placement="top" class="btn btn-primary">
                    <i class="fa fa-map-marker"> </i> Detail dan Lokasi</a>&nbsp;
                  </div>
                  </td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>Bengkel Mobil Wayan Motor</td>
                  <td>Mobil</td>
                  <td>Jalan Gunung Sanghyang, Padang Sambian, Denpasar Barat, Padangsambian Kaja, Kec. Denpasar Bar., Kota Denpasar, Bali 80236</td>
                  <td class="text-center">
                   <div class="btn-group">
                    <a target="_blank" href="detail.php?id=<?php echo $item->id_perusahaan; ?>" rel="tooltip" data-original-title="Lihat File" data-placement="top" class="btn btn-primary">
                    <i class="fa fa-map-marker"> </i> Detail dan Lokasi</a>&nbsp;
                  </div>
                  </td>

                </tr>
              
              </tbody>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php include_once "footer.php" ?>