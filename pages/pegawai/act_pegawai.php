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

	if($mod == "pegawai" AND $act == "simpan")
	{
		//variable input
		
		$kode_pegawai= $_POST['kode_pegawai'];
		$nama_pegawai= $_POST['nama_pegawai'];
		$alamat= $_POST['alamat'];
		$telepon= $_POST['telepon'];
		$jabatan= $_POST['jabatan'];
		$Username= $_POST['usernm'];
		$Password= md5($_POST['passwd']);

		mysqli_query($conn, "INSERT INTO pegawai(
										kode_pegawai, 
										nama_pegawai, 
										alamat, 
										telepon, 
										jabatan)
									VALUES (
										'$kode_pegawai', 
										'$nama_pegawai', 
										'$alamat', 
										'$telepon', 
										'$jabatan')") ;
		$lastId = mysqli_fetch_assoc(mysqli_query($conn,'select idPegawai from pegawai order by idPegawai desc limit 1'));
		$idPegawai = $lastId['idPegawai'];

		mysqli_query($conn, "INSERT INTO user(
										idPegawai, 
										nama_lengkap, 
										usernm, 
										passwd,
										level)
									VALUES (
										'$idPegawai', 
										'$nama_pegawai', 
										'$Username', 
										'$Password',
										'$jabatan')") ;
		


		echo"
		<script>
			location.href='../../index.php?page=pegawai';
		</script>
		";
	}

	elseif ($mod == "pegawai" AND $act == "edit") 
	{
		//variable input
		$idPegawai = trim($_POST['id']);
		$kode_pegawai= $_POST['kode_pegawai'];
		$nama_pegawai= $_POST['nama_pegawai'];
		$alamat= $_POST['alamat'];
		$telepon= $_POST['telepon'];
		$jabatan= $_POST['jabatan'];
		$Username= $_POST['usernm'];
		$pass = !empty($_POST['passwd']) ? md5($_POST['passwd']) : '';
		$Password= !empty($_POST['passwd']) ? "passwd= '$pass'," : '';

		mysqli_query($conn, "UPDATE pegawai SET 
										kode_pegawai= '$kode_pegawai', 
										nama_pegawai= '$nama_pegawai', 
										alamat= '$alamat', 
										telepon= '$telepon', 
										jabatan= '$jabatan' 
					WHERE idPegawai = '$_POST[id]'");

		mysqli_query($conn, "UPDATE user SET 
										usernm= '$Username', 
										nama_lengkap = '$nama_pegawai',
										level = '$jabatan',
										$Password
					WHERE idPegawai = '$_POST[id]'");

		echo"
		<script>
			location.href='../../index.php?page=pegawai';
		</script>
		";
	}

	elseif ($mod == "pegawai" AND $act == "hapus") 
	{
		mysqli_query($conn, "DELETE FROM pegawai WHERE idPegawai = '$_GET[id]'");
		mysqli_query($conn, "DELETE FROM user WHERE idPegawai = '$_GET[id]'");
		echo"<script>
			window.history.back();
		</script>";	
	}

?>