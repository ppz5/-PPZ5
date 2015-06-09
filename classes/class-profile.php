<?php
class profile{
	public static function registration(){
	?>
    					<div class="signup">
                        	<h3>Registration</h3>
                        	<table id="tab" style="width:100% !important">
                                <form action="actions/signup.php" method="post">
                                    <tr>
                                        <td class="justuj" style="width:50% !important"> Nazwa </td>
                                        <td style="width:50% !important"> <input type="text" name="name" /> </td>
                                    </tr>
        
                                    <tr>
                                        <td class="justuj" >Email</td>
                                        <td> <input type="text" name="email" /> </td>
                                    </tr>
                                    <tr>
                                        <td class="justuj" >Hasło</td>
                                        <td> <input type="password" name="password" /> </td>
                                    </tr>
                                    <tr>
                                        <td class="justuj" >Hasło (ponownie)</td>
                                        <td> <input type="password" name="apassword" /> </td>
                                    </tr>

                                    <tr>
                                        <td/>
                                        <td align="right">
                                             <input type="submit" style="font-family: 'Arial', sans-serif;" name="wyslij" value="Register" />
                                        </td>
                                    </tr>
                                </form>
                            </table>
                        </div>
                        <div class="signin">
                        	<h3>Login</h3>
                        	<table id="tab" style="width:100% !important">
                                <form action="actions/signin.php" method="post">
                                    <tr>
                                        <td class="justuj" style="width:50% !important">Email</td>
                                        <td style="width:50% !important"> <input type="text" name="email" /> </td>
                                    </tr>
        
                                    <tr>
                                        <td class="justuj" >Hasło</td>
                                        <td> <input type="password" name="password" /> </td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td align="right">
                                             <input type="submit" style="font-family: 'Arial', sans-serif;" name="wyslij" value="Login" />
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="2"><a href="reset_password.php" style="color: black">resetuj hasło</a></td>
                                    </tr>
                                </form>
                            </table>
                        </div>
    <?php
	}
	
	public static function account(){
		?>
        	<table id="tab">
						<form action="actions/account-update.php" method="post">
							<tr>
								<td class="justuj" width="150"> Nazwa </td>
								<td> <input type="text" name="name" value="<?php echo $_SESSION['NAME'] ?>" /> </td>
							</tr>

							<tr>
								<td class="justuj" > Email </td>
								<td> <input type="text" name="email"  value="<?php echo $_SESSION['EMAIL'] ?>" /> </td>
							</tr>

							<tr>
                                <td class="justuj" >Nowe hasło</td>
                                <td> <input type="password" name="password" /> </td>
                            </tr>


							<tr>
                                <td class="justuj" >Nowe hasło (ponownie)</td>
                                <td> <input type="password" name="apassword" /> </td>
                            </tr>
                            
                            <tr>
                                <td class="justuj" >Stare hasło (wymagane)</td>
                                <td> <input type="password" name="opassword" /> </td>
                            </tr>
                            
							<tr>
								<td/>
								<td align="right">
									 <input type="submit" style="font-family: 'Quicksand', sans-serif;" name="wyslij" value="Update" />
								</td>
							</tr>
						</form>
					</table>
        <?php
	}
}
?>