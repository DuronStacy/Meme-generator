<?php 


function ListImages($connect){

	$statement = $connect->prepare("SELECT * FROM images");
	$statement->execute();
	$data = $statement->fetchAll();
	
	
	// echo '<pre>';
	// var_dump($data);
	// echo '</pre>';

	return $data;
}

function listCategories($connect, $categorie){

	$categorie = implode("|",$categorie);
	$request = "SELECT filename  FROM categories
	INNER JOIN images_categ ON categories.id = images_categ.categories_id
	INNER JOIN images ON images_categ.images_id = images.id
	WHERE categories.name = :categorie";
	$statement = $connect->prepare($request);
	$statement->execute(array(
		'categorie' => $categorie
	));
	$data = $statement->fetchAll();

	// echo '<pre>';
	// var_dump($data);
	// echo '</pre>';

	return $data;
}

function create($connect, $image){




	$statement = $connect->prepare("SELECT * FROM images WHERE images.filename = ?");
	$statement->execute([$image]);
	$data = $statement->fetch();
	$path = "./assets/img/upload/";
	$data = $path.$image;

	echo '<pre>';
	var_dump($data);
	echo '</pre>';
	return $data;
}


function lastMemes($connect){

	$request = "SELECT * FROM `memes` ORDER BY id DESC LIMIT 10";
	$statement = $connect->prepare($request);
	$statement->execute();
	$data = $statement->fetchAll();

	// echo '<pre>';
	// var_dump($data);
	// echo '</pre>';
	return $data;
}
function addMeme(){

}
function getMeme(){

}

// function egitImage($image){
// 	// editer l'image pour la modifier
// 	imagecreatetruecolor(int $width, int $height);
// 	// sauvgarder l'image 
// 	imagepng();
	
	
// }


?>