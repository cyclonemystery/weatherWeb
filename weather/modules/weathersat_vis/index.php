<?php
### (C) 2013 by Jens Federow
### www.lingx.de
header('content-type: text/html; charset=utf-8');
define('VERIFIED', 1);
# Konfigurationsdateien laden
require_once '../../includes/inc.configuration.php';
require_once 'includes/inc.configuration.php';
require_once 'includes/inc.module.php';
require_once 'includes/inc.database.php';
$Texts = array_merge($Texts, $ModuleTexts);
# Funktionen laden
require_once '../../includes/inc.functions.php';
require_once 'includes/inc.functions.php';
# Bilder auslesen und in einen Array packen
$SatImages = array();
$SatImagesQuery = lingx_DBQuery("select sat_image_name from ".DB_TABLE_SAT_IMAGES." order by sat_image_name desc limit ".$MaxImagesNum);
while($SatImagesArray = lingx_DBFetchArray($SatImagesQuery))
{
  $SatImage = $LocalDir.$SatImagesArray['sat_image_name'];
  if(file_exists($SatImage))
  {
    $SatImages[] = $ModuleDir.$SatImage;
  }
}
$SatImages = array_reverse($SatImages);
# Ausgabe Template laden
require_once 'templates/tpl.overview.php';
mysql_close($DBConnection);
exit;
?>