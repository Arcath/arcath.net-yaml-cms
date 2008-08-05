<?php
//Default Template
Class Template {
	function head(){
		global $config, $pages, $theme, $nav;
		echo('<html>
			<head>
				<title>'.$config['name'].'</title>
				<link rel="stylesheet" type="text/css" href="'.$config['themesdir'].'/'.$theme['folder'].'/'.$theme['stylesheet'].'" />
			</head>
			<body>
			<div class="top"><img src="'.$config['themesdir'].'/'.$theme['folder'].'/images/logo.jpg" /></div>
			<div class="nav">'.$nav.'</div>
			<div class="content">');
	}

	function foot(){
		echo('</div>
			</body>
		</html>');
	}
}
?>
