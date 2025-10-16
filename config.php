<?php
$Secure = true;			#true : private host - false : public host
$password= array(
"bywarrior"					# pass1
,"@leti_"					# pass2
,"frank"					# pass3
); 

$homepage = "bywarrior.net";
$fileinfo_dir = 'data';		# name folder data
$fileinfo_ext = "dat";		# type file data
$filecookie ="cookie.php";	# file cookie

$download_prefix = "Bywarrior_";
$limitMBIP = 1024*1024;	# limit load file for 1 IP (MB)
$ttl = 60*60;				# time to live (in minutes)
$limitPERIP = 800000;		# (files) limit file per mins
$ttl_ip = 8000;			#  (minutes) limit load file per time
$max_jobs_per_ip = 6500000;	//total jobs for 1 IP  per time live
$max_jobs = 500000;			# max total jobs in this host   
$max_load = 500000;			# max server load (%)

$title = "Download"; # Example: [color=blue]http://vinaleeech.com[/color]
$colorfilename = "green";
$colorfilesize = "red";

$ziplink = false; # enable/disable zip link
$apiadf = "http://api.adf.ly/api.php?key=e8a4819f311e0914ef394c38ff474127&uid=23888439&advert_type=int&domain=q.gs&url=";       # Adfly api
$tg_bot = "5901274026:AAEneQJ9yUo0CbIc1m80RP_Rw7Fka24bGmo";       # Telegram bot
$listfile = true;		# enable/disable all user can see list files.
$privatefile = false;	# enable/disable other people can see your file in the list files
$privateip = false;		# enable/disable other people can download your file.
$checkacc = true;		# enable/disable all user can use check account.
$checklinksex =  false;	# enable/disable check link 3x,porn...
$direct = true;	#enable/disable get Direct link
$bbcode = false;	#enable/disable bbcode

$modvnl = false;		# enable/disable login host for mod vinaleech
$debrid = false;	#enable/disable get link with debrid plugin
$plugin = 'real-debrid_com.php';	# file plugin

$action = array(		# action with file in server files, set to true to enable, set to false to disable
'rename' => true,
'delete' => true,
);

# List of Bad Words, you can add more
$badword = array("porn","jav ", "Uncensored","xxx japan", "tora.tora", "tora-tora", "SkyAngle", "Sky_Angel", "Sky.Angel", "Incest","fuck", "Virgin", "PLAYBOY", "Adult", "tokyo hot", "Gangbang", "BDSM", "Hentai", "lauxanh", "homosexual", "bitch" , "Torture", "Nurse", "dâm đãng", "cực dâm", "phim cấp 3", "phim 18+", " Hentai", "Sex Videos", "Adult", "Adult XXX", "XXX movies", "Free Sex", "hardcore", "rape", "jav4u", "javbox", "jav4you", "akiba-online.com","JAVbest.ORG","X-JAV","cnnwe.com","J4v.Us","J4v.Us","teendaythi.com","entnt.com","khikhicuoi","sex-scandal.us","hotavxxx.com"); 


require_once ('languages.php');
?>