
<?php
  require_once "Gonexion.php";
  class cajas{

    public function creaCodigo($datos){
      $c = new conectar();
      $conexion = $c->conexion();
      $sql = "INSERT into caja(
                          caja_codigo,
                          caja_llave,
                          caja_usuario)
                  values ('$datos[0]',
                          '$datos[1]',
                          '$datos[2]')";
      return mysqli_query($conexion, $sql);
    }

    public function validaCodigo($datos){
      $c = new conectar();
      $conexion = $c->conexion();
      $sql = "SELECT caja_id
                from caja
               where caja_codigo = '$datos[0]'
                 and caja_llave = '$datos[1]'
                 and caja_usuario = '1'";
      $result = mysqli_query($conexion, $sql);
      return mysqli_fetch_row($result)[0];
    }

    public function agregaCaja($datos){
      $c = new conectar();
      $conexion = $c->conexion();
      $fechaLocal = time() - (7*60*60);
      $fechaAhora = date("Y-m-d H:i:s", $fechaLocal);
      $llave = sha1($datos[4]);
      $sql = "UPDATE caja
                 set caja_sede = '$datos[0]',
                     caja_direccion = '$datos[1]',
                     caja_telefono = '$datos[2]',
                     caja_logo = '$datos[3]',
                     caja_llave = '$llave',
                     caja_efectivo = '$datos[5]',
                     caja_fecha = '$fechaAhora',
                     caja_usuario = '$datos[6]'
               where caja_id = '$datos[7]'";
      return mysqli_query($conexion, $sql);
    }

    public function cierraCajaDiario($datos){
      $c = new conectar();
      $conexion = $c->conexion();
      $cuenta = 0;
      $fechaLocal = time() - (7*60*60);
      $fechaAhora = date("Y-m-d H:i:s", $fechaLocal);

      $sqlSuma = "SELECT movimiento_nombre,
                         movimiento_efectivo
                    from movimiento
                   where movimiento_estado = '0'
                     and movimiento_caja = '$datos[2]'";
      $querySuma = mysqli_query($conexion, $sqlSuma);
      while ($monto = mysqli_fetch_row($querySuma)) {
         if ($monto[0] == "Gasto") {
            $cuenta = $cuenta - $monto[1];
         } else {
            $cuenta = $cuenta + $monto[1];
         }
      }
      if ($cuenta > 0) {
         $sqlPersona = "SELECT usuario_persona
                          from usuario
                         where usuario_id = '$datos[1]'";
         $consultaP = mysqli_query($conexion, $sqlPersona);
         $idPersona = mysqli_fetch_row($consultaP)[0];

         $sqlEfectivo = "SELECT caja_efectivo
                           from caja
                          where caja_id = '$datos[2]'";
         $consulta = mysqli_query($conexion, $sqlEfectivo);
         $efectivoCaja = mysqli_fetch_row($consulta)[0];
         $nuevoEfe = $efectivoCaja + $cuenta;

         $sqlMovimi = "INSERT into movimi(
                                   movimi_nombre,
                                   movimi_efectivo,
                                   movimi_monto,
                                   movimi_nuevoefe,
                                   movimi_fecha,
                                   movimi_persona_usu,
                                   movimi_caja)
                           values ('$datos[0]',
                                   '$efectivoCaja',
                                   '$cuenta',
                                   '$nuevoEfe',
                                   '$fechaAhora',
                                   '$idPersona',
                                   '$datos[2]')";
         $queryMovimi = mysqli_query($conexion, $sqlMovimi);

         if ($queryMovimi > 0) {
            $sqlMovi = "UPDATE movimiento
                           set movimiento_estado = '1'
                         where movimiento_estado = '0'
                           and movimiento_caja = '$datos[2]'";
            $queryMovi = mysqli_query($conexion, $sqlMovi);

            if ($queryMovi > 0) {
               $sqlCaja = "UPDATE caja
                              set caja_efectivo = '$nuevoEfe'
                            where caja_id = '$datos[2]'";
               return mysqli_query($conexion, $sqlCaja);
            } else {
               return 0;
            }
         } else {
            return 0;
         }
      } else {
         return 0;
      }
   }

   public function ingresaCapital($datos){
      $c = new conectar();
      $conexion = $c->conexion();
      $fechaLocal = time() - (7*60*60);
      $fechaAhora = date("Y-m-d H:i:s", $fechaLocal);

      $sqlPersona = "SELECT usuario_persona
                       from usuario
                      where usuario_id = '$datos[2]'";
      $consultaP = mysqli_query($conexion, $sqlPersona);
      $idPersona = mysqli_fetch_row($consultaP)[0];

      $sqlEfectivo = "SELECT caja_efectivo
                        from caja
                       where caja_id = '$datos[3]'";
      $consulta = mysqli_query($conexion, $sqlEfectivo);
      $efectivoCaja = mysqli_fetch_row($consulta)[0];
      $nuevoEfe = $efectivoCaja + $datos[1];

      $sqlMovimi = "INSERT into movimi(
                                movimi_nombre,
                                movimi_efectivo,
                                movimi_monto,
                                movimi_nuevoefe,
                                movimi_detalle,
                                movimi_fecha,
                                movimi_persona_usu,
                                movimi_caja)
                        values ('$datos[0]',
                                '$efectivoCaja',
                                '$datos[1]',
                                '$nuevoEfe',
                                '$datos[4]',
                                '$fechaAhora',
                                '$idPersona',
                                '$datos[3]')";
      $queryMovimi = mysqli_query($conexion, $sqlMovimi);
      if ($queryMovimi > 0) {
         $sqlCaja = "UPDATE caja
                        set caja_efectivo = '$nuevoEfe'
                      where caja_id = '$datos[3]'";
         return mysqli_query($conexion, $sqlCaja);
      } else {
         return 0;
      }
   }

   public function egresaCapital($datos){
      $c = new conectar();
      $conexion = $c->conexion();
      $fechaLocal = time() - (7*60*60);
      $fechaAhora = date("Y-m-d H:i:s", $fechaLocal);

      $sqlPersona = "SELECT usuario_persona
                       from usuario
                      where usuario_id = '$datos[2]'";
      $consultaP = mysqli_query($conexion, $sqlPersona);
      $idPersona = mysqli_fetch_row($consultaP)[0];

      $sqlEfectivo = "SELECT caja_efectivo
                        from caja
                       where caja_id = '$datos[3]'";
      $consulta = mysqli_query($conexion, $sqlEfectivo);
      $efectivoCaja = mysqli_fetch_row($consulta)[0];
      $nuevoEfe = $efectivoCaja - $datos[1];

      $sqlMovimi = "INSERT into movimi(
                                movimi_nombre,
                                movimi_efectivo,
                                movimi_monto,
                                movimi_nuevoefe,
                                movimi_detalle,
                                movimi_fecha,
                                movimi_persona_usu,
                                movimi_caja)
                        values ('$datos[0]',
                                '$efectivoCaja',
                                '$datos[1]',
                                '$nuevoEfe',
                                '$datos[4]',
                                '$fechaAhora',
                                '$idPersona',
                                '$datos[3]')";
      $queryMovimi = mysqli_query($conexion, $sqlMovimi);
      if ($queryMovimi > 0) {
         $sqlCaja = "UPDATE caja
                        set caja_efectivo = '$nuevoEfe'
                      where caja_id = '$datos[3]'";
         return mysqli_query($conexion, $sqlCaja);
      } else {
         return 0;
      }
   }

  }
?>
