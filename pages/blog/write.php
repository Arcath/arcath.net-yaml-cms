<?php
//Arcath.net CMS  Module
function output(){
	global $config, $pages, $ums, $blog, $user, $coms, $editor;
	//First Requirements (Components)
	$error="";
	foreach($pages['blogwrite']['reqs'] as $req){
		if(!in_array($req,$config['coms'])){
			$error.="Component: ".$req." is missing<br>";
		}
	}
	if($error!=""){
		$out=$error;
	}else{
		if(!in_array($user['id'],$coms['blog']['writers'])){
			$out="You are not a blog writer";
		}else{
			$out='<h1>Write a Blog post</h1><form action="index.php?var=blogsub" method="POST">Title: <input type="text" name="title" id="title" size="20" maxchars="255" />';
			$out.=$editor->disp(70,15,'post','');
			$out.='<input type="submit" value="Post" /></form>';
		}
	}
	return $out;
}
?>
