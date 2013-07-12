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
# Neue Sat-Bilder in den Cache laden
$InsertedNum = lingx_GetRemoteSatImages($FTPArray, $LocalDir, $RemoteDir, $RemoteFiles, $DownloadInterval);
lingx_DisplayText($Texts['NumOfSatImagesSavedMessage'], 'echo', $DefaultColor, false, '', array('%insertednum%'), array($InsertedNum));
echo '<br />';
# Alte Sat-Bilder löschen
$DeletedNum = lingx_ClearCache($LocalDir, $ClearCacheInterval);
lingx_DisplayText($Texts['NumOfSatImagesDeletedMessage'], 'echo', $DefaultColor, false, '', array('%deletednum%'), array($DeletedNum));
mysql_close($DBConnection);
exit;
?>