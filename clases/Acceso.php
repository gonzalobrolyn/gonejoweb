
<?php
  require_once "Gonexion.php";

  class acceso{

    public function entrarUsuario($datos){
      $c = new conectar();
      $conexion = $c->conexion();

      $sqlUsuario = "SELECT *
                       from usuario
                      where usuario_nombre = '$datos[0]'
                        and usuario_clave = '$datos[1]'";
      $consultaUsuario = mysqli_query($conexion, $sqlUsuario);
      $resultadoUsuario = mysqli_num_rows($consultaUsuario);

      $sqlCaja = "SELECT *
                     from caja
                    where caja_llave = '$datos[2]'";
      $consultaCaja = mysqli_query($conexion, $sqlCaja);
      $resultadoCaja = mysqli_num_rows($consultaCaja);

      if($resultadoUsuario>0 && $resultadoCaja>0) {
        $_SESSION['usuarioNombre'] = $datos[0];
        $_SESSION['usuarioID'] = self::traeUID($datos);
        $_SESSION['usuarioCargo'] = self::traeUCargo($datos);
        $_SESSION['usuarioCaja'] = self::traeUCaja($datos);
        $_SESSION['cajaID'] = self::traeCID($datos);
        $_SESSION['cajaUsuario'] = self::traeCUsuario($datos);
        $_SESSION['cajaLlave'] = $datos[2];
        if ($_SESSION['usuarioCaja'] == $_SESSION['cajaID']) {
          return 1;
        } elseif ($_SESSION['usuarioID'] == $_SESSION['cajaUsuario']) {
          return 1;
        } elseif ($_SESSION['usuarioCargo']=="Empresa" && $_SESSION['cajaUsuario']==1) {
          return 1;
        } else {
          return 0;
        }
      } else {
        return 0;
      }
    }

    public function traeUID($datos){
      $c = new conectar();
      $conexion = $c->conexion();
      $sql = "SELECT usuario_id
                from usuario
               where usuario_nombre = '$datos[0]'
                 and usuario_clave = '$datos[1]'";
      $result = mysqli_query($conexion, $sql);
      return mysqli_fetch_row($result)[0];
    }

    public function traeUCargo($datos){
      $c = new conectar();
      $conexion = $c->conexion();
      $sql = "SELECT usuario_cargo
                from usuario
               where usuario_nombre = '$datos[0]'
                 and usuario_clave = '$datos[1]'";
      $result = mysqli_query($conexion, $sql);
      return mysqli_fetch_row($result)[0];
    }

    public function traeUCaja($datos){
      $c = new conectar();
      $conexion = $c->conexion();
      $sql = "SELECT usuario_caja
                from usuario
               where usuario_nombre = '$datos[0]'
                 and usuario_clave = '$datos[1]'";
      $result = mysqli_query($conexion, $sql);
      return mysqli_fetch_row($result)[0];
    }

    public function traeCID($datos){
      $c = new conectar();
      $conexion = $c->conexion();
      $sql = "SELECT caja_id
                from caja
               where caja_llave = '$datos[2]'";
      $result = mysqli_query($conexion, $sql);
      return mysqli_fetch_row($result)[0];
    }

    public function traeCUsuario($datos){
      $c = new conectar();
      $conexion = $c->conexion();
      $sql = "SELECT caja_usuario
                from caja
               where caja_llave = '$datos[2]'";
      $result = mysqli_query($conexion, $sql);
      return mysqli_fetch_row($result)[0];
    }
  }
?>
