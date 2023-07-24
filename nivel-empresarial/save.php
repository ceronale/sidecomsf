<?php
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {
    $result = $crud->crear_nivelempresarial();
    if ($result == 2) {
        header("Location: ../nivel-empresarial/?inserted");
    } else if ($result == 0) {
        header("Location: ../nivel-empresarial/?duplicate");
    } else {
        header("Location: ../nivel-empresarial/?failure");
    }
}

if (isset($_POST['update'])) {
    $result = $crud->editar_nivelempresarial();

    if ($result == 2) {
        header("Location: ../nivel-empresarial/?edited");
    } else if ($result == 0) {
        header("Location: ../nivel-empresarial/?duplicate");
    } else {
        header("Location: ../nivel-empresarial/?failureedited");
    }
}

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_nivelempresarial = $crud->eliminar_nivelempresarial($id)) {
        header("Location:  ../nivel-empresarial/");
    } else {
        header("Location:  ../nivel-empresarial/?failure");
    }
}
