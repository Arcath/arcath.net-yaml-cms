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
			if(!$_GET['pac']){
				$out.='Please Go back and try again';
			}else{
				$com=$_GET['pac'];
				$content=Spyc::YAMLDump($coms[$com]);
				$out.='<form action="?var=pacsub" method="POST">
					<input type="hidden" value="'.$com.'" name="com" />
					<textarea name="yaml" id="yaml" cols="70" rows="15">'.str_replace("- --\n",'',$content).'</textarea><input type="submit" value="Save" /></form>';
			}
		}
	}
	return $out;
}
?>
