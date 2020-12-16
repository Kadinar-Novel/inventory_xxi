<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	//link buat paging
	$linkaksi = 'index.php?page=penerimaan';

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act=$act';
	}
	else
	{
		$act = '';
	}

	$aksi = 'pages/penerimaan/act_penerimaan.php';

	switch ($act) {
		case 'form':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?page=penerimaan&act=edit";
				$query = mysqli_query($conn, "SELECT * FROM penerimaan WHERE idPemesanan = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:index.php?page=penerimaan");
				}

			}
			else
			{
				$act = "$aksi?page=penerimaan&act=simpan";
			}

		echo"<div class='col-md-12'>
          <div class='box box-primary'>
            <div class='box-header with-border'>
              <h3 class='box-title'> Penerimaan</h3>
			</div>";
			
            echo"<form role='form'  method='POST' action='$act' enctype='multipart/form-data' >
              <div class='box-body'>
                <div class='form-group'>
                  
                  <input type='hidden' class='form-control' name='id' value='"?><?php echo isset($c['idPemesanan']) ? $c['idPemesanan'] : '';?><?php echo"'"?> <?php echo isset($c['idPemesanan']) ? ' readonly' : ' ';?><?php echo" >
								</div>
					<div class='form-group'><label >IDPEGAWAI MENGAJUKAN</label>
					<input type='text' class='form-control' placeholder='IdPegawai Mengajukan' name='idPegawai_mengajukan' value='"?><?php echo isset($c['idPegawai_mengajukan']) ? $c['idPegawai_mengajukan'] : '';?><?php echo"'"?> <?php echo isset($c['idPegawai_mengajukan']) ? ' ' : ' ';?><?php echo" >
										</div>
					<div class='form-group'><label >IDPEGAWAI APPROVE</label>
					<input type='text' class='form-control' placeholder='IdPegawai Approve' name='idPegawai_approve' value='"?><?php echo isset($c['idPegawai_approve']) ? $c['idPegawai_approve'] : '';?><?php echo"'"?> <?php echo isset($c['idPegawai_approve']) ? ' ' : ' ';?><?php echo" >
										</div>
					<div class='form-group'><label >TANGGAL PEMESANAN</label>
					<input type='text' class='form-control' placeholder='Tanggal Pemesanan' name='tanggal_pemesanan' value='"?><?php echo isset($c['tanggal_pemesanan']) ? $c['tanggal_pemesanan'] : '';?><?php echo"'"?> <?php echo isset($c['tanggal_pemesanan']) ? ' ' : ' ';?><?php echo" >
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
              <h3 class='box-title'>Penerimaan</h3><br/>
			  <small>Halaman untuk update penerimaan barang</small><br/><br/>
			  <a href='index.php?page=penerimaan&act=form' class='w3-btn w3-big w3-blue' style='font-size:16px'><i class='fa fa-file'></i> ADD DATA</a>
            </div>
            <div class='box-body'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
					<th>No</th>
						<th>IDPEGAWAI MENGAJUKAN</th>
						<th>IDPEGAWAI APPROVE</th>
						<th>TANGGAL PEMESANAN</th>
						<th>Action</th>
                </tr>
                </thead>
                <tbody>";
				$query = "SELECT * FROM penerimaan ";
				$sql_kul = mysqli_query($conn, $query);
				$fd_kul = mysqli_num_rows($sql_kul);
				
				if($fd_kul > 0)
				{
					$no =  1;
					while ($m = mysqli_fetch_assoc($sql_kul)) {
						echo"<tr>
						
							<td>$no</td>
							<td>$m[idPegawai_mengajukan]</td>
							<td>$m[idPegawai_approve]</td>
							<td>$m[tanggal_pemesanan]</td>
							<td><a href='index.php?page=penerimaan&act=form&id=$m[idPemesanan]'><i class='fa fa-pencil-square w3-large w3-text-blue'></i></a> 
							<a href='$aksi?page=penerimaan&act=hapus&id=$m[idPemesanan]' onclick=\"return confirm('Are You sure want to delete?');\"><i class='fa fa-trash w3-large w3-text-red'></i></a></td>
						
						</tr>";
						$no++;
					}
				}
				else
				{
					echo"<tr>
						<td colspan='5'><div class='w3-center'><i>Data Penerimaan Not Found.</i></div></td>
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