<?php
$hiddenFolderArray = array("oldshit", "brain sync", "book of mormon", "hypnosis super", "lucid dreaming", "stephen king mass", "jumgle book", "dark tower series");
$rootFolderName = "i:/__ DL __/--== AUDIO BOOKS ==--";
$folders = array_slice(scandir($rootFolderName),2);

foreach ($folders as $folderName) {
	if (is_dir($rootFolderName . "/" . $folderName)) {
		$found = false;
		foreach ($hiddenFolderArray as $hiddenFolder) {
			if (substr_count(strtolower($folderName), $hiddenFolder)>0) {
				$found = true; break;
			}
		}
		
		if ($found == false) {
			echo '<div class="folder" data-foldername="' . $folderName . '">' . $folderName;
			
			// check to see if this audiobook has a timestamp saved
			$positionFile = $rootFolderName . "/" . $folderName . "/__position.log";
			if (file_exists($positionFile)) {
				// get position details by checking the audiobooks folder
				$positionArray = explode("\r\n", file_get_contents($positionFile));
				$fileList = scandir($rootFolderName . "/" . $folderName);
				$fileCounter = 0;
				foreach ( $fileList as $fileName) {
					if (substr_count($fileName, ".mp3") == 1 || substr_count($fileName, ".m4a") == 1 || substr_count($fileName, ".m4b") == 1) {
						if ($fileName == $positionArray[0]) {
							// file found
							$filePositionInPlaylist = $fileCounter;
						}
						$fileCounter++;
					}	
				}
				$percentagePlayed = floor((100 / $fileCounter) * $filePositionInPlaylist);
				$percentageLeft   = 100 - $percentagePlayed;
				echo '<div style="width: 100%; margin-bottom: 10px;"><span style="background-color: #004400; width: ' . $percentagePlayed . '%;">&nbsp;</span><span style="background-color: #00c806; width: ' . $percentageLeft . '%;"></span></div>';
			}
			echo '</div>';
		}
	}
}
?>