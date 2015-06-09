<?php
class ess{
	static function main_menu(){
		?>
        	<div class="naglowek">
				<a href="#" class="przycisk">O nas</a>
				<a href="#" class="przycisk">FAQ</a>
				<a href="#" class="przycisk">Blog</a>
				<a href="#" class="przycisk">Kontakt</a>
				<?php
                if(isset($_SESSION['ID_USER']))
                    echo '<a href="signout.php" class="przycisk">Wyloguj</a>';
                else echo '<a href="profile.php" class="przycisk">Zaloguj</a>';
                ?>
			</div>
        <?php
	}
	
	static function sidebar(){
		?>
        		<div class="menu">
					<ul class="lista">
						<li><a href="#">Moje zlecenia</a>
							<ul>
								<li><a href="http://www.anzzilla.linuxpl.info/news_p5/index.php">Dodaj zlecenie</a></li>
							</ul>
						</li>
					
						<li><a href="#">Moje oferty</a>
							<ul>
								<li><a href="http://www.anzzilla.linuxpl.info/news_p5/search-order.php">Wyszukaj zlecenie</a></li>
								<li><a href="http://www.anzzilla.linuxpl.info/news_p5/offers.php">Moje oferty</a></li>
							</ul>
						</li>
						
						<li><a href="#">Koszyk (0)</a>
							<ul>
								 <li><a href="#">Generuj ofertę</a>
								 <li><a href="#">Podgląd wydruku</a></li>
							</ul>
						</li>
					</ul>
				</div>
		<?php
	}
	
	static function footer(){
		?>
        	<div class="naglowek">
				<a href="#" class="przycisk">Facebook</a>
				<a href="#" class="przycisk">Regulamin</a>
				<a href="#" class="przycisk">Kontakt</a>
				<a href="#" class="przycisk">Wesprzyj</a>
                <?php
				if(isset($_SESSION['ID_USER'])){
					$name = explode(" ", $_SESSION['NAME']);
					echo '<a href="profile.php" class="przycisk">'.$name[0].'</a>';
				}else echo '<a href="profile.php" class="przycisk">Register</a>';
				?>
			</div>
        <?php
	}
}
?>