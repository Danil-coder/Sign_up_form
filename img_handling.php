<?php

function image_handling(){
	
	// Creating a directory for storing images:
	
	$dir = "images";
	if(!file_exists($dir)) mkdir($dir);
	
	// Limiting the maximum photo size (5 MB)	
	$max_size = 5242880;
	$img_errors = array();

	if(is_uploaded_file($_FILES['image']['tmp_name'])){
		
		// Getting and checking image format:
		$ext = array_pop(explode(".", $_FILES['image']['name']));
	
			if($ext == 'jpg' || $ext == 'gif' || $ext == 'png' || $ext == 'JPG' || $ext == 'PNG' || $ext == 'GIF'|| $ext == 'jpeg'){
				
				// Checking image size:
				if ($_FILES['image']['size'] <= $max_size){
					
					// Creating an image path on the server:
					$img_link = ($dir.'/'.time().rand(1,9).'.'.$ext);
					
					// Getting geometric parameters of an image:
					$size = getimagesize($_FILES['image']['tmp_name']);
					$cut = abs(round(($size[0] - $size[1])/2));
					$side_length = min($size[0], $size[1]);
					
					// Creating the resource of image:
					if ($ext == 'jpg' || $ext == 'JPG' || $ext == 'jpeg') $new = imagecreatefromjpeg($_FILES['image']['tmp_name']);
					if ($ext == 'png' || $ext == 'PNG') $new = imagecreatefrompng($_FILES['image']['tmp_name']);
					if ($ext == 'gif' || $ext == 'GIF') $new = imagecreatefromgif($_FILES['image']['tmp_name']);
					
					// Converting an image to a square:
					if ($size[0] > $size[1]) $img_resource = imagecrop($new, ['x' => $cut, 'y' => 0, 'width' => $side_length, 'height' => $side_length]);
					if ($size[0] < $size[1]) $img_resource = imagecrop($new, ['x' => 0, 'y' => $cut, 'width' => $side_length, 'height' => $side_length]);
					
					// Creating jpeg image that will storing on the server:
					if ($avatar = imagejpeg($img_resource, $img_link)){

					}else{
			// Displaying an errors:
						$img_errors[] = $parse_lang[$lang]['image_upload_error'];
					}
				}else{
					$img_errors[] = $parse_lang[$lang]['image_over_size'];
				}
			}else{
				$img_errors[] = $parse_lang[$lang]['undefined_image_format'];
			}
	}

	return $img_link;
	return $img_errors;
}

?>