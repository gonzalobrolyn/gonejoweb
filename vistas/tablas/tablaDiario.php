
<?php
  session_start();
  require_once "../../clases/Gonexion.php";
  $c = new conectar();
  $conexion = $c->conexion();
  $idCaja = $_SESSION['cajaID'];
  $suma = 0;

  $sql = "SELECT mov.movimiento_id,
                 mov.movimiento_nombre,
                 mov.movimiento_efectivo,
                 mov.movimiento_detalle,
                 mov.movimiento_fecha,
                 per.persona_nombre,
                 per.persona_apellido,
                 per.persona_razon,
                 usu.persona_nombre
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
      <td><b>Usuario</b></td>
      <td><b>Hora</b></td>
      <td><b>A Nombre</b></td>
      <td colspan="2"><b>Movimiento</b></td>
      <td><b>Efectivo</b></td>
      <td><b>Suma</b></td>
      <td><b>Imprimir</b></td>
   </tr>
   <?php while($ver=mysqli_fetch_row($result)):
      if ($ver[1] == "Gasto") {
         $suma = $suma - $ver[2];
      } else {
         $suma = $suma + $ver[2];
      }
   ?>
      <tr>
         <td><?php echo $ver[8]; ?></td>
         <td><?php echo $ver[4]; ?></td>
         <td><?php echo $ver[5]." ".$ver[6]." ".$ver[7]; ?></td>
         <td colspan="2"><?php echo $ver[1]; ?></td>
         <td><?php echo $ver[2]; ?></td>
         <td><?php echo $suma.".00"; ?></td>
         <td>
            <span class="btn btn-success" name="impMovi<?php echo $ver[0]; ?>" id="impMovi<?php echo $ver[0]; ?>">
               <span class="glyphicon glyphicon-print"></span>
            </span>
         </td>
      </tr>

      <?php
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
                      where sal.salida_movimiento = '$ver[0]'";
      $queryDetalle = mysqli_query($conexion, $sqlDetalle);

      while ($verDetalle = mysqli_fetch_row($queryDetalle)):
      ?>
      <tr>
         <td colspan="3"><?php echo $verDetalle[1]." ".$verDetalle[2]." ".$verDetalle[3]." ".$verDetalle[4]; ?></td>
         <td><?php echo $verDetalle[5]; ?></td>
         <td><?php echo $verDetalle[6]; ?></td>
         <td><?php echo $verDetalle[5]*$verDetalle[6]; ?></td>
      </tr>
      <?php
         endwhile;
      ?>

      <div hidden>
         <div class="formatoMovimiento<?php echo $ver[0]; ?>" id="impFormatoMovimiento<?php echo $ver[0]; ?>"></div>
      </div>
      <script type="text/javascript">
         $(document).ready(function(){
            $('#impFormatoMovimiento<?php echo $ver[0]; ?>').load("imprimir/impMovimiento.php?idMovimiento=<?php echo $ver[0]; ?>");
            $('#impMovi<?php echo $ver[0]; ?>').click(function(){
               $('.formatoMovimiento<?php echo $ver[0]; ?>').printThis();
            });
         });
      </script>

   <?php
      endwhile;
   ?>
   <tr>
      <td colspan="6" style="text-align: right"><b>TOTAL EFECTIVO S/</b></td>
      <td><b><?php echo $suma.".00"; ?></b></td>
   </tr>
</table>
