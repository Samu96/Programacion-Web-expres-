<?php
include_once './lib.php';
User::session_start();
View::start('Gestión distribuidora');
security::view(2);
    User::cerrarCesion();
    View::navigation(2);
    if(isset($_POST['ver'])){
    
        $sql="SELECT * FROM lineaspedido WHERE idpedido='" . $_POST['idped'] . "'";
        $res=DB::execute_sql($sql);
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            $first=true;
         
            foreach($res as $game){
                if($first){
                    echo "<table><tr>";
                    foreach($game as $field=>$value){
                        echo "<th>$field</th>";
                    }
                    $first = false;
                    echo "</tr>";
                }
                echo "<tr>";
                
                foreach($game as $field=>$value){
                    
                    echo "<th>$value</th>";
                    
                }
                echo "</tr>";
              
            }
            echo '</table>';
        }
        
        
    }
View::end();