<?php
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();



if (isset($_POST['add'])) {
    $aux = $crud->crear_relacion();
    if ($aux == 2) {
        header("Location: ../relacion-externa/?inserted");
    } elseif ($aux == 1) {
        header("Location: ../relacion-externa/?same");
    } else {
        header("Location: ../relacion-externa/?failure");
    }
}




if (isset($_POST['update'])) {
    $aux = $crud->editar_relacion();
    if ($aux == 2) {
        header("Location: ../relacion-externa/?edited");
    } elseif ($aux == 1) {
        header("Location: ../relacion-externa/?same");
    } else {
        header("Location: ../relacion-externa/?failureedited");
    }
}


if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_relacion = $crud->eliminar_relacion($id)) {
        header("Location:  ../relacion-externa/");
    } else {
        header("Location:  ../relacion-externa/?failure");
    }
}
