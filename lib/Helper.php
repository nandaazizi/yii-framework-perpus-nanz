<?php

//1. Coding Koneksi

class Helper
{
	
	public static function session($name){
		if(isset($_SESSION[$name])){
			return $_SESSION[$name];
		}
		return '';
	}

	public static function kelolagambar($attr,
									    $file_lokasi
	){
		if(isset($_FILES[$attr])){
			$file = $_FILES[$attr];
			$simpan = $file_lokasi.'/'.$file['name'];
			move_uploaded_file(
				$file['tmp_name'],
				$simpan
			);
			$_POST['data'][$attr]=$simpan;
		}
	}
	/* 
	$access = [
			'user'=>'hapus,edit,tambah,tabel',
			'#group'=>'hapus,edit,tambah,tabel',
			//'@'=>'hapus,edit,tambah,tabel',
			//'*'=>'hapus,edit,tambah,tabel',
		];
	*/
	public static function controller($classname,
									  $filename,
									  $access=['*'=>'hapus,edit,tambah,tabel']
		){
		
		$dbSaya = new $classname;
		$act = isset($_GET['act'])?$_GET['act']:'tabel';
		$id  = isset($_GET['id']) ?$_GET['id']:'';
		$pk = $dbSaya->pk;
		
		$user ='';
		$group = '';
		
		if(isset($_SESSION['user'])){
			$user  =$_SESSION['user'];
			$group =$_SESSION['group'];
		}
		
		$boleh = false;
		// boleh adalah bila $access ada yang pakai user 
		// isset($access[$user])=> true;
		// kemudian dicek apakah $access[$user]
		// memiliki kata $act
		$k1 = isset($access[$user]) && 
			  stripos($access[$user],$act)!==false;
		$k2 = isset($access['#'.$group]) && 
			  stripos($access['#'.$group],$act)!==false;
		$k3 = isset($user) && $user!='' && 
			  isset($access['@']) &&
			  stripos($access['@'],$act)!==false;
		$k4 = isset($access['*']) && stripos($access['*'],$act)!==false;

		$boleh = $k1 || $k2 || $k3 || $k4;



		if(!$boleh){
			echo '<h1 style="background:green">Tidak Boleh Masuk</h1>';
			return;
		}
		
		
		$dbSaya->$pk = $id;
		$dbSaya->load();

		if (isset($_POST['data'])) {
			$dbSaya->attributes  = $_POST['data'];
			$dbSaya->save();
			header('Location: ?modul='.$filename);
		}
		switch($act){
			case 'hapus' :
				$dbSaya->hapus();
				header('Location: ?modul='.$filename);
				break;
			case 'tambah':
			case 'edit'  :form($dbSaya);break;
			default:tabel($classname);
		}
	}
	
	public static function input($data,$label,$field,$type='text'){
		echo '
		<div class="form-group row">
			<div class="col-2">
				<label>'.$label.'</label>
			</div>
			<div class="col-6"><input class="form-control" type="'.$type.'" 
			value="'.$data->$field.'" 
				   name="data['.$field.']">
			</div>
		</div>
		';
	}
	public static function select($data,$label,$field,$dropdata){
		$option='';
		/*
		$dropdata = [
			'yes'=>'Aktif',
			'no'=>' Tidak Aktif'
		]
		*/
		$template = '<option value="%s">%s</option>';
		foreach($dropdata as $k=>$y){
			$option .=sprintf($template,$k,$y);
		}
		
		
		echo '
		<div class="form-group row">
			<div class="col-2">
				<label>'.$label.'</label>
			</div>
			<div class="col-6">
			<select name="data['.$field.']">
				'.$option.'
			</select>
			</div>
		</div>
		';
	}
	
	public static function image($label,$attr_name){
		
		return '
		<div class="form-group row">
			<div class="col-2">
				<label>'.$label.'</label>
			</div>
			<div class="col-6"><input class="form-control" type="file" 
			name="'.$attr_name.'">
			</div>
		</div>
		';
	}
	public static function ghost($header, $data,$modul)
	{
		echo "<table class=\"table\">\r\n";
		echo "<thead><tr>\r\n";
		foreach ($header as $key => $item) {
			echo "\t\t<th>" . $item['header'] . "</th>\r\n";
		}

		foreach ($data as $item) {
			echo "\t<tr>\r\n";
			foreach ($header as $key=>$isi) {
				if(isset($isi['tipe']) && $isi['tipe']=='img')
					echo "\t\t<td><img class=\"img\" src=\"".$item->$key."\"></td>\r\n";
				else
					echo "\t\t<td>" . $item->$key . "</td>\r\n";
			}
			$id = $item->pk;
			$id = $item->$id;
			echo "
		<td>
		</td>\r\n";
			echo "\t</tr>\r\n";
		}
		echo "</tbody>\r\n";
		echo "</table>\r\n";
	}
	public static function tabel($header, $data,$modul)
	{
		echo "<table class=\"table\">\r\n";
		echo "<thead><tr>\r\n";
		foreach ($header as $key => $item) {
			echo "\t\t<th>" . $item['header'] . "</th>\r\n";
		}
		echo "\t\t<th>Aksi</th>\r\n";
		echo "\t</tr>\r\n";
		echo "</thead>\r\n";
		echo "<tbody>\r\n";

		foreach ($data as $item) {
			echo "\t<tr>\r\n";
			foreach ($header as $key=>$isi) {
				if(isset($isi['tipe']) && $isi['tipe']=='img')
					echo "\t\t<td><img class=\"img\" src=\"".$item->$key."\"></td>\r\n";
				else
					echo "\t\t<td>" . $item->$key . "</td>\r\n";
			}
			$id = $item->pk;
			$id = $item->$id;
			echo "
		<td>
			<a class=\"btn btn-primary\" href=\"?modul=$modul&act=edit&id=$id\">Edit</a>
			<a class=\"btn btn-primary\" href=\"?modul=$modul&act=hapus&id=$id\">Hapus</a>
		</td>\r\n";
			echo "\t</tr>\r\n";
		}
		echo "</tbody>\r\n";
		echo "</table>\r\n";
	}

	public static function tabels($header, $data,$modul)
	{
		echo "<table class=\"table\">\r\n";
		echo "<thead><tr>\r\n";
		foreach ($header as $key => $item) {
			echo "\t\t<th>" . $item['header'] . "</th>\r\n";
		}
		echo "\t\t<th>Aksi</th>\r\n";
		echo "\t</tr>\r\n";
		echo "</thead>\r\n";
		echo "<tbody>\r\n";

		foreach ($data as $item) {
			echo "\t<tr>\r\n";
			foreach ($header as $key=>$isi) {
				if(isset($isi['tipe']) && $isi['tipe']=='img')
					echo "\t\t<td><img class=\"img\" src=\"".$item->$key."\"></td>\r\n";
				else
					echo "\t\t<td>" . $item->$key . "</td>\r\n";
			}
			$id = $item->pk;
			$id = $item->$id;
			echo "
		<td>
			<a class=\"btn btn-primary\" href=\"?modul=$modul&act=edit&id=$id\">Edit</a>
		</td>\r\n";
			echo "\t</tr>\r\n";
		}
		echo "</tbody>\r\n";
		echo "</table>\r\n";
	}
	public static function tabelss($header, $data,$modul)
	{
		echo "<table class=\"table\">\r\n";
		echo "<thead><tr>\r\n";
		foreach ($header as $key => $item) {
			echo "\t\t<th>" . $item['header'] . "</th>\r\n";
		}
		echo "\t\t<th>Aksi</th>\r\n";
		echo "\t</tr>\r\n";
		echo "</thead>\r\n";
		echo "<tbody>\r\n";

		foreach ($data as $item) {
			echo "\t<tr>\r\n";
			foreach ($header as $key=>$isi) {
				if(isset($isi['tipe']) && $isi['tipe']=='img')
					echo "\t\t<td><img class=\"img\" src=\"".$item->$key."\"></td>\r\n";
				else
					echo "\t\t<td>" . $item->$key . "</td>\r\n";
			}
			$id = $item->pk;
			$id = $item->$id;
			echo "
		<td>
			<a class=\"btn btn-primary\" href=\"?modul=pinjam1&&act=tambah\">Pinjam</a>
			
		</td>\r\n";
			echo "\t</tr>\r\n";
		}
		echo "</tbody>\r\n";
		echo "</table>\r\n";
	}
	public static function dd($data, $label, $field, $dropdata)
	{
		$option = '';
		$template = '<option value="%s">%s</option>';
		foreach ($dropdata as $k => $y) {
			$option .= sprintf($template, $k, $y);
		}


		echo '
		<div class="form-group row">
			<div class="col-2">
				<label>' . $label . '</label>
			</div>
			<div class="col-6">
			<select class="form-control" id="'.$field.'" name="data[' . $field . ']">
				' . $option . '
			</select>
			</div>
		</div>
		';
	}
}
