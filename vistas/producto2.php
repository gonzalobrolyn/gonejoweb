
<?php
   require_once "../clases/Gonexion.php";

   $c = new conectar();
   $conexion = $c->conexion();

   $opcion = mysqli_real_escape_string($conexion, strip_tags($_GET["opcion"]));

   $sqlGrupo = "SELECT grupo_id,
                       grupo_nombre
                  from grupo
                 where grupo_familia = '$opcion'";
   $queryGrupo = mysqli_query($conexion, $sqlGrupo);

   if (mysqli_num_rows($queryGrupo)){
?>
      <select class="form-control" name="grupo" id="grupo" title="Selecciona Grupo">
       <option value="A">Selecciona Grupo</option>
       <?php while($verGrupo=mysqli_fetch_row($queryGrupo)): ?>
          <option value="<?php echo $verGrupo[0]; ?>">
            <?php echo $verGrupo[1]; ?>
          </option>
       <?php endwhile;
       mysqli_free_result($queryGrupo);
       ?>
      </select><p></p>
<?php
   }
?>
<script type="text/javascript">
  $(document).ready(function(){
    $('#grupo').select2();
  });
</script>
