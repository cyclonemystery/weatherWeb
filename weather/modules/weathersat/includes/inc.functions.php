<?php
# (C) 2013 by Jens Federow
# www.lingx.de
if(!defined('VERIFIED'))
{
  die('<b>Fataler Fehler</b>: Direkter Zugriff auf diese Funktion ist nicht erlaubt');
}

# Bild-Datensatz speichern
function lingx_DBInsertImage($ImageName)
{
  $CheckTopicArray = lingx_DBArray("select sat_image_id from ".DB_TABLE_SAT_IMAGES." where sat_image_name='".lingx_Security($ImageName)."' limit 1", true);
  if($CheckTopicArray['Num'] == 0)
  {
	$Date = date('Y-m-d H:i:s');
	lingx_DBQuery("insert into ".DB_TABLE_SAT_IMAGES." (sat_image_date, sat_image_name) values ('".lingx_Security($Date)."', '".lingx_Security($ImageName)."')");
  }
}

# Bild(er) von einem FTP Server in den lokalen Cache Ordner laden
function lingx_GetRemoteSatImages($FTPArray, $LocalDir, $RemoteDir, $RemoteFiles, $DownloadInterval)
{
  global $Texts, $ErrorColor;
  $NumInserted = 0;
  if(@!file_exists($LocalDir.'index.php'))
  {
	lingx_DisplayText($Texts['OpenTempDirErrorMessage'], 'echo', $ErrorColor, true, '', array('%localdir%'), array($LocalDir));
  }
  else
   {
	  $GetLastDateQuery = lingx_DBQuery("select sat_image_date from ".DB_TABLE_SAT_IMAGES." order by sat_image_date desc limit 1");
    $GetLastDateNum = lingx_DBNumRows($GetLastDateQuery);
	  $Continue = false;
	if($GetLastDateNum == 0)
	{
	  $Continue = true;
	}
	elseif($GetLastDateNum > 0)
	{
	  $GetLastDateArray = lingx_DBFetchArray($GetLastDateQuery);
	  $LastDateTimestamp = strtotime($GetLastDateArray['sat_image_date']); 
	  $DownloadIntervalSeconds = (60 * (60 * $DownloadInterval)); 
	  if(($LastDateTimestamp + $DownloadIntervalSeconds) < time())
	  {
	    $Continue = true;
	  }
	}
	if($Continue == true)
	{
	  if(@!ftp_connect($FTPArray['FTPServer']))
	  {
		lingx_DisplayText($Texts['FTPConnectionErrorMessage'], 'echo', $ErrorColor, true, '', array('%ftpserver%'), array($FTPArray['FTPServer']));
	  }
	  else
	  {
		$FTPConnectionID = ftp_connect($FTPArray['FTPServer']);
	  }
	  if(@!ftp_login($FTPConnectionID, $FTPArray['FTPUsername'], $FTPArray['FTPPassword']))
	  {
		lingx_DisplayText($Texts['FTPLoginErrorMessage'], 'echo', $ErrorColor, true, '', array('%ftpserver%'), array($FTPArray['FTPServer']));
	  }
	  $ContentFilesArray = @ftp_nlist($FTPConnectionID, $RemoteDir);
	  foreach($ContentFilesArray as $ContentFile)
	  {
		$RemotePath = $RemoteDir.$RemoteFiles;
		if(substr($RemotePath, 0, strpos($RemotePath, '_%')) == substr($ContentFile, 0, strpos($ContentFile, '_1')))
		{
		  $LocalImage = str_replace($RemoteDir, '', $ContentFile);
		  # '_2' wird in den Satbildern nicht gefunden, also fängt die Funktion bei (0 + 1) an und schmeißt 
		  # deswegen das 'V' vom Dateinamen weg.
		  # Hab die ganz hässliche Lösung gefunden, die nur vielleicht funktioniert. Und zwar:
		  # '_2' durch '_1' ersetzt, weil das Datum in den Satellitenbildern YYMMDD geschrieben wird,
		  # statt YYYYMMDD. Folglich kommt '_2' gar nicht vor.
		  $LocalImage = substr($LocalImage, (strpos($LocalImage, '_1') + 1));
		  $LocalImagePath = $LocalDir.$LocalImage;
		  if(!file_exists($LocalImagePath)) # && preg_match('/_'.date('Ymd').'_/', $ContentFile))
		  {
			if(@ftp_get($FTPConnectionID, $LocalImagePath, $ContentFile, FTP_BINARY))
			{
			  # Bei einem Localhost mit langsamer Internetleitung kann es hier zu folgendem Fehler kommen: "Fatal error: Maximum execution time..." und es werden nicht alle Bilder übertragen. 
			  # Einfach das Script mehrmals ausführen, bis alle aktuellen Bilder im lokalen Cache-Ordner vorhanden sind.
			  lingx_DBInsertImage($LocalImage);
			  $NumInserted++;
			}
		  }
		}
	  }
	  ftp_close($FTPConnectionID);
	}
  }
  return $NumInserted;
}
# Alte Bilder und Datensätze löschen
function lingx_ClearCache($LocalDir, $ClearCacheInterval)
{
  $NumDeleted = 0;
  if($ClearCacheInterval < 3)
  {
    $ClearCacheInterval = 3;
  }
  $ClearCacheIntervalSeconds = ((($ClearCacheInterval * 24) * 60) * 60);
  $GetImagesDate = date('Y-m-d H:i:s', (time() - $ClearCacheIntervalSeconds));
  $GetImagesQuery = lingx_DBQuery("select sat_image_id, sat_image_name from ".DB_TABLE_SAT_IMAGES." where sat_image_date<'".lingx_Security($GetImagesDate)."'");
  while($CacheImageArray = lingx_DBFetchArray($GetImagesQuery))
  {
    $CacheImagePath = $LocalDir.$CacheImageArray['sat_image_name'];
	if(file_exists($CacheImagePath))
	{
	  unlink($CacheImagePath);
	}
	lingx_DBQuery("delete from ".DB_TABLE_SAT_IMAGES." where sat_image_id='".lingx_Security($CacheImageArray['sat_image_id'])."'");
	$NumDeleted++;
  }
  return $NumDeleted;
}
?>