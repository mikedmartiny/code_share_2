<?php
    function user_exsits($username) {
        $mydb = new myDBC();

        $sql="SELECT `username` FROM `users_table` WHERE `username` = '".$username."' LIMIT 1";
        $result = $mydb->runQuery($sql);

        if($result = $mydb->totalCount('username', 'users_table', $where = "WHERE `username` = '".$username."'") > 0) {
          return true;
        } else {
          return false;
        }
    }

    function email_exsits($email) {
        $mydb = new myDBC();

        $sql="SELECT `email` FROM `users_table` WHERE `email` = '".$email."' LIMIT 1";
        $result = $mydb->runQuery($sql);

        if($result = $mydb->totalCount('email', 'users_table', $where = "WHERE `email` = '".$email."'") > 0) {
          return true;
        } else {
          return false;
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

    function valid_pass($candidate) {
        if (!preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $candidate))
            return FALSE;
        return TRUE;
    }

    function genenrate_password($salt,$pass){
        $password_hash = '';
        $mysalt = $salt;
        $password_hash= hash('SHA256', "-".$mysalt."-".$pass."-");
        return $password_hash;
    }
?>