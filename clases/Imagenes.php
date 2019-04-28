
<?php
   require_once "Gonexion.php";

   class imagenes{

      public function guardaImagen($datos){
         $c = new conectar();
         $conexion = $c->conexion();

         $fechaLocal = time() - (7*60*60);
         $fechaAhora = date("Y-m-d H:i:s", $fechaLocal);

         $sqlPersona = "SELECT usuario_persona
                          from usuario
                         where usuario_id = '$datos[1]'";
         $consulta = mysqli_query($conexion, $sqlPersona);
         $resultadoPersona = mysqli_fetch_row($consulta)[0];

         $sql = "INSERT into imagen (
                             imagen_ruta,
                             imagen_fecha,
                             imagen_persona)
                     values ('$datos[0]',
                             '$fechaAhora',
                             '$resultadoPersona')";
         $result = mysqli_query($conexion, $sql);
         return mysqli_insert_id($conexion);
      }
   }
?>
