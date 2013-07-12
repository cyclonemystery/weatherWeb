<?php
# (C) 2013 by Jens Federow
# www.lingx.de
if(!defined('VERIFIED'))
{
  die('<b>Fataler Fehler</b>: Direkter Zugriff auf diese Funktion ist nicht erlaubt');
}

# Datenbankverbindung aufbauen
$DBConnection = mysql_connect($DB['Host'], $DB['User'], $DB['Password']);
if($DBConnection == false)
{
  die(mysql_error());
  mysql_close($DBConnection);
  exit;
}
else
{
  if(mysql_select_db($DB['Database'], $DBConnection) == false)
  {
    die(mysql_error());
    mysql_close($DBConnection);
    exit;
  }
}

# Datenbankabfrage
function lingx_DBQuery($SQLString)
{
  global $DBConnection;
  return mysql_query($SQLString." ;", $DBConnection);
}

# Anzahl gefundener Zeilen einer Datenbankabfrage ausgeben
function lingx_DBNumRows($Query)
{
  return mysql_num_rows($Query);
}

# Daten aus einer Datenbankabfrage in ein Array packen
function lingx_DBFetchArray($Query)
{
  return mysql_fetch_array($Query);
}

# Letzte Speicherungs-ID erfragen
function lingx_DBGetID()
{
  return mysql_insert_id();
}

# Daten aus einem SQL String in ein Array packen
function lingx_DBArray($SQLString, $IsSingleArray = true)
{
  $Array = array();
  $Query = lingx_DBQuery($SQLString);
  $NumRows = lingx_DBNumRows($Query);
  if($IsSingleArray == true)
  {
<<<<<<< HEAD
	$Array = lingx_DBFetchArray($Query);
  }
  else
  {
	while($FetchArray = lingx_DBFetchArray($Query))
	{
	  $Array[] = $FetchArray;
	}
  }
  return array('Num' => $NumRows, 'Data' => $Array);
}
# Datenbank-Sicherheitsfunktion für HTML Daten
=======
        $Array = lingx_DBFetchArray($Query);
  }
  else
  {
        while($FetchArray = lingx_DBFetchArray($Query))
        {
          $Array[] = $FetchArray;
        }
  }
  return array('Num' => $NumRows, 'Data' => $Array);
}

# Datenbank-Sicherheitsfunktion f�r HTML Daten
>>>>>>> a74c513... Seit Wochenende lauffähige Version. Hier sind nun alle Variabeln richtig
function lingx_SecurityHTML($Value)
{
  $Value = (isset($Value) && !empty($Value) || $Value == 0) ? $Value : '';
  $HEX = array('0x22', '0x24', '0x26', '0x28', '0x2a', '0x2c', '0x2e', '0x3a', '0x3c', '0x3e', '0x25', '0x27', '0x29', '0x2b', '0x2d', '0x2f', '0x3b', '0x3e', '0x3f', '0x5c', '0x5e', '0x60', '%22', '%24', '%26', '%28', '%2a', '%2c', '%2e', '%3a', '%3c', '%3e', '%25', '%27', '%29', '%2b', '%2d', '%2f', '%3b', '%3e', '%3f', '%5c', '%5e', '%60');
  $Replace = '';
  foreach($HEX as $Search)
  {
<<<<<<< HEAD
	$Value = str_replace($Search, $Replace, $Value);
=======
        $Value = str_replace($Search, $Replace, $Value);
>>>>>>> a74c513... Seit Wochenende lauffähige Version. Hier sind nun alle Variabeln richtig
  }
  $Value = stripslashes(str_replace('\r\n', '', mysql_real_escape_string(trim($Value))));
  return $Value;
}
<<<<<<< HEAD
# Datenbank-Sicherheitsfunktion für alle anderen Daten, ausgenommen HTML
=======

# Datenbank-Sicherheitsfunktion f�r alle anderen Daten, ausgenommen HTML
>>>>>>> a74c513... Seit Wochenende lauffähige Version. Hier sind nun alle Variabeln richtig
function lingx_Security($Value)
{
  $Unmask = array('*', "'", '"');
  $Replace = '';
  foreach($Unmask as $Search)
  {
<<<<<<< HEAD
	$Value = str_replace($Search, $Replace, $Value);
=======
        $Value = str_replace($Search, $Replace, $Value);
>>>>>>> a74c513... Seit Wochenende lauffähige Version. Hier sind nun alle Variabeln richtig
  }
  $Value = lingx_SecurityHTML(htmlentities($Value));
  return $Value;
}
<<<<<<< HEAD
# Benötigte Tabelle erstellen, falls sie nicht existiert
lingx_DBQuery("
  create table if not exists ".DB_TABLE_SATVIS_IMAGES." (    
	sat_image_id int(11) not null auto_increment,
	sat_image_date datetime default '0000-00-00 00:00:00',
	sat_image_name varchar(250) not null,
	primary key (sat_image_id)
  ) engine=myisam default character set=utf8 collate=utf8_general_ci auto_increment=1 ; 
");
?>
=======

# Ben�tigte Tabelle erstellen, falls sie nicht existiert
lingx_DBQuery("
  create table if not exists ".DB_TABLE_SAT_IMAGES." (
        sat_image_id int(11) not null auto_increment,
        sat_image_date datetime default '0000-00-00 00:00:00',
        sat_image_name varchar(250) not null,
        primary key (sat_image_id)
  ) engine=myisam default character set=utf8 collate=utf8_general_ci auto_increment=1 ;
");
?>
>>>>>>> a74c513... Seit Wochenende lauffähige Version. Hier sind nun alle Variabeln richtig
