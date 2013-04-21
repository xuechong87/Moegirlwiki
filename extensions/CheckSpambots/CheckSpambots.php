<?php
// **************************************************************
// File: check_spammers.php
// Purpose: Used by index.php for the web interface to perform the
//	    spambot checks
// Author: MysteryFCM
// Support: http://mysteryfcm.co.uk/?mode=Contact
//	    http://forum.hosts-file.net/viewforum.php?f=68
//	    http://www.temerc.com/forums/viewforum.php?f=71
// Last modified: 12-02-2011
// **************************************************************

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

function checkSpambots($mail,$ip,$name){
	$sMyPath = dirname(__FILE__).'/';
	// Include the language file
	include($sMyPath."en.php");
	// Include the config file
	include($sMyPath."config.php");

	$ahblspambot = false; // AHBL (Abusive Hosts Blacklist)
	$sdronespambot = false; // DroneBL
	$scopspambot = false; // SpamCop
	$sphpspambot = false; // Project Honey Pot
	$sorbsspambot = false; // Sorbs
	$spamhausspambot = false; // Spamhaus
	$sfsspambot = false; // StopForumSpam
	$fslspambot = false; // fSpamlist
	$bsspambot = false; // BotScout
	$stvospambot = false; // dnsbl.tornevall.org
	$sefnetspambot = false; // efnetrbl.org
	$sTorspambot = false; // Torproject.org
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

	// Set init table ....
	echo '<table class="results" width="60%" cellpadding="3" cellspacing="0">';
	echo '<tr><th width="100px" class="results">Type</th><th class="results">Result</th></tr>';

	// We want to print the result at the top of the table, so lets create a temporary var for the results shall we?
	$sTD_Results = '';

	// *********************************************************************************
	// BEGIN CHECK FSPAMLIST
	// *********************************************************************************
	//
	// Check the e-mail address against fSpamlist
	//
	$sTD_Results = '<tr><td class="results_white" colspan="2"><b>Checking <a class="results" href="http://www.fspamlist.com/">fSpamList</a></b> ....</td></tr>';
	if($sFSLAPI==''){
		$sTD_Results = $sTD_Results . '<tr><td class="results_white" colspan="2"><span class="error">'.$sFSLAPIError.'</span></td></tr>';
	}else{
		// Get the FSL URL ready
		$sFSLURL = 'http://www.fspamlist.com/xml.php?key='.$sFSLAPI.'&spammer=';

		if($mail !='' && $bCheckFSL ==TRUE){
			$sFSLURL = $sFSLURL . $mail;
		} // End If(!$mail=")

		//
		// Now check the IP
		//
		if($ip !='' && $bCheckFSL ==TRUE){
			if($mail==''){$sFSLURL = $sFSLURL . $ip;}else{$sFSLURL = $sFSLURL .','.$ip;}
		} // End If

		//
		// Lets check the username
		//
		if($name !='' && $bCheckFSL ==TRUE){
			if($mail=='' && $ip==''){$sFSLURL = $sFSLURL . $name;}else{$sFSLURL = $sFSLURL .','.$name;}
		} // End If

		$fspamcheck = getURL($sFSLURL); $fspamcheck = strtolower($fspamcheck);
		$fspamcheck = str_replace('\r', '', str_replace('\n', '', $fspamcheck)); $fspamcheck = str_replace(chr(10), '', str_replace(chr(13), '', $fspamcheck));

		if (strpos($fspamcheck, 'true') !=False) {
			// Needs to be handled a little differently so we can determine which one's have matched
			// due to the new FSL API.
			$fslspambot=true;
			if(!$mail==''){
				if(strpos($fspamcheck, $mail.'</spammer><isspammer>true')==true){
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Email.':</td><td class="results_white"><span style="color: #ff0000">'.$emailfound.'</span></td>';
				}else{
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Email.':</td><td class="results_white">'.$nomatches.'</td></tr>';
				}
			}else{
				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Email.':</td><td class="results_white">'.$queryskipped.'</td></tr>';
			}
			if(!$ip==''){
				if(strpos($fspamcheck, $ip.'</spammer><isspammer>true')==true){
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_IPAddr.':</td><td class="results_white"><span style="color: #ff0000">'.$ipfound.'</span></td>';
				}else{
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_IPAddr.':</td><td class="results_white">'.$nomatches.'</td></tr>';
				}
			}else{
				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_IPAddr.':</td><td class="results_white">'.$queryskipped.'</td></tr>';
			}
			if(!$name==''){
				if(strpos($fspamcheck, $name.'</spammer><isspammer>true')==true){
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Username.':</td><td class="results_white"><span style="color: #ff0000">'.$usernamefound.'</span></td></tr>';
				}else{
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Username.':</td><td class="results_white">'.$nomatches.'</td></tr>';
				}
			}else{
				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Username.':</td><td class="results_white">'.$queryskipped.'</td></tr>';
			}
		}else{
			if(!$mail==''){$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Email.':</td><td class="results_white">'.$nomatches.'</td></tr>';}else{$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Email.':</td><td class="results_white">'.$queryskipped.'</td></tr>';}
			if(!$ip==''){$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_IPAddr.':</td><td class="results_white">'.$nomatches.'</td></tr>';}else{$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_IPAddr.':</td><td class="results_white">'.$queryskipped.'</td></tr>';}
			if(!$name==''){$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Username.':</td><td class="results_white">'.$nomatches.'</td></tr>';}else{$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Username.':</td><td class="results_white">'.$queryskipped.'</td></tr>';}
		}
		if($fslspambot == true){
			$spambot = true; // Required seperately now that dumping to a text file is optional
		}

	} // End if($sFSLAPI .....
	// *********************************************************************************
	// END CHECK FSPAMLIST
	// *********************************************************************************

	// *********************************************************************************
	// BEGIN CHECK STOPFORUMSPAM
	// *********************************************************************************
	//
	// Check the e-mail address against StopForumSpam
	//
	$sTD_Results = $sTD_Results . '<tr><td class="results_white" colspan="2"><b>Checking <a class="results" href="http://www.stopforumspam.com/search">StopForumSpam</a></b> ....</td></tr>';
	if($mail !='' && $bCheckSFS ==TRUE){
		$fspamcheck = getURL('http://www.stopforumspam.com/api?email='.$mail);

		if(strpos($fspamcheck, 'rate limit exceeded')==true){
			$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Email.':</td><td class="results_white">Query limit exceeded</td></tr>';
		}else{
			if($bXMLAvailable == True && strpos($fspamcheck, '<') == True){
				$sfsxml = new SimpleXMLElement($fspamcheck);
				if($sfsxml->appears == 'yes'){
					$sfsspambot = true;
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Email.':</td><td class="results_white"><span style="color: #ff0000">'.$emailfound.'</span></td>';
				}else{
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Email.':</td><td class="results_white">'.$nomatches.'</td></tr>';
				} // End if($sfsxml->appears == 'yes') (Email)
			}else{
				if (strpos($fspamcheck, 'yes') !=False) {
					$sfsspambot = true;
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Email.':</td><td class="results_white"><span style="color: #ff0000">'.$emailfound.'</span></td>';
				}else{
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Email.':</td><td class="results_white">'.$nomatches.'</td></tr>';
				} // End if($sfsxml->appears == 'yes') (Email)
			}
		} // END if(strpos($fspamcheck, 'rate limit exceeded')==true)
	}else{
		$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Email.':</td><td class="results_white">'.$queryskipped.'</td></tr>';
	} // End If

	//
	// Now check the IP
	//
	if($ip !='' && $bCheckSFS ==TRUE){
		$fspamcheck = getURL('http://www.stopforumspam.com/api?ip='.$ip);

		if(strpos($fspamcheck, 'rate limit exceeded')==true){
			$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_IPAddr.':</td><td class="results_white">Query limit exceeded</td></tr>';
		}else{
			if($bXMLAvailable == True && strpos($fspamcheck, '<') == True){
				$sfsxml = new SimpleXMLElement($fspamcheck);
				if($sfsxml->appears == 'yes'){
					$sfsspambot = true;
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_IPAddr.':</td><td class="results_white"><span style="color: #ff0000">'.$ipfound.'</span></td>';
				}else{
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_IPAddr.':</td><td class="results_white">'.$nomatches.'</td></tr>';
				} // End if($sfsxml->appears == 'yes') (IP)
			}else{
				if (strpos($fspamcheck, 'yes') !=False) {
					$sfsspambot = true;
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_IPAddr.':</td><td class="results_white"><span style="color: #ff0000">'.$ipfound.'</span></td>';
				}else{
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_IPAddr.':</td><td class="results_white">'.$nomatches.'</td></tr>';
				} // End if($sfsxml->appears == 'yes') (IP)
			}
		} // END if(strpos($fspamcheck, 'rate limit exceeded')==true)
	}else{
		$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_IPAddr.':</td><td class="results_white">'.$queryskipped.'</td></tr>';
       	} // End If

	//
	// Lets check the username
	//
	if($name !='' && $bCheckSFS ==TRUE){
		$fspamcheck = getURL('http://www.stopforumspam.com/api?username='.$name);

		if(strpos($fspamcheck, 'rate limit exceeded')==true){
			$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Username.':</td><td class="results_white">Query limit exceeded</td></tr>';
		}else{
			if($bXMLAvailable == True && strpos($fspamcheck, '<') == True){
				$sfsxml = new SimpleXMLElement($fspamcheck);
				if($sfsxml->appears == 'yes'){
               				$sfsspambot = true;
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Username.':</td><td class="results_white"><span style="color: #ff0000">'.$usernamefound.'</span></td>';
				}else{
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Username.':</td><td class="results_white">'.$nomatches.'</td></tr>';
	    			} // End if($sfsxml->appears == 'yes') (username)
			}else{
				if (strpos($fspamcheck, 'yes') !=False) {
					$sfsspambot = true;
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Username.':</td><td class="results_white"><span style="color: #ff0000">'.$usernamefound.'</span></td>';
				}else{
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Username.':</td><td class="results_white">'.$nomatches.'</td></tr>';
				} // End if($sfsxml->appears == 'yes') (IP)
			}
		} // END if(strpos($fspamcheck, 'rate limit exceeded')==true)
	}else{
		$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Username.':</td><td class="results_white">'.$queryskipped.'</td></tr>';
	} // End If

	if($sfsspambot == true){
		$spambot = true; // Required seperately now that dumping to a text file is optional
	}
	// *********************************************************************************
	// END CHECK STOPFORUMSPAM
	// *********************************************************************************

	// *********************************************************************************
	// END SUBMIT TO FSL AND SFS
	// *********************************************************************************
	// There's got to be at least an IP address .....
	if(!$ip==''){
		$sTD_Results = $sTD_Results . '<tr><th class="results_white" colspan="2"><b>Submit to: <a class="results_white" href="./?p=submit&amp;name='.$name.'&amp;ip='.$ip.'&amp;mail='.$mail.'">fSpamlist &amp; StopForumSpam</a></b></th></tr>';
	}
	// *********************************************************************************
	// END SUBMIT TO FSL AND SFS
	// *********************************************************************************

	// *********************************************************************************
	// BEGIN CHECK BOTSCOUT
	// *********************************************************************************
	//
	// Check the e-mail address against BotScout
	//
	$sTD_Results = $sTD_Results . '<tr><td class="results_white" colspan="2"><b>Checking <a class="results" href="http://www.botscout.com/">BotScout</a></b> ....</td></tr>';
	if($mail !='' && $sBSAPI !=''){
		$fspamcheck = getURL('http://botscout.com/test/?key='.$sBSAPI.'&mail='.$mail);
		if (strpos($fspamcheck, '! ') !=False) {
			$bsspambot = false;
			$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Email.':</td><td class="results_white">'.$fspamcheck.'</td>';
		}else{
			if (strpos($fspamcheck, 'Y|') !=False) {
				$bsspambot = true;
				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Email.':</td><td class="results_white"><a class="results" href="http://www.botscout.com/search.htm?sterm='.$mail.'&amp;stype=q"><span style="color: #ff0000">'.$emailfound.'</span></a></td>';
			}else{
				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Email.':</td><td class="results_white">'.$nomatches.'</td></tr>';
			} // End if($bsxml->appears == 'Y|') (Email)
		}
	}else{
		$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Email.':</td><td class="results_white">'.$queryskipped.'</td></tr>';
	} // End If

	//
	// Now check the IP
	//
	if($ip !='' && $sBSAPI !=''){
		$fspamcheck = getURL('http://botscout.com/test/?key='.$sBSAPI.'&ip='.$ip);
		if (strpos($fspamcheck, '! ') !=False) {
			$bsspambot = false;
			$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Email.':</td><td class="results_white">'.$fspamcheck.'</td>';
		}else{
			if (strpos($fspamcheck, 'Y|') !=False) {
				$bsspambot = true;
				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_IPAddr.':</td><td class="results_white"><a class="results" href="http://www.botscout.com/search.htm?sterm='.$ip.'&amp;stype=q"><span style="color: #ff0000">'.$ipfound.'</span></a></td>';
			}else{
				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_IPAddr.':</td><td class="results_white">'.$nomatches.'</td></tr>';
			} // End if($bsxml->appears == 'Y|') (IP)
		}
	}else{
		$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_IPAddr.':</td><td class="results_white">'.$queryskipped.'</td></tr>';
       	} // End If

	//
	// Lets check the username
	//
	if($name !='' && $sBSAPI !=''){
		$fspamcheck = getURL('http://botscout.com/test/?key='.$sBSAPI.'&name='.$name);
		if (strpos($fspamcheck, '! ') !=False) {
			$bsspambot = false;
			$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Email.':</td><td class="results_white">'.$fspamcheck.'</td>';
		}else{
			if (strpos($fspamcheck, 'Y|') !=False) {
				$bsspambot = true;
				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Username.':</td><td class="results_white"><a class="results" href="http://www.botscout.com/search.htm?sterm='.$name.'&amp;stype=q"><span style="color: #ff0000">'.$usernamefound.'</span></a></td>';
			}else{
				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Username.':</td><td class="results_white">'.$nomatches.'</td></tr>';
			} // End if($bsxml->appears == 'Y|') (Username)
		}
	}else{
		$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results">'.$fld_Username.':</td><td class="results_white">'.$queryskipped.'</td></tr>';
	} // End If

	if($bsspambot == true){
		$spambot = true; // Required seperately now that dumping to a text file is optional
	}
	// *********************************************************************************
	// END CHECK BOTSCOUT
	// *********************************************************************************

	$sTD_Results = $sTD_Results . '<tr><td class="results_white" colspan="2"><b>Checking DNS Blacklists</b> ....</td></tr>';
	// Check DNSBL
	if ($ip !=''){
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
					$sdroneachspambot = true;
        				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="https://dnsbl.abuse.ch/">abuse.ch (DRONE, Spam)</a>:</td><td class="results_white"><a class="results" href="http://dnsbl.abuse.ch/webabusetracker.php?ipaddress='.$ip.'" title="This IP has been identified as a drone involved in spam"><span style="color: #ff0000">'.$ipfound.'</span></a></td></tr>';
					break;
				case "127.0.0.3":
					$sdroneachspambot = true;
        				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="https://dnsbl.abuse.ch/">abuse.ch (DRONE, Malware)</a>:</td><td class="results_white"><a class="results" href="http://dnsbl.abuse.ch/webabusetracker.php?ipaddress='.$ip.'" title="This IP has been identified as a drone involved in malware"><span style="color: #ff0000">'.$ipfound.'</span></a></td></tr>';
					break;
				case "127.0.0.4":
					$sdroneachspambot = true;
        				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="https://dnsbl.abuse.ch/">abuse.ch (DRONE, Phish)</a>:</td><td class="results_white"><a class="results" href="http://dnsbl.abuse.ch/webabusetracker.php?ipaddress='.$ip.'" title="This IP has been identified as a drone involved in Phishing"><span style="color: #ff0000">'.$ipfound.'</span></a></td></tr>';
					break;
				case "127.0.0.5":
					$sdroneachspambot = true;
        				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="https://dnsbl.abuse.ch/">abuse.ch (DRONE, Scam)</a>:</td><td class="results_white"><a class="results" href="http://dnsbl.abuse.ch/webabusetracker.php?ipaddress='.$ip.'" title="This IP has been identified as a drone involved in scamming"><span style="color: #ff0000">'.$ipfound.'</span></a></td></tr>';
					break;
				default:
					$sdroneachspambot = false;
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="http://dnsbl.abuse.ch">abuse.ch (DRONE)</a>:</td><td class="results_white">'.$nomatches.'</td></tr>';
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
					$shttpblachspambot = true;
        				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="https://dnsbl.abuse.ch/">abuse.ch (HTTPBL, Hacking)</a>:</td><td class="results_white"><a class="results" href="http://dnsbl.abuse.ch/webabusetracker.php?ipaddress='.$ip.'" title="This IP has been identified as involved in malicious activities such as hacking"><span style="color: #ff0000">'.$ipfound.'</span></a></td></tr>';
					break;
				case "127.0.0.3":
					$shttpblachspambot = true;
		        		$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="https://dnsbl.abuse.ch/">abuse.ch (HTTPBL, Hijacked Server)</a>:</td><td class="results_white"><a class="results" href="http://dnsbl.abuse.ch/webabusetracker.php?ipaddress='.$ip.'" title="This IP has been identified as a hijacked server"><span style="color: #ff0000">'.$ipfound.'</span></a></td></tr>';
					break;
				case "127.0.0.4":
					$shttpblachspambot = true;
        				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="https://dnsbl.abuse.ch/">abuse.ch (HTTPBL, Referer Spam)</a>:</td><td class="results_white"><a class="results" href="http://dnsbl.abuse.ch/webabusetracker.php?ipaddress='.$ip.'" title="This IP has been identified as involved in referer spam"><span style="color: #ff0000">'.$ipfound.'</span></a></td></tr>';
					break;
				case "127.0.0.5":
					$shttpblachspambot = true;
		        		$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="https://dnsbl.abuse.ch/">abuse.ch (HTTPBL, Auto Scan Drone)</a>:</td><td class="results_white"><a class="results" href="http://dnsbl.abuse.ch/webabusetracker.php?ipaddress='.$ip.'" title="This IP has been identified as an auto scanning drone"><span style="color: #ff0000">'.$ipfound.'</span></a></td></tr>';
					break;
				default:
					$shttpblachspambot = false;
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="http://dnsbl.abuse.ch">abuse.ch (HTTPBL)</a>:</td><td class="results_white">'.$nomatches.'</td></tr>';
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
					$sspamachspambot = true;
        				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="http://dnsbl.abuse.ch">abuse.ch (Spam, honeypot)</a>:</td><td class="results_white"><span style="color: #ff0000">'.$ipfound.'</span></td></tr>';
					break;
				case "127.0.0.3":
					$sspamachspambot = true;
        				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="http://dnsbl.abuse.ch">abuse.ch (Spam, Pushdo)</a>:</td><td class="results_white"><span style="color: #ff0000">'.$ipfound.'</span></td></tr>';
					break;
				case "127.0.0.4":
					$sspamachspambot = true;
        				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="http://dnsbl.abuse.ch">abuse.ch (Spam, Ozdok)</a>:</td><td class="results_white"><span style="color: #ff0000">'.$ipfound.'</span></td></tr>';
					break;
				default:
					$sspamachspambot = false;
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="http://dnsbl.abuse.ch">abuse.ch (Spam)</a>:</td><td class="results_white">'.$nomatches.'</td></tr>';
					break;
       			} // End if ($lookup != gethostbyname($lookup))
		}

		//
		// Check the IP against zeustracker.abuse.ch
		//
		$lookup = $rev.'.ipbl.zeustracker.abuse.ch.';
		$lookup = gethostbyname($lookup);
		if ($lookup =='127.0.0.2')
		{
			$szeusachspambot = true;
        		$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="https://zeustracker.abuse.ch/">ZeusTracker</a>:</td><td class="results_white"><a class="results" href="https://zeustracker.abuse.ch/monitor.php?ipaddress='.$ip.'" title="This IP has been identified as part of the Zeus botnet "><span style="color: #ff0000">'.$ipfound.'</span></a></td></tr>';
		}else{
			$szeusachspambot = false;
			$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="https://zeustracker.abuse.ch/">ZeusTracker</a>:</td><td class="results_white">'.$nomatches.'</td></tr>';
		} // End if ($lookup != gethostbyname($lookup))

		//
		// Check the IP against projecthoneypot.org
		//
		if(!$sPHPAPI ==''){
			$lookup = $sPHPAPI.'.'.$rev.'.dnsbl.httpbl.org';

			//echo "DEBUG: ".$lookup."<br>";
			//$sLookupRes = gethostbyname($lookup);
			//echo "DEBUG: ".$sLookupRes."<br>";

			if ($lookup != gethostbyname($lookup))
			{
				$sphpspambot = true;
				$sTempArr = explode('.',gethostbyname($lookup));

				//echo "DEBUG [RESULT]: ".gethostbyname($lookup).' - '.$sTempArr[0].'<br>';

				if($sTempArr[0]=='127'){
					$sDays = $sTempArr[1];
					$sThreatScore = $sTempArr[2];
					$sVisitorType = $sTempArr[3];
					switch ($sVisitorType) {
						case "0":
							$sVisitorType = "Search Engine";
							break;
						case "1":
							$sVisitorType = "Suspicious";
							break;
						case "2":
							$sVisitorType = "Harvester";
							break;
						case "3":
							$sVisitorType = "Suspicious & Harvester";
							break;
						case "4":
							$sVisitorType = "Comment Spammer";
							break;
						case "5":
							$sVisitorType = "Suspicious & Comment Spammer";
							break;
						case "6":
							$sVisitorType = "Harvester & Comment Spammer";
							break;
						case "7":
							$sVisitorType = "Suspicious & Harvester & Comment Spammer";
							break;
					}
        				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="http://www.projecthoneypot.org/">ProjectHoneyPot</a>:</td><td class="results_white"><a class="results" href="http://www.projecthoneypot.org/ip_'.$ip.'" title="This IP\'s threat score is [ '.$sThreatScore.'/255 ]. Activity was last seen by this IP [ '.$sDays.' ] days ago. It has been identified as a [ '.$sVisitorType.' ] "><span style="color: #ff0000">'.$ipfound.'</span></a><br><br><span style="color: #000000; text-align: left">This IP\'s threat score is [ <b>'.$sThreatScore.'</b>/255 ]. Activity was last seen by this IP [ <b>'.$sDays.'</b> ] days ago. It has been identified as a [ <b>'.$sVisitorType.'</b> ]</span></td></tr>';
				}else{
					$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="http://www.projecthoneypot.org/">ProjectHoneyPot</a>:</td><td class="results_white"><span style="color: #ff0000; text-align: left">Error: Lookup failed</span></td></tr>';
				}
			}else{
				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="http://www.projecthoneypot.org/">ProjectHoneyPot</a>:</td><td class="results_white">'.$nomatches.'</td></tr>';
			} // End if ($lookup != gethostbyname($lookup))
		}else{
			$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="http://www.projecthoneypot.org/">ProjectHoneyPot</a>:</td><td class="results_white">'.$queryskipped.'</td></tr>';
		} // End If

		//
		// Check the IP against Sorbs
		//
		$lookup = $rev.'.l2.spews.dnsbl.sorbs.net';
		if ($lookup != gethostbyname($lookup))
		{
			$sorbsspambot = true;
       			$sTD_Results = $sTD_Results . '<tr><td width="100px" class="results"><a class="results" href="http://dnsbl.sorbs.net/">Sorbs</a>:</td><td class="results_white"><span style="color: #ff0000">'.$ipfound.'</span></td></tr>';
		}else{
			$sTD_Results = $sTD_Results . '<tr><td width="100px" class="results"><a class="results" href="http://dnsbl.sorbs.net/">Sorbs</a>:</td><td class="results_white">'.$nomatches.'</td></tr>';
		} // End if ($lookup != gethostbyname($lookup))

		//
		// Check the IP against Sorbs
		//
		$lookup = $rev.'.problems.dnsbl.sorbs.net';
		if ($lookup != gethostbyname($lookup))
		{
			$sorbsspambot = true;
       			$sTD_Results = $sTD_Results . '<tr><td width="100px" class="results"><a class="results" href="http://dnsbl.sorbs.net/">Sorbs (2)</a>:</td><td class="results_white"><span style="color: #ff0000">'.$ipfound.'</span></td></tr>';
		}else{
			$sTD_Results = $sTD_Results . '<tr><td width="100px" class="results"><a class="results" href="http://dnsbl.sorbs.net/">Sorbs (2)</a>:</td><td class="results_white">'.$nomatches.'</td></tr>';
		} // End if ($lookup != gethostbyname($lookup))

		//
		// Check the IP against Spamhaus
		//
		// zen.spamhaus.org checks ALL of the SH blacklists. If you only want to check the XBL/SBL, change it to
		//
		//	$lookup = $rev.'.sbl=xbl.spamhaus.org';

		$lookup = $rev.'.zen.spamhaus.org';

		// Spamhaus returns codes based on which blacklist the IP is in;
		//
		// 127.0.0.2 = SBL (Direct UBE sources, verified spam services and ROKSO spammers)
		// 127.0.0.3 = Not used
		// 127.0.0.4-8 = XBL (Illegal 3rd party exploits, including proxies, worms and trojan exploits)
		//	- 4 = CBL
		//	- 5 = NJABL Proxies (customized)
		// 127.0.0.10-11 = PBL (IP ranges which should not be delivering unauthenticated SMTP email)
		//	- 10 = ISP Maintained
		//	- 11 = Spamhaus Maintained

		if(gethostbyname($lookup) == '127.0.0.2' || gethostbyname($lookup) == '127.0.0.4' || gethostbyname($lookup) == '127.0.0.5' || gethostbyname($lookup) == '127.0.0.6' || gethostbyname($lookup) == '127.0.0.7' || gethostbyname($lookup) == '127.0.0.8' || gethostbyname($lookup) == '127.0.0.10' || gethostbyname($lookup) == '127.0.0.11')
		{
			$spamhausspambot = true;
			$spamhaustemp = gethostbyname($lookup);
			switch ($spamhaustemp) {
				case "127.0.0.2":
					$spamhaustemp = " (SBL)";
					break;
				case "127.0.0.4":
					$spamhaustemp = " (CBL)"; $spamhausspambot = false;
					break;
				case "127.0.0.5":
					$spamhaustemp = " (NJABL)";
					break;
				case "127.0.0.6":
					$spamhaustemp = " (XBL)";
					break;
				case "127.0.0.7":
					$spamhaustemp = " (XBL)";
					break;
				case "127.0.0.8":
					$spamhaustemp = " (XBL)";
					break;
				case "127.0.0.10":
					$spamhaustemp = " (PBL - ISP Maintained)"; $spamhausspambot = false;
					break;
				case "127.0.0.11":
					$spamhaustemp = " (PBL - Spamhaus Maintained)"; $spamhausspambot = false;
					break;
			}
       			$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="http://www.spamhaus.org/">Spamhaus</a>:</td><td class="results_white"><a class="results" href="http://www.spamhaus.org/query/bl?ip='.$ip.'"><span style="color: #ff0000">'.$ipfound.$spamhaustemp.'</span></a></td></tr>';
		}else{
			$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="http://www.spamhaus.org/">Spamhaus</a>:</td><td class="results_white">'.$nomatches.'</td></tr>';
		} // End if ($lookup != gethostbyname($lookup))

		//
		// Check the IP against SpamCop
		//
		$lookup = $rev.'.bl.spamcop.net';
		if (gethostbyname($lookup) == '127.0.0.2')
		{
			$scopspambot = true;
        		$sTD_Results = $sTD_Results . '<tr><td width="100px" class="results"><a class="results" href="http://www.spamcop.net/">SpamCop</a>:</td><td class="results_white"><span style="color: #ff0000">'.$ipfound.'</span></td></tr>';
		}else{
			$sTD_Results = $sTD_Results . '<tr><td width="100px" class="results"><a class="results" href="http://www.spamcop.net/">SpamCop</a>:</td><td class="results_white">'.$nomatches.'</td></tr>';
		} // End if ($lookup != gethostbyname($lookup))

		//
		// Check the IP against DroneBL
		//
		$lookup = $rev.'.dnsbl.dronebl.org';
		if ($lookup != gethostbyname($lookup))
		{
			$sdronespambot = true;
       			$sTD_Results = $sTD_Results . '<tr><td width="100px" class="results"><a class="results" href="http://dronebl.org/">DroneBL</a>:</td><td class="results_white"><a class="results" href="http://www.dronebl.org/lookup?ip='.$ip.'"><span style="color: #ff0000">'.$ipfound.'</span></a></td></tr>';
		}else{
			$sTD_Results = $sTD_Results . '<tr><td width="100px" class="results"><a class="results" href="http://dronebl.org/">DroneBL</a>:</td><td class="results_white">'.$nomatches.'</td></tr>';
		} // End if ($lookup != gethostbyname($lookup))

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
		$lookup = $rev.'.dnsbl.ahbl.org';
		$sah = gethostbyname($lookup); $sah = explode('.', $sah); $sah = $sah[3];
		if($sah = 127 || ($sah > 2 && $sah < 20))
		{
			$ahbltemp = gethostbyname($lookup);
			switch ($ahbltemp) {
				case "127.0.0.2":
					$sahbltemp = "Open Relay"; $ahblspambot = true; break;
				case "127.0.0.3":
					$sahbltemp = "Open Proxy"; $ahblspambot = true; break;
				case "127.0.0.4":
					$sahbltemp = "Spam Source"; $ahblspambot = true; break;
				case "127.0.0.5":
					$sahbltemp = "Provisional Spam Source Listing block (will be removed if spam stops)"; $ahblspambot = true; break;
				case "127.0.0.6":
					$sahbltemp = "Formmail Spam"; $ahblspambot = true; break;
				case "127.0.0.7":
					$sahbltemp = "Spam Supporter"; $ahblspambot = true; break;
				case "127.0.0.8":
					$sahbltemp = "Spam Supporter (indirect)"; $ahblspambot = true; break;
				case "127.0.0.9":
					$sahbltemp = "End User (non mail system)"; $ahblspambot = false; break;
				case "127.0.0.10":
					$sahbltemp = "Shoot On Sight"; $ahblspambot = true; break;
				case "127.0.0.11":
					$sahbltemp = "Non-RFC Compliant (missing postmaster or abuse)"; $ahblspambot = false; break;
				case "127.0.0.12":
					$sahbltemp = "Does not properly handle 5xx errors"; $ahblspambot = false; break;
				case "127.0.0.13":
					$sahbltemp = "Other Non-RFC Compliant"; $ahblspambot = false; break;
				case "127.0.0.14":
					$sahbltemp = "Compromised System - DDoS"; $ahblspambot = true; break;
				case "127.0.0.15":
					$sahbltemp = "Compromised System - Relay"; $ahblspambot = true; break;
				case "127.0.0.16":
					$sahbltemp = "Compromised System - Autorooter/Scanner"; $ahblspambot = true; break;
				case "127.0.0.17":
					$sahbltemp = "Compromised System - Worm or mass mailing virus"; $ahblspambot = true; break;
				case "127.0.0.18":
					$sahbltemp = "Compromised System - Other virus"; $ahblspambot = true; break;
				case "127.0.0.19":
					$sahbltemp = "Open Proxy"; $ahblspambot = true; break;
				case "127.0.0.20":
					$sahbltemp = "Blog/Wiki/Comment Spammer"; $ahblspambot = true; break;
				case "127.0.0.127":
					$sahbltemp = "Other"; $ahblspambot = true; break;
				default:
					$ahblspambot = false; break;
			}
			if($ahblspambot ==true){
	       			$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="http://www.ahbl.org/">AHBL</a>:</td><td class="results_white"><span style="color: #ff0000">'.$ipfound.' ( '.$ahbltemp.' )</span></td></tr>';
			}else{
				$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="http://www.ahbl.org/">AHBL</a>:</td><td class="results_white">'.$nomatches.'</td></tr>';
			}
		}else{
			$sTD_Results = $sTD_Results . '<tr><td align="left" width="200px" class="results"><a class="results" href="http://www.ahbl.org/">AHBL</a>:</td><td class="results_white">'.$nomatches.'</td></tr>';
		} // End if ($lookup != gethostbyname($lookup))

		//
		// Check the IP against dnsbl.tornevall.org
		//
		$lookup = $rev.'.opm.tornevall.org';
		if ($lookup != gethostbyname($lookup))
		{
			$stvospambot = true;
       			$sTD_Results = $sTD_Results . '<tr><td width="100px" class="results"><a class="results" href="http://dnsbl.tornevall.org/">Tornevall</a>:</td><td class="results_white"><span style="color: #ff0000">'.$ipfound.'</span></td></tr>';
		}else{
			$sTD_Results = $sTD_Results . '<tr><td width="100px" class="results"><a class="results" href="http://dnsbl.tornevall.org/">Tornevall</a>:</td><td class="results_white">'.$nomatches.'</td></tr>';
		} // End if ($lookup != gethostbyname($lookup))

		//
		// Check the IP against efnetrbl.org
		//
		$lookup = $rev.'.rbl.efnetrbl.org';
		if ($lookup != gethostbyname($lookup))
		{
			$sefnetspambot = true;
       			$sTD_Results = $sTD_Results . '<tr><td width="100px" class="results"><a class="results" href="http://efnetrbl.org/">EFNet</a>:</td><td class="results_white"><span style="color: #ff0000">'.$ipfound.'</span></td></tr>';
		}else{
			$sTD_Results = $sTD_Results . '<tr><td width="100px" class="results"><a class="results" href="http://efnetrbl.org/">EFNet</a>:</td><td class="results_white">'.$nomatches.'</td></tr>';
		} // End if ($lookup != gethostbyname($lookup))

		//
		// Check the IP against .80.104.161.233.64.ip-port.exitlist.torproject.org
		//
		//	Special thanks (albeit a little late - my fault for forgetting the first time ;o)) to Zaphod (spambotsecurity.com)
		//	for the URI for this one ...
		//
		$lookup = gethostbyname($rev.'.80.104.161.233.64.ip-port.exitlist.torproject.org');
		if ($lookup == "127.0.0.2")
		{
			$sTorspambot = true;
       			$sTD_Results = $sTD_Results . '<tr><td width="100px" class="results"><a class="results" href="http://torproject.org/">Tor</a>:</td><td class="results_white"><span style="color: #ff0000">'.$ipfound.'</span></td></tr>';
		}else{
			$sTD_Results = $sTD_Results . '<tr><td width="100px" class="results"><a class="results" href="http://torproject.org/">Tor</a>:</td><td class="results_white">'.$nomatches.'</td></tr>';
		} // End if ($sTemp == "127.0.0.2")

		// ****************************************************************************
		// If any of our DNSBL's are true, change $spambot to true if it's not already
		// ****************************************************************************
		if($sTorspambot == true || $sefnetspambot == true || $sstraptvospambot == true || $stvospambot == true || $sphpspambot ==true || $sorbsspambot ==true || $spamhausspambot ==true || $scopspambot==true || $sdronespambot ==true || $ahblspambot == true || $shttpblachspambot || $sdroneachspambot || $sspamachspambot || $szeusachspambot){
			$spambot = true; // Required seperately now that dumping to a text file is optional
		}
	}else{
		$sTD_Results = $sTD_Results . '<tr><td class="results_white" colspan="2">'.$dnsblskipped.'</td></tr>';
	} // End if ($ip !='')
	// End Check DNSBL

	// Close table
	$sTD_Results = $sTD_Results . "</table><br><br>";


	// *********************************************************************************
	// Create a .txt file or log to the database, with the info of the spambot, if this
	// one already exists, increase its amount of try's
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

		if($ahblspambot == true){
			$spambot = true;
			if($bln_SaveToFile == true){$lRet = LogSpammerToFile($savetofolder, 'AHBL',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'AHBL', $name, $ip, $mail);}
		} // End AHBL (Abusive Hosts Black List)

		if($bsspambot == true){
			$spambot = true;
			if($bln_SaveToFile == true){$lRet = LogSpammerToFile($savetofolder, 'BotScout',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'BotScout', $name, $ip, $mail);}
		} // End BotScout

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
		if($sdroneachspambot == true){
			$spambot = true;
			if($bln_SaveToFile ==true){$lRet = LogSpammerToFile($savetofolder, 'Abuse.ch (Drone)',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'Abuse.ch (Drone)', $name, $ip, $mail);}
		} // End Drone
		if($shttpblachspambot == true){
			$spambot = true;
			if($bln_SaveToFile ==true){$lRet = LogSpammerToFile($savetofolder, 'Abuse.ch (HTTPBL)',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'Abuse.ch (HTTPBL)', $name, $ip, $mail);}
		} // End HTTPBL
		if($sspamachspambot == true){
			$spambot = true;
			if($bln_SaveToFile ==true){$lRet = LogSpammerToFile($savetofolder, 'Abuse.ch (SPAM)',$name, $ip, $mail);}
			if($bln_SaveToDB == true){$lRet = LogSpammerToDB($dbShost, $dbSname, $dbSusername, $dbSpassword, 'Abuse.ch (SPAM)', $name, $ip, $mail);}
		} // End Spam
		if($szeusachspambot == true){
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

	$sresult_data = $spambot.'[DATA_FOLLOWS]'.$sTD_Results;
	return $sresult_data;

} // End function checkSpambots

if(isset($_GET['email']) && !$_GET['email'] =='' || isset($_GET['ip']) && $_GET['ip'] !='' || isset($_GET['name']) && $_GET['name'] !=''){

	// Has an e-mail been passed? If so, check it's valid
	$sMail = $_GET['email'];
	if(!$sMail==''){
		if(IsValidEmail($sMail)==false){
			$sMail = ''; // Can't use it if it's not valid
		}
	}

	// Has an IP been passed? If so, check it's valid
	$sIP = $_GET['ip'];
	if($sIP !=''){
		if(IsvalidIP($sIP)==false){
			$sIP = ''; // Can't use it if it's not valid
		}
	}

	// Sadly, usernames can usually contain absolutely any characters, not just letters
	// and numbers, so gonna be difficult to filter it
	$sName = $_GET['name']; $sName = addslashes(htmlentities($sName)); $sName = urlencode($sName);

	$sCSpambot = false; $arrSCSpambot=false; $sResults=false;

	// ************************
	// Check Whitelist
	// ************************
	if(file_exists('whitelist.txt')){
		$sWhitelist = @file_get_contents('whitelist.txt');
		if(!strlen($sWhitelist)==0){

			$sTName = $sName; $sTMail = $sMail; $sTIP = $sIP;

			if(strlen($sTName)==0){$sTName="NULL";}
			if(strlen($sTMail)==0){$sTMail="nobody@example.com";}
			if(strlen($sTIP)==0){$sTIP="0.0.0.0";}

			if(substr_count($sWhitelist, $sTName) > 0 || substr_count($sWhitelist, $sTMail) > 0 || substr_count($sWhitelist, $sTIP) > 0){
				$sCSpambot = true;
			}else{
				$sCSpambot=false;
			}

		}else{
			$sCSpambot=false;
		}
	}

	if($sCSpambot==false){
		// ********************************************
		// Okay, lets process the details shall we?
		// ********************************************
		$arrSCSpambot = checkSpambots($sMail,$sIP,$sName); $arrSCSpambot = explode('[DATA_FOLLOWS]',$arrSCSpambot);
		$sCSpambot = $arrSCSpambot[0];
		$sResults = $arrSCSpambot[1];
	}

	// ********************************************
	// Check and return the results
	// ********************************************
	if($sCSpambot == true){

		// ************************
		// Increase our catch count
		// ************************
		$lDummy = IncreaseCatchCount(); // Function in functions.php that is used to increase the counter

		// ************************
		// Notify the user
		// ************************
		echo '<tr><td class="results_white" colspan="2"><span class="spammer">'.$Spammer_found.'</span></td></tr>'.$sResults;
	}else{
		// ************************
		// Notify the user
		// ************************
		echo '<tr><td class="results_white" colspan="2"><span class="notspammer">'.$Spammer_notfound.'</span></td></tr>'.$sResults;
	}
}
?>