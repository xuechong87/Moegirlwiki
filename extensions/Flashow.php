<?php
# FlashOnWeb-Stream MediaWiki extension
# 
# derivated from RSS-Feed MediaWiki extension by Eric Larcher 23.09.2006
# RSS-Feed MediaWiki extension authors: original by mutante 25.03.2005
# extended by Duesentrieb 30.04.2005
# extended by Rdb78 07.07.2005
# extended by Mafs  10.07.2005, 24.07.2005
# extended by User:Arcy  07.09.2005
# Updated for MediaWiki 1.6 by User:piku 13.06.2006
# Update for Wikicode output, by User:cogdog 14.jul.2006
# Adding Date output, by User:Arcy 30. 07. 2006
#
# Installation:
#  * put this file (flashow.php) into the extension directory of your MediaWiki installation 
#  * add the following to the end of LocalSettings.php: require_once("extensions/flashow.php");
#  * make sure magpie can be found by PHP.
#
# Usage:
#  Use one section between <flashow>-tags for each feed. The flashow section may contain parameters
#  separated by a pipe ("|"), just like links and templates. These parameters should be supported:
#
#    * width=px or % (Modify the width of the object)
#    * height=px or a% (Modify the height of the object)
#    * play=true/false (Start playing the file or wait at first frame, default:true)
#    * loop=true/false (Loop the animation, default:true)
#    * quality=low/autolow/medium/high/autohigh/best (Predefine the quality)
#    * devicefont=true/false (Change the look of the text used in flash file)
#    * bgcolor=#?????? (? -> Hexadecimal integer: 1-9, A-F)
#    * scale=showall/noborder/exactfit (Automatically adjust content to width and height)
#    * menu=true/false (Show or hide the menu on right-click)
#    * align
#    * salign
#    * base
#    * wmode
#    * SeamlessTabbing
#    * flashvars
#    * name (object-specific)
#    * id (embed-specific)
#    * movie (object-specific)
#    * src (embed-specific)
#    * charset=...             The charset used by the feed. iconv is used to convert this.
#
# Example:
#    <flashow>file=happy.swf|width=10%|height=30|quality=best</flashow>
#    Shows the movie with the best quality with a width of 10% and a height of 30 pixels.
#    <flashow>file=cool.swf|width=200|height=300|bgcolor=#FDE742|scale=exactfit</flashow>
#    Shows the movie with a width of 200 and a height of 300. The background color is light-yellow (#FDE742). The content of the movie is stretched to the size of 200x300. 
#
#install extension hook
$wgExtensionFunctions[] = "wfFlashowExtension";
 
$wgExtensionCredits['parserhook'][] = array(
        'name' => 'Flashow',
        'author' => array('Eric Larcher', 'mutante', 'Duesentrieb', 'Rdb78', 'Mafs', 'Arcy', 'piku', 'cogdog'),
        'url' => 'http://www.mediawiki.org/wiki/Extension:Flashow',
        'description' => 'Embeds a widget that runs flash movies.'
);
 
#extension hook callback function
function wfFlashowExtension() { 
  global $wgParser;
 
  #install parser hook for <flashow> tags
  $wgParser->setHook( "flashow", "renderFlashow" );
}
 
#parser hook callback function
function renderFlashow($input, $argv, $parser = null) {
  if (!$parser) $parser =& $GLOBALS['wgParser'];
  global $wgOutputEncoding;
 
  $DefaultEncoding = "ISO-8859-1";
 
 
  # $input = mysql_escape_string($input);

  if (!$input) return ""; #if <flashow>-section is empty, return nothing

  #parse fields in flashow-section
  $fields= explode("|",$input);
  $url= @$fields[0];
 
  $args= array();
  for ($i=1; $i<sizeof($fields); $i++) {
    $f= $fields[$i];
 
    if (strpos($f,"=")===False) $args[strtolower(trim($f))]= False;
    else {
      list($k,$v)= explode("=",$f,2);
      if (trim($v)==False) $args[strtolower(trim($k))] = False; 
      else $args[strtolower(trim($k))]= trim($v);
    }
  }
 
  #get charset from argument-array    
  $charset= @$args["charset"];
  if (!$charset) $charset= $DefaultEncoding;
 
  #get parameters from argument-array
  $width = @$args["width"];
  $height = @$args["height"];
 
   /* Final Output */
  $output= "";
  #to insert check for errors. ini_set("allow_url_fopen", true)...
 
     # return "Flash stream error"; #localize...
     #return "<div>Failed to play Flash stream from $url: "."</div>"; #localize...

  $output = '<object width="' . $width . '" height="' . $height . '><param name="movie" value="' . $url . '"></param><param name="wmode" value="transparent"></param>' . '<embed src="' . $url . '" type="application/x-shockwave-flash" wmode="transparent" width="' . $width . '" height="' . $height . '"' . '></embed></object>';
  return $output;
}