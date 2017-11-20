<?php
include_once './lib.php';
User::session_start();
View::start('Gestión distribuidora');
security::view(2);
 User::cerrarCesion();
 View::navigation(2);
    $html="<p>Bienvenido<br>
    Acciones que puede realizar como cliente:<br>
        -   Ver Bebidas<br>
        -   Realizar Pedidos<br>
        -   Ver Pedidos<br></p>";
    echo $html;
View::end();