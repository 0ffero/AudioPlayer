<?php
$currentTime = $_GET["currenttime"];
$folderName  = trim($_GET["foldername"]);
$fileName    = trim($_GET["filename"]);

if (is_numeric($currentTime) && strlen($folderName)>0 && strlen($fileName)>0) {
	$data = $fileName . "\r\n" . $currentTime;
	file_put_contents("i:/__ DL __/--== AUDIO BOOKS ==--/" . $folderName . "/__position.log", $data);
	echo "File Saved";
} else {
	echo "Invalid Data Sent";
}
?>