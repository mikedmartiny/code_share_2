<?php
if(isset($_POST['submit'])) {
    if($_POST['color'] == $_POST['color_answer'] && !empty($_POST['color'])){
        $name = $db->real_escape_string($_POST['name']);
	    $username = $db->real_escape_string($_POST['username']);
	    $email = $db->real_escape_string($_POST['email']);
	    $salt = genenrate_salt();
	    $password = $db->real_escape_string($_POST['password1']);
	    $salted_password = genenrate_password($salt , $password);
            foreach($_POST as $field){
                if(empty($field)){
                    $_SESSION['error'] = "Please fill out the entire form.";
                    break;
                }
            }

            if($_POST['password1'] != $_POST['password2']) {
                $_SESSION['error'] = "Passwords do not match!";
            }

            if(!preg_match("/^[a-zA-Z'-]+$/",$name)) {
                $_SESSION['error'] = "Enter a valid name!";
            }

            if (!preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $username)){
                $_SESSION['error'] = "Enter a valid username!";
            } else {
                if(user_exsits($username)){
                    $_SESSION['error'] = "The username ".$username." is all ready being used!";
                }
            }

            if (validateEmail($email) === false){
                $_SESSION['error'] = "E-mail is not a valid email address";
            } else {
                if(email_exsits($email)){
                    $_SESSION['error'] = "The email that you provided is all ready associated with an account";
                }
            }
	} else {
		$_SESSION['error'] = "Please verify that you typed in the correct color name.";
	}


	if(empty($_SESSION['error'])){
        //$sql="INSERT INTO `users_table` (`name`,`username`,`email`,`salt`,`password`) VALUES ('".$name."','".$username."','".$email."','".$salt."','".$salted_password."')";

//        if($db->query($sql) === false) {
  //        trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
    //    } else {
      //      //$_SESSION['success'] = "You have successfully created an account!";
        //}
	}

}

$color = array('blue', 'black', 'purple', 'yellow', 'red','green','brown','DarkBlue','DarkGreen','gray');
$right_answer = array_rand($color, 1);
$wrong_answers = array_rand($color, 2);
$randomdivcolor = $color[$right_answer];

$multiple_choice = array($color[$wrong_answers[0]], $color[$wrong_answers[1]], $color[$right_answer]);
shuffle($multiple_choice);
?>
<form class="registration" name="registration" action="index.php?page=register" method="post" enctype="multipart/form-data">
    <h1>Register for an account</h1>
    <?php echo messages(); ?>
	<p>
	    <input type="text" name="name" placeholder="Name" />
	</p>
	<p>
	    <input type="text" name="username" placeholder="Username" />
	</p>
	<p>
	    <input type="text" name="email" placeholder="email" />
    </p>
    <p>
	    <input type="password" name="password1" placeholder="password" />
    </p>
    <p>
	    <input type="password" name="password2" placeholder="password again" />
    </p>
    <p class="captcha" style="background-color:<?php echo $randomdivcolor ?>"></p>
    <input type="hidden" name="color" value="<?php echo $randomdivcolor ?>" />
    <span>What color fits the above color</span>
    <ul class="color-answers">
    <?php
        foreach($multiple_choice as $choice){
            echo "<li>".$choice."</li>";
        }
    ?>
    </ul>
	<p>
	    <input type="text" name="color_answer" placeholder="What is the color above"/>
    </p>
	<p>
	    <input type="submit" name="submit" value="register" />
    </p>
</form>
