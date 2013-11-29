<?php require_once('includes/core/init.php');
    if(isset($_POST['submit'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        if(!empty($username) || !empty($password)) {
            //I'm actually in class and can't be bothered too much I'll get back asap. I won't obviously won't have much time after school. Happy thanksgiving.
        } else {
            //errors??
        }
    }
?>
<html>
    <head>
        <title>login page</title>
    </head>
    <body>
        <form action="" method="post">
            <input type="text" name="username" />
            <input type="password" name="password" />
            <button type="submit" name="submit">Login</button>
        </form>
    </body>
</html>