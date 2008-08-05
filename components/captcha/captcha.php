<?php
function captcha($numchars){
	$vals="ABCDEFGHIJKLMNOPQRSETUVWZYZabcdefghijklmnopqrstuvwxyz0123456789";
	$numvals=strlen($vals);
	$im = ImageCreate((38*$numchars)+10, 40);
	$white = ImageColorAllocate($im, 0,0, 0);
	$black = ImageColorAllocate($im, 120, 200, 68);
	srand((double)microtime()*1000000); 
	$string="";
	ImageFill($im,0,0,$black);
	ImageString($im,1,0,0,"Arcath.net",$white);
	for($i=1;$i<=$numchars;$i++){
		$rand=rand(0,$numvals-1);
		$out=$vals[$rand];
		$string.=$out;
		ImageString($im,rand(1,5),$i*38,rand(5,25),$out,$white);
	}
	Imagejpeg($im, "images/verify.jpeg");
	ImageDestroy($im);
	return $string;
}
?>
