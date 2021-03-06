<?php
	header("Access-Control-Allow-Origin: *");
	session_start();
	header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
    include "../../lib/conn.php";
    mysqli_set_charset($conn,'utf8');

    $method = isset($_POST['_METHOD']) ? $_POST['_METHOD'] : $_SERVER['REQUEST_METHOD'];

    $key = isset($_REQUEST['idPemesanan']) ? $_REQUEST['idPemesanan'] : '';
    
		$idPegawai_mengajukan= isset($_REQUEST['idPegawai_mengajukan']) ? $_REQUEST['idPegawai_mengajukan'] : '' ;
		$idPegawai_approve= isset($_REQUEST['idPegawai_approve']) ? $_REQUEST['idPegawai_approve'] : '' ;
		$tanggal_pemesanan= isset($_REQUEST['tanggal_pemesanan']) ? $_REQUEST['tanggal_pemesanan'] : '' ;
    switch ($method) {
        case 'GET':
          $sql = "SELECT * FROM pemesanan ".($key ?" WHERE idPemesanan =$key":''); 
        break;
        case 'PUT': $sql = "UPDATE pemesanan SET 
										idPegawai_mengajukan= '$idPegawai_mengajukan', 
										idPegawai_approve= '$idPegawai_approve', 
										tanggal_pemesanan= '$tanggal_pemesanan' WHERE idPemesanan = $key ";
        break;
        case 'POST': $sql = "INSERT INTO pemesanan( 
										idPegawai_mengajukan, 
										idPegawai_approve, 
										tanggal_pemesanan) VALUES (
										'$idPegawai_mengajukan', 
										'$idPegawai_approve', 
										'$tanggal_pemesanan')";
        break;
        case 'DELETE':
           $sql = "DELETE FROM pemesanan WHERE idPemesanan = $key"; 
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