<?php

require_once '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader, array(
	'cache' => false));

$path = '.'.$_POST['path'];
$filename = basename($path);
$info = pathinfo($filename);
$file_name =  basename($filename,'.'.$info['extension']);
$text = htmlspecialchars(strtoupper($_POST['top-text']));

// RESIZE IMAGE //
$img = $path;
$temp_img = '../assets/img/resized_'.$file_name.'.'.$info['extension'];
$width = 400;
$height = 0;
$useGD = TRUE;

$dimensions = getimagesize($img);
$ratio      = $dimensions[0] / $dimensions[1];

// Calcul des dimensions si 0 passé en paramètre
if($width == 0 && $height == 0){
	$width = $dimensions[0];
	$height = $dimensions[1];
}elseif($height == 0){
	$height = round($width / $ratio);
}elseif ($width == 0){
	$width = round($height * $ratio);
}

if($dimensions[0] > ($width / $height) * $dimensions[1]){
	$dimY = $height;
	$dimX = round($height * $dimensions[0] / $dimensions[1]);
	$decalX = ($dimX - $width) / 2;
	$decalY = 0;
}
if($dimensions[0] < ($width / $height) * $dimensions[1]){
	$dimX = $width;
	$dimY = round($width * $dimensions[1] / $dimensions[0]);
	$decalY = ($dimY - $height) / 2;
	$decalX = 0;
}
if($dimensions[0] == ($width / $height) * $dimensions[1]){
	$dimX = $width;
	$dimY = $height;
	$decalX = 0;
	$decalY = 0;
}

// Création de l'image avec la librairie GD
if($useGD){
	$pattern = imagecreatetruecolor($width, $height);
	$type = mime_content_type($img);
	switch (substr($type, 6)) {
		case 'jpeg':
		$image = imagecreatefromjpeg($img);
		break;
		case 'gif':
		$image = imagecreatefromgif($img);
		break;
		case 'png':
		$image = imagecreatefrompng($img);
		break;
	}
	imagecopyresampled($pattern, $image, 0, 0, 0, 0, $dimX, $dimY, $dimensions[0], $dimensions[1]);
	imagedestroy($image);
	imagejpeg($pattern, $temp_img, 100);
}


// var_dump($text);

$im = imagecreatefromjpeg($temp_img);
$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);

//$text = $_POST['text'];
$font = dirname(__FILE__) . '/fonts/arial.ttf';

imagettftext($im, 22, 0, 15, 40, $white, $font, $text);

$memeName = time();

// uploadMeme($memeName);
$pathMeme = "../assets/img/memes/".$memeName.".jpg";
imagejpeg($im, $pathMeme);
echo $twig->render('test.html', array( 'im' => $pathMeme));

//free memory
imagedestroy($im);

//delete temp resized image
unlink($temp_img);

?>