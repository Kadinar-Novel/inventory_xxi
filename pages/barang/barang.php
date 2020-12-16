<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	//link buat paging
	$linkaksi = 'index.php?page=barang';

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act=$act';
	}
	else
	{
		$act = '';
	}

	$aksi = 'pages/barang/act_barang.php';

	switch ($act) {
		case 'form':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?page=barang&act=edit";
				$query = mysqli_query($conn, "SELECT * FROM barang WHERE idBarang = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:index.php?page=barang");
				}

			}
			else
			{
				$act = "$aksi?page=barang&act=simpan";
			}

		echo"<div class='col-md-12'>
          <div class='box box-primary'>
            <div class='box-header with-border'>
              <h3 class='box-title'> Barang</h3>
			</div>";
			
            echo"<form role='form'  method='POST' action='$act' enctype='multipart/form-data' >
              <div class='box-body'>
                <div class='form-group'>
                  
                  <input type='hidden' class='form-control' name='id' value='"?><?php echo isset($c['idBarang']) ? $c['idBarang'] : '';?><?php echo"'"?> <?php echo isset($c['idBarang']) ? ' readonly' : ' ';?><?php echo" >
								</div>
					<div class='form-group'><label >KODE BARANG</label>
					<input type='text' class='form-control' placeholder='Kode Barang' name='kode_barang' value='"?><?php echo isset($c['kode_barang']) ? $c['kode_barang'] : '';?><?php echo"'"?> <?php echo isset($c['kode_barang']) ? ' ' : ' ';?><?php echo" >
										</div>
					<div class='form-group'><label >NAMA BARANG</label>
					<input type='text' class='form-control' placeholder='Nama Barang' name='nama_barang' value='"?><?php echo isset($c['nama_barang']) ? $c['nama_barang'] : '';?><?php echo"'"?> <?php echo isset($c['nama_barang']) ? ' ' : ' ';?><?php echo" >
										</div>
					<div class='form-group'><label >STOCK BARANG</label>
					<input type='text' class='form-control' placeholder='Stock Barang' name='stock_barang' value='"?><?php echo isset($c['stock_barang']) ? $c['stock_barang'] : '';?><?php echo"'"?> <?php echo isset($c['stock_barang']) ? ' ' : ' ';?><?php echo" >
										</div><div class='box-footer'>
					<button type='submit' class='btn btn-primary'>Submit</button> <button type='button' class='btn btn-primary' onclick='history.back()'><i class='fa fa-rotate-left'></i> Kembali</button>
				</div>
			  </div>			
            </form>
          </div>
        </div>
		";
		break;

		default :
		echo"
		<div class='col-xs-12'>
         <div class='box'>
            <div class='box-header'>
              <h3 class='box-title'>Barang</h3><br/>
			  <small>Halaman untuk update data barang</small><br/><br/>
			  <a href='index.php?page=barang&act=form' class='w3-btn w3-big w3-blue' style='font-size:16px'><i class='fa fa-file'></i> ADD DATA</a>
            </div>
            <div class='box-body'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
					<th>No</th>
						<th>KODE BARANG</th>
						<th>NAMA BARANG</th>
						<th>STOCK BARANG</th>
						<th>Action</th>
                </tr>
                </thead>
                <tbody>";
				$query = "SELECT * FROM barang ";
				$sql_kul = mysqli_query($conn, $query);
				$fd_kul = mysqli_num_rows($sql_kul);
				
				if($fd_kul > 0)
				{
					$no =  1;
					while ($m = mysqli_fetch_assoc($sql_kul)) {
						echo"<tr>
						
							<td>$no</td>
							<td>$m[kode_barang]</td>
							<td>$m[nama_barang]</td>
							<td>$m[stock_barang]</td>
							<td><a href='index.php?page=barang&act=form&id=$m[idBarang]'><i class='fa fa-pencil-square w3-large w3-text-blue'></i></a> 
							<a href='$aksi?page=barang&act=hapus&id=$m[idBarang]' onclick=\"return confirm('Are You sure want to delete?');\"><i class='fa fa-trash w3-large w3-text-red'></i></a></td>
						
						</tr>";
						$no++;
					}
				}
				else
				{
					echo"<tr>
						<td colspan='5'><div class='w3-center'><i>Data Barang Not Found.</i></div></td>
					</tr>";
				}
				
				
                echo "</tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
          </div>
        </div>";

		break;
	}

	
?>