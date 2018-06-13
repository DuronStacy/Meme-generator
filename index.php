<?php 

require_once 'vendor/autoload.php';
require 'controllers/controller.php';
require 'models/connect.php';


$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader, [
	'cache' => false
]);

$twig->addFunction(new \Twig_SimpleFunction('baseUrl', function ($url) {

	$rootUrl = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);

	return $rootUrl.$url;

}));
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
			// var_dump($_POST['path']); die();
		$msg = "please enter text";
		ctrlSelectImage($twig, $connect, basename($_POST['path']), $msg);
	}
	break;
	
	default:
	ctrlListImages($twig, $connect);
	break;
}


?>
