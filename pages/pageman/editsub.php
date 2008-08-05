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
			$page['name']=$_POST['name'];
			$page['link']=$_POST['link'];
			$content=explode('/',$_POST['content']);
			if($_POST['content']=="CHANGE"){
				$page['content']="<b>Edit Me</b>";
			}else{
				if(in_array($content[0],$config['coms'])){
					$page['content'][0]=$content[0];
					$page['content'][1]=$content[1].'.php';
					$page['reqs'][0]=$content[0];
				}else{
					$page['content']='"'.$_POST['content'].'"';
					$page['content']=str_replace(array("\r\n","\n","\r"),"",$page['content']);
					echo($page['content']);
				}
			}
			$yaml=Spyc::YAMLDump($page);
			$file=fopen('pages/'.$_POST['file'].'.yaml','w');
			fwrite($file,$yaml);
			fclose($file);
			$out.='<h1>Saving...</h1>The page has been updated';
		}
	}
	return $out;
}
?>
