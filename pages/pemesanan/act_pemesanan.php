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

	if($mod == "pemesanan" AND $act == "simpan")
	{
		//variable input
		
		$idPegawai_mengajukan= $_POST['idPegawai_mengajukan'];
		$idPegawai_approve= $_POST['idPegawai_approve'];
		$tanggal_pemesanan= $_POST['tanggal_pemesanan'];

		mysqli_query($conn, "INSERT INTO pemesanan(
										idPegawai_mengajukan, 
										idPegawai_approve, 
										tanggal_pemesanan)
									VALUES (
										'$idPegawai_mengajukan', 
										'$idPegawai_approve', 
										'$tanggal_pemesanan')") ;
		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "pemesanan" AND $act == "edit") 
	{
		//variable input
		$idPemesanan = trim($_POST['id']);
		$idPegawai_mengajukan= $_POST['idPegawai_mengajukan'];
		$idPegawai_approve= $_POST['idPegawai_approve'];
		$tanggal_pemesanan= $_POST['tanggal_pemesanan'];

		mysqli_query($conn, "UPDATE pemesanan SET 
										idPegawai_mengajukan= '$idPegawai_mengajukan', 
										idPegawai_approve= '$idPegawai_approve', 
										tanggal_pemesanan= '$tanggal_pemesanan' 
					WHERE idPemesanan = '$_POST[id]'");

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "pemesanan" AND $act == "hapus") 
	{
		mysqli_query($conn, "DELETE FROM pemesanan WHERE idPemesanan = '$_GET[id]'");
		echo"<script>
			window.history.back();
		</script>";	
	}

?>