<script language=javascript>
function selectTextPopUp(value){
window.opener.selectText(value);
window.self.close();
}
</script>
<table border=1 width="850">
	<tr>
		<th>
			Kode Barang
		</th>
		<th>
			Nama Barang
		</th>
		<th>
			Stok Barang
		</th>
		<th>
			Action
		</th>
	<tr>
<?php
include "../../lib/conn.php";
$idKe = $_GET['idKe'];
$sel2 = "SELECT * FROM barang order by kode_barang";
$que2 = mysqli_query($conn,$sel2);
while ($row = mysqli_fetch_array($que2)){
?>
	<tr>
		<td align='center'>
			<font size=2><?php echo $row['kode_barang'];?></font>
		</td>
		<td align="center">
			<font size=2><?php echo $row['nama_barang'];?></font>
		</td>
		<td align='center'>
			<font size=2><?php echo $row['stock_barang'];?></font>
		</td>
		<td align="center">
			<input type="button" onClick="javascript: selectTextPopUp('<?php echo $idKe.'_'.$row['idBarang'].'_'.$row['kode_barang'].'_'.$row['nama_barang'];?>')"  value="Pilih" />
		</td>
	</tr>
<?php } ?>
</table>