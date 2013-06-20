<?php
# (C) 2013 by Jens Federow
# www.lingx.de
if(!defined('VERIFIED'))
{
  die('<b>Fataler Fehler</b>: Direkter Zugriff auf diese Funktion ist nicht erlaubt');
}

####################################################################################
# Wichtige Variabeln definieren
####################################################################################

  # Temporärer lokaler Ordner zum Zwischenspeichern der Bilder
  $LocalDir = 'temp/';

  # Downloadintervall der Satbilder in Stunden
  $DownloadInterval = 0.25;

  # Alte Sat-Bilder löschen, die älter als X Tage sind (darf nicht kleiner als 3 sein).
  $ClearCacheInterval = 5;

  # Max. Anzahl der einzelnen Satbilder im Satfilm
  $MaxImagesNum = 10;

  # Geschwindigkeit der Bilderwechsel in Millisekunden
  $ImageChangingSpeed = 700;

  # Größe der Satelliten-Bilder in Pixeln
  $ImageSize = array
  #540 405

  (
    'width' =>  800,
    'height' => 600
  );

####################################################################################
# Variabeln fuer die Verbindung zur MySQL Datenbank
####################################################################################

 # Datenbank Zugangsdaten
 $DB = array
  (
   'Host' => 'xxxxxxxxxxxxxxxxxxxxx', # Datenbankserver, zumeist 'loacalhost'
   'Database' => 'xxxxxxxxxxxxxxxxx', # Zu selektierende Datenbank
   'User' => 'xxxxxxxxxxxxxxxxxxx', # Datenbankbenutzername
   'Password' => 'xxxxxxxxxxxxxxxx', # Datenbankpasswort
   'Prefix' => 'lingx_weather' # Bitte nicht ändern!
  );

  # Tabelle(n) des Systems bestimmen
  define('DB_TABLE_SATVIS_IMAGES', $DB['Prefix'].'_satvis_images');

####################################################################################
# Variabeln fuer die FTP Verbindung zum Deutschen Wetterdienst (DWD)
####################################################################################

  # Zu selektierender Ordner auf FTP
  $RemoteDir = 'gds/specials/satweather/';

  # Zu selektierende Datei auf FTP: In Prozent-Zeichen eingeschlossene Werte sind variabel und duerfen nicht entfernt werden!
  $RemoteFiles = 'SWIS_SATWETTER_%datetime%.jpg';

####################################################################################
# Texte festlegen
####################################################################################

  # In Prozent-Zeichen eingeschlossene Werte sind variabel und sollten nicht aus dem Text entfernt werden
  $ModuleTexts = array
  (
        'NumOfSatImagesDeletedMessage' => 'Es wurden %deletednum% alte Sat-Bilder gel&ouml;scht.',
        'NumOfSatImagesSavedMessage' => 'Es wurden %insertednum% neue Sat-Bilder gespeichert.',
        'OpenTempDirErrorMessage' => 'Der lokale Cache Ordner &quot;%localdir%&quot; wurde nicht gefunden oder ist nicht schreibbar, bitte kontaktieren Sie den Administrator dieser Webseite.'
  );
  
####################################################################################
# Styles anpassen
####################################################################################

  # CSS Style
  $Style = '
        #weathersatvis
        {
          font-family: Verdana, Geneva;
          color: #'.$DefaultColor.';
          font-size: 11px;
          width: 100%;
        }
    #weathersatvis .sat
        {
          width: '.$ImageSize['width'].'px;
          height: '.$ImageSize['height'].'px;
      	}
    #weathersatvis .buttons 
	{ 
	  width: 160px; 
	  height: 36px;
	  position: relative;
	  clear: both;
	  margin: 6px 0px 0px '.(($ImageSize['width'] - 160) / 2).'px;
	}
	#weathersatvis .previous, #weathersatvis .next, #weathersatvis .play, #weathersatvis .pause 
	{
	  cursor: pointer; 
	  float: left;
	  width: 36px;
	  height: 36px;
	  margin: 2px;
	}
	#weathersatvis .previous
	{
	  background: url("modules/weathersatvis/images/previous.png") transparent no-repeat;
	}
	#weathersatvis .play
	{
	  background: url("modules/weathersatvis/images/play.png") transparent no-repeat;
	}
	#weathersatvis .pause
	{
	  background: url("modules/weathersatvis/images/pause.png") transparent no-repeat;
	}
	#weathersatvis .next
	{
	  background: url("modules/weathersatvis/images/next.png") transparent no-repeat;
	}
  ';

?>