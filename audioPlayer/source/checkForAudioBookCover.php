<?php
$ROOT_FOLDER = "i:/__ DL __/--== AUDIO BOOKS ==--/";
$MAX_IMAGE_DIMENSION = 400;
if ($_GET["foldername"]) {
	$requestedFolder = $_GET["foldername"];
	$folderName = $ROOT_FOLDER . $_GET["foldername"];
	$coverImageArray = array_slice(scandir($folderName),2);
} else {
	$requestedFolder = "Stephen King - Blood and Smoke";
	$folderName = $ROOT_FOLDER . $requestedFolder;
	$coverImageArray[] = "cover.jpg";
}

foreach ($coverImageArray as $coverImage) {
	$extension = substr($coverImage, -4);
	if ($extension == ".jpg" || $extension == ".png" || $extension == ".gif") {
		$fileSize = getimagesize($folderName . '/' . $coverImage);
		$width = $fileSize[0]; $height = $fileSize[1];
		if ($width>$height) {
			$height = ($MAX_IMAGE_DIMENSION / $width ) * $height;
			$width = $MAX_IMAGE_DIMENSION;
		} else {
			$width = ($MAX_IMAGE_DIMENSION / $height) *  $width;
			$height = $MAX_IMAGE_DIMENSION;
		}
		echo '<div style="background-size: contain; background-image: url(\'/AudioBooksFolder/' . $requestedFolder . '/' . $coverImage . '\'); width: ' . $width . 'px; height: ' . $height . 'px">&nbsp;</div>';
	}
}

?>