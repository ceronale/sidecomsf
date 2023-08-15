<?php
ob_start(); // Start output buffering
$seccion = 'p_escalas';
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

$escala_administrativo  = isset($_POST['escala_administrativo']) ? $_POST['escala_administrativo'] : '';
$escala_planta  = isset($_POST['escala_planta']) ? $_POST['escala_planta'] : '';

try {
    if ($crud->changeEscala($escala_administrativo, $escala_planta)) {
        header("Location: ../escalas/?inserted");
    } else {
        header("Location: ../escalas/?failure");
    }
} catch (Exception $e) {
    // código de manejo de error
    echo "Error al registrar la empresa: " . $e->getMessage();
}

ob_end_flush(); // Send the output buffer