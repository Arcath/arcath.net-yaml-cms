<?php

//the first number

$vals="ABCDEFGHIJKLMNOPQRSETUVWZYZabcdefghijklmnopqrstuvwxyz0123456789";
$numvals=strlen($vals);
$im = ImageCreate(200, 40);  //create image
$white = ImageColorAllocate($im, 0,0, 0);
$black = ImageColorAllocate($im, 120, 200, 68);
srand((double)microtime()*1000000); 
$numchars=5;
$string="";
ImageFill($im,0,0,$black);
for($i=1;$i<=$numchars;$i++){
	$rand=rand(0,$numvals-1);
	$top=$numvals-$rand-2;
	$out=substr($vals,$rand,-$top-1);
	$string.=$out;
	ImageString($im,rand(1,5),$i*38,rand(5,25),$out,$white);
}
Imagejpeg($im, "images/verify.jpeg");

ImageDestroy($im);

print "<form action='action.php' method='post'>";

print "Please enter the answer to the math question below to verify your not an evil bot:<br>";

print "<input type='hidden' value='$thevalue' name='hiddenvalue'>";

print "<input type='text' name='yourcode' size='20'><br>";

print "<img src='images/verify.jpeg' border='0'><br><br>";

print "<input type='submit' name='submit' value='submit'></form>";

?>
