function none(){
    document.getElementById('type').style.display ='none';
}

function block(){
    document.getElementById('type').style.display ='block';
}
function comprueba(){
    
    if(document.pepe.usuario.value.length<4 ){
        document.getElementById('size').style.display ='inline';
        
        if(document.pepe.nombre.value.length<4){
            document.getElementById('size2').style.display ='inline';
            return false;
        }else{
            document.getElementById('size2').style.display ='none';
        }
        return false;
    }
    if(document.pepe.nombre.value.length<4){
        document.getElementById('size2').style.display ='inline';
        if(document.pepe.nombre.value.length<4){
            document.getElementById('size').style.display ='none';
        }
        return false;
    }
}

function borraLinea(id,name){
    if(!confirm('¿Desea borrar la bebida "'+name+'"?')){
       return;
    }
    var ajax= new XMLHttpRequest();
    ajax.onreadystatechange=function(){
        if(this.readyState== 4 && this.status == 200) {
            var res= JSON.parse(this.responseText); //resultado formato JSON {deleted:lógico}
            if(res.deleted === true){
                var fila=document.querySelector('#fila'+id); //Se usa id por la clausura
                fila.parentNode.removeChild(fila); //Eliminamos la fila del juego
            }
        }
    };
    ajax.open("post","borra_linea.php",true);
    ajax.setRequestHeader("Content-Type","application/json;charset=UTF-8");
    ajax.send(JSON.stringify({"id":id})); //Formato {id:identificador de registro a borrar}
}