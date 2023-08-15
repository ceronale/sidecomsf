<?php
$seccion = 'p_setup';
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();




if (isset($_POST['add'])) {
    $aux = $crud->crear_producto();
    if ($aux == 2) {
        header("Location: ../productos-servicios/?inserted");
    } elseif ($aux == 1) {
        header("Location: ../productos-servicios/?same");
    } else {
        header("Location: ../productos-servicios/?failure");
    }
}

if (isset($_POST['update'])) {
    $aux = $crud->editar_producto();
    if ($aux == 2) {
        header("Location: ../productos-servicios/?edited");
    } elseif ($aux == 1) {
        header("Location: ../productos-servicios/?same");
    } else {
        header("Location: ../productos-servicios/?failureedited");
    }
}

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_departamento = $crud->eliminar_producto($id)) {
        header("Location:  ../productos-servicios/");
    } else {
        header("Location:  ../productos-servicios/?failure");
    }
}
