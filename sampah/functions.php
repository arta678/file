
<?php 
// koneksi ke database
$conn = mysqli_connect("localhost", "artawgn", "kopibali", "sibasah");
if (!$conn) {
 die("Connection failed: " . mysqli_connect_error());

}
function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}
	return $rows;
}

/////////////////////////////////////////////
				// NASABAH TAMBAH
/////////////////////////////////////////////

function tambahNasabah($data) {
	global $conn;
	$id_nasabah = kodeNasabah();
	$id_rekening = kodeRekening();
	$nama = ucwords(htmlspecialchars($data["nama"]));
	$jenis_kelamin = htmlspecialchars($data["jenis_kelamin"]);
	$hp = htmlspecialchars($data["hp"]);
	$alamat = ucwords(htmlspecialchars($data["alamat"]));
	$status = "Aktif";
	$tanggal_buat = date('Y-m-d');
	$query_nasabah = "INSERT INTO tb_nasabah
				VALUES 
			  ('$id_nasabah', '$nama', '$jenis_kelamin', '$hp', '$alamat', '$status','$tanggal_buat')
			";
	$query_rekening = "INSERT INTO tb_rekening
				VALUES 
			  ('$id_rekening','$id_nasabah',0)
			";	
		
	mysqli_query($conn, $query_nasabah);
	mysqli_query($conn, $query_rekening);
	
	return mysqli_affected_rows($conn);
}
/////////////////////////////////////////////
				// NASABAH UBAH
/////////////////////////////////////////////
function ubahNasabah($data) {
	global $conn;
	$id= $data["id"];
	$nama = ucwords(htmlspecialchars($data["nama"]));
	$jenis_kelamin = htmlspecialchars($data["jenis_kelamin"]);
	$hp = htmlspecialchars($data["hp"]);
	$alamat = ucwords(htmlspecialchars($data["alamat"]));
	$status = htmlspecialchars($data["status"]);
	$tanggal_buat = date('Y-m-d');

	$query = "UPDATE tb_nasabah SET
				nama = '$nama',
				jenis_kelamin = '$jenis_kelamin',
				hp = '$hp',
				alamat = '$alamat',
				status = '$status'
			  WHERE id = '$id'
			";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);	
}


/////////////////////////////////////////////
				// NASABAH HAPUS
/////////////////////////////////////////////
function hapusNasabah($id) {
	global $conn;
	$id = $_POST["id"];
	mysqli_query($conn, "DELETE FROM tb_nasabah WHERE id = '$id'");
	return mysqli_affected_rows($conn);
}



/////////////////////////////////////////////
				// PETUGAS TAMBAH
/////////////////////////////////////////////
function tambah_petugas($data) {
	global $conn;
	$nama = htmlspecialchars($data["nama"]);
	$jenis_kelamin = htmlspecialchars($data["jenis_kelamin"]);
	$hp = htmlspecialchars($data["hp"]);
	$alamat = htmlspecialchars($data["alamat"]);
	$status = "Aktif";
	$tanggal_buat = date('Y-m-d');
	$query = "INSERT INTO tb_petugas
				VALUES 
			  (null, '$nama', '$jenis_kelamin', '$hp', '$alamat', '$status','$tanggal_buat')
			";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

/////////////////////////////////////////////
				// PETUGAS UBAH
/////////////////////////////////////////////
function ubah_petugas($data) {
	global $conn;
	$id= $data["id"];
	$nama = htmlspecialchars($data["nama"]);
	$jenis_kelamin = htmlspecialchars($data["jenis_kelamin"]);
	$hp = htmlspecialchars($data["hp"]);
	$alamat = htmlspecialchars($data["alamat"]);
	$status = htmlspecialchars($data["status"]);
	$tanggal_buat = date('Y-m-d');

	$query = "UPDATE tb_petugas SET
				nama = '$nama',
				jenis_kelamin = '$jenis_kelamin',
				hp = '$hp',
				alamat = '$alamat',
				status = '$status',
				tanggal_buat = '$tanggal_buat'
			  WHERE id = $id
			";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);	
}

/////////////////////////////////////////////
				// PETUGAS HAPUS
/////////////////////////////////////////////
function hapus_petugas($id) {
	global $conn;
	mysqli_query($conn, "DELETE FROM tb_petugas WHERE id = $id");
	return mysqli_affected_rows($conn);
}

/////////////////////////////////////////////
				// KATEGORI TAMBAH
/////////////////////////////////////////////

function tambahKategori($data) {
	global $conn;
	$id_kategori =kodeKategori();
	$jenis_kategori= ucwords(htmlspecialchars($data["jenis_kategori"]));
	$satuan = ucwords(htmlspecialchars($data["satuan"]));

	$b  =  "SELECT jenis_kategori from tb_kategori where jenis_kategori = '$jenis_kategori'";
	$a = mysqli_query($conn, $b);

	if ( mysqli_fetch_assoc($a) ) {
		echo "
		<script>
		toastr['warning']('Data sudah pernah dimasukkan sebelumnya!', 'Data Sudah Ada');
		</script>";
		return false;
	}

	$query_kategori = "INSERT INTO tb_kategori
				VALUES 
			  ('$id_kategori', '$jenis_kategori', '$satuan')
			";
	mysqli_query($conn, $query_kategori);
	
	return mysqli_affected_rows($conn);
}
/////////////////////////////////////////////
				// KATEGORI UBAH
/////////////////////////////////////////////
function ubahKategori($data) {
	global $conn;
	$id= $data["id"];
	$jenis_kategori= ucwords(htmlspecialchars($data["jenis_kategori"]));
	$satuan = ucwords(htmlspecialchars($data["satuan"]));

	$query = "UPDATE tb_kategori SET
				jenis_kategori = '$jenis_kategori',
				satuan = '$satuan'
			  WHERE id_kategori = '$id'
			";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);	
}

/////////////////////////////////////////////
				// KATEGORI HAPUS
/////////////////////////////////////////////
function hapusKategori($id) {
	global $conn;
	$id_hapus = $_POST['id'];
	mysqli_query($conn, "DELETE FROM tb_kategori WHERE id_kategori = '$id_hapus'");
	return mysqli_affected_rows($conn);
}


/////////////////////////////////////////////
				// SAMPAH TAMBAH
/////////////////////////////////////////////

function tambahSampah($data) {
	global $conn;
	$id_sampah = kodeSampah();
	$id_kategori= $data["id_kategori"];
	$nama_sampah = ucwords(htmlspecialchars($data["nama_sampah"]));
	$harga_sampah = htmlspecialchars($data["harga_sampah"]);
	$keterangan = ucwords(htmlspecialchars($data["keterangan"]));
	
	
	$query_sampah = "INSERT INTO tb_sampah
				VALUES 
			  ('$id_sampah', '$id_kategori', '$nama_sampah', '$harga_sampah', '$keterangan')
			";
	mysqli_query($conn, $query_sampah);
	
	return mysqli_affected_rows($conn);
}

function ubahSampah($data) {
	global $conn;
	$id= $data["id"];
	$id_kategori= htmlspecialchars($data["id_kategori"]);
	$nama_sampah= htmlspecialchars($data["nama_sampah"]);
	$kategori = htmlspecialchars($data["kategori"]);
	$harga_sampah = htmlspecialchars($data["harga_sampah"]);
	$keterangan = htmlspecialchars($data["keterangan"]);

	$query = "UPDATE tb_sampah SET
				id_kategori = '$id_kategori',
				nama_sampah = '$nama_sampah',
				harga_sampah = '$harga_sampah',
				keterangan = '$keterangan'
			  WHERE id = '$id'
			";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);	
}
/////////////////////////////////////////////
				// SAMPAH HAPUS
/////////////////////////////////////////////
function hapusSampah($id) {
	global $conn;
	$id_hapus = $_POST['id'];
	mysqli_query($conn, "DELETE FROM tb_sampah WHERE id = '$id_hapus'");
	return mysqli_affected_rows($conn);
}

function tambahSetoran($data) {
	global $conn;
	$id_transaksi= kodeTransaksi();
	$id_detail_transaksi = kodeDetailTransaksi();
	$tanggal_transaksi = date('Y-m-d');
 	$tipe_transaksi = "Setoran";
 	$id_nasabah = $data["id_nasabah"];
	$id_sampah = $data["id_sampah"];
	$kg = $data["kg"];
	// mendapatkan rekening nasabah
	$sql = "select id_rekening from tb_rekening  where id_nasabah ='".$id_nasabah."'";
	$row = mysqli_fetch_array(mysqli_query($conn,$sql));
	$id_rekening = $row['id_rekening'];
	// query insert tb_transaksi
	$query_transaksi = "INSERT INTO tb_transaksi
				VALUES 
			  ('$id_transaksi', '$tanggal_transaksi', '$tipe_transaksi', '$id_nasabah', '$id_rekening',0,0)
			";
	mysqli_query($conn, $query_transaksi);
		foreach ($data["id_sampah"] as  $key => $sampah) {
			$berat = $data["kg"][$key];
			// cek harga sampah
			$sql1 = "select * from tb_sampah  where id ='".$sampah."'";
			$row = mysqli_fetch_array(mysqli_query($conn,$sql1));
			$harga = $row['harga_sampah'];

			$jumlah_setoran_sampah = $harga * $berat;
			$query_detail_transaksi = " INSERT INTO tb_detail_transaksi
					VALUES
					(null,'$id_transaksi', '$sampah', '{$data['kg'][$key]}',$jumlah_setoran_sampah)
		
			";				
			mysqli_query($conn,$query_detail_transaksi) or die ;
		}
		// update jumlah setoran pada tb_transaksi
		$jumlah = getJumlahSetoranPerTransaksi($id_transaksi);
		updateTransaksiSetoran($jumlah,$id_transaksi);



	return mysqli_affected_rows($conn);
}

function tambahPenarikan($data) {
	global $conn;
	$id_transaksi= kodeTransaksi();
	$tanggal_transaksi = date('Y-m-d');
 	$tipe_transaksi = "Penarikan";
 	$id_nasabah = $data["id_nasabah"];
 	$jumlah_penarikan = $data["penarikan"];
	// mendapatkan rekening nasabah
	$sql = "select id_rekening from tb_rekening  where id_nasabah ='".$id_nasabah."'";
	$row = mysqli_fetch_array(mysqli_query($conn,$sql));
	$id_rekening = $row['id_rekening'];
	// query insert tb_transaksi
	$query_penarikan = "INSERT INTO tb_transaksi
				VALUES 
			  ('$id_transaksi', '$tanggal_transaksi', '$tipe_transaksi', '$id_nasabah', '$id_rekening',0,'$jumlah_penarikan')
			";
	mysqli_query($conn, $query_penarikan);
	$query_detail_transaksi = "INSERT INTO tb_detail_transaksi
				VALUES
					(null,'$id_transaksi', '', null ,0)
			";
	mysqli_query($conn, $query_detail_transaksi);
	
	return mysqli_affected_rows($conn);
}
function tambahSetoran1($data) {
	global $conn;
	$id= $data["id"];
	$tanggal_transaksi = date('Y-m-d');
 	$tipe_transaksi = "Setoran";
 	$id_nasabah = htmlspecialchars($data["id_nasabah"]);
 	$id_rekening = $id_nasabah;
	$id_sampah = $data["id_sampah"];
	$kg = $data["kg"];
	
	$query_transaksi = "INSERT INTO tb_transaksi
				VALUES 
			  (null, '$tanggal_transaksi', '$tipe_transaksi', '$id_nasabah', '$id_rekening')
			";
	mysqli_query($conn, $query_transaksi);
	$sql = "select max(id_transaksi) as id from tb_transaksi limit 1";
	
	$row = mysqli_fetch_array(mysqli_query($conn,$sql));
		
	$id_transaksi = $row['id'];
		foreach ($data["id_sampah"] as  $key => $sampah) {
		$query_detail_transaksi = " INSERT INTO tb_detail_transaksi
				VALUES
				(null,'{$id_transaksi}', $sampah, '{$data['kg'][$key]}',1000 )
	
		";				
		mysqli_query($conn,$query_detail_transaksi) or die ;
	}		
	// return echo mysqli_error($conn);
	return mysqli_affected_rows($conn);
}


function registrasi($data) {
	global $conn;

	$username = strtolower(stripslashes($data["username"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);

	// cek username sudah ada atau belum
	$result = mysqli_query($conn, "SELECT username FROM tb_user WHERE username = '$username'");

	if( mysqli_fetch_assoc($result) ) {
		echo "<script>
				alert('username sudah terdaftar!')
		      </script>";
		return false;
	}
	// cek konfirmasi password
	if( $password !== $password2 ) {
		echo "<script>
				alert('konfirmasi password tidak sesuai!');
		      </script>";
		return false;
	}

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);

	// tambahkan userbaru ke database
	mysqli_query($conn, "INSERT INTO tb_user VALUES(null, '$username', '$password','petugas')");

	return mysqli_affected_rows($conn);
}

function suksesTambah(){
      echo '
            <script>
              	toastr.options.onHidden = function() { window.location.href = "index.php" }
              	toastr.options.timeOut = 4000;
              	toastr.options.timeOut= 1000;
              	toastr["success"]("Berhasil Menambahkan Data!", "Success");
            </script>
          ';
    }
function gagalTambah(){
  echo '
        <script>
              	toastr.options.onHidden = function() { window.location.href = "index.php" }
             	toastr.options.timeOut = 4000;
              	toastr.options.timeOut= 4000;
              	toastr["error"]("Gagal Menambahkan Data!", "Error");
         </script>
      ';
}
function suksesEdit(){
      echo '
            <script>
              	toastr.options.onHidden = function() {window.location.href = "index.php"}
              	toastr.options.timeOut = 4000;
              	toastr.options.timeOut= 1000;
              	toastr["success"]("Berhasil Mengedit Data!", "Success");
            </script>
          ';
    }

function gagalEdit(){
  echo "
        <script>
              	toastr.options.onHidden = function() { window.location.href = 'index.php' }
              toastr.options.timeOut = 4000;
              	toastr.options.timeOut= 1000;
              	toastr['error']('Gagal Mengedit Data!', 'Error');
            </script>
      ";
}

function suksesHapus(){
      echo '
      		<script>
              	toastr.options.onHidden = function() { window.location.href = "index.php" }
              	toastr.options.timeOut = 4000;
              	toastr.options.timeOut= 1000;
              	toastr["success"]("Berhasil Mengahapus Data!", "Success");
            </script>
          ';
    }

function gagalHapus(){
  echo '
        <script>
              	toastr.options.onHidden = function() { window.location.href = "index.php" }
              	toastr.options.timeOut = 4000;
              	toastr.options.timeOut= 1000;
              	toastr["error"]("Gagal Mengedit Data!", "Error");
            </script>
      ';
}

function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

  function kodeNasabah(){
        global $conn;

        $query = mysqli_query($conn, "select max(id) as maxkode from tb_nasabah ");
        $data = mysqli_fetch_assoc($query);
        $kodeuser = $data['maxkode'];
        $nourut = (int)substr($kodeuser,3, 3);
        $nourut++;
        $char = "NS";
        $kodeuser = $char.sprintf("%03s", $nourut);
        return $kodeuser;
    }
    function kodeRekening(){
        global $conn;

        $query = mysqli_query($conn, "select max(id_rekening) as maxkode from tb_rekening ");
        $data = mysqli_fetch_array($query);
        $kodeuser = $data['maxkode'];
        $nourut = (int)substr($kodeuser,3, 3);
        $nourut++;
        $char = "RK";
        $kodeuser = $char.sprintf("%03s", $nourut);
        return $kodeuser;
    }
    function kodeTransaksi(){
        global $conn;
        $query = mysqli_query($conn, "select max(id_transaksi) as maxkode from tb_transaksi ");
        $data = mysqli_fetch_array($query);
        $kodeuser = $data['maxkode'];
        $nourut = (int)substr($kodeuser,5, 5);
        $nourut++;
        $char = "TR";
        $kodeuser = $char.sprintf("%05s", $nourut);
        return $kodeuser;
    }
    function kodeSampah(){
        global $conn;
        $query = mysqli_query($conn, "select max(id) as maxkode from tb_sampah ");
        $data = mysqli_fetch_array($query);
        $kodeuser = $data['maxkode'];
        $nourut = (int)substr($kodeuser,3, 3);
        $nourut++;
        $char = "S";
        $kodeuser = $char.sprintf("%03s", $nourut);
        return $kodeuser;
    }
    function kodeKategori(){
        global $conn;
        $query = mysqli_query($conn, "select max(id_kategori) as maxkode from tb_kategori ");
        $data = mysqli_fetch_array($query);
        $kodeuser = $data['maxkode'];
        $nourut = (int)substr($kodeuser,3, 3);
        $nourut++;
        $char = "J";
        $kodeuser = $char.sprintf("%03s", $nourut);
        return $kodeuser;
    }
    function kodeDetailTransaksi(){
        global $conn;
        $query = mysqli_query($conn, "select max(id_detail_transaksi) as maxkode from tb_detail_transaksi ");
        $data = mysqli_fetch_array($query);
        $kodeuser = $data['maxkode'];
        $nourut = (int)substr($kodeuser,4, 4);
        $nourut++;
        $char = "DT";
        $kodeuser = $char.sprintf("%04s", $nourut);
        return $kodeuser;
    }
    function getTotalSetoran($id_nasabah){
    	global $conn;
    	$getTotalSetoran = "SELECT SUM(total_setoran) as tot
            FROM tb_transaksi
            WHERE id_nasabah ='$id_nasabah' AND tipe_transaksi = 'Setoran'";
			$result = mysqli_fetch_assoc(mysqli_query($conn,$getTotalSetoran));
			$total_setoran = $result["tot"];      
			return $total_setoran;
    }
    function getTotalSetoran1($id_nasabah){
    	global $conn;
    	$getTotalSetoran = "SELECT SUM(total_setoran) as tot
            FROM tb_transaksi
            WHERE id_nasabah ='$id_nasabah' AND tipe_transaksi = 'Setoran'";
			$result = mysqli_fetch_assoc(mysqli_query($conn,$getTotalSetoran));
			$total_setoran = $result["tot"];      
			return $total_setoran;
    }
    function getTotalPenarikan($id_nasabah){
    	global $conn;
    	$getTotalPenarikan = "SELECT SUM(total_penarikan) as tot
            FROM tb_transaksi
            WHERE id_nasabah ='$id_nasabah' AND tipe_transaksi = 'Penarikan'";
			$result = mysqli_fetch_assoc(mysqli_query($conn,$getTotalPenarikan));
			$total_penarikan = $result["tot"];      
			return $total_penarikan;
    }
    function updateTransaksiSetoran($jumlahSetoran ,$id_transaksi){
    	global $conn;
    	$updateTotalTransaksiSetoran ="UPDATE tb_transaksi SET total_setoran ='".$jumlahSetoran."' where id_transaksi ='".$id_transaksi."'";
    	$result = mysqli_fetch_assoc(mysqli_query($conn,$updateTotalTransaksiSetoran));
    }

    function getJumlahSetoranPerTransaksi($idTransaksi){
    	global $conn;
    	$getJumlahSetoran = "select SUM(total_transaksi) as tl from tb_detail_transaksi where id_transaksi = '".$idTransaksi."'";
		$result = mysqli_fetch_assoc(mysqli_query($conn,$getJumlahSetoran));
		$JumlahSetoran = $result["tl"];      
		return $JumlahSetoran;
    }

    function rupiah($jumlahUang){
    	if($jumlahUang!=0){
			$rupiah = number_format($jumlahUang, 0,',','.');
			$hasil = "Rp.".$rupiah;

		}else{
			$hasil="";
 		}
 		return $hasil;
    }
    function getTotalSaldo($id_nasabah){
    	$setoran = getTotalSetoran($id_nasabah);
    	$penarikan =getTotalPenarikan($id_nasabah);
    	$saldo = $setoran - $penarikan;
    	return $saldo;

    }

?>


