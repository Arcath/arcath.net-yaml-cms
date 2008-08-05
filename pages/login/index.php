<?php
//Arcath.net CMS UMS Login Module
function output(){
	global $config, $pages, $ums;
	//First Requirements (Components)
	$error="";
	foreach($pages['login']['reqs'] as $req){
		if(!in_array($req,$config['coms'])){
			$error.="Component: ".$req." is missing<br>";
		}
	}
	if($error!=""){
		$out=$error;
	}else{
		if(!isset($_POST['uname'])){
			$out=$ums->loginform();
		}else{
			$username=$_POST['uname'];
			$password=$_POST['pass'];
			$out=$ums->login($username,$password);
		}
	}
	return $out;
}
?>
