<?php
// **************************************************************
// File: submit.php
// Purpose: Submit spammers to fSpamlist and StopForumSpam
// Author: MysteryFCM
// Support: http://mysteryfcm.co.uk/?mode=Contact
//	    http://forum.hosts-file.net/viewforum.php?f=68
//	    http://www.temerc.com/forums/viewforum.php?f=71
// Last modified: 02-04-2010
// **************************************************************

// This file should never be accessed directly
$sTempVar=$_SERVER['REQUEST_URL']; $sTempHost=$_SERVER['URL'];
if( strpos($sTempVar, 'submit.php') || !strpos($sTempHost, $_SERVER['HTTP_HOST']) ){
	die('Error');
}

// There must at least be an IP
if(!isset($_GET['ip'])){
	die('Error');
}

$sName=$_GET['name']; $sName = addslashes(htmlentities($sName)); $sName = urlencode($sName);
$sMail=$_GET['mail']; $sMail = addslashes(htmlentities($sMail));
$sIP=$_GET['ip']; $sIP = addslashes(htmlentities($sIP));

if($sName=='' || $sMail==''){
	if($sIP==''){
		die('Error');
	}else{
		if(IsValidIP($sIP)==false){
			die('Error');
		}
	}
}

// *********************************************************************************
// BEGIN SUBMIT TO FSPAMLIST
// *********************************************************************************
if(!$sFSLAPI==''){
	if($sName==''){$sName='NULL';}
	if($sMail==''){$sMail='nobody@nodomain.com';}
	if($sIP==''){$sIP='1.2.3.4';}

	// Is there an e-mail address?
	if($sMail !=''){
		$sFSLM = 'http://www.fspamlist.com/apiadd.php?spammer='.$sMail.'&type=email&key='.$sFSLAPI.'&from='.$_SERVER['SERVER_NAME'];
		$fspamsubmit = getURL($sFSLM);
		if(strpos($fspamsubmit, 'Added')){
			echo 'Email: Added Successfully<br>';
		}
	}
	// Is there a username?
	if($sName !=''){
		$sFSLU = 'http://www.fspamlist.com/apiadd.php?spammer='.$sName.'&type=username&key='.$sFSLAPI.'&from='.$_SERVER['SERVER_NAME'];
		$fspamsubmit = getURL($sFSLU);
		if(strpos($fspamsubmit, 'Added')){
			echo 'Name: Added Successfully<br>';
		}
	}
	// Is there an IP address?
	if($sIP !=''){
		$sFSLI = 'http://www.fspamlist.com/apiadd.php?spammer='.$sIP.'&type=ip&key='.$sFSLAPI.'&from='.$_SERVER['SERVER_NAME'];
		$fspamsubmit = getURL($sFSLI);
		if(strpos($fspamsubmit, 'Added')){
			echo 'IP: Added Successfully<br>';
		}
	}
	echo '<br>Finished submitting to fSpamlist ....<br>';

}else{
	echo 'Error: fSpamlist API key is missing.';
}
// *********************************************************************************
// END SUBMIT TO FSPAMLIST
// *********************************************************************************

// *********************************************************************************
// BEGIN SUBMIT TO STOPFORUMSPAM
// *********************************************************************************

if($sName==''){$sName='NULL';}
if($sMail==''){$sMail='nobody@nodomain.com';}
if($sIP==''){$sIP='1.2.3.4';}

$sURL = "http://www.stopforumspam.com/post.php";
$sPostData = "username=".urlencode($sName)."&ip_addr=".urlencode($sIP)."&email=".urlencode($sMail)."&api_key=".$sSFSAPI;

if(!$sSFSAPI==''){
	$curl = @curl_init();
	curl_setopt($curl, CURLOPT_URL, $sURL);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $sPostData);
	curl_setopt($curl, CURLOPT_VERBOSE, 1);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HEADER, 1);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	$sSFSTemp = @curl_exec($curl);
	curl_close($curl);
	if(strpos($sSFSTemp, '200')){
		echo '<br>Finished submitting to StopForumSpam';
	}else{
		echo 'Error: Something went terribly wrong ....<br><br>'.htmlentities($sSFSTemp, ENT_QUOTES);
	}
}else{
	echo 'Error: StopForumSpam API key is missing.';
}

// *********************************************************************************
// END SUBMIT TO STOPFORUMSPAM
// *********************************************************************************
?>