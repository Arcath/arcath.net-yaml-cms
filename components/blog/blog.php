<?php
//Arcath.net Blog Component
class blog{
	function init(){
		global $config, $coms, $db, $user, $nav;
		$fail="";
		$out=true;
		foreach($coms['blog']['reqs'] as $req){
			if(!in_array($req,$config['coms'])){
				$fail.=$req.' ';
			}
		}
		if($fail!=""){
			echo('<div class="error">Component Blog is missing the requirement(s) '.$fail.'</div>');
			$out=false;
		}
		if(in_array($user['id'],$coms['blog']['writers'])){
			$nav.='<a href="?var=blogwrite">Write to Blog</a><br />';
		}
		return $out;
	}
	function showpost($post){
		global $db, $ums;
		$data=Spyc::YAMLLoad('components/blog/posts/'.$post.'.yaml');
		$poster=$ums->load($data['author']);
		$out='<h1>'.$data['title'].'</h1>Posted by '.$poster['username'].' at <i>'.date("g:ia l F Y ",$data['time']).'</i><br /><br />'.$data['body'].'<br />';
		return $out;
	}
	function clippedpost($post,$to){
		global $blog;
		$pre=$blog->showpost($post);
		$out=substr($pre,0,$to);
		if(strlen($pre)!=strlen($out)){
			$out.='...<br /><a href="#">Read More</a>';
		}
		return $out;
	}
	function disp($num){
		global $blog, $config;
		$out="";
		$dir=opendir($config['rootdir'].'/components/blog/posts');
		//for every file loop
		while($file=readdir($dir)){
			$temp=explode('.',$file);
			if(isset($temp[0]) && $temp[1] == "yaml"){
				if($temp[0]>=$high){
					$high=$temp[0];
				}
			}
		}
		$low=$high-$num;
		if($low<=0){
			$low=1;
		}
		for($i=$high;$i>=$low;$i--){
//			$out.=$blog->clippedpost($i,50);
			$out.=$blog->showpost($i).'<hr>';
		}
		return $out;
	}
}
$blog=new blog;
if($blog->init()){
	
}
?>
