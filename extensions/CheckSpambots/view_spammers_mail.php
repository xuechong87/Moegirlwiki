<?php
// **************************************************************
// File: view_spammers_mail.php
// Purpose: Displays e-mail reports sent by the SBST mods
// Author: MysteryFCM
// Support: http://mysteryfcm.co.uk/?mode=Contact
//	    http://forum.hosts-file.net/viewforum.php?f=68
//	    http://www.temerc.com/forums/viewforum.php?f=71
// Last modified: 18-11-2009
// **************************************************************

//$sMyPath = dirname(__FILE__).'/';
//include($sMyPath."functions.php");

?>
<table class="results" align="center" cellpadding="5" cellspacing="0">
<tr>
	<th class="results" align="left"><?php echo $fld_Date ?></th>
	<th class="results" align="left"><?php echo $fld_Username ?></th>
	<th class="results" align="left"><?php echo $fld_Email ?></th>
	<th class="results" align="left"><?php echo $fld_IPAddr ?></th>
	<th class="results" align="left"><?php echo $fld_BlockedBy ?></th>
</tr>
<?php
	if($sMailServer =='' || $sMail =='' || function_exists('imap_open') == false){
		if(function_exists('imap_open') == false){
			echo '<tr><td class="results_white" colspan="5">'.$noIMAP.'</td></tr>';
		}else{
			echo '<tr><td class="results_white" colspan="5">'.$noMailServer.'</td></tr>';
		}
	}else{
		$mbox = imap_open($sMailServer,$sMail,$sMailPW) or die('<tr><td class="results_white" colspan="5">' . $noConnection . ' ' . imap_last_error() . '</td></tr>');
		$mc = imap_check($mbox);
		$result = imap_fetch_overview($mbox,"1:{$mc->Nmsgs}",0); $result = array_reverse($result);
		$l_msgcnt = $mc->Nmsgs; // Total number of emails (including those we don't want)
		$m_count = 0; // Count how many emails we have (only counts those matching our reports)
		$l_maxmsg = 50; // Maximum number of e-mails to show per page

		// Pagination
		$pg = $_GET['pg']; if($pg==''){$pg='1';}

		// Only process if theres e-mails present ....
		if($l_msgcnt !=0){
			foreach ($result as $overview) {
				if($m_count==$l_maxmsg){break;}
				// Get e-mail body
				$msgbody = imap_fetchbody($mbox,$overview->msgno,1);
				// Filter the e-mails, incase the e-mail account is used for something else
				if(strpos(strtolower($msgbody), 'username:') == True){
					if(strpos($msgbody, '<br>')==True){
						$spambot_array = explode('<br>',$msgbody);
					}else{
						$spambot_array = explode('\n\r', $msgbody);
					}
					$sDate = $overview->date;
					$sBlockedBy = str_replace(' & ','<br>', $spambot_array[0]);
					$sBlockedBy = str_replace('The following was blocked by the ','',$sBlockedBy);
					$sBlockedBy = str_replace(' filter','',$sBlockedBy);
					// Allow for those blocked by ProjectHoneyPot
					$sBlockedBy = str_replace('<br>-<br>',' - ',$sBlockedBy);
					$sBlockedBy = str_replace('<br>&amp;<br>',' &amp; ',$sBlockedBy);
					$sBlockedBy = str_replace('Comment<br>Spammer','Comment Spammer',$sBlockedBy);
					$sSpammerName = str_replace('Username: ', '', $spambot_array[2]);
					$sSpammerMail = str_replace('Email: ', '', $spambot_array[4]);
					$sSpammerIP = str_replace('IP: ', '', $spambot_array[6]);
					if($sSpammerIP == '' || $sSpammerIP == 'NULL'){
						$sSpammerIP = 'NULL'.'</td>';
					}else{
						$sSpammerIP ='<a class="menu" title="'.$linkViewhpHosts.'" href="http://hosts-file.net/?s='.$sSpammerIP.'">'.$sSpammerIP.'</a>';
					}
					echo '<tr><td class="results_white" align="left" nowrap>'.$sDate.'</td>';
					echo '<td class="results_white" align="left">'.$sSpammerName.'</td>';
					echo '<td class="results_white" align="left">'.$sSpammerMail.'</td>';
					echo '<td class="results_white" align="left">'.$sSpammerIP.'</td>';
					echo '<td class="results_white" align="left" nowrap>'.$sBlockedBy.'</td></tr>';
					// Increase a counter
					$m_count = $m_count + 1;
				} // End If(strpos ...
			} // end foreach
		} // End if($l_msgcnt !=0)
		imap_close($mbox);

		if($m_count==0){
			echo '<tr><td class="results_white" colspan="5">'.$noEmailsFound.' ['.$l_msgcnt.']</td></tr>';
		}else{
			echo '<tr><td class="results_white" colspan="5">'.$m_count.' Emails found</td></tr>';
		}
	}
?>
</table><br><br>