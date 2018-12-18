
<?php
  require_once "../../clases/Gonexion.php";
  $c = new conectar();
  $conexion = $c->conexion();
  $sql = "SELECT fam.familia_id,
                 fam.familia_nombre,
                 fam.familia_fecha,
                 per.persona_nombre,
                 per.persona_apellido
            from familia as fam
      inner join persona as per
              on fam.familia_persona = per.persona_id";
  $result = mysqli_query($conexion, $sql);
?>

<table class="table table-hover table-condensed table-bordered" style="text-align: center">
  <tr>
    <td><b>Ingresa a familia</b></td>
    <td><b>Editado</b></td>
    <td><b>Editor</b></td>
    <td><b>Editar</b></td>
  </tr>
  <?php while($ver=mysqli_fetch_row($result)): ?>
    <tr>
      <td><a href="grupo.php?familia=<?php echo $ver[0]?>"><?php echo $ver[1]; ?></a></td>
      <td><?php echo $ver[2]; ?></td>
      <td><?php echo $ver[3]." ".$ver[4]; ?></td>
      <td>
         <span class="btn btn-danger btn-sm" data-toggle="modal" data-target="#actualizaFamilia" onclick="agregaDato('<?php echo $ver[0] ?>','<?php echo $ver[1] ?>')">
				<span class="glyphicon glyphicon-pencil"></span>
			</span>
      </td>
    </tr>
  <?php endwhile; ?>
</table>
