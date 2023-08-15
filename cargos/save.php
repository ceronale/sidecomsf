<?php
$seccion = 'p_cargos';
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {
    $categoria = $_GET['ca'];
    $aux = $crud->crear_cargo();
    if ($aux == 2) {
        header("Location: ../cargos/?ca=" . $categoria . "&inserted&new");
    } elseif ($aux == 1) {
        header("Location: ../cargos/?ca=" . $categoria . "&failureSameCargo&new");
    } else {
        header("Location: ../cargos/?ca=" . $categoria . "&failure&new");
    }
}

if (isset($_POST['update'])) {
    $categoria = $_GET['ca'];
    $aux = $crud->editar_cargo();
    if ($aux == 2) {
        header("Location: ../cargos/?ca=" . $categoria . "&edited&new");
    } elseif ($aux == 1) {
        header("Location: ../cargos/?ca=" . $categoria . "&failureSameCargo&new");
    } else {
        header("Location: ../cargos/?ca=" . $categoria . "&failureedited&new");
    }
}

if (isset($_GET['deleteid'])) {
    $categoria = $_GET['ca'];
    $id = $_GET['deleteid'];
    if ($eliminar_cargo = $crud->eliminar_cargo($id)) {
        header("Location:  ../cargos/?ca=" . $categoria . "&new");
    } else {
        header("Location:  ../cargos/?failure?ca=" . $categoria . "&new");
    }
}

if (isset($_POST['btn-save-val'])) {
    if (isset($_GET['va'])) {
        $categoria = $_GET['ca'];
        $id_cargo = $_GET['idc'];
        if ($valoracion_adm = $crud->editar_valoracion_adm($id_cargo)) {
            header("Location:  ../cargos/?val&ca=" . $categoria);
        } else {
            header("Location:  ../cargos/?val&ca=" . $categoria . "&failure");
        }
    }
}


if (isset($_POST['btn-save-val-direct'])) {
    if (isset($_GET['va'])) {
        $categoria = $_GET['ca'];
        $id_cargo = $_GET['idc'];
        if ($valoracion_adm = $crud->editar_valoracion_adm_direct($id_cargo)) {
            header("Location:  ../cargos/?val&ca=" . $categoria);
        } else {
            header("Location:  ../cargos/?val&ca=" . $categoria . "&failure");
        }
    }
}


if (isset($_POST['btn-save-val'])) {
    if (isset($_GET['vt'])) {
        $categoria = $_GET['ca'];
        $id_cargo = $_GET['idc'];
        if ($valoracion_adm = $crud->editar_valoracion_taller($id_cargo)) {
            header("Location:  ../cargos/?val&ca=" . $categoria);
        } else {
            header("Location:  ../cargos/val&?failure");
        }
    }
}

if (isset($_POST['btn-save-val-direct'])) {
    if (isset($_GET['vt'])) {
        $categoria = $_GET['ca'];
        $id_cargo = $_GET['idc'];
        if ($valoracion_adm = $crud->editar_valoracion_taller_direct($id_cargo)) {
            header("Location:  ../cargos/?val&ca=" . $categoria);
        } else {
            header("Location:  ../cargos/?val&ca=" . $categoria . "&failure");
        }
    }
}