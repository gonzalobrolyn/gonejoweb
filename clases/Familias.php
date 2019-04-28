
<?php
   require_once "Gonexion.php";

   class familias{

      public function guardaFamilia($datos){
         $c = new conectar();
         $conexion = $c->conexion();

         $fechaLocal = time() - (7*60*60);
         $fechaAhora = date("Y-m-d H:i:s", $fechaLocal);

         $sqlPersona = "SELECT usuario_persona
                          from usuario
                         where usuario_id = '$datos[1]'";
         $consulta = mysqli_query($conexion, $sqlPersona);
         $resultadoPersona = mysqli_fetch_row($consulta)[0];

         $sql = "INSERT into familia (
                             familia_nombre,
                             familia_fecha,
                             familia_persona)
                     values ('$datos[0]',
                             '$fechaAhora',
                             '$resultadoPersona')";
         return mysqli_query($conexion, $sql);
      }

		public function actualizaFamilia($datos){
			$c = new conectar();
			$conexion = $c->conexion();

         $fechaLocal = time() - (7*60*60);
         $fechaAhora = date("Y-m-d H:i:s", $fechaLocal);

         $sqlPersona = "SELECT usuario_persona
                          from usuario
                         where usuario_id = '$datos[2]'";
         $consulta = mysqli_query($conexion, $sqlPersona);
         $resultadoPersona = mysqli_fetch_row($consulta)[0];

			$sql = "UPDATE familia
                    set familia_nombre = '$datos[1]',
                        familia_fecha = '$fechaAhora',
                        familia_persona = '$resultadoPersona'
						where familia_id = '$datos[0]'";
			echo mysqli_query($conexion,$sql);
		}
  }
?>
