<?php
include_once './lib.php';
User::session_start();
View::start('Gestión distribuidora');
security::view(1);
    User::cerrarCesion();
    View::navigation(1);
    
    if(isset($_POST['enviar'])){
        $user=$_POST['usuario'];
        $pass=md5($_POST['clave']);
        $nombre=$_POST['nombre'];
        $tipo=$_POST['tipo'];
        $pob=$_POST['poblacion'];
        $dir=$_POST['direccion'];
        $sql="INSERT INTO usuarios('usuario','clave','nombre','tipo','poblacion','direccion')
        VALUES('$user','$pass','$nombre','$tipo','$pob','$dir')";
        
       
        DB::execute_sql($sql);
        
       
        //header('Location: ./ver_adm.php');
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=ver_adm.php">';
       
    } 
        
        $form=
        "<form name='pepe' method=post action='' onSubmit='return comprueba()'>
        <div id=div-1>
        <label for=usuario>Usuario :</label>
        <input type=text name=usuario id=usuario  required><label id='size' for=usuario>  Debe tener más de 4 caracteres</label><br>
        <label for=clave>Clave :</label>
        <input type=password name=clave id=clave required><br>
        <label for=nombre>Nombre :</label>
        <input type=text name=nombre id=nombre required><label id='size2' for=nombre2>  Debe tener más de 4 caracteres </label><br>
        <input type=radio name=tipo value=1 onclick='none()' required> Administrador<br>
        <input type=radio name=tipo value=2 onclick='block()' required> Cliente<br>
        <input type=radio name=tipo value=3 onclick='none()' required> Repartidor<br>
        <div id='type'><label for=poblacion>Poblacion :</label>
        <input type=text name=poblacion id=poblacion><br>
        <label for=direccion>Direccion :</label>
        <input type=text name=direccion id=direccion><br></div>
        <input type=submit name=enviar value=Enviar > <input type=reset name=limpiar value=Limpiar>
        </div>
        </form>";
        echo $form;
View::end();