
<?php
   require_once "Gonexion.php";

   class compras{

      public function registraDeposito($datos){
         $c = new conectar();
         $conexion = $c->conexion();

         $sqlPersona = "SELECT usuario_persona
                          from usuario
                         where usuario_id = '$datos[7]'";
         $consulta = mysqli_query($conexion, $sqlPersona);
         $idPersona = mysqli_fetch_row($consulta)[0];

         $sqlEfectivo = "SELECT caja_efectivo
                           from caja
                          where caja_id = '$datos[8]'";
         $consulta = mysqli_query($conexion, $sqlEfectivo);
         $efectivoCaja = mysqli_fetch_row($consulta)[0];
         $nuevoEfe = $efectivoCaja - $datos[2];

         $sqlMov = "INSERT into movimiento (
                                movimiento_nombre,
                                movimiento_estado,
                                movimiento_persona,
                                movimiento_efectivo,
                                movimiento_monto,
                                movimiento_nuevoefe,
                                movimiento_comprobante,
                                movimiento_numerocom,
                                movimiento_detalle,
                                movimiento_fecha,
                                movimiento_persona_usu,
                                movimiento_caja)
                        values ('$datos[0]',
                                '1',
                                '$datos[1]',
                                '$efectivoCaja',
                                '$datos[2]',
                                '$nuevoEfe',
                                '$datos[3]',
                                '$datos[4]',
                                '$datos[5]',
                                '$datos[6]',
                                '$idPersona',
                                '$datos[8]')";
         $deposito = mysqli_query($conexion, $sqlMov);
         if ($deposito > 0) {
            $sqlCaja = "UPDATE caja
                           set caja_efectivo = '$nuevoEfe'
                         where caja_id = '$datos[8]'";
            return mysqli_query($conexion, $sqlCaja);
         } else {
            return 0;
         }
      }

      public function crearCompra($movi){
         $c = new conectar();
         $conexion = $c->conexion();

         $fechaLocal = time() - (7*60*60);
         $fechaAhora = date("Y-m-d H:i:s", $fechaLocal);
         $idUsuario = $_SESSION['usuarioID'];
         $idCaja = $_SESSION['cajaID'];
         $datoso = $_SESSION['listaCompraTmp'];
         $r = 0;

         $sqlPersona = "SELECT usuario_persona
                          from usuario
                         where usuario_id = '$idUsuario'";
         $consultaP = mysqli_query($conexion, $sqlPersona);
         $idPersona = mysqli_fetch_row($consultaP)[0];

         $sqlEfectivo = "SELECT caja_efectivo
                           from caja
                          where caja_id = '$idCaja'";
         $consultaE = mysqli_query($conexion, $sqlEfectivo);
         $efectivoCaja = mysqli_fetch_row($consultaE)[0];

         $nuevoEfe = $efectivoCaja - $movi[2];

         $sqlMov = "INSERT into movimi (
                                movimi_nombre,
                                movimi_persona,
                                movimi_efectivo,
                                movimi_monto,
                                movimi_nuevoefe,
                                movimi_comprobante,
                                movimi_numerocom,
                                movimi_fecha,
                                movimi_persona_usu,
                                movimi_caja)
                        values ('$movi[0]',
                                '$movi[1]',
                                '$efectivoCaja',
                                '$movi[2]',
                                '$nuevoEfe',
                                '$movi[3]',
                                '$movi[4]',
                                '$fechaAhora',
                                '$idPersona',
                                '$idCaja')";
         $resCompra = mysqli_query($conexion, $sqlMov);
         $idMovi = mysqli_insert_id($conexion);
         $r = $r + $resCompra;

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
            $nuevoCan = $dAlma[1] + $li[8];
            $sqlEntra = "INSERT into entrada(
                                    entrada_producto,
                                    entrada_cantidad,
                                    entrada_entracan,
                                    entrada_nuevocan,
                                    entrada_precio,
                                    entrada_preciocompra,
                                    entrada_fecha,
                                    entrada_movimi,
                                    entrada_persona)
                            values ('$li[0]',
                                    '$dAlma[1]',
                                    '$li[8]',
                                    '$nuevoCan',
                                    '$dAlma[2]',
                                    '$li[9]',
                                    '$fechaAhora',
                                    '$idMovi',
                                    '$idPersona')";
            $resEntra = mysqli_query($conexion, $sqlEntra);

            if ($dAlma[0] == NULL) {
               $sqlAlmacena = "INSERT into almacen (
                                           almacen_producto,
                                           almacen_cantidad,
                                           almacen_preciofactura,
                                           almacen_preciollegada,
                                           almacen_precioempresa,
                                           almacen_preciotraspaso,
                                           almacen_preciocantidad,
                                           almacen_preciorebaja,
                                           almacen_precioventa,
                                           almacen_caja)
                                   values ('$li[0]',
                                           '$li[8]',
                                           '$li[9]',
                                           '$li[10]',
                                           '$li[11]',
                                           '$li[12]',
                                           '$li[13]',
                                           '$li[14]',
                                           '$li[15]',
                                           '$idCaja')";
               $resAlmacen = mysqli_query($conexion, $sqlAlmacena);
            } else {
               $v1 = $dAlma[1] * $dAlma[2];
               $v2 = $li[8] * $li[9];
               $v3 = $dAlma[1] + $li[8];
               $sqlActualiza = "UPDATE almacen
                                   set almacen_cantidad = '$v3',
                                       almacen_preciofactura = ('$v1'+'$v2')/'$v3',
                                       almacen_preciollegada = '$li[10]',
                                       almacen_precioempresa = '$li[11]',
                                       almacen_preciotraspaso = '$li[12]',
                                       almacen_preciocantidad = '$li[13]',
                                       almacen_preciorebaja = '$li[14]',
                                       almacen_precioventa = '$li[15]'
                                 where almacen_id = '$dAlma[0]'
                                   and almacen_producto = '$li[0]'
                                   and almacen_caja = '$idCaja'";
               $resAlmacen = mysqli_query($conexion, $sqlActualiza);
            }
            $r = $r + $resEntra + $resAlmacen;
         }
         $sqlCaja = "UPDATE caja
                        set caja_efectivo = '$nuevoEfe'
                      where caja_id = '$idCaja'";
         $resCaja = mysqli_query($conexion, $sqlCaja);
         $r = $r + $resCaja;
         return $r;
      }

      public function crearCompraConDep(){
         $c = new conectar();
         $conexion = $c->conexion();

         $fechaLocal = time() - (7*60*60);
         $fechaAhora = date("Y-m-d H:i:s", $fechaLocal);
         $idMovimiento = $_SESSION['depositoID'];
         $idUsuario = $_SESSION['usuarioID'];
         $idCaja = $_SESSION['cajaID'];
         $datos = $_SESSION['listaCompraDep'];
         $r = 0;

         $sqlPersona = "SELECT usuario_persona
                          from usuario
                         where usuario_id = '$idUsuario'";
         $consulta = mysqli_query($conexion, $sqlPersona);
         $idPersona = mysqli_fetch_row($consulta)[0];

         for ($i=0; $i<count($datos); $i++) {
            $d = explode("||", $datos[$i]);
            $sqlBusca = "SELECT almacen_id,
                                almacen_cantidad,
                                almacen_precio
                           from almacen
                          where almacen_producto = '$d[0]'
                            and almacen_caja = '$idCaja'";
            $result = mysqli_query($conexion,$sqlBusca);
       		$dAlma = mysqli_fetch_row($result);

            $sqlEntra = "INSERT into entrada (
                                     entrada_producto,
                                     entrada_cantidad,
                                     entrada_entracan,
                                     entrada_nuevocan,
                                     entrada_precio,
                                     entrada_preciocompra,
                                     entrada_fecha,
                                     entrada_movimiento,
                                     entrada_persona)
                             values ('$d[0]',
                                     '$dAlma[1]',
                                     '$d[5]',
                                     '$dAlma[1]'+'$d[5]',
                                     '$dAlma[2]',
                                     '$d[6]',
                                     '$fechaAhora',
                                     '$idMovimiento',
                                     '$idPersona')";
            $resEntra = mysqli_query($conexion, $sqlEntra);

            if ($dAlma[0] == NULL) {
               $sqlAlmacena = "INSERT into almacen (
                                           almacen_producto,
                                           almacen_cantidad,
                                           almacen_precio,
                                           almacen_caja)
                                   values ('$d[0]',
                                           '$d[5]',
                                           '$d[6]',
                                           '$idCaja')";
               $resAlmacen = mysqli_query($conexion, $sqlAlmacena);
            } else {
               $v1 = $dAlma[1] * $dAlma[2];
               $v2 = $d[5] * $d[6];
               $v3 = $dAlma[1] + $d[5];
               $sqlActualiza = "UPDATE almacen
                                   set almacen_cantidad = '$v3',
                                       almacen_precio = ('$v1'+'$v2')/'$v3'
                                 where almacen_id = '$dAlma[0]'
                                   and almacen_producto = '$d[0]'
                                   and almacen_caja = '$idCaja'";
               $resAlmacen = mysqli_query($conexion, $sqlActualiza);
            }
            $r = $r + $resEntra + $resAlmacen;
         }
         $sqlCambio = "UPDATE movimiento
                          set movimiento_nombre = 'Comprado'
                        where movimiento_id = '$idMovimiento'
                          and movimiento_caja = '$idCaja'";
         $resCambio = mysqli_query($conexion, $sqlCambio);
         $r = $r + $resCambio;
         return $r;
      }
   }
?>
