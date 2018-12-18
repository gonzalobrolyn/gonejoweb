
<?php
   session_start();
   if(isset($_SESSION['usuarioNombre'])){
      require_once "../clases/Gonexion.php";
      $c = new conectar();
      $conexion = $c->conexion();
      $idCaja = $_SESSION['cajaID'];

      $sqlGrupo = "SELECT grupo_id,
                          grupo_nombre
                     from grupo";
      $rGrupo = mysqli_query($conexion, $sqlGrupo);
?>

<!DOCTYPE html>
<html lang="es" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Gonejo Web</title>
      <link rel="stylesheet" type="text/css" href="../css/demo.css">
      <?php
      require_once "menu.php";
      require_once "inicio/contenido.php";
      $datos = contenido();
      ?>
   </head>
   <body>
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-10">
               <ul class="gridder">
               <?php
               for ($i=0; $i < count($datos) ; $i++):
                  $d=explode("||", $datos[$i]);
               ?>
                  <li class="gridder-list" data-griddercontent="<?php echo '#gridder-content-'.$i ?>">
                     <img src="<?php echo $d[0] ?>">
                     <p><?php echo $d[2]." ".$d[3] ?></p>
                  </li>

               <?php endfor; ?>
               </ul>

               <?php
               for ($i=0; $i < count($datos); $i++):
                  $d=explode("||", $datos[$i]);
               ?>
               <div id="<?php echo 'gridder-content-'.$i; ?>" class="gridder-content">
                  <div class="col-sm-6" style="text-align: center">
                     <br><br><br>
                     <h4><?php echo $d[1]." - ".$d[2]; ?></h4>
                     <p><?php echo $d[3]; ?></p>
                     <p><?php echo $d[4]; ?></p>
                     <p><?php echo "Cantidad: ".$d[5]; ?></p>
                     <p><?php echo "Precio: S/ ".ceil($d[6]*1.1).".00"; ?></p>
                  </div>
                  <div class="col-sm-6">
                     <img src="<?php echo $d[0] ?>" class="img-responsive" />
                  </div>
               </div>
               <?php endfor; ?>
            </div>
            <div class="col-sm-2" style="text-align: center">
               <a href="inicio.php" class="btn btn-primary btn-sm">
                  VOLVER A VENTAS
               </a><p></p>
               <?php while($verGrupo=mysqli_fetch_row($rGrupo)): ?>
                  <a href="inicio2.php?grupo=<?php echo $verGrupo[0]?>" class="btn btn-danger btn-sm">
                     <?php echo $verGrupo[1]; ?>
                  </a><p></p>
               <?php endwhile; ?>
             </div>
         </div>
      </div>
   </body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$(".gridder").gridderExpander({
			scroll: true,
			scrollOffset: 60,
         scrollTo: "listitem", // panel or listitem
         animationSpeed: 100,
         animationEasing: "easeInOutExpo",
         showNav: true,
         nextText: "<i class=\"fa fa-arrow-right\"></i>",
         prevText: "<i class=\"fa fa-arrow-left\"></i>",
         closeText: "<i class=\"fa fa-times\"></i>",
         onStart: function () {
      	   console.log("Gridder Inititialized");
         },
         onContent: function () {
      	   console.log("Gridder Content Loaded");
      	   $(".carousel").carousel();
         },
         onClosed: function () {
      	   console.log("Gridder Closed");
         }
      });
	});
</script>

<?php
} else {
   header("location:../index.php");
}
?>
