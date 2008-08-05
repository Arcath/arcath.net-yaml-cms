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
			$page=$_GET['page'];
			$out='<h1>Edit a Page</h1><h2>'.$pages[$page]['name'].'</h2>
			<form action="?var=pageeditsub" method="POST">
			<input type="hidden" name="file" id="file" value="'.$page.'" />
			<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td width="15%">Name:</td>
					<td><input type="text" name="name" id="name" size="20" maxchars="255" value="'.$pages[$page]['name'].'" /></td>
				</tr>
				<tr>
					<td>Link text:</td>
					<td><input type="text" name="link" id="link" size="20" maxchars="255" value="'.$pages[$page]['link'].'" /></td>
				</tr>';
				if(is_array($pages[$page]['content'])){
					$out.='<tr><td>Module/file</td><td><select name="content" id="content"><option value="CHANGE">Change to typed content</option>';
						$folder=opendir('pages');
						while($module=readdir($folder)){
							if($module!='.' && $module!='..'){
								$temp=explode('.',$module);
								if(!isset($temp[1])){
									$folder2=opendir('pages/'.$module);
									while($file=readdir($folder2)){
										if($file!='.' && $file!='..'){
											$temp2=explode('.',$file);
											if($module.'/'.$file==$pages[$page]['content'][0].'/'.$pages[$page]['content'][1]){
												$status="SELECTED";
											}
											$out.='<option value="'.$module.'/'.$temp2[0].'" '.$status.'>'.$module.'/'.$temp2[0].'</option>';
											$status="";
										}
									}
									closedir($folder2);
								}
							}
						}
						closedir($folder);
					$out.='</select></td></tr>';
				}else{
					$out.='<tr><td>Content:</td><td></td></tr><tr><td colspan="2">'.$editor->disp(70,15,'content',$pages[$page]['content']).'</td></tr>';
				}
			$out.='</table><input type="submit" value="Save" /></form>';
		}
	}
	return $out;
}
?>
