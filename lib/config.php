<?php 
session_start();
//1. konek
$conf = [
	"host"=>"localhost",
	"user"=>"root",
	"pass"=>"",
	"db"=>"perpustakaan"
];

spl_autoload_register(function($class) {
	$filename = "$class.php";
	if(is_file("lib/$filename"))
		include_once "lib/$filename";
	else if(is_file("models/$filename"))
		include_once "models/$filename";
});
?>