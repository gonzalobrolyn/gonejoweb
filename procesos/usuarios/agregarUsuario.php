
<?php
  session_start();
  require_once "../../clases/Personas.php";
	require_once "../../clases/Usuarios.php";

  $objPersona = new personas();
  $objUsuario = new usuarios();

  $cajaID = $_SESSION['cajaID'];
  $fecha = date('Y-m-d H:i:m');
  $datosPersona = array(
    $_POST['dni'],
    $_POST['nombre'],
    $_POST['apellido'],
    $_POST['celular']);
	$personaID = $objPersona->agregaPersona($datosPersona);
  if ($personaID > 0) {
    $datosUsuario = array(
      $_POST['usuario'],
      $_POST['clave'],
      $cajaID,
      $_POST['cargo'],
      $_POST['sueldo'],
      $_POST['diapago'],
      $fecha,
      $personaID);
    echo $objUsuario->agregaUsuario($datosUsuario);
  } else {
    echo 0;
  }
 ?>
