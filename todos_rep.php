<?php
include_once './lib.php';

User::session_start();
View::start('Gestión distribuidora');
security::view(3);
 User::cerrarCesion();
   
   View::navigation(3);
   
    $sql="SELECT * FROM pedidos WHERE idrepartidor is null ";
    $res=DB::execute_sql($sql);
   
        
    if($res){
        
        $res->setFetchMode(PDO::FETCH_NAMED);
        $first=true;
     
        foreach($res as $game){
            
            if($first){
                echo "<table><tr>";
                foreach($game as $field=>$value){
                    if($field!='id' && $field!='idcliente' &&$field!='idrepartidor'  && $field!='PVP'  ){
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
                }
                if($field=='horacreacion'){
                    $date = date("F j, Y, g:i a", $value);
                    echo "<th>$date</th>";
                } else {
                    if($field!='id' && $field!='idcliente' &&$field!='idrepartidor'  && $field!='PVP'  ){
                        echo "<th>$value</th>";
                    }
                }
            }
            echo "<th><form method=post action=./gestionar_rep.php>
            <input type=hidden name=id value=$id>
            <input type=submit name=asig value=Asignar>
            </form></th>";
            echo "</tr>";
          
        }
        echo '</table>';
    } else {
        $html="<div id=div-1>
        No tiene pedidos por asignar
        </div>";
        echo $html;
    }
    
View::end();