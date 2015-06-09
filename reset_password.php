<?php
session_start();
include("classes/class-ess.php");
include("classes/class-db.php");

if (isset($_POST['resetuj']))
{
    $con = db::connect();
    $result = mysqli_query($con,"SELECT id_user FROM user WHERE email = '".$_POST['email']."'");
    if ($result)
    {
        $row = mysqli_fetch_assoc($result);
        $id_user = $row['id_user'];
        require_once('classes/phpmailer/class.phpmailer.php');

        $chars = array();
        for ($i=48;$i<=57;++$i)
            $chars[] = chr($i);
        for ($i=65;$i<=90;++$i)
            $chars[] = chr($i);
        for ($i=97;$i<=122;++$i)
            $chars[] = chr($i);
        $password = '';
        for ($i=0;$i<8;++$i)
            $password .= $chars[rand(0,count($chars)-1)];
        mysqli_query($con,"UPDATE user SET password=".md5($password)." WHERE id_user=$id_user");
        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";
        $mail->IsSMTP();
        $mail->Host = "ssl://smtp.wit.edu.pl";
        $mail->SMTPAuth = true;
        $mail->Port = 465;
        $mail->Username = "borkowsa";
        $mail->Password = "l2o0b0o4";
        $mail->AddAddress($_POST['email'], 'Odbiorca');
        $mail->SetFrom('borkowsa@wit.edu.pl', 'Nadawca');
        $mail->Subject = 'Nowe hasło';
        $mail->MsgHTML("Twoje nowe hasło: $password");

        $mail->Send();
        $info = 'Mail z nowym hasłem został wysłany.';
    }
    else
    {
        $error = 'Nie ma użytkownika o tym emailu!';
    }
}
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
                    <form method="post" action="">
                        Email: <input type="text" name="email" /> <input type="submit" name="resetuj" value="Resetuj" />
                    </form>
                    <br />
                    <? if(isset($error)): ?>
                    <div>
                        <?= $error ?>
                    </div>
                    <? endif; ?>
                    <? if(isset($info)): ?>
                    <div>
                        <?= $info ?>
                    </div>
                    <? endif; ?>
                </div>
            </div>
            <?php ess::footer() ?>
        </div>
    </body>
</html>