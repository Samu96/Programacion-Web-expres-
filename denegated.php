<?php
include_once './lib.php';
User::session_start();
View::start('Gestión distribuidora');
  User::cerrarCesion();
  View::navigation(0);
    $html="<p>Error: No tienes permisos para acceder
    </p>
    <form method=post action=index.php><input type=submit name=del value=Volver></form>
    ";
    echo $html;

View::end();
?>
