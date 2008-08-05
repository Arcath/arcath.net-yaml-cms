<?php
//Arcath.net DB CONNECTOR
Class db{
	function connect(){
		global $coms;
		mysql_connect($coms['db']['host'],$coms['db']['user'],$coms['db']['pass']);
		mysql_select_db($coms['db']['base']);
		return true;
	}

	function query($q){
		global $coms;
		$query=str_replace('{PREFIX}',$coms['db']['pref'],$q);
		$result=mysql_query($query);
		if(!$result){
			$result="MYSQL Error: ".mysql_error();
		}
		return $result;
	}
	function has($value,$field,$table){
		global $db;
		if(mysql_num_rows($db->query("SELECT * FROM `{PREFIX}$table` WHERE `$field` = '$value'"))==0){
			$out=false;
		}else{
			$out=true;
		}
		return $out;
	}
	function getvalue($field,$table,$idfield,$idvalue){
		global $db;
		$out=false;
		$result=$db->query("SELECT * FROM `{PREFIX}$table` WHERE `$idfield` = '$idvalue' LIMIT 1");
		while($row=mysql_fetch_array($result)){
			$out=$row[$field];
		}
		return $out;;
	}	
}
$db=new db;
$db->connect();
?>
