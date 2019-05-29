<?php
$rootFolder = "i:/__ DL __/--== AUDIO BOOKS ==--/";
$folderName = $rootFolder . $_GET["folder"];
$positionFile = $folderName . "/__position.log";

$files = scandir($folderName);

if (file_exists($positionFile)) {
	$positionArray = explode("\r\n", file_get_contents($positionFile));
	$currentFile = $positionArray[0];
	$currentFilePosition = $positionArray[1];
}

foreach ($files as $file) {
	if (substr_count($file, ".mp3") == 1 || substr_count($file, ".m4a") == 1 || substr_count($file, ".m4b") == 1) {
		$data=''; $class='';
		if ( $file == $currentFile ) {
			$class = ' playing';
			$data  = ' data-currentposition="' . $currentFilePosition . '" ';
		}
		echo '<div class="file' . $class . '"' . $data . '>' . $file . '</div>';
	}
}
?>