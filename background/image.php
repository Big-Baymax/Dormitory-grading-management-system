<?php
/**
 * Created by PhpStorm.
 * User: 10367
 * Date: 2017/1/29
 * Time: 15:39
 */
require_once 'string.func.php';
$width=119;
$height=40;
$image=imagecreatetruecolor($width,$height);
$white=imagecolorallocate($image,255,255,255);
$whith=imagecolorallocate($image,255,255,255);
imagefilledrectangle($image,1,1,$width-2,$height-2,$white);
$chars=buildRandomString(4);
session_start();
$fontfiles=array('TrainStation.ttf','uchiyama.ttf','WELCOME TO THE JUNGLE.ttf');
$_SESSION['CAPTCHA']=$chars;
for($i = 0;$i < strlen($chars);$i ++){
    $size=mt_rand(23,27);
    $angle=mt_rand(-15,15);
    $x=5+$i*$size;
    $y=mt_rand(25,30);
    $fontfile='../fonts/'.$fontfiles[mt_rand(0,count($fontfiles)-1)];
    $color=imagecolorallocate($image,mt_rand(50,90),mt_rand(80,200),mt_rand(90,180));
    $text=$chars[$i];
    imagettftext ($image,$size,$angle,$x,$y,$color,$fontfile,$text);
}
header("Content-type: image/png");
imagepng($image);
imagedestroy($image);
