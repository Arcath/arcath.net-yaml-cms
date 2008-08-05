<?php
//Arcath.net Editor Component
function init(){
	global $config, $coms, $db, $user, $nav;
	$fail="";
	$out=true;
	foreach($coms['editor']['reqs'] as $req){
		if(!in_array($req,$config['coms'])){
			$fail.=$req.' ';
		}
	}
	if($fail!=""){
		echo('<div class="error">The Editor '.$fail.' is missing</div>');
		$out=false;
	}
	return $out;
}
if(init()){
	$editor=new $coms['editor']['reqs'][0];
	echo($editor->head());
}
?>
