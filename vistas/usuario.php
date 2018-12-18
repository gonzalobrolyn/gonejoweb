
<?php
  session_start();
  if(isset($_SESSION['usuarioNombre']) && ($_SESSION['usuarioCargo']=="Empresa" || $_SESSION['usuarioCargo']=="Administrador")){
    require_once "menu.php";
?>

<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-2">
          <h2>Nuevo Usuario</h2>
          <form id="frmUsuario">
            <input type="text" name="usuario" id="usuario" placeholder="Usuario" title="Usuario" class="form-control"><p></p>
            <input type="password" name="clave" id="clave" placeholder="Contraseña" title="Contraseña" class="form-control"><p></p>
            <input type="text" name="dni" id="dni" placeholder="DNI" title="DNI" class="form-control"><p></p>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre" title="Nombre" class="form-control"><p></p>
            <input type="text" name="apellido" id="apellido" placeholder="Apellido" title="Apellido" class="form-control"><p></p>
            <input type="text" name="celular" id="celular" placeholder="Celular" title="Celular" class="form-control"><p></p>
            <select class="form-control" name="cargo" id="cargo" title="Selecciona Cargo">
              <option value="A">Selecciona Cargo</option>
              <option value="Administrador">Administrador</option>
              <option value="Vendedor">Vendedor</option>
              <option value="Tecnico">Tecnico</option>
            </select><p></p>
            <input type="text" name="sueldo" id="sueldo" placeholder="Sueldo S/" title="Sueldo S/" class="form-control"><p></p>
            <input type="text" name="diapago" id="diapago" placeholder="Dia de pago" title="Dia de pago" class="form-control"><p></p>
            <input type="reset" class="btn btn-danger" name="Limpiar" value="Limpiar">
            <span class="btn btn-success" id="btnAgregaUsuario">Agregar</span>
          </form>
        </div>
        <div class="col-sm-10">

            <h2>Datos de Usuarios</h2>
            <div id="cargaTablaUsuarios"></div>

        </div>
      </div>
    </div>
  </body>
</html>

<script type="text/javascript">
  $(document).ready(function(){
    $('#cargaTablaUsuarios').load('tablas/tablaUsuarios.php');
    $('#btnAgregaUsuario').click(function(){

      vacios = validarFrmVacio('frmUsuario');
      if(vacios > 0){
        alertify.alert("Debes llenar todos los datos.");
        return false;
      }

      datos = $('#frmUsuario').serialize();
      $.ajax({
        type:"POST",
        data:datos,
        url:"../procesos/usuarios/agregarUsuario.php",
        success:function(r){
          if(r==1){
            $('#frmUsuario')[0].reset();
            $('#cargaTablaUsuarios').load('tablas/tablaUsuarios.php');
            alertify.success("Agregado con exito.");
          }else{
            alertify.error("Fallo al agregar.");
          }
        }
      });
    });
  });
</script>

<?php
} else {
  header("location:inicio.php");
}
?>
