<?php
	header("Access-Control-Allow-Origin: *");
	session_start();
	header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
    include "../../lib/conn.php";
    mysqli_set_charset($conn,'utf8');

    $method = isset($_POST['_METHOD']) ? $_POST['_METHOD'] : $_SERVER['REQUEST_METHOD'];

    $key = isset($_REQUEST['idKeluarBarang']) ? $_REQUEST['idKeluarBarang'] : '';
    
		$idPegawai_mengajukan= isset($_REQUEST['idPegawai_mengajukan']) ? $_REQUEST['idPegawai_mengajukan'] : '' ;
		$idPegawai_approve= isset($_REQUEST['idPegawai_approve']) ? $_REQUEST['idPegawai_approve'] : '' ;
		$tanggal_keluar_barang= isset($_REQUEST['tanggal_keluar_barang']) ? $_REQUEST['tanggal_keluar_barang'] : '' ;
    switch ($method) {
        case 'GET':
          $sql = "SELECT * FROM keluar_barang ".($key ?" WHERE idKeluarBarang =$key":''); 
        break;
        case 'PUT': $sql = "UPDATE keluar_barang SET 
										idPegawai_mengajukan= '$idPegawai_mengajukan', 
										idPegawai_approve= '$idPegawai_approve', 
										tanggal_keluar_barang= '$tanggal_keluar_barang' WHERE idKeluarBarang = $key ";
        break;
        case 'POST': $sql = "INSERT INTO keluar_barang( 
										idPegawai_mengajukan, 
										idPegawai_approve, 
										tanggal_keluar_barang) VALUES (
										'$idPegawai_mengajukan', 
										'$idPegawai_approve', 
										'$tanggal_keluar_barang')";
        break;
        case 'DELETE':
           $sql = "DELETE FROM keluar_barang WHERE idKeluarBarang = $key"; 
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