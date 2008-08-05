<?php
//Arcath.net Package Manager Component
class pacman{
	function init(){
		global $config, $coms, $db, $user, $nav;
		$fail="";
		$out=true;
		foreach($coms['pacman']['reqs'] as $req){
			if(!in_array($req,$config['coms'])){
				$fail.=$req.' ';
			}
		}
		if($fail!=""){
			echo('<div class="error">Component Package Manager is missing the requirement(s) '.$fail.'</div>');
			$out=false;
		}
		if(in_array($user['id'],$coms['pacman']['admins'])){
			$nav.='<a href="?var=pageman">Package Manager</a><br />';
		}
		return $out;
	}
}
$pacman=new pacman;
if($pacman->init()){
	
}
?>
