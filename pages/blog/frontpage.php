<?php
//Arcath.net CMS UMS Login Module
function output(){
	global $config, $pages, $ums, $blog;
	//First Requirements (Components)
	$error="";
	foreach($pages['home']['reqs'] as $req){
		if(!in_array($req,$config['coms'])){
			$error.="Component: ".$req." is missing<br>";
		}
	}
	if($error!=""){
		$out=$error;
	}else{
		$out=$blog->disp(5);
	}
	return $out;
}
?>
