<?php
    function user_exsits($username) {
        $sql="SELECT `username` FROM `users_table` WHERE `username` = '".$username."'";
        $rs=$db->query($sql);

        if($rs === false) {
          return false;
        } else {
          return true;
        }
    }

    function email_exsits($email) {
        $sql="SELECT `email` FROM `users_table` WHERE `email` = '".$email."'";
        $rs=$db->query($sql);

        if($rs === false) {
          return false;
        } else {
          return true;
        }
    }

    function validateEmail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function messages(){
        $message = '';
        if(!empty($_SESSION['success'])) {
            $message = '<div class="msg-ok">'.$_SESSION['success'].'</div>';
            $_SESSION['success'] = '';
        } else if(!empty($_SESSION['error'])) {
            $message = '<div class="msg-error">'.$_SESSION['error'].'</div>';
    		$_SESSION['error'] = '';
        } else if (!empty($_SESSION['warning'])) {
            $message = '<div class="msg-warning">'.$_SESSION['warning'].'</div>';
            $_SESSION['warning'] = '';
        }
        return $message;
    }

    function genenrate_salt(){
        $rndstring = "";
        $length = 64;
        $a = "";
        $b = "";
        $template = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        settype($length, "integer");
        settype($rndstring, "string");
        settype($a, "integer");
        settype($b, "integer");
        for ($a = 0; $a <= $length; $a++) {
            $b = rand(0, strlen($template) - 1);
            $rndstring .= $template[$b];
        }
            return $rndstring;
    }

    function genenrate_password($salt,$pass){
        $password_hash = '';
        $mysalt = $salt;
        $password_hash= hash('SHA256', "-".$mysalt."-".$pass."-");
        return $password_hash;
    }
?>