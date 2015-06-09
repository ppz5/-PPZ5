<?php
session_start();
include("classes/class-ess.php");
include("classes/class-profile.php");
?>
<html>
    <head>
        <title>Newsletter of dreams</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href='http://fonts.googleapis.com/css?family=Cinzel' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Arial' rel='stylesheet' type='text/css'>
		<link href="wyglad.css" rel="stylesheet" type="text/css" />
        <link href="style.css" rel="stylesheet" type="text/css" />
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
							}else if($_SESSION['REPORT']['success'] == 0) echo 'Fill up the form carefully!';
							
							unset($_SESSION['REPORT']);
							echo "</strong>";
						}
						?>
                    </div>
					<div>
                    	<?php
						if(!isset($_SESSION['ID_USER']))
                        	profile::registration();
						else
							profile::account();
						?>
                    </div>
				</div>
			</div>
			<?php ess::footer() ?>
		</div>
    </body>
</html>
