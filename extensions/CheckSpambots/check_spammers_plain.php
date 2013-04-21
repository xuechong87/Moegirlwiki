<?php
// **************************************************************
// File: check_spammers_plain.php
// Purpose: Used by scripts/mods to determine if user is a spammer
// Author: MysteryFCM
// Support: http://mysteryfcm.co.uk/?mode=Contact
//	    http://forum.hosts-file.net/viewforum.php?f=68
//	    http://www.temerc.com/forums/viewforum.php?f=71
// Last modified: 22-02-2011
// **************************************************************

	$sMyPath = dirname(__FILE__).'/';

	if(!file_exists($sMyPath.'config.php')==true){
		// Okay, lets try and copy the sample file
		if(file_exists($sMyPath.'config.sample.php')==true){
			if(!copy($sMyPath.'config.sample.php', './config.php')){
				die('config.php and config.sample.php are missing. Please restore these files');
			}
		}else{
			die('config.php is missing, did you forget to copy config.sample.php?');
		}
	}else{
		include($sMyPath.'config.php');
	}

	// Check for whitelist.txt
	if(!file_exists($sMyPath.'whitelist.txt')==true){
		// Okay, lets try and copy the sample file
		if(file_exists($sMyPath.'whitelist.sample.txt')==true){
			if(!copy($sMyPath.'whitelist.sample.txt', './whitelist.txt')){
				die('whitelist.txt and whitelist.sample.txt are missing. Please restore these files');
			}
		}else{
			die('whitelist.txt is missing, did you forget to copy whitelist.sample.txt?');
		}
	}

	include($sMyPath."functions.php");

function checkSpambots($mail,$ip,$name){
	$sMyPath = dirname(__FILE__).'/';

	// Include the language file
	include($sMyPath."en.php");
	include($sMyPath."config.php");

	// Do we want to check the DNS blacklists?
	//
	// We aren't going to actually be processing this, just checking if it's empty,
	// so you could use dbl=1 or dbl=no or dbl=ireallydonotcare
	//
	// Note, this is only used here, check_spammers.php doesn't include this (not
	// really necessary as it's not going to be used by scripts).
	$sCheckDNSBL = $_GET['dbl'];

	// If we do want to check the DNS blacklists, lets see if there are any singled out
	//
	// Note, this is only used here, check_spammers.php doesn't include this (not
	// really necessary as it's not going to be used by scripts).
	$sNoCheckSpamHaus = $_GET['sh']; // SpamHaus
	$sNoCheckSpamCop = $_GET['sc']; // SpamCOp
	$sNoCheckSorbs = $_GET['sb']; // Sorbs
	$sNoCheckPHP = $_GET['ph']; // Project Honey Pot
	$sNoCheckDrone = $_GET['drone']; // DroneBL
	$sNoCheckAHBL = $_GET['ahbl']; // AHBL
	$sNoCheckTVO = $_GET['tvo']; // Tornevall.org
	$sNoCheckEFN = $_GET['efn']; // EFNet
	$sNoCheckTor = $_GET['tor']; // Tor
	$sNoCheckDroneACH = $_GET['dach']; // Drone.abuse.ch
	$sNoCheckSpamACH = $_GET['sach']; // spam.abuse.ch
	$sNoCheckHTTPBLACH = $_GET['hach']; // HTTPBL.abuse.ch
	$sNoCheckZeusACH = $_GET['zach']; // ZeusTracker.abuse.ch

	// Some vars used ..... we need to set these to false to begin with
	$ahblspambot = false; // AHBL (Abusive Hosts Blacklist)
	$sdronespambot = false; // DroneBL
	$scopspambot = false; // Spamcop
	$sphpspambot = false; $sVisitorType = ''; // Project Honey Pot
	$sorbsspambot = false; // Sorbs
	$spamhausspambot = false; $sSHDB = ''; // Spamhaus
	$sfsspambot = false; // StopForumSpam
	$fslspambot = false; // fSpamlist
	$bsspambot = false; // BotScout
	$stvospambot = false; // dnsbl.tornevall.org
	$sefnetspambot = false; // efnetrbl.org
	$sTorspambot = false; // Tor
	$httpblachspambot = false; // HTTPBL.abuse.ch
	$droneachspambot = false; // Drone.abuse.ch
	$spamachspambot = false; // spam.abuse.ch
	$zeusachspambot = false; // ZeusTracker (abuse.ch)

	$spambot = false;

	// Ensure there are no spaces in the vars
	$name = str_replace(" ","%20",$name);
	$mail = str_replace(" ","%20",$mail);

	// Lowercase it
	$name=strtolower($name);
	$mail=strtolower($mail);

	if(phpversion() > "5"){
		if(class_exists('SimpleXMLElement') == true){
			$bXMLAvailable = true;
		}else{
			$bXMLAvailable = false;
		}
	}else{
		$bXMLAvailable = false;
	}

	$bFoundMatch=false;

	// Are we saving to database?
	if($bln_SaveToDB==true){
		// If it's already in our database, no need to check further .....
		$sSDBRet = IsSpammerInDB($dbShost, $dbSname, $dbSusername, $dbSpassword, $name, $ip, $mail);
		if($sSDBRet==true){
			echo 'Database match ';
			$spambot=true;
			$bFoundMatch=true;
		} // End if($sSDBRet==true)
	} // End if($bln_SaveToDB==true)

	// *********************************************************************************
	// BEGIN CHECK FSPAMLIST
	// *********************************************************************************
	//
	// No point checking if the user has told us not to, or a match has already been found
	$fspamcheck='';
	if(!$sFSLAPI==''){
		if($bCheckFSL ==TRUE && $bFoundMatch==false){
			$bFoundMatch=false;
			//if($mail==''){$mail='nobody@example.com';}
			//if($name==''){$name='no_name_given';}
			//if($ip==''){$ip='1.2.3.4';}

			$sFSLURL='http://www.fspamlist.com/xml.php?key='.$sFSLAPI.'&spammer='.$mail.','.$ip.','.$name;


			$fspamcheck = getURL($sFSLURL); $fspamcheck = strtolower($fspamcheck);
			if(!$_GET['debug']==''){echo 'DEBUG: '.htmlentities($fspamcheck, ENT_QUOTES).'<br>';}
			$fspamcheck = str_replace('\r', '', str_replace('\n', '', $fspamcheck)); $fspamcheck = str_replace(chr(10), '', str_replace(chr(13), '', $fspamcheck));
			if($fspamcheck=='unable to connect to server'){echo 'ERROR: could not connect to fSpamlist server [ '.$sFSLURL.' ]<br>';}

			// Let's see if we can figure out where those sporadic empty results and Bad Request errors are coming from
			if(substr_count($fspamcheck, "Bad Request") > 0 || $fspamcheck==''){
				echo 'FSL_EMPTY: Bad Request OR EMPTY TRUE';
			}

			if (substr_count($fspamcheck, 'true') > 0) {
				$bFoundMatch=true;
				// Needs to be handled a little differently so we can determine which one's have matched
				// due to the new FSL API.
				if(strpos($fspamcheck, $mail.'</spammer><isspammer>true')==true){$bMail = 'True';}else{$bMail='false';}
				if(strpos($fspamcheck, $ip.'</spammer><isspammer>true')==true){$bIP = 'True';}else{$bIP='false';}
				if(strpos($fspamcheck, $name.'</spammer><isspammer>true')==true){$bUsername = 'True';}else{$bUsername='false';}
				switch($BaseMatch){
					case "1,2": // Match username and IP
						if($bUsername == 'True' && $bIP == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
						break;
					case "1,3": // Match username and E-mail
						if($bUsername == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
						break;
					case "2,3": // Match IP and E-mail
						if($bIP == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
						break;
					case "1,2|1,3": // Match username and IP OR username + E-mail
						if($bUsername == 'True' && $bIP == 'True' || $bUsername == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
						break;
					case "1,2|1,3|2,3": // Match username and IP OR username + E-mail OR IP + E-mail
						if($bUsername == 'True' && $bIP == 'True' || $bUsername == 'True' && $bMail == 'True' || $bIP == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
						break;
					case "1,2|2,3": // Match username and IP OR IP + E-mail
						if($bUsername == 'True' && $bIP == 'True' || $bIP == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
						break;
					case "1,3|2,3": // Match username and Email OR IP + E-mail
						if($bUsername == 'True' && $bMail == 'True' || $bIP == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
						break;
					case "1,2,3": // Match Username, IP and E-mail
						if($bUsername == 'True' && $bIP == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
						break;
					default:
						// We don't match based solely on usernames alone
						if($bMail=='True' || $bIP=='True' || ($bUsername=='True' && $bMail=='True') || ($bUsername=='True' && $bIP=='True') || ($bIP=='True') || ($bMail=='True')){$bFoundMatch = true; break;}else{$bFoundMatch = false; break;}
				}
			} // End if(strpos($fspamcheck
			if($bFoundMatch==true){
				$fslspambot = true;
				$spambot = true; // Required seperately now that dumping to a text file is optional
				echo 'fSpamlist ';
			}else{
				$fslspambot = false;
			} // End if($bFoundMatch==true)

		} // End if($bCheckFSL ...

	} // End if(!$sFSLAPI .....
	// *********************************************************************************
	// END CHECK FSPAMLIST
	// *********************************************************************************

	// *********************************************************************************
	// BEGIN CHECK STOPFORUMSPAM
	// *********************************************************************************
	//
	// Reset vars to default
	$fspamcheck =''; $bSFSLimit=false;
	// No point checking if the user has told us not to, or a match has already been found
	if($bCheckSFS ==TRUE && $bFoundMatch==false){
		$bFoundMatch=false;
		$fspamcheck = getURL('http://www.stopforumspam.com/api?email='.$mail.'&ip='.$ip.'&username='.$name);

		// Let's see if we can figure out where those sporadic empty results and Bad Request errors are coming from
		if(substr_count($fspamcheck, "Bad Request") > 0 || $fspamcheck==''){
			echo 'SFS_EMPTY: Bad Request OR EMPTY TRUE';
		}

		$bSFSLimit = strpos($fspamcheck, 'rate limit exceeded');
		if($bSFSLimit == True){
			// Added due to SFS introducing a query limit
			//
			// http://www.stopforumspam.com/forum/t573-Rate-Limiting
			//
			$bFoundMatch=false; $bSFSLimit=TRUE;
		}else{
			if($bXMLAvailable == True && strpos($fspamcheck, '<') == True){
				$sfsxml = new SimpleXMLElement($fspamcheck);
				if($sfsxml->appears == 'yes'){
					if($sfsxml->appears == 'username yes'){$bUsername='True';}else{$bUsername='False';}
					if($sfsxml->appears == 'ip yes'){$bIP='True';}else{$bIP='False';}
					if($sfsxml->appears == 'email yes'){$bMail='True';}else{$bMail='False';}
					switch($BaseMatch){
						case "1,2": // Match username and IP
							if($bUsername == 'True' && $bIP == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
							break;
						case "1,3": // Match username and E-mail
							if($bUsername == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
							break;
						case "2,3": // Match IP and E-mail
							if($bIP == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
							break;
						case "1,2|1,3": // Match username and IP OR username + E-mail
							if($bUsername == 'True' && $bIP == 'True' || $bUsername == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
							break;
						case "1,2|1,3|2,3": // Match username and IP OR username + E-mail OR IP + E-mail
							if($bUsername == 'True' && $bIP == 'True' || $bUsername == 'True' && $bMail == 'True' || $bIP == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
							break;
						case "1,2|2,3": // Match username and IP OR IP + E-mail
							if($bUsername == 'True' && $bIP == 'True' || $bIP == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
							break;
						case "1,3|2,3": // Match username and Email OR IP + E-mail
							if($bUsername == 'True' && $bMail == 'True' || $bIP == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
							break;
						case "1,2,3": // Match Username, IP and E-mail
							if($bUsername == 'True' && $bIP == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
							break;
						default:
							// We don't match based solely on username alone.
							if($bMail=='True' || $bIP=='True' || ($bUsername=='True' && $bMail=='True') || ($bUsername=='True' && $bIP=='True') || ($bIP=='True') || ($bMail=='True')){$bFoundMatch = true; break;}else{$bFoundMatch = false; break;}
					}
				}
			}else{
				if (substr_count($fspamcheck, 'yes') > 0) {
					if(strpos($fspamcheck, 'username yes') !=False){$bUsername='True';}else{$bUsername='False';}
					if(strpos($fspamcheck, 'ip yes') !=False){$bIP='True';}else{$bIP='False';}
					if(strpos($fspamcheck, 'email yes') !=False){$bMail='True';}else{$bMail='False';}
					switch($BaseMatch){
						case "1,2": // Match username and IP
							if($bUsername == 'True' && $bIP == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
							break;
						case "1,3": // Match username and E-mail
							if($bUsername == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
							break;
						case "2,3": // Match IP and E-mail
							if($bIP == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
							break;
						case "1,2|1,3": // Match username and IP OR username + E-mail
							if($bUsername == 'True' && $bIP == 'True' || $bUsername == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
							break;
						case "1,2|1,3|2,3": // Match username and IP OR username + E-mail OR IP + E-mail
							if($bUsername == 'True' && $bIP == 'True' || $bUsername == 'True' && $bMail == 'True' || $bIP == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
							break;
						case "1,2|2,3": // Match username and IP OR IP + E-mail
							if($bUsername == 'True' && $bIP == 'True' || $bIP == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
							break;
						case "1,3|2,3": // Match username and Email OR IP + E-mail
							if($bUsername == 'True' && $bMail == 'True' || $bIP == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
							break;
						case "1,2,3": // Match Username, IP and E-mail
							if($bUsername == 'True' && $bIP == 'True' && $bMail == 'True'){$bFoundMatch = true;}else{$bFoundMatch = false;}
							break;
						default:
							if($bMail=='True' || $bIP=='True' || ($bUsername=='True' && $bMail=='True') || ($bUsername=='True' && $bIP=='True') || ($bIP=='True') || ($bMail=='True')){$bFoundMatch = true; break;}else{$bFoundMatch = false; break;}
					} // END Switch

				} // END if (strpos($fspamcheck, 'yes') !=False)

			} // END if($bXMLAvailable == True && strpos($fspamcheck, '<') == True)

		} // END if(strpos($fspamcheck, 'rate limit exceeded') ==True )

		if($bFoundMatch==true){
			$sfsspambot = true;
			$spambot = true; // Required seperately now that dumping to a text file is optional
			echo 'StopForumSpam ';
		}else{
			$sfsspambot = false;
			if($bSFSLimit==true){
				echo 'StopForumSpam informed me your daily query limit has been exceeded<br>';
			}
		} // End if($bFoundMatch==true)
	}

	// *********************************************************************************
	// END CHECK STOPFORUMSPAM
	// *********************************************************************************

	// *********************************************************************************
	// BEGIN CHECK BOTSCOUT
	// *********************************************************************************
	//
	// Check the username etc against BotScout. Done using a single query for efficiency
	// as we don't need multiple queries for the plain version.
	//
	// If any of the values are missing, BotScout will ignore them (better for us as it
	// prevents us having to deal with them, which thus prevents spammers potentially
	// abusing it)
	//
	// No point checking if the user has told us not to, or a match has already been found
	if($sBSAPI !='' && $bFoundMatch==false){
		$bFoundMatch=false;
		$sBSMail = $mail;
		$sBSIP = $ip;
		$sBSName = $name;
		$sBSURL = 'http://botscout.com/test/?multi&key='.$sBSAPI.'&mail='.$sBSMail.'&ip='.$sBSIP.'&name='.$sBSName;
		$fspamcheck = getURL($sBSURL);

		// Let's see if we can figure out where those sporadic empty results and Bad Request errors are coming from
		if(substr_count($fspamcheck, "Bad Request") > 0 || $fspamcheck==''){
			echo 'BotScout_EMPTY: Bad Request OR EMPTY TRUE';
		}

		// BotScout error codes begin with an apostrophe, so we'll check for those first
		if (substr_count($fspamcheck, '! ') > 0) {
			$bFoundMatch = false;
			echo 'Error: '.$fspamcheck;
		}else{

			// $sSpamData[3] = IP
			// $sSpamData[5] = Email
			// $sSpamData[7] = Username
			if($_GET['debug']=='1'){echo 'SENT: '.htmlentities($sBSURL, ENT_QUOTES).'<br>RECEIVED: '.htmlentities($fspamcheck, ENT_QUOTES).'<br>';}
			$sSpamData = explode('|',$fspamcheck);
			if($sSpamData[0] == 'Y'){
				switch($BaseMatch){
					case "1,2": // Match username and IP
						if($sSpamData[7] > 0 && $sSpamData[3] > 0){$bFoundMatch = true;}else{$bFoundMatch = false;}
						break;
					case "1,3": // Match username and E-mail
						if($sSpamData[7] > 0 && $sSpamData[5] > 0){$bFoundMatch = true;}else{$bFoundMatch = false;}
						break;
					case "2,3": // Match IP and E-mail
						if($sSpamData[3] > 0 && $sSpamData[5] > 0){$bFoundMatch = true;}else{$bFoundMatch = false;}
						break;
					case "1,2|1,3": // Match username and IP OR username + E-mail
						if($sSpamData[7] > 0 && $sSpamData[3] > 0 || $sSpamData[7] > 0 && $sSpamData[5] > 0){$bFoundMatch = true;}else{$bFoundMatch = false;}
						break;
					case "1,2|1,3|2,3": // Match username and IP OR username + E-mail OR IP + E-mail
						if($sSpamData[7] > 0 && $sSpamData[3] > 0 || $sSpamData[7] > 0 && $sSpamData[5] > 0 || $sSpamData[3] > 0 && $sSpamData[5] > 0){$bFoundMatch = true;}else{$bFoundMatch = false;}
						break;
					case "1,2|2,3": // Match username and IP OR IP + E-mail
						if($sSpamData[7] > 0 && $sSpamData[3] > 0 || $sSpamData[3] > 0 && $sSpamData[5] > 0){$bFoundMatch = true;}else{$bFoundMatch = false;}
						break;
					case "1,3|2,3": // Match username and Email OR IP + E-mail
						if($sSpamData[7] > 0 && $sSpamData[5] > 0 || $sSpamData[3] > 0 && $sSpamData[5] > 0){$bFoundMatch = true;}else{$bFoundMatch = false;}
						break;
					case "1,2,3": // Match Username, IP and E-mail
						if($sSpamData[7] > 0 && $sSpamData[3] > 0 && $sSpamData[5] > 0){$bFoundMatch = true;}else{$bFoundMatch = false;}
						break;
					default:
						if($sSpamData[3] > 0 || $sSpamData[5] > 0){$bFoundMatch = true;}else{$bFoundMatch = false;}
				}
			}else{
				$bFoundMatch = false;
			}

		} // End if (strpos($fspamcheck, '! ') !=False)

		if($bFoundMatch==true){
			$bsspambot = true;
			$spambot = true; // Required seperately now that dumping to a text file is optional
			echo 'BotScout ';
		}else{
			$bsspambot = false;
		} // End if($bFoundMatch==true)

	} // End If ($sBSAPI !='')

	// *********************************************************************************
	// END CHECK BOTSCOUT
	// *********************************************************************************

	// *********************************************************************************
	// BEGIN CHECK DNSBL
	// *********************************************************************************
	// No point checking if the user has told us not to, the IP isn't present, or a match has already been found
	if ($ip !='' && $sCheckDNSBL =='' && $bFoundMatch==false){
		$address = $ip;
		$rev = implode('.',array_reverse(explode('.', $address)));

		//
		// Check the IP against drone.abuse.ch
		//
		// Response 127.0.0.2: "Spam related FastFlux Bot"
		// IP addresses with this response code are part of a spam related FastFlux botnet (e.g My Canadian Pharmacy, HerbalKing, etc).
		// 
		// Response 127.0.0.3: "Malware related FastFlux Bot"
		// IP addresses with this response code are part of a malware related FastFlux botnet (e.g. Warezov, Storm, etc).
		// 
		// Response 127.0.0.4: "Phish related FastFlux Bot"
		// IP addresses with this response code are part of a phish related FastFlux botnet (mostly Rock phish botnet).
		// 
		// Response 127.0.0.5: "Scam related FastFlux Bot"
		// IP addresses with this response code are part of a scam related FastFlux botnet (e.g. Money-Mule).

		if($sNoCheckDroneACH ==''){
			$lookup = $rev.'.drone.abuse.ch.';
			$sDACH = gethostbyname($lookup);
			switch ($sDACH)
			{
				case "127.0.0.2":
					$droneachspambot = true;
					echo 'DRONE (SPAM) abuse.ch ';
					break;
				case "127.0.0.3":
					$droneachspambot = true;
					echo 'DRONE (MALWARE) abuse.ch ';
					break;
				case "127.0.0.4":
					$droneachspambot = true;
					echo 'DRONE (PHISH) abuse.ch ';
					break;
				case "127.0.0.5":
					$droneachspambot = true;
					echo 'DRONE (SCAM) abuse.ch ';
					break;
				default:
					$droneachspambot = false;
					break;
       			} // End if ($lookup != gethostbyname($lookup))
		}

		//
		// Check the IP against httpbl.abuse.ch
		//
		// Response 127.0.0.2: "Source of hacking activities"
		// IP addresses with this response code are source of hacking activities (mostly Script-Kiddies). They tried to access one or more PHPShells (eg. r57Shell, C99Shell or similar) which are installed on my honeypots (mostly they find these scripts thru a search engine like google). These PHPShells give an attacker the posibility to deface your webserver or install further malicious code.
		// 
		// Response 127.0.0.3: "Hjacked webserver (source of RFI attacks)"
		// IP addresses with this response code are mostly hijacked systems or webservers. They are scanning the web for vulnerable webservers and try to inject malicious code using Remote File Inclusion (RFI attack). This scripts are often used for mass defacements or install further malicious scripts (eg. Shellbots for DDoS etc.)
		// 
		// Response 127.0.0.4: "Referer Spam"
		// IP addresses with this response code are using referer spam to give websites a better ranking on search engines. They are just bothersome because they flood your webserver log and your webstatistic with crap.
		// 
		// Response 127.0.0.5: "Automated scanning drone"
		// IP addresses with this response code are automated scanning drones (eg. drones which scanning the web for vulnerable web servers, open proxy scanners etc.)

		if($sNoCheckHTTPBLACH ==''){
			$lookup = $rev.'.httpbl.abuse.ch.';
			$sDACH = gethostbyname($lookup);
			switch ($sDACH)
			{
				case "127.0.0.2":
					$httpblachspambot = true;
					echo 'HTTPBL (HACKING) abuse.ch ';
					break;
				case "127.0.0.3":
					$httpblachspambot = true;
					echo 'HTTPBL (HIJACKED_SERVER) abuse.ch ';
					break;
				case "127.0.0.4":
					$httpblachspambot = true;
					echo 'HTTPBL (REFERER_SPAM) abuse.ch ';
					break;
				case "127.0.0.5":
					$httpblachspambot = true;
					echo 'HTTPBL (AUTO_SCAN_DRONE) abuse.ch ';
					break;
				default:
					$httpblachspambot = false;
					break;
       			} // End if ($lookup != gethostbyname($lookup))
		}


		//
		// Check the IP against spam.abuse.ch
		//
		// Response 127.0.0.2: "Sends spam to spamtrap"
		//
		// Response 127.0.0.3: "Pushdo Spambot"
		// 
		// Response 127.0.0.4: "Ozdok Spambot"

		if($sNoCheckSpamACH ==''){
			$lookup = $rev.'.spam.abuse.ch.';
			$sDACH = gethostbyname($lookup);
			switch ($sDACH)
			{
				case "127.0.0.2":
					$spamachspambot = true;
					echo 'SPAM abuse.ch ';
					break;
				case "127.0.0.3":
					$spamachspambot = true;
					echo 'SPAM (Pushdo) abuse.ch ';
					break;
				case "127.0.0.4":
					$spamachspambot = true;
					echo 'SPAM (Ozdok) abuse.ch ';
					break;
				default:
					$spamachspambot = false;
					break;
       			} // End if ($lookup != gethostbyname($lookup))
		}

		//
		// Check the IP against zeustracker.abuse.ch
		//
		if($sNoCheckZeusACH ==''){
			$lookup = $rev.'.ipbl.zeustracker.abuse.ch.';
			$lookup = gethostbyname($lookup);
			if ($lookup =='127.0.0.2')
			{
				$zeusachspambot = true;
				echo 'ZEUS abuse.ch ';
       			}else{
				$zeusachspambot = false;
			} // End if ($lookup != gethostbyname($lookup))
		}

		// ahbl returns codes based on which blacklist the IP is in;
		//
		// 127.0.0.2 - Open Relay
		// 127.0.0.3 - Open Proxy
		// 127.0.0.4 - Spam Source
		// 127.0.0.5 - Provisional Spam Source Listing block (will be removed if spam stops)
		// 127.0.0.6 - Formmail Spam
		// 127.0.0.7 - Spam Supporter
		// 127.0.0.8 - Spam Supporter (indirect)
		// 127.0.0.9 - End User (non mail system)
		// 127.0.0.10 - Shoot On Sight
		// 127.0.0.11 - Non-RFC Compliant (missing postmaster or abuse)
		// 127.0.0.12 - Does not properly handle 5xx errors
		// 127.0.0.13 - Other Non-RFC Compliant
		// 127.0.0.14 - Compromised System - DDoS
		// 127.0.0.15 - Compromised System - Relay
		// 127.0.0.16 - Compromised System - Autorooter/Scanner
		// 127.0.0.17 - Compromised System - Worm or mass mailing virus
		// 127.0.0.18 - Compromised System - Other virus
		// 127.0.0.19 - Open Proxy
		// 127.0.0.20 - Blog/Wiki/Comment Spammer
		// 127.0.0.127 - Other
		//
		if($sNoCheckAHBL==''){
			$lookup = $rev.'.dnsbl.ahbl.org.';
			$ahbltemp = gethostbyname($lookup);
			switch ($ahbltemp) {
				case "127.0.0.2":
					$sVisitorType = "Open Relay"; $ahblspambot = true; break;
				case "127.0.0.3":
					$sVisitorType = "Open Proxy"; $ahblspambot = true; break;
				case "127.0.0.4":
					$sVisitorType = "Spam Source"; $ahblspambot = true; break;
				case "127.0.0.5":
					$sVisitorType = "Provisional Spam Source Listing block (will be removed if spam stops)"; $ahblspambot = true; break;
				case "127.0.0.6":
					$sVisitorType = "Formmail Spam"; $ahblspambot = true; break;
				case "127.0.0.7":
					$sVisitorType = "Spam Supporter"; $ahblspambot = true; break;
				case "127.0.0.8":
					$sVisitorType = "Spam Supporter (indirect)"; $ahblspambot = true; break;
				case "127.0.0.9": // We don't flag end user systems unless they're spammers or match one of the other criteria
					$sVisitorType = "End User (non mail system)"; $ahblspambot = false; break;
				case "127.0.0.10":
					$sVisitorType = "Shoot On Sight"; $ahblspambot = true; break;
				case "127.0.0.11": // I'd love to match these and force RFC compliance, but that's just me, so we don't flag these either
					$sVisitorType = "Non-RFC Compliant (missing postmaster or abuse)"; $ahblspambot = false; break;
				case "127.0.0.12": // Not handling errors properly does not a spammer/attacker make
					$sVisitorType = "Does not properly handle 5xx errors"; $ahblspambot = false; break;
				case "127.0.0.13": // Again, we don't flag those just because they aren't RFC compliant
					$sVisitorType = "Other Non-RFC Compliant"; $ahblspambot = false; break;
				case "127.0.0.14":
					$sVisitorType = "Compromised System - DDoS"; $ahblspambot = true; break;
				case "127.0.0.15":
					$sVisitorType = "Compromised System - Relay"; $ahblspambot = true; break;
				case "127.0.0.16":
					$sVisitorType = "Compromised System - Autorooter/Scanner"; $ahblspambot = true; break;
				case "127.0.0.17":
					$sVisitorType = "Compromised System - Worm or mass mailing virus"; $ahblspambot = true; break;
				case "127.0.0.18":
					$sVisitorType = "Compromised System - Other virus"; $ahblspambot = true; break;
				case "127.0.0.19":
					$sVisitorType = "Open Proxy"; $ahblspambot = true; break;
				case "127.0.0.20":
					$sVisitorType = "Blog/Wiki/Comment Spammer"; $ahblspambot = true; break;
				case "127.0.0.127":
					$sVisitorType = "Other"; $ahblspambot = true; break;
				default:
					$ahblspambot = false; break;
			} // End Switch
			// Do an echo if $ahblpambot = true
			if($ahblspambot == true){
				echo 'AHBL ('.$ahbltemp.' - '.$sVisitorType.') ';
			} // End if($ahblspambot ....

		} // End if($sNoCheckAHBL ....

		//
		// Check the IP against projecthoneypot.org
		//
		if($sPHPAPI !='' && $sNoCheckPHP ==''){
			$lookup = $sPHPAPI.'.'.$rev.'.dnsbl.httpbl.org.';
			if ($lookup != gethostbyname($lookup))
			{

				$sphpspambot = true;
				$sTempArr = explode('.',gethostbyname($lookup));
				if($sTempArr[0]=='127'){
					$sDays = $sTempArr[1];
					$sThreatScore = $sTempArr[2];
					$sVisitorType = $sTempArr[3]; // Let's see what PHP says about this IP
					switch ($sVisitorType) {
						case "0":
							$sVisitorType = "Search Engine";
							$sphpspambot = false;
							break;
						case "1":
							$sVisitorType = "Suspicious";
							$sphpspambot = false;
							break;
						case "2":
							$sVisitorType = "Harvester";
							$sphpspambot = true;
							break;
						case "3":
							$sVisitorType = "Suspicious &amp; Harvester";
							$sphpspambot = true;
							break;
						case "4":
							$sVisitorType = "Comment Spammer";
							$sphpspambot = true;
							break;
						case "5":
							$sVisitorType = "Suspicious &amp; Comment Spammer";
							$sphpspambot = true;
							break;
						case "6":
							$sVisitorType = "Harvester &amp; Comment Spammer";
							$sphpspambot = true;
							break;
						case "7":
							$sVisitorType = "Suspicious &amp; Harvester &amp; Comment Spammer";
							$sphpspambot = true;
							break;
					}
					// Do an echo if $sphpspambot = true
					if($sphpspambot == true){
						echo 'ProjectHoneyPot ('.gethostbyname($lookup).' - '.$sVisitorType.') ';
					}
				}else{
					echo 'Error:'.gethostbyname($lookup); $sphpspambot=false;
				}
			} // End if ($lookup != gethostbyname($lookup))
		} // End If

		//
		// Check the IP against Sorbs
		//
		//	http://www.au.sorbs.net/using.shtml
		//
		if($sNoCheckSorbs ==''){
			$lookup = $rev.'.l2.spews.dnsbl.sorbs.net.';
			if ($lookup != gethostbyname($lookup))
			{
				$sorbsspambot = true;
				echo 'Sorbs ';
       			} // End if ($lookup != gethostbyname($lookup))
		}

		//
		// Check the IP against Sorbs
		//
		if($sNoCheckSorbs ==''){
			$lookup = $rev.'.problems.dnsbl.sorbs.net.';
			if ($lookup != gethostbyname($lookup))
			{
				$sorbsspambot = true;
				echo 'Sorbs ';
       			} // End if ($lookup != gethostbyname($lookup))
		}

		//
		// Check the IP against Spamhaus
		//
		if($sNoCheckSpamHaus ==''){
			$spamhausspambot = false;
			$lookup = $rev.'.zen.spamhaus.org.';

			// Spamhaus returns codes based on which blacklist the IP is in;
			//
			// 127.0.0.2		= SBL (Direct UBE sources, verified spam services and ROKSO spammers)
			// 127.0.0.3		= Not used
			// 127.0.0.4-8		= XBL (Illegal 3rd party exploits, including proxies, worms and trojan exploits)
			//	- 4		= CBL
			//	- 5		= NJABL Proxies (customized)
			// 127.0.0.9		= Not used
			// 127.0.0.10-11	= PBL (IP ranges which should not be delivering unauthenticated SMTP email)
			//	- 10		= ISP Maintained
			//	- 11		= Spamhaus Maintained
			//
			// We don't flag the CBL or PBL here.

			$spamhaustemp = gethostbyname($lookup);
			switch ($spamhaustemp){
				case "127.0.0.2":
					$sSHDB = "(SBL) ";
					$spamhausspambot = true;
					break;
				case "127.0.0.4": // We don't flag those in the CBL
					$sSHDB = "(CBL) ";
					$spamhausspambot = false;
					break;
				case "127.0.0.5":
					$sSHDB = "(NJABL) ";
					$spamhausspambot = true;
					break;
				case "127.0.0.6":
					$sSHDB = "(XBL) ";
					$spamhausspambot = true;
					break;
				case "127.0.0.7":
					$sSHDB = "(XBL) ";
					$spamhausspambot = true;
					break;
				case "127.0.0.8":
					$sSHDB = "(XBL) ";
					$spamhausspambot = true;
					break;
				case "127.0.0.10": // We don't flag those in the PBL
					$sSHDB = "(PBL - ISP Maintained) ";
					$spamhausspambot = false;
					break;
				case "127.0.0.11": // We don't flag those in the PBL
					$sSHDB = "(PBL - Spamhaus Maintained) ";
					$spamhausspambot = false;
					break;
				default: // We only flag valid responses
					$sSHDB = "";
					$spamhausspambot = false;
					break;
			} // End switch

			if($spamhausspambot == true){
				echo 'Spamhaus '.$sSHDB;
			} // End if

		} // End $sNoCheckSpamHaus

		//
		// Check the IP against SpamCop.net
		//
		if($sNoCheckSpamCop ==''){
			$lookup = $rev.'.bl.spamcop.net.';
			if (gethostbyname($lookup) == '127.0.0.2')
			{
				$scopspambot = true;
				echo 'SpamCop ';
			} // End if ($lookup != gethostbyname($lookup))
		}

		//
		// Check the IP against DroneBL
		//
		if($sNoCheckDrone ==''){
			$lookup = $rev.'.dnsbl.dronebl.org.';
			if ($lookup != gethostbyname($lookup))
			{
				$sdronespambot = true;
				echo 'DroneBL ';
			} // End if ($lookup != gethostbyname($lookup))
		}

		//
		// Check the IP against dnsbl.tornevall.org
		//
		if($sNoCheckTVO==''){
			$lookup = $rev.'.opm.tornevall.org.';
			if ($lookup != gethostbyname($lookup))
			{
				$stvospambot = true;
				echo 'Tornevall ';
			}
		}

		//
		// Check the IP against efnetrbl.org
		//
		if($sNoCheckEFN==''){
			$lookup = $rev.'.rbl.efnetrbl.org.';
			if ($lookup != gethostbyname($lookup))
			{
				$sefnetspambot = true;
				echo 'EFNet ';
			}
		}

		//
		// Check the IP against torproject.org
		//
		//	Special thanks (albeit a little late - my fault for forgetting the first time ;o)) to Zaphod (spambotsecurity.com)
		//	for the URI for this one ...
		//
		if($sNoCheckTor==''){
			$lookup = gethostbyname($rev.'.80.104.161.233.64.ip-port.exitlist.torproject.org.');
			if ($lookup == "127.0.0.2")
			{
				$sTorspambot = true;
				echo 'Tor Exit Node ';
			}
		}

		if($sTorspambot == true || $sefnetspambot == true || $sstraptvospambot == true || $stvospambot == true || $sphpspambot ==true || $sorbsspambot ==true || $spamhausspambot ==true || $scopspambot || $sdronespambot==true || $ahblspambot == true || $httpblachspambot == true || $droneachspambot == true || $spamachspambot == true || $zeusachspambot == true){
			$spambot = true; // Required seperately now that dumping to a text file is optional
		}
	} // End if ($ip !='')
	// *********************************************************************************
	// END CHECK DNSBL
	// *********************************************************************************

	// *********************************************************************************
	// We've let the user know the database, all we need to do now is let the user know the status
	// *********************************************************************************

	if($spambot == true){
		echo 'TRUE';
	}else{
		echo 'FALSE';
	}

	// *********************************************************************************
	// BEGIN SUBMIT TO FSPAMLIST
	// *********************************************************************************
	// Do we want to submit this to fSpamlist?
	if($sFSLAPI !='' && $spambot ==true && $fslspambot ==false && $blnSubmitToFSL==TRUE){
		// Only submit it if it's not PBL/CBL (Spamhaus)
		if($spamhaustemp !=' (PBL - ISP Maintained)' && $spamhaustemp !=' (PBL - Spamhaus Maintained)' && $spamhaustemp !=' (CBL)'){
			$bSubmitted = false;
			// Is there an e-mail address?
			if($mail !=''){
				$sFSLM = 'http://www.fspamlist.com/apiadd.php?spammer='.$mail.'&type=email&key='.$sFSLAPI.'&from='.$_SERVER['SERVER_NAME'];
				$fspamsubmit = getURL($sFSLM);
				if (substr_count($fspamsubmit, 'Added successfully!') > 0) {
					$bSubmitted = true;
				}else{
					$bSubmitted = false;
				}
			}

			// Is there a username?
			if($name !=''){
				$sFSLU = 'http://www.fspamlist.com/apiadd.php?spammer='.$name.'&type=username&key='.$sFSLAPI.'&from='.$_SERVER['SERVER_NAME'];
				$fspamsubmit = getURL($sFSLU);
				if (substr_count($fspamsubmit, 'Added successfully!') > 0) {
					$bSubmitted = true;
				}else{
					$bSubmitted = false;
				}
			}

			// Is there an IP address?
			if($ip !=''){
				$sFSLI = 'http://www.fspamlist.com/apiadd.php?spammer='.$ip.'&type=ip&key='.$sFSLAPI.'&from='.$_SERVER['SERVER_NAME'];
				$fspamsubmit = getURL($sFSLI);
				if (substr_count($fspamsubmit, 'Added successfully!') > 0) {
					$bSubmitted = true;
				}else{
					$bSubmitted = false;
				}
			}

		} // End if($spamhaustemp ....
	} // End if($sFSLAPI ...
	// *********************************************************************************
	// END SUBMIT TO FSPAMLIST
	// *********************************************************************************

	// *********************************************************************************
	// Create a .txt file with the info of the spambot, if this one already exists, increase its amount of try's
	// *********************************************************************************
	if($spambot ==true){
		if($stvospambot == true){
			$spambot = true;
			if($bln_SaveToFile == true){$lRet = LogSpammerToFile($savetofolder, 'Tornevall',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'Tornevall', $name, $ip, $mail);}
		} // End Tornevall (dnsbl.tornevall.org)

		if($storspambot == true){
			$spambot = true;
			if($bln_SaveToFile == true){$lRet = LogSpammerToFile($savetofolder, 'Tor',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'Tor', $name, $ip, $mail);}
		} // End Tornevall (dnsbl.torproject.org)

		if($sefnetspambot == true){
			$spambot = true;
			if($bln_SaveToFile == true){$lRet = LogSpammerToFile($savetofolder, 'EFNet',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'EFNet', $name, $ip, $mail);}
		} // End EFNet (rbl.efnetrbl.org)

		if($bsspambot == true){
			$spambot = true;
			if($bln_SaveToFile == true){$lRet = LogSpammerToFile($savetofolder, 'BotScout',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'BotScout', $name, $ip, $mail);}
		} // End BotScout

		if($ahblspambot == true){
			$spambot = true;
			if($bln_SaveToFile == true){$lRet = LogSpammerToFile($savetofolder, 'AHBL',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'AHBL', $name, $ip, $mail);}
		} // End AHBL (Abusive Hosts Black List)

		if($sfsspambot == true){
			$spambot = true;
			if($bln_SaveToFile ==true){$lRet = LogSpammerToFile($savetofolder, 'StopForumSpam',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'StopForumSpam', $name, $ip, $mail);}
		} // End StopForumSpam

		if($fslspambot == true){
			$spambot = true;
			if($bln_SaveToFile ==true){$lRet = LogSpammerToFile($savetofolder, 'fSpamlist',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'fSpamList', $name, $ip, $mail);}
		} // End fSpamList

		if($sphpspambot == true && $sPHPAPI !=''){
			$spambot = true;
			if($bln_SaveToFile ==true){$lRet = LogSpammerToFile($savetofolder, 'ProjectHoneyPot',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'ProjectHoneyPot', $name, $ip, $mail);}
		} // End ProjectHoneyPot

		if($sorbsspambot == true){
			$spambot = true;
			if($bln_SaveToFile ==true){$lRet = LogSpammerToFile($savetofolder, 'Sorbs',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'Sorbs', $name, $ip, $mail);}
		} // End Sorbs

		if($spamhausspambot == true){
			$spambot = true;
			if($bln_SaveToFile ==true){$lRet = LogSpammerToFile($savetofolder, 'SpamHaus',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'SpamHaus', $name, $ip, $mail);}
		} // End Spamhaus

		if($scopspambot == true){
			$spambot = true;
			if($bln_SaveToFile ==true){$lRet = LogSpammerToFile($savetofolder, 'SpamCop',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'SpamCop', $name, $ip, $mail);}
		} // End SpamCop

		if($sdronespambot == true){
			$spambot = true;
			if($bln_SaveToFile ==true){$lRet = LogSpammerToFile($savetofolder, 'DroneBL',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'DroneBL', $name, $ip, $mail);}
		} // End SpamCop

		// *********************************************************************************************************************************************
		// abuse.ch
		// *********************************************************************************************************************************************
		if($droneachspambot == true){
			$spambot = true;
			if($bln_SaveToFile ==true){$lRet = LogSpammerToFile($savetofolder, 'Abuse.ch (Drone)',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'Abuse.ch (Drone)', $name, $ip, $mail);}
		} // End Drone
		if($httpblachspambot == true){
			$spambot = true;
			if($bln_SaveToFile ==true){$lRet = LogSpammerToFile($savetofolder, 'Abuse.ch (HTTPBL)',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'Abuse.ch (HTTPBL)', $name, $ip, $mail);}
		} // End HTTPBL
		if($spamachspambot == true){
			$spambot = true;
			if($bln_SaveToFile ==true){$lRet = LogSpammerToFile($savetofolder, 'Abuse.ch (SPAM)',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'Abuse.ch (SPAM)', $name, $ip, $mail);}
		} // End Spam
		if($zeusachspambot == true){
			$spambot = true;
			if($bln_SaveToFile ==true){$lRet = LogSpammerToFile($savetofolder, 'Abuse.ch (Zeus)',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'Abuse.ch (Zeus)', $name, $ip, $mail);}
		} // End Zeus
		// *********************************************************************************************************************************************
		// END abuse.ch
		// *********************************************************************************************************************************************

	} // End if file_exists($savetofolder)
	// *********************************************************************************
	// END CREATE TEXT FILES
	// *********************************************************************************

	return $spambot;

} // End function checkSpambots

if(isset($_GET['email']) && $_GET['email'] !='' || isset($_GET['ip']) && $_GET['ip'] !='' || isset($_GET['name']) && $_GET['name'] !=''){
	//if(@curl_version() !=='Array' && !@function_exists('file_get_contents')){
	//	echo $nocurlorfgc;
	//}else{
		// Has an e-mail been passed? If so, check it's valid
		$sMail = $_GET['email'];
		if($sMail !=''){
			$bMailValid = IsValidEmail($sMail);
			//echo "bMailValid: " . $bMailValid.'<br><br>';
			if(!$bMailValid == TRUE){
				if($bFailOnInvalidEmail==TRUE){
					die('INVALID_EMAIL TRUE');
				}else{
					$sMail = ''; // Can't use it if it's not valid
				}
			}
		}

		// Has an IP been passed? If so, check it's valid
		$sIP = $_GET['ip'];
		if($sIP !=''){
			if(IsvalidIP($sIP)==FALSE){
				$sIP = ''; // Can't use it if it's not valid
			}
		}

		// Sadly, usernames can usually contain absolutely any characters, not just letters
		// and numbers, so gonna be difficult to filter it
		$sName = $_GET['name']; $sName = addslashes(htmlentities($sName)); $sName = urlencode($sName);

		// ************************
		// Check Whitelist
		// ************************
		if(file_exists('whitelist.txt')){
			$sWhitelist = @file_get_contents('whitelist.txt');
			if(!strlen($sWhitelist)==0){
				$sTName=$sName; $sTMail=$sMail; $sTIP=$sIP;

				if(strlen($sTName)==0){$sTName="NULL";}
				if(strlen($sTMail)==0){$sTMail="nobody@example.com";}
				if(strlen($sTIP)==0){$sTIP="0.0.0.0";}

				if(substr_count($sWhitelist, $sTName) > 0 || substr_count($sWhitelist, $sTMail) > 0 || substr_count($sWhitelist, $sTIP) > 0){
					die('FALSE');
				}
			}
		} // End if(file_exists....

		// ********************************************
		// Okay, lets process the details shall we?
		// ********************************************
		$spambot = checkSpambots($sMail,$sIP,$sName);

		// ************************
		// Increase our catch count
		// ************************
		if($spambot == 'TRUE'){
			$lDummy = IncreaseCatchCount(); // Function in functions.php that is used to increase the counter
		}
	//}
}
?>