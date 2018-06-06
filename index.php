<?php 

require_once 'vendor/autoload.php';
require 'controllers/controller.php';
require 'models/connect.php';


$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader, [
	'cache' => false
]);

switch (true) {
	case !empty($_GET['image']):
	ctrlSelectImage($twig, $connect, $_GET['image']);
	break;

	case !empty($_POST):
	ctrlListByCategorie($twig, $connect, $_POST);
	break;
	
	default:
	ctrlListImages($twig, $connect);
	// foreach(gd_info() as $key => $value) 
	// echo "$key: <b>$value</b><br />"; 
	// ctrlLastMemes($twig, $connect);
	break;
}


?>
