<?php

/*
/@======@@======@@=@@=@@===@@=====@@======@@@@@@==@@====@@=@@=@@@@@@@@====@@============@/
/@======@@=@===@@@=@@=@@=@@======@@@@====@@=====@=@@====@@=@@====@@======@@@@===========@/
/@======@@==@=@=@@=@@=@@@@======@@==@@==@@========@@@@@@@@=@@====@@=====@@==@@==========@/
/@======@@===@==@@=@@=@@=@@====@@=@@=@@==@@@@@@@==@@@@@@@@=@@====@@====@@=@@=@@=========@/
/@======@@======@@=@@=@@==@@===@@====@@=@======@@=@@====@@=@@====@@====@@====@@=========@/
/@======@@======@@=@@=@@===@@==@@====@@==@@@@@@@==@@====@@=@@====@@====@@====@@=========@/
*/

/*=========================================================================*/
error_reporting(0);
ini_set('display_errors', 0);

/*=========================================================================*/

/*=========================================================================*/
$start_time = microtime(true);
$lista = $_GET['lista'];
$gateway = "STRIPE AUTH";
/*=========================================================================*/

/*=========================================================================*/
$functions = new Functions();
if($functions->hasaccess() === false){$functions->redirect_location();}
$httpheaders = $functions->httpheaders();
if (empty($httpheaders['sec'])) {die('where is the key?<br>');} 
$zmikashita = new ZMikashita();
$secret_key = $httpheaders['sec'];
/*=========================================================================*/

/*=========================================================================*/
$i = explode("|", $lista);
$cc = isset($i[0]) ? $i[0] : null;
$mm = isset($i[1]) ? $i[1] : null;
$yyyy = isset($i[2]) ? $i[2] : null;
if(strlen($yyyy) == 2){
	$yyyy = "20".$yyyy;
}
$yy = substr($yyyy, 2, 4);
$cvv = isset($i[3]) ? $i[3] : null;
$bin = substr($cc, 0, 6);
$last4 = substr($cc, 12, 16);
$email = $functions->emailGenerate();
$m = ltrim($mm, "0");
/*=========================================================================*/

/*=========================================================================*/
if($cc == null || $mm == null || $yyyy==null || $cvv==null)
{
   $end_time = microtime(true);
   $execution_time = $end_time - $start_time;
   $execution_time = number_format($execution_time, 2);
   echo '<span><i class="fa fa-times" aria-hidden="true"></i>DEAD</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: Invalid Card.</span><br>Time Taken: '.$execution_time.'s<br><br>';
   exit();
}
/*=========================================================================*/

/*=========================================================================*/
$lookup = new BinLookup();
$cc_country = $lookup->issuingCountry();
$cc_bname = $lookup->issuingBank();
$cc_type0 = $lookup->cardType();
$cc_type1 = $lookup->cardSubType();
$cc_type2 = $lookup->cardCategory();
$binlookup = "BIN INFO: $cc_type0 - $cc_type1 - $cc_type2<br>BANK: $cc_bname<br>COUNTRY: $cc_country";
/*=========================================================================*/

/*=========================================================================*/
$identity = new GenerateIdentity('au');
$name_first = $identity->first_name();
$name_last =  $identity->last_name();
$name_full = "$name_first $name_last";
$location_street = $identity->location_street();
$location_city = $identity->location_city();
$location_postcode = $identity->location_postcode();
$location_state =$identity->location_state_iso();
/*=========================================================================*/

$item_descriptions = array(
  1 => 'Cablecar Ticket',
  2 => 'Apartment Reservation Ticket',
  3 => 'Entrance Reservation Ticket',
  4 => 'Ski Reservation Ticket',
  5 => 'Gears Reservation Ticket'
    ); 
$item_description = $item_descriptions[array_rand($item_descriptions)];
/*=========================================================================*/

/*=========================================================================*/
$retry_count = 0;
/*=========================================================================*/

/*=========================================================================*/
while(true){
	$curl_1 = curl_init();
	curl_setopt($curl_1, CURLOPT_CONNECTTIMEOUT,15);
	curl_setopt($curl_1, CURLOPT_URL, 'https://api.stripe.com/v1/tokens');
	curl_setopt($curl_1, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl_1, CURLOPT_POSTFIELDS, 'card[number]='.$cc.'&card[exp_month]='.$mm.'&card[exp_year]='.$yyyy.'&card[cvc]='.$cvv.'&card[name]='.$name_first.'+'.$name_last.'&card[address_line1]='.$location_street.'&card[address_city]='.$location_city.'&card[address_state]='.$location_state.'&card[address_zip]='.$location_postcode.'&card[address_country]='.$location_country);
	curl_setopt($curl_1, CURLOPT_USERPWD, $secret_key. ':' . '');
	$headers = array();
	$headers[] = 'Content-Type: application/x-www-form-urlencoded';
	curl_setopt($curl_1, CURLOPT_HTTPHEADER, $headers);
	$curl_1_exec = curl_exec($curl_1);
	curl_close($curl_1);
	if (strpos($curl_1_exec, "rate_limit"))   
	{  
		$retry_count++;  
		continue;  
	}  
	break; 
}
$result_1 = json_decode($curl_1_exec, true);
/*=========================================================================*/

/*=========================================================================*/
if(isset($result_1['error'])){
	$code = $result_1['error']['code'];
	$decline_code = $result_1['error']['decline_code'];
	$message = $result_1['error']['message'];
	if(isset($result_1['error']['decline_code'])){
		$codex = $decline_code;
	}else{
		$codex = $code;
	}
	
	$err = ''.$result_1['error']['message'].' [ '.strtoupper($codex).' ]';
	if($code == "incorrect_cvc"||$decline_code == "incorrect_cvc"){
		$end_time = microtime(true);
		$execution_time = $end_time - $start_time;
		$execution_time = number_format($execution_time, 2);
		echo '<span><i class="fa fa-check" aria-hidden="true"></i>CCN LIVE</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: '.$err.'.</span><br>RETRY: [ '.$retry_count.' ]<br>'.$binlookup.'<br>Time Taken: '.$execution_time.'s<br><br>';
	}elseif($code == "insufficient_funds"||$decline_code == "insufficient_funds"){
		$end_time = microtime(true);
		$execution_time = $end_time - $start_time;
		$execution_time = number_format($execution_time, 2);
        echo '<span><i class="fa fa-check" aria-hidden="true"></i>CVV LIVE</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: '.$err.'.</span><br>RETRY: [ '.$retry_count.' ]<br>'.$binlookup.'<br>Time Taken: '.$execution_time.'s<br><br>';
	}elseif($code == "testmode_charges_only"||$decline_code == "testmode_charges_only"){
		$end_time = microtime(true);
		$execution_time = $end_time - $start_time;
		$execution_time = number_format($execution_time, 2);
		echo '<span><i class="fa fa-times" aria-hidden="true"></i>DEAD</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: TestMode Charges. [ SK ERROR ][ DEAD SK ].</span><br>RETRY: [ '.$retry_count.' ]<br>'.$binlookup.'<br>Time Taken: '.$execution_time.'s<br><br>';
	}elseif(strpos($curl_1_exec, 'Sending credit card numbers directly to the Stripe API is generally unsafe.')) {
		$end_time = microtime(true);
		$execution_time = $end_time - $start_time;
		$execution_time = number_format($execution_time, 2);
		echo '<span><i class="fa fa-times" aria-hidden="true"></i>DEAD</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: Integration Error. [ SK ERROR ].</span><br>RETRY: [ '.$retry_count.' ]<br>'.$binlookup.'<br>Time Taken: '.$execution_time.'s<br><br>';
	}elseif(strpos($curl_1_exec, "You must verify a phone number on your Stripe account before you can send raw credit card numbers to the Stripe API.")){
		$end_time = microtime(true);
		$execution_time = $end_time - $start_time;
		$execution_time = number_format($execution_time, 2);
		echo '<span><i class="fa fa-times" aria-hidden="true"></i>DEAD</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: Verify Phone Number. [ SK ERROR ].</span><br>RETRY: [ '.$retry_count.' ]<br>'.$binlookup.'<br>Time Taken: '.$execution_time.'s<br><br>';
	}else{
		$end_time = microtime(true);
		$execution_time = $end_time - $start_time;
		$execution_time = number_format($execution_time, 2);
		echo '<span><i class="fa fa-times" aria-hidden="true"></i>DEAD</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: '.$err.'</span><br>RETRY: [ '.$retry_count.' ]<br>'.$binlookup.'<br>Time Taken: '.$execution_time.'s<br><br>';
	}
	exit();
}
/*=========================================================================*/

/*=========================================================================*/
if(!isset($result_1['id'])){
    $end_time = microtime(true);
    $execution_time = $end_time - $start_time;
    $execution_time = number_format($execution_time, 2);
    die('<span><i class="fa fa-times" aria-hidden="true"></i>DEAD</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: Client not found</span><br>RETRY: [ '.$retry_count.' ]<br>'.$binlookup.'<br>Time Taken: '.$execution_time.'s<br><br>');
}
if(!isset($result_1['card']['id'])){
    $end_time = microtime(true);
    $execution_time = $end_time - $start_time;
    $execution_time = number_format($execution_time, 2);
    die('<span><i class="fa fa-times" aria-hidden="true"></i>DEAD</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: Client not found</span><br>RETRY: [ '.$retry_count.' ]<br>'.$binlookup.'<br>Time Taken: '.$execution_time.'s<br><br>');
}
/*=========================================================================*/

/*=========================================================================*/
$src_id = $result_1["id"];
/*=========================================================================*/

/*=========================================================================*/
while(true){
	$curl_2 = curl_init();
	curl_setopt($curl_2, CURLOPT_URL, 'https://api.stripe.com/v1/customers');
	curl_setopt($curl_2, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl_2, CURLOPT_POST, 1);
	curl_setopt($curl_2, CURLOPT_POSTFIELDS, 'name='.$name_first.'+'.$name_last.'&email='.$email.'&description='.$item_description.'&source='.$src_id.'&address[line1]='.$location_street.'&address[city]='.$location_city.'&address[state]='.$location_state.'&address[postal_code]='.$location_postcode.'&address[country]='.$location_country);
	curl_setopt($curl_2, CURLOPT_USERPWD, $secret_key . ':' . '');
	$headers = array();
	$headers[] = 'Content-Type: application/x-www-form-urlencoded';
	curl_setopt($curl_2, CURLOPT_HTTPHEADER, $headers);
	$curl_2_exec = curl_exec($curl_2);
	curl_close($curl_2);
	if (strpos($curl_2_exec, "rate_limit"))   
	{  
		$retry_count++;  
		continue;  
	}  
	break; 
}
$result_2 = json_decode($curl_2_exec, true);
/*=========================================================================*/


/*=========================================================================*/
if (isset($result_2['error'])) {
		//DEAD
	$code = $result_2['error']['code'];
	$decline_code = $result_2['error']['decline_code'];
	$message = $result_2['error']['message'];
	if(isset($result_2['error']['decline_code'])){
		$codex = $decline_code;
	}else{
		$codex = $code;
	}
	$err = ''.$result_2['error']['message'].' [ '.strtoupper($codex).' ]';
	if($code == "incorrect_cvc"||$decline_code == "incorrect_cvc"){
		$end_time = microtime(true);
		$execution_time = $end_time - $start_time;
		$execution_time = number_format($execution_time, 2);
		echo '<span><i class="fa fa-check" aria-hidden="true"></i>CCN LIVE</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: '.$err.'.</span><br>RETRY: [ '.$retry_count.' ]<br>'.$binlookup.'<br>Time Taken: '.$execution_time.'s<br><br>';
	}elseif($code == "insufficient_funds"||$decline_code == "insufficient_funds"){
		$end_time = microtime(true);
		$execution_time = $end_time - $start_time;
		$execution_time = number_format($execution_time, 2);
		echo '<span><i class="fa fa-check" aria-hidden="true"></i>CVV LIVE</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: '.$err.'.</span><br>RETRY: [ '.$retry_count.' ]<br>'.$binlookup.'<br>Time Taken: '.$execution_time.'s<br><br>';
	}elseif($code == "testmode_charges_only"||$decline_code == "testmode_charges_only"){
		$end_time = microtime(true);
		$execution_time = $end_time - $start_time;
		$execution_time = number_format($execution_time, 2);
		echo '<span><i class="fa fa-times" aria-hidden="true"></i>DEAD</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: TestMode Charges. [ SK ERROR ][ DEAD SK ].</span><br>RETRY: [ '.$retry_count.' ]<br>'.$binlookup.'<br>Time Taken: '.$execution_time.'s<br><br>';
	}elseif(strpos($curl_2_exec, 'Sending credit card numbers directly to the Stripe API is generally unsafe.')) {
		$end_time = microtime(true);
		$execution_time = $end_time - $start_time;
		$execution_time = number_format($execution_time, 2);
		echo '<span><i class="fa fa-times" aria-hidden="true"></i>DEAD</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: Integration Error. [ SK ERROR ].</span><br>RETRY: [ '.$retry_count.' ]<br>'.$binlookup.'<br>Time Taken: '.$execution_time.'s<br><br>';
	}elseif(strpos($curl_2_exec, "You must verify a phone number on your Stripe account before you can send raw credit card numbers to the Stripe API.")){
		$end_time = microtime(true);
		$execution_time = $end_time - $start_time;
		$execution_time = number_format($execution_time, 2);
		echo '<span><i class="fa fa-times" aria-hidden="true"></i>DEAD</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: Verify Phone Number. [ SK ERROR ].</span><br>RETRY: [ '.$retry_count.' ]<br>'.$binlookup.'<br>Time Taken: '.$execution_time.'s<br><br>';
	}else{
		$end_time = microtime(true);
		$execution_time = $end_time - $start_time;
		$execution_time = number_format($execution_time, 2);
		echo '<span><i class="fa fa-times" aria-hidden="true"></i>DEAD</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: '.$err.'</span><br>RETRY: [ '.$retry_count.' ]<br>'.$binlookup.'<br>Time Taken: '.$execution_time.'s<br><br>';
	}
	exit();
}
/*=========================================================================*/

/*=========================================================================*/
if (isset($result_2['sources'])) {
	$cvc_result_2 = $result_2['sources']['data'][0]['cvc_check'];
	if($cvc_result_2 == "pass"||$cvc_result_2 == "success"){
		$end_time = microtime(true);
		$execution_time = $end_time - $start_time;
		$execution_time = number_format($execution_time, 2);
		echo '<span><i class="fa fa-check" aria-hidden="true"></i>CVV LIVE</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: [ CVC_CHECK ][ '.strtoupper($cvc_result_2).' ]</span><br>RETRY: [ '.$retry_count.' ]<br>'.$binlookup.'<br>Time Taken: '.$execution_time.'s<br><br>';
	}else{
		$end_time = microtime(true);
		$execution_time = $end_time - $start_time;
		$execution_time = number_format($execution_time, 2);
		echo '<span><i class="fa fa-times" aria-hidden="true"></i>DEAD</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: [ CVC_CHECK ][ '.strtoupper($cvc_result_2).' ]</span><br>RETRY: [ '.$retry_count.' ]<br>'.$binlookup.'<br>Time Taken: '.$execution_time.'s<br><br>';
	}
	exit();
}
if(!isset($result_2['id'])){
	$end_time = microtime(true);
    $execution_time = $end_time - $start_time;
    $execution_time = number_format($execution_time, 2);
    die('<span><i class="fa fa-times" aria-hidden="true"></i>DEAD</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: Client not found</span><br>RETRY: [ '.$retry_count.' ]<br>'.$binlookup.'<br>Time Taken: '.$execution_time.'s<br><br>');
}
/*=========================================================================*/

/*=========================================================================*/
$customer_ID = $result_2['id'];
$card_ID = $result_1['card']['id'];
/*=========================================================================*/

/*=========================================================================*/
while(true){
	$curl_3 = curl_init();
	curl_setopt($curl_3, CURLOPT_CONNECTTIMEOUT,15);
		
	curl_setopt($curl_3, CURLOPT_URL, 'https://api.stripe.com/v1/customers/'.$customer_ID.'/sources/'.$card_ID);
	curl_setopt($curl_3, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl_3, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($curl_3, CURLOPT_USERPWD, $secret_key . ':' . '');
	$headers = array();
	$headers[] = 'Content-Type: application/x-www-form-urlencoded';
	curl_setopt($curl_3, CURLOPT_HTTPHEADER, $headers);
	$curl_3_exec = curl_exec($curl_3);
	curl_close($curl_3);
	if (strpos($curl_3_exec, "rate_limit"))   
	{  
		$retry_count++;  
		continue;  
	}  
	break; 
}
$result_3 = json_decode($curl_3_exec, true);
/*=========================================================================*/

/*=========================================================================*/
if(!isset($result_3['id'])){
	$end_time = microtime(true);
    $execution_time = $end_time - $start_time;
    $execution_time = number_format($execution_time, 2);
    die('<span><i class="fa fa-times" aria-hidden="true"></i>DEAD</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: Client not found</span><br>RETRY: [ '.$retry_count.' ]<br>'.$binlookup.'<br>Time Taken: '.$execution_time.'s<br><br>');
}
/*=========================================================================*/

/*=========================================================================*/
$cvc_result_3 = $result_3['cvc_check'];
/*=========================================================================*/

/*=========================================================================*/
if($cvc_result_3 == "pass"||$cvc_result_3 == "success"){
	$end_time = microtime(true);
	$execution_time = $end_time - $start_time;
	$execution_time = number_format($execution_time, 2);
	echo '<span><i class="fa fa-check" aria-hidden="true"></i>CVV LIVE</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: [ CVC_CHECK ][ '.strtoupper($cvc_result_3).' ]</span><br>RETRY: [ '.$retry_count.' ]<br>'.$binlookup.'<br>Time Taken: '.$execution_time.'s<br><br>';
}else{
	$end_time = microtime(true);
	$execution_time = $end_time - $start_time;
	$execution_time = number_format($execution_time, 2);
	echo '<span><i class="fa fa-times" aria-hidden="true"></i>DEAD</span>  <span>:  '.$lista.'</span>  <br>GATEWAY: '.$gateway.' <br>RESULT: [ CVC_CHECK ][ '.strtoupper($cvc_result_3).' ]</span><br>RETRY: [ '.$retry_count.' ]<br>'.$binlookup.'<br>Time Taken: '.$execution_time.'s<br><br>';
}
/*=========================================================================*/
?>