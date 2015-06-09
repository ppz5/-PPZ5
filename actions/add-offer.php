<?php
session_start();
include("../classes/class-db.php");
if(trim($_GET['url']) == "" || !isset($_GET['url']) || !isset($_SESSION['ID_USER']) || !isset($_GET['id']) || trim($_GET['id']) == "" || db::decodeID($_GET['id']) <= 0){
	header('Location: ../');
	exit();
}

$id_order = db::decodeID($_GET['id']);

$con = db::connect();

$result = mysqli_query($con, "SELECT id_order, id_user FROM orders WHERE id_order='$id_order' AND id_status=1");
$order = mysqli_fetch_array($result);
$res_offer = mysqli_query($con, "SELECT id_offer FROM offer WHERE id_user='".$_SESSION['ID_USER']."' AND id_order='".$id_order."'");
$offer = mysqli_num_rows($res_offer);
if($offer == 0){
	$sql = "INSERT INTO offer(id_user, id_order, date, id_status)
			VALUES('".$_SESSION['ID_USER']."','".$order['id_order']."','".date(DATE_ISO8601)."','1','"."')";
	//, order_user
        //.$order['id_user'].
	if (mysqli_query($con, $sql)) {
		$flags['successString'] =  "Oferta została dodana!";
		//$flags['success'] = 1;
	} else {
		$flags['successString'] =  mysqli_error($con);
	}
	$flags['success'] = 1;
}else $flags['success'] = 0;

mysqli_close($con);
$_SESSION['REPORT'] = $flags;
header("Location: " . $_GET['url']);
exit();
?>