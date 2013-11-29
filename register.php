<?php
if(isset($_POST['submit'])) {
    if($_POST['color'] == $_POST['color_answer'] && !empty($_POST['color'])){
        $name = $db->real_escape_string($_POST['name']);
	    $username = $db->real_escape_string($_POST['username']);
	    $email = $db->real_escape_string($_POST['email']);
	    $salt = genenrate_salt();
	    $password = $db->real_escape_string($_POST['password1']);
	    $salted_password = hash('SHA256', $password);
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
	    $mydb = new myDBC();
	    $sql="INSERT INTO `users_table` (`name`,`username`,`email`,`salt`,`password`) VALUES ('".$name."','".$username."','".$email."','".$salt."','".$salted_password."')";
	    $mydb->runQuery($sql);
	}

}

$color = array('blue', 'black', 'purple', 'yellow', 'red','green','brown','DarkBlue','DarkGreen','gray','silver');
$right_answer = array_rand($color, 1);
$wrong_answers = array_rand($color, 2);
$randomdivcolor = $color[$right_answer];

$multiple_choice = array($color[$wrong_answers[0]], $color[$wrong_answers[1]], $color[$right_answer]);
$answers = array();
foreach ($multiple_choice as $choice){
    if (!in_array($choice, $answers)){
        array_push($answers, $choice);
    } else if (in_array($choice, $answers)) {
        array_push($answers, "Olive");
    }
}
shuffle($answers);
?>
<form class="registration" name="registration" action="index.php?page=register" method="post" enctype="multipart/form-data">
    <h1>Register for an account</h1>
    <?php echo messages(); ?>
	<p>
	    <input type="text" name="name" placeholder="Name" value="<?php if(isset($name)){echo $name;} ?>" />
	</p>
	<p>
	    <input type="text" name="username" placeholder="Username" value="<?php if(isset($username)){echo $username;} ?>" />
	</p>
	<p>
	    <input type="text" name="email" placeholder="email" value="<?php if(isset($email)){echo $email;} ?>" />
    </p>
    <p>
	    <input type="password" name="password1" placeholder="password" />
    </p>
    <p>
	    <input type="password" name="password2" placeholder="password again" />
    </p>
    <p>
        <select name="secret_question">
            <option>What was your childhood nickname?</option>
            <option>In what city did you meet your spouse/significant other?</option>
            <option>What is the name of your favorite childhood friend? </option>
            <option>What street did you live on in third grade?</option>
            <option>What is your oldest sibling’s birthday month and year? (e.g., January 1900)</option>
            <option>What is the middle name of your oldest child?</option>
            <option>What is your oldest sibling's middle name?</option>
            <option>What school did you attend for sixth grade?</option>
            <option>What was your childhood phone number including area code? (e.g., 000-000-0000)</option>
            <option>What is your oldest cousin's first and last name?</option>
            <option>What was the name of your first stuffed animal?</option>
            <option>In what city or town did your mother and father meet? </option>
            <option>Where were you when you had your first kiss? </option>
            <option>What is the first name of the boy or girl that you first kissed?</option>
            <option>What was the last name of your third grade teacher?</option>
            <option>In what city does your nearest sibling live?</option>
            <option>What is your oldest brother’s birthday month and year? (e.g., January 1900) </option>
            <option>What is your maternal grandmother's maiden name?</option>
            <option>In what city or town was your first job?</option>
           <option> What is the name of the place your wedding reception was held?</option>
            <option>What is the name of a college you applied to but didn't attend?</option>
            <option>Where were you when you first heard about 9/11?</option>
        </select>
    </p>
    <p>
	    <input type="text" name="secret_answer" placeholder="secret question answer" />
    </p>
    <p class="captcha" style="background-color:<?php echo $randomdivcolor ?>"></p>
    <input type="hidden" name="color" value="<?php echo $randomdivcolor ?>" />
    <span>What color fits the above color</span>
    <ul class="color-answers">
    <?php
        foreach($answers as $answer){
            echo "<li>".$answer."</li>";
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
