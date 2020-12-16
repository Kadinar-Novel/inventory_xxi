<?php
	header("Access-Control-Allow-Origin: *");
	session_start();
	header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
    include "../../lib/conn.php";
    mysqli_set_charset($conn,'utf8');

    $method = isset($_POST['_METHOD']) ? $_POST['_METHOD'] : $_SERVER['REQUEST_METHOD'];

    $key = isset($_REQUEST['idPegawai']) ? $_REQUEST['idPegawai'] : '';
    
		$kode_pegawai= isset($_REQUEST['kode_pegawai']) ? $_REQUEST['kode_pegawai'] : '' ;
		$nama_pegawai= isset($_REQUEST['nama_pegawai']) ? $_REQUEST['nama_pegawai'] : '' ;
		$alamat= isset($_REQUEST['alamat']) ? $_REQUEST['alamat'] : '' ;
		$telepon= isset($_REQUEST['telepon']) ? $_REQUEST['telepon'] : '' ;
		$jabatan= isset($_REQUEST['jabatan']) ? $_REQUEST['jabatan'] : '' ;
    switch ($method) {
        case 'GET':
          $sql = "SELECT * FROM pegawai ".($key ?" WHERE idPegawai =$key":''); 
        break;
        case 'PUT': $sql = "UPDATE pegawai SET 
										kode_pegawai= '$kode_pegawai', 
										nama_pegawai= '$nama_pegawai', 
										alamat= '$alamat', 
										telepon= '$telepon', 
										jabatan= '$jabatan' WHERE idPegawai = $key ";
        break;
        case 'POST': $sql = "INSERT INTO pegawai( 
										kode_pegawai, 
										nama_pegawai, 
										alamat, 
										telepon, 
										jabatan) VALUES (
										'$kode_pegawai', 
										'$nama_pegawai', 
										'$alamat', 
										'$telepon', 
										'$jabatan')";
        break;
        case 'DELETE':
           $sql = "DELETE FROM pegawai WHERE idPegawai = $key"; 
        break;
    }       
      // excecute SQL statement
      $result = mysqli_query($conn,$sql);
      
      // print results, insert id or affected row count
      if ($method == 'GET') {
		  $row = mysqli_num_rows($result);
          if ($row==0) {
              $data['status'] = 201;
              $data['msg'] = 'Data not found';
              echo json_encode($data);
          }else{
			$response = array();
			$response["data"] = array();
			while ($row = mysqli_fetch_assoc($result)) {
				$data = $row;
				array_push($response["data"], $data);
			}
			echo json_encode($response);			  
          }  
      } elseif ($method == 'POST') {
          if (!$result) {
              $data['status'] = 201;
              $data['msg'] = 'Insert failed';  
          }else{
              $data['status'] = 200;
              $data['msg'] = 'Insert successful';
          }
          echo json_encode($data);
      } elseif ($method == 'PUT') {
          if (!$result) {
              $data['status'] = 201;
              $data['msg'] = 'Update failed'; 
          }else{
              $data['status'] = 200;
              $data['msg'] = 'Update successful';
          }
          echo json_encode($data);
      } elseif ($method == 'DELETE') {
          if (!$result) {
              $data['status'] = 201;
              $data['msg'] = 'Delete failed';  
          }else{
              $data['status'] = 200;
              $data['msg'] = 'Delete successful';
          }
          echo json_encode($data);
      }
       
      // close mysql connection
      mysqli_close($conn);
?>