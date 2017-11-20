<?php
include_once 'lib.php';
echo '<h1 id="nombre"> Práctica en equipo</h1>';
$mensaje = '';
if(isset($_POST['usuario']) && isset($_POST['clave'])){
    if(User::login($_POST['usuario'], $_POST['clave'])){
        //header('location:index.php');
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
        die;
    }else{
        $mensaje = '<h3>Error. Intentelo de nuevo</h3>';
    }
}

View::start('login');
View::navigation(0);
echo $mensaje;
User::formularioLogin();

View::end();

?>

  
    