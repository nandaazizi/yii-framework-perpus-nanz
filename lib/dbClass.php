<?php

//1. Coding Koneksi

class dbClass
{
	protected $namatabel;
	protected $data = [];
	protected $mysqli;
	public $pk;
	public $isLoad=false;
	protected $field = [
		'pk'=>'kd_pakaian',
		'nm_pakaian',
		'hrg_pakaian',
		'gmbr_pakaian',
	];

	public function __construct()
	{
		$this->pk = $this->field['pk'];
		$conf = $GLOBALS['conf'];
		$this->mysqli = mysqli_connect(
			$conf['host'],
			$conf['user'],
			$conf['pass'],
			$conf['db']
		);
	}
	public function __set($name, $value)
	{
		if ($name == "tabel") {
			$this->namatabel = $value;
		} else if ($name == "attributes") {			
			foreach($value as $nama=>$nilai)
				if($nilai!='')
					$this->data[$nama] = $nilai;
		} else {
			if($value!='')
				$this->data[$name] = $value;
		}
	}

	public function __get($name)
	{
		if ($name == "tabel") {
			return $this->namatabel;
		} else if ($name == "attributes") {
			return $this->data;
		} else {
			if (isset($this->data[$name])) {
				return $this->data[$name];
			}
		}
	}

	public function execute($sql)
	{
		$hasil = $this->mysqli->query($sql);
		if ($this->mysqli->error != '') {
			echo $sql;
			die($this->mysqli->error);
		}
		return $hasil;
	}

	public static function loads($sql=''){
		$md = new static();
		if($sql=='')
			$sql = "SELECT * FROM ".$md->tabel;
		//echo $sql;
		$hasil = $md->execute($sql);
		$data = $hasil->fetch_all(MYSQLI_ASSOC);
		$return = [];
		//$class = get_called_class();
		foreach($data as $index => $m){
			$return[$index]=new static();
			$return[$index]->attributes=$m;			
		}
		return $return;
	}

	public function load()
	{
		$id = $this->pk;
		$sql = "SELECT * FROM $this->namatabel
		WHERE " . $this->pk . "='" . $this->$id . "';";

		$hasil = $this->execute($sql);
		if($hasil->num_rows>0){
			$this->isLoad=true;
			$this->data = $hasil->fetch_assoc();
		}
	}
	public function hapus()
	{
		$id = $this->pk;
		$sql = "DELETE FROM $this->namatabel
		WHERE " . $this->pk . "='" . $this->$id . "';";
		$this->execute($sql);
	}
	public function save()
	{
		$isi_data = [];
		$dimana = '';
		$id = $this->pk;
		if($this->$id!=''){
			$dimana = "$id = '".$this->$id."'";
		}
		
		foreach ($this->data as $key => $value) {
			if (in_array($key, $this->field))
				$isi_data[] = "`$key` = '$value'";
		}
		$isi = implode(',', $isi_data);

		if ($this->isLoad) {
			$sql = "UPDATE $this->namatabel SET $isi WHERE 
			$dimana";
		} else {
			$sql = "INSERT INTO $this->namatabel SET $isi";
		}
		//echo $sql;
		$this->execute($sql);
	}
}
