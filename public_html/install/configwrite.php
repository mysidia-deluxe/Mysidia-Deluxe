<?php

//This file writes the config.php file and then inserts the database info into the database...
require_once './_header.php';

define("SUBDIR", "Install");
$dbhost = $_POST['dbhost']; 
$dbuser = $_POST['dbuser'];
$dbpass = $_POST['dbpass'];
$dbname = $_POST['dbname'];
$domain = $_POST['domain'];
$scriptpath = $_POST['scriptpath'];
$prefix = $_POST['prefix'];


//Check again that config.php is writable...

if (!is_writable(CONFIG_FOLDER)) {
    die("The configuration folder isn't writeable.  Cannot proceed.");
} 

if($dbuser == "" or $dbname == "" or $domain == "" or $prefix == ""){
    die("Something required was left blank. Please go back and try again.");
}

//Begin writing the config.php file...

$configdata = "DBHOST='{$dbhost}'
DBUSER='{$dbuser}'
DBPASS='{$dbpass}'
DBNAME='{$dbname}'
DOMAIN='{$domain}'
SCRIPTPATH='{$scriptpath}'
PREFIX='{$prefix}'";

//Write the config.php file...

$file = fopen(CONFIG_FOLDER . '.env', 'w');
fwrite($file, $configdata);
fclose($file);				

//Connect to the database and insert the default data.....
try{
    $dsn = "mysql:host={$dbhost};dbname={$dbname}";
    $adopts = new PDO($dsn, $dbuser, $dbpass);
}
catch(PDOException $pe){
    die("Could not connect to database, the following error has occurred: <br><b>{$pe->getmessage()}</b>");  
}

$query = "CREATE TABLE {$prefix}acp_hooks (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, linktext varchar(150), linkurl varchar(200), pluginname varchar(50), pluginstatus int DEFAULT 0)";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}adoptables (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, type varchar(40), class varchar(40), description varchar(300), eggimage varchar(120), whenisavail varchar(50), alternates varchar(10), altoutlevel int DEFAULT 0, altchance int DEFAULT 0, shop varchar(20), cost int DEFAULT 0)";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}adoptables_conditions (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, type varchar(40), whenisavail varchar(50), freqcond varchar(50), number int DEFAULT 0, datecond varchar(50), date varchar(20), adoptscond varchar(20), moreless varchar(20), morelessnum int DEFAULT 0, levelgrle varchar(25), grlelevel int DEFAULT 0)";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}ads (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, adname varchar(50), text varchar(1650), page varchar(50), impressions int DEFAULT 0, actualimpressions int DEFAULT 0, date varchar(50), status varchar(15), user varchar(45), extra varchar(100))";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}breeding (bid int NOT NULL AUTO_INCREMENT PRIMARY KEY, offspring varchar(40), parent varchar(40), mother varchar(40), father varchar(40), probability int DEFAULT 0, survival int DEFAULT 0, level int DEFAULT 0, available varchar(10))";
$adopts->query($query);


$query = "CREATE TABLE {$prefix}breeding_settings (bsid int NOT NULL AUTO_INCREMENT PRIMARY KEY, name varchar(20), value varchar(40))";
$adopts->query($query);

$query = "INSERT INTO {$prefix}breeding_settings (bsid, name, value) VALUES (1, 'system', 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}breeding_settings (bsid, name, value) VALUES (2, 'method', 'advanced')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}breeding_settings (bsid, name, value) VALUES (3, 'species', '')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}breeding_settings (bsid, name, value) VALUES (4, 'interval', 2)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}breeding_settings (bsid, name, value) VALUES (5, 'level', 1)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}breeding_settings (bsid, name, value) VALUES (6, 'capacity', 5)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}breeding_settings (bsid, name, value) VALUES (7, 'number', 2)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}breeding_settings (bsid, name, value) VALUES (8, 'chance', 80)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}breeding_settings (bsid, name, value) VALUES (9, 'cost', 1000)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}breeding_settings (bsid, name, value) VALUES (10, 'usergroup', 'all')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}breeding_settings (bsid, name, value) VALUES (11, 'item', '')";
$adopts->query($query);


$query = "CREATE TABLE {$prefix}content (cid int NOT NULL AUTO_INCREMENT PRIMARY KEY, page varchar(20), title varchar(75), date varchar(15), content varchar(15000), level varchar(50), code varchar(128), item varchar(20), time varchar(20), `group` varchar(20))";
$adopts->query($query);

$query = "INSERT INTO {$prefix}content (cid, page, title, date, content, level, code, item, time, `group`) VALUES ('', 'index', 'This is the index page', '03-22-2011', 'This is a sample article.  All of this text you can change in the script admin control panel.', '', '', '', '', '')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}content (cid, page, title, date, content, level, code, item, time, `group`) VALUES ('', 'tos', 'This is the Terms of Service Page', '03-22-2011', 'Put your terms of service here.  All of this text you can change in the script admin control panel.', '', '', '', '', '')";
$adopts->query($query);


$query = "CREATE TABLE {$prefix}daycare_settings (dsid int NOT NULL AUTO_INCREMENT PRIMARY KEY, name varchar(20), value varchar(40))";
$adopts->query($query);

$query = "INSERT INTO {$prefix}daycare_settings (dsid, name, value) VALUES (1, 'system', 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}daycare_settings (dsid, name, value) VALUES (2, 'display', 'random')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}daycare_settings (dsid, name, value) VALUES (3, 'number', 15)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}daycare_settings (dsid, name, value) VALUES (4, 'columns', 5)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}daycare_settings (dsid, name, value) VALUES (5, 'level', 1)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}daycare_settings (dsid, name, value) VALUES (6, 'species', '')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}daycare_settings (dsid, name, value) VALUES (7, 'info', 'Name,CurrentLevel')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}daycare_settings (dsid, name, value) VALUES (8, 'owned', 'yes')";
$adopts->query($query);


$query = "CREATE TABLE {$prefix}filesmap (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, serverpath varchar(150), wwwpath varchar(200), friendlyname varchar(50))";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}folders_messages (mid int NOT NULL AUTO_INCREMENT PRIMARY KEY, fromuser varchar(50), touser varchar(50), folder varchar(20), datesent varchar(25), messagetitle varchar(100), messagetext varchar(2500))";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}friend_requests (fid int NOT NULL AUTO_INCREMENT PRIMARY KEY, fromuser varchar(50), offermessage varchar(1000), touser varchar(50), status varchar(30))";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}groups (gid int NOT NULL AUTO_INCREMENT PRIMARY KEY, groupname varchar(20) UNIQUE, canadopt varchar(10), canpm varchar(10), cancp varchar(10), canmanageadopts varchar(10), canmanagecontent varchar(10), canmanageads varchar(10), canmanagesettings varchar(10), canmanageusers varchar(10))";
$adopts->query($query);


$query = "INSERT INTO {$prefix}groups VALUES (1, 'rootadmins', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}groups VALUES (2, 'admins', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}groups VALUES (3, 'registered', 'yes', 'yes', 'no', 'no', 'no', 'no', 'no', 'no')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}groups VALUES (4, 'artists', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}groups VALUES (5, 'banned', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}groups VALUES (6, 'visitors', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no')";
$adopts->query($query);


$query = "CREATE TABLE {$prefix}inventory (iid int NOT NULL AUTO_INCREMENT PRIMARY KEY, category varchar(40), itemname varchar(40), owner varchar(40), quantity int DEFAULT 0, status varchar(40))";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}items (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, category varchar(40), itemname varchar(40), description varchar(200), imageurl varchar(150), function varchar(40), target varchar(200), value int DEFAULT 0, shop varchar(40), price int DEFAULT 0, chance int DEFAULT 0, cap int DEFAULT 0, tradable varchar(30), consumable varchar(30))";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}items_functions (ifid int NOT NULL AUTO_INCREMENT PRIMARY KEY, function varchar(40), intent varchar(20), description varchar(200))";
$adopts->query($query);

$query = "INSERT INTO {$prefix}items_functions VALUES (1, 'Key', 'no', 'This item function defines items classified as key items, they cannot be sold or tossed, and exist for various purposes.')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}items_functions VALUES (2, 'Valuable', 'no', 'This item function defines items that do not serve any purposes besides selling for money.')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}items_functions VALUES (3, 'Level1', 'Adoptable', 'This item function defines items that raise your adoptables levels by certain point.')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}items_functions VALUES (4, 'Level2', 'Adoptable', 'This item function defines items that set your adoptables levels to certain values.')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}items_functions VALUES (5, 'Level3', 'Adoptable', 'This item function defines items that reset your adoptables to baby state.')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}items_functions VALUES (6, 'Click1', 'Adoptable', 'This item function defines items that raise your adoptables totalclicks by certain points.')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}items_functions VALUES (7, 'Click2', 'Adoptable', 'This item function defines items that set your adoptables totalclicks to certain values.')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}items_functions VALUES (8, 'Click3', 'Adoptable', 'This item function defines items that reset the clicks of a day.')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}items_functions VALUES (9, 'Breed1', 'Adoptable', 'This item function defines items that enables your adoptables to breed again instantly.')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}items_functions VALUES (10, 'Breed2', 'Adoptable', 'This item function defines items that enable adoptables to overcome class barriers for interspecies breeding.')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}items_functions VALUES (11, 'Alts1', 'Adoptable', 'This item function defines items that change your adoptables form from one to the other.')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}items_functions VALUES (12, 'Name1', 'Adoptable', 'This item function defines items that allow members to rename their adoptables.')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}items_functions VALUES (13, 'Name2', 'User', 'This item function defines items that allow members to change their usernames.')";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}levels (lvid int NOT NULL AUTO_INCREMENT PRIMARY KEY, adoptiename varchar(50), thisislevel int DEFAULT 0, requiredclicks int DEFAULT 0, primaryimage varchar(120), alternateimage varchar(120), rewarduser varchar(10), promocode varchar(25))";
$adopts->query($query);


$query = "CREATE TABLE {$prefix}levels_settings (lsid int NOT NULL AUTO_INCREMENT PRIMARY KEY, name varchar(20), value varchar(200))";
$adopts->query($query);

$query = "INSERT INTO {$prefix}levels_settings (lsid, name, value) VALUES (1, 'system', 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}levels_settings (lsid, name, value) VALUES (2, 'method', 'multiple')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}levels_settings (lsid, name, value) VALUES (3, 'clicks', '5,2')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}levels_settings (lsid, name, value) VALUES (4, 'maximum', 3)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}levels_settings (lsid, name, value) VALUES (5, 'number', 10)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}levels_settings (lsid, name, value) VALUES (6, 'reward', '10,20')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}levels_settings (lsid, name, value) VALUES (7, 'owner', 'enabled')";
$adopts->query($query);


$query = "CREATE TABLE {$prefix}links (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, linktype varchar(15), linktext varchar(150), linkurl varchar(200), linkparent int DEFAULT 0, linkorder int DEFAULT 0)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (1, 'navlink', 'Home', 'index', 0, 0)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (2, 'navlink', 'Adoptables', 'index', 0, 10)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (3, 'navlink', 'User CP', 'index', 0, 20)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (4, 'navlink', 'Explore', 'index', 0, 30)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (5, 'navlink', 'Community', 'index', 0, 40)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (6, 'navlink', 'Adoption Center', 'adopt', 2, 0)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (7, 'navlink', 'Pound Pool', 'pound', 2, 10)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (8, 'navlink', 'My Adopts', 'myadopts', 2, 20)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (9, 'navlink', 'Special Offer', 'promo', 2, 30)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (10, 'navlink', 'Manage Account', 'account', 3, 0)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (11, 'navlink', 'Manage Trade', 'mytrades', 3, 10)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (12, 'navlink', 'Manage Items', 'inventory', 3, 20)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (13, 'navlink', 'Manage PMs', 'messages', 3, 30)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (14, 'navlink', 'Trade', 'trade', 4, 0)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (15, 'navlink', 'Breeding', 'breeding', 4, 10)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (16, 'navlink', 'Daycare', 'levelup/daycare', 4, 20)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (17, 'navlink', 'Market', 'shop', 4, 30)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (18, 'navlink', 'Search', 'search', 4, 40)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (19, 'navlink', 'Shoutbox', 'shoutbox', 5, 0)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (20, 'navlink', 'Forum', 'forum', 5, 10)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (21, 'navlink', 'Members List', 'profile', 5, 20)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (22, 'navlink', 'Stats', 'stats', 5, 30)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (23, 'navlink', 'TOS', 'tos', 5, 40)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (24, 'sidelink', 'Adopt New Pets', 'adopt', 0, 0)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (25, 'sidelink', 'Acquire Pounded Pets', 'pound', 0, 10)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (26, 'sidelink', 'Manage Adoptables', 'myadopts', 0, 20)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (27, 'sidelink', 'Go to My Account', 'account', 0, 30)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (28, 'sidelink', 'Messages', 'messages', 0, 40)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (29, 'sidelink', 'Change Themes', 'changestyle', 0, 50)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}links VALUES (30, 'sidelink', 'Logout', 'login/logout', 0, 60)";
$adopts->query($query);


$query = "CREATE TABLE {$prefix}messages (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, fromuser varchar(50), touser varchar(1650), status varchar(20), datesent varchar(25), messagetitle varchar(100), messagetext varchar(2500))";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}modules (moid int NOT NULL AUTO_INCREMENT PRIMARY KEY, widget varchar(20), name varchar(20), subtitle varchar(40), userlevel varchar(20), html text, php text, `order` int DEFAULT 0, status varchar(10))";
$adopts->query($query);

$query = "INSERT INTO {$prefix}modules VALUES (1, 'sidebar', 'MoneyBar', '', 'member', '', '', 0, 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}modules VALUES (2, 'sidebar', 'LoginBar', '', 'visitor', '', '', 0, 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}modules VALUES (3, 'sidebar', 'LinksBar', '', 'member', '', '', 10, 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}modules VALUES (4, 'sidebar', 'WolBar', '', 'user', '', '', 20, 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}modules VALUES (5, 'footer', 'Ads', '', 'user', '', '', 0, 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}modules VALUES (6, 'footer', 'Credits', '', 'user', '', '', 10, 'enabled')";
$adopts->query($query);


$query = "CREATE TABLE {$prefix}online (username varchar(40), ip varchar(20), session char(100), time int DEFAULT 0)";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}owned_adoptables (aid int NOT NULL AUTO_INCREMENT PRIMARY KEY, type varchar(40), name varchar(40) DEFAULT unnamed, owner varchar(40), currentlevel int DEFAULT 0, totalclicks int DEFAULT 0, code varchar(15), imageurl varchar(120), usealternates varchar(10), tradestatus varchar(15), isfrozen varchar(10), gender varchar(10), offsprings int DEFAULT 0, lastbred int DEFAULT 0)";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}passwordresets (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, username varchar(20), email varchar(50), code varchar(70), ip varchar(30), date varchar(20))";
$adopts->query($query);


$query = "CREATE TABLE {$prefix}pounds (poid int NOT NULL AUTO_INCREMENT PRIMARY KEY, aid int DEFAULT 0 UNIQUE, firstowner varchar(40), lastowner varchar(40), currentowner varchar(25), recurrence int DEFAULT 0, datepound varchar(20), dateadopt varchar(20))";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}pound_settings (psid int NOT NULL AUTO_INCREMENT PRIMARY KEY, varname varchar(20), active varchar(10), value varchar(40), advanced varchar(40))";
$adopts->query($query);

$query = "INSERT INTO {$prefix}pound_settings VALUES (1, 'system', 'yes', '', '')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}pound_settings VALUES (2, 'adopt', 'yes', '', '')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}pound_settings VALUES (3, 'specieslimit', 'no', '', '')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}pound_settings VALUES (4, 'cost', 'yes', '50, 100', 'percent')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}pound_settings VALUES (5, 'levelbonus', 'yes', '1', 'multiply')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}pound_settings VALUES (6, 'number', 'yes', '4, 5', '')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}pound_settings VALUES (7, 'date', 'yes', '', '')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}pound_settings VALUES (8, 'duration', 'yes', '3', 'days')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}pound_settings VALUES (9, 'owner', 'yes', '', '')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}pound_settings VALUES (10, 'recurrence', 'yes', '5', '')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}pound_settings VALUES (11, 'rename', 'yes', '', '')";
$adopts->query($query);


$query = "CREATE TABLE {$prefix}promocodes (pid int NOT NULL AUTO_INCREMENT PRIMARY KEY, type varchar(20), user varchar(40), code varchar(200), availability int DEFAULT 0, fromdate varchar(20), todate varchar(20), reward varchar(40))";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}settings (name varchar(20), value varchar(350))";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}shops (sid int NOT NULL AUTO_INCREMENT PRIMARY KEY, category varchar(40), shopname varchar(40), shoptype varchar(20), description varchar(200), imageurl varchar(150), status varchar(40), restriction varchar(80), salestax int DEFAULT 0)";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}shoutbox (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, user varchar(50), date varchar(30), comment varchar(2500))";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}themes (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, themename varchar(150), themefolder varchar(200))";
$adopts->query($query);

$query = "INSERT INTO {$prefix}themes VALUES (1, 'Main', 'main')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}themes VALUES (2, 'Elements', 'elements')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}themes VALUES (3, 'Green', 'green')";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}trade (tid int NOT NULL AUTO_INCREMENT PRIMARY KEY, type varchar(15), sender varchar(40), recipient varchar(40), adoptoffered varchar(40), adoptwanted varchar(40), itemoffered varchar(40), itemwanted varchar(40), cashoffered int DEFAULT 0, message varchar(100), status varchar(20), date varchar(20))";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}trade_associations (taid int NOT NULL AUTO_INCREMENT PRIMARY KEY, publicid int DEFAULT 0, privateid int DEFAULT 0)";
$adopts->query($query);


$query = "CREATE TABLE {$prefix}trade_settings (tsid int NOT NULL AUTO_INCREMENT PRIMARY KEY, name varchar(20), value varchar(40))";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (1, 'system', 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (2, 'multiple', 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (3, 'partial', 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (4, 'public', 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (5, 'species', '')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (6, 'interval', 1)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (7, 'number', 3)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (8, 'duration', 5)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (9, 'tax', 300)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (10, 'usergroup', 'all')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (11, 'item', '')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (12, 'moderate', 'disabled')";
$adopts->query($query);


$query = "CREATE TABLE {$prefix}users (uid int NOT NULL AUTO_INCREMENT PRIMARY KEY, username varchar(20) UNIQUE, salt varchar(20), password varchar(200), session varchar(100), email varchar(60), ip varchar(60), usergroup int DEFAULT 0, birthday varchar(40), membersince varchar(20), money int DEFAULT 0, friends varchar(500))";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}users_contacts (uid int NOT NULL AUTO_INCREMENT PRIMARY KEY, username varchar(20) UNIQUE, website varchar(80), facebook varchar(80), twitter varchar(80),aim varchar(80), yahoo varchar(80), msn varchar(80), skype varchar(80))";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}users_options (uid int NOT NULL AUTO_INCREMENT PRIMARY KEY, username varchar(20) UNIQUE, newmessagenotify varchar(10), pmstatus int DEFAULT 0, vmstatus int DEFAULT 0, tradestatus int DEFAULT 0, theme varchar(20))";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}users_profile (uid int NOT NULL AUTO_INCREMENT PRIMARY KEY, username varchar(20) UNIQUE, avatar varchar(120), bio varchar(500), color varchar(20), about varchar(200), favpet int DEFAULT 0, gender varchar(10), nickname varchar(40))";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}users_status (uid int NOT NULL AUTO_INCREMENT PRIMARY KEY, username varchar(20) UNIQUE, canlevel varchar(10), canvm varchar(10), canfriend varchar(10), cantrade varchar(10), canbreed varchar(10), canpound varchar(10), canshop varchar(10))";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}visitor_messages (vid int NOT NULL AUTO_INCREMENT PRIMARY KEY, fromuser varchar(50), touser varchar(50), datesent varchar(25), vmtext varchar(500))";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}vote_voters (void int NOT NULL AUTO_INCREMENT PRIMARY KEY, date varchar(30), username varchar(50), ip varchar(50), adoptableid int DEFAULT 0)";
$adopts->query($query);


$query = "CREATE TABLE {$prefix}widgets (wid int NOT NULL AUTO_INCREMENT PRIMARY KEY, name varchar(40), controller varchar(20), `order` int DEFAULT 0, status varchar(20))";
$adopts->query($query);

$query = "INSERT INTO {$prefix}widgets VALUES (1, 'header', 'all', 0, 'enabled')"; 
$adopts->query($query);

$query = "INSERT INTO {$prefix}widgets VALUES (2, 'menu', 'main', 10, 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}widgets VALUES (3, 'document', 'all', 20, 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}widgets VALUES (4, 'sidebar', 'all', 30, 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}widgets VALUES (5, 'footer', 'all', 40, 'enabled')";
$adopts->query($query);


//Now we output a form so they can create an admin user...

echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'
'http://www.w3.org/TR/html4/loose.dtd'>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
<title>Mysidia Adoptables v1.3.4 Installation Wizard</title>
<style type='text/css'>
<!--
body,td,th {
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
body {
	background-color: #ffff00;
}
a:link {
	color: #000000;
}
a:visited {
	color: #000000;
}
a:hover {
	color: #000000;
}
a:active {
	color: #000000;
}
.style1 {
	font-size: 18px;
	color: #FFFFFF;
}
.style2 {font-size: 14px}
-->
</style></head>

<body>
<center><table width='750' border='0' cellpadding='0' cellspacing='0'>
  <!--DWLayoutTable-->
  <tr>
    <td width='750' height='57' valign='top' bgcolor='#FF3300'><div align='left'>
      <p><span class='style1'>Mysidia Adoptables v1.3.4 Installation Wizard <br>
        <span class='style2'>Step 4: Create Admin User </span></span></p>
    </div></td>
  </tr>
  <tr>
    <td height='643' valign='top' bgcolor='#FFFFFF'><p align='left'><br>
      <span class='style2'>This page allows you to set up an admin user account for your installation of Mysidia Adoptables. This account will allow you to administer your site in the built-in Admin CP.</span></p>
      <form name='form1' method='post' action='createadmin.php'>
        <p class='style2'>Admin Username: 
          <input name='username' type='text' id='username' maxlength='20'>
</p>
        <p class='style2'>The username may contain letters, numbers and spaces ONLY and can be up to 20 characters long. </p>
        <p class='style2'>Admin Password: 
          <input name='pass1' type='password' id='pass1'>
</p>
        <p><span class='style2'>The password may contain letters, numbers and special characters and can be up to 20 characters long.</span></p>
        <p><span class='style2'>Confirm Password: 
          <input name='pass2' type='password' id='pass2'>
</span></p>
        <p><span class='style2'>Admin Birthday:(mm/dd/yyyy) 
          <input name='birthday' type='text' id='birthday'>
</span></p>
        <p><span class='style2'>Admin Email Address: 
          <input name='email' type='text' id='email'>
</span></p>
        <p>
          <input type='submit' name='Submit' value='Submit and Continue Installation'>
</p>
        <p>&nbsp;</p>
      </form>      
      <p align='left'>&nbsp;</p>
      <p align='right'><br>
        </p></td>
  </tr>
</table>
</center>
</body>
</html>";


?>