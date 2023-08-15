<?php
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {
    $id_usuario = $crud->crear_usuario();
    if ($id_usuario != 1 && $id_usuario != 0) {
        $contador = 1;
 
            foreach ($_POST as $clave=>$valor)
                {
                        if ($clave != 'add' && $clave != 'status' && $clave != 'password' && $clave != 'apellido' &&  $clave != 'cargo' && $clave != 'email' && $clave != 'nombre')
                        {
                        if ($_POST[$clave]=='on'){$valor='1';} else {$valor='0';}
                        if ($contador == 1){
                        $filtro = $clave . "=" . $valor;
                        $contador = 2;
                        
                        } else{ 
                        $filtro = $filtro.", ".$clave."=".$valor;      
                        }
                    
                        }
                }
    
           
            if($guardar_permisos =  $crud->guardar_permisos($id_usuario,$filtro))
            {
                header("Location: ../usuarios/?inserted");
            }
            else
            {
                header("Location: ../usuarios/?failure");
            }
 
    } elseif ($id_usuario == 1) {
        header("Location: ../usuarios/?failureSameEmail");
    } elseif($id_usuario == 0) {
        header("Location: ../usuarios/?failure");
    }
}

if (isset($_POST['update'])) {

    $id_usuario = $_GET['id'];
    $aux = $crud->editar_usuario();
    if ($aux == 2) {
        $contador = 1;
        foreach ($_POST as $clave=>$valor)
            {
                    if ($clave != 'update' &&  $clave != 'lastemail' && $clave != 'id' && $clave != 'status' && $clave != 'password' && $clave != 'apellido' &&  $clave != 'cargo' && $clave != 'email' && $clave != 'nombre')
                    {
                    if ($_POST[$clave]=='on'){$valor='1';} else {$valor='0';}
                    if ($contador == 1){
                    $filtro = $clave . "=" . $valor;
                    $contador = 2;
                    
                    } else{ 
                    $filtro = $filtro.", ".$clave."=".$valor;      
                    }
                
                    }
            }
        if($guardar_permisos =  $crud->guardar_permisos($id_usuario,$filtro))
        {
            header("Location: ../usuarios/?edited");
        }
        else
        {
            header("Location: ../usuarios/?failure");
        }
    } elseif ($aux == 1) {
        header("Location: ../usuarios/?failureSameEmail");
    } else {
        header("Location: ../usuarios/?failureedited");
    }
}

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_usuario = $crud->eliminar_usuario($id)) {
        header("Location:  ../usuarios/");
    } else {
        header("Location:  ../usuarios/?failure");
    }
}
