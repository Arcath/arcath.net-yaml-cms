<?php
//Arcath.net CMS  Module
function output(){
	global $config, $pages, $ums, $blog, $user, $coms, $editor;
	//First Requirements (Components)
	$error="";
	foreach($pages['pageman']['reqs'] as $req){
		if(!in_array($req,$config['coms'])){
			$error.="Component: ".$req." is missing<br>";
		}
	}
	if($error!=""){
		$out=$error;
	}else{
		if(!in_array($user['id'],$coms['pageman']['admins'])){
			$out="You are not a page manager";
		}else{
			$out='<h1>Page Manager</h1><h2>Loaded Pages</h2>';
			foreach($config['loadedpages'] as $page){
				$out.='<a href="?var=pageedit&page='.$page.'">'.$pages[$page]['name'].'</a><br />';
			}
			$out.='<h2>UnLoaded Pages</h2>';
			foreach($config['unloadedpages'] as $page){
				$out.=$page.'<br />';
			}
		}
	}
	return $out;
}
?>
