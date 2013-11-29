<?php
    if($_GET['method'] == 'username'){
        if(isset($_POST['username_retrieve'])){
            $mydb = new myDBC();

            $email = $mydb->clearText($_POST['email']);
            $password = $mydb->clearText($_POST['password']);
            $hashed = hash('SHA256', $password);

            $sql="SELECT `username` FROM `users_table` WHERE `email` = '".$email."' AND `password` = '".$hashed."' LIMIT 1";
            $result = $mydb->runQuery($sql);
            $row = $result->fetch_assoc();

            if($result = $mydb->totalCount('username', 'users_table', $where = "WHERE `email` = '".$email."' AND `password` = '".$hashed."'") > 0) {
                echo "<p class='msg-info'>Your username is <strong>".$row['username']."</strong></p>";
            } else {
                $_SESSION['error'] = "That email address and password combination is incorrect!";
            }
        } else {
            echo "<form name='username_retrieve' method='post' action='index.php?page=forgotten&method=username'>\r\n
            <p><input type='email' name='email' placeholder='Enter your email address' /></p>\r\n
            <p><input type='password' name='password' placeholder='Enter your password' /></p>\r\n
            <p><input type='submit' name='username_retrieve' /></p>\r\n
            </form>\r\n";
        }
    } else if($_GET['method'] == 'password'){
        if(isset($_POST['reset_password'])){
            $token = md5(uniqid(microtime(), true));

        	$pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i";
            if (preg_match($pattern, trim(strip_tags($_POST['email'])))) {
                $cleanedFrom = trim(strip_tags($_POST['email']));
            } else {
                $_SESSION['error'] = "The email address you entered was invalid. Please try again!";
            }

            //   CHANGE THE BELOW VARIABLES TO YOUR NEEDS
        	$to = $cleanedFrom;
        	$subject = 'Password Reset';

        	$message = '<html><body>';
        	$message = '<table border="0" cellpadding="10" width="100%" style="background: #FDFDFD; font-family: Tahoma,Verdana,sans-serif;">';
        	$message .= "<tr style='background: #eee; text-align: center; text-transform: capitalize; fonat-variant: small-caps; '><td>Your password change request</td></tr>";
        	$message .= "<tr><td><p>This email is being sent to you because you or someone has requested a change of your password for  your account. Ignore this email if you have recieved it by mistake. Nothing on your account will be changed.</p>
        	<p>Click on the link below to reset your password. <br /><a href=index.php?page=password_reset&t=".$token."&e=".$cleanedFrom."'>Link for password reset</a><br />If you do not see a clickable link above copy and paste the link into your address bar.</p></td></tr>";
        	$message .= "<tr><td><p>If there are any questions regarding this email. Please feel free to check our <a href='#'>Frequently asked questions</a> page or send an email to <a href='mailto:mike@martinywebdesign.com'>mike@martinywebdesign.com</p></td></tr>";
        	$message .= "</body></html>";

        	$headers = "From: mike@martinywebdesign.com\r\n";
        	$headers .= "Reply-To: mike@martinywebdesign.com\r\n";
        	$headers .= "MIME-Version: 1.0\r\n";
        	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            if (mail($to, $subject, $message, $headers)) {
                echo "<p class='msg-info'>Your message has been sent.</p>";
                $mydb = new myDBC();
                $sql="UPDATE `users_table` SET token='".$token."' WHERE `email`='".$email."'";
                $mydb->runQuery($sql);
            } else {
                 $_SESSION['error'] = "There was a problem sending the email!";
            }
        } else {
            echo "<form name='reset_password' method='post' action='index.php?page=forgotten&method=password'>\r\n
            <input type='text' name='email' placeholder='Enter your email address' />\r\n
            <input type='submit' name='reset_password' value='Reset Password'/>\r\n
            </form>\r\n";
        }
    } else {
        echo "<button onclick=\"location.href='index.php?page=forgotten&method=username'\">Retrive Username</button>\r\n
        <br />\r\n
        <button onclick=\"location.href='index.php?page=forgotten&method=password'\">Reset Password</button>\r\n";
    }
    echo messages();
?>
