<?php

//Coding CRUD

require_once 'lib/config.php';
$classname = "Pinjam";
$filename  = substr(basename(__FILE__),0,-4);
//Helper::kelolagambar('BarangGambar','gambar');
Helper::controller($classname,$filename,[
	'#super_user'=>'hapus,edit,tambah,tabel',
	'#admin'=>'hapus,edit,tambah,tabel',
	'#member'=>'tambah,edit,tabel',
]);



function form($data){
	?>
	<form method="post" enctype="multipart/form-data">
	<?=Helper::input($data,'Nama','nama_yang_minjam'); ?>
	<?=Helper::dd(
                    $data,
                    'Nama Buku',
                    'nama_buku_yang_di_pinjam',
                    [
                        'Laskar Pelangi' => 'Laskar Pelangi',
                        'Bumi Manusia' => 'Bumi Manusia',
                        '5 cm' => '5 cm',
						'Sang Pemimpi' => 'Sang Pemimpi',
						'Perahu Kertas' => 'Perahu Kertas',
						'Cedera Kepala' => 'Cedera Kepala',
						'Cinta Brontosaurus' => 'Cinta Brontosaurus',

                    ]
                ); ?>
	<?=Helper::input($data, 'Pinjam Buku', 'tgl_pinjam_buku', 'date'); ?>
	<input type="submit"  class="btn btn-primary" name="simpan" value="Simpan">
<a class="btn btn-primary" href="?modul=pinjam1">Kembali</a>
	</form>
	<?php
}

function tabel($classname){
	global $filename;
	$coba = $classname::loads();
	Helper::ghost(
		[
			'id_pinjam'=>['header'=>'ID'],
			'nama_yang_minjam'=>['header'=>'Nama'],
			'nama_buku_yang_di_pinjam'=>['header'=>'Buku'],
			'tgl_pinjam_buku'=>['header'=>'Pinjam Buku'], 
			'tgl_batas_pinjam'=>['header'=>'Batas Pinjam Buku'], 
			'tgl_kembali_buku'=>['header'=>'Kembalikan Buku'],
		], 
		$coba,$filename
	);
}
?>