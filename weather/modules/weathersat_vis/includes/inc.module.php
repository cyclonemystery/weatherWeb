<?php
# (C) 2013 by Jens Federow
# www.lingx.de
if(!defined('VERIFIED'))
{
  die('<b>Fataler Fehler</b>: Direkter Zugriff auf diese Funktion ist nicht erlaubt');
}

####################################################################################
# Modul Variabeln bestimmen
####################################################################################
  # Name des Modules
  $ModuleName = 'SWIS Satwetter';

  # Version des Modules
  $ModuleVersion = '1.0.0';

  # Ordner des Modules
  $ModuleDir = 'modules/weathersat_vis/';

  # Geben Sie hier den Schlüssel des Navigationspunktes an, unter welchem das Modul zugeordnet und angezeigt werden soll:
  $NavigationPointKey = 'Wetter-Sat';

  # An welcher Position soll der Link zum Modul in der Navigation stehen? Je kleiner die Zahl, desto weiter oben wird der Link angeordnet
  $NavigationPosition = 2;
?>