<style>
	.img{width:100px;height:100px;}
</style>
<?php

//Coding CRUD

require_once 'lib/config.php';
$classname = "Buku";
$filename  = substr(basename(__FILE__),0,-4);
Helper::kelolagambar('gambar','gambar');
Helper::controller($classname,$filename,[
	'#super_user'=>'hapus,edit,tambah,tabel',
	'#admin'=>'hapus,edit,tambah,tabel',
	'#member'=>'tambah,tabel',
]);


function form($data){
	?>
	<form method="post" enctype="multipart/form-data">
<?=Helper::input($data,'Judul','judul'); ?>
<?=Helper::input($data,'Pengarang','pengarang'); ?>
<?=Helper::input($data,'Tahun','tahun'); ?>
<?=Helper::input($data,'Penerbit Buku','penerbit'); ?>
<?=Helper::image('Gambar','gambar'); ?>
<input type="submit"  class="btn btn-primary" name="simpan" value="Simpan">
<a class="btn btn-primary" href="?modul=buku">Kembali</a>		
	</form>
	<?php
}

function tabel($classname){
	global $filename;
	$coba = $classname::loads();
	Helper::tabelss(
		[
			'id'=>['header'=>'ID'], 
			'judul'=>['header'=>'Judul'],
			'pengarang'=>['header'=>'Pengarang'],
			'tahun'=>['header'=>'Tahun'],
			'penerbit'=>['header'=>'Penerbit'],
			'gambar'=>
				[
					'header'=>'Gambar',
					'tipe'=>'img'
				]
		], 
		$coba,$filename
	);
}
?>