<?php
/*********************************************************************
**
** This file is part of the PCR GUI Inserts extension for MediaWiki
** Copyright (C)2010
**                - PatheticCockroach <www.patheticcockroach.com>
**
** Home Page : 
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

class PCRguii
{
	public function __construct()
	{
		global $wgHooks;
		$wgHooks['BeforePageDisplay'][] = array( &$this, 'BeforePageDisplay' );
		$wgHooks['SkinAfterBottomScripts'][] = array( &$this, 'SkinAfterBottomScripts' );
		$wgHooks['SkinBuildSidebar'][] = array( &$this, 'SkinBuildSidebar' );
	}
	
	# addHeadItem places stuff within <head></head>
	# BeforePageDisplay places stuff just at the end of the page content frame
	public function BeforePageDisplay(&$out, &$sk)
	{
		global $wgPCRguii_Inserts;
		if($wgPCRguii_Inserts['addHeadItem']['on'])
			{
			$i=0;
			foreach($wgPCRguii_Inserts['addHeadItem']['content'] as $value)
				{
				$out->addHeadItem('PCRguii'.$i,$value);
				$i++;
				}
			}
		if($wgPCRguii_Inserts['BeforePageDisplay']['on'])
			$out->addHTML($wgPCRguii_Inserts['BeforePageDisplay']['content']);
		return $out;
	}
	
	# SkinAfterBottomScripts places stuff really at the bottom (after the last yellow line!)
	public function SkinAfterBottomScripts($skin, &$text)
	{
		global $wgPCRguii_Inserts;
		if($wgPCRguii_Inserts['SkinAfterBottomScripts']['on'])
			$text .= $wgPCRguii_Inserts['SkinAfterBottomScripts']['content'];
		return true;
	}
	
	# SkinBuildSidebar places stuff at the end of the side bar
	public function SkinBuildSidebar($skin, &$bar)
	{
		global $wgPCRguii_Inserts;
		if($wgPCRguii_Inserts['SkinBuildSidebar']['on'])
			{
			foreach($wgPCRguii_Inserts['SkinBuildSidebar']['content'] as $value)
			$bar[$value[0]] = $value[1];
			}
		return true;
	}
}