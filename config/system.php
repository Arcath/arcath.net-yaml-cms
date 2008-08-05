<?php
//Arcath.net CMS System File
//First include the YAML class
include('lib/spyc.php');
session_start();
//Load the confing file and parse it
$config=Spyc::YAMLLoad('config/config.yaml');


//Page Manager
//Open the Pages dir
$dir=opendir($config['rootdir'].'/'.$config['pagedir']);
//for every file loop
while($file=readdir($dir)){
	$sep=explode('.',$file);
	if(($sep[1]=="yaml")&&((in_array($sep[0],$config['loadedpages']))or(in_array($sep[0],$config['unloadedpages'])))){
		//If it has the page already loaded into either of the page lists then load its config
		if(in_array($sep[0],$config['loadedpages'])){
			$pages[$sep[0]]=Spyc::YAMLLoad($config['rootdir'].'/'.$config['pagedir'].'/'.$file);
			$pages[$sep[0]]['status']='active';
		}else{
			$pages[$sep[0]]['status']='404';
		}
	}elseif($file!="." && $file!=".."){
		//Not Seen
		if($sep[1]=="yaml"){
			$pages[$sep[0]]['status']='404';
			$config['unloadedpages'][count($config['unloadedpages'])]=$sep[0];
		}
	}
}
//Close the Directory
closedir($dir);

//Is there a page in the confing file that isnt in the pages dir?
for($i=0;$i<=count($config['loadedpages'])-1;$i++){
	if(!isset($pages[$config['loadedpages'][$i]]['status'])){
		unset($config['loadedpages'][$i],$config[0]);
	}
}
for($i=0;$i<=count($config['unloadedpages'])-1;$i++){
        if(!isset($pages[$config['unloadedpages'][$i]]['status'])){
                unset($config['unloadedpages'][$i],$config[0]);
        }
}

//Page Function
function content($var){
	global $pages, $config;
	if(!isset($var)){
		$out=content($config['loadedpages'][0]);
	}else{
		if(!is_array($pages[$var]['content']) && $pages[$var]['status']=='active'){
			$out=$pages[$var]['content'];
		}elseif(is_array($pages[$var]['content']) && $pages[$var]['status']=='active'){
			include($config['pagedir'].'/'.$pages[$var]['content'][0].'/'.$pages[$var]['content'][1]);
			$out=output();
		}else{
			$out="<h1>Error 404</h1>Page Not Found!";	
		}
	}
	return $out;
}

//Navigation
$nav="<h1>Menu</h1>";
for($i=0;$i<=count($config['loadedpages'])-1;$i++){
	if($pages[$config['loadedpages'][$i]]['link']!="NOSHOW"){
	        $nav.='<a href="index.php?var='.$config['loadedpages'][$i].'">'.$pages[$config['loadedpages'][$i]]['link'].'</a><br>';
	}
}

//Components
foreach($config['coms'] as $com){
	$coms[$com]=Spyc::YAMLLoad($config['comsdir'].'/'.$com.'.yaml');
	include($config['comsdir'].'/'.$com.'/'.$coms[$com]['file']);
}

//Package Managers
if(in_array($user['id'],$config['pacmans'])){
	$nav.='<a href="?var=pacman">Package Manager</a><br />';
}

//Template Manager (like the page manager but simpler)
$theme=Spyc::YAMLLoad($config['themesdir'].'/'.$config['currenttheme'].'.yaml');
//There thats the current template loaded!
include($config['themesdir'].'/'.$theme['folder'].'/'.$theme['mainfile']);
$template= new Template();

//END OF SYSTEM
//Load the original config file
$original=Spyc::YAMLLoad('config/config.yaml');
if($config!=$original){ //HAS $config been modified in this file?
	//YES so lets dump it
	$yaml=Spyc::YAMLDump($config);
	$file=fopen('config/config.yaml','w');
	fwrite($file,$yaml);
	fclose($file);
}
?>
