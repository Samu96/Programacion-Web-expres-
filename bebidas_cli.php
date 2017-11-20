<?php
include_once './lib.php';
User::session_start();
View::start('Gestión distribuidora');
security::view(2);
    User::cerrarCesion();
    View::navigation(2);
    $sql="SELECT * FROM bebidas";
    $res=DB::execute_sql($sql);
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);
        $first=true;
     
        foreach($res as $game){
            if($first){
                echo "<table><tr>";
                foreach($game as $field=>$value){
                    if($field!='id'){
                        echo "<th>$field</th>";
                    }
                    
                }
                $first = false;
                echo "</tr>";
            }
            echo "<tr>";
            
            foreach($game as $field=>$value){
                if($field!='id'){
                    echo "<th>$value</th>";
                }
                
                
            }
            
            echo "</tr>";
          
        }
        echo '</table>';
    }

View::end();