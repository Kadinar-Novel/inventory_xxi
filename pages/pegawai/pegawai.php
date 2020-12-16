<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	//link buat paging
	$linkaksi = 'index.php?page=pegawai';

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act=$act';
	}
	else
	{
		$act = '';
	}

	$aksi = 'pages/pegawai/act_pegawai.php';

	switch ($act) {
		case 'form':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?page=pegawai&act=edit";
				$query = mysqli_query($conn, "SELECT * FROM pegawai a left join user b on a.idPegawai=b.idPegawai WHERE a.idPegawai = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:index.php?page=pegawai");
				}

			}
			else
			{
				$act = "$aksi?page=pegawai&act=simpan";
			}

		echo"<div class='col-md-12'>
          <div class='box box-primary'>
            <div class='box-header with-border'>
              <h3 class='box-title'> Pegawai</h3>
			</div>";
			
            echo"<form role='form'  method='POST' action='$act' enctype='multipart/form-data' >
              <div class='box-body'>
                <div class='form-group'>
                  
                  <input type='hidden' class='form-control' name='id' value='"?><?php echo isset($c['idPegawai']) ? $c['idPegawai'] : '';?><?php echo"'"?> <?php echo isset($c['idPegawai']) ? ' readonly' : ' ';?><?php echo" >
								</div>
					<div class='form-group'><label >KODE PEGAWAI</label>
					<input type='text' class='form-control' placeholder='Kode Pegawai' name='kode_pegawai' value='"?><?php echo isset($c['kode_pegawai']) ? $c['kode_pegawai'] : '';?><?php echo"'"?> <?php echo isset($c['kode_pegawai']) ? ' ' : ' ';?><?php echo" >
										</div>
					<div class='form-group'><label >NAMA PEGAWAI</label>
					<input type='text' class='form-control' placeholder='Nama Pegawai' name='nama_pegawai' value='"?><?php echo isset($c['nama_pegawai']) ? $c['nama_pegawai'] : '';?><?php echo"'"?> <?php echo isset($c['nama_pegawai']) ? ' ' : ' ';?><?php echo" >
										</div>
					<div class='form-group'><label >ALAMAT</label>
					<input type='text' class='form-control' placeholder='Alamat' name='alamat' value='"?><?php echo isset($c['alamat']) ? $c['alamat'] : '';?><?php echo"'"?> <?php echo isset($c['alamat']) ? ' ' : ' ';?><?php echo" >
										</div>
					<div class='form-group'><label >TELEPON</label>
					<input type='text' class='form-control' placeholder='Telepon' name='telepon' value='"?><?php echo isset($c['telepon']) ? $c['telepon'] : '';?><?php echo"'"?> <?php echo isset($c['telepon']) ? ' ' : ' ';?><?php echo" >
										</div>
					<div class='form-group'><label >LEVEL</label>
						<select name='jabatan' class='form-control'>
							<option value=''>Silahkan Pilih</option>
							<option value='Admin' "; if($c['jabatan']=='Admin'){echo 'selected';} echo">Admin</option>
							<option value='Bagian Umum' "; if($c['jabatan']=='Bagian Umum'){echo 'selected';} echo">Bagian Umum</option>
							<option value='Manager' "; if($c['jabatan']=='Manager'){echo 'selected';} echo">Manager</option>
						</select>
					</div>
					<div class='form-group'><label >USERNAME</label>
					<input type='text' class='form-control' placeholder='Username Pegawai' name='usernm' value='"?><?php echo isset($c['usernm']) ? $c['usernm'] : '';?><?php echo"'"?> <?php echo isset($c['usernm']) ? ' ' : ' ';?><?php echo" >
										</div>
					<div class='form-group'><label >PASSWORD</label>
					<input type='password' class='form-control' placeholder='Password Pegawai' name='password' value='"?><?php echo isset($c['passwd']) ? $c['passwd'] : '';?><?php echo"'"?> <?php echo isset($c['passwd']) ? ' ' : ' ';?><?php echo" onkeyup='pass()' id='pass1'>

					<input type='hidden' name='passwd'  value='' id='pass2'>
										</div>
					<div class='box-footer'>
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
              <h3 class='box-title'>Pegawai</h3><br/>
			  <small>Halaman untuk update data pegawai</small><br/><br/>
			  <a href='index.php?page=pegawai&act=form' class='w3-btn w3-big w3-blue' style='font-size:16px'><i class='fa fa-file'></i> ADD DATA</a>
            </div>
            <div class='box-body'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
					<th>No</th>
						<th>KODE PEGAWAI</th>
						<th>NAMA PEGAWAI</th>
						<th>ALAMAT</th>
						<th>TELEPON</th>
						<th>LEVEL</th>
						<th>Action</th>
                </tr>
                </thead>
                <tbody>";
				$query = "SELECT * FROM pegawai ";
				$sql_kul = mysqli_query($conn, $query);
				$fd_kul = mysqli_num_rows($sql_kul);
				
				if($fd_kul > 0)
				{
					$no =  1;
					while ($m = mysqli_fetch_assoc($sql_kul)) {
						echo"<tr>
							
							<td>$no</td>
							<td>$m[kode_pegawai]</td>
							<td>$m[nama_pegawai]</td>
							<td>$m[alamat]</td>
							<td>$m[telepon]</td>
							<td>$m[jabatan]</td>
							<td><a href='index.php?page=pegawai&act=form&id=$m[idPegawai]'><i class='fa fa-pencil-square w3-large w3-text-blue'></i></a> 
							<a href='$aksi?page=pegawai&act=hapus&id=$m[idPegawai]' onclick=\"return confirm('Are You sure want to delete?');\"><i class='fa fa-trash w3-large w3-text-red'></i></a></td>
						
						</tr>";
						$no++;
					}
				}
				else
				{
					echo"<tr>
						<td colspan='7'><div class='w3-center'><i>Data Pegawai Not Found.</i></div></td>
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
<script type="text/javascript">
	function pass()
	{
		document.getElementById('pass2').value=document.getElementById('pass1').value;
	}
</script>