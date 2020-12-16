<?php
	header("Access-Control-Allow-Origin: *");
	session_start();
	header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
    include "../../lib/conn.php";
    mysqli_set_charset($conn,'utf8');

    $method = isset($_POST['_METHOD']) ? $_POST['_METHOD'] : $_SERVER['REQUEST_METHOD'];

    $key = isset($_REQUEST['idBarang']) ? $_REQUEST['idBarang'] : '';
    
		$kode_barang= isset($_REQUEST['kode_barang']) ? $_REQUEST['kode_barang'] : '' ;
		$nama_barang= isset($_REQUEST['nama_barang']) ? $_REQUEST['nama_barang'] : '' ;
		$stock_barang= isset($_REQUEST['stock_barang']) ? $_REQUEST['stock_barang'] : '' ;
    switch ($method) {
        case 'GET':
          $sql = "SELECT * FROM barang ".($key ?" WHERE idBarang =$key":''); 
        break;
        case 'PUT': $sql = "UPDATE barang SET 
										kode_barang= '$kode_barang', 
										nama_barang= '$nama_barang', 
										stock_barang= '$stock_barang' WHERE idBarang = $key ";
        break;
        case 'POST': $sql = "INSERT INTO barang( 
										kode_barang, 
										nama_barang, 
										stock_barang) VALUES (
										'$kode_barang', 
										'$nama_barang', 
										'$stock_barang')";
        break;
        case 'DELETE':
           $sql = "DELETE FROM barang WHERE idBarang = $key"; 
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