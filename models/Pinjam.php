<?php 
class Pinjam extends dbClass{
	protected $namatabel="pinjam";
	protected $field=[
		'pk'=>'id_pinjam',
        'nama_yang_minjam',
        'nama_buku_yang_di_pinjam',
        'tgl_pinjam_buku',
        'tgl_batas_pinjam',	
        'tgl_kembali_buku',	
	];	
}

?>