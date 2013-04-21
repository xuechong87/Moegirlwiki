<?php
// **************************************************************
// File: check_spammers.php
// Purpose: Main web interface for the SBST
// Author: MysteryFCM
// Support: http://mysteryfcm.co.uk/?mode=Contact
//	    http://forum.hosts-file.net/viewforum.php?f=68
//	    http://www.temerc.com/forums/viewforum.php?f=71
// Last modified: 02-04-2010
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
	include($sMyPath."en.php");
	include($sMyPath."functions.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $page_title.' '.$Version_Info; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta http-equiv="Content-Language" content="en-gb">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="imagetoolbar" content="no">
<meta name="resource-type" content="document">
<meta name="distribution" content="global">
<meta name="copyright" content="<?php echo $CopyrightYear; ?> Steven Burn (aka MysteryFCM)">
<style type="text/css">
<!--
html, body		{margin: 10px 10px 10px 10px;}
table.main, td.main	{
				border: <?php echo $border ?>;
				margin-left: auto;
				margin-right: auto;
			}
table.results, table.results_white	{
				border: <?php echo $border ?>;
				margin-left: auto;
				margin-right: auto;
			}
table.header, table.menu	{
				border: <?php echo $border ?>;
				margin-left: auto;
				margin-right: auto;
			}
table.view_white, table.menu	{
				border: <?php echo $border ?>;
				margin-left: auto;
				margin-right: auto;
			}

td.header		{
				background: url('<?php echo $header_title_image ?>') no-repeat;
				background-color: <?php echo $header_title_bg ?>;
				border: <?php echo $tdborder ?>;
				border-bottom: <?php echo $border ?>; /* Just to be sure we've got a separation border */
				font-size: <?php echo $font_hsize ?>;
				color: <?php echo $header_title_text ?>;
				font-family: <?php echo $font ?>;
				font-weight: bold;
				text-align: center;
			}
td.menu			{
				background-color: <?php echo $menu_bg ?>;
				border: <?php echo $menu_tdborder ?>;
				border-bottom: <?php echo $menu_border ?>; /* Just to be sure we've got a separation border */
				font-size: <?php echo $font_size ?>;
				color: <?php echo $menu_text ?>;
				font-family: <?php echo $font ?>;
				font-weight: bold;
				text-align: left;
			}
a.menu			{text-decoration: none; color: <?php echo $menu_link ?>;}
a.menu:active		{text-decoration: none; color: <?php echo $menu_link ?>;}
a.menu:link		{text-decoration: none; color: <?php echo $menu_link ?>;}
a.menu:hover		{text-decoration: underline; color: <?php echo $menu_hover_link ?>;}

td.results		{
				background-color: <?php echo $body_bg ?>;
				border: <?php echo $border ?>;
				font-size: <?php echo $font_size ?>;
				color: <?php echo $main_title_text ?>;
				font-family: <?php echo $font ?>;
				font-weight: normal;
				text-align: left;
				white-space: nowrap;
			}

a.results		{text-decoration: none; color: <?php echo $menu_link ?>;}
a.results:active	{text-decoration: none; color: <?php echo $menu_link ?>;}
a.results:link		{text-decoration: none; color: <?php echo $menu_link ?>;}
a.results:hover		{text-decoration: underline; color: <?php echo $menu_hover_link ?>;}

td.results_white	{
				background-color: <?php echo $res_bg ?>;
				border: <?php echo $border ?>;
				font-size: <?php echo $font_size ?>;
				color: <?php echo $main_title_text ?>;
				font-family: <?php echo $font ?>;
				font-weight: normal;
				text-align: center;
			}
td.view_white		{
				background-color: <?php echo $res_bg ?>;
				border: <?php echo $border ?>;
				font-size: <?php echo $font_size ?>;
				color: <?php echo $main_title_text ?>;
				font-family: <?php echo $font ?>;
				font-weight: normal;
				text-align: center;
			}
th.results		{
				background-color: <?php echo $reshead_bg ?>;
				border: <?php echo $border ?>;
				font-size: <?php echo $font_size ?>;
				color: <?php echo $reshead_text ?>;
				font-family: <?php echo $font ?>;
				font-weight: bold;
				text-align: center;
			}
table.content, td.content{
				background-color: <?php echo $main_bg ?>;
				border: <?php echo $tdborder ?>;
				font-size: <?php echo $font_size ?>;
				color: <?php echo $main_title_text ?>;
				font-family: <?php echo $font ?>;
				font-weight: normal;
				text-align: center;
				margin-left: auto;
				margin-right: auto;
			}
table.form, td.form, text.form, submit.form	{
				background-color: <?php echo $main_bg ?>;
				border: <?php echo $tdborder ?>;
				font-size: <?php echo $font_size ?>;
				color: <?php echo $main_title_text ?>;
				font-family: <?php echo $font ?>;
				font-weight: normal;
				text-align: left;
				margin-left: auto;
				margin-right: auto;
			}
td.footer		{
				background-color: <?php echo $footer_title_bg ?>;
				border: <?php echo $tdborder ?>;
				border-top: <?php echo $border ?>; /* Just to be sure we've got a separation border */
				font-size: <?php echo $font_fsize ?>;
				color: <?php echo $main_title_text ?>;
				color: <?php echo $footer_title_text ?>;
				font-family: <?php echo $font ?>;
				font-weight: bold;
			}
a.footer		{
				text-decoration: none;
				color: #000000;
			}
a.footer:hover		{
				text-decoration: underline;
				color: #6666ff;
			}
span.error		{
				font-size: <?php echo $font_size ?>;
				color: <?php echo $error_text ?>;
				font-family: <?php echo $font ?>;
				font-weight: bold;
				text-align: center;
			}
span.spammer		{
				font-size: <?php echo $font_size ?>;
				color: <?php echo $error_text ?>;
				font-family: <?php echo $font ?>;
				font-weight: bold;
				text-align: center;
			}
span.notspammer		{
				font-size: <?php echo $font_size ?>;
				color: <?php echo $main_title_text ?>;
				font-family: <?php echo $font ?>;
				font-weight: bold;
				text-align: center;
			}
span.main		{
				font-size: <?php echo $font_size ?>;
				color: <?php echo $main_title_text ?>;
				font-family: <?php echo $font ?>;
				font-weight: bold;
				text-align: center;
			}
//-->
</style>
</head>
<body>

<table align="center" cellpadding="2" cellspacing="0" class="main" width="100%">
<tr>
	<td align="center" class="header" height="90px">
		<?php echo $page_title ?>
	</td>
</tr>
<tr>
	<td align="center" class="menu">
		<a href="./" class="menu"><?php echo $linkhome ?></a> &nbsp;
		<a href="./?p=view" class="menu"><?php echo $linkview ?></a> &nbsp;
		<a href="./?p=email" class="menu"><?php echo $linkviewmail ?></a> &nbsp;
		<a href="http://temerc.com/forums/viewforum.php?f=71" class="menu"><?php echo $linkhelp ?></a>
	</td>
</tr>
<tr>
	<td align="center" valign="top" class="content">
		<?php

			// Are we submitting, or viewing?
			$p_type=$_GET['p'];

			// Only show messages on the front page
			if($p_type ==''){

				if($bln_SaveToFile == true && function_exists('file_put_contents')==false || ini_get('allow_url_fopen') == false){
					echo '<span class="error">'.$nofileputcontents.'</span><br><br>';
				}

				if(function_exists('get_headers')==false){
					echo '<span class="error">'.$nogetheaders.'</span><br><br>';
				}

				if(!file_exists($savetofolder)){
					echo '<span class="error">'.$savetofolder.' '.$folderdoesnotexist.'</span><br><br>';
				}

				// Ensure the ProjectHoneyPot API key is here
				if($sPHPAPI ==''){
					echo '<span class="error">'.$sPHPAPIMissing.'</span><br><br>';
				}

				// Ensure the BotScout API key is here
				if($sBSAPI ==''){
					echo '<span class="error">'.$sBSAPIMissing.'</span><br><br>';
				}

				// Ensure the fSpamList API key is here
				if($sFSLAPI ==''){
					echo '<span class="error">'.$sFSLAPIMissing.'</span><br><br>';
				}

				// Let's ensure our required vars are present.
				if($_GET['email'] =='' && $_GET['ip'] =='' && $_GET['name'] ==''){
					echo '<span class="main">'.$main.'</span><br><br>';
				}
			}
			switch(strtolower($p_type)){
				case 'history':
					if(function_exists('file_get_contents') && ini_get('allow_url_fopen') == true){
						$sHistory = file_get_contents('history.txt');
						echo '<div style="text-align: left">'.nl2br($sHistory).'<br><br></div>';
					}else{
						header("Location: history.txt");
					}
					break;
				case 'submit';
					if(file_exists($sMyPath.'submit.php')){
						include($sMyPath.'submit.php');
					}else{
						echo 'Error: submit.php is missing';
					}
					break;
				default:

				// Check for any vars passed

				if(isset($_GET["name"])){
					$sVar_Name = htmlentities($_GET["name"]);
				}
				if(isset($_GET["email"])){
					$sVar_Mail = htmlentities($_GET["email"]);
				}
				if(isset($_GET["ip"])){
					$sVar_IP = htmlentities($_GET["ip"]);
				}
		?>
				<form method="GET" name="checkspamdb" action="index.php">
				<table border="0px" class="form" align="center">
				<tr>
					<td class="form"><?php echo $fld_Username ?>:</td><td class="form"><input type="text" size="35" class="form" name="name" value="<?php echo $sVar_Name ?>"></td>
				</tr>
				<tr>
					<td class="form"><?php echo $fld_Email ?>:</td><td class="form"><input type="text" size="35" class="form" name="email" value="<?php echo $sVar_Mail ?>"></td>
				</tr>
				<tr>
					<td class="form"><?php echo $fld_IPAddr ?>:</td><td class="form"><input type="text" size="35" class="form" name="ip" value="<?php echo $sVar_IP ?>"></td>
				</tr>
				<tr>
					<td align="right" colspan="2"><input class="form" type="submit" name="submit" value="check"></td>
				</tr>
				</table>
				</form>
				<br><br>
		<?php
				$sMyPath = dirname(__FILE__).'/';
				if($p_type ==''){
					if(@curl_version() !=='Array' && !function_exists('file_get_contents')){
						echo '<span class="error">'.$nocurlorfgc.'</span>';
					}else{
						if(file_exists($sMyPath.'check_spammers.php')){
							include($sMyPath."check_spammers.php");
						}else{
							echo 'check_spammers.php is missing';
						}
					}
				}else{
					echo '<span class="main">'.$view_main.'</span><br><br>';
					if($p_type == 'view'){
						include($sMyPath."view_spammers.php");
					}else{
						include($sMyPath."view_spammers_mail.php");
					}
				}
				break;
			} // End switch
		?>
	</td>
</tr>
<tr>
        <td align="center" class="footer" height="24px">
		Copyright &copy; <?php echo $CopyrightYear; ?> <a class="footer" href="http://hosts-file.net">MysteryFCM</a>
		&nbsp;[	<?php echo $Version_Info; ?> | <a class="footer" href="http://temerc.com/forums/viewtopic.php?f=71&amp;t=6103" title="TeMerc Internet Countermeasures - fSpamlist.com - SpamBot Search Tool (aka Querying the fSpamlist database)">Get the code!</a> | 
		<a class="footer" href="<?php echo $_SERVER['SCRIPT_PATH']; ?>?p=History">Version History</a> 
		<?php
			echo ' | ';
			// Do we want to get the spammer count from counter.txt, or the database?
			if($bln_SaveToDB==True){
				$s_ret = GetSpammerCount('F_DB');
			}else{
				$s_ret = GetSpammerCount('F_TEXT');
			}
			echo $s_ret.' spammers blocked';
		?>
		]
		<br><br>
		<a rel="license" class="footer" href="http://creativecommons.org/licenses/by-sa/2.0/uk/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/2.0/uk/80x15.png"></a><br><span xmlns:dc="http://purl.org/dc/elements/1.1/" property="dc:title">Spambot Search Tool</span> by <a class="footer" xmlns:cc="http://creativecommons.org/ns#" href="http://support.it-mate.co.uk/?mode=Products&amp;p=spambotsearchtool" property="cc:attributionName" rel="cc:attributionURL">Steven Burn</a>, <a class="footer" xmlns:dc="http://purl.org/dc/elements/1.1/" href="http://guildwarsholland.nl/phphulp/testspambot.php" rel="dc:source">Smurf Minions</a> is licensed under a <a class="footer" rel="license" href="http://creativecommons.org/licenses/by-sa/2.0/uk/">Creative Commons Attribution-Share Alike 2.0 UK: England &amp; Wales License</a>.<br>Based on a work at <a class="footer" xmlns:dc="http://purl.org/dc/elements/1.1/" href="http://guildwarsholland.nl/phphulp/testspambot.php" rel="dc:source">guildwarsholland.nl</a> with bug fixes courtesy of <a class="footer" xmlns:dc="http://purl.org/dc/elements/1.1/" href="http://www.cedit.biz/joomla-extensions/18-registration-validator/22-block-disposable-email-addresses" rel="dc:source">Dan McCormick</a>.<br>Permissions beyond the scope of this license may be available at <a class="footer" xmlns:cc="http://creativecommons.org/ns#" href="http://mysteryfcm.co.uk/?mode=Contact" rel="cc:morePermissions">http://mysteryfcm.co.uk/?mode=Contact</a>.
	</td>
</tr>
</table>
</body>
</html>