<?php
//Arcath.net UMS Component
class ums{
	function init(){
		global $config, $coms, $db;
		$fail="";
		$out=true;
		foreach($coms['ums']['reqs'] as $req){
			if(!in_array($req,$config['coms'])){
				$fail.=$req.' ';
			}
		}
		if($fail!=""){
			echo('<div class="error">Component UMS is missing the requirement(s) '.$fail.'</div>');
			$out=false;
		}
		
		if(isset($_COOKIE[$config['cookie']])){
				$expires=time()+60*60*24;
                                $time=time();
                                $hash=$_COOKIE[$config['cookie']];
                                setcookie($config['cookie'],$hash,$expires);
                                $user=$db->getvalue('id','ums_users','name',$username);
                                $db->query("UPDATE `{PREFIX}ums_sessions` SET `time` = '$time' WHERE `hash` = '$hash'");

		}
		return $out;
	}
	function register($username,$password1,$password2,$email1,$email2,$code,$ent){
		global $db, $ums;
		$errors="";
		if($db->has($username,'name','ums_users')){
			$errors.=$username." has already been taken<br>";
		}
		if($password1==$password2){
			$password=md5($password1);
		}else{
			$errors.="The passwords you entered did not match<br>";
		}
		if($ums->email($email1,$email2)){
			$email=$email1;
		}else{
			$errors.="The Emails You entered where invalid<br>";
		}
		if($code!=$ent){
			$errors.="The Verification Code you entered was wrong<br>";
		}
		if($errors==""){
			$db->query("INSERT INTO {PREFIX}ums_users (`name`,`pass`,`email`) VALUES ('$username','$password','$email');");
			$out="Registration Successful";
		}else{
			$out=$errors;
		}
		return $out;
	}
	function regform(){
		$value=captcha(5);
		$_SESSION['code']=$value;
		$form='<h1>Register</h1>
		<form action="index.php?var=register" method="POST">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
		<td width="25%">Name:</td>
		<td width="75%"><input name="uname" id="uname" type="text" maxchars="255" size="20" /></td>
		</tr><tr>
                <td width="25%">Password:</td>
		<td width="75%"><input name="pass1" id="pass1" type="password" maxchars="255" size="20" /></td>
                </tr><tr>
		<td width="25%">Repeat Password:</td>
		<td width="75%"><input name="pass2" id="pass2" type="password" maxchars="255" size="20" /></td>
                </tr><tr>
		<td width="25%">Email:</td>
                <td width="75%"><input name="email1" id="email1" type="text" maxchars="255" size="20" /></td>
                </tr><tr>
		<td width="25%">Repeat Email:</td>
                <td width="75%"><input name="email2" id="email2" type="text" maxchars="255" size="20" /></td>
                </tr><tr>
		<td><img src="images/verify.jpeg" /></td>
		<td>Verification Code:<br><input type="text" name="img" id="img" maxchars="5" size="20"/></td>
		<tr><td></td><td><input type="submit" value="Register!" /></td></tr>
		</table>
		</form>';
		return $form;
	}
	function email($email1,$email2){
		//Are they the same?
		if($email1==$email2){
			//Yes?
			$check1=explode("@",$email1);
			if(isset($check1[0]) && isset($check1[1])){
				$check2=explode(".",$check1[1]);
				if(isset($check2[0]) && isset($check2[1])){
					$out=true;
				}else{
					$out=false;
				}
			}else{
				$out=false;
			}
		}else{
			//No?
			$out=false;
		}
		return $out;
	}
	function login($username,$pass){
		global $db, $config;
		if($db->has($username,'name','ums_users')){
			$pass2=md5($pass);
			if($pass2==$db->getvalue('pass','ums_users','name',$username)){
				$expires=time()+60*60*24;
				$time=time();
				$hash=md5($username);
				setcookie($config['cookie'],$hash,$expires);
				$user=$db->getvalue('id','ums_users','name',$username);
				$ip=$_SERVER['REMOTE_ADDR'];
				$db->query("INSERT INTO `{PREFIX}ums_sessions` (`hash`,`user`,`ip`,`page`,`time`) VALUES ('$hash','$user','$ip','$page','$time');");
				$out="Login Successful";
			}else{
				$out="Incorrect Password";
			}
		}else{
			$out=$username." doesn't Exist";
		}
		return $out;
	}
	function loginform(){
		$form='<h1>Login</h1><form action="index.php?var=login" method="POST">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<td width="25%">Username:</td>
				<td><input type="text" name="uname" id="uname" size="20" maxchars="255" /></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="password" name="pass" id="pass" size="20" maxchars="255" /></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Login!" /></td>
			</tr>
		</table>
		</form>';
		return $form;
	}
	function load($user){
		global $db;
		$array=array();
		$array['username']=$db->getvalue('name','ums_users','id',$user);
		$array['id']=$user;
		return $array;
	}
	function nav(){
		global $db, $nav, $ums, $user;
		$nav=str_replace('<a href="index.php?var=login">Login</a><br>',"",$nav);
		$nav=str_replace('<a href="index.php?var=register">Register</a><br>',"",$nav);
		$nav.='<h1>'.$user['username'].'</h1>';
	}
	function logout(){
		global $config, $db;
		$hash=$_COOKIE[$config['cookie']];
		$db->query("DELETE FROM `{PREFIX}ums_sessions` WHERE `hash` = '$hash'");
		setcookie($config['cookie'],"ended",time()-100);
		return "You are now logged out! We hope to see you again";
	}
	function guest(){
		global $nav;
		$nav=str_replace('<a href="index.php?var=logout">Logout</a><br>',"",$nav);
	}
}
$ums=new ums;
if($ums->init()){
	if(isset($_COOKIE[$config['cookie']])){
		$user=$ums->load($db->getvalue('user','ums_sessions','hash',$_COOKIE[$config['cookie']]));
		$ums->nav();
	}else{
		$ums->guest();
	}
}
?>
