<?php
// **************************************************************
// File: functions.php
// Purpose: Contains functions used by Spambot Search Tool
// Author: MysteryFCM
//	   Contains modifications and bug fixes with thanks to  Dan McCormick.
//
//		http://www.cedit.biz/joomla-extensions/18-registration-validator/22-block-disposable-email-addresses
//
// Support: http://mysteryfcm.co.uk/?mode=Contact
//	    http://forum.hosts-file.net/viewforum.php?f=68
//	    http://www.temerc.com/forums/viewforum.php?f=71
// Last modified: 22-02-2011
// **************************************************************

// Determine whether curl is available or not
function isCUrlAvailable() {
	$extension = 'curl';
	if (extension_loaded($extension)) {
		return true;
	}
	else {
		return false;
	}
}

// Determine if a URL is online or not

function isURLOnline($sSiteToCheck) {
	// check, if curl is available
	if (isCUrlAvailable()) {
		// check if url is online
		$curl = @curl_init($sSiteToCheck);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		curl_setopt($curl, CURLOPT_FAILONERROR, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		@curl_exec($curl);
		if (curl_errno($curl) != 0) {
			return false;
		}
		else {
				return true;
			}
		curl_close($curl);
	}
	else {
		//curl is not loaded, this won't work
		return false;
	}
}


// Gets a URL's content
//
//	If file_get_contents() is available, use that, otherwise use cURL
//
function getURL($sURL)
{
	if(isURLOnline($sURL) == false)
	{
		$sURLTemp = 'Unable to connect to server';
		return $sURLTemp;
	}
	else
	{
		if(function_exists('file_get_contents') && ini_get('allow_url_fopen') == true)
		{
			// Use file_get_contents
			$sURLTemp = @file_get_contents($sURL);
		}
		else
		{
			// Use cURL (if available)
			if (isCUrlAvailable()) {
				$curl = @curl_init();
				curl_setopt($curl, CURLOPT_URL, $sURL);
				curl_setopt($curl, CURLOPT_VERBOSE, 1);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_HEADER, 0);
				$sURLTemp = @curl_exec($curl);
				curl_close($curl);
			}
			else {
				$sURLTemp = 'Unable to connect to server';
				return $sURLTemp;
			}
		}
		return $sURLTemp;
	}
	//echo 'DEBUG: $sURLTemp: '.$sURLTemp.'<br/>';
}

// Resolve a hostname
function resolve_host($sRHHost){
	if($sRHHost !=''){
		$sRHHosts = gethostbynamel($sRHHost);
		$irh=0;
		if (is_array($sRHHosts)) {
			foreach ($sRHHosts as $sRHHip) {
				if($sRHret==''){$sRHret=$sRHHip;}else{$sRHret = $sRHHip.",".$sRHret;}
				$irh++;
			}
			return $sRHret;
		}else{
			$sRHret = gethostbyname($sRHhost);
			if($sRHret==''){$sRHret=$sRHHost;}
			return $sRHret;
		}
	}else{
		die('ERROR: resolve_host requires a var be passed .....');
	}
}

// Determines if e-mail passed, is valid
//
//	Returns false if no @ is present
//	Returns false if domain does not resolve to an IP
//

function IsValidEmail($sMailToCheck){
	// Check it's an e-mail address
	if(substr_count($sMailToCheck, '@') == 1){
		// Check the domain part has at least one period, and it resolves to an IP (it's invalid if it doesn't)

		if(substr_count($sMailToCheck, '.') > 0){
			$sMailDomain = explode('@', $sMailToCheck); $sMailDomain=$sMailDomain[1];
			//echo 'Mail DOM: '.$sMailDomain.'<br>';
			$sMailDomainIP = resolve_host($sMailDomain);
			//echo 'Mail DOM IP: '.$sMailDomainIP.'<br>';

			//echo 'DOM: '.$sMailDomainIP.'<br>SERVER_ADDR: '.gethostbyname($_SERVER['SERVER_NAME']).'<br>';

			$sMyServerIP = gethostbyname($_SERVER['SERVER_NAME']);

			// If the IP = the domain then it's invalid
			switch($sMailDomainIP){
				case $sMailDomain:
					//echo 'NOT VALID<br>';
					$sIVE = FALSE;
					break;
				// If the IP = our servers IP, it's invalid
				case $sMyServerIP:
					//echo 'NOT VALID<br>';
					$sIVE = FALSE;
					break;

				default:
					// If the IP is an NRIP (non-routable IP) it's invalid					
					if(substr_count($sMailDomainIP, "192.168.0") > 0){
						//echo 'NOT VALID<br>';
						$sIVE = FALSE;

					}else{
						//echo 'VALID<br>';
						$i=0;
						// If there's commas in the return, we need to process them
						If(substr_count($sMailDomainIP, ',') > 0){
							$arrMDIP = explode(',', $sMailDomainIP);
							foreach($arrMDIP as $sMIP => $sMDIP){

								$barrIP = IsValidIP($sMDIP);
								//echo "barrIP: ".$barrIP.'<br>';
								If($barrIP==true){
									$bIVEIP = TRUE; break;
								}else{
									$bIVEIP = FALSE; break;
								}
								//$i++;
							}

							if($bIVEIP==TRUE){$sIVE = TRUE;}else{$sIVE = FALSE;}
						}else{

							$bIVEIP = IsValidIP($sMailDomainIP);

							if($bIVEIP==TRUE){$sIVE = TRUE;}else{$sIVE = FALSE;}
						}
					} // END if($sMailDomainIP == $_SERVER['SERVER_ADDR']){

					//$sIVE = settype($sIVE, "boolean");
					//echo "sIVE: ".$sIVE.'<br>';

					return $sIVE;
			}
		}else{
			return FALSE;
		}
	}else{
		return FALSE;
	}
}

// Determines if passed IP is valid
//
//	Thanks to Mike @ BotScout (botscout.com) for this function
//
//	http://botscout.com/forum/index.php/topic,2.msg128.html#msg128
//

function IsValidIP($ip){
	if(preg_match("'\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b'", $ip)){
		return TRUE;
	}else{
		return FALSE;
	}
}

// Increase our counter if a match to a known spammer
//
function IncreaseCatchCount(){
	$sMyPath = dirname(__FILE__).'/';
	if(!file_exists($sMyPath.'counter.txt')==true){
		// Okay, lets try and copy the sample file
		if(file_exists($sMyPath.'counter.sample.txt')==true){
			if(!copy($sMyPath.'counter.sample.txt', $sMyPath.'counter.txt')){
				die('counter.sample.txt and counter.txt are missing. Please restore these files');
			}
		}else{
			die('counter.sample.txt is missing, I need this to create counter.txt unless you are going to create it yourself?');
		}
	}
	if(@function_exists('file_put_contents')==True && @ini_get('allow_url_fopen') == true){
		$spambot_counter = @file_get_contents($sMyPath.'counter.txt');
		// If the counter.txt file has just been created, it won't contain anything so set it to 1
		if($spambot_counter ==''){
			$spambot_counter='1';
		}else{
			$spambot_counter = $spambot_counter+1; // Increase it's count + 1
		}
		if(@is_writable($sMyPath.'counter.txt')){
			@file_put_contents($sMyPath.'counter.txt',$spambot_counter);
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

// Display number of spammers caught
//
//	Requires:
//
//		$m_opt		= Whether we're displaying from DB or counter.txt
//
//		From counter.txt	: F_TEXT
//		From database		: F_DB
//		
//
//	Usage:
//
//		$l_ret = GetSpammerCount("F_TEXT");
//
function GetSpammerCount($m_opt){
	if($m_opt=='F_TEXT'){
		if(@file_exists('./counter.txt')==True && @function_exists('file_get_contents')==True && @ini_get('allow_url_fopen')==True){
			$l_ret = @file_get_contents('counter.txt');
		}
		if($l_ret==''){
			$l_ret='0';
		}
	}else{ // Display from MySQL count
		include('config.php');
		$conSBST = @mysql_connect($dbShost,$dbSusername,$dbSpassword);
		if(!$conSBST){
			return $l_ret;
		}else{
			$m_ret = @mysql_select_db($dbSname);
			if(!$m_ret=="0"){
				$sSQL = 'SELECT fldspammer_id From tblspammers';
				$sQuery = @mysql_query($sSQL, $conSBST);
				if($sQuery){
					$l_ret = @mysql_num_rows($sQuery);
				}
			}
			mysql_close($conSBST);
		}
	}
	if($l_ret==''){$l_ret="0";}
	return $l_ret;
}

// Used to increment and log spammers to text file (if enabled)
//
//	Requires:
//
//		$sLogPath	= Path to the folder you'd like the text files created
//		$sLDB		= Database the spammer was listed in (fSpamList, StopForumSpam, SpamCop etc)
//		$sLName		= Spammers username
//		$sLIP		= Spammers IP address
//		$sLMail		= Spammers e-mail address
//
//	Usage:
//
//		$lRet = LogSpammerToFile('./spambots/', 'fSpamList', 'volter', '123.123.123.123', 'spammer@email.com')
//
function LogSpammerToFile($sLogPath, $sLDB, $sLName, $sLIP, $sLMail){
	if($bln_SaveToFile==true){
		if(file_exists($sLogPath) == false){
			return false;
		}
		if(function_exists('file_put_contents')==false){
			echo 'You\'ve asked me to dump the results to text file, but file_put_contents is not available. Please enable it or disable dumping to a text file';
			return false;
		}
		if(ini_get('allow_url_fopen') == false){
			echo 'Unable to save to file, allow_url_fopen is disabled on this server';
			return false;
		}

		// We need a spammer database
		if($sLDB==''){
			return false;
		}else{
			//
			//	bs_		= BotScout
			//	fsl_		= fSpamlist
			//	sfs_		= StopForumSpam
			//	php_		= ProjectHoneyPot
			//	sorbs_		= Sorbs
			//	spamhaus_	= SpamHaus
			//	scop_		= SpamCop
			//	drone_		= DroneBL
			switch($sLDB){
				case "BotScout";
					$sSpamDB ='bs_';
					break;
				case "fSpamlist";
					$sSpamDB ='fsl_';
					break;
				case "StopForumSpam";
					$sSpamDB ='sfs_';
					break;
				case "ProjectHoneyPot";
					$sSpamDB ='php_';
					break;
				case "Sorbs";
					$sSpamDB ='sorbs_';
					break;
				case "SpamHaus";
					$sSpamDB ='spamhaus_';
					break;
				case "SpamCop";
					$sSpamDB ='scop_';
					break;
				case "DroneBL";
					$sSpamDB ='drone_';
					break;
				case "AHBL";
					$sSpamDB ='ahbl_';
					break;
			}
			// If any of the vars are empty, change them to "NULL"
			if($sLName==''){$sLName='NULL';}
			if($sLIP==''){$sLIP='NULL';}
			if($sLMail==''){$sLMail='NULL';}

			// Since our text files are created using the e-mail address as part of the name
			// we can't have an empty e-mail address, or it's not going to work is it?
			//
			// In this case, we'll skip the text files creation

			if($sLMail !='NULL'){
				$file = str_replace('*', '', $sLMail);
				if(file_exists($sLogPath.$sSpamDB.$file.'.txt')){
					$spambot_old_info = file_get_contents($sLogPath.$sSpamDB.$file.'.txt');
					$spambot_old_info = explode(',',$spambot_old_info);
					$spambot_old_info[2] = $spambot_old_info[2]+1; // Increase count
					$spambot_old_info = implode(',',$spambot_old_info);
					if(ini_get('allow_url_fopen') == true){
						file_put_contents($sLogPath.$sSpamDB.$file.'.txt',$spambot_old_info);
					}
				}else{
					$spambot_info = $sLIP.','.$sLName.',1';
					if(ini_get('allow_url_fopen') == true){
						file_put_contents($sLogPath.$sSpamDB.$file.'.txt',$spambot_info);
					}
				} // End if(file_exists($sLogPath.$sSpamDB.$file.'.txt'))

				return true;
			}else{
				return false;
			}
		}

	} // End if($bln_SaveToFile==true....
}

// Is spammer to database (if enabled)
//
//	Requires:
//
//		$host		= MySQL server (e.g. localhost, 192.168.0.10 etc)
//		$dbname		= Database to use (e.g. Spambots)
//		$username	= Your MySQL username
//		$password	= Your MySQL password
//		$spammername	= Spammers username
//		$spammerip	= Spammers IP
//		$spammeremail	= Spammers email address
//
//	Usage:
//
//		$lRet = IsSpammerInDB('localhost', 'sbst', 'root', '12345password', 'volter', '123.123.123.123', 'spammer@email.com')
//
function IsSpammerInDB($host, $dbname, $username, $password, $spammername, $spammerip, $spammeremail){

	// We need a host, database, username and password, if they're missing, return false
	if($host=='' || $dbname=='' || $username=='' || $password==''){
		return false;
	}

	$conSBST = mysql_connect($host, $username, $password);
	if(!$conSBST){
		return false;
	}else{
		// Check our database exists shall we?
		$ret = mysql_select_db($dbname);
		if($ret == "0"){
			// Okay, lets try and create it then ....
			$ret = CreateDatabase($host, $username, $password, $dbname);
			$ret = mysql_select_db($dbname);
			if($ret == "0"){
				mysql_close($conSBST);
				return false;
			}
		}

		// Change empty vars to "NULL"
		if($spammername==''){$spammername='nothing';}
		if($spammerip==''){$spammerip='1.2.3.4';}
		if($spammeremail==''){$spammeremail='noone@nothing.com';}

		// Trim anything that could screw with the SQL
		$spammername=str_replace(array("0x", ",", "%", "'","\r\n", "\r", "\n"), "", $spammername);
		$spammername=mysql_real_escape_string($spammername);

		$spammerip=str_replace(array("0x", ",", "%", "'","\r\n", "\r", "\n"), "", $spammerip);
		$spammerip=mysql_real_escape_string($spammerip);

		$spammeremail=str_replace(array("0x", ",", "%", "'","\r\n", "\r", "\n"), "", $spammeremail);
		$spammeremail=mysql_real_escape_string($spammeremail);

		// Check to see if our spammer already exists (compares username/IP/E-mail AND the database they are listed in, returns false if only one matches)
		$sSQL = "SELECT fldspammer_id, fldspammer_name, fldspammer_count, fldspammer_ip, fldspammer_mail FROM tblspammers WHERE fldspammer_name='$spammername' OR fldspammer_ip='$spammerip' OR fldspammer_mail='$spammeremail' AND flddb_matched='$spamdb'";
		$sQuery = mysql_query($sSQL, $conSBST);
		if(!$sQuery){
			die(mysql_error());
		}else{
			$num = mysql_num_rows($sQuery);
			//echo 'NUM: '.$num.'<br>';
			if($num==0){return false;}else{return true;}
		}
	}
}

// Log spammer to database (if enabled)
//
//	Requires:
//
//		$host		= MySQL server (e.g. localhost, 192.168.0.10 etc)
//		$dbname		= Database to use (e.g. Spambots)
//		$username	= Your MySQL username
//		$password	= Your MySQL password
//		$spamdb		= Database the spammer is listed in (e.g. fSpamlist)
//		$spammername	= Spammers username
//		$spammerip	= Spammers IP
//		$spammeremail	= Spammers email address
//
//	Usage:
//
//		$lRet = LogSpammerToDB('localhost', 'SBST', 'root', '12345password', 'fSpamlist', 'volter', '123.123.123.123', 'spammer@email.com')
//
function LogSpammerToDB($host, $dbname, $username, $password, $spamdb, $spammername, $spammerip, $spammeremail){

	// We need a host, database, username and password, if they're missing, return false
	if($host=='' || $dbname=='' || $username=='' || $password==''){
		return false;
	}

	$conSBST = mysql_connect($host, $username, $password);
	if(!$conSBST){
		return false;
	}else{
		// Check our database exists shall we?
		$ret = mysql_select_db($dbname);
		if($ret == "0"){
			// Okay, lets try and create it then ....
			$ret = CreateDatabase($host, $username, $password, $dbname);
			$ret = mysql_select_db($dbname);
			if($ret == "0"){
				mysql_close($conSBST);
				return false;
			}
		}

		// Change empty vars to "NULL"
		if($spammername==''){$spammername='NULL';}
		if($spammerip==''){$spammerip='NULL';}
		if($spammeremail==''){$spammeremail='NULL';}

		// Trim anything that could screw with the SQL
		$spammername=str_replace(array("0x", ",", "%", "'","\r\n", "\r", "\n"), "", $spammername);
		$spammername=mysql_real_escape_string($spammername);

		$spammerip=str_replace(array("0x", ",", "%", "'","\r\n", "\r", "\n"), "", $spammerip);
		$spammerip=mysql_real_escape_string($spammerip);

		$spammeremail=str_replace(array("0x", ",", "%", "'","\r\n", "\r", "\n"), "", $spammeremail);
		$spammeremail=mysql_real_escape_string($spammeremail);

		$bAddNewSpammer='ADD';
		// Check to see if our spammer already exists (compares username/IP/E-mail AND the database they are listed in, returns false if only one matches)
		$sSQL = "SELECT fldspammer_id, fldspammer_name, fldspammer_count, fldspammer_ip, fldspammer_mail FROM tblspammers WHERE fldspammer_name='$spammername' OR fldspammer_ip='$spammerip' OR fldspammer_mail='$spammeremail' AND flddb_matched='$spamdb'";
		$sQuery = mysql_query($sSQL, $conSBST);
		if(!$sQuery){
			die(mysql_error());
		}else{
			$num = mysql_num_rows($sQuery);
			while ($row = mysql_fetch_array($sQuery)) {
				$bAddNewSpammer=$row['fldspammer_id'];
				$lSpammerCount=$row['fldspammer_count'];
			}
		}

		if($bAddNewSpammer=='ADD'){
			// ADD SPAMMER
			$sDate = date("YmdHis", time());
			$sSQL = "INSERT INTO tblspammers (fldspammer_name, fldspammer_ip, fldspammer_mail, flddb_matched, fldspammer_count, fldadded) VALUES('$spammername', '$spammerip', '$spammeremail', '$spamdb', '1','$sDate')";
			if(!mysql_query($sSQL, $conSBST)){
				die(mysql_error());
			}
		}else{
			// UPDATE SPAMMER
			$lSpammerCount = $lSpammerCount+1;
			$sSQL = "UPDATE tblspammers SET fldspammer_count='$lSpammerCount' WHERE fldspammer_id='$bAddNewSpammer'";
			if(!mysql_query($sSQL, $conSBST)){
				die(mysql_error());
			}
		}
		mysql_close($conSBST);
		return true;
	}
}

// Create the SBST database and table if it doesn't exist
//
//	Requires:
//
//		$host		= MySQL server (e.g. localhost)
//		$username	= MySQL Username (e.g. SBSTUser)
//		$password	= MySQL password
//		$dbname		= Database to create (e.g. SBST)
//
//	Usage:
//
//		$ret = CreateDatabase('localhost', 'sbstuser', 'sbst1234', 'SBST');
//		if($ret == "0"){
//			echo 'I couldn\'t create the SBST database, something went wrong ....';
//			mysql_close($conSBST);
//		}
//
//
function CreateDatabase($host, $username, $password, $dbname){
	$conSBST = mysql_connect($host,$username,$password);
	if(!$conSBST){
		return false;
	}else{
		// Create the database if it doesn't exist
		if (!mysql_query("CREATE DATABASE ".$dbname,$conSBST)){
			return mysql_error();
		}

		// Create table if it doesn't exist
		mysql_select_db($dbname, $conSBST);
		$sSQL = "CREATE TABLE IF NOT EXISTS tblspammers
		(
			fldspammer_id int NOT NULL AUTO_INCREMENT,
			PRIMARY KEY(fldspammer_id),
			fldspammer_name varchar(255),
			fldspammer_ip varchar(15),
			fldspammer_mail varchar(255),
			flddb_matched varchar(255),
			fldadded DATE,
			fldspammer_count int
		)";
		// Execute query
		if(!mysql_query($sSQL,$conSBST)){
			return mysql_error();
		}

		// ********************************
		// Not currently required
		// ********************************
		// Create counter table
		//mysql_select_db($dbname, $conSBST);
		//$sSQL = "CREATE TABLE IF NOT EXISTS tblspamcount(fldspam_count int)";
		// Execute query
		//if(!mysql_query($sSQL,$conSBST)){
		//	return mysql_error();
		//}

		// Cleanup
		if(!mysql_close($conSBST)){
			return mysql_error();
		}
		// Finish
		return true;
	}
}

?>