<?php
//Arcath.net CMS Forums Module
function output(){
	global $config, $pages, $ums;
	//First Requirements (Components)
	$error="";
	foreach($pages['register']['reqs'] as $req){
		if(!in_array($req,$config['coms'])){
			$error.="Component: ".$req." is missing<br>";
		}
	}
	if($error!=""){
		$out=$error;
	}else{
		if(!isset($_POST['uname'])){
			$out=$ums->regform();
		}else{
			$code=$_SESSION['code'];
			$img=$_POST['img'];
			$name=$_POST['uname'];
			$pass1=$_POST['pass1'];
			$pass2=$_POST['pass2'];
			$email1=$_POST['email1'];
			$email2=$_POST['email2'];
			echo($ums->register($name,$pass1,$pass2,$email1,$email2,$code,$img));
		}
	}
	return $out;
}
?>
