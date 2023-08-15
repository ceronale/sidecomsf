<?php
$seccion = 'p_nomina';
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {
    if ($crud->crear_nomina()) {
        header("Location: ../matriz-nomina/?inserted&ca=1");
    } else {
       header("Location: ../matriz-nomina/?failure&ca=1");
    }
}

if (isset($_POST['update'])) {

    if ($crud->editar_nomina()) {
        header("Location: ../matriz-nomina/?edited&ca=1");
    } else {
        header("Location: ../matriz-nomina/?failureedited&ca=1");
    }
}

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_departamento = $crud->eliminar_nomina($id)) {
        header("Location:  ../matriz-nomina/?ca=1");
    } else {
        header("Location:  ../matriz-nomina/?failure&ca=1");
    }
}
