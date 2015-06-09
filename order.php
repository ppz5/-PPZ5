<?php
session_start();
include("classes/class-ess.php");
include("classes/class-db.php");

if(!isset($_GET['id']) || trim($_GET['id']) == ""){
	header("Location: search-order.php");
	exit();
}else{
	$enoid = $_GET['id'];
	$order_id = db::decodeID($_GET['id']);
}
?>
<html>
    <head>
        <title>Gazetka marzeń</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href='http://fonts.googleapis.com/css?family=Cinzel' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Arial' rel='stylesheet' type='text/css'>
		<link href="wyglad.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
		<div class="all">
			<?php ess::main_menu() ?>
			<div class="strona">
				<?php ess::sidebar() ?>
				<div class="ndw" style="font-family: 'Arial', sans-serif;">
                	<div>
                    	
                    	<?php
						if(isset($_SESSION['REPORT'])){
							echo "<strong class='error'>";
							if($_SESSION['REPORT']['success'] == 1){
								echo $_SESSION['REPORT']['successString'];
							}else if($_SESSION['REPORT']['success'] == 0) echo 'Wypełnij formularz uważnie!';
							
							unset($_SESSION['REPORT']);
							echo "</strong>";
						}
						?>
                        
                    </div>
					<div>
                    <?php
						$con = db::connect();
                                                //o.*,s.name as status_name FROM offer o join status_offer s on o.id_status=s.id 
						$result = mysqli_query($con, "SELECT o.*,s.name as status_name FROM orders o JOIN status_order s on o.id_status=s.id WHERE id_order = '$order_id'");
						$row = mysqli_fetch_array($result);
						
						$row['photo_url'] = trim($row['photo_url']) == ""?'default.jpg':$row['photo_url'];
						$row['description'] = trim($row['description']) == ""? "No description available!":$row['description'];
						list($width, $height) = getimagesize("uploads/photo/".$row['photo_url']);
						if($width < $height)
							$rep = "width";
						else $rep = "height";
						//echo $row['name'];						
					?>
                        <div class="news_view">
                        <a style="float:right; margin-top:-40px; text-decoration:none" href="pdf.php?xml=<?php echo $row['xml_url'] ?>"><img src="image/pdf.png" width="24" /></a>
                        <?php
							if (file_exists("uploads/xml/" . $row['xml_url']) && trim($row['xml_url']) != "") {
								$use_errors = libxml_use_internal_errors(true);
								$xml = simplexml_load_file("uploads/xml/" . $row['xml_url']);
								if(!$xml) {
									echo "No valid xml file found.";
									$xml = array();
								}
								//print_r($xml);
								foreach($xml as $product){
									//var_dump($product);
									//echo $product['name'];
									foreach($product as $info){
									?>
                                    <div class="product">
                                    	<h3>Nazwa Produktu: <?php echo $product['name'] ?></h3>
                                        <div>
                                            <div class="info">
                                                <p><strong>Kod Producenta:</strong> <?php echo $info['kod_prod'] ?></p>
                                                <p><strong>Symbol NTT:</strong> <?php echo $info['symbol'] ?></p>
                                                <p class="opis"><strong>Opis:</strong> <?php echo $info['desc'] ?></p>
                                            </div>
                                            <div class="price">
												<?php
													$price = explode(".", $info['price']);
													echo "<p>".$price[0]."</p>";
													echo "<p>".$price[1]."</p>";
													echo "<p>netto</p>";
												?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
									}
								}
							} else {
								echo "Nie znaleziono pliku xml.";
							}
						?> 
                        </div>
                        <div class="detail_view">
                        	<div class="cover">
                            	<img src="uploads/photo/<?php echo $row['photo_url'] ?>" <?php echo $rep ?>="100%" alt="<?php echo $row['name'] ?>">
                            </div>
                            <?php
                           
							if(isset($_SESSION['ID_USER'])){
								$result = mysqli_query($con, "SELECT id_offer FROM offer WHERE id_user='".$_SESSION['ID_USER']."' AND id_order = '".$order_id."'");
								$count = mysqli_num_rows($result);
                                                                
								if($count == 0 && $row['id_status'] == 1 && $row['id_user'] != $_SESSION['ID_USER']){
									echo '<a class="add_offer" title="Add this order to offer" href="actions/add-offer.php?id='.$enoid.'&url='.urlencode($_SERVER['PHP_SELF']).'?id='. $enoid . '" style="float:right"> + Dodaj ofertę</a>';
								}else if($count > 0 && $row['id_status'] == 1 && $row['id_user'] != $_SESSION['ID_USER']) echo '<a class="add_offer">Oferta została złożona!</a>';
								else echo '<a class="add_offer">'.$row['status_name'].'</a>';
							}else echo '<a class="add_offer" href="profile.php">Zaloguj się/zarejestruj aby dodać ofertę!</a>';
							
							mysqli_close($con);
							?>
                            	
                            <div style="margin-top:50px;">
                                <h4><?php echo $row['name'] ?></h4>
                                <p class="type">Type : <?php echo $row['type'] ?></p>
                                <p class="desc"><?php echo $row['description'] ?></p>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
			<?php ess::footer() ?>
		</div>
    </body>
</html>
