
<?php
   require_once "../../clases/Gonexion.php";
   $c = new conectar();
   $conexion = $c->conexion();

   $grupoID = $_GET['grupo'];

   $sqlPro = "SELECT pro.producto_codigo,
                     mar.marca_nombre,
                     pro.producto_modelo,
                     pro.producto_descripcion,
                     pro.producto_detalle,
                     img.imagen_ruta
                from producto as pro
          inner join marca as mar
                  on pro.producto_marca = mar.marca_id
          inner join imagen as img
                  on pro.producto_imagen = img.imagen_id
               where pro.producto_grupo = '$grupoID'";
   $resultPro = mysqli_query($conexion, $sqlPro);
   ?>

   <table class="table table-hover table-condensed table-bordered" style="text-align: center">
      <tr>
         <td><b>CODIGO</b></td>
         <td><b>MARCA</b></td>
         <td><b>MODELO</b></td>
         <td><b>DESCRIPCION</b></td>
         <td><b>CARACTERISTICAS</b></td>
         <td><b>IMAGEN</b></td>
         <td><b>EDITAR</b></td>

      </tr>
      <?php while($ver=mysqli_fetch_row($resultPro)): ?>
      <tr>
         <td><?php echo $ver[0]; ?></td>
         <td><?php echo $ver[1]; ?></td>
         <td><?php echo $ver[2]; ?></td>
         <td><?php echo $ver[3]; ?></td>
         <td><?php echo $ver[4]; ?></td>
         <td>
            <?php
            $img = explode("/",$ver[5]);
            $ruta = $img[1]."/".$img[2]."/".$img[3];
            ?>
            <img height="100" src="<?php echo $ruta ?>">
         </td>
         <td>
            <span class="btn btn-danger btn-sm" data-toggle="modal" data-target="#actualizaProducto">
   				<span class="glyphicon glyphicon-pencil"></span>
   			</span>
         </td>
      </tr>
      <?php endwhile; ?>
   </table>
