<?php 
class Buku extends dbClass{
	protected $namatabel="buku";
	protected $field=[
		'pk'=>'id', 
		'judul', 
		'pengarang', 
		'tahun',
        'penerbit',
        'gambar',
	];	
}
