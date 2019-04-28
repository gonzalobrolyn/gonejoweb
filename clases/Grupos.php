
<?php
   require_once "Gonexion.php";

   class grupos{

      public function guardaGrupo($datos){
         $c = new conectar();
         $conexion = $c->conexion();

         $fechaLocal = time() - (7*60*60);
         $fechaAhora = date("Y-m-d H:i:s", $fechaLocal);

         $sqlPersona = "SELECT usuario_persona
                          from usuario
                         where usuario_id = '$datos[2]'";
         $consulta = mysqli_query($conexion, $sqlPersona);
         $resultadoPersona = mysqli_fetch_row($consulta)[0];

         $sql = "INSERT into grupo (
                             grupo_nombre,
                             grupo_familia,
                             grupo_fecha,
                             grupo_persona)
                     values ('$datos[0]',
                             '$datos[1]',
                             '$fechaAhora',
                             '$resultadoPersona')";
         return mysqli_query($conexion, $sql);
      }

		public function actualizaGrupo($datos){
			$c = new conectar();
			$conexion = $c->conexion();

         $fechaLocal = time() - (7*60*60);
         $fechaAhora = date("Y-m-d H:i:s", $fechaLocal);

         $sqlPersona = "SELECT usuario_persona
                          from usuario
                         where usuario_id = '$datos[2]'";
         $consulta = mysqli_query($conexion, $sqlPersona);
         $resultadoPersona = mysqli_fetch_row($consulta)[0];

			$sql = "UPDATE grupo
                    set grupo_nombre = '$datos[1]',
                        grupo_fecha = '$fechaAhora',
                        grupo_persona = '$resultadoPersona'
						where grupo_id = '$datos[0]'";
			echo mysqli_query($conexion,$sql);
		}

  }
?>
