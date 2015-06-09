<?php
session_start();

if(!isset($_POST['wyslij']) || !isset($_SESSION['ID_USER'])){
	if(!isset($_SESSION['ID_USER'])){
		$flags['successString'] = "Musisz być zalogowany/zarejestrowany aby dodać zlecenie!";
		$flags["success"] = 1;
		$_SESSION['REPORT'] = $flags;
	}
	header('Location: ../');
	exit();
}

function fileName($url, $name){
	$time = time() . '_';
	$filename = $time . $name;
	if (file_exists($url . $filename)) {
		fileName($url, $name);
	}
	
	if(trim($filename) == trim($time)){
		$filename = "";
	}
	return $filename;
}

$flags = array();

$photo_dir = "../uploads/photo/";
$flags['photo']['fileName'] = fileName($photo_dir, basename($_FILES["zdjecie"]["name"]));
$photo = $photo_dir . $flags['photo']['fileName'];
$flags['photo']['upload'] = 1;
$imageFileType = pathinfo($photo,PATHINFO_EXTENSION);

if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["zdjecie"]["tmp_name"]);
    if($check !== false) {
        $flags['photo']['upload'] = 1;
    } else {
        $flags['photo']['isImage'] = "File is not an image.";
        $flags['photo']['upload'] = 0;
    }
}

if ($_FILES["zdjecie"]["size"] > 500000) {
    $flags['photo']['size'] = "Your photo is too large.";
    $flags['photo']['upload'] = 0;
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $flags['photo']['isImage'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
    $flags['photo']['upload'] = 0;
}

$xml_dir = "../uploads/xml/";
$flags['xml']['fileName'] = fileName($xml_dir, basename($_FILES["xml"]["name"]));
$xml = $xml_dir . $flags['xml']['fileName'];
$flags['xml']['upload'] = 1;
$imageFileType = pathinfo($xml,PATHINFO_EXTENSION);

if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["xml"]["tmp_name"]);
    if($check !== false) {
        $flags['xml']['upload'] = 1;
    } else {
        $flags['xml']['isXml'] = "File is not an image.";
        $flags['xml']['upload'] = 0;
    }
}

if ($_FILES["xml"]["size"] > 500000) {
    $flags['xml']['size'] = "Your xml is too large.";
    $flags['xml']['upload'] = 0;
}

if($imageFileType != "xml" ) {
    $flags['xml']['isXml'] = "Upload a XML file!";
    $flags['xml']['upload'] = 0;
}


include('../classes/class-db.php');
$flags['success'] = 1;
if(trim($_POST['nazwa']) != "")
	$name = mb_convert_encoding($_POST['nazwa'],'UTF-8','auto');
else $flags['success'] = 0;
if(trim($_POST['typ']) != "")
	$type =  mb_convert_encoding($_POST['typ'],'UTF-8','auto');
else $flags['success'] = 0;

$time = filter_var($_POST['czas'],FILTER_SANITIZE_SPECIAL_CHARS);
$description = mb_convert_encoding($_POST['opis'],'UTF-8','auto');
$add_time = date(DATE_ISO8601);

$con = db::connect();

if($flags['success'] == 1){
	if ($flags['photo']['upload'] == 0) {
		$flags['photo']['uploaded'] = "Nie udało się uploadować pliku.";
	} else {
		if (move_uploaded_file($_FILES["zdjecie"]["tmp_name"], $photo)) {
			$flags['photo']['uploaded'] = "Plik uploadowano.";
			$flags['photo']['success'] = 1;
		} else {
			$flags['photo']['uploaded'] = "Błąd podczas uploadu pliku.";
		}
	}
	
	if ($flags['xml']['upload'] == 0) {
		$flags['xml']['uploaded'] = "Nie udało się uploadować pliku.";
	} else {
		if (move_uploaded_file($_FILES["xml"]["tmp_name"], $xml)) {
			$flags['xml']['uploaded'] = "Plik uploadowano.";
			$flags['xml']['success'] = 1;
		} else {
			$flags['xml']['uploaded'] = "Błąd podczas uploadu pliku.";
		}
	}
	
	
	$sql = "INSERT INTO orders (id_user, name, type, id_time, description, photo_url, xml_url, id_status)
		VALUES ('".$_SESSION['ID_USER']."', '$name', '$type', '$time', '$description', '".urlencode($flags['photo']['fileName'])."', '".urlencode($flags['xml']['fileName'])."', '1')";

	if (mysqli_query($con, $sql)) {
		$flags['successString'] = "Nowe zlecenie dodano pomyślnie!";
		//$flags['success'] = 1;
	} else {
		$flags['successString'] = "Error"  . $sql . "</br" . mysqli_error($con);
	}
}
mysqli_close($con);
$_SESSION['REPORT'] = $flags;
header("Location: http://www.anzzilla.linuxpl.info/news_p5/order.php");
exit();
?> 