<?php
// **************************************************************
// File: en.php
// Purpose: Contains messages used within the SBST
// Author: MysteryFCM
// Support: http://mysteryfcm.co.uk/?mode=Contact
//	    http://forum.hosts-file.net/viewforum.php?f=68
//	    http://www.temerc.com/forums/viewforum.php?f=71
// Last modified: 22-02-2011
// **************************************************************

// Title
$page_title='SpamBot Search Tool';
$Version_Info='v0.52';

// Messages
$main='Enter the e-mail, username or IP you\'d like to check';
$view_main='The following are the spammers I\'ve logged for you';
$Spammer_found='Spammer identified!';
$Spammer_notfound='Nope, it\'s not a spammer';
$nomatches=' No matches found ....';
$ipfound='IP found!';
$emailfound='E-mail found!';
$usernamefound='Username found!';
$dnsblskipped='DNS Blacklist query skipped, IP not specified';
$queryskipped='Query skipped';
$noemailsfound='Thar be nothing in here ....';
$sViewRecordsFrom='View records from: ';

// Links (menu)
$linkhome='Home';
$linkview='View Spammers';
$linkviewmail='View E-mail Reports';
$linkhelp='Need Help?';
$linkViewhpHosts='View spammers IP information on hpHosts';
$linkdb='Database';
$linktext='Text files';

// Field names (used in view_spammers_mail.php, view_spammers_plain.php, check_spammers.php and index.php)
$fld_Date='Date';
$fld_Username='Username';
$fld_Email='E-mail';
$fld_IPAddr='IP';
$fld_BlockedBy='Blocked By';
$fld_Count='Count';

// Errors
$phpver_error='Incompatable PHP version: '.phpversion().'<br /><br />PHP Version 5 or above is required for this site to work';
$NoXMLAvailable='The SimpleXMLElement class is not available, I can\'t continue ...';
$nofilegetcontents='The file_get_contents function is not available, I can\'t continue ...';
$nocurlorfgc='It appears neither the file_get_contents function or cURL are available, I can\'t continue. I need at least one of these for me to work ...';
$folderdoesnotexist=' does not exist';
$ipnotspecified='IP not specified';
$usernamenotspecified='Username not specified';
$nointernetconnection='You don\'t seem to be connected to the internet. Unless you\'re querying a local database, this isn\'t going to work ...';
$sPHPAPIMissing='You need to enter your <a class="menu" href="http://projecthoneypot.org">Project Honey Pot API Key</a> key before I can query their database (see config.php)';
$sFSLAPIMissing='You need to enter your <a class="menu" href="http://fspamlist.com">fSpamList API Key</a> key before I query their database (see config.php)';
$sFSLAPIError='fSpamlist API Key missing';
$sBSAPIMissing='You need to enter your <a class="menu" href="http://botscout.com">BotScout API Key</a> key before I can query their database (see config.php)';
$nofileputcontents='You\'ve asked me to dump the results to text file, but file_put_contents is not available. Please enable it or disable dumping to a text file';
$nogetheaders='The get_headers() function is required to determine if one of the sites I use is online, but it doesn\'t seem to be available? I can still continue, but I\'d recommend enabling this function to increase accuracy and reduce the possibility of errors.';
$noIMAP='IMAP not available, please install/enable it';
$noMailServer='No mail server is configured';
$noConnection='Can\'t connect:';
$noEmailsFound='No emails found matching my filter';
$noSaveToFile='You\'ve not asked me to save anything';
$NoRecordsFound='No records to display';

?>