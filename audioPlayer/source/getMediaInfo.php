<?php
$rootFolder = "i:/__ DL __/--== AUDIO BOOKS ==--/";
$file = $rootFolder . "HHGTTG (Book 1) The Hitchhiker's Guide to the Galaxy/HHGTTG (Book 1) The Hitchhiker's Guide to the Galaxy.m4b";
$mediaInfoBlock = explode("\n\n", `c:\wamp\_php_cli_apps\mediainfo\MediaInfo.exe "{$file}"`);

$mediaStatsArray = array();

foreach ($mediaInfoBlock as $section) {
    $sectionArray = explode("\n", $section);
    $sectionName = array_shift($sectionArray);

    foreach ($sectionArray as $details) {
        $key = ucwords(trim(substr(substr($details, 0, 43), 0, -2)));
        $data = trim(substr($details, 43));
        if ($key && $data) {
            $mediaStatsArray[$sectionName][$key] = $data;
        }
    }
}

echo "<pre>"; print_r($mediaStatsArray); echo "</pre>"; exit;
?>