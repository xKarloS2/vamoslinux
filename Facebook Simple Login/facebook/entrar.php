<?php
session_start();
require 'src/facebook.php';  // Incluyo el facebook SDK
require 'funciones.php';  
$facebook = new Facebook(array(
  'appId'  => '1556944497854173',   // App ID 
  'secret' => '19985572c444b60c76ccd26001fd2b87',  // App Secret :3
  'cookie' => true,	
));
$usuario = $facebook->getUser();

if ($usuario) {
  try {
            $user_profile = $facebook->api('/me');
  	    $fbid = $user_profile['id'];                 //Consigo la Facebook ID
 	    $fbusuario = $user_profile['username'];  // Consigo el nombre de usuario
 	    $fbnombre = $user_profile['name']; // Consigo el nombre completo
	    $femail = $user_profile['email'];    // Consigo el correo
	//    $_SESSION[''] = $fbid;           
	//    $_SESSION[''] = $fbusuario;
        //    $_SESSION[''] = $fbnombre;
	//    $_SESSION[''] =  $femail;

            comprobarbyks2($fbid,$fbusuario,$fbnombre,$femail);    // Envio los datos a funciones.php
  } catch (FacebookApiException $e) {
    error_log($e);
   $usuario = null;
  }
}
if ($usuario) {
	header('Location: /index.php');
} else {
 $enlacefacebook = $facebook->getLoginUrl(array(
		'scope'		=> 'email', // Que pedire a facebook
		));
 header('Location: '.$enlacefacebook);
}
?>