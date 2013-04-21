<?php
// **************************************************************
// File: view_spammers.php
// Purpose: Displays spammers saved to text file or DB
// Author: MysteryFCM
// Support: http://mysteryfcm.co.uk/?mode=Contact
//	    http://forum.hosts-file.net/viewforum.php?f=68
//	    http://www.temerc.com/forums/viewforum.php?f=71
// Last modified: 18-11-2009
// **************************************************************

//$sMyPath = dirname(__FILE__).'/';
//include($sMyPath."functions.php");

?>
<table class="results" align="center" width="70%" cellpadding="5" cellspacing="0">
<tr>
	<td class="results_white" align="left" colspan="6" style="font-weight: bold">
		<?php
			echo $sViewRecordsFrom;
			echo '<a class="menu" href="./?p=view&type=0">'.$linkdb.'</a> | <a class="menu" href="./?p=view&type=1">'.$linktext.'</a>';

			if(isset($_GET['type'])){
				$lTypeTemp=$_GET['type'];
				switch($lTypeTemp){
					case "1":
						$_SESSION['type']="TEXT"; break;
					default:
						$_SESSION['type']=""; break;
				}
			}
		?>
	</td>
</tr>
<tr>
	<th class="results" align="left"><?php echo $fld_Date ?></th>
	<th class="results" align="left"><?php echo $fld_Username ?></th>
	<th class="results" align="left"><?php echo $fld_Email ?></th>
	<th class="results" align="left"><?php echo $fld_IPAddr ?></th>
	<th class="results" align="left"><?php echo $fld_Count ?></th>
	<th class="results" align="left"><?php echo $fld_BlockedBy ?></th>
</tr>
<?php
	// Are we saving to text files, or database?
	if($bln_SaveToDB==True && $_SESSION['type']!="TEXT"){
		$conView = mysql_connect($dbShost, $dbSusername, $dbSpassword);
		if(!$conView){
			echo '<tr><td class="results_white" align="center" colspan="6">'.mysql_error().'</td></tr>';
		}else{
			$rView = mysql_select_db($dbSname);
			// Try first to ensure it exists, if not, try and create it
			if($rView =="0"){
				mysql_close($conView);
				$rRet = CreateDatabase($dbShost, $dbSusername, $dbSpassword, $dbSname);
				// Did it fail?
				$conView = mysql_connect($dbShost, $dbSusername, $dbSpassword);
				$rRet = mysql_select_db($dbSname);
				if($rRet=="0"){
					die('<tr><td class="results_white" align="center" colspan="6">Error: '.mysql_error().'</td></tr>');
				}
			}
			// Last try, if it still doesn't exist, notify the user of the problem
			$rView = mysql_select_db($dbSname);
			if($rView == "0"){
				echo '<tr><td class="results_white" align="center" colspan="6">Error: '.mysql_error().'</td></tr>';
			}else{
				$sSQL = "Select fldspammer_name, fldspammer_ip, fldspammer_mail, flddb_matched, fldspammer_count, fldadded, fldspammer_id FROM tblspammers ORDER BY fldspammer_id DESC";
				$sQuery = mysql_query($sSQL, $conView);
				if(!$sQuery){
					echo '<tr><td class="results_white" align="center" colspan="6">Error: '.mysql_error().'</td></tr>';
				}else{

					$num = mysql_num_rows($sQuery); $lTotalNum = $num;

					// Pagination
					$lPageNo = $_GET['pg'];
					if(!isset($lPageNo)){
						$lPageNo = 1;
					}else{
						$lPageNo = (int)$lPageNo;
					}
					if(!is_numeric($lPageNo)){
						$lPageNo = 1;
					}

					$srows = 100;
					$slast = ceil($num/$srows);
					if ($lPageNo < 1) 
					{
						$lPageNo = 1;
					}
						elseif ($lPageNo > $slast)
					{
						$lPageNo = $slast;
					}
					// End Pagination
					//$sLimit = "(".$lPageNo-1.")*".$srows.", ".$srows";
					$sSQL = "Select fldspammer_name, fldspammer_ip, fldspammer_mail, flddb_matched, fldspammer_count, fldadded, fldspammer_id FROM tblspammers ";
					if($num>100){$sSQL .= "ORDER BY fldspammer_id DESC LIMIT ".($lPageNo-1)*$srows.", ".$srows;}else{$sSQL .="ORDER BY fldspammer_id";}
					$sQuery = mysql_query($sSQL, $conView);
					if(!$sQuery){
						echo '<tr><td class="results_white" align="center" colspan="6">Error: '.mysql_error().'</td></tr>';
					}else{

						$num = mysql_num_rows($sQuery);
						$i=0;
						if($num == 0){
							echo '<tr><td class="results_white" align="center" colspan="6">'.$NoRecordsFound.'</td></tr>';
						}else{
							while ($row = mysql_fetch_array($sQuery)) {
								$i++;
								$lCount = $row['fldspammer_count'];
								$spammer=$row['fldspammer_name'];
								$spammerip=$row['fldspammer_ip'];
								$spammermail=$row['fldspammer_mail'];
								$spamDB=$row['flddb_matched'];
								$Added=$row['fldadded'];

								// Lets determine who blocked what
								switch (strtolower($spamDB)){
									case "fspamlist":
										$spamDB = '<a class="menu" href="http://fspamlist.com">fSpamList</a>';
										break;
									case "stopforumspam":
										$spamDB = '<a class="menu" href="http://stopforumspam.com">StopForumSpam</a>';
										break;
									case "projecthoneypot":
										$spamDB = '<a class="menu" href="http://www.projecthoneypot.org">ProjectHoneyPot</a>';
										break;
									case "sorbs":
										$spamDB = '<a class="menu" href="http://dnsbl.sorbs.net">Sorbs</a>';
										break;
									case "spamhaus":
										$spamDB = '<a class="menu" href="http://spamhaus.org">Spamhaus</a>';
										break;
									case "spamcop":
										$spamDB = '<a class="menu" href="http://spamcop.net">SpamCop</a>';
										break;
									case "botscout":
										$spamDB = '<a class="menu" href="http://botscout.com">BotScout</a>';
										break;
									case "dronebl":
										$spamDB = '<a class="menu" href="http://dronebl.org">DroneBL</a>';
										break;
									case "ahbl":
										$spamDB = '<a class="menu" href="http://ahbl.org">AHBL</a>';
										break;
									case "undisposable.net":
										$spamDB = '<a class="menu" href="http://undisposable.net">Undisposable.net</a>';
										break;
									case "tornevall":
										$spamDB = '<a class="menu" href="http://dnsbl.tornevall.org">Tornevall.org</a>';
										break;
									case "efnet":
										$spamDB = '<a class="menu" href="http://efnetrbl.org">EFNet</a>';
										break;
									case "tor":
										$spamDB = '<a class="menu" href="http://torproject.org">Tor</a>';
										break;
								}

								// Wrap long usernames
								if(strlen($spammer)>30){$spammer=wordwrap($spammer, 30, "<br>\n", true);}

								echo '<tr><td class="results_white" align="left">'.$Added.'</td>';
								echo '<td class="results_white" align="left" wrap>'.$spammer.'</td>';
								echo '<td class="results_white" align="left">'.$spammermail.'</td>';
								if($spammerip == '' || $spammerip == 'NULL'){
									$spammerip = 'NULL'.'</td>';
								}else{
									$spammerip ='<a class="menu" title="'.$linkViewhpHosts.'" href="http://hosts-file.net/?s='.$spammerip.'">'.$spammerip.'</a>';
								}
								echo '<td class="results_white" align="left">'.$spammerip.'</td>';
								echo '<td class="results_white" align="left">'.$lCount.'</td>';
								echo '<td class="results_white" align="left">'.$spamDB.'</td></tr>';
							}

						} // END if($num == 0){

						if($num>100){
							// Display previous/next links
							if($lPageNo==1)
							{
								//$sNextPage=$lPageNo+1;
								//$sPageLinks .= ' <a class="menu" href="?p=view&pg='.$sNextPage.'">&gt;&gt; '.$sNextPage.'</a> ';
							}
							else
							{
								$sPageLinks .= '<a class="menu" href="./?p=view&pg=1">1 &lt;&lt;&lt;</a> | ';
								$sPrevPage=$lPageNo-1;
								$sPageLinks .= ' <a class="menu" href="./?p=view&pg='.$sPrevPage.'">&lt;&lt; '.$sPrevPage.'</a> ';
							}
							$sPageLinks .= ' ( Page '.$lPageNo.' of '.$slast.' ) ';
							if($lPageNo==$slast)
							{
								$sPageLinks .= ' NEXT | LAST ';
							}
							elseif($lPageNo==1){
								$sNextPage=$lPageNo+1;
								$sPageLinks .= ' <a class="menu" href="./?p=view&pg='.$sNextPage.'">&gt;&gt; '.$sNextPage.'</a>';
							}else{
								$sNextPage = $lPageNo+1;
								$sPageLinks .= ' <a class="menu" href="./?p=view&pg='.$sNextPage.'">&gt;&gt; '.$sNextPage.'</a> | ';
								$sPageLinks .= ' <a class="menu" href="./?p=view&pg='.$slast.'">&gt;&gt&gt; '.$slast.'</a>';
							}
						}else{
							$sPageLinks='1';
						}
						echo '<tr><td class="results_white" align="center" colspan="6">Records: '.$lTotalNum.' - '.$sPageLinks.'</td></tr>';

					} // END if(!$sQuery) - Secondary (display)

				} // END if(!$sQuery) - PRIMARY (calculate)

			} // END if($rView == "0"){

		} // END if(!$conView){
		mysql_close($conView);
	}else{
		// Lets first check the directory exists, otherwise this isn't going to work too well ....
		if(file_exists($savetofolder) && $bln_SaveToFile == TRUE && ini_get('allow_url_fopen') == true){
			$spambots = scandir($savetofolder); $arriCount = 0;
			foreach($spambots as $value){
				if($value != '.' && $value != '..'){
					$spambot_info = file_get_contents($savetofolder.$value);
					$spambot_array = explode(',',$spambot_info);
					$mail = substr($value, 0, -4);

					// Lets determine who blocked what
					if(strpos($mail, 'fsl_') !==False){
						$blockedby = '<a class="menu" href="http://fspamlist.com">fSpamList</a>';
					}
					if(strpos($mail, 'sfs_') !==False){
						$blockedby = '<a class="menu" href="http://stopforumspam.com">StopForumSpam</a>';
					}
					if(strpos($mail, 'php_') !==False){
						$blockedby = '<a class="menu" href="http://www.projecthoneypot.org">ProjectHoneyPot</a>';
					}
					if(strpos($mail, 'sorbs_') !==False){
						$blockedby = '<a class="menu" href="http://dnsbl.sorbs.net">Sorbs</a>';
					}
					if(strpos($mail, 'spamhaus_') !==False){
						$blockedby = '<a class="menu" href="http://spamhaus.org">Spamhaus</a>';
					}
					if(strpos($mail, 'scop_') !==False){
						$blockedby = '<a class="menu" href="http://spamcop.net">SpamCop</a>';
					}
					if(strpos($mail, 'bs_') !==False){
						$blockedby = '<a class="menu" href="http://botscout.com">BotScout</a>';
					}
					if(strpos($mail, 'drone_') !==False){
						$blockedby = '<a class="menu" href="http://dronebl.org">DroneBL</a>';
					}
					if(strpos($mail, 'ahbl_') !==False){
						$blockedby = '<a class="menu" href="http://ahbl.org">AHBL</a>';
					}
					if(strpos($mail, 'und_') !==False){
						$blockedby = '<a class="menu" href="http://undisposable.net">Undisposable</a>';
					}
					if(strpos($mail, 'tornevall_') !==False){
						$blockedby = '<a class="menu" href="http://dnsbl.tornevall.org">Tornevall</a>';
					}
					if(strpos($mail, 'efnet_') !==False){
						$blockedby = '<a class="menu" href="http://efnetrbl.org">EFNet</a>';
					}
					if(strpos($mail, 'tor_') !==False){
						$blockedby = '<a class="menu" href="http://torproject.org">Tor</a>';
					}

					// We first need to remove the database prefixes from the files
					//
					//	ahbl_		= AHBL
					//	bs_		= BotScout
					//	fsl_		= fSpamlist
					//	sfs_		= StopForumSpam
					//	php_		= ProjectHoneyPot
					//	sorbs_		= Sorbs
					//	spamhaus_	= SpamHaus
					//	scop_		= SpamCop
					//	drone_		= DroneBL
					//	und_		= Undisposable.net
					//	tornevall_	= Tornevall.org
					//	efnet_		= EFNet RBL
					//	tor_		= Tor RBL

					$spammername = $spambot_array[1];
					if($spammername == ''){
						$spammername='Unspecified';
					}

					$spammermail = str_replace('bs_', '', $mail);
					$spammermail = str_replace('fsl_', '', $spammermail);
					$spammermail = str_replace('sfs_', '', $spammermail);
					$spammermail = str_replace('php_', '', $spammermail);
					$spammermail = str_replace('sorbs_', '', $spammermail);
					$spammermail = str_replace('spamhaus_', '', $spammermail);
					$spammermail = str_replace('scop_', '', $spammermail);
					$spammermail = str_replace('drone_', '', $spammermail);
					$spammermail = str_replace('und_', '', $spammermail);
					$spammermail = str_replace('tornevall_', '', $spammermail);
					$spammermail = str_replace('efnet_', '', $spammermail);
					$spammermail = str_replace('ahbl_', '', $spammermail);
					$spammermail = str_replace('tor_', '', $spammermail);
					if(strpos($spammermail, '@') ==False){
						$spammermail = 'Unspecified';
					}
					$spambot_ip = $spambot_array[0];
					if($spambot_ip == ''){
						$spambot_ip = 'NULL';
					}else{
						$spambot_ip ='<a class="menu" title="'.$linkViewhpHosts.'" href="http://hosts-file.net/?s='.$spambot_ip.'">'.$spambot_ip.'</a>';
					}
					$filedate = date("d-m-y", filemtime($savetofolder.$value));

					echo '<tr><td class="results_white" align="left">'.$filedate.'</td>';
					echo '<td class="results_white" align="left">'.$spammername.'</td>';
					echo '<td class="results_white" align="left">'.$spammermail.'</td>';
					echo '<td class="results_white" align="left">'.$spambot_ip.'</td>';
					echo '<td class="results_white" align="left">'.$spambot_array[2].'</td>';
					echo '<td class="results_white" align="left">'.$blockedby.'</td></tr>';

					$arriCount = $arriCount + 1;

				} // END if($value != '.' && $value != '..'){
			}

			if($arriCount == 0){
				echo '<tr><td class="results_white" align="center" colspan="6">'.$NoRecordsFound.'</td></tr>';
			}

		}else{
			if($bln_SaveToFile == FALSE){
				echo '<tr><td class="results_white" align="center" colspan="6">'.$noSaveToFile.'</td></tr>';
			}else{
				echo '<tr><td class="results_white" align="center" colspan="6">'.$folderdoesnotexist.'</td></tr>';
			}

		} // END if(file_exists($savetofolder) && $bln_SaveToFile == TRUE)

	} // END if($bln_SaveToDB==True)
?>
</table><br><br>