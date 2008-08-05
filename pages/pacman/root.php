<?php
//Arcath.net CMS  Module
function output(){
	global $config, $pages, $ums, $blog, $user, $coms, $editor;
	//First Requirements (Components)
	$error="";
	foreach($pages['pacman']['reqs'] as $req){
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
			$out="<h1>Package Manager</h1>";
			foreach($config['coms'] as $com){
				$out.='<a href="?var=pacedit&pac='.$com.'">'.$coms[$com]['name'].'</a><br />';
			}
		}
	}
	return $out;
}
?>
