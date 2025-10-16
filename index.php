<?php
ob_start();
error_reporting (E_ALL);
ob_implicit_flush (TRUE);
ignore_user_abort (0);
if( !ini_get('safe_mode') ){
            set_time_limit(0);
} 
define('vinaget', 'yes');
include("class.php");
$obj = new stream_get(); 

if ($obj->Deny == false && isset($_POST['urllist'])) $obj->main();
elseif(isset($_GET['infosv'])) $obj->notice();
############################################### Begin Secure ###############################################
elseif($obj->Deny == false) {
	if (!isset($_POST['urllist'])) {
		include ("hosts/hosts.php");
		asort($host);
?>
<!DOCTYPE html>
   <html>
       <head>
			<link rel="SHORTCUT ICON" href="images/vngicon.png" type="image/x-icon" />
			<title><?php printf($obj->lang['title'],$obj->lang['version']); ?></title>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<meta name="keywords" content="<?php printf($obj->lang['version']); ?>, bywarrior code" />
			<link href="rl_style_pm.css?v=3.08" rel="stylesheet">
			<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
			<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
            

		</head>
		<body>
			<script type="text/javascript" language="javascript" src="images/jquery-1.7.1.min.js"></script>
			<script type="text/javascript" src="images/ZeroClipboard.js"></script>
			<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
			<script type="text/javascript" language="javascript">			
				var title = '<?php echo $obj->title; ?>';
				var colorname = '<?php echo $obj->colorfn; ?>';
				var colorfile = '<?php echo $obj->colorfs; ?>';

				var more_acc ='<?php printf($obj->lang["moreacc"]); ?>';
				var less_acc ='<?php printf($obj->lang["lessacc"]); ?>';
				var d_error ='<?php printf($obj->lang["invalid"]); ?>';
				var d_succ1 ='<?php printf($obj->lang["dsuccess"]); ?>';
				var d_succ2 ='<?php printf($obj->lang["success"]); ?>';
				var get_loading ='<?php printf($obj->lang["getloading"]); ?>';
				var notf ='<?php printf($obj->lang["notfound"]); ?>';
			</script> 
			<!--
			<center><img src="images/logo.png" alt="RapidLeech PlugMod" border="0" /></center><br />
			-->
			<div id="showlistlink" class="showlistlink" align="center">
				<div style="border:1px #ffffff solid; width:960px; padding:5px; margin-top:50px;">
					<div id="listlinks"><textarea style='width:950px;height:400px' id="textarea"></textarea></div>
					<table style='width:950px;'><tr>
					<td width="50%" vAlign="left" align="left">	
					<input type='button' value="bbcode" onclick="return bbcode('list');" />
					<input type='button' id ='SelectAll' value="Select All"/>
					<input type='button' id="copytext" value="Copy To Clipboard"/>
					
					</td>
					<td id="report"  width="50%" align="center"></td>
					</tr></table>
				</div>
				<div style="width:120px; padding:5px; margin:2px;border:1px #ffffff solid;">
					<a onclick="return makelist(document.getElementById('showresults').innerHTML);" href="javascript:void(0)" style='TEXT-DECORATION: none'><font color=#FF6600>Click to close</font></a>
				</div>
			</div>
			<table align="center"><tbody>
				<tr>
				<!-- ########################## Begin Plugins ########################## -->
				<td valign="top">
					<table width="100%"  border="0">
						<tr><td valign="top">
							<table border="0" cellpadding="0" cellspacing="0">
								<tr><td width="140" height="100%"><div class="cell-plugin"><?php printf($obj->lang['plugins']); ?></div></td></tr>
								<tr><td><div align="center" class="plugincolhd"><b><small><?php echo count($host);?></small></b> <?php printf($obj->lang['plugins']); ?></div></td></tr>
								<tr><td height="100%" style="padding:3px;">
									<div dir="rtl" align="left" style="overflow-y:scroll; height:150px; padding-left:5px;">
									<?php
										foreach ($host as $file => $site){
											$site = substr($site,0,-4);
											$site = str_replace("_",".",$site) ;
											echo "<span class='plugincollst'>" .$site."</span><br />";
										}
									?>
									</div><br />
									<div class="cell-plugin"><?php printf($obj->lang['premium']); ?></div>
									<table border="0">
										<tr><td height="100%" style="padding:3px;">
											<div dir="rtl" align="left" style="padding-left:5px;">
												<?php $obj->showplugin(); ?>
											</div>
										</td></tr>
									</table><br />
								</td></tr>
							</table>
						</td></tr>
					</table>
				</td>
				<!-- ########################## End Plugins ########################## -->
				<!-- ########################## Begin Main ########################### -->
				<td align="center" valign="top">
					<table border="0" cellpadding="0" cellspacing="1"><tbody>
						<tr>
							<td class="cell-nav"><a class="ServerFiles" href="./"><?php printf($obj->lang['main']); ?></a></td>
							<td class="cell-nav"><a class="ServerFiles" href="./?id=donate"><?php printf($obj->lang['donate']); ?></a></td>
							<td class="cell-nav"><a class="ServerFiles" href="./?id=listfile"><?php printf($obj->lang['listfile']); ?></a></td>
							<td class="cell-nav"><a class="ServerFiles" href="./?id=check"><?php printf($obj->lang['check']); ?></a></td>
							<?php if ($obj->Secure == true) 
							echo '<td class="cell-nav"><a class="ServerFiles" href="./login.php?go=logout"> '.$obj->lang['log'].'</a></td>'; ?>
						</tr>
					</tbody></table>
					<table id="tb_content"><tbody>
						<tr><td height="5px"></td></tr>
						<tr><td align="center">
<?php 
						#---------------------------- begin list file ----------------------------#
						if ((isset($_GET['id']) && $_GET['id']=='listfile') || isset($_POST['listfile']) || isset($_POST['option']) || isset($_POST['renn']) || isset($_POST['remove']))  {
							if($obj->listfile==true)$obj->fulllist();
							else echo "<BR><BR><font color=red size=2>".$obj->lang['notaccess']."</b></font>";
						}
						#---------------------------- end list file ----------------------------#

						#---------------------------- begin donate  ----------------------------#
						else if (isset($_GET['id']) && $_GET['id']=='donate') { 
?>
							<div align="center">
								<div id="wait"><?php printf($obj->lang['donations']); ?></div><BR>
								<form action="javascript:donate(document.getElementById('donateform'));" name="donateform" id="donateform">
									<table>
										<tr>
											<td>
												<?php printf($obj->lang['acctype']); ?> 
												<select name='type' id='type'>
													<option value="bitshare">bitshare.com</option>
													<option value="rapidshare">rapidshare.com</option>
													<option value="hotfile">hotfile.com</option>
													<option value="depositfiles">depositfiles.com</option>
													<option value="oron">oron.com</option>
													<option value="uploading">uploading.com</option>
													<option value="uploaded">uploaded.to</option>
												</select>
											</td>
											<td>
												&nbsp; &nbsp; &nbsp; <input type="text" name="accounts" id="accounts" value="" size="50" maxlength="50"><br />
											</td>
											<td>&nbsp; &nbsp; &nbsp; <input type=submit value="<?php printf($obj->lang['sbdonate']); ?>">
											</td>
										</tr>
									</table>
								</form>
								<div id="check"><font color=#FF6600>user:pass</font> or <font color=#FF6600>cookie</font></div>
							</div>
<?php					
						}
						#---------------------------- end donate  ----------------------------#

						#---------------------------- begin check  ---------------------------#
						else if (isset($_GET['id']) && $_GET['id']=='check'){
							if($obj->checkacc==true) include("checkaccount.php");
							else echo "<BR><BR><font color=red size=2>".$obj->lang['notaccess']."</b></font>";
						}
						#---------------------------- end check  ------------------------------#

						#---------------------------- begin get  ------------------------------#
						else {
?>
<audio id="audio"><source src="images/lives.mp3" type="audio/mp3"></audio>
<audio id="end"><source src="images/end.mp3" type="audio/mp3"></audio>
<audio id="unk"><source src="images/unknow.mp3" type="audio/mp3"></audio>
							<!-- <form action="javascript:get(document.getElementById('linkform'));" name="linkform" id="linkform"> -->
								<?php printf($obj->lang['welcome'],$obj->lang['homepage']); ?><br/><font face=Arial size=1><?php printf($obj->lang['maxline']); ?></font><BR>
								<textarea id='lista' style='width:550px;height:100px; resize:none' onkeyup="contar_total(this);" name='links' placeholder="PUT YOUR SHIT HERE!!!"></textarea>
								<textarea id='proxy' name='proxy' onkeyup="contar_proxy(this);" placeholder='xxx.xxx.xxx.xxx:xxx' title='Proxy:Port' style='width:144px;height:100px; resize:none'></textarea><BR>
								<span id="status" class="label label-primary">Checker Waiting!</span><br><BR> 	 
								<center>
                                    <div>
                                       Live: </font><span id="live_conta" class="label label-success">0</span>
									   Dead: </font><span id="dead_conta" class="label label-danger">0</span>
									   Unknow: </font><span id="unknow_conta" class="label label-unknow">0</span>
                                        Checked:  <span id="testado" class="label label-info">0</span>
                                        All: <span id="tudo_conta" class="label label-default">0</span>
                                     </div>
                                </center><br>
								<input type="checkbox" name="autopost" id="autopost" onclick="auto_post()"><i class="fa fa-commenting fa-2x fa-fw"" aria-hidden="true"></i>&nbsp;
								<input type="checkbox" name="autofile" id="autofile" onclick="auto_file()"><i class="fa fa-telegram fa-2x fa-fw"" aria-hidden="true"></i>&nbsp;
								<input type="checkbox" name="antiduplicate" id="antiduplicate" checked>&nbsp;Anti-duplicate&nbsp;&nbsp;&nbsp;
								<input type="checkbox" name="controlck" id="controlck" onclick="control_check()">&nbsp;Control batch&nbsp;&nbsp;&nbsp;
								<input type="checkbox" name="autoreset" id="autoreset" checked>&nbsp;Auto reset&nbsp;&nbsp;&nbsp;<br><br>
								<input type="submit"  id ='iniciar' value='<?php printf($obj->lang['sbdown']); ?>' style='height:22px; width:65px'/>&nbsp;&nbsp;&nbsp;
								<input type="button" onclick="reseturl();return false;" value="Reset">&nbsp;&nbsp;&nbsp;
							<!-- </form> --> <BR>
<?php						
						}
						#---------------------------- end get  ------------------------------#
?>                         <div id="autop" style="overflow: hidden; display: none;">
							<br>
                            <table style="width: 400px; border-collapse: collapse" border="1" align="center">
                            <tbody><tr><td><br>
                            <center>&nbsp;
                           Chat <!--<input type="text" name="idchat" id="idchat" value="-771790507">-->
						   <select name="idchat" id="idchat">
						   <option value="1416120977">Geramel</option>						   
						   <option value="7379498421">Victor</option>
						   <option value="6694564926">Bywarrior</option>
						   <option value="1570206512">Leti</option>
						   <option value="1016493217">Win</option>
						   <option value="5794755769">Antonio</option>
						   <option value="5831510241">MBernal</option>
                           </select>
						   &nbsp;Id <input type="text" name="bot" id="bot" size="8">
						   &nbsp;Mess <input type="text" name="text" id="text" size="20">
						   <!--<input type="button" onclick="send_tg_mess();return false;" value="Send">-->
						   <br><br>
                           </center>
                           </td></tr></tbody>
                           </table>
                           </div>                      

							<BR>
							
						<div id="autofil" style="overflow: hidden; display: none;">
							<br>
                            <table style="width: 400px; border-collapse: collapse" border="1" align="center">
                            <tbody><tr><td><br>
                            <center>&nbsp;
                           Chat <!--<input type="text" name="idchat" id="idchat" value="-771790507">-->
						   <select name="IdChat" id="IdChat">
						   <option value="1416120977">Geramel</option>
						   <option value="7379498421">Victor</option>
						   <option value="6694564926">Bywarrior</option>
						   <option value="1570206512">Leti</option>
						   <option value="1016493217">Win</option>
						   <option value="5794755769">Antonio</option>
						   <option value="5831510241">MBernal</option>
                           </select>
						   &nbsp;Id <input type="text" name="Bot" id="Bot" size="8">
						   <br><br>
                           </center>
                           </td></tr></tbody>
                           </table>
                           </div> 
						   
							<BR>
							
							<div id="dlhere" align="left" style="overflow: hidden; display: none;">
								<BR><hr /><small style="color:#55bbff"><?php printf($obj->lang['dlhere']); ?></small>
								<div align="right">
								<b><a id="lab_liv" href="javascript:void(0)" style='TEXT-DECORATION: none'><font color=#FF6600>Live </font></a>&nbsp;&nbsp;&nbsp;
								<a id="lab_die" href="javascript:void(0)" style='TEXT-DECORATION: none'><font color=#FF6600>Dead </font></a>&nbsp;&nbsp;&nbsp;
								<a id="lab_unk" href="javascript:void(0)" style='TEXT-DECORATION: none'><font color=#FF6600>Unknow </font></a>&nbsp;&nbsp;&nbsp;</b>
								</div>
							</div>
							
					</td></tr>
					</tbody></table>
				</td></tr>
				<!-- ########################## End Main ########################### -->
			</tbody></table>

						<div class="row" id="liv" style="overflow: hidden; display: none;">
                            <div class="form">
                                <div class="table2">
                                    <div class="td11">
                                       &nbsp;  Live &nbsp;
                                        <span id="live_conta_1" class="label label-success">0</span>
                                        <span style="float: right;">
                                           <button onclick="stfil()" ttype="button" class="button-auto"><font class="fdown"><i class="fa fa-telegram"></i> Send</font></button><button onclick="selectText('lives')" ttype="button" class="button-auto"><font class="fdown"><i class="fa fa-copy"></i> Copy</font></button> <button id="btn-descargar" type="button" class="button-auto"><font class="fdown"><i class="fa fa-download"></i> Download</font></button>&nbsp;&nbsp;&nbsp;
                                        </span>
                                    </div>
                                    <div  class="panel-body2">
                                        <small><div id="lives"></div></small><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row"  id="dea" style="overflow: hidden; display: none;">
                            <div class="form">
                                <div class="table2">
                                    <div class="td11">
                                       &nbsp;  Dead &nbsp;
                                        <span id="dead_conta_2" class="label label-danger">0</span>
                                    </div>
                                    <div  class="panel-body3">
                                       <!-- <div id="deads"> -->
										<small><div id="deads"></div></small><br>
                                    </div>
                                </div>
                            </div>
                        </div>
		                  <div class="row"  id="unkk" style="overflow: hidden; display: none;">
                            <div class="form">
                                <div class="table2">
                                    <div class="td11">
                                       &nbsp;  Unknow &nbsp;
                                        <span id="unknow_conta_3" class="label label-unknow">0</span>
                                        <span style="float: right;">
                                            <button type="button" class="btne btn-outline-dark" id="btn_unknow"><font color="black"><i class="fa fa-minus"></i>Hide</font></button> &nbsp;
                                        </span>
                                    </div>
                                    <div  class="panel-body3">
                                        <div id="unknow"></div><br>
                                    </div>
                                </div>
                            </div>
                        </div>
						<br>
						
			<table width="60%" align="center" cellpadding="0" cellspacing="0">
				<tr><td>
					<div align="center" style="color:#ccc">
						<!-- Start Server Info -->
							<hr />
						<div id="server_stats">
							<?php echo $obj->notice();?>
						</div>
						<!-- End Server Info -->
						<hr />
						
					<!--	<script type="text/javascript" language="javascript" src="ajax.js?ver=1.0"></script> -->
					<script>document.write("<script type='text/javascript' language='javascript' src='ajax.js?v=" + Date.now() + "'><\/script>");</script>
					
					<!-- Copyright please don't remove-->
						<div class="powered">
								Based on <a href='https://code.google.com/archive/p/vinaget-script/downloads'><?php printf($obj->lang['version']); ?> Revision 97</a> by ..:: [H] ::..<br/>
								Developed bywarrior. Find me on <a target='_blank' href='https://web.facebook.com/bywarriormx/'>Facebook</a>Current version: 72
						</div>
						<div class="copyright">Copyright 2009-<?php echo date('Y');?> by <a href='http://vinaget.us/'>http://vinaget.us</a>. All rights reserved.</div>
					<!-- Copyright please don't remove-->
					
					</div>
				</td></tr>
			</table>	
			
        <script type="text/javascript">

                                                function selectText(containerid) {
                                                    if (document.selection) {
                                                        var range = document.body.createTextRange();
                                                        range.moveToElementText(document.getElementById(containerid));
                                                        range.select();
                                                    } else if (window.getSelection()) {
                                                        var range = document.createRange();
                                                        range.selectNode(document.getElementById(containerid));
                                                        window.getSelection().removeAllRanges();
                                                        window.getSelection().addRange(range);
													    window.getSelection();
                                                         document.execCommand("copy");
                                                    }
                                                }
												
												
function enviarDocumentoTelegram(token, chatId) {
  var contenido = 'helloworld bro';

  // Crear archivo temporal
  var archivoTemporal = new Blob([contenido], { type: 'text/plain' });
  var formData = new FormData();
  formData.append('document', archivoTemporal, 'myfile.txt');

  $.ajax({
    url: 'https://api.telegram.org/bot' + token + '/sendDocument?chat_id=' + chatId,
    method: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function(data) {
      console.log('Documento enviado con éxito');
    },
    error: function(xhr, status, error) {
      console.log('Error al enviar el documento: ' + error);
    }
  });
}
        </script>			
		</body>
	</html>

<?php
	} #(!$_POST['urllist'])
} 
############################################### End Secure ###############################################
else {
?>
<!--
* Home page: http://vinaget.us
* Blog:	http://blog.vinaget.us
* Script Name: Vinaget 
* Version: 2.6.3 (Mod)
* Description: 
	- You can now download files with full resume support from filehosts using download managers like IDM etc
	- Vinaget is a Free Open Source, supported by a growing community.
* Code LeechViet by VinhNhaTrang
* Developed by ..:: [H] ::..
* Updated: Saturday, January 05, 2013
-->
	<html>
	<head>
	<meta http-equiv="Content-Language" content="en-us">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<META NAME="ROBOTS" CONTENT="NOINDEX,FOLLOW" />
	<META NAME="GOOGLEBOT" CONTENT="NOINDEX,FOLLOW" />
	<META NAME="SLURP" CONTENT="NOINDEX,FOLLOW" />
	<link rel="shortcut icon" type="image/x-icon" href="images/login.ico"/>
	<link title="Rapidleech Style" href="images/login.css" rel="stylesheet" type="text/css" />
	<title>Login - <?php printf($obj->lang['title'],$obj->lang['version']); ?></title>
	</head>

	<body>
		<!-- main -->
		<div align="center">
			<div><a><img src="images/logo.png" alt="vinaget.us" align="center"></a></div>
			<div align="center" id="loginform">
				<form method="POST" action="login.php">
				<font face="Arial" color='#FFFFFF'><b><?php printf($obj->lang['login']); ?></b></font>
				<table border="0" width="500" height="32" align="center" >
					<tr>
						<td height="28" width="108">
							<font face="Bookman Old Style" color="#CCCCCC"><b><?php printf($obj->lang['password']); ?></b></font>
						</td>
						<td height="28" width="316"><input type="password" name="secure" size="44"></td>
						<td height="28" width="56"><input type="submit" value="Submit" name="submit" class="submit"></td>
					</tr>
				</table>
				</form>
			</div>
		<!-- /main -->

					<!-- Copyright please don't remove-->
						<div class="powered">
								Based on <a href='https://code.google.com/archive/p/vinaget-script/downloads'><?php printf($obj->lang['version']); ?> Revision 97</a> by ..:: [H] ::..<br/>
								Developed bywarrior. Find me on <a target='_blank' href='https://web.facebook.com/bywarriormx/'>Facebook</a>Current version: 72
						</div>
						<div class="copyright">Copyright 2009-<?php echo date('Y');?> by <a href='http://vinaget.us/'>http://vinaget.us</a>. All rights reserved.</div>
					<!-- Copyright please don't remove-->
					
					
		</div>
	</body>
	</html>
<?php
}
ob_end_flush();
?>