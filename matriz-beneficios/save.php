<?php
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {
    if ($crud->crear_periodo()) {
        header("Location: ../matriz-beneficios/?inserted");
    } else {
        header("Location: ../matriz-beneficios/?failure");
    }
}


if (isset($_POST['update'])) {
    if ($crud->crear_calculo()) {
        header("Location: ../matriz-beneficios/?inserted");
    } else {
        header("Location: ../matriz-beneficios/?failure");
    }
}

if (isset($_POST['insertCheck'])) {
    $beneficioId = $_POST['beneficioId'];
    $nivelId = $_POST['nivelId'];
    $id_pe = $_POST['id_pe'];
    if ($crud->insertNivelBeneficio($beneficioId, $nivelId, $id_pe)) {
        header("Location: ../matriz-beneficios/?inserted");
    } else {
        header("Location: ../matriz-beneficios/?failure");
    }
}

if (isset($_POST['deleteCheck'])) {
    $beneficioId = $_POST['beneficioId'];
    $nivelId = $_POST['nivelId'];
    $id_pe = $_POST['id_pe'];
    if ($crud->deleteNivelBeneficio($beneficioId, $nivelId, $id_pe)) {
        header("Location: ../matriz-beneficios/?inserted");
    } else {
        header("Location: ../matriz-beneficios/?failure");
    }
}
