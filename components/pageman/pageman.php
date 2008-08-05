<?php
//Arcath.net Page Manager Component
class pageman{
	function init(){
		global $config, $coms, $db, $user, $nav;
		$fail="";
		$out=true;
		foreach($coms['pageman']['reqs'] as $req){
			if(!in_array($req,$config['coms'])){
				$fail.=$req.' ';
			}
		}
		if($fail!=""){
			echo('<div class="error">Component Page Manager is missing the requirement(s) '.$fail.'</div>');
			$out=false;
		}
		if(in_array($user['id'],$coms['pageman']['admins'])){
			$nav.='<a href="?var=pageman">Page Manager</a><br />';
		}
		return $out;
	}
}
$pageman=new pageman;
if($pageman->init()){
	
}
?>
