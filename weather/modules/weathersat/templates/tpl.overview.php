<?php
# (C) 2013 by Jens Federow
# www.lingx.de
if(!defined('VERIFIED'))
{
  die('<b>Fataler Fehler</b>: Direkter Zugriff auf diese Funktion ist nicht erlaubt');
}
echo '<style type="text/css">'."\n";
echo $Style."\n";
echo '</style>'."\n";
echo '<div id="weathersat">'."\n";
if(count($SatImages) == 0)
{
  # Fehler Nachricht
  lingx_DisplayText($Texts['NoDataErrorMessage'], 'echo', $ErrorColor, true);
} 
else
{
  lingx_Javascript('', 'echo', 'src="'.$ModuleDir.'includes/jquery.cycle.plugin.js"');
  $CycleJavascript = '
    $("#weathersat .sat").cycle({ 
	  speed: 1, 
	  timeout: '.$ImageChangingSpeed.', 
	  delay: 2000,
	  next: "#weathersat .next",
      prev: "#weathersat .previous"
	});
	$("#weathersat .pause").click(function(){
	  $(".sat").cycle("pause");
	  return false;
	});
	$("#weathersat .play").click(function() {
	  $(".sat").cycle("resume");
	  return false;
	});  
  ';
  lingx_Javascript($CycleJavascript, 'echo');
  echo '  <div class="sat">'."\n";
  foreach($SatImages as $SatImage)
  {
    echo '    <img src="'.$SatImage.'" width="'.$ImageSize['width'].'" height="'.$ImageSize['height'].'" />'."\n";
  }
  echo '  </div>
  '."\n";
  ?>
  <div class="buttons">
    <div class="previous"></div>
    <div class="play"></div>
    <div class="pause"></div> 
    <div class="next"></div>
  </div>
  <?php
}
echo '</div>';
?>