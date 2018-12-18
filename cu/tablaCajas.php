
<?php
  require_once "../clases/Gonexion.php";
  $c = new conectar();
  $conexion = $c->conexion();
  $sql = "SELECT caj.caja_codigo,
                 caj.caja_sede,
                 caj.caja_direccion,
                 caj.caja_ciudad,
                 caj.caja_telefono,
                 caj.caja_fecha,
                 usu.usuario_nombre,
                 per.persona_nombre,
                 per.persona_apellido,
                 per.persona_celular
            from caja as caj
      inner join usuario as usu
              on caj.caja_usuario = usu.usuario_id
      inner join persona as per
              on usu.usuario_persona = per.persona_id";
  $result = mysqli_query($conexion, $sql);
?>

<table class="table table-hover table-condensed table-bordered" style="text-align: center">
  <tr>
    <td><b>Codigo</b></td>
    <td><b>Cliente</b></td>
    <td><b>Usuario</b></td>
    <td><b>Celular</b></td>
    <td><b>Sede</b></td>
    <td><b>Direccion</b></td>
    <td><b>Ciudad</b></td>
    <td><b>Telefono</b></td>
    <td><b>Fecha</b></td>
  </tr>

  <?php while($ver=mysqli_fetch_row($result)): ?>
    <tr>
      <td><?php echo $ver[0]; ?></td>
      <td><?php echo $ver[7]." ".$ver[8]; ?></td>
      <td><?php echo $ver[6]; ?></td>
      <td><?php echo $ver[9]; ?></td>
      <td><?php echo $ver[1]; ?></td>
      <td><?php echo $ver[2]; ?></td>
      <td><?php echo $ver[3]; ?></td>
      <td><?php echo $ver[4]; ?></td>
      <td><?php echo $ver[5]; ?></td>
    </tr>
  <?php endwhile; ?>
</table>
