<?php
    session_start();
    $string = '';
    
    $dir = 'captcha_fonts/';

    $image = imagecreatetruecolor(170, 60);
    $black = imagecolorallocate($image, 0, 0, 0);
    $color = imagecolorallocate($image, 200, 100, 90); // red
    $white = imagecolorallocate($image, 255, 255, 255);
    
    imagefilledrectangle($image,0,0,200,100,$white);
    
    //imagettftext($image, $font_size, $angle, $x, $y, $color ,$font_file ,$text);
    imagettftext($image, 30, 0, 10, 40, $alt, $dir."JollyLodger.ttf", $_SESSION['rand_code']);
    
    header("Content-type: image/png");
    imagepng($image);
?>