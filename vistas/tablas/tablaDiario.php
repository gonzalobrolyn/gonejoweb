
<?php
  session_start();
  require_once "../../clases/Gonexion.php";
  $c = new conectar();
  $conexion = $c->conexion();
  $idCaja = $_SESSION['cajaID'];
  $suma = 0;

  $sql = "SELECT mov.movimiento_nombre,
                 mov.movimiento_monto,
                 mov.movimiento_detalle,
                 mov.movimiento_fecha,
                 per.persona_nombre,
                 per.persona_apellido,
                 per.persona_razon,
                 usu.persona_nombre,
                 usu.persona_apellido,
                 mov.movimiento_efectivo,
                 mov.movimiento_nuevoefe,
                 mov.movimiento_id
            from movimiento as mov
      inner join persona as per
              on mov.movimiento_persona = per.persona_id
      inner join persona as usu
              on mov.movimiento_persona_usu = usu.persona_id
           where mov.movimiento_caja = '$idCaja'
             and mov.movimiento_estado = 0
        order by mov.movimiento_id asc ";
  $result = mysqli_query($conexion, $sql);
?>

<table class="table table-hover table-condensed table-bordered" style="text-align: center">
   <tr>
      <td><b>Hora</b></td>
      <td><b>Movimiento</b></td>
      <td><b>A Nombre</b></td>
      <td><b>Monto</b></td>
      <td><b>Efectivo</b></td>
      <td><b>Usuario</b></td>
      <td><b>Imprimir</b></td>
   </tr>
   <?php while($ver=mysqli_fetch_row($result)):
      if ($ver[9] < $ver[10]) {
         $suma = $suma + $ver[1];
      } else {
         $suma = $suma - $ver[1];
      }
   ?>
      <tr>
         <td><?php echo $ver[3]; ?></td>
         <td><?php echo $ver[0]; ?></td>
         <td><?php echo $ver[4]." ".$ver[5]." ".$ver[6]; ?></td>
         <td><?php echo $ver[1]; ?></td>
         <td><?php echo $suma.".00"; ?></td>
         <td><?php echo $ver[7]." ".$ver[8]; ?></td>
         <td>
            <span class="btn btn-info" data-toggle="modal" data-target="#modalMovimiento<?php echo $ver[11] ?>">
               <span class="glyphicon glyphicon-eye-open"></span>
            </span>
            <div class="modal fade" id="modalMovimiento<?php echo $ver[11] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                      <?php echo $ver[3]." - ".$ver[0];?>
                    </h4>
                  </div>
                  <div class="modal-body">
                     <?php
                     $importe = 0;
                     $sqlDetalle = "SELECT sal.salida_id,
                                           gru.grupo_nombre,
                                           mar.marca_nombre,
                                           pro.producto_modelo,
                                           pro.producto_descripcion,                           sal.salida_salecan,
                                           sal.salida_precioventa
                                      from salida as sal
                                inner join producto as pro
                                        on sal.salida_producto = pro.producto_id
                                inner join grupo as gru
                                        on pro.producto_grupo = gru.grupo_id
                                inner join marca as mar
                                        on pro.producto_marca = mar.marca_id
                                     where sal.salida_movimiento = '$ver[11]'";
                     $queryDetalle = mysqli_query($conexion, $sqlDetalle);
                     ?>
                     <p><?php echo "A NOMBRE: ".$ver[4]." ".$ver[5]." ".$ver[6]; ?></p>
                     <table class="table table-hover table-bordered">
                        <tr>
                           <td><b>Producto</b></td>
                           <td><b>Cantidad</b></td>
                           <td><b>P Unidad</b></td>
                           <td><b>Importe</b></td>
                        </tr>
                        <?php
                           while ($verDetalle = mysqli_fetch_row($queryDetalle)):
                        ?>
                        <tr>
                           <td><?php echo $verDetalle[1]." ".$verDetalle[2]." ".$verDetalle[3]." ".$verDetalle[4]; ?></td>
                           <td><?php echo $verDetalle[5]; ?></td>
                           <td><?php echo $verDetalle[6]; ?></td>
                           <td><?php echo $verDetalle[5]*$verDetalle[6]; ?></td>
                        </tr>
                        <?php
                           $importe = $importe+$verDetalle[5]*$verDetalle[6];
                           endwhile;
                        ?>
                        <tr>
                           <td colspan="3" style="text-align: right"><b> TOTAL  S/ </b></td>
                           <td><b><?php echo $importe; ?></b></td>
                        </tr>
                     </table>
                  </div>
                </div>
              </div>
            </div>
            <span class="btn btn-success" name="impMovi<?php echo $ver[11]; ?>" id="impMovi<?php echo $ver[11]; ?>">
               <span class="glyphicon glyphicon-print"></span>
            </span>
         </td>
      </tr>
      <div hidden>
         <div class="formatoMovimiento<?php echo $ver[11]; ?>" id="impFormatoMovimiento<?php echo $ver[11]; ?>"></div>
      </div>
      <script type="text/javascript">
         $(document).ready(function(){
            $('#impFormatoMovimiento<?php echo $ver[11]; ?>').load("imprimir/impMovimiento.php?idMovimiento=<?php echo $ver[11]; ?>");
            $('#impMovi<?php echo $ver[11]; ?>').click(function(){
               $('.formatoMovimiento<?php echo $ver[11]; ?>').printThis();
            });
         });
      </script>

   <?php
      endwhile;
   ?>
   <tr>
      <td colspan="3" style="text-align: right"><b>TOTAL EFECTIVO S/</b></td>
      <td colspan="2"><b><?php echo $suma.".00"; ?></b></td>
   </tr>
</table>
