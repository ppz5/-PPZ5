<?php
session_start();

if(!isset($_POST['wyslij'])){
	header('Location: ../');
	exit();
}

include('../classes/class-db.php');
$flags = array();
$flags['success'] = 1;

if(trim($_POST['email']) == ""){
	$flags['success'] = 0;
	$flags['email'] = 'Należy podać email!';
}
if($_POST['password'] == ""){
	$flags['success'] = 0;
	$flags['pass_empty'] = 'Należy podać hasło!';
}
$link = db::connect();
if($flags['success'] = 1){
	$result = mysqli_query($link,"SELECT * FROM user WHERE email='". $_POST['email'] ."' AND password='". md5($_POST['password']) ."'");
	if(mysqli_num_rows($result) > 0){
		$values = mysqli_fetch_array($result);
		session_regenerate_id();
		$_SESSION['ID_USER'] = $values['id_user'];
		$_SESSION['NAME'] = $values['name'];
		$_SESSION['EMAIL'] = $values['email'];
		$_SESSION['PASSWORD'] = $values['password'];
		session_write_close();
	}else{
		$flags['successString'] = 'Dane do logowania nie zgadzają się!';
		$flags['success'] = 0;
	}
	@mysqli_close($link);
}

//@mysqli_close($con);
$_SESSION['REPORT'] = $flags;
header("Location: http://www.anzzilla.linuxpl.info/news_p5/profile.php");
exit();
?>