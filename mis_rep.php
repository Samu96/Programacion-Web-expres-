<?php
include_once './lib.php';

User::session_start();
View::start('Gestión distribuidora');
security::view(3);
  User::cerrarCesion();
  View::navigation(3);
    $user=User::getLoggedUser();
    $sql="SELECT id FROM usuarios WHERE usuario='$user'";
   
    
    $res=DB::execute_sql($sql);
    $res2=$res->fetch(PDO::FETCH_NAMED);
    
    $id=$res2['id'];
   
    $sql="SELECT * FROM pedidos WHERE idrepartidor='$id'";
    $res=DB::execute_sql($sql);
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);
        
        $first=true;
     
        foreach($res as $game){
            
            if($first){
                echo "<table><tr>";
                foreach($game as $field=>$value){
                    if($field!='id' && $field!='idcliente' &&$field!='idrepartidor' && $field!='PVP'  ){
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
                if(($field=='horaasignacion' || $field=='horacreacion' || $field=='horareparto' || $field=='horaentrega')&&$value!=0){
                    $date = date("F j, Y, g:i a", $value);
                    echo "<th>$date</th>";
                }else {
                    if($field!='id' && $field!='idcliente' &&$field!='idrepartidor'   && $field!='PVP'){
                        echo "<th>$value</th>";
                    }
                }
            }
            $sql="SELECT horareparto, horaentrega FROM pedidos WHERE id='$id'";
            $aux=DB::execute_sql($sql);
            $aux2=$aux->fetch(PDO::FETCH_NAMED);
            $hrep= $aux2['horareparto'];
            $hent= $aux2['horaentrega'];
            echo "<th><form method=post action=./gestionar_rep.php>
            <input type=hidden name=id value=$id>";
            if($hrep==0){
            
                echo "<input type=submit name=rep value=Repartir>"; 
            
            } else if($hent==0){
                echo "<input type=submit name=ent value=Entregado>";
            }
            echo "</form></th>";
            echo "</tr>";
            
        }
        echo '</table>';
        
    } else {
        $html="<div id=div-1>
        No tiene pedidos asignados
        </div>";
        echo $html;
    }
View::end();