<?php
# Setup and Hooks for the MsUpload extension
if( !defined( 'MEDIAWIKI' ) ) {
 	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
 	die( 1 );
}

## Register extension setup hook and credits:
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'MsUpload萌娘百科修改版',
	'url'  => 'https://www.mediawiki.org/wiki/Extension:MsUpload',
	'descriptionmsg' => 'msu-desc',
	'version' => '9.2',
	'author' => '[http://www.ratin.de/msupload.html Ratin] | [http://wiki.moegirl.org/ 萌娘百科]',
);

$dir = dirname(__FILE__).'/';
//$wgAvailableRights[] = 'msupload';
$wgExtensionMessagesFiles['msu'] = $dir . 'msupload.i18n.php';


$wgHooks['EditPage::showEditForm:initial'][] = 'MSLSetup';
require_once($dir.'msupload.body.php');
//$wgAutoloadClasses['msupload'] = $dir . 'msupload.body.php';


$wgResourceModules['ext.MsUpload'] = array(
        // JavaScript and CSS styles.
        'scripts' => array( 'js/msupload.insert.js', 'js/plupload/plupload.full.js', 'js/msupload.js' ),
        'styles' => array( 'css/jquery.css', 'css/msupload.css' ),
        // When your module is loaded, these messages will be available through mw.msg()
        'messages' => array( 'msu-description', 'msu-button_title', 'msu-insert_link', 'msu-insert_gallery', 'msu-insert_picture', 'msu-insert_movie', 'msu-cancel_upload', 'msu-upload_possible', 'msu-ext_not_allowed', 'msu-upload_this', 'msu-upload_all', 'msu-dropzone', 'msu-comment' ),
 
        'dependencies' => array( 'jquery.ui.progressbar' ),
        // subdir relative to "/extensions"
        'localBasePath' => dirname( __FILE__ ),
        'remoteExtPath' => 'MsUpload'
);

 
function MSLSetup() {

  global $wgOut, $wgScriptPath;
  //global $wgVersion;
  //$version = explode(".", $wgVersion); #$version[0] = 1; $version[1] = 17; $version[2] = 0;
  $path =  $wgScriptPath.'/extensions/MsUpload';
  $dir = dirname(__FILE__).'/';
  
  //load module
  $wgOut->addModules( 'ext.MsUpload' );
  
  global $wgMSU_ShowAutoKat, $wgMSU_AutoIndex, $wgMSU_CheckedAutoKat, $wgMSL_FileTypes, $wgJsMimeType, $wgMSU_debug;
  
  $use_MsLinks = 'false';
  if(isset($wgMSL_FileTypes)){$use_MsLinks = 'true';} //check whether the extension MsLinks is installed

    
	$msu_vars = array(
		'path' => $path,
    	'use_mslinks' => $use_MsLinks,
    	'autoKat' => BoolToText($wgMSU_ShowAutoKat),
    	'autoIndex' => 'false', #BoolToText($wgMSU_AutoIndex);
		'autoChecked' => BoolToText($wgMSU_CheckedAutoKat),
		'debugMode' => BoolToText($wgMSU_debug)
	);

	$msu_vars = json_encode($msu_vars);
	
    $wgOut->addScript( "<script type=\"{$wgJsMimeType}\">var msu_vars = $msu_vars;</script>\n" );
  
  return true;
}

function BoolToText($a) {
return $a ? "true" : "false";
}  