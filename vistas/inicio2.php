
<?php
   session_start();
   if(isset($_SESSION['usuarioNombre'])){
      require_once "menu.php";
      require_once "../clases/Gonexion.php";

      $c = new conectar();
      $conexion = $c->conexion();

      $idCaja = $_SESSION['cajaID'];
      $idFamilia = $_GET['familia'];
      $nombreFamilia = $_GET['nombre'];

      $sqlGrupo = "SELECT grupo_id,
                          grupo_nombre
                     from grupo
                    where grupo_familia = '$idFamilia'";
      $queryGrupo = mysqli_query($conexion, $sqlGrupo);

      $sqlFamilia = "SELECT familia_id,
                            familia_nombre
                       from familia";
      $rFamilia = mysqli_query($conexion, $sqlFamilia);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title></title>
   </head>
   <body>
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-10">
               <h3 style="text-align:center">LISTA DE <?php echo $nombreFamilia; ?></h3>
               <?php while($verGrupo=mysqli_fetch_row($queryGrupo)): ?>
                  <p> <b><?php echo $verGrupo[1]; ?></b> </p>
                  <?php
                     $sqlProducto = "SELECT alm.almacen_id,
                                            alm.almacen_cantidad,
                                            pro.producto_modelo,
                                            pro.producto_codigo,
                                            pro.producto_detalle,
                                            mar.marca_nombre,
                                            alm.almacen_precioventa
                                       from almacen as alm
                                 inner join producto as pro
                                         on alm.almacen_producto = pro.producto_id
                                 inner join marca as mar
                                         on pro.producto_marca = mar.marca_id
                                      where pro.producto_grupo = '$verGrupo[0]'
                                        and alm.almacen_caja = '$idCaja'";
                     $queryPro = mysqli_query($conexion, $sqlProducto);
                  ?>
                  <?php while ($verPro=mysqli_fetch_row($queryPro)): ?>
                     <table class="table table-hover table-condensed table-bordered" style="text-align: center">
                        <tr>
                           <td><?php echo $verPro[3]; ?></td>
                           <td><?php echo $verPro[5]; ?></td>
                           <td><?php echo $verPro[2]; ?></td>
                           <td><?php echo $verPro[4]; ?></td>
                           <td><?php echo "Stok ".$verPro[1]; ?></td>
                           <td><?php echo "S/ ".$verPro[6]; ?></td>
                           <td>
                              <a class="btn btn-xs btn-info" href="detalle.php?idProAlm=<?php echo $verPro[0] ?>">
                                 <span class="glyphicon glyphicon-eye-open"></span> Ver
                              </a>
                           </td>
                        </tr>
                     </table>
                  <?php endwhile; ?>
               <?php endwhile; ?>
            </div>
            <div class="col-sm-2" style="text-align:center">
               <a href="inicio.php" class="btn btn-primary">Volver a Ventas</a>
               <p></p>
               <table class="table table-hover table-condensed table-bordered" style="text-align: center">
                  <?php while($verFamilia=mysqli_fetch_row($rFamilia)): ?>
                  <tr>
                     <td>
                        <a href="inicio2.php?familia=<?php echo $verFamilia[0]?>&nombre=<?php echo $verFamilia[1]?>">
                           <?php echo $verFamilia[1]; ?>
                        </a>
                     </td>
                  </tr>
                  <?php endwhile; ?>
               </table>
            </div>
         </div>
      </div>
   </body>
</html>

<?php
} else {
   header("location:../index.php");
}
?>
