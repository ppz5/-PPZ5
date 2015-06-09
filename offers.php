<?php
session_start();

include("classes/class-ess.php");
include("classes/class-db.php");
?>
<html>
    <head>
        <title>Newsletter of dreams</title>
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
						//var_dump($_SESSION['REPORT']);
						//echo $_SESSION['REPORT']['success'];
						if(isset($_SESSION['REPORT'])){
							echo "<strong class='error'>";
							if($_SESSION['REPORT']['success'] == 1){
								echo $_SESSION['REPORT']['successString'];
							}else if($_SESSION['REPORT']['success'] == 0) echo 'Fill up the form carefully!';
							
							unset($_SESSION['REPORT']);
							echo "</strong>";
						}
						?>
                    </div>
                    <?php
					
					if(!isset($_SESSION['ID_USER']))
						echo '<a class="add_offer" href="profile.php">Login/Register to this page!</a>';
					else{
						$user_id = $_SESSION['ID_USER'];
						echo "<div class='offer_notification'>";
						$con = db::connect();
						//mysqli_query($con,"Update status_offer SET name='Złożono ofertę' WHERE id=1");
   
						echo "<h2>Powiadomienia</h2>";
						
						/*$res_order = mysqli_query($con, "SELECT * FROM orders WHERE user_id = '".$_SESSION['USER_ID']."' and status='Submitted' ORDER BY id_order DESC");
						while($row_order = mysqli_fetch_assoc($res_order)){
							$res_offer = mysqli_query($con,"SELECT * FROM offers WHERE order_id = '".$row_order['id_order']."' and status='Offered' ORDER BY id_offer DESC");
							while($row_offer = mysqli_fetch_assoc($res_offer)){
								$res_user = mysqli_query($con, "SELECT * FROM contractors WHERE id_contractor='".$row_offer['user_id']."'");
								$user = mysqli_fetch_array($res_user);
								$_SESSION['TOKEN_OFFERS'] = (time()*$_SESSION['USER_ID']);
								*/
						//$row_offer
						$res_offer = mysqli_query($con,"SELECT o.*,s.name as status_name FROM offer o join status_offer s on o.id_status=s.id WHERE id_user='$user_id' ORDER BY id_offer DESC");
                                                //OR order_user='$user_id'
                                               
                                                while($row_offer = mysqli_fetch_assoc($res_offer)){
							$res_user = mysqli_query($con, "SELECT name,email FROM user WHERE id_user='".$row_offer['id_user']."'");
						
                                                $user = mysqli_fetch_array($res_user);
							$res_order = mysqli_query($con, "SELECT id_order,name FROM orders WHERE id_order = '".$row_offer['id_order']."'");
                                               
							$order = mysqli_fetch_array($res_order);
							
							$enoid = db::encodeID($order['id_order']);
							
							if($row_offer['id_user'] == $user_id && $row_offer['id_status'] != 3){
                                                            
								if($row_offer['id_status'] == 1){
									$s = 1;
									$v = 'Zaakceptuj';
								}else if($row_offer['id_status'] == 2){
									$s = 2;
									$v = 'Zakończ';
								}
								$token = md5($row_offer['id_offer'] * 5 * $s);
								$link = '<a href="actions/offers.php?id='.db::encodeID($row_offer['id_offer']).'&oid='.$enoid.'&s='.$s.'&t='.$token.'">'.$v.'</a>';
								$string = "złożył ofertę do ";
							}else{
								$link = $row_offer['status_name'];
								$string = "złożył ofertę do ";
							}
							?>
								<div>
									<p>
										<span>#</span>
										<strong><?php echo $user['name'] ?></strong>
										<?php echo "(" . $user['email'] . ") ". $string ?> 
										<strong><a href="order.php?id=<?php echo $enoid ?>"><?php echo $order['name'] ?></a></strong>.
										<?php echo $link ?>
									</p>
								</div>
							<?php
						}
						mysqli_close($con);
						echo "</div>";
					}
					?>
                    
				</div>
			</div>
			<?php ess::footer() ?>
		</div>
    </body>
</html>
