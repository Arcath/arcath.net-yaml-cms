<?php
//Arcath.net CMS  Module
function output(){
	global $config, $pages, $ums, $blog, $user, $coms, $editor;
	//First Requirements (Components)
	$error="";
	foreach($pages['blogsub']['reqs'] as $req){
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
			$out='<h1>Posting To Blog</h2>';
			$post['title']=$_POST['title'];
			$post['body']=$_POST['post'];
			$post['time']=time();
			$post['author']=$user['id'];
			$files=opendir('components/blog/posts/');
			$count=0-1;
			while($temp=readdir($files)){
				if($file!='.' && $file!='..'){
					$count++;
				}
			}
			closedir($files);
			$yaml=Spyc::YAMLDump($post);
			$file=fopen('components/blog/posts/'.$count.'.yaml','w');
			fwrite($file,$yaml);
			fclose($file);
		}
	}
	return $out;
}
?>
