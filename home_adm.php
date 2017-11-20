<?php
include_once './lib.php';
User::session_start();
View::start('Gestión distribuidora');
security::view(1);
  User::cerrarCesion();
  View::navigation(1);
    $html="<p>Bienvenido<br>
    Acciones que puede realizar como administrador:<br>
        -   Crear Usuarios<br>
        -   Modificar Usuarios<br>
        -   Borrar Usuarios<br></p>";
    echo $html;

View::end();
?>

