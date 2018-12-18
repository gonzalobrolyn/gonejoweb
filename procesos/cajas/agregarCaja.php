
<?php
  session_start();
  require_once "../../clases/Imagenes.php";
  require_once "../../clases/Cajas.php";

  $objImg = new imagenes();
  $objCaja = new cajas();

  $usuarioID = $_SESSION['usuarioID'];
  $cajaLlave = $_SESSION['cajaLlave'];
  $cajaID = $_SESSION['cajaID'];


  $datos = array(
    $_POST['codigo'],
    $cajaLlave);
  $validar = $objCaja->validaCodigo($datos);

  if ($validar == $cajaID) {

    $datosCaja = array();

    $archivo = $_FILES['logo']['name'];
    $rutaAlma = $_FILES['logo']['tmp_name'];
    $carpeta = '../../imagenes/';
    $rutaFinal = $carpeta.$archivo;

    $datosImg = array(
      $rutaFinal,
      $usuarioID);

    if (move_uploaded_file($rutaAlma, $rutaFinal)) {
      $imagenID = $objImg->guardaImagen($datosImg);

      if ($imagenID > 0) {
        $datosCaja[0] = $_POST['sede'];
        $datosCaja[1] = $_POST['direccion'];
        $datosCaja[2] = $_POST['ciudad'];
        $datosCaja[3] = $_POST['telefono'];
        $datosCaja[4] = $imagenID;
        $datosCaja[5] = $_POST['llave'];
        $datosCaja[6] = $_POST['efectivo'];
        $datosCaja[7] = $usuarioID;
        $datosCaja[8] = $validar;
        echo $objCaja->agregaCaja($datosCaja);
      } else {
        echo 0;
      }
    }
  } else {
    echo 0;
  }

?>
