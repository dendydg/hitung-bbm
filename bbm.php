<?php
$hbensin=6500;
$hsolar=6000;
$hminyak=3000;
$bensin=null;
$solar=null;
$minyak=null;
$akhir=10;
$awal=1;

//untuk populasi option select html
function opsiselect($jml){
	echo "<option value=1 selected>1</option>";
	for($i=2;$i<=$jml;$i++){
		echo "<option value=$i>$i</option>";
	}
}

//untuk menghitung harga berdasarkan jumlah liter dan tipe barang
function hitung($tipe,$jml) {
global $hbensin,$hsolar,$hminyak,$akhir;
	if($tipe=='Bensin'){
		$harga = $hbensin;
	}elseif($tipe=='Solar'){
		$harga = $hsolar;
	}else{
		$harga = $hminyak;
	}
	$total = $harga * $jml;
	
	return $total;
}

//untuk menampilkan isi tabel
function isinya() {
global $awal, $akhir;
  $args = func_get_args();
  echo "<tr><td>Liter</th>"; //untuk header tabel
  foreach($args as $arg) {
  	if(!empty($arg))
    	echo "<th>$arg</th>";
  }
  echo "</tr>";
  
  //isi tabel
  for($i=$awal;$i<=$akhir;$i++){
  	echo "<tr><td>$i</td>";
  	foreach($args as $arg) {
  		if(!empty($arg))
    		echo "<td>".hitung($arg,$i)."</td>";
  	}
  	echo "</tr>";
  }
}

?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table border="1" cellpadding="5" cellspacing="0" align="center">
	<tr>
		<th>Liter Awal</th>
		<th>Liter Akhir</th>
		<th>Bensin (<?php echo $hbensin; ?>)</th>
		<th>Solar (<?php echo $hsolar; ?>)</th>
		<th>Minyak Tanah (<?php echo $hminyak; ?>)</th>
	</tr>
	
	<tr>
		<td><select name="awal"><?php opsiselect(20); ?></select></td>
		<td><select name="akhir"><?php opsiselect(20); ?></select></td>
		<td><input type="checkbox" name="bensin" value="1"></td>
		<td><input type="checkbox" name="solar" value="1"></td>
		<td><input type="checkbox" name="minyak" value="1"></td>
	</tr>
	
	<tr>
		<td colspan="5"><input type="submit" name="hitung-form" value="Tampilkan"></td>
	</tr>
</table>
</form>

<hr>

<?php if(isset($_POST['hitung-form'])): ?>
	<table border="1" cellpadding="5" cellspacing="0" align="center">
	<?php
		$valid=false;
		if(!empty($_POST['bensin'])){
			$bensin = $_POST['bensin'] ? 'Bensin': null;$valid=true;}
			
		if(!empty($_POST['solar'])){
			$solar = $_POST['solar'] ? 'Solar':'';$valid=true;}
		
		if(!empty($_POST['minyak'])){
			$minyak = $_POST['minyak'] ? 'Minyak':'';$valid=true;}
			
		$start = $_POST['akhir'];
		$end = $_POST['awal'];
		if($start < $end){
			$awal=$start;
			$akhir=$end;
		}elseif($start > $end){
			$awal=$end;
			$akhir=$start;
		}else{
			$awal=$start;
			$akhir=$start;
		}
		//var_dump($valid);die();
		
		if($valid){
			isinya($bensin,$solar,$minyak); 
		}else{
			echo "<tr><td>Anda Harus memilih sedikitnya satu tipe produk</td></tr>";
		}
	?>
	</table>
<?php else: ?>
	<table border="1" cellpadding="5" cellspacing="0" align="center">
	<?php isinya('Bensin','Solar','Minyak'); ?>
	</table>
<?php endif; ?>
