<?php 

function ListImages($connect){

	$statement = $connect->prepare("SELECT * FROM images");
	$statement->execute();
	$data = $statement->fetchAll();
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

	return $data;
}

function getImageId($connect, $image){

	$statement = $connect->prepare("SELECT id FROM images WHERE images.filename = ?");
	$statement->execute([$image]);
	$data = $statement->fetch();
	return $data;

}

function select($connect, $image){

	$path = "./assets/img/";
	$data1 = $path.$image;
	$data1 = resize($data1);
	$id = getImageId($connect, $image);
	$lastMemes = lastMemes($connect, $id);
	$data = [];
	array_push($data, ['path'=>$data1], ['lastMemes'=>$lastMemes]);	
		
	return $data;
}


function lastMemes($connect, $id){
	// echo '<pre>'; var_dump($id); echo '</pre>'; die();
	$request = "SELECT filename FROM `memes` WHERE images_id = :id ORDER BY id DESC LIMIT 10";
	$statement = $connect->prepare($request);
	$statement->execute([
		'id' => $id['id']
	]); 
	$data = $statement->fetchAll();
	// echo '<pre>'; var_dump($data); echo '</pre>'; die();
	return $data;
}

function resize($path){
	$filename = basename($path);
	// echo '<pre>'; var_dump($filename); echo '</pre>'; 
	$info = pathinfo($filename);
	// echo '<pre>'; var_dump($info); echo '</pre>'; 
	$file_name =  basename($filename,'.'.$info['extension']);
	// echo '<pre>'; var_dump($file_name); echo '</pre>';

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

	$data = [];

	$temp_img = $_POST['path'];
	$image_taille = getimagesize($temp_img);

	$width = $image_taille[0]; 
	$height = $image_taille[1];
	$x = $width / 2;
	$y = $height - 10 ;

	$text1 = htmlspecialchars(strtoupper($_POST['top-text']));
	$im = imagecreatefromjpeg($temp_img);
	$color = $_POST['color'];
	$color = getColor($im, $color);

	$font ='./assets/fonts/impact.ttf';

	// Retourne le rectangle entourant le texte
	$taille1 = imagettfbbox(22, 0, $font, $text1);
	//centrer le top text
	$width1 = $taille1[2] + $taille1[0];
	$height1 = $taille1[1] + $taille1[7];
	
	$x1 = (380 - $width1) / 2;
	$y1 = (50 - $height1) / 2;
	imagettftext($im, 25, 0, $x1, $y1, $color, $font, $text1);

	//centrer le bottom text 
	$text2 = htmlspecialchars(strtoupper($_POST['bottom-text']));
	$taille2 = imagettfbbox(22, 0, $font, $text2);
	
	$width2 = $taille2[2] + $taille2[0];
	// $height2 = $taille2[1] + $taille2[7];

	$x2 = (380 - $width2) / 2;
	// $y2 = (800 - $height2) / 2;

	imagettftext($im, 25, 0, $x2, $y, $color, $font, $text2);	

	//préparation pour stocker dans la base de données
	$memeName = time();
	//récupérer le nom du fiechier original
	$filename = substr(basename($temp_img),8);
	// echo '<pre>'; var_dump($filename); echo '</pre>'; die();
	$id = getImageId($connect, $filename);
	// echo '<pre>'; var_dump($id); echo '</pre>'; die();

	uploadMeme($connect, $memeName, $id['id']);

	$pathMeme = "./memes/".$memeName.".jpg";
	$dlMeme = $memeName.".jpg";

	imagejpeg($im, $pathMeme);

	//free memory
	imagedestroy($im);

	//delete temp resized image
	unlink($temp_img);

	array_push($data, ['path' => $pathMeme], ['name' => $dlMeme]);
	var_dump($data);


	return $data;
}

function getColor($im, $color){

	$hex = $color;
	$hex = ltrim($hex,'#');
	$a = hexdec(substr($hex,0,2));
	$b = hexdec(substr($hex,2,2));
	$c = hexdec(substr($hex,4,2));
	return imagecolorallocate($im, $a, $b, $c);
}


function uploadMeme($connect, $memeName, $id){
	// echo '<pre>'; var_dump($id); echo '</pre>'; die();
	$date = new DateTime();
	$date = $date->format('Y-m-d H:i:s');
	// echo '<pre>'; var_dump($date); echo '</pre>'; die();
	$meme = $connect->prepare("INSERT INTO memes (filename, date, images_id) VALUES (:memeName, :date, :image_id)");  
	$meme->execute(array(
		'memeName'=> $memeName, 
		'date'=> $date,
		'image_id'=> $id
	));

}


?>
