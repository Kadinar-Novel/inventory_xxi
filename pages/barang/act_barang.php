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

	if($mod == "barang" AND $act == "simpan")
	{
		//variable input
		
		$kode_barang= $_POST['kode_barang'];
		$nama_barang= $_POST['nama_barang'];
		$stock_barang= $_POST['stock_barang'];

		mysqli_query($conn, "INSERT INTO barang(
										kode_barang, 
										nama_barang, 
										stock_barang)
									VALUES (
										'$kode_barang', 
										'$nama_barang', 
										'$stock_barang')") ;
		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "barang" AND $act == "edit") 
	{
		//variable input
		$idBarang = trim($_POST['id']);
		$kode_barang= $_POST['kode_barang'];
		$nama_barang= $_POST['nama_barang'];
		$stock_barang= $_POST['stock_barang'];

		mysqli_query($conn, "UPDATE barang SET 
										kode_barang= '$kode_barang', 
										nama_barang= '$nama_barang', 
										stock_barang= '$stock_barang' 
					WHERE idBarang = '$_POST[id]'");

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "barang" AND $act == "hapus") 
	{
		mysqli_query($conn, "DELETE FROM barang WHERE idBarang = '$_GET[id]'");
		echo"<script>
			window.history.back();
		</script>";	
	}

?>