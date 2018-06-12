<?php 

require 'models/model.php';


function ctrlListImages($twig, $connect) {
	echo $twig->render('home.html', ['data' => ListImages($connect)]);
}

function ctrlSelectImage($twig, $connect, $image, $msg){
	echo $twig->render('create.html', ['data' => select($connect, $image), 'message'=> $msg]);
}

function ctrlListByCategorie($twig, $connect, $categorie){
	echo $twig->render('filter.html', ['data' => listCategories($connect, $categorie)]);
}

// function ctrlText($twig, $connect){
// 	echo $twig->render('create.html', ['massage' => "please enter text"]);
// }

function ctrlCreateMeme($twig, $connect, $posted){
	// var_dump($_server);die();
	echo $twig->render('result.html', ['data' => createMeme($connect, $posted)]);
}



?>

