<?php
include_once './lib.php';
View::start('Gestión distribuidora');
User::session_start();
security::view(3);
 User::cerrarCesion();
 View::navigation(3);
    $html="
    <p>Bienvenido<br>
    Acciones que puede realizar como repartidor:<br>
        -   Ver Pedidos No Asignados<br>
        -   Ver Mis Pedidos Asignados<br></p>
    ";
    echo $html;
    
View::end();