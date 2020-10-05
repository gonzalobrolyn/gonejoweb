
<?php
   session_start();
   require_once "../../clases/Gonexion.php";
   $c = new conectar();
   $conexion = $c->conexion();

   $idCaja = $_SESSION['cajaID'];
   $idMovimiento = $_GET['idMovimiento'];
   $importe = 0;

   $sqlMovi = "SELECT mov.movimiento_id,
                      mov.movimiento_efectivo,
                      mov.movimiento_fecha,
                      per.persona_nombre,
                      per.persona_apellido,
                      per.persona_razon,
                      per.persona_dni,
                      per.persona_ruc
                 from movimiento as mov
           inner join persona as per
                   on mov.movimiento_persona = per.persona_id
                where mov.movimiento_id = '$idMovimiento'
                  and mov.movimiento_caja = '$idCaja'";
   $queryMovi = mysqli_query($conexion, $sqlMovi);
   $ver = mysqli_fetch_row($queryMovi);

   $sqlDetalle = "SELECT sal.salida_id,
                         gru.grupo_nombre,
                         mar.marca_nombre,
                         pro.producto_modelo,
                         pro.producto_descripcion,
                         sal.salida_salecan,
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
?>

<div class="container">
   <h2 style="text-align: center">Blue Store</h2>
   <h4 style="text-align: center">
      <?php echo 'Nombre: '.$ver[3]." ".$ver[4]." ".$ver[5]; ?> <br>
      <?php echo 'Documento: '.$ver[6]; ?> <br>
      <?php echo 'Fecha: '.$ver[2]; ?> <br>
   </h4>
   <table class="table table-hover table-bordered">
      <tr>
         <td><b>Producto</b></td>
         <td><b>Cant.</b></td>
         <td><b>P. U.</b></td>
         <td><b>Importe</b></td>
      </tr>
      <?php
         while ($verDetalle = mysqli_fetch_row($queryDetalle)):
      ?>
      <tr>
         <td><?php echo $verDetalle[1]." ".$verDetalle[2]." ".$verDetalle[3]." ".$verDetalle[4]; ?></td>
         <td style="text-align: center"><?php echo $verDetalle[5]; ?></td>
         <td style="text-align: right"><?php echo $verDetalle[6]; ?></td>
         <td style="text-align: right"><?php echo $verDetalle[5]*$verDetalle[6].".00"; ?></td>
      </tr>
      <?php
         $importe = $importe+$verDetalle[5]*$verDetalle[6];
         endwhile;
      ?>
      <tr>
         <td colspan="3" style="text-align: right"><b> TOTAL  S/ </b></td>
         <td><b><?php echo $importe.".00"; ?></b></td>
      </tr>
      <tr>
         <td colspan="3" style="text-align: right"></td>
         <td><b><?php echo $ver[1]; ?></b></td>
      </tr>
   </table>
</div>
