<?php
//Arcath.net CMS  Module
function output(){
	global $config, $pages, $ums, $blog, $user, $coms, $editor;
	//First Requirements (Components)
	$error="";
	foreach($pages['pacedit']['reqs'] as $req){
		if(!in_array($req,$config['coms'])){
			$error.="Component: ".$req." is missing<br>";
		}
	}
	if($error!=""){
		$out=$error;
	}else{
		if(!in_array($user['id'],$coms['pacman']['admins'])){
			$out="You are not a package manager";
		}else{
			$out="<h1>Package Manager - Edit</h1>";
			$com=$_POST['com'];
			$yaml=$_POST['yaml'];
			$file=fopen('components/'.$com.'.yaml','w');
			fwrite($file,$yaml);
			fclose($file);
		}
	}
	return $out;
}
?>
