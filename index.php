<?php 

require_once 'vendor/autoload.php';
require 'controllers/controller.php';
require 'models/connect.php';


$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader, [
	'cache' => false
]);
$msg = "";


switch (true) {
	case !empty($_GET['image']):
	ctrlSelectImage($twig, $connect, $_GET['image'],$msg);
	break;

	case !empty($_POST['categorie']):
	ctrlListByCategorie($twig, $connect, $_POST);
	break;

	case isset($_POST['save']):
		if(($_POST['top-text'] !="") || ($_POST['bottom-text'] !="")){
			ctrlCreateMeme($twig, $connect, $_POST);
			
			
		}else{
			$msg = "please enter text";
			ctrlSelectImage($twig, $connect, substr(basename($_POST['path']),8), $msg);
			
			
		}
		break;
	
	default:
	ctrlListImages($twig, $connect);
	// foreach(gd_info() as $key => $value) 
	// echo "$key: <b>$value</b><br />"; 
	// ctrlLastMemes($twig, $connect);
	break;
}


?>
