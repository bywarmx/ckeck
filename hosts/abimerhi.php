<?php
if (preg_match('#^abimerhi\|#', $url)){
	if (isset($_POST['proxy'])) $proxy=$_POST['proxy'];
	if (!isset($_POST['proxy'])) $proxy=false;
$separar = explode("|", $url);

$tiket = $separar[1];
$monto = $separar[2];	
$es = $separar[3];

     	$cookie='';
		for ($j=0; $j < 2; $j++){
           $post="{ rfc: 'APU640930KV9', ticket: '$es-$tiket', amount: $monto, consumptionId: '', invoicingReference: '' }";		
		      $dat = $this->curl('https://www.abimerhigasolineras.com/facturacion/Home/FindTicketAndClientData', '', $post, $proxy,0,1,1);				
				$dat = preg_replace("/[\r\n|\n|\r]+/", "", $dat);			
			     if (!$dat) die('<span class="list">Dead ❌ '.$tiket.'|'.$monto.' </span><span class="report"> ==► The plugin failed to connect! '.$proxy.'</span><br>');
				 $mess = trim(strip_tags($this->cut_str($dat,'"message":"','"')));
				 if($mess =='') {
					 $enlace = "https://abimerhi.byw.workers.dev/".$tiket."_".$monto."_".$es;
	                die('<span class="list"> Live  ✅ '.$tiket.'|  </span><span class="mfname">'.$monto.'</span> | <span class="mfnam">'.$es.'</span> | <span class="mfsize"> '.$separar[4].'  | <span class="mflink"><a href="'.$enlace.'"  target="_blank">'.$enlace.'</a> </span>  '.$proxy.'</span><br>');
                 }else{
			
	                die('<span class="list">Dead ❌ '.$tiket.' </span><span class="report"> ==►  '.$mess.' '.$proxy.'</span><br>');
                  }
			  }
			 die('<span class="list">Dead ❌ '.$tiket.' | </span><span class="report"> ==►  Error Fixing :s '.$proxy.'</span><br>');
			  
}
?>