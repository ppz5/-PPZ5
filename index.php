<?php
session_start();
include("classes/class-ess.php");
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
					<p><center><font size="6"><b>Dodaj zlecenie</b></font></center></p>
					<table id="tab">
						<form action="actions/add-order.php" method="post" enctype="multipart/form-data">
							<tr>
								<td class="justuj"> Nazwa zlecenia </td>
								<td> <input type="text" name="nazwa" /> </td>
							</tr>

							<tr>
								<td class="justuj" > Typ zlecenia </td>
								<td> <input type="text" name="typ" /> </td>
							</tr>

							<tr>
								<td class="justuj" > Termin realizacji </td>
								<td>
									 <select name="czas">
										<option value="1"> Krótki termin </option>
										<option selected="selected" value="2"> Do ustalenia </option>
										<option value="3"> Długi termin </option>>
									 </select>
								</td>
							</tr>

							<tr>
								<td class="justuj" valign="middle"> Opis </td>
								<td> <textarea style="font-family: 'Arial', sans-serif;" name="opis" placeholder="Type your description here"></textarea></td>
							</tr>
							
							<tr>
								<td class="justuj"> Dodaj zdjęcie </td>
								<td> <input style="font-family: 'Arial', sans-serif;" type="file" name="zdjecie"/></td>
							</tr>
							
							<tr>
								<td class="justuj"> Dodaj plik xml z danymi </td>
								<td> <input style="font-family: 'Arial', sans-serif;" type="file" name="xml"/></td>
							</tr>


							<tr>
								<td/>
								<td align="right">
									 <input type="submit" style="font-family: 'Arial', sans-serif;" name="wyslij" value="Wyślij" />
								</td>
							</tr>
						</form>
					</table>
				</div>
			</div>
			<?php ess::footer() ?>
		</div>
    </body>
</html>
