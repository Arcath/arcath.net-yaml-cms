<?php
//Arcath.net CMS UMS Logout Module
function output(){
	global $config, $pages, $ums;
	//First Requirements (Components)
	$error="";
	foreach($pages['logout']['reqs'] as $req){
		if(!in_array($req,$config['coms'])){
			$error.="Component: ".$req." is missing<br>";
		}
	}
	if($error!=""){
		$out=$error;
	}else{
		$out=$ums->logout();
	}
	return $out;
}
?>
