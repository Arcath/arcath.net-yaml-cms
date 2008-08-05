<?php
//Arcath.net CMS Forums Module
function output(){
	global $config, $pages;
	//First Requirements (Components)
	$error="";
	foreach($pages['forums']['reqs'] as $req){
		if(!in_array($req,$config['coms'])){
			$error.="Component: ".$req." is missing<br>";
		}
	}
	if($error!=""){
		$out=$error;
	}else{
		$out="FORUMS";
	}
	return $out;
}
?>
