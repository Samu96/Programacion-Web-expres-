<?php
include_once './lib.php';
User::session_start();
View::start('Gestión distribuidora');
security::view(1);
User::cerrarCesion();
View::navigation(1);
    $id=$_POST['id'];
    
    if(isset($_POST['enviar'])){
    
        $cont=md5($_POST['cont']);
        $sql="UPDATE usuarios SET clave='$cont' WHERE id=$id";
        DB::execute_sql($sql);
        //header('Location: ./ver_adm.php');
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./ver_adm.php">';
    }
    $form=
            "<form method=post action=''>
            <div id=div-1>
            <label for=cont>Nueva Contraseña :</label>
            <input type=password name=cont id=cont>
            <input type=hidden name=id value=$id>
            <input type=submit name=enviar value=Enviar></form>
            </div>";
    echo $form;


View::end();