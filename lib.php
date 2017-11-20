<?php
class View{
    public static function  start($title){
        $html = "<!DOCTYPE html>
<html>
<head>
<meta charset=\"utf-8\">
<link rel=\"stylesheet\" type=\"text/css\" href=\"estilos.css\">
<script src=\"scripts.js\"></script>
<title>$title</title>
</head>
<body id='cuerpo'>";
echo'<div id="banner" align="right"><img src="images/logo.png" alt="CSS: No hay imagen">';
    echo'</div>';
        User::session_start();
        echo $html;
    }
    public static function navigation($type){
        switch($type){
        case 0:
            $user = User::getLoggedUser();
            echo '<nav>';
            if($user === false){
            
                echo'<div id="principal2">';
                echo'<ul id="nav">';
                echo' <li><a href="login.php" class="linkInicio">Login</a></li>';
                echo'<li><a href="#" class="linkNosotros">Quiénes somos</a></li>';
                echo'<li><a href="#" class="linkContacto">Contáctanos</a></li>';
                echo'</ul>';
                echo' </div>';
            }else{
                switch(User::getLoggedPerm()){
                    case 1:
                        echo header('location:./home_adm.php');
                        break;
                    case 2:
                        echo header('location:./home_cli.php');
                        break;
                    case 3:
                        echo header('location:./home_rep.php');
                        break;
                }
            }
            
            echo '</nav>';
            
            break;
        case 1:
            echo '<nav>';
            echo'<div id="principal2">';
            echo'<ul id="nav">';
            echo' <li><a href="home_adm.php" >Administrador</a></li>';
            echo'<li><a href="crear_adm.php" >Crear Ususario</a></li>';
            echo'<li><a href="ver_adm.php" >Ver Usuarios</a></li>';
            echo'</ul>';
            echo' </div>';
            echo '</nav>';
            break;
        case 2:
            echo '<nav>';
            echo'<div id="principal2">';
            echo'<ul id="nav">';
            echo' <li><a href="home_cli.php" >Cliente</a></li>';
            echo'<li><a href="crear_pedido_cli.php" >Hacer Pedido</a></li>';
            echo'<li><a href="pedidos_cli.php" >Mis Pedidos</a></li>';
            echo'<li><a href="bebidas_cli.php" >Bebidas</a></li>';
            echo'</ul>';
            echo' </div>';
            echo '</nav>';
            break;
        case 3:
            echo '<nav>';
            echo'<div id="principal2">';
            echo'<ul id="nav">';
            echo' <li><a href="home_rep.php" >Repartidor</a></li>';
            echo'<li><a href="todos_rep.php" >Pedido</a></li>';
            echo'<li><a href="mis_rep.php" >Mis Pedidos</a></li>';
            echo'</ul>';
            echo' </div>';
            echo '</nav>';
            break;
        
        } 
    }
    public static function end(){
        echo '</body>
</html>';
    }
}

class DB{
    private static $connection=null;
    public static function get(){
        if(self::$connection === null){
            self::$connection = $db = new PDO("sqlite:./datos.db");
            self::$connection->exec('PRAGMA foreign_keys = ON;');
            self::$connection->exec('PRAGMA encoding="UTF-8";');
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }
    public static function execute_sql($sql,$parms=null){
        try {
            $db = self::get();
            $ints= $db->prepare ( $sql );
            if ($ints->execute($parms)) {
                return $ints;
            }
        }
        catch (PDOException $e) {
            echo '<h3>Error en al DB: ' . $e->getMessage() . '</h3>';
        }
        return $false;
    }
}
class User{
    public static function session_start(){
        if(session_status () === PHP_SESSION_NONE){
            session_start();
        }
    }
    public static function getLoggedUser(){ //Devuelve un array con los datos del cuenta o false
        self::session_start();
        if(!isset($_SESSION['user'])) return false;
        return $_SESSION['user'];
    }
    public static function login($usuario,$pass){ //Devuelve verdadero o falso según
        self::session_start();
        $db=DB::get();
        $inst=$db->prepare('SELECT * FROM usuarios WHERE usuario=? and clave=?');
        $inst->execute(array($usuario,md5($pass)));
        $res=$inst->Fetch(PDO::FETCH_NAMED);
        if($res){
            $_SESSION['user']=$res['usuario']; //Almacena datos del usuario en la sesión
            $_SESSION['user_type']=$res['tipo'];
            return true;
        }
        return false;
    }
    public static function logout(){
        self::session_start();
        unset($_SESSION['user']);
    }
    
        public static function formularioLogin(){
        echo'<div id="bordeForm">
<form id="formLoggin" name="form1" method="post">
  <table align="center">
   <tr>
      <td>Usuario</td>
      <td><label for="c_usr"></label>
      <input type = "text" name = "usuario"></td>
    </tr>
    
    <tr>
      <td>Clave</td>
      <td><label for="c_usr"></label>
      <input type = "password" name = "clave"></td>
    </tr>
    
    <tr>
      <td align="center"><input type="submit" name="enviar" id="enviar" value="Acceder"></td>
    </tr>
  </table>
</form>
</div>';
    }
    public static function getLoggedPerm(){ //Devuelve un array con los datos del cuenta o false
        self::session_start();
        if(!isset($_SESSION['user_type'])) return false;
      
        return $_SESSION['user_type'];
    }
    
    //Código del botón logOut
    public static function cerrarCesion(){
          echo '<form name="form2" method="post">
 <div border="0" align="right">
      <tr></tr><td align="right"><input type="submit" name="logout" id="logout" value="LogOut"></td></tr>
  </div>
</form>';
     if(isset($_POST["logout"])){
        header('location:logout.php');
        }
    }
    
 }

class security{
    public static function view($permiso){
        if($permiso != User::getLoggedPerm()){
            header("location: denegated.php");
        }
        
    }
}