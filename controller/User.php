<style>
	.img{width:100px;height:100px;}
</style>
<?php

//Coding CRUD

require_once 'lib/config.php';
$classname = "User";
$filename  = substr(basename(__FILE__),0,-4);
//Helper::kelolagambar('BarangGambar','gambar');
Helper::controller($classname,$filename,[
	'#super_user'=>'hapus,edit,tambah,tabel',
	'#admin'=>'hapus,edit,tambah,tabel',
]);



function form($data){
	?>
	<form method="post" enctype="multipart/form-data">
<?=Helper::input($data,'Nama','nama'); ?>
<?=Helper::input($data,'ID','username'); ?>
<?=Helper::input($data,'Password','password'); ?>
<?=Helper::select($data,'Group','level',[
	'admin'=>'admin',
	'super_user'=>'super_user',
	'member'=>'member',
]); ?>
<input type="submit" class="btn btn-primary" name="simpan" value="Simpan">		
	</form>
	<?php
}

function tabel($classname){
	global $filename;
	$coba = $classname::loads();
	echo '<a class="btn btn-primary" href="?modul='.$filename.'&act=tambah">Tambah</a>';
	Helper::tabel(
		[
			'username'=>['header'=>'ID'], 
			'nama'=>['header'=>'Nama'],
			'password'=>['header'=>'Password'],
			'level'=>['header'=>'Group'],
		], 
		$coba,$filename
	);
}
?>