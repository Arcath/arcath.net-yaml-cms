<?php
//Arcath.net TinyMCE Component
class tinymce{
	function init(){
		global $config, $coms, $db, $user, $nav;
		$fail="";
		$out=true;
		foreach($coms['tinymce']['reqs'] as $req){
			if(!in_array($req,$config['coms'])){
				$fail.=$req.' ';
			}
		}
		if($fail!=""){
			echo('<div class="error">Component TinyMCE is missing the requirement(s) '.$fail.'</div>');
			$out=false;
		}
		return $out;
	}
	function head(){
		$out='<script type="text/javascript" src="tinymce/tiny_mce.js"></script>
		<script type="text/javascript">
		tinyMCE.init({
			mode : "textareas",
			theme : "advanced",
			plugins : "safari,pagebreak,style,layer,save,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
			theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
			content_css : "themes/default/style.css",
			template_external_list_url : "tinymce/lists/template_list.js",
			external_link_list_url : "tinymce/lists/link_list.js",
			external_image_list_url : "tinymce/lists/image_list.js",
			media_external_list_url : "tinymce/lists/media_list.js",
			template_replace_values : {
				username : "user",
				staffid : "12345678",
			}
		});
		</script>';
		return $out;
	}
	function disp($x,$y,$name,$edit){
		global $editor;
		$edit=$editor->editparse($edit);
		$out='<textarea id="'.$name.'" name="'.$name.'" rows="'.$y.'" cols="'.$x.'">'.$edit.'</textarea>';
		return $out;
	}
	function editparse($in){
		$out=str_replace('<','&lt;',$in);
		$out=str_replace('>','&gt;',$out);
		return $out;
	}
}
?>
