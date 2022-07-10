<?php 
class User extends dbClass{
	protected $namatabel="users";
	protected $field=[
		'pk'=>'username', 
		'password', 
		'level', 
		'nama',
	];	
}
