<style>
	.img{width:100px;height:100px;}
</style>
<?php

//Coding CRUD

require_once 'lib/config.php';
$classname = "User";
$filename  = substr(basename(__FILE__),0,-4);
//Helper::kelolagambar('BarangGambar','gambar');
if(!isset($_POST['data'])){	
	$data = new User();
	form($data);
}
else{	
	//cek, username sudah ada?
	$data = new User();
	$data->username=$_POST['data']['username'];
	$data->load();
	echo $data->username;
	if($data->nama==''){	
		$data->attributes  = $_POST['data'];
		$data->level = 'member';
		$data->save();
		header('location: ?modul=login');
	}
	else{
		$data = new User();
		$data->attributes  = $_POST['data'];
		echo '<div class="alert alert-danger">Nama User ID sudah digunakan</div>';
	}
	
	form($data);
}


function form($data){
	?>
	<form method="post" enctype="multipart/form-data">
	<?=Helper::input($data,'ID User','username'); ?>
	<?=Helper::input($data,'Password','password'); ?>
	
	<?=Helper::input($data,'Nama','nama'); ?>
	<p> Sudah Punya Akun?
        <a href="?modul=login">Login di sini</a><br>
<input class="btn btn-success" type="submit" name="simpan" value="Simpan">		
	</form>
	<?php
}

?>