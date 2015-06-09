<?php
session_start();
include("classes/class-ess.php");
include("classes/class-db.php");
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
					<div style="margin:-10px 0px 0px -120px;" align="left">
                    	<div>
                        	<table id="tab">
                                <form action="search-order.php" method="get">
                                    <tr>
                                        <td class="justuj">Słowo kluczowe</td>
                                        <td> <input type="text" name="k" value="<?php if(isset($_GET['k'])) echo $_GET['k'] ?>" /> </td>
                                        <td class="justuj" >Typ</td>
                                        <td> <input type="text" name="t"value="<?php if(isset($_GET['t'])) echo trim($_GET['t']) ?>" /> </td>
                                        <td><input type="submit" value="Szukaj" style="font-family: 'Arial', sans-serif;" /></td>
                                    </tr>
                                </form>
                            </table>
                        </div>
                        <div>
                        <?php
						$con = db::connect();
						if(isset($_GET['k']))
							$name = mb_convert_encoding(trim($_GET['k']),'UTF-8','auto');
						else $name = "";
						if(isset($_GET['t']))
							$type = mb_convert_encoding(trim($_GET['t']),'UTF-8','auto');
						else $type = "";
						$result = mysqli_query($con, "SELECT * FROM orders WHERE name LIKE '".$name."%' AND type LIKE '".$type."%'ORDER BY id_order DESC LIMIT 6");
						while($row = mysqli_fetch_assoc($result)){
							$row['photo_url'] = trim($row['photo_url']) == ""?'default.jpg':$row['photo_url'];
							$row['description'] = trim($row['description']) == ""? "Opis jest niedostępny!":$row['description'];
							list($width, $height) = getimagesize("uploads/photo/".$row['photo_url']);
							//echo $width;
							$enoid = db::encodeID($row['id_order']);
							if($width < $height)
								$rep = "width";
							else $rep = "height";
							
							$add = "";
							if(isset($_SESSION['ID_USER'])){
								$result_count = mysqli_query($con, "SELECT id_offer FROM offer WHERE id_user='".$_SESSION['ID_USER']."' AND id_order = '".$row['id_order']."'");
								$count = mysqli_num_rows($result_count);
								
								if($count < 1)
									$add = '</a><a title="Add this order to offer" href="actions/add-offer.php?id='.$enoid.'&url='.urlencode($_SERVER['PHP_SELF']).'" style="float:right">+</a>';
							}
							?>
                            <div class="grid">
                            	<a href="order.php?id=<?php echo $enoid ?>">
                            		<div class="img"><img src="uploads/photo/<?php echo $row['photo_url'] ?>" <?php echo $rep ?>="100%" alt="<?php echo $row['name'] ?>"></div>
                                </a>
                                <div>
                                	<h4><a href="order.php?id=<?php echo $enoid ?>"><?php echo $row['name'] . $add ?></h4>
                                    <a href="order.php?id=<?php echo $enoid ?>">
                                        <p class="type">Type : <?php echo $row['type'] ?></p>
                                        <p class="desc"><?php echo $row['description'] ?></p>
                                    </a>
                                </div>
                            </div>
                            
                            <?php
						}
						mysqli_close($con);
						?>
                        </div>
                    </div>
				</div>
			</div>
			<?php ess::footer() ?>
		</div>
    </body>
</html>
