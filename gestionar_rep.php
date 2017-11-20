<?php
include_once './lib.php';

User::session_start();
View::start('Gestión distribuidora');

security::view(3);
   
    if(isset($_POST['asig'])){
        
        
        $sql="SELECT * FROM usuarios WHERE usuario='" . User::getLoggedUser() . "'";
        $inst=DB::execute_sql($sql);
        $res=$inst->fetch(PDO::FETCH_NAMED);
        $sql="UPDATE pedidos SET idrepartidor='" . $res['id'] . "', horaasignacion='" . time() . "' WHERE id='" . $_POST['id'] . "'";
        DB::execute_sql($sql);
        
        //header('Location: ./mis_rep.php');
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=mis_rep.php">';
    } else if(isset($_POST['rep'])){
        
        $sql="UPDATE pedidos SET horareparto='" . time() . "' WHERE id='" . $_POST['id'] . "'";
        DB::execute_sql($sql);
        //header('Location: ./mis_rep.php');
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=mis_rep.php">';
    } else if(isset($_POST['ent'])){
        
       
        $sql="UPDATE pedidos SET horaentrega='" . time() . "' WHERE id='" . $_POST['id'] . "'";
        DB::execute_sql($sql);
        //header('Location: ./mis_rep.php');
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=mis_rep.php">';
    }

View::end();