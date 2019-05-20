
<?php
  session_start();
  require_once "../../clases/Gonexion.php";
  $c = new conectar();
  $conexion = $c->conexion();
  $idCaja = $_SESSION['cajaID'];
  $sql = "SELECT mov.movimi_nombre,
                 mov.movimi_efectivo,
                 mov.movimi_monto,
                 mov.movimi_nuevoefe,
                 mov.movimi_detalle,
                 mov.movimi_fecha,
                 per.persona_nombre,
                 per.persona_apellido,
                 per.persona_razon,
                 usu.persona_nombre
            from movimi as mov
      left join persona as per
              on mov.movimi_persona = per.persona_id
      inner join persona as usu
              on mov.movimi_persona_usu = usu.persona_id
           where mov.movimi_caja = '$idCaja'
        order by mov.movimi_id desc";
  $result = mysqli_query($conexion, $sql);
?>

<table class="table table-hover table-condensed table-bordered" style="text-align: center">
  <tr>
      <td><b>Fecha</b></td>
      <td><b>Movimiento</b></td>
      <td><b>A Nombre</b></td>
      <td><b>Caja Efectivo</b></td>
      <td><b>Monto</b></td>
      <td><b>Nuevo Efectivo</b></td>
      <td><b>Descripción</b></td>
      <td><b>Usuario</b></td>
  </tr>
  <?php while($ver=mysqli_fetch_row($result)): ?>
    <tr>
      <td><?php echo $ver[5]; ?></td>
      <td><?php echo $ver[0]; ?></td>
      <td><?php echo $ver[6]." ".$ver[7]." ".$ver[8]; ?></td>
      <td><?php echo $ver[1]; ?></td>
      <td><?php echo $ver[2]; ?></td>
      <td><?php echo $ver[3]; ?></td>
      <td><?php echo $ver[4]; ?></td>
      <td><?php echo $ver[9]; ?></td>
    </tr>
  <?php endwhile; ?>
</table>
