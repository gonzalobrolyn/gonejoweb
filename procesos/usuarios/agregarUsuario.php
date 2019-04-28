
<?php
  session_start();
  require_once "../../clases/Personas.php";
	require_once "../../clases/Usuarios.php";

  $objPersona = new personas();
  $objUsuario = new usuarios();

  $cajaID = $_SESSION['cajaID'];
  $fechaLocal = time() - (7*60*60);
  $fechaAhora = date("Y-m-d H:i:s", $fechaLocal);
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
      $fechaAhora,
      $personaID);
    echo $objUsuario->agregaUsuario($datosUsuario);
  } else {
    echo 0;
  }
 ?>
