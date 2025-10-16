<?php

    $account = trim($this->get_account('sammobile.com'));
	if (stristr($account,':')) list($user, $pass) = explode(':',$account);
	else $cookie = $account;
	if(empty($cookie)==false || ($user && $pass)){
     		for ($j=0; $j < 2; $j++){
			if(!$cookie) $cookie = $this->get_cookie("sammobile.com");
			if(!$cookie){
				$data = $this->curl_cloud("https://www.sammobile.com/login/?login", "", "action=sammobile_login&log=$user&pwd=$pass&rememberme=forever",'');
                $cookie = $this->GetAllCookies($data);
				$this->save_cookies('sammobile.com',$cookie);
			}
            $this->cookie = $cookie;	
		    $dat = $this->curl_cloud($url,$cookie,'','',0);
		      $link= $this->cut_str($this->cut_str($dat,'<a id="regular"','<a id="premium"'),'href="','"');
			  $link=str_replace('#','',$link);
              if($link ){
				$size_name = Tools_get::size_name($link, $cookie);
				$filesize = $size_name[0];
				$filename = $size_name[1];
				break;
				}elseif(strpos($dat,"File not found")){ die('<span class="list">Dead ❌ '.$url.' </span><span class="report"> ==► The firmware you were looking for could not be found</span><br>');}
                elseif(strpos($dat,"Archived firmware, premium users only")){ die('<span class="list">Dead ❌ '.$url.' </span><span class="report"> ==► Archived firmware, premium users only</span><br>');}
				elseif($dat==""){$cookie=""; $this->save_cookies('sammobile.com',$cookie);}
		}		
	}
	
	
?>