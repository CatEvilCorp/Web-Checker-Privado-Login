<?php
session_start();
if(!isset($_SESSION['login'])) {
    header('LOCATION:login/login.php'); die();
} else {
}
if(isset($_POST['but_logout'])){



    session_destroy();
    header('Location: index.php');
}
 ?>
<!DOCTYPE html>
<html class="loading">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">    
    <title>𝑨 𝑹 𝑴 𝑿 ♫[𝙈𝙤𝙙𝙞𝙛𝙞𝙚𝙙]</title>
    <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/vendors.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/app-lite.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/core/colors/palette-gradient.css">
    	 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    	<style>
            @media (max-width: 767px) {
                .hidden-mobile {
                    display: none;
                }
            }
            footer {
            text-align: center;
            padding: 3px;
            background-color:#112132;;
            color: #ffffff;
            content-body {
background-color:#112132;
            
            }
            
            
            
            
            
        </style>
    	 
    	 
  </head>
  <body class="vertical-layout"; style="background-color:#112132;" > 
  <style>
  
  h5,h4{
			color:white;
		}
		.text-center{
			background-color:#0e1d2c;
			border:1px solid #525252;
			border-radius:5px;
		}
		textarea{
			color:white;
			resize: none;
		}
		.text-center::placeholder{
			color:grey;
		}
		.text-center:focus{
			background-color:#0e1d2c;
		}
		textarea::-webkit-scrollbar {
  			width: 5px;
 			background-color: #112132; 
		}
		textarea::-webkit-scrollbar-thumb {
 			border-radius: 10px;
  			background-color: #2e4964; 
		}
		.lista_reprovadass{
			color:#747474;
		}
		.card-body{
			background-color: #1c3044; 
			border-radius:5px;
		}
		.text-center{
			border:none;
		}
		.badge-success,.btn-success{
			background-color: #ffe74c;
			color:black	;
			border:none;
		}
		.btn-success:hover{
			background-color: #c9b63c;
			border:none;
			color:black;
			shadow:hidden;
		}
		.aprovadas{
			background-color: #35a7ff;
			color:black	;
		}
		.badge-danger{
			background-color: #ff5964;
			color:black	;
		}
		.html body .content .content-wrapper{
			background-color:#112132;
		}
		.btn-bg-gradient {
  			background-image: linear-gradient(to right, #FF8008 0%, #FFC837  51%, #FF8008  100%);
   			 margin: 5px;
			 width:49%;
    		padding: 12px 40px;
    		text-align: center;
    		text-transform: uppercase;
    		transition: 0.5s;
    		background-size: 200% auto;
    		color: white;            
    		box-shadow: 0 0 20px #eee;
    		border-radius: 5px;
    		display: block;
			-webkit-box-shadow: 0 0 0 0 #514a9d;
  		}
  		.btn-bg-gradient:hover {
   			background-position: right center; /* change the direction of the change here */
    		color: #fff;
    		text-decoration: none;
  		}
		  .btn-bg-gradient-x {
			background-image: linear-gradient(to right, #ee0979 0%, #ff6a00  51%, #ee0979  100%);
            margin: 5px;
            padding: 12px 45px;
			
            text-align: center;
            text-transform: uppercase;
            transition: 0.5s;
            background-size: 200% auto;
            color: white;            
            box-shadow: 0 0 20px #eee;
            border-radius: 5px;
            display: block;
			-webkit-box-shadow: 0 0 0 0 #514a9d;
  		}
  		.btn-bg-gradient-x:hover {
			background-position: right center; /* change the direction of the change here */
            color: #fff;
            text-decoration: none;
  		}
		  .statusbar{
			height:320px;
			padding-top:50px;
		  }
		  .hr-statusbar{
			border:none;
			height:1px;
			background-color:#3c5c7c;
		  }
		  
		  option { 
    /* Whatever color  you want */
    background-color: #112132;
	color: white;
	}
  
  </style>
  <div class="text-center" style="background-color:#112132;">
<h4 class="mb-2"><strong><marquee behavior="scroll" scrollamount="12" style="font-size: 1.8em;color: #ff0000;">𝑨 𝑹 𝑴 𝑿  &emsp;       𝑺 𝑻 𝑨 𝑹 ♫ </marquee></strong></h4>
<div class="form-group">
CHARGED: <span class="badge badge-success charge">0</span>
DEAD: <span class="badge badge-danger reprovadas"> 0</span>
TOTAL: <span class="badge badge-primary carregadas"> 0</span>
LIMIT: <span class="badge badge-secondary"> 500</span><br>
DATE: <span class="badge badge-dark" id="datetime">01/02/2022</span> •  TIME: <span class="badge badge-dark" id="timenow">12:00:00 AM</span>
</div>
	  </div>	
  
      <style>
.rainbow_text_animated {
    background: linear-gradient(to right, #6666ff, #0099ff , #00ff00, #ff3399, #6666ff);
    -webkit-background-clip: text;
    background-clip: text;
    font-size: 35px;
    font-family: 'kalam';
     
 
    color: transparent;
    animation: rainbow_animation 2s ease-in-out infinite;
    background-size: 400% 100%;
}
@keyframes rainbow_animation {
    0%,100% {
        background-position: 0 0;
    }
    50% {
        background-position: 100% 0;
    }
}
</style>
    <div class="app-content content"   style="display:block;">
      <div class="content-wrapper  style="background-color:#112132; ">
        <div class="content-wrapper-before mb-3">        	
        </div>        
  <div class="content-body">
  	<div class="mt-2"></div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body text-center">
					<h4 class="mb-2"><span class="badge badge-dark rainbow_text_animated "><strong>𝑨𝑹𝑴𝑿 𝑺𝑻𝑨𝑹 [𝙈𝙤𝙙𝙞𝙛𝙞𝙚𝙙]</strong></span></h4>
					<textarea rows="12" class="form-control text-center form-checker mb-2" placeholder="𝙋𝙐𝙏 𝙔𝙊𝙐𝙍 𝘾𝘼𝙍𝘿𝙎 𝙃𝙀𝙍𝙀"></textarea>
					<textarea rows="1" class="form-control text-center" style="width: 70%; float: left ;"  id="sec" placeholder="sk_live_xx𝙒𝙖𝙗𝙤𝙪xxx"></textarea>
					<textarea rows="1"class="form-control text-center" style="width: 30%; float: right margin-bottom: 5px;" id="cst" placeholder="𝘾𝙪𝙨𝙩𝙤𝙢 𝘼𝙢𝙤𝙪𝙣𝙩"></textarea></br>
					          <select name="gate" id="gate" class="form-control" style="margin-bottom: 5px;"
    <option </option>
	            
	            
				
				
				
				
				
				
				<option style="background:rgba(16, 15, 154, 0.281);color:rgb(255, 208, 0);color:white" value="gate/CVV.php">𝘾𝙑𝙑 𝘾𝙃𝘼𝙍𝙂𝙀: $1</option>
               
                <option style="background:rgba(16, 15, 154, 0.281);color:rgb(25, 208, 1);color:white" value="gate/CVV1.php">𝘾𝙑𝙑 𝘾𝙃𝘼𝙍𝙂𝙀: €1</option>
															   
                                <option style="background:rgba(16, 15, 154, 0.281);color:rgb(25, 208, 1);color:white" value="gate/AUTH.php">𝘾𝙃𝘼𝙍𝙂𝙀: €1</option>

             	
				
                
</select>
	<br>										
					<button class="btn btn-play btn-glow btn-bg-gradient-x-blue-cyan text-white" style="width: 49%; float: left;"><i class="fa fa-play"></i>START</button>
					<button class="btn btn-stop btn-glow btn-bg-gradient-x-red-pink text-white" style="width: 49%; float: right;" disabled><i class="fa fa-stop"></i>STOP</button>
				
			</div>
		</div>
<div class="col-md-12">
  <div class="card mb-2">
  	<div class="card-body">
<center>
<button class="btn btn-glow btn-bg-gradient-x-blue-cyan text-white" onclick="window.open('https://t.me/RX_TW')" style="width: 100%;">𝑻𝑯𝑬 𝑫𝑬𝑽 𓁻</button>
                                <hr>
<h5>‎𝗧𝗢𝗧𝗔𝗟 :<span class="badge badge-dark float-right carregadas">0</span></h5><hr>
<h5> 𝗖𝗛𝗔𝗥𝗚𝗘𝗗 :<span class="badge badge-success float-right charge">0</span></h5><hr>
<h5> ‎ 𝗖𝗩𝗩 :<span class="badge badge-info float-right cvvs">0</span></h5><hr>
<h5>  𝗖𝗖𝗡 :<span class="badge badge-primary float-right aprovadas">0</span></h5><hr>
<h5> 𝗗𝗘𝗔𝗗 :<span class="badge badge-danger float-right reprovadas">0</span></h5><hr>
<h5>LIMIT CHECK :<span class="badge badge-secondary float-right">500 CC</span></h5>
</center>
<center>
        <div class="card mb-2">
                            <div class="card-body">
<style>
.text-center{
text-align: center;
justify-content: center;
position: relative;
}
</style>
                            
                                </div>
                        </div>
                    </div>
                  </div> 
                </div>
              </div>
            		<div class="col-xl-12">
			<div class="card">
				<div class="card-body">
					<div class="float-right">
						<button type="show" class="btn btn-primary btn-sm show-charge"><i class="fa fa-eye-slash"></i></button>
					<button class="btn btn-success btn-sm btn-copy1"><i class="fa fa-copy"></i></button>					
					</div>
					
					<center>
					
					<h4 class="card-title mb-1"><i class="fa fa-check-circle text-success"></i> CHARGED</h4>					
			<div id='lista_charge'></div>
				</div>				
			</div>
		</div>
		            		<div class="col-xl-12">
			<div class="card">
				<div class="card-body">
					<div class="float-right">
						<button type="show" class="btn btn-primary btn-sm show-live"><i class="fa fa-eye-slash"></i></button>
					<button class="btn btn-success btn-sm btn-copy2"><i class="fa fa-copy"></i></button>					
					</div>
					
					<center>
					
					<h4 class="card-title mb-1"><i class="fa fa-check text-success"></i> Cvvs</h4>					
			<div id='lista_cvvs'></div>
				</div>				
			</div>
		</div>
		<div class="col-xl-12">
			<div class="card">
				<div class="card-body">
					<div class="float-right">
						<button type="show" class="btn btn-primary btn-sm show-lives"><i class="fa fa-eye-slash"></i></button>
					<button class="btn btn-success btn-sm btn-copy"><i class="fa fa-copy"></i></button>					
					</div>
					
					<center>
					
					<h4 class="card-title mb-1"><i class="fa fa-times text-success"></i> CCN</h4>					
			<div id='lista_aprovadas'></div>
				</div>				
			</div>
		</div>
		<div class="col-xl-12">
			<div class="card">
				<div class="card-body">
					<div class="float-right">
						<button type='hidden' class="btn btn-primary btn-sm show-dies"><i class="fa fa-eye"></i></button>
					<button class="btn btn-danger btn-sm btn-trash"><i class="fa fa-trash"></i></button>					
					</div>
					
					<center>
					
					<h4 class="card-title mb-1"><i class="fa fa-times text-danger"></i> DECLINED</h4>		
						<div style='display: none;' id='lista_reprovadas'></div>
				</div>				
			</div>
		</div>
		
</section>
        </div>
      </div>
    </div>
 
    <script src="theme-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
    
    
<footer>
  <p> <b><div class=text-danger> 𝙈𝙤𝙙𝙞𝙛𝙞𝙚𝙙 By <a href="https://t.me/RX_TW">𝑨𝑹𝑴𝑿 𝑺𝑻𝑨𝑹</b></a></div></p>
</footer>
<style>
</style>
<script>
$(document).ready(function(){
const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger'
  },
  buttonsStyling: false
})
    
$('.show-charge').click(function(){
var type = $('.show-charge').attr('type');
$('#lista_charge').slideToggle();
if(type == 'show'){
$('.show-charge').html('<i class="fa fa-eye"></i>');
$('.show-charge').attr('type', 'hidden');
}else{
$('.show-charge').html('<i class="fa fa-eye-slash"></i>');
$('.show-charge').attr('type', 'show');
}});
$('.show-live').click(function(){
var type = $('.show-live').attr('type');
$('#lista_cvvs').slideToggle();
if(type == 'show'){
$('.show-live').html('<i class="fa fa-eye"></i>');
$('.show-live').attr('type', 'hidden');
}else{
$('.show-live').html('<i class="fa fa-eye-slash"></i>');
$('.show-live').attr('type', 'show');
}});
$('.show-lives').click(function(){
var type = $('.show-lives').attr('type');
$('#lista_aprovadas').slideToggle();
if(type == 'show'){
$('.show-lives').html('<i class="fa fa-eye"></i>');
$('.show-lives').attr('type', 'hidden');
}else{
$('.show-lives').html('<i class="fa fa-eye-slash"></i>');
$('.show-lives').attr('type', 'show');
}});
$('.show-dies').click(function(){
var type = $('.show-dies').attr('type');
$('#lista_reprovadas').slideToggle();
if(type == 'show'){
$('.show-dies').html('<i class="fa fa-eye"></i>');
$('.show-dies').attr('type', 'hidden');
}else{
$('.show-dies').html('<i class="fa fa-eye-slash"></i>');
$('.show-dies').attr('type', 'show');
}});
$('.btn-trash').click(function(){
	Swal.fire({title: 'REMOVED DEAD', icon: 'success', showConfirmButton: false, toast: true, position: 'top-end', timer: 3000});
$('#lista_reprovadas').text('');
});
$('.btn-copy1').click(function(){
	Swal.fire({title: 'COPIED CHARGED', icon: 'success', showConfirmButton: false, toast: true, position: 'top-end', timer: 3000});
var lista_charge = document.getElementById('lista_charge').innerText;
var textarea = document.createElement("textarea");
textarea.value = lista_charge;
document.body.appendChild(textarea); 
textarea.select(); 
document.execCommand('copy');           document.body.removeChild(textarea); 
});
$('.btn-copy2').click(function(){
	Swal.fire({title: 'COPIED CVV', icon: 'success', showConfirmButton: false, toast: true, position: 'top-end', timer: 3000});
var lista_live = document.getElementById('lista_cvvs').innerText;
var textarea = document.createElement("textarea");
textarea.value = lista_live;
document.body.appendChild(textarea); 
textarea.select(); 
document.execCommand('copy');           document.body.removeChild(textarea); 
});
$('.btn-copy').click(function(){
	Swal.fire({title: 'COPIED CCN', icon: 'success', showConfirmButton: false, toast: true, position: 'top-end', timer: 3000});
var lista_lives = document.getElementById('lista_aprovadas').innerText;
var textarea = document.createElement("textarea");
textarea.value = lista_lives;
document.body.appendChild(textarea); 
textarea.select(); 
document.execCommand('copy');           document.body.removeChild(textarea); 
});
$('.btn-play').click(function(){
var sec = $("#sec").val();
var cst = $("#cst").val();
var e = document.getElementById("gate");
var gate = e.options[e.selectedIndex].value;
var lista = $('.form-checker').val().trim();
var array = lista.split('\n');
var charge = 0, live = 0, lives = 0, dies = 0, testadas = 0, txt = '';
if(!lista){
	Swal.fire({title: 'You did not provide a card :(', icon: 'error', showConfirmButton: false, toast: true, position: 'top-end', timer: 3000});
	return false;
}
Swal.fire({title: 'Your cards are being checked...', icon: 'success', showConfirmButton: false, toast: true, position: 'top-end', timer: 3000});
var line = array.filter(function(value){
if(value.trim() !== ""){
	txt += value.trim() + '\n';
	return value.trim();
}
});
/*
var line = array.filter(function(value){
return(value.trim() !== "");
});
*/
var total = line.length;
/*
line.forEach(function(value){
txt += value + '\n';
});
*/
$('.form-checker').val(txt.trim());
// ảo ma hả, đừng lấy code chứ !!
if(total > 100000000){
  Swal.fire({title: 'YOU CAN NOT PERFORM THAT ACTION: REDUCE NUMBER OF CARDS TO <4999', icon: 'warning', showConfirmButton: false, toast: true, position: 'top-end', timer: 3000});
  return false;
}
$('.carregadas').text(total);
$('.btn-play').attr('disabled', true);
$('.btn-stop').attr('disabled', false);
line.forEach(function(data){
var callBack = $.ajax({
	url: gate + '?lista=' + data + '&sec=' + sec + '&cst=' + cst,
	success: function(retorno){
		if(retorno.indexOf("CHARGED") >= 0){
			$('#lista_charge').append(retorno);
			removelinha();
			charge = charge +1;
			}
			else if(retorno.indexOf("CVV") >= 0){
			$('#lista_cvvs').append(retorno);
			removelinha();
			live = live +1;
		    }
			else if(retorno.indexOf("CCN") >= 0){
			$('#lista_aprovadas').append(retorno);
			removelinha();
			lives = lives +1;
		    }else{
			$('#lista_reprovadas').append(retorno);
			removelinha();
			dies = dies +1;
		}
		testadas = charge + live + lives + dies;
	    $('.charge').text(charge);
	    $('.cvvs').text(live);
		$('.aprovadas').text(lives);
		$('.reprovadas').text(dies);
		$('.testadas').text(testadas);
		
		if(testadas == total){
			Swal.fire({title: 'ALL CARDS HAS BEEN CHECKED', icon: 'success', showConfirmButton: false, toast: true, position: 'top-end', timer: 3000});
			$('.btn-play').attr('disabled', false);
			$('.btn-stop').attr('disabled', true);
		}
        }
      });
      $('.btn-stop').click(function(){
      Swal.fire({title: 'PAUSED', icon: 'warning', showConfirmButton: false, toast: true, position: 'top-end', timer: 3000});
      $('.btn-play').attr('disabled', false);
      $('.btn-stop').attr('disabled', true);      
      	callBack.abort();
      	return false;
      });
    });
  });
});
function removelinha() {
var lines = $('.form-checker').val().split('\n');
lines.splice(0, 1);
$('.form-checker').val(lines.join("\n"));
}
var myVar=setInterval(function(){myTimer()},1000);
function myTimer() {
	var dt = new Date();
	document.getElementById("datetime").innerHTML = dt.toLocaleDateString();
    var d = new Date();
    document.getElementById("timenow").innerHTML = d.toLocaleTimeString();
}
	
</script>
  </body>
</html>
