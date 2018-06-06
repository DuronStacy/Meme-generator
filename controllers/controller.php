<?php 

require 'models/model.php';


function ctrlListImages($twig, $connect) {
	echo $twig->render('home.html', ['data' => ListImages($connect)]);
}

function ctrlSelectImage($twig, $connect, $image){
	echo $twig->render('create.html', ['data' => select($connect, $image)]);
}

function ctrlListByCategorie($twig, $connect, $categorie){
	echo $twig->render('filter.html', ['data' => listCategories($connect, $categorie)]);
}

function ctrlLastMemes($twig, $connect){
	echo $twig->render('home.html', ['data' => lastMemes($connect)]);
}

function ctrlCreateMeme($twig, $connect, $posted){
	echo $twig->render('result.html', ['data' => createMeme($connect, $posted)]);
}



?>

