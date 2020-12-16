<?php
	session_start();
	include "../../lib/conn.php";
	
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_GET['page']) && isset($_GET['act']))
	{
		$mod = $_GET['page'];
		$act = $_GET['act'];
	}
	else
	{
		$mod = "";
		$act = "";
	}

	if($mod == "keluar_barang" AND $act == "simpan")
	{
		//variable input
		
		$kode_keluar_barang= $_POST['kode_keluar_barang'];
		$idPegawai_mengajukan= $_POST['idPegawai_mengajukan'];
		$nama_pegawai= $_POST['nama_pegawai'];
		$pegawai_approve= $_POST['pegawai_approve'];
		$approve_manager= $_POST['approve_manager'];
		$tanggal_keluar_barang= $_POST['tanggal_keluar_barang'];
		$idBarang= $_POST['idBarang'];
		$qty= $_POST['qty'];

		mysqli_query($conn, "INSERT INTO keluar_barang(
										kode_keluar_barang, 
										idPegawai_mengajukan, 
										nama_pegawai,
										pegawai_approve,
										approve_manager,
										tanggal_keluar_barang)
									VALUES (
										'$kode_keluar_barang', 
										'$idPegawai_mengajukan', 
										'$nama_pegawai',
										'$pegawai_approve',
										'$approve_manager',
										'$tanggal_keluar_barang')") ;

		$cekKeluarBarang = mysqli_query($conn, "select idKeluarBarang from keluar_barang order by idKeluarBarang desc limit 1");
		$dataKeluarBarang = mysqli_fetch_array($cekKeluarBarang);
		$idKeluarBarang = $dataKeluarBarang['idKeluarBarang'];

		for ($i=0;$i<count($idBarang);$i++){
			$qtyBarang = $qty[$i];
			mysqli_query($conn, "INSERT INTO keluar_barang_detail(idKeluarBarang,
										idBarang, 
										qty)
									VALUES ('$idKeluarBarang',
										'$idBarang[$i]', 
										'$qty[$i]')") or die(mysqli_error());

			mysqli_query($conn,"update barang set stock_barang=stock_barang-$qtyBarang where idBarang=$idBarang[$i]");
		}

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "keluar_barang" AND $act == "edit") 
	{
		//variable input
		$idKeluarBarang = trim($_POST['id']);
		$idPegawai_mengajukan= $_POST['idPegawai_mengajukan'];
		$pegawai_approve= $_POST['pegawai_approve'];
		$tanggal_keluar_barang= $_POST['tanggal_keluar_barang'];
		$approve_manager= $_POST['approve_manager'];

		mysqli_query($conn, "UPDATE keluar_barang SET 
										idPegawai_mengajukan= '$idPegawai_mengajukan', 
										pegawai_approve= '$pegawai_approve', 
										tanggal_keluar_barang= '$tanggal_keluar_barang', 
										approve_manager= '$approve_manager' 
					WHERE idKeluarBarang = '$_POST[id]'");

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "keluar_barang" AND $act == "hapus") 
	{
		mysqli_query($conn, "DELETE FROM keluar_barang WHERE idKeluarBarang = '$_GET[id]'");
		echo"<script>
			window.history.back();
		</script>";	
	}

?>