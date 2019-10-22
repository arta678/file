
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
	$username = str_replace(' ', '', $nama);
	$user = substr($username,0,8);
	$id_login = registrasiManual($user,$hp,"nasabah");

	$query_nasabah = "INSERT INTO tb_nasabah
				VALUES 
			  ('$id_nasabah',null,LAST_INSERT_ID(), '$nama', '$jenis_kelamin', '$hp', '$alamat', '$status','$tanggal_buat')
			";
	$query_rekening = "INSERT INTO tb_rekening
				VALUES 
			  ('$id_rekening',null,0)
			";	
		
	mysqli_query($conn, $query_nasabah);
	mysqli_query($conn, $query_rekening);
	updateTbNasabah($id_nasabah,$id_rekening);
	updateTbRekening($id_rekening,$id_nasabah);
	
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
	$tanggal_transaksi = $data["tanggal_transaksi"];
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
		tambahSaldoRekening($jumlah,$id_rekening);

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
					(null,'$id_transaksi', null, null ,0)
			";
	mysqli_query($conn, $query_detail_transaksi);
	// update saldo
	kurangiSaldoRekening($jumlah_penarikan,$id_rekening);
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
	$result = mysqli_query($conn, "SELECT username FROM tb_login WHERE username = '$username'");

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
	mysqli_query($conn, "INSERT INTO tb_login VALUES(null,'$username', '$password','admin')");

	return mysqli_affected_rows($conn);
}
function registrasiManual($username,$passowd,$akses) {
	global $conn;

	$username = strtolower(stripslashes($username));
	$password = mysqli_real_escape_string($conn, $passowd);
	// $akses =$akses;
	// cek username sudah ada atau belum
	$result = mysqli_query($conn, "SELECT username FROM tb_login WHERE username = '$username'");

	if( mysqli_fetch_assoc($result) ) {
		echo "<script>
				alert('username sudah terdaftar!')
		      </script>";
		return false;
	}
	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);
	// tambahkan userbaru ke database
	mysqli_query($conn, "INSERT INTO tb_login VALUES(null,'$username', '$password','$akses')");
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
    function getTotalSaldo($idRekening){
    	// $setoran = getTotalSetoran($id_nasabah);
    	// $penarikan =getTotalPenarikan($id_nasabah);
    	// $saldo = $setoran - $penarikan;
    	global $conn;
    // find saldo rekening	
    	$query = "
    	SELECT saldo_rekening FROM tb_rekening 
    	WHERE id_nasabah ='".$idRekening."'
    	";
    	$hasil = mysqli_fetch_assoc(mysqli_query($conn,$query));
    	$saldo =  $hasil["saldo_rekening"];

    	return $saldo;

    }
    // untuk metod tambah setoran 
    function tambahSaldoRekening($jumlahSetoran,$idRekening){
    	global $conn;
    // find saldo rekening	
    	$query = "
    	SELECT saldo_rekening FROM tb_rekening 
    	WHERE id_rekening ='".$idRekening."'
    	";
    	$hasil = mysqli_fetch_assoc(mysqli_query($conn,$query));
    	$saldo =  $hasil["saldo_rekening"];

    	$saldo_akhir = $saldo + $jumlahSetoran;

    // update saldo rekening
    	$tambah = "UPDATE tb_rekening SET
				saldo_rekening = '".$saldo_akhir."'
			  WHERE id_rekening = '".$idRekening."'
			";	
		mysqli_query($conn,$tambah);	
    	return $saldo_akhir;

    }
    // untuk metod penarikan saldo
    function kurangiSaldoRekening($jumlahSetoran,$idRekening){
    	global $conn;
    	$query = "
    	SELECT saldo_rekening FROM tb_rekening 
    	WHERE id_rekening ='".$idRekening."'
    	";
    	$hasil = mysqli_fetch_assoc(mysqli_query($conn,$query));
    	$saldo =  $hasil["saldo_rekening"];
    	$saldo_akhir = $saldo - $jumlahSetoran;
    	$kurangi = "UPDATE tb_rekening SET
				saldo_rekening = '".$saldo_akhir."'
			  WHERE id_rekening = '".$idRekening."'
			";
		mysqli_query($conn,$kurangi);	
    	return $saldo_akhir;
    }
    function updateTbNasabah($id_nasabah,$id_rekening){
    	global $conn;
    	$update = "UPDATE tb_nasabah SET 
    		no_rekening ='$id_rekening'	
    		WHERE id = '$id_nasabah'
    		";
    		mysqli_query($conn,$update);
    }
     function updateTbRekening($id_rekening,$id_nasabah){
    	global $conn;
    	$update = "UPDATE tb_rekening SET 
    		id_nasabah ='$id_nasabah'	
    		WHERE id_rekening = '$id_rekening'
    		";
    		mysqli_query($conn,$update);
    }

    function tesMulti(){
    	global $conn;
    	$sql = "
		    	INSERT INTO tes
		    	VALUES
		    	('3','KOMANG');
		    	";
    	$sql .="
		    	INSERT INTO tes2
		    	VALUES
		    	('4','C')";
    	mysqli_multi_query($conn,$sql);
    }

    function showData($awal, $akhir){
    	global $conn;
    	$sql = "
	    	SELECT * FROM tb_transaksi
	    	where tanggal_transaksi between '".$awal."' and '".$akhir."' 
	    	";
    	$hasil = mysqli_query($conn,$sql);

    	return $hasil;

    }
    function bulanBelakang(){
    	global $conn;
    	$sql = "SELECT month(now()) as bulan";
    	$hasil = mysqli_fetch_assoc(mysqli_query($conn,$sql));
    	$bulan = $hasil["bulan"];
    	$bulan = $bulan - 1;
    	return $bulan;
    }
    function bulanMysql(){
    	global $conn;
    	$sql = "SELECT month(now()) as bulan";
    	$hasil = mysqli_fetch_assoc(mysqli_query($conn,$sql));
    	$bulan = $hasil["bulan"];
    	return $bulan;
    }
   function bulanIndonesia($bulan){
   	
   	if ($bulan == 1) {
   		return "Januari";
   	}elseif ($bulan == 2 ) {
   		return "Februari";
   	}elseif ($bulan == 3) {
   		return "Maret";
   	}elseif ($bulan == 4) {
   		return "April";
   	}elseif ($bulan == 5) {
   		return "Mei";
   	}elseif ($bulan == 6) {
   		return "Juni";
   	}elseif ($bulan == 7) {
   		return "Juli";
   	}elseif ($bulan == 8) {
   		return "Agustus";
   	}elseif ($bulan == 9) {
   		return "September";
   	}elseif ($bulan == 10) {
   		return "Oktober";
   	}elseif ($bulan == 11) {
   		return "November";
   	}elseif ($bulan == 12) {
   		return "Desember";
   	}
   }

   function totalBeratSampah($tanggal1,$tanggal2){
   		global $conn;
   		$hasil = "SELECT SUM(berat_sampah) as total  FROM `tb_detail_transaksi` 
                              INNER JOIN tb_transaksi 
                              ON tb_detail_transaksi.id_transaksi = tb_transaksi.id_transaksi
                              WHERE tb_transaksi.tanggal_transaksi 
                              BETWEEN  '".$tanggal1."' and '".$tanggal2."'
                              ";
        $hasil = mysqli_fetch_assoc(mysqli_query($conn,$hasil));
        $hasil = $hasil["total"];
   		return $hasil;
   }
   function bulanTanggal($tanggal){
   	global $conn;
    	$sql = "SELECT month('$tanggal') as bulan";
    	$hasil = mysqli_fetch_assoc(mysqli_query($conn,$sql));
    	$bulan = $hasil["bulan"];
    	$bulan = bulanIndonesia($bulan);
    	$sql = "SELECT day('$tanggal') as hari";
    	$hasil2 = mysqli_fetch_assoc(mysqli_query($conn,$sql));
    	$hari = $hasil2["hari"];
    	return $hari." ". $bulan;
   }

   function getSampahPerbulan($bulan,$tahun){
   	global $conn;
   	$sql = "SELECT SUM(tb_detail_transaksi.berat_sampah) as jumlah FROM tb_sampah
			INNER JOIN tb_detail_transaksi
			ON tb_sampah.id = tb_detail_transaksi.id_sampah
			INNER JOIN tb_transaksi
			ON tb_detail_transaksi.id_transaksi = tb_transaksi.id_transaksi
			WHERE month(tb_transaksi.tanggal_transaksi) = '".$bulan."' and
			YEAR(tb_transaksi.tanggal_transaksi) = '".$tahun."'
			";
	$hasil =  mysqli_fetch_assoc(mysqli_query($conn,$sql));
	$hasil = $hasil["jumlah"];
	if ($hasil == '') {
		$hasil = 0;
	}
	return $hasil;		
   }

   function stringToInt($string){
		$bar = (int) $string;
		return $bar;
   }
   
   function showDataSampah($tahun){
   	$bulan1 = stringToInt(getSampahPerbulan(1,$tahun));
   	$bulan2 = stringToInt(getSampahPerbulan(2,$tahun));
   	$bulan3 = stringToInt(getSampahPerbulan(3,$tahun));
   	$bulan4 = stringToInt(getSampahPerbulan(4,$tahun));
   	$bulan5 = stringToInt(getSampahPerbulan(5,$tahun));
   	$bulan6 = stringToInt(getSampahPerbulan(6,$tahun));
   	$bulan7 = stringToInt(getSampahPerbulan(7,$tahun));
   	$bulan8 = stringToInt(getSampahPerbulan(8,$tahun));
   	$bulan9 = stringToInt(getSampahPerbulan(9,$tahun));
   	$bulan10 = stringToInt(getSampahPerbulan(10,$tahun));
   	$bulan11 = stringToInt(getSampahPerbulan(11,$tahun));
   	$bulan12 = stringToInt(getSampahPerbulan(12,$tahun));


   	$data = 
   	[
   		$bulan1,
   		$bulan2,
   		$bulan3,
   		$bulan4,
   		$bulan5,
   		$bulan6,
   		$bulan7,
   		$bulan8,
   		$bulan9,
   		$bulan10,
   		$bulan11,
   		$bulan12
   	];
   	return $data;

   }
   function jumlahNasabah(){
   	global $conn;
   	$sql = "SELECT COUNT(id) as jumlah FROM tb_nasabah";
   	$hasil = mysqli_fetch_assoc(mysqli_query($conn,$sql));
   	$hasil = $hasil["jumlah"];
   	return $hasil;
   }
   function jumlahSampah(){
   	global $conn;
   	$sql = "SELECT SUM(berat_sampah) as jumlah FROM tb_detail_transaksi";
   	$hasil = mysqli_fetch_assoc(mysqli_query($conn,$sql));
   	$hasil = $hasil["jumlah"];
   	return $hasil;
   }
   function jumlahSetoran(){
   	global $conn;
   	$sql = " SELECT SUM(total_setoran) as jumlah FROM tb_transaksi";
   	$hasil = mysqli_fetch_assoc(mysqli_query($conn,$sql));
   	$hasil = $hasil["jumlah"];
   	return $hasil;
   }
   function jumlahPenarikan(){
   	global $conn;
   	$sql = " SELECT SUM(total_penarikan) as jumlah FROM tb_transaksi";
   	$hasil = mysqli_fetch_assoc(mysqli_query($conn,$sql));
   	$hasil = $hasil["jumlah"];
   	return $hasil;
   }
	function getSetoranPerbulan($bulan,$tahun){
	   	global $conn;
	   	$sql = "SELECT SUM(tb_transaksi.total_setoran) as jumlah FROM tb_transaksi
				WHERE month(tb_transaksi.tanggal_transaksi) = '".$bulan."' and
				YEAR(tb_transaksi.tanggal_transaksi) = '".$tahun."'
				";
		$hasil =  mysqli_fetch_assoc(mysqli_query($conn,$sql));
		$hasil = $hasil["jumlah"];
		if ($hasil == '') {
			$hasil = 0;
		}
		return $hasil;		
	}
		function getPenarikanPerbulan($bulan,$tahun){
	   	global $conn;
	   	$sql = "SELECT SUM(tb_transaksi.total_penarikan) as jumlah FROM tb_transaksi
				WHERE month(tb_transaksi.tanggal_transaksi) = '".$bulan."' and
				YEAR(tb_transaksi.tanggal_transaksi) = '".$tahun."'
				";
		$hasil =  mysqli_fetch_assoc(mysqli_query($conn,$sql));
		$hasil = $hasil["jumlah"];
		if ($hasil == '') {
			$hasil = 0;
		}
		return $hasil;		
	}
	
	function showDataSetoran($tahun){
	   	$bulan1 = stringToInt(getSetoranPerbulan(1,$tahun));
	   	$bulan2 = stringToInt(getSetoranPerbulan(2,$tahun));
	   	$bulan3 = stringToInt(getSetoranPerbulan(3,$tahun));
	   	$bulan4 = stringToInt(getSetoranPerbulan(4,$tahun));
	   	$bulan5 = stringToInt(getSetoranPerbulan(5,$tahun));
	   	$bulan6 = stringToInt(getSetoranPerbulan(6,$tahun));
	   	$bulan7 = stringToInt(getSetoranPerbulan(7,$tahun));
	   	$bulan8 = stringToInt(getSetoranPerbulan(8,$tahun));
	   	$bulan9 = stringToInt(getSetoranPerbulan(9,$tahun));
	   	$bulan10 = stringToInt(getSetoranPerbulan(10,$tahun));
	   	$bulan11 = stringToInt(getSetoranPerbulan(11,$tahun));
	   	$bulan12 = stringToInt(getSetoranPerbulan(12,$tahun));


	   	$data = 
	   	[
	   		$bulan1,
	   		$bulan2,
	   		$bulan3,
	   		$bulan4,
	   		$bulan5,
	   		$bulan6,
	   		$bulan7,
	   		$bulan8,
	   		$bulan9,
	   		$bulan10,
	   		$bulan11,
	   		$bulan12
	   	];
	   	return $data;

	   }
	   function showDataPenarikan($tahun){
	   	$bulan1 = stringToInt(getPenarikanPerbulan(1,$tahun));
	   	$bulan2 = stringToInt(getPenarikanPerbulan(2,$tahun));
	   	$bulan3 = stringToInt(getPenarikanPerbulan(3,$tahun));
	   	$bulan4 = stringToInt(getPenarikanPerbulan(4,$tahun));
	   	$bulan5 = stringToInt(getPenarikanPerbulan(5,$tahun));
	   	$bulan6 = stringToInt(getPenarikanPerbulan(6,$tahun));
	   	$bulan7 = stringToInt(getPenarikanPerbulan(7,$tahun));
	   	$bulan8 = stringToInt(getPenarikanPerbulan(8,$tahun));
	   	$bulan9 = stringToInt(getPenarikanPerbulan(9,$tahun));
	   	$bulan10 = stringToInt(getPenarikanPerbulan(10,$tahun));
	   	$bulan11 = stringToInt(getPenarikanPerbulan(11,$tahun));
	   	$bulan12 = stringToInt(getPenarikanPerbulan(12,$tahun));


	   	$data = 
	   	[
	   		$bulan1,
	   		$bulan2,
	   		$bulan3,
	   		$bulan4,
	   		$bulan5,
	   		$bulan6,
	   		$bulan7,
	   		$bulan8,
	   		$bulan9,
	   		$bulan10,
	   		$bulan11,
	   		$bulan12
	   	];
	   	return $data;

	   }
  

?>


