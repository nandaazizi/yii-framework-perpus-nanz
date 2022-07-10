<?php

//Coding CRUD
$filename  = substr(basename(__FILE__),0,-4);
if(isset($_GET['act']) && $_GET['act']=='logout'){
	session_destroy();
	header('Location: ?');
}
if(isset($_POST['data'])){
	$login = $_POST['data'];
	
	$data = new User();
	$data->username=$login['username'];
	$data->load();
	if($data->password==$login['password']
		&& $data->password!=''
	){
		$_SESSION['user']=$data->username;
		$_SESSION['nama']=$data->nama;
		$_SESSION['group']=$data->level;
		header('Location: ?');
	}
}
form();

function form(){
	$data=new User()
	?>
	<form method="post">
<?=Helper::input($data,'Username','username'); ?>
<?=Helper::input($data,'Password','password','password'); ?>
<input type="submit" class="btn btn-primary" name="simpan" value="Login">	
        <a class="btn btn-primary" href="?modul=daftar">Daftar</a>
		
	</form>
	<?php
}
?>