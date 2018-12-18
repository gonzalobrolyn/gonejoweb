
<?php
  require_once "../../clases/Gonexion.php";
  $c = new conectar();
  $conexion = $c->conexion();
  $sql = "SELECT mar.marca_id,
                 mar.marca_nombre,
                 mar.marca_fecha,
                 per.persona_nombre,
                 per.persona_apellido
            from marca as mar
      inner join persona as per
              on mar.marca_persona = per.persona_id";
  $result = mysqli_query($conexion, $sql);
?>

<table class="table table-hover table-condensed table-bordered" style="text-align: center">
  <tr>
    <td><b>Nombre de Marca</b></td>
    <td><b>Editado</b></td>
    <td><b>Editor</b></td>
    <td><b>Editar</b></td>
  </tr>
  <?php while($ver=mysqli_fetch_row($result)): ?>
    <tr>
      <td><?php echo $ver[1]; ?></td>
      <td><?php echo $ver[2]; ?></td>
      <td><?php echo $ver[3]." ".$ver[4]; ?></td>
      <td>
         <span class="btn btn-danger btn-sm" data-toggle="modal" data-target="#actualizaMarca" onclick="agregaDato('<?php echo $ver[0] ?>','<?php echo $ver[1] ?>')">
            <span class="glyphicon glyphicon-pencil"></span>
         </span>
      </td>
    </tr>
  <?php endwhile; ?>
</table>
