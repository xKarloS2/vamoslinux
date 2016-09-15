<?php
session_start();
require '../configuracion.php';

function comprobarbyks2($fbid,$fbusuario,$fbnombre,$femail){
global $by_xks2;
        $reviso = mysqli_query($by_xks2,"select ID_MEMBER from members where emailAddress='$femail'");
	$reviso = mysqli_num_rows($reviso);
        if (empty($reviso)) {
        $_SESSION['fbemail'] =  $femail;
        $_SESSION['contadorbykarlos'] = 0;

                die ("<script type='text/javascript'>alert('Por ahora tu correo de Facebook debe estar registrado en VamosLinux para loguearte usando Facebook!.');window.location.href='/';</script>"); 

	} else {  
	
       $random=substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 4)), 0, 4);
       $consultilla = "UPDATE members SET passwordSalt='$random', id_facebook='$fbid' where emailAddress='$femail'";
	mysqli_query($by_xks2,$consultilla);


$seleccionar = mysqli_query($by_xks2,"select ID_MEMBER, passwd, passwordSalt from members where emailAddress='$femail'") or die(mysqli_error());
if ($resultado = mysqli_fetch_assoc($seleccionar)) {
$id = $resultado['ID_MEMBER'];
$clv = $resultado['passwd'];
$cc= $random;
}


$data = serialize(empty($id) ? array(0, '', 0) : array($id, sha1($clv . $cc), time() + 31560000, 1));
setcookie('vamos_linux', $data, time() + 31560000, '/', 'www.vamoslinux.net', 0);

}

}
?>