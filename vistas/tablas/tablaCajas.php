
<?php
  session_start();
  require_once "../../clases/Gonexion.php";
  $c = new conectar();
  $conexion = $c->conexion();
  $usuarioCaja = $_SESSION['usuarioCaja'];

  $sql = "SELECT caj.caja_id,
                 caj.caja_sede,
                 caj.caja_direccion,
                 caj.caja_ciudad,
                 caj.caja_telefono,
                 caj.caja_efectivo,
                 ima.imagen_ruta
            from caja as caj
      inner join imagen as ima
              on caj.caja_logo = ima.imagen_id
           where caj.caja_id = '$usuarioCaja'";
  $result = mysqli_query($conexion, $sql);
?>

<?php
while($ver=mysqli_fetch_row($result)):

   $sqlInversion = "SELECT almacen_cantidad,
                           almacen_preciollegada
                      from almacen
                     where almacen_caja = '$ver[0]'";
   $queryInv = mysqli_query($conexion, $sqlInversion);

   $inversion = 0;
   while ($inv = mysqli_fetch_row($queryInv)) {
      $inversion = $inversion + $inv[0] * $inv[1];
   }
?>
<div class="col-md-6">
   <table class="table table-hover table-condensed table-bordered" style="text-align: center">
      <tr>
         <td colspan="2"><b><?php echo $ver[1]; ?></b></td>
      </tr>
      <tr>
         <td rowspan="5">
         <?php
            $img = explode("/",$ver[6]);
            $ruta = $img[1]."/".$img[2]."/".$img[3];
         ?>
            <img height="120" src="<?php echo $ruta ?>">
         </td>
         <td><?php echo $ver[2]." ".$ver[3]; ?></td>
      </tr>
      <tr><td><?php echo "Telf: ".$ver[4]; ?></td></tr>
      <tr><td><?php echo "Inversión: S/ ".$inversion; ?></td></tr>
      <tr><td><?php echo "Soles: S/ ".$ver[5]; ?></td></tr>
      <tr><td><?php echo "Dolares: $ "; ?></td></tr>
      <tr>
         <td colspan="2">
            <span class="btn btn-success" data-toggle="modal" data-target="#modalIngreso">
               <span class="glyphicon glyphicon-plus-sign"></span> Agregar Efectivo
            </span>
            <span class="btn btn-danger" data-toggle="modal" data-target="#modalEgreso">
               <span class="glyphicon glyphicon-minus-sign"></span> Retirar Efectivo
            </span>
            <span class="btn btn-primary">
               <span class="glyphicon glyphicon-pencil"></span> Editar Datos
            </span>
         </td>
      </tr>
   </table>
</div>
<?php endwhile; ?>
