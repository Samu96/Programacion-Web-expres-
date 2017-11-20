<?php
include_once './lib.php';

User::session_start();
View::start('Gestión distribuidora');
security::view(2);
    User::cerrarCesion();
    View::navigation(2);
    $user=User::getLoggedUser();
    $sql="SELECT id FROM usuarios WHERE usuario='$user'";
    $res=DB::execute_sql($sql);
    $res2=$res->fetch(PDO::FETCH_NAMED);
    
    $id=$res2['id'];
   
    $sql="SELECT * FROM pedidos WHERE idcliente='$id'  and horacreacion !='0'";
    $res=DB::execute_sql($sql);
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);
        $first=true;
     
        foreach($res as $game){
            if($first){
                echo "<table><tr>";
                foreach($game as $field=>$value){
                    if($field!='id' && $field!='idcliente' &&$field!='idrepartidor'  ){
                        echo "<th>$field</th>";
                    }
                }
                $first = false;
                echo "</tr>";
            }
            echo "<tr>";
            
            foreach($game as $field=>$value){
                
                if($field=='id'){
                    $idped=$value;
                
                }
                if(($field=='horaasignacion' || $field=='horacreacion' || $field=='horareparto' || $field=='horaentrega')&&$value!=0){
                    $date = date("F j, Y, g:i a", $value);
                    echo "<th>$date</th>";
                }else {
                    
                    if($field!='id' && $field!='idcliente' &&$field!='idrepartidor'){
                        echo "<th>$value</th>";
                    }
                }
                
            }
            
            echo "<th><form method=post action=./ver_pedido_cli.php>
            <input type=hidden name=idped value='$idped'>
            <input type=submit name=ver value='Ver Pedido'> 
            </form></th>";
            
            echo "</tr>";
          
        }
        echo '</table>';
    } else {
        $html="<div id=div-1>
        No ha hecho ningún pedido
        </div>";
        echo $html;
    }
View::end();