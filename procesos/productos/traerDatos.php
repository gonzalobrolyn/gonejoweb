
<?php
  require_once "../../clases/Productos.php";

  $obj= new productos();

  echo json_encode($obj->traeDatosProducto3($_POST['productoID']))
?>
