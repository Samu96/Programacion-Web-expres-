<?php
include_once './lib.php';

User::session_start();
View::start('Gestión distribuidora');
security::view(2);
    User::cerrarCesion();
    View::navigation(2);
    $product = DB::execute_sql("SELECT marca FROM bebidas ORDER BY id ASC");
	//$product->setFetchMode(PDO::FETCH_NAMED);
    if($product){
        echo "<br><form method=post action=''?action=add>";
        echo "<select name=prod>";
        $product->setFetchMode(PDO::FETCH_NAMED);
        $first=true;
        foreach($product as $game) {
            if(!$first){
                foreach($game as $field => $value){
                    echo '<option value="' . $value . '">' . $value . '</option>';
                }
                
            }else {
                $first=false;
            }
            
            
        }
        echo "</select>";
        echo "<input type=number name=cant value=1 min=1>";
        echo "<input type=submit name=add value='Añadir'>";
        echo "</form>";
    }
    
    
    if(isset($_POST['add'])){
        if(isset($_POST['cant'])){
            $producto=DB::execute_sql("SELECT * FROM bebidas WHERE marca='" . $_POST['prod'] . "'");
            $producto=$producto->fetch(PDO::FETCH_NAMED);
            
            
            $user=DB::execute_sql("SELECT id FROM usuarios WHERE usuario='" . User::getLoggedUser() . "'");
            $user=$user->fetch(PDO::FETCH_NAMED);
            
            $pedido=DB::execute_sql("SELECT id FROM pedidos WHERE idcliente='" . $user['id'] . "' and horacreacion='0'");
            $pedido=$pedido->fetch(PDO::FETCH_NAMED);
            
            $linea=DB::execute_sql("SELECT * FROM lineaspedido WHERE idpedido='" . $pedido['id'] . "'");
            $linea=$linea->fetch(PDO::FETCH_NAMED);
            
            
            if($linea['idbebida']!=$producto['id']){
                
                DB::execute_sql("INSERT INTO lineaspedido('idpedido','idbebida','unidades','PVP') VALUES('" . $pedido['id'] . "','" . $producto['id'] . "','". $_POST['cant'] ."','". $producto['PVP']. "')");
                $new=$producto['stock']-$_POST['cant'];
                DB::execute_sql("UPDATE bebidas SET stock='" . $new . "' WHERE id='" . $producto['id'] . "'");
            }else {
                
                DB::execute_sql("UPDATE lineaspedido SET unidades='" . $_POST['cant'] . "' WHERE idbebida='" . $producto['id'] . "'");
                $new=$producto['stock']-$_POST['cant'];
                DB::execute_sql("UPDATE bebidas SET stock='" . $new . "' WHERE id='" . $producto['id'] . "'");
            }
        }
    } else if (isset($_POST['fin'])){
        $user=DB::execute_sql("SELECT id FROM usuarios WHERE usuario='" . User::getLoggedUser() . "'");
        $user=$user->fetch(PDO::FETCH_NAMED);
        $pedido=DB::execute_sql("SELECT id FROM pedidos WHERE idcliente='" . $user['id'] . "' and horacreacion='0'");
        $pedido=$pedido->fetch(PDO::FETCH_NAMED);
        $res=DB::execute_sql("SELECT unidades,PVP FROM lineaspedido WHERE idpedido='" . $pedido['id'] . "'");
        $total=0;
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            $first=true;
            foreach($res as $game){
                
                if(!$first){
                    $aux=1;
                    foreach($game as $value){
                        $aux=$aux*$value;
                    }
                    $total=$total+$aux;
                    echo $total;
                }else {
                    $first=false;
                }
            }
        }
        DB::execute_sql("UPDATE pedidos SET PVP=" . $total . ", horacreacion=" . time()." WHERE id=" . $pedido['id'] );    
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=pedidos_cli.php">';
    } else if(isset($_POST['can'])){
        $user=DB::execute_sql("SELECT id FROM usuarios WHERE usuario='" . User::getLoggedUser() . "'");
        $user=$user->fetch(PDO::FETCH_NAMED);
        $pedido=DB::execute_sql("SELECT id FROM pedidos WHERE idcliente='" . $user['id'] . "' and horacreacion='0'");
        $pedido=$pedido->fetch(PDO::FETCH_NAMED);
        DB::execute_sql("DELETE FROM lineaspedido WHERE idpedido='" . $pedido['id'] . "'");
        DB::execute_sql("DELETE FROM pedidos WHERE id='" . $pedido['id'] . "'");
        
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=home_cli.php">';
    } else{   
        $res=DB::execute_sql("SELECT id FROM usuarios WHERE usuario='" . User::getLoggedUser() . "'");
        if($res){
            $aux=$res->fetch(PDO::FETCH_NAMED);
            $tmp = DB::execute_sql("SELECT id,horacreacion FROM pedidos WHERE idcliente='" . $aux['id'] . "' AND horacreacion='0'");
            $aux2=$tmp->fetch(PDO::FETCH_NAMED);
            if(!$aux2){
                DB::execute_sql("INSERT INTO pedidos('idcliente','horacreacion') VALUES ('" . $aux['id'] . "',0)");
            } 
        }
    }
    $user=DB::execute_sql("SELECT id FROM usuarios WHERE usuario='" . User::getLoggedUser() . "'");
    $user=$user->fetch(PDO::FETCH_NAMED);
    $pedido=DB::execute_sql("SELECT id FROM pedidos WHERE idcliente='" . $user['id'] . "' and horacreacion='0'");
    $pedido=$pedido->fetch(PDO::FETCH_NAMED);
    $linea=DB::execute_sql("SELECT lineaspedido.id,marca,unidades,lineaspedido.PVP FROM lineaspedido JOIN bebidas ON idbebida=bebidas.id WHERE idpedido='" . $pedido['id'] . "'");
    if($linea){
        $linea->setFetchMode(PDO::FETCH_NAMED);
            $first=true;
         
            foreach($linea as $game){
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
                        if($field=='marca'){
                            $nombre=$value;
                        }
                        echo "<th>$value</th>";
                    }else {
                        $id=$value;
                    }
                    
                }
                
                echo "<th>
                <form method=post action=''>
                <input type=hidden name=id value=$id>
                <input type=submit onclick=\"borraLinea($id,'$nombre')\" name=del value=Eliminar>
                </form>
                
                </th>";
                echo "</tr>";
              
            }
            echo '</table>';
            
            echo "<form method=post action=''>
                <input type=hidden name=id value=" . $pedido['id'] .">
                <input type=submit name=fin value=Confirmar>
                <input type=submit name=can value=Cancelar>
                </form>";
    }
    

View::end();