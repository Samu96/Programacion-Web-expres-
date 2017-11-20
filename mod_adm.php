<?php
include_once './lib.php';

User::session_start();
View::start('Gestión distribuidora');

security::view(1);
    User::cerrarCesion();
    View::navigation(1);
    $id=$_POST['id'];
    
     if(isset($_POST['enviar'])){
           
            
        $user=$_POST['usuario'];
        $nombre=$_POST['nombre'];
        $tipo=$_POST['tipo'];
        $pob=$_POST['poblacion'];
        $dir=$_POST['direccion'];
        $sql="UPDATE usuarios SET usuario='$user',nombre='$nombre',
        poblacion='$pob',direccion='$dir',tipo='$tipo' WHERE id=$id";
        DB::execute_sql($sql);
       
        //header('Location: ./ver_adm.php');
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=ver_adm.php">';
     }
    if(isset($_POST['mod'])){
       
            $sql="SELECT * FROM usuarios WHERE id='$id'";
            
            $res=DB::execute_sql($sql);
    
            $res->execute();
            $res2=$res->fetch(PDO::FETCH_NAMED);
            $user=$res2['usuario'];
            $nombre=$res2['nombre'];
            $tipo=$res2['tipo'];
            $pob=$res2['poblacion'];
            $dir=$res2['direccion'];
            echo $nombre;
            $form=
            "<form method=post action=''>
            <div id=div-1>
            <label for=usuario>Usuario :</label>
            <input type=text name=usuario id=usuario value='$user'><br>
            <label for=nombre>Nombre :</label>
            <input type=text name=nombre id=nombre value='$nombre'><br>
            <label for=poblacion>Poblacion :</label>
            <input type=text name=poblacion id=poblacion value='$pob'><br>
            <label for=direccion>Direccion :</label>
            <input type=text name=direccion id=direccion value='$dir'><br>";
            switch($tipo){
                
                case 1:
                    $form=$form . "<input type=radio name=tipo value=1 CHECKED> Administrador<br>
                    <input type=radio name=tipo value=2> Cliente<br>
                    <input type=radio name=tipo value=3> Repartidor<br>";
                    break;
                case 2:
                    $form=$form . "<input type=radio name=tipo value=1 > Administrador<br>
                    <input type=radio name=tipo value=2 CHECKED> Cliente<br>
                    <input type=radio name=tipo value=3> Repartidor<br>";
                    break;
                case 3:
                    $form=$form . "<input type=radio name=tipo value=1 > Administrador<br>
                    <input type=radio name=tipo value=2> Cliente<br>
                    <input type=radio name=tipo value=3 CHECKED> Repartidor<br>";
                    break;
            }
            $form=$form . "<input type=hidden name=id value=$id>
            <input type=submit name=enviar value=Enviar></form>
            <form method=post action='./cont_adm.php'>
            <input type=hidden name=id value=$id>
            <input type=submit name=cont value='Cambiar Contraseña'></form>
            </form>
            </div>";
            echo $form;
    } else if (isset($_POST['del'])){
          
            $id=$_POST['id'];          
            $sql="DELETE FROM usuarios WHERE id=$id";
            DB::execute_sql($sql);
           
        //header('Location: ./ver_adm.php');
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=ver_adm.php">';
        
    }

View::end();