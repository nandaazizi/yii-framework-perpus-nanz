<?php

//Coding CRUD

require_once 'lib/config.php';
$classname = "Pegawai";
$filename  = substr(basename(__FILE__),0,-4);
//Helper::kelolagambar('BarangGambar','gambar');
Helper::controller($classname,$filename,[
	'#super_user'=>'hapus,edit,tambah,tabel',
	'#admin'=>'hapus,edit,tambah,tabel',
	'#member'=>'tabel',
]);



function form($data){
	?>
	<form method="post" enctype="multipart/form-data">
	<?=Helper::input($data,'Nama','nama'); ?>
	<?=Helper::input($data,'Alamat','alamat'); ?>
	<?=Helper::input($data,'No HP','no_hp'); ?>
	<?=Helper::input($data,'Posisi','posisi'); ?>
	<input type="submit"  class="btn btn-primary" name="simpan" value="Simpan">
<a class="btn btn-primary" href="?modul=pegawai">Kembali</a>		
	</form>
	<?php
}

function tabel($classname){
	global $filename;
	$coba = $classname::loads();
	echo '<a class="btn btn-primary" href="?modul='.$filename.'&act=tambah">Tambah</a>';
	Helper::ghost(
		[
			'id'=>['header'=>'ID'],
			'nama'=>['header'=>'Nama'], 
			'alamat'=>['header'=>'Alamat'], 
			'no_hp'=>['header'=>'No HP'], 
			'posisi'=>['header'=>'Posisi'],
		], 
		$coba,$filename
	);
}
?>