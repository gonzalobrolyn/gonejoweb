
<?php
   require_once "Gonexion.php";

   class ventas{

      public function registraAdelanto($datos){
        $c = new conectar();
        $conexion = $c->conexion();

        $sqlPersona = "SELECT usuario_persona
                         from usuario
                        where usuario_id = '$datos[6]'";
        $consulta = mysqli_query($conexion, $sqlPersona);
        $idPersona = mysqli_fetch_row($consulta)[0];

        $sqlEfectivo = "SELECT caja_efectivo
                          from caja
                         where caja_id = '$datos[7]'";
        $consulta = mysqli_query($conexion, $sqlEfectivo);
        $efectivoCaja = mysqli_fetch_row($consulta)[0];
        $nuevoEfe = $efectivoCaja + $datos[2];

        $sqlMov = "INSERT into movimiento (
                            movimiento_nombre,
                            movimiento_persona,
                            movimiento_efectivo,
                            movimiento_monto,
                            movimiento_nuevoefe,
                            movimiento_comprobante,
                            movimiento_detalle,
                            movimiento_fecha,
                            movimiento_persona_usu,
                            movimiento_caja)
                    values ('$datos[0]',
                            '$datos[1]',
                            '$efectivoCaja',
                            '$datos[2]',
                            '$nuevoEfe',
                            '$datos[3]',
                            '$datos[4]',
                            '$datos[5]',
                            '$idPersona',
                            '$datos[7]')";
        $deposito = mysqli_query($conexion, $sqlMov);
        if ($deposito > 0) {
          $sqlCaja = "UPDATE caja
                         set caja_efectivo = '$nuevoEfe'
                       where caja_id = '$datos[7]'";
          return mysqli_query($conexion, $sqlCaja);
        } else {
          return 0;
        }
      }

      public function crearVenta($movi){
         $c = new conectar();
         $conexion = $c->conexion();

         $fechaLocal = time() - (7*60*60);
         $fechaAhora = date("Y-m-d H:i:s", $fechaLocal);
         $idUsuario = $_SESSION['usuarioID'];
         $idCaja = $_SESSION['cajaID'];
         $datoso = $_SESSION['listaVentaTmp'];
         $r = 0;

         $sqlPersona = "SELECT usuario_persona
                          from usuario
                         where usuario_id = '$idUsuario'";
         $consultaP = mysqli_query($conexion, $sqlPersona);
         $idPersona = mysqli_fetch_row($consultaP)[0];

         $sqlMov = "INSERT into movimiento (
                                movimiento_nombre,
                                movimiento_persona,
                                movimiento_efectivo,
                                movimiento_fecha,
                                movimiento_persona_usu,
                                movimiento_caja)
                        values ('$movi[0]',
                                '$movi[1]',
                                '$movi[2]',
                                '$fechaAhora',
                                '$idPersona',
                                '$idCaja')";
         $resVenta = mysqli_query($conexion, $sqlMov);
         $idMovi = mysqli_insert_id($conexion);
         $r = $r + $resVenta;

         foreach (@$datoso as $key) {
            $li = explode("||", @$key);

            $sqlBusca = "SELECT almacen_id,
                                almacen_cantidad,
                                almacen_preciofactura
                           from almacen
                          where almacen_producto = '$li[0]'
                            and almacen_caja = '$idCaja'";
            $result = mysqli_query($conexion,$sqlBusca);
       		$dAlma = mysqli_fetch_row($result);
            $nuevoCan = ($dAlma[1] - $li[5]);
            $sqlSale = "INSERT into salida(
                                    salida_producto,
                                    salida_cantidad,
                                    salida_salecan,
                                    salida_nuevocan,
                                    salida_precio,
                                    salida_precioventa,
                                    salida_fecha,
                                    salida_movimiento,
                                    salida_persona)
                            values ('$li[0]',
                                    '$dAlma[1]',
                                    '$li[5]',
                                    '$nuevoCan',
                                    '$dAlma[2]',
                                    '$li[6]',
                                    '$fechaAhora',
                                    '$idMovi',
                                    '$idPersona')";
            $resSale = mysqli_query($conexion, $sqlSale);

            $sqlActualiza = "UPDATE almacen
                                set almacen_cantidad = '$nuevoCan'
                              where almacen_id = '$dAlma[0]'
                                and almacen_producto = '$li[0]'
                                and almacen_caja = '$idCaja'";
            $resAlmacen = mysqli_query($conexion, $sqlActualiza);
            $r = $r + $resSale + $resAlmacen;
         }
         return $r;
      }
   }
?>
