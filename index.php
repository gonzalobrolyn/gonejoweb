
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>GonejoWeb</title>
    <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
    <link rel="icon" type="image/png" href="imagenes/mifavicon.png" />
  	<script src="librerias/jquery-3.2.1.min.js"></script>
    <script src="librerias/bootstrap/js/bootstrap.js"></script>
  	<script src="js/funciones.js"></script>
    <style type="text/css">
      .carousel-inner{text-align: center;;}
      .carousel .item > img{display: inline-block;}
      #slider .item {height: auto;}
    </style>
  </head>

  <body>
     <nav class="navbar navbar-fixed-top" data-spy="affix" id="barra-nav" role="navigation">
      <div class="container-fluid">
         <div class="nav navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav" aria-expanded="false" aria-controls="navbar">
             <span class="sr-only">MENU</span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">
             <span class="btn btn-primary btn-lg">
               <span class="glyphicon glyphicon-fire" style="color: #22d0ff"></span> GonejoWeb</span>
          </a>
         </div>
         <div id="main-nav" class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
             <li>
               <a  data-toggle="modal" data-target="#modalIngreso">
                  <span class="btn btn-primary">
                     Ingreso
                  </span>
               </a>
             </li>
             <li>
             <a href="registro.php">
                <span class="btn btn-primary">
                   Registro
               </span>
             </a>
           </li>
          </ul>
         </div>
      </div>
     </nav>

  	<div class="container-fluid">
  		<div class="row">

          <div id="slider" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
              <li data-target="#slider" data-slide-to="0" class="active"></li>
              <li data-target="#slider" data-slide-to="1"></li>
              <li data-target="#slider" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
              <div class="item active">
                <img src="imagenes/fondo1.png" alt="...">
                <div class="carousel-caption">
                  <h3></h3>
                </div>
              </div>
              <div class="item">
                <img src="imagenes/fondo2.png" alt="...">
                <div class="carousel-caption">
                  <h3></h3>
                </div>
              </div>
              <div class="item">
                <img src="imagenes/fondo3.png" alt="...">
                <div class="carousel-caption">
                  <h3></h3>
                </div>
              </div>
            </div>

            <!-- Controles -->
            <a class="left carousel-control" href="#slider" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
              <span class="sr-only">Anterior</span>
            </a>
            <a class="right carousel-control" href="#slider" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
              <span class="sr-only">Siguiente</span>
            </a>
          </div>

  			<div class="modal fade" id="modalIngreso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
               <div class="panel panel-primary">
     					<div class="panel panel-heading">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                     <b>Bienvenido</b>
                  </div>
     					<div class="panel panel-body" style="text-align: center">
     						<p><img src="imagenes/monitor.png" height="222"></p>
     						<form id="frmEntrar">
     					<input type="text" class="form-control input-sm" name="usuario" id="usuario" title="Usuario" placeholder="Usuario"><p></p>
                  <input type="password" class="form-control input-sm" name="clave" id="clave" title="Contraseña" placeholder="Contraseña"><p></p>
                  <input type="password" class="form-control input-sm" name="llave" id="llave" title="Llave" placeholder="Llave"><p></p>

                  <input type="reset" class="btn btn-info" name="limpiar" value="Limpiar" >
   					<span class="btn btn-primary" id="entrarSoftware">Entrar</span>
                 </form>
     					</div>
     				</div>
            </div>
  			</div>
  		</div>
  	</div>
   </body>
   <footer style="background-color: black">
      <div class="container-fluid">
         <div class="col-sm-12" style="text-align: center">
            <p></p>
            <p style="color: gray">
               Todos los derechos reservados
               <span class="glyphicon glyphicon-copyright-mark"></span>
               Gonzalo Brolyn -
               <?php echo date('Y'); ?>
            </p>
         </div>
      </div>
   </footer>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$('#entrarSoftware').click(function(){

  		vacios=validarFrmVacio('frmEntrar');
  			if(vacios > 0){
  				alert("Debes llenar todos los datos.");
  				return false;
  			}

  		datos=$('#frmEntrar').serialize();
  		$.ajax({
  			type:"POST",
  			data:datos,
  			url:"procesos/entrar.php",
  			success:function(r){
  				if(r==1){
            $('#frmEntrar')[0].reset();
            window.location="vistas/inicio.php";
  				}else{
  					alert("Acceso denegado.");
  				}
  			}
  		});
	  });
	});
</script>
