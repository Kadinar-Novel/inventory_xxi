<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
		
	}

	//link buat paging
	$idPegawai = $_SESSION['id_pegawai'];
	if($_SESSION['level']=='Manager'){
		$namaManager = $_SESSION['nama'];
	}else{
		$namaManager = '';
	}
	$linkaksi = 'index.php?page=pemesanan';

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act=$act';
	}
	else
	{
		$act = '';
	}

	$aksi = 'pages/pemesanan/act_pemesanan.php';
?>
<script src="dist/js/jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	    $("#btn1").click(function(){
			var nilai = parseInt($("#count").val())+1;
			$("#count").val(nilai);

	        $("#plus").append("<tr><td><button type='button' onClick=\"popup("+nilai+")\">...</button><input type='hidden' name='idBarang[]' value='' id='idBarang"+nilai+"'><input type='text' name='kodeBarang[]' value='' id='kodeBarang"+nilai+"'></td><td><input type='text' name='nama_barang[]' class='w3-input' placeholder='Nama Barang' value='' id='namaBarang"+nilai+"'></td><td><input type='text' name='qty[]' class='w3-input' placeholder='Jumlah' id='qty"+nilai+"' required></td></tr>");
	    });   

	});

	function popup(isi) {
		window.open('pages/pemesanan/get_detail.php?idKe='+isi, 'Data Barang', 'top=0, left=0,location=1,status=1,scrollbars=1,width=875,height=200,menubar=no,toolbar=no'); 
	}

	function selectText(value){
			var newValue=value.split("_");
			document.getElementById('idBarang'+newValue[0]).value = newValue[1] ;	
			document.getElementById('kodeBarang'+newValue[0]).value = newValue[2] ;	
			document.getElementById('namaBarang'+newValue[0]).value = newValue[3] ;	
	}
</script>
<?php
	switch ($act) {
		case 'form':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?page=pemesanan&act=edit";
				$query = mysqli_query($conn, "SELECT * FROM pemesanan a inner join pegawai b on a.idPegawai_mengajukan=b.idPegawai WHERE idPemesanan = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:index.php?page=pemesanan");
				}

			}
			else
			{
				$act = "$aksi?page=pemesanan&act=simpan";
				$yearNow = date('Y', strtotime('now'));
				$query = "SELECT kode_pemesanan as maxKode FROM pemesanan where year(tanggal_pemesanan)='$yearNow' order by idPemesanan desc";
				$hasil = mysqli_query($conn,$query);
				$data = mysqli_fetch_array($hasil);
				$kodeInv = $data['maxKode'];
				$noUrut = (int) substr($kodeInv, 9, 4);
				$noUrut++;
				$char = "XXIORDER-";
				$kodeInv = $char . sprintf("%04s", $noUrut);
			}

		echo"<div class='col-md-12'>
          <div class='box box-primary'>
            <div class='box-header with-border'>
              <h3 class='box-title'> Pemesanan</h3>
			</div>";
			
            echo"<form role='form'  method='POST' action='$act' enctype='multipart/form-data' >
              <div class='box-body'>
                <div class='form-group'>
                  
                  <input type='hidden' class='form-control' name='id' value='"?><?php echo isset($c['idPemesanan']) ? $c['idPemesanan'] : '';?><?php echo"'"?> <?php echo isset($c['idPemesanan']) ? ' readonly' : ' ';?><?php echo" >
                  <input type='hidden' class='form-control' name='idPegawai_mengajukan' value='"?><?php echo isset($c['idPegawai_mengajukan']) ? $c['idPegawai_mengajukan'] : $idPegawai;?><?php echo"'"; echo" >
				</div>
				<div class='form-group'><label >TANGGAL PEMESANAN</label>
					<input type='text' class='form-control' placeholder='Tanggal Pemesanan' name='tanggal_pemesanan' value='"?><?php echo isset($c['tanggal_pemesanan']) ? $c['tanggal_pemesanan'] : date('Y-m-d'); echo"'"; echo" id='datepicker'>
				</div>
				<div class='form-group'><label >KODE PEMESANAN</label>
					<input type='text' class='form-control' placeholder='Tanggal Pemesanan' name='kode_pemesanan' value='"?><?php echo isset($c['kode_pemesanan']) ? $c['kode_pemesanan'] : $kodeInv; echo"'"; echo">
				</div>
				";
					if(!empty($c['idPemesanan'])){
						echo "
					<div>
						<table id='plus'>	
							<tr>
								<td><label class='w3-label'>Kode Barang</label></td>
								<td><label class='w3-label'>Nama Barang</label></td>
								<td><label class='w3-label'>Jumlah Keluar Barang</label></td>
							</tr>
						";
						$selDetail = "select * from pemesanan a inner join barang b on a.idBarang=b.idBarang where idPemesanan = '".$c['idPemesanan']."'";
						$queryDetail = mysqli_query($conn, $selDetail);
						while($dataDetail = mysqli_fetch_array($queryDetail)){
						echo "
							<tr>
								<td>
									<input type='hidden' name='idBarang[]' value='".$dataDetail['idBarang']."' id='idBarang1'>
									<input type='text' name='kode_barang[]' class='w3-input' placeholder='Kode Barang Barang' value='".$dataDetail['kode_barang']."' id='kodeBarang1'>
								</td>
								<td>
									<input type='text' name='nama_barang[]' class='w3-input' placeholder='Nama Barang' value='".$dataDetail['nama_barang']."' id='namaBarang1'>
								</td>
								<td>
									<input type='text' name='qty[]' class='w3-input' placeholder='Jumlah' value='".$dataDetail['qty']."' required>
								</td>
							</tr>	
						";
						}
						echo "				
						</table>	
					</div>
						";
					}else {
					echo "
					<div>
					<b>Input Barang</b> <br/><br/>
						<table id='plus'>	
							<tr>
								<td><label class='w3-label'>Kode Barang</label></td>
								<td><label class='w3-label'>Nama Barang</label></td>
								<td><label class='w3-label'>Jumlah Pesan Barang</label></td>
							</tr>
							<tr>
								<td>
									<button type='button' onClick=\"popup(1)\">...</button>
									<input type='hidden' name='idBarang[]' value='' id='idBarang1'>
									<input type='text' name='kode_barang[]' class='w3-input' placeholder='Kode Barang Barang' value='' id='kodeBarang1'>
								</td>
								<td>
									<input type='text' name='nama_barang[]' class='w3-input' placeholder='Nama Barang' value='' id='namaBarang1'>
								</td>
								<td>
									<input type='text' name='qty[]' class='w3-input' placeholder='Jumlah' value='' required>
								</td>
							</tr>					
						</table>	
						<table>
							<tr>
								<td align='right' ><input type='button' value='Tambah Barang' id='btn1'></td>
							</tr>
						</table>
						<input type='hidden' id='count' value='1'/>
					</div>
					";
				}
				echo "
					<div class='form-group'><label >NAMA MANAGER</label>
						<input type='hidden' class='form-control' placeholder='IdPegawai Approve' name='idPegawai_approve' value='"?><?php echo isset($c['idPegawai_approve']) ? $c['idPegawai_approve'] : '';?><?php echo"'"?> <?php echo isset($c['idPegawai_approve']) ? ' ' : ' ';?><?php echo" >

						<input type='text' class='form-control' placeholder='Nama Manager' name='nama_pegawai' value='"?><?php echo isset($c['nama_pegawai']) ? $c['nama_pegawai'] : $namaManager;?><?php echo"'"; echo" >
					</div>
					<div class='form-group'><label >APPROVE MANAGER</label>
						<select name='approve_manager' class='form-control'>
							<option value='0' "; if($c['approve_manager']=='0'){echo 'selected';} echo">Belum Di Approve</option>
							<option value='1' "; if($c['approve_manager']=='1'){echo 'selected';} echo">Sudah Di Approve</option>
						</select>
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
              <h3 class='box-title'>Pemesanan</h3><br/>
			  <small>Halaman untuk update pemesanan barang</small><br/><br/>
			  <a href='index.php?page=pemesanan&act=form' class='w3-btn w3-big w3-blue' style='font-size:16px'><i class='fa fa-file'></i> ADD DATA</a>
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
				$query = "SELECT * FROM pemesanan ";
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
							<td><a href='index.php?page=pemesanan&act=form&id=$m[idPemesanan]'><i class='fa fa-pencil-square w3-large w3-text-blue'></i></a> 
							<a href='$aksi?page=pemesanan&act=hapus&id=$m[idPemesanan]' onclick=\"return confirm('Are You sure want to delete?');\"><i class='fa fa-trash w3-large w3-text-red'></i></a></td>
						
						</tr>";
						$no++;
					}
				}
				else
				{
					echo"<tr>
						<td colspan='5'><div class='w3-center'><i>Data Pemesanan Not Found.</i></div></td>
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