<?php
# Poll extension for WikiMedia v1.4 Eric David / 2006
# http://fr.wikipedia.org/w/index.php?title=Utilisateur:Serenity/poll.php
# <Poll> 
# Question
# Answer 1
# Asnwer 2
# ...
# Answer n
# </Poll>
#
# To activate the extension, include it from your LocalSettings.php
# with: include("extensions/poll.php"); 
$wgExtensionFunctions[] = "wfPoll";

function wfPoll() {
        global $wgParser;
        # register the extension with the WikiText parser
        # the first parameter is the name of the new tag. 
        # In this case it defines the tag <Poll> ... </Poll>
        # the second parameter is the callback function for 
        # processing the text between the tags
        $wgParser->setHook( "poll", "renderPoll" );
        $wgParser->disableCache();
}

# The callback function for converting the input text to HTML output
# $argv is an array containing any arguments passed to the extension like <example argument="foo" bar>..

function renderPoll( $input, $argv=array() ) {
        global $wgParser,$wgUser,$wgScriptPath,$wgTitle,$wgRequest,$wgArticlePath;
        $wgImagePath=$wgScriptPath . "/images/";

        $title = $wgTitle->getText();
        $nspace = $wgTitle->getNameSpace();
        $domain = empty($argv['domain'])?"":$argv['domain'];
        $small = empty($argv['small'])?"":$argv['small'];
        $locked = empty($argv['locked'])?"":$argv['locked'];
        if ($small) {$bginfo = ' BGCOLOR=#F0F0F0'; $bginfo2 = ' BGCOLOR=#FFFFFF'; }
        else $bginfo = $bginfo2 = ' BGCOLOR=#F6F6F6';
        if ($locked) {$bginfo = ' BGCOLOR=#D0D0D0'; $bginfo2 = ' BGCOLOR=#C0C0C0'; $small = '1'; }
        $wgParser->disableCache();
        $IP = wfGetIP();
        if ($wgUser->mName == "") $user = $IP; else $user = $wgUser->mName; 
        $ID = strtoupper(md5($input)); // ID of the poll
        $err = "";
        if ($wgRequest->getVal('oldid') != "") $nspace = "Oldies";
        $lines = split("\n",$input);

        // *******************************************************************************************
        // SPECIAL OPTIONS : STATS, etc
        // *******************************************************************************************


        if ($lines[1] == "TRANSFER IP VOTES") // special param : transfert IP to user votes
        {
                        if ($user == $IP) return "You have to log in if you want to attach your IP-logged votes to your user account.";
                        if (!empty($_POST['transfer'])) // the button has already been clicked
                        {
                                $sql = "UPDATE IGNORE poll_vote SET poll_user= '".$user."' WHERE poll_user = '".$IP."'";
                                mysql_query($sql); $err = $err.mysql_error();
                                if ($err == "")
                                {
                                $sql = "DELETE FROM poll_vote WHERE poll_user = '".$IP."'";
                                mysql_query($sql); $err = $err.mysql_error();
                                }
                                return $err == ""?"Your IP-logged votes have been moved successfully.<BR>":"Error : <BR>".$err."<BR>$sql";
                        }
                        return "Your IP is $IP<BR>Your user account is $user<BR>".'<form name=poll method=POST>'.
                        '<input type="hidden" name="transfer" value="1">'.
                        '<input type="submit" value="Attach my IP votes to my user account"></form><BR>Beware, you won'."'".'t be able to cancel this operation.';
                }

        if ($lines[1] == "STATS" || $lines[1] == "STATSFR") // special param : stats
                {
                        $fr = $lines[1] == "STATSFR";
                        $sql = "SELECT COUNT(*),COUNT(DISTINCT poll_id),COUNT(DISTINCT poll_user),timediff(now(),MAX(poll_date)) FROM `poll_vote`";
                        $result = mysql_query($sql);
                        $err = $err.mysql_error();
                        $tab = mysql_fetch_array($result);
                        $clock = split(':',$tab[3]);
                        if ($clock[0] == '00' && $clock[1] == '00') { $x = $clock[2]+0; $y = $fr?" seconde":" second"; }
                        else if ($clock[0] == '00') { $x = $clock[1]+0; $y = " minute"; }
                        else 
                        {
                                $hr = ($clock[0]+0);
                                if ($hr < 24) { $x = $hr; $y = ($fr?" heure.":" hour"); }
                                else { $x = floor($hr/24); $y = ($fr?" jour":" day"); }
                        }
                        $clockago = $x.$y.($x>1?'s':'');
                        $sql = "SELECT count(*) FROM poll_vote WHERE DATE_SUB(CURDATE(), INTERVAL 2 DAY) <= poll_date";
                        $result2 = mysql_query($sql);
                        $err = $err.mysql_error();
                        $tab2 = mysql_fetch_array($result2);
                        return $fr==0 ? "There are $tab[1] polls and $tab[0] votes given by $tab[2] different people.".
                        "<br>The last vote has been given $clockago ago.".
                        "<br>During the last 48 hours, $tab2[0] votes have been given.<BR>".$err
                        : "Il y a actuellement $tab[1] sondages et $tab[0] opinions émises par $tab[2] internautes.".
                        "<br>La dernière opinion a été émise il y a $clockago.".
                        "<br>Au cours des dernières 48 heures, $tab2[0] opinions ont été émises.<BR>".$err;
                }
                if ($lines[1] == "REMAINING") // special param : remaining polls
                {
                        $sql = 'SELECT poll_domain,poll_title,min(poll_txt) FROM poll_info where poll_id not in (SELECT poll_id FROM poll_vote WHERE poll_user="'.$user.'") group by poll_domain,poll_title';
                        $result = mysql_query($sql);
                        $err = $err.mysql_error();
                        $i = 0; $j = 0; $str = ""; $dom = "ZZ";
                        while ($polltxt = mysql_fetch_array($result)) 
                                { if ($polltxt[0] != $dom) { $dom = $polltxt[0]; $i++; $j = 0;
                                                             $str .= '<h3> '.$i.'. Domain '.strtoupper($dom).'</h3>'; }
                                  $tmp = split("\n",$polltxt[2]);
                                  $str .= '    '.$i.'.'.(++$j).'. <a href="'.
                                str_replace('$1',$polltxt[1],str_replace(' ','%20',$wgArticlePath)).'#firstone">'.
                                $polltxt[1].'</a> <font size=1 color=#C0C0C0>('.$tmp[1].')</font><BR>';
                                  }
                        if ($str == "") $str = "There are no polls where you haven't voted yet.\n<BR>";
                        return $str.$err;
                }
        if ($lines[1] == "REMAINING FOR DOMAIN") // special param : remaining polls
                {
                        $sql = 'SELECT min(poll_txt),poll_title,count(*) FROM poll_info where poll_id not in (SELECT poll_id FROM poll_vote WHERE poll_user="'.$user.'") and poll_domain = "'.$lines[2].'" group by poll_title';
                        $result = mysql_query($sql);
                        $err = $err.mysql_error();
                        $str = "";
                        $j = 0;
                        while ($polltxt = mysql_fetch_array($result)) 
                        {       
                                $tmp = split("\n",$polltxt[0]);
                                $str .= "<BR>\n".(++$j).'. <a href="'.str_replace('$1',$polltxt[1],str_replace(' ','%20',$wgArticlePath)).
                                        '#firstone">'.$polltxt[1].'</a> <font size=1>('.$polltxt[2].') <font color=#C0C0C0>'.
                                                str_replace('<a ','<bla ',$tmp[1]).' ...</font></font>';
                        }
                        if ($str == "") $str = $lines[4]."<BR>"; else $str = "<H2>".$lines[3]."</H2>".$str;
                        return $str.$err;
                }
        if ($lines[1] == "CONTROL") // special param : remaining polls
                {
                        if ($user != 'WikiSysop') return '';
                        $sql = 'select * from (SELECT min(poll_ip),poll_user,count(*) cnt,min(poll_date),max(poll_date) mdat FROM poll_vote group by poll_user) t order by mdat desc';
                        $result = mysql_query($sql);
                        $err = $err.mysql_error();
                        $str = "";
                        $b = "";
                        while ($t = mysql_fetch_array($result)) 
                                {
                                $str .= "<tr><td>$t[0]</td><td>$t[1]</td><td>$t[2]</td><td>$t[3]</td><td>$t[4]</td></tr>";
                                $b .= "$t[0]\t$t[1]\t$t[2]\t$t[3]\t$t[4]\n";
                                }
                        return "<form action=http://localhost/ip2dns.php method=post><input type=submit value='Calcul DNS'><input type=hidden name=txt value='".$b.
                                "'></form><BR><BR><table border=2>".$str."</table>".$err;
                }
        if ($lines[1] == "CROSS") // special param : tableau croisé
                {
                if (!empty($_POST['poll1'])) // the button has already been clicked
                {
                        $split1 = split("\n",$_POST['poll1']);
                        $split2 = split("\n",$_POST['poll2']);
                        $ID1 = trim($split1[0]);
                        $ID2 = trim($split2[0]);
                        $norm = empty($_POST['norm']) ? "" : $_POST['norm'];
                        $nbansw1 = count($split1)-2;
                        $nbansw2 = count($split2)-2;
                        $sql = "SELECT p1.poll_answer,p2.poll_answer,count(*) FROM poll_vote p1,poll_vote p2 WHERE 
                                p1.poll_id = '$ID1' and p2.poll_id = '$ID2' and p1.poll_user = p2.poll_user group by p1.poll_answer,p2.poll_answer";
                        $result = mysql_query($sql); $err = $err.mysql_error();
                        while ($row = mysql_fetch_array($result)) $res[$row[0]+$row[1]*$nbansw1] = $row[2]; 

                        for ($i=0;$i<$nbansw1;$i++) $tot_line[$i+2] = 0;
                        for ($j=0;$j<$nbansw2;$j++) $tot_row[$j+2] = 0;

                        for ($i=0;$i<$nbansw1;$i++)
                        for ($j=0;$j<$nbansw2;$j++)
                                {
                                if (empty($res[($i+2)+($j+2)*$nbansw1])) $res[($i+2)+($j+2)*$nbansw1] = 0;
                                $tot_line[$i+2] += $res[($i+2)+($j+2)*$nbansw1];
                                $tot_row[$j+2] += $res[($i+2)+($j+2)*$nbansw1];
                                }
                        $total = array_sum($res);

                        $str = "<BR><table border=0 cellspacing=3 cellpadding=2><tr><td rowspan=2 bgcolor=#E0E0E0 style='border:1px outset'><b>".
                                        "$split1[1]</b></td><td colspan=$nbansw2 bgcolor=#E0E0E0 style='border:1px outset'><b>$split2[1]</b></td></tr><tr>";
                        for ($j=0;$j<$nbansw2;$j++)
                                $str .= "<td align=center style='border:1px outset' bgcolor=#F0F0F0>".$split2[$j+2]."</td>";
                        $str .= "</tr>";
                        for ($i=0;$i<$nbansw1;$i++)
                        {
                                $str .= "<tr><td align=right style='border:1px outset' bgcolor=#F0F0F0>".$split1[$i+2]."</td>";
                                for ($j=0;$j<$nbansw2;$j++)
                                {
                                $x = empty($res[($i+2)+($j+2)*$nbansw1]) ? 0 : $res[($i+2)+($j+2)*$nbansw1]*100/$total;
                                if ($norm == "line") $x = $tot_line[$i+2] == 0 ? "" : $x*$total/$tot_line[$i+2];
                                if ($norm == "row") $x = $tot_row[$j+2] == 0 ? "" : $x*$total/$tot_row[$j+2];
                                $r = dechex($x==0 || $x == ""?255:230-$x*2);
                                if (strlen($r) == 1) $r = "0".$r;
                                $g = "FF";
                                $b = $r;
                                if ($x != "") $x = round($x)."%";
                                $str .= "<td align=center bgcolor=#$r$g$b><font size=1>$x</font></td>";
                                if ($x != "" && empty($comm)) 
                                        {
                                        if ($norm == "")
                                                $comm = str_replace('$3',$split2[$j+2],str_replace('$2',$split1[$i+2],str_replace('$1',$x,$lines[7])));
                                        if ($norm == "line")
                                                $comm = str_replace('$3',$split2[$j+2],str_replace('$2',$split1[$i+2],str_replace('$1',$x,$lines[8])));
                                        if ($norm == "row")
                                                $comm = str_replace('$3',$split1[$i+2],str_replace('$2',$split2[$j+2],str_replace('$1',$x,$lines[9])));
                                        }
                                }
                                if ($norm == "line" && $tot_line[$i+2]>0) $str .= "<td style='border:1px outset'><font size=1>100%</font></td>";
                                if ($norm == "") $str .= "<td style='border:1px outset' align=center><font size=1>".round($tot_line[$i+2]*100/$total)."%</font></td>";
                                $str .= "</tr>";

                        }
                        if ($norm == "row" || $norm == "")
                        {
                                $str .= "<tr><td></td>";
                                for ($j=0;$j<$nbansw2;$j++)
                                {
                                        if ($norm == "row" && $tot_row[$j+2]==0) $str .= "<td></td>";
                                        else
                                        $str .= "<td align=center style='border:1px outset'><font size=1>".($norm==""?round($tot_row[$j+2]*100/$total).'%':"100%")."</font></td>";
                                }
                                if ($norm == "") $str .= "<td style='border:1px outset'><font size=1>100%</td>";
                                $str .= "</tr>";
                        }
                        return $str."</table><BR><BR><font size=1>$total vote".($total>1?'s':'').'<BR>'.$comm.'</font>'.$err.
                                '<BR><BR><form name=poll method=POST><input type=submit value="'.$lines[3].'">'.
                                        '<input type=hidden name=norm value=line>'.
                                        '<input type=hidden name=poll1 value="'.$_POST['poll1'].'">'.
                                        '<input type=hidden name=poll2 value="'.$_POST['poll2'].'"></form>'.
                                '<form name=poll method=POST><input type=submit value="'.$lines[4].'">'.
                                        '<input type=hidden name=norm value=row>'.
                                        '<input type=hidden name=poll1 value="'.$_POST['poll1'].'">'.
                                        '<input type=hidden name=poll2 value="'.$_POST['poll2'].'"></form>'.
                                '<form name=poll method=POST><input type=submit value="'.$lines[5].'">'.
                                        '<input type=hidden name=poll1 value="'.$_POST['poll1'].'">'.
                                        '<input type=hidden name=poll2 value="'.$_POST['poll2'].'"></form>'.
                                '<BR><form name=poll method=POST><input type=submit value="'.$lines[6].'">'.
                                        '<input type=hidden name=p1 value="'.$ID1.'">'.
                                        '<input type=hidden name=p2 value="'.$ID2.'"></form>';
                }

                $sql = 'SELECT poll_txt,poll_title,poll_id FROM poll_info where poll_domain = "'.$lines[2].'" order by poll_title,poll_txt';
                $result = mysql_query($sql); $err = $err.mysql_error();
                $opt1 = "";
                $opt2 = "";
                $dsel1 = 0; $dsel2 = 0;
                if (!empty($_POST['p1'])) { $p1 = $_POST['p1']; $p2 = $_POST['p2']; } else { $p1 = ""; $p2 = ""; }
                while ($polltxt = mysql_fetch_array($result)) 
                        {
                        $polllines = split("\n",$polltxt[0]);
                        $txt = $polllines[1];
                        while (strpos($txt,'<') != FALSE && strpos($txt,'>') != FALSE) // supression des balises a et /a
                                $txt = substr($txt,0,strpos($txt,'<')).substr($txt,strpos($txt,'>')+1);
                        $sel1 = $p1==''?rand(0,10)==0 && $dsel1==0:$polltxt[2] == $p1;
                        $sel2 = $p2==''?$dsel2==0 && $dsel1==1:$polltxt[2] == $p2;
                        $opt1 .= '<option '.($sel1?'selected=selected':'').' value="'.$polltxt[2]."\n".
                                str_replace('"',"'",'<font size=1>'.trim($polltxt[1])."</font><BR> ".trim($polltxt[0])).'">'.
                                        $polltxt[1].' : '.(strlen($txt)>80?substr($txt,0,80).' (...)':$txt).'</option>';
                        $opt2 .= '<option '.($sel2?'selected=selected':'').' value="'.$polltxt[2]."\n".
                                str_replace('"',"'",'<font size=1>'.trim($polltxt[1])."</font><BR> ".trim($polltxt[0])).'">'.
                                        $polltxt[1].' : '.(strlen($txt)>80?substr($txt,0,80).' (...)':$txt).'</option>';
                        $dsel1 = $sel1+$dsel1; 
                        $dsel2 = $sel2+$dsel2;  // déjà selectionné ?
                        }
                $str = "<BR><form name=poll method=POST><select name=poll1>$opt1</select><BR><BR><select name=poll2>$opt2</select><BR><BR>"
                  .'<input type=submit></form>';
                return $str.$err;
                }

        // *******************************************************************************************
        // REGULAR 'POST' VARIABLES TREATMENTS
        // *******************************************************************************************

        if (!empty($_POST['poll_ID']))  // POST Variables treatments
                {
                  $_POST['poll_ID'] = trim($_POST['poll_ID'],"/");
                  if (!empty($_POST['answer']))
                  {  
                  $_POST['answer'] = trim($_POST['answer'],"/");
                  if ($wgUser->mName != "") // PROCESS VOTE ONLY FOR LOGGED USERS
                  if ($_POST['poll_ID'] == $ID)  // PROCESS THE VOTE
                        {
                        $sql = "DELETE FROM `poll_vote` WHERE `poll_id` = '".$ID."' and `poll_user` = '".$user."'";
                        mysql_query($sql);
                        $err = $err.mysql_error();
                        $sql = "INSERT INTO `poll_vote` "
                                                ."(`poll_id`, `poll_user`, `poll_ip`, `poll_answer`, `poll_date`)\n"
                                                ."\tVALUES ('".$ID."', '".$user."', '".wfGetIP()."', '".
                                                $_POST['answer']."', '".date("Y-m-d H:i:s")."')";
                        mysql_query($sql);
                        $err = $err.mysql_error();
                        }                       
                  }
                  if (!empty($_POST['message']))
                  {  
                  if ($_POST['poll_ID'] == $ID)  // PROCESS THE MESSAGE
                        {
                        $_POST['message'] = trim($_POST['message'],"/");
                        $_POST['message'] = ereg_replace("'","''",$_POST['message']);
                        $sql = "DELETE FROM `poll_message` WHERE `poll_id` = '".$ID."' and `poll_user` = '".$user."'";
                        mysql_query($sql);
                        $err = $err.mysql_error();
                        $sql = "INSERT INTO `poll_message` "
                                        ."(`poll_id`, `poll_user`, `poll_ip`, `poll_msg`, `poll_date`)\n"
                                        ."\tVALUES ('".$ID."', '".$user."', '".wfGetIP()."', '".
                                        $_POST['message']."', '".date("Y-m-d H:i:s")."')";
                        mysql_query($sql);
                        $err = $err.mysql_error();
                        }
                  }
                }

        // *******************************************************************************************
        // GETTING THE VOTES (some SQL requests)
        // *******************************************************************************************
        $sql = "SELECT `poll_answer`, COUNT(*)"
                        ."\tFROM `poll_vote`\n"
                        ."\tWHERE "."`poll_id` = '".$ID."'"."\n"
                        ."\tGROUP BY `poll_answer`";
        $result = mysql_query($sql);
        $err = $err.mysql_error();
        while ($row = mysql_fetch_array($result)) $poll_result[$row[0]] = $row[1]; 
        if (empty($poll_result)) $total = 0; else $total = array_sum($poll_result);

                // has the user already voted ?
        $sql = "SELECT poll_answer FROM `poll_vote`\n"
                        ."\tWHERE `poll_id` = '".$ID."' AND `poll_user` = '".$user."'\n";
        $result = mysql_query($sql);
        $err = $err.mysql_error();
        $row = mysql_fetch_array($result);
        $deja_vote = $row[0];

        // Getting the messages
        $sql = "SELECT `poll_user`,`poll_msg` FROM `poll_message`\n"
                        ."\tWHERE "."`poll_id` = '".$ID."' ORDER BY `poll_date`\n";
        $comresult = mysql_query($sql);
        $err = $err.mysql_error();
        $i = 0;
        while ($comrow = mysql_fetch_array($comresult)) 
                        {
                        $compoll_result[$i++] = $comrow[1];
                        $compoll_result[$i-1] = str_replace('<','<',$compoll_result[$i-1]);
                        $compoll_result[$i-1] = str_replace('>','>',$compoll_result[$i-1]);
                        if ($domain == 'DO NOT REGISTER' && $comrow[1] == 'DEL' && 
                                        $comrow[0] == 'WikiSysop') return '<a name="'.$ID.'" id="'.$ID.'"></a>';
                        }
        $msgtotal = $i;


        if ($total == 0 || $lines[1] == "PURIFY") // Purify the poll_info table
                {
                        $sql = 'insert into poll_message (poll_id,poll_user,poll_msg) 
select poll_info.poll_id,\' AUTO \',\'DEL\'
from poll_info,
        (select poll_title,min(poll_date),max(poll_date) poll_datemaxi
        from poll_info
        group by poll_title) title
where poll_info.poll_title = title.poll_title
and TIME_TO_SEC(title.poll_datemaxi)-TIME_TO_SEC(poll_info.poll_date)>2';
                        $result = mysql_query($sql); $err = $err.mysql_error();
                        $sql = 'UPDATE poll_info SET poll_domain = "DEL" where poll_id in 
        (select msg.poll_id from poll_message msg
        where poll_msg = "DEL" and poll_user = " AUTO ")';
                        $result = mysql_query($sql); $err = $err.mysql_error();
                        $sql = 'delete from poll_info where poll_domain = "DEL"';
                        $result = mysql_query($sql); $err = $err.mysql_error();
                        $sql = 'delete from poll_message where poll_msg = "DEL" and poll_user = " AUTO ";';
                        $result = mysql_query($sql); $err = $err.mysql_error();
                        if ($lines[1] == "PURIFY") return "<!-- POLL PURIFY PROCESS $err -->";
                }


        // *******************************************************************************************
        // building HTML
        // *******************************************************************************************
        $str = "";
        
        if ($nspace == '' && $domain != 'DO NOT REGISTER' && $locked == '') // register the poll in poll_info
                        {
                                $sql = "DELETE FROM `poll_info` WHERE `poll_id` = '".$ID."'";
                                mysql_query($sql);
                                $input2 = str_replace("'","''",$input);
                                $err = $err.mysql_error();
                                $sql = "INSERT INTO `poll_info` "
                                                ."(`poll_id`, `poll_txt`, `poll_date`,`poll_title`,`poll_domain`)\n"
                                                ."\tVALUES ('".$ID."', '".$input2."', '".date("Y-m-d H:i:s").
                                                        "', '".str_replace("'","''",$title)."','".$domain."')";
                                mysql_query($sql);
                                $err = $err.mysql_error();
                                $str .= "<!-- regdom $domain -->";
                        } else $str .= "<!-- no regdom -->";

        if ($deja_vote==0 && empty($_POST['first'])) { $str .= "<a name=firstone></a>"; $_POST['first'] = 1; }

        $smalltxt1 = $small==''?'':'<font size='.$small.'>';
        $smalltxt2 = $small==''?'':'</font>';
        $str .= '<a name="'.$ID.'" id="'.$ID.'"></a>'.
                '<b'.($small==''?'':' style="line-height: 100%"').'>'.
                        ucfirst($lines[1]).' </b><font size=1>('.$total.' vote'.($total>1?'s':'').')</font>'.
                        '<table border="0" cellpadding=0 cellspacing=0>';
        $nbansw = count($lines)-1;
        for ($i=2;$i<$nbansw;$i++)
                        { $str .= '<tr style="line-height: 100%">';
                          $str .= '<td '.($i%2==0?$bginfo2:$bginfo).'>'.$smalltxt1.'<form name="poll" method="POST" action="#'.$ID.'">'.
                        '<input type="hidden" name="poll_ID" value="'.($ID).'">'.
                        '<input type="hidden" name="answer" value="'.$i.'">'.
                        ($locked!=''?'':
                        '<input type="image" align=texttop src="'.$wgImagePath.'/pool/button'.$small.'.gif" name="Vote" alt="Vote" name="Vote" '.
                                ($small==''?'width=23 height=20':'width=17 height=13').'> ').ucfirst($lines[$i]).'  '.$smalltxt2.'</form></td>'; 
                        if ($total>0)
                                {
                                if (empty($poll_result[$i])) $res = 0; else $res = $poll_result[$i];
                                $str .= '<td width=160'.($i%2==0?$bginfo2:$bginfo).'><font size=1>';
                                $a = $deja_vote==""?"a":($deja_vote==$i?"c":"b");
                                if ($res>0)
                                        $str .= '<img src="'.$wgImagePath.'/pool/left'.$a.'.gif" height=10 width=4>'.
                                '<img src="'.$wgImagePath.'/pool/middle'.$a.'.gif" alt="'.$res.' votes" height=10 width='.round($res*100/$total).'>'.
                                '<img src="'.$wgImagePath.'/pool/right'.$a.'.gif" height=10 width=5>';
                                $str .= ' '.($res/$total>0.03?round($res*100/$total):round($res*1000/$total)/10).'% </font></td>';
                                }
                        $str .= '</tr>';
                        }
        $str .= '</table><form name=poll method=POST action="#'.$ID.'"><font size=1>  '.
                        '<input type="hidden" name="poll_ID" value="'.($ID).'">'.
                        '<font color=#A0A0A0> Message '.($domain=="fr"?"(ENTREE pour valider)":"(ENTER to confirm)").
                        '</font><BR><input type="text" STYLE="background: #E8E8E8; font: '.(10-$small*2).'pt arial" name="message" size=50 value="<'.$user.'> ">';
        if ($msgtotal>0)
        {
                $str .= '<BR><select STYLE="background: #F6F6F6; font: '.(10-$small*2).'pt arial">';
                $str .= '<option>'.$msgtotal.' message'; if ($msgtotal>1) $str .= 's'; $str .= '</option>';
                for ($i=0;$i<$msgtotal;$i++) // list of message
                        $str .= '<option>'.ucfirst($compoll_result[$i]).'</option>';
                $str .= '</select>';
        }
        $str .= '</select></font></form>';
        if ($err != NULL) return '<B>Error</B><BR>'.$err;
      
        return '<BR><table style="border:1px outset" cellspacing=0 cellpadding=5><tr><td'.$bginfo.'>'.$str.'</td></tr></table>';
 }

?>