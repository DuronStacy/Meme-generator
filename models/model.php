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

function select($connect, $image){

	$path = "./assets/img/";
	$data = $path.$image;
	$data = resize($data);

	return $data;
}


function lastMemes($connect){

	$request = "SELECT * FROM `memes` ORDER BY id DESC LIMIT 10";
	$statement = $connect->prepare($request);
	$statement->execute();
	$data = $statement->fetchAll();

	return $data;
}
function resize($path){

	$filename = basename($path);
	$info = pathinfo($filename);
	$file_name =  basename($filename,'.'.$info['extension']);

	$img = $path;
	$temp_img = './assets/img/resized_'.$file_name.'.'.$info['extension'];
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
	}return $temp_img;
}

function createMeme($connect, $posted){

	$temp_img = $_POST['path'];
	$text = htmlspecialchars(strtoupper($_POST['top-text']));

	$im = imagecreatefromjpeg($temp_img);
	$white = imagecolorallocate($im, 255, 255, 255);
	$grey = imagecolorallocate($im, 128, 128, 128);


	$font ='./assets/fonts/arial.ttf';

	imagettftext($im, 22, 0, 5, 40, $white, $font, $text);

	$memeName = time();

// uploadMeme($memeName);
	$pathMeme = "./memes/".$memeName.".jpg";

	imagejpeg($im, $pathMeme);

//free memory
	imagedestroy($im);

//delete temp resized image
	unlink($temp_img);

	$data = $pathMeme;
	return $data;
}

function saveMeme($connect, $posted){
	var_dump($posted);

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