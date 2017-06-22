<?php
	if(empty($db)) $db = "coin";
	$sql = new PDO("mysql:host=localhost;dbname=$db", $user, $pass);
	$sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql->exec("set names utf8");
	
	function insert($table,$tuple,$data){
		global $sql;
		$tmp = "";
		for($i=0;$i < count($data);$i++){
			if($i != 0) $tmp .= ", ";
			$tmp .= "?";
		}
		try{
			$db  = $sql->prepare("insert into $table($tuple) values($tmp)");
			$db->execute($data);
			return true;
		}catch(PDOException $e){
				echo $e->getMessage();
		}
		return false;
	}
	
	function select($tuple,$table,$where,$data=NULL,$adm=NULL){
		if(isset($adm)) AccountDBAdmin();
		if(gettype($data) != "array"){
			$tmp = $data;
			$data = array($tmp);
			unset($tmp);
		}
		global $sql;
		if($tuple == "") $tuple = "*";
		try{
			$db  = $sql->prepare("select $tuple from $table where $where");
			$db->setFetchMode(PDO::FETCH_ASSOC);
			$db->execute($data);
			return (object) $db->fetch() ?? NULL;
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}
	function slist($tuple,$table,$where,$data=NULL){
		if(gettype($data) != "array"){
			$tmp = $data;
			$data = array($tmp);
			unset($tmp);
		}
		global $sql;
		$count = 0;
		if($tuple == "") $tuple = "*";
		try{
			$db  = $sql->prepare("select $tuple from $table where $where");
			$db->setFetchMode(PDO::FETCH_ASSOC);
			$db->execute($data);
			while($list = $db->fetch()){
				$row[$count++] = (object) $list;
			}
			return (object) ($row ?? NULL);
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}
	
	function update($table,$set,$where,$data=NULL,$adm=NULL){
		global $sql;
		if(isset($adm)) AccountDBAdmin();
		if(gettype($data) != "array"){
			$tmp = $data;
			$data = array($tmp);
			unset($tmp);
		}
		try{
			$db  = $sql->prepare("update $table set $set where $where");
			$db->execute($data);
			return true;
		}catch(PDOException $e){
				echo "<div class='err-box'>".$e->getMessage()."</div>";
		}
	}
	
	function delete($table,$where,$data=NULL){
		if(gettype($data) != "array"){
			$tmp = $data;
			$data = array($tmp);
			unset($tmp);
		}
		global $sql;
		$newset = "";
		$newwhere = "";
		try{
			$db  = $sql->prepare("delete from $table where $where");
			$db->execute($data);
			return true;
		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}
	
	

	//현재 시간에서(TIMESTAMP형식) 사용자가 입력한 시간만큼 계산하여 출력해준다.
	function strdate($type=NULL,$val=NULL){
		if(empty($val)) $val = 'Y-m-d H:i:s';
		$date = date($val,strtotime($type,time()));
		return $date;
	}