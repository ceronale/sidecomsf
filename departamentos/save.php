<?php
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {

    $aux = $crud->crear_departamento();
    if ($aux == 2) {
        header("Location: ../departamentos/?ca=" . $_GET['ca'] . "&inserted");
    } elseif ($aux == 1) {
        header("Location: ../departamentos/?ca=" . $_GET['ca'] . "&failureSameDpto");
    } else {
        header("Location: ../departamentos/?ca=" . $_GET['ca'] . "&failure");
    }


}

if (isset($_POST['update'])) {

    $aux = $crud->editar_departamento();
    if ($aux == 2) {
        header("Location: ../departamentos/?ca=" . $_GET['ca'] . "&edited");
    } elseif ($aux == 1) {
        header("Location: ../departamentos/?ca=" . $_GET['ca'] . "&failureSameDpto");
    } else {
        header("Location: ../departamentos/?ca=" . $_GET['ca'] . "&failureedited");
    }
}

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_departamento = $crud->eliminar_departamento($id)) {
        header("Location:  ../departamentos/?ca=" . $_GET['ca']);
    } else {
        header("Location:  ../departamentos/?failure&ca=" . $_GET['ca']);
    }
}
