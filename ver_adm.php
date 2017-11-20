<?php
include_once './lib.php';
User::session_start();
View::start('Gestión distribuidora');
security::view(1);
    User::cerrarCesion();
    View::navigation(1);
    $sql="SELECT * FROM usuarios";
    $res=DB::execute_sql($sql);
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);
        $first=true;
     
        foreach($res as $game){
            if($first){
                
                echo "<table><tr>";
                foreach($game as $field=>$value){
                    if($field!='clave' && $field!='id'){
                    echo "<th>$field</th>";
                }
                   
                }
                $first = false;
                echo "</tr>";
            }
            echo "<tr>";
            $first=true;
            foreach($game as $field=>$value){
                if($first==true){
                    $id=$value;
                    $first=false;
                } else {
                    if($field!='clave'){
                        if($field=='tipo'){
                            switch($value){
                                case 1:
                                    echo "<th>Administrador</th>";
                                    break;
                                case 2:
                                    echo "<th>Cliente</th>";
                                    break;
                                case 3:
                                    echo "<th>Repartidor</th>";
                                    break;
                            }
                        } else {
                            echo "<th>$value</th>";
                        }
                    }
                    
                }
            }
            echo "<th><form method=post action=mod_adm.php>
            <input type=hidden name=id value=$id>
            <input type=submit name=mod value=Modificar> <input type=submit name=del value=Eliminar>
            </form></th>";
            echo "</tr>";
          
        }
        echo '</table>';
    }
View::end();