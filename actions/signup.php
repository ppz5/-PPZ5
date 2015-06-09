<?php
session_start();

if(!isset($_POST['wyslij'])){
	header('Location: ../');
	exit();
}

include('../classes/class-db.php');
$flags = array();
$flags['success'] = 1;

if(trim($_POST['name']) == ""){
	$flags['success'] = 0;
	$flags['email'] = 'Name is required!';
}else $name = mb_convert_encoding($_POST['name'],'UTF-8','auto');
$con = db::connect();
if(!(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) {
	$flags['success'] = 0;
	if(trim($_POST['email']) == ""){
		$flags['email'] = 'Należy podać email!';
	}else{
		$flags['email'] = 'Podany email jest nieprawidłowy!';
	}
}else{
	$result = mysqli_query($con,"SELECT email FROM user WHERE email='". $_POST['email'] ."'");
	if(mysqli_num_rows($result) > 0){
		$flags['success'] = 0;
		$flags['email'] = 'Email jest już w użyciu!';
	}
}

if(trim($_POST['password']) == ""){
	$flags['success'] = 0;
	$flags['password'] = 'Hasło jest wymagane!';
}
if(trim($_POST['apassword']) == ""){
	$flags['success'] = 0;
	$flags['apassword'] = 'Ponowne hasło jest wymagane!';
}
if(trim($_POST['apassword']) != "" && trim($_POST['password']) != "" && md5($_POST['apassword']) != md5($_POST['password'])){
	$flags['success'] = 0;
	$flags['apassword'] = 'Podane hasło nie pasuje!';
}
if($flags['success'] == 1){
	$sql = "INSERT INTO user (name,email,password, date)VALUES('".$name."','".$_POST['email']."','".md5($_POST['password'])."','".date(DATE_ISO8601)."')";
	if(!mysqli_query($con,$sql)){
		$flags['success'] = 0;
	}else $flags['successString'] = "Rejestracja przebiegła pomyślnie! Proszę zaloguj się teraz.";
}

mysqli_close($con);
$_SESSION['REPORT'] = $flags;
header("Location: www.anzzilla.linuxpl.info/news_p5/profile.php");
exit();
?>