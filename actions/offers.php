<?php
session_start();

include('../classes/class-db.php');
$id = db::decodeID($_GET['id']);
$oid = db::decodeID($_GET['oid']);
if(!isset($_SESSION['ID_USER'])
		 || !isset($_GET['id'])
		 || !isset($_GET['s'])
		 || !isset($_GET['t']) 
		 || trim($_GET['oid']) == "" 
		 || !isset($_GET['oid']) 
		 || trim($_GET['id']) == "" 
		 || trim($_GET['s']) == ""
		 || trim($_GET['t']) == ""
		 || $_GET['t'] != md5($id * 5 * $_GET['s'])
	){
	header('Location: ../');
	exit();
}

$flags = array();
$flags['success'] = 1;

$status = $_GET['s'] <= 1?2:3;
$status_o = $_GET['s'] <= 1?2:3;
$con = db::connect();
$sql = mysqli_query($con, "UPDATE offer SET id_status = '$status' WHERE id_offer='$id'");

$sql = mysqli_query($con, "UPDATE orders SET id_status = '$status_o' WHERE id_order='$oid'");
mysqli_close($con);
$flags['successString'] = 'Oferta została pomyślnie ';

switch ($status) {
    case 2:
        $flags['successString'].= "zaakaceptowana"; break;
    case 3:
        $flags['successString'].= "zakończona"; break;
}


$_SESSION['REPORT'] = $flags;
header("Location: http://www.anzzilla.linuxpl.info/news_p5/offers.php");
exit();
?>