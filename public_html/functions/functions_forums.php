 <?php

// File ID: functions_forums.php
// Purpose: Provides specific functions for forum integration, for now it is MyBB only.

function mybbregister()
{
    $mysidia = Registry::get("mysidia");
    include("inc/config_forums.php");
    $forums = new Database($mybbdbname, $mybbhost, $mybbuser, $mybbpass, $mybbprefix) or die("Cannot connect to forum database, please contact an admin immediately.");

    //Now the database has been switched to mybb forum's. Before inserting user info, lets generate the password and salt in Mybb format.
    $salty = codegen(8, 0);
    $loginkey = codegen(50, 0);
    $md5pass = md5($mysidia->input->post("pass1"));
    $fpass = md5(md5($salty).$md5pass);
    $ip = $_SERVER['REMOTE_ADDR'];
    $altip = ipgen($ip);
    $username = $mysidia->input->post("username");
    $email = $mysidia->input->post("email");
    $avatar = (strpos($imageurl, "http://") !== false)?$avatar:"http://www.".DOMAIN.SCRIPTPATH."/".$mysidia->input->post("avatar");
    $birthday = $mysidia->input->post("birthday");
    $query = "INSERT INTO {$mybbprefix}users (uid, username, password, salt, loginkey, email, postnum, avatar, avatardimensions, avatartype, usergroup, additionalgroups, displaygroup, usertitle, regdate, lastactive, lastvisit, lastpost, website, icq, aim, yahoo, msn, birthday, birthdayprivacy, signature, allownotices, hideemail, subscriptionmethod, invisible, receivepms, receivefrombuddy, pmnotice, pmnotify, threadmode, showsigs, showavatars, showquickreply, showredirect, ppp, tpp, daysprune, dateformat, timeformat, timezone, dst, dstcorrection, buddylist, ignorelist, style, away, awaydate, returndate, awayreason, pmfolders, notepad, referrer, referrals, reputation, regip, lastip, longregip, longlastip, language, timeonline, showcodebuttons, totalpms, unreadpms, warningpoints, moderateposts, moderationtime, suspendposting, suspensiontime, suspendsignature, suspendsigtime, coppauser, classicpostbit, loginattempts, usernotes)
                                       VALUES ('', '$username', '$fpass','$salty','$loginkey', '$email', '0', '$avatar', '', '0', '2', '', '0', '', 'time()', 'time()', 'time()', '0', '', '', '', '', '', '$birthday', 'all', '', '1', '0', '0', '0', '1', '0', '1', '1', '', '1', '1', '1', '1', '0', '0', '0', '', '', '0', '0', '0', '', '', '0', '0', '0', '', '', '', '', '0','0','0','$ip', '$ip','$altip','$altip','','0','1', '0', '0', '0','0','0','0','0','0','0','0','0','1','')";
    $forums->query($query) or die("Failed to create forum account");

    // Now set the cookie for user on MyBB
    $mybbuser = $forums->select("users", array("uid", "loginkey"), "username = '{$username}'")->fetchObject();
    $cookiesettings = array();
    $cookiesettings['cookiedomain'] = $forums->select("settings", array("value"), "name = 'cookiedomain'")->fetchColumn();
    $cookiesettings['cookiepath'] = $forums->select("settings", array("value"), "name = 'cookiepath'")->fetchColumn();
    $cookiesettings['cookieprefix'] = $forums->select("settings", array("value"), "name = 'cookieprefix'")->fetchColumn();
    mybbsetcookie("mybbuser", $mybbuser->uid."_".$mybbuser->loginkey, null, true, $cookiesettings);

    $mybbsid = mybb_random_str(32);
    mybbsetcookie("sid", $mybbsid, -1, true);
}

function mybblogin()
{
    $mysidia = Registry::get("mysidia");
    include("inc/config_forums.php");
    $forums = new Database($mybbdbname, $mybbhost, $mybbuser, $mybbpass, $mybbprefix) or die("Cannot connect to forum database, please contact an admin immediately.");
    $mybbuser = $forums->select("users", array("uid", "loginkey"), "username = '{$mysidia->input->post("username")}'")->fetchObject();
    $cookiesettings = array();
    $cookiesettings['cookiedomain'] = $forums->select("settings", array("value"), "name = 'cookiedomain'")->fetchColumn();
    $cookiesettings['cookiepath'] = $forums->select("settings", array("value"), "name = 'cookiepath'")->fetchColumn();
    $cookiesettings['cookieprefix'] = $forums->select("settings", array("value"), "name = 'cookieprefix'")->fetchColumn();
    mybbsetcookie("mybbuser", $mybbuser->uid."_".$mybbuser->loginkey, null, true, $cookiesettings);

    $mybbsid = mybb_random_str(32);
    mybbsetcookie("sid", $mybbsid, -1, true);
}

function mybblogout()
{
    $mysidia = Registry::get("mysidia");
    include("inc/config_forums.php");
    mybbunsetcookie("mybbuser");
    mybbunsetcookie("sid");
    $forums = new Database($mybbdbname, $mybbhost, $mybbuser, $mybbpass, $mybbprefix) or die("Cannot connect to forum database, please contact an admin immediately.");
    $loginkey = codegen(50, 0);
    $lastvisit = time() - 900;
    $lastactive = time();
    $forums->update("users", array("loginkey" => $loginkey, "lastvisit" => $lastvisit, "lastactive" => $lastactive), "uid = '{$mysidia->user->uid}'");
    $forums->delete("sessions", "uid = '{$mysidia->user->uid}'");
}

function mybbsetcookie($name, $value="", $expires="", $httponly=false, $cookiesettings = array())
{
    $mysidia = Registry::get("mysidia");
    if (!$cookiesettings['cookiepath']) {
        $cookiesettings['cookiepath'] = "/";
    }

    if ($expires == -1) {
        $expires = 0;
    } elseif ($expires == "" || $expires == null) {
        $expires = time() + (60*60*24*365);
    } // Make the cookie expire in a years time
    else {
        $expires = time() + intval($expires);
    }

    $cookiesettings['cookiepath'] = str_replace(array("\n","\r"), "", $cookiesettings['cookiepath']);
    $cookiesettings['cookiedomain'] = str_replace(array("\n","\r"), "", $cookiesettings['cookiedomain']);
    $cookiesettings['cookieprefix'] = str_replace(array("\n","\r", " "), "", $cookiesettings['cookieprefix']);

    // Versions of PHP prior to 5.2 do not support HttpOnly cookies and IE is buggy when specifying a blank domain so set the cookie manually
    $cookie = "Set-Cookie: {$cookiesettings['cookieprefix']}{$name}=".urlencode($value);

    if ($expires > 0) {
        $cookie .= "; expires=".@gmdate('D, d-M-Y H:i:s \\G\\M\\T', $expires);
    }
    if (!empty($cookiesettings['cookiepath'])) {
        $cookie .= "; path={$cookiesettings['cookiepath']}";
    }
    if (!empty($cookiesettings['cookiedomain'])) {
        $cookie .= "; domain={$cookiesettings['cookiedomain']}";
    }
    if ($httponly == true) {
        $cookie .= "; HttpOnly";
    }
    
    $cookiesettings[$name] = $value;
    header($cookie, false);
}

function mybbunsetcookie($name)
{
    $expires = -3600;
    mybbsetcookie($name, "", $expires);
}


function mybb_seed_rng($count=8)
{
    $output = '';
    
    // Try the unix/linux method
    if (@is_readable('/dev/urandom') && ($handle = @fopen('/dev/urandom', 'rb'))) {
        $output = @fread($handle, $count);
        @fclose($handle);
    }
    
    // Didn't work? Do we still not have enough bytes? Use our own (less secure) rng generator
    if (strlen($output) < $count) {
        $output = '';
        
        // Close to what PHP basically uses internally to seed, but not quite.
        $unique_state = microtime().@getmypid();
        
        for ($i = 0; $i < $count; $i += 16) {
            $unique_state = md5(microtime().$unique_state);
            $output .= pack('H*', md5($unique_state));
        }
    }
    
    // /dev/urandom and openssl will always be twice as long as $count. base64_encode will roughly take up 33% more space but crc32 will put it to 32 characters
    $output = hexdec(substr(dechex(crc32(base64_encode($output))), 0, $count));
    
    return $output;
}

function mybb_rand($min=null, $max=null, $force_seed=false)
{
    static $seeded = false;
    static $obfuscator = 0;

    if ($seeded == false || $force_seed == true) {
        mt_srand(mybb_seed_rng());
        $seeded = true;

        $obfuscator = abs((int) mybb_seed_rng());
        
        // Ensure that $obfuscator is <= mt_getrandmax() for 64 bit systems.
        if ($obfuscator > mt_getrandmax()) {
            $obfuscator -= mt_getrandmax();
        }
    }

    if ($min !== null && $max !== null) {
        $distance = $max - $min;
        if ($distance > 0) {
            return $min + (int)((float)($distance + 1) * (float)(mt_rand() ^ $obfuscator) / (mt_getrandmax() + 1));
        } else {
            return mt_rand($min, $max);
        }
    } else {
        $val = mt_rand() ^ $obfuscator;
        return $val;
    }
}

function mybb_random_str($length="8")
{
    $set = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J","k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T","u","U","v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9");
    $str = '';

    for ($i = 1; $i <= $length; ++$i) {
        $ch = mybb_rand(0, count($set)-1);
        $str .= $set[$ch];
    }

    return $str;
}

function mybbrebuildstats()
{
    $mysidia = Registry::get("mysidia");
    include("inc/config_forums.php");
    if (!$mysidia->input->post("username")) {
        return false;
    }
    
    $forums = new Database($mybbdbname, $mybbhost, $mybbuser, $mybbpass, $mybbprefix) or die("Cannot connect to forum database, please contact an admin immediately.");
    $oldstats = $forums->select("datacache", array("cache"), "title = 'stats'")->fetchColumn();
    $stats = unserialize($oldstats);
    $uid = $forums->select("users", array("uid"), "username = '{$mysidia->input->post("username")}'")->fetchColumn();
    
    if ($stats['lastuid'] == $uid) {
        return false;
    }
    $stats['numusers']++;
    $stats['lastuid'] = $uid;
    $stats['lastusername'] = $mysidia->input->post("username");
    $newstats = serialize($stats);
    
    $forums->update("datacache", array("cache" => $newstats), "title = 'stats'");
    $forums->delete("stats");
    $forums->insert("stats", array("dateline" => time(), "numusers" => $stats['numusers'], "numthreads" => $stats['numthreads'], "numposts" => $stats['numposts']));
    return true;
}

?> 