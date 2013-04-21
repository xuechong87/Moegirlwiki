<?php
/*********************************************************************
**
** This file is part of the PCR GUI Inserts extension for MediaWiki
** Copyright (C)2010
**                - PatheticCockroach <www.patheticcockroach.com>
**
** Home Page : http://www.mediawiki.org/wiki/Extension:PCR_GUI_Inserts
** Version: 1.0
**
** This program is licensed under the Creative Commons
** Attribution-Noncommercial-No Derivative Works 3.0 Unported license
** <http://creativecommons.org/licenses/by-nc-nd/3.0/legalcode>
**
** The attribution part of the license prohibits any unauthorized editing of any line related to
** $wgExtensionCredits['other'][]
**
** This program is distributed in the hope that it will be useful,
** but WITHOUT ANY WARRANTY; without even the implied warranty of
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
**
*********************************************************************/

if (!defined('MEDIAWIKI')) die('This file is part of MediaWiki. It is not a valid entry point.');
 
$dir = dirname(__FILE__) . '/';

/**************
* Options (NB: edit the settings you want to customize in LocalSettings.php)
***************/
$wgPCRguii_Inserts = array(
	'addHeadItem' => array('on' => false,
						'content' => array(
								'head1',
								'head2')),
	'BeforePageDisplay' => array('on' => false,
						'content' => 'BeforePageDisplay'),
	'SkinAfterBottomScripts' => array('on' => false,
						'content' => 'SkinAfterBottomScripts'),
	'SkinBuildSidebar' => array('on' => false,
						'content' => array(
								array('title1','content1'),
								array('title2','content2'))),
	);
/**************
* End of options
***************/
 
$wgAutoloadClasses['PCRguii'] = $dir . 'pcr_guii_body.php';
$wgExtensionMessagesFiles['PCRguii'] = $dir . 'pcr_guii.i18n.php';
$wgHooks['ParserFirstCallInit'][] = 'wfPCRguii'; 
 
$wgExtensionCredits['other'][] = array(
	'name' => 'PCR GUI Inserts',
	'author' => array('[http://www.patheticcockroach.com David Dernoncourt]'),
	'url' => 'http://www.mediawiki.org/wiki/Extension:PCR_GUI_Inserts',
	'descriptionmsg' => 'pcr_guii-desc',
	'version' => '1.0',
);

function wfPCRguii()
{
	new PCRguii;
	return true;
} 