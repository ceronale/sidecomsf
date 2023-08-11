<?php

ob_start(); // Start output buffering

include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

$id = isset($_POST['id']) ? $_POST['id'] : '';
$destrezainstrumento = isset($_POST['destrezainstrumento']) ? $_POST['destrezainstrumento'] : '';
$destrezaequipo = isset($_POST['destrezaequipo']) ? $_POST['destrezaequipo'] : '';
$destrezasistema = isset($_POST['destrezasistema']) ? $_POST['destrezasistema'] : '';
$destrezacomputacion = isset($_POST['destrezacomputacion']) ? $_POST['destrezacomputacion'] : '';
$destrezaotro = isset($_POST['destrezaotro']) ? $_POST['destrezaotro'] : '';

$fecha_preparacion = isset($_POST['fecha_preparacion']) ? $_POST['fecha_preparacion'] : '';
$revisado = isset($_POST['revisado']) ? $_POST['revisado'] : '';
$supervisor = isset($_POST['supervisor']) ? $_POST['supervisor'] : '';
$funcion1 = isset($_POST['funcion1']) ? $_POST['funcion1'] : '';
$funcion2 = isset($_POST['funcion2']) ? $_POST['funcion2'] : '';
$funcion3 = isset($_POST['funcion3']) ? $_POST['funcion3'] : '';
$funcion4 = isset($_POST['funcion4']) ? $_POST['funcion4'] : '';
$funcion5 = isset($_POST['funcion5']) ? $_POST['funcion5'] : '';
$funcion6 = isset($_POST['funcion6']) ? $_POST['funcion6'] : '';
$funcion7 = isset($_POST['funcion7']) ? $_POST['funcion7'] : '';
$funcion8 = isset($_POST['funcion8']) ? $_POST['funcion8'] : '';
$funcion9 = isset($_POST['funcion9']) ? $_POST['funcion9'] : '';
$funcion10 = isset($_POST['funcion10']) ? $_POST['funcion10'] : '';

$competencia1 = isset($_POST['competencia1']) ? $_POST['competencia1'] : '';
$competencia2 = isset($_POST['competencia2']) ? $_POST['competencia2'] : '';
$competencia3 = isset($_POST['competencia3']) ? $_POST['competencia3'] : '';
$competencia4 = isset($_POST['competencia4']) ? $_POST['competencia4'] : '';
$competencia5 = isset($_POST['competencia5']) ? $_POST['competencia5'] : '';
$competencia6 = isset($_POST['competencia6']) ? $_POST['competencia6'] : '';
$competencia7 = isset($_POST['competencia7']) ? $_POST['competencia7'] : '';
$competencia8 = isset($_POST['competencia8']) ? $_POST['competencia8'] : '';
$competencia9 = isset($_POST['competencia9']) ? $_POST['competencia9'] : '';
$competencia10 = isset($_POST['competencia10']) ? $_POST['competencia10'] : '';

$actividad1 = isset($_POST['actividad1']) ? $_POST['actividad1'] : '';
$actividad2 = isset($_POST['actividad2']) ? $_POST['actividad2'] : '';
$actividad3 = isset($_POST['actividad3']) ? $_POST['actividad3'] : '';
$actividad4 = isset($_POST['actividad4']) ? $_POST['actividad4'] : '';
$actividad5 = isset($_POST['actividad5']) ? $_POST['actividad5'] : '';
$actividad6 = isset($_POST['actividad6']) ? $_POST['actividad6'] : '';
$actividad7 = isset($_POST['actividad7']) ? $_POST['actividad7'] : '';
$actividad8 = isset($_POST['actividad8']) ? $_POST['actividad8'] : '';
$actividad9 = isset($_POST['actividad9']) ? $_POST['actividad9'] : '';
$actividad10 = isset($_POST['actividad10']) ? $_POST['actividad10'] : '';
$actividad11 = isset($_POST['actividad11']) ? $_POST['actividad11'] : '';
$actividad12 = isset($_POST['actividad12']) ? $_POST['actividad12'] : '';
$actividad13 = isset($_POST['actividad13']) ? $_POST['actividad13'] : '';
$actividad14 = isset($_POST['actividad14']) ? $_POST['actividad14'] : '';
$actividad15 = isset($_POST['actividad15']) ? $_POST['actividad15'] : '';

$selectactividad1 = isset($_POST['selectactividad1']) ? $_POST['selectactividad1'] : '';
$selectactividad2 = isset($_POST['selectactividad2']) ? $_POST['selectactividad2'] : '';
$selectactividad3 = isset($_POST['selectactividad3']) ? $_POST['selectactividad3'] : '';
$selectactividad4 = isset($_POST['selectactividad4']) ? $_POST['selectactividad4'] : '';
$selectactividad5 = isset($_POST['selectactividad5']) ? $_POST['selectactividad5'] : '';
$selectactividad6 = isset($_POST['selectactividad6']) ? $_POST['selectactividad6'] : '';
$selectactividad7 = isset($_POST['selectactividad7']) ? $_POST['selectactividad7'] : '';
$selectactividad8 = isset($_POST['selectactividad8']) ? $_POST['selectactividad8'] : '';
$selectactividad9 = isset($_POST['selectactividad9']) ? $_POST['selectactividad9'] : '';
$selectactividad10 = isset($_POST['selectactividad10']) ? $_POST['selectactividad10'] : '';
$selectactividad11 = isset($_POST['selectactividad11']) ? $_POST['selectactividad11'] : '';
$selectactividad12 = isset($_POST['selectactividad12']) ? $_POST['selectactividad12'] : '';
$selectactividad13 = isset($_POST['selectactividad13']) ? $_POST['selectactividad13'] : '';
$selectactividad14 = isset($_POST['selectactividad14']) ? $_POST['selectactividad14'] : '';
$selectactividad15 = isset($_POST['selectactividad15']) ? $_POST['selectactividad15'] : '';

$departamento = isset($_POST['departamento']) ? $_POST['departamento'] : '';
$cargo = isset($_POST['cargo']) ? $_POST['cargo'] : '';


$organigrama = isset($_POST['radio_Org']) ? $_POST['radio_Org'] : '';

$ambiente = isset($_POST['radio_Amb']) ? $_POST['radio_Amb'] : '';
$otroambiente = isset($_POST['otroambiente']) ? $_POST['otroambiente'] : '';
if ($ambiente[0] == "Otro") {
    $ambiente[0] = $otroambiente;
}

$instrumento = isset($_POST['radio_Ins']) ? $_POST['radio_Ins'] : '';
$otroinstrumento = isset($_POST['otroinstrumento']) ? $_POST['otroinstrumento'] : '';
if ($instrumento[0] == "Otro") {
    $instrumento[0] = $otroinstrumento;
}

$manipulacion = isset($_POST['radio_Man']) ? $_POST['radio_Man'] : '';
$otromanipulacion = isset($_POST['otromanipulacion']) ? $_POST['otromanipulacion'] : '';
if ($manipulacion[0] == "Otro") {
    $manipulacion[0] = $otromanipulacion;
}

$traslado = isset($_POST['radio_Tras']) ? $_POST['radio_Tras'] : '';
$otrotraslado = isset($_POST['otrotraslado']) ? $_POST['otrotraslado'] : '';
if ($traslado[0] == "Otro") {
    $traslado[0] = $otrotraslado;
}


$proposito = isset($_POST['proposito']) ? $_POST['proposito'] : '';
$funciones = isset($_POST['funciones']) ? $_POST['funciones'] : '';

$presupuesto = isset($_POST['radio_Ppto']) ? $_POST['radio_Ppto'] : '';
$ingreso = isset($_POST['radio_Ingr']) ? $_POST['radio_Ingr'] : '';
$gasto = isset($_POST['radio_Gasto']) ? $_POST['radio_Gasto'] : '';
$empleados = isset($_POST['empleados']) ? $_POST['empleados'] : '';
$obreros = isset($_POST['obreros']) ? $_POST['obreros'] : '';
$ejecutivos = isset($_POST['ejecutivos']) ? $_POST['ejecutivos'] : '';
$conocimiento = isset($_POST['radio_Con']) ? $_POST['radio_Con'] : '';
$experiencia = isset($_POST['radio_Exp']) ? $_POST['radio_Exp'] : '';
$especialidad = isset($_POST['especialidad']) ? $_POST['especialidad'] : '';
$adicional = isset($_POST['adicional']) ? $_POST['adicional'] : '';

$relacionesInternas = isset($_POST['relacionesInternas']) ? $_POST['relacionesInternas'] : array();
$relacionesExternas = isset($_POST['relacionesExternas']) ? $_POST['relacionesExternas'] : array();
$idiomas = isset($_POST['idiomas']) ? $_POST['idiomas'] : array();

$relacionesInternasString = implode(", ", $relacionesInternas);
$relacionesExternasString = implode(", ", $relacionesExternas);
$idiomasString = implode(", ", $idiomas);

$ambientales = isset($_POST['radio_Ambz']) ? $_POST['radio_Ambz'] : '';
$riesgo = isset($_POST['radio_Rie']) ? $_POST['radio_Rie'] : '';
$comentarios = isset($_POST['comentarios']) ? $_POST['comentarios'] : '';
$destrezas = isset($_POST['destrezas']) ? $_POST['destrezas'] : '';
$habilidades = isset($_POST['check_Hab']) ? $_POST['check_Hab'] : [];
$conocimientos = isset($_POST['check_Con']) ? $_POST['check_Con'] : [];



$conocimiento1Valor = 0;
$conocimiento2Valor = 0;
$conocimiento3Valor = 0;
$conocimiento4Valor = 0;
$conocimiento5Valor = 0;
$conocimiento6Valor = 0;
$conocimiento7Valor = 0;

// Check if "Conocimiento" checkbox is selected
if (isset($conocimientos[1]) && $conocimientos[1] == '1') {
    $conocimiento1Valor = $conocimientos[1];
}
if (isset($conocimientos[2]) && $conocimientos[2] == '1') {
    $conocimiento2Valor = $conocimientos[2];
}
if (isset($conocimientos[3]) && $conocimientos[3] == '1') {
    $conocimiento3Valor = $conocimientos[3];
}
if (isset($conocimientos[4]) && $conocimientos[4] == '1') {
    $conocimiento4Valor = $conocimientos[4];
}
if (isset($conocimientos[5]) && $conocimientos[5] == '1') {
    $conocimiento5Valor = $conocimientos[5];
}
if (isset($conocimientos[6]) && $conocimientos[6] == '1') {
    $conocimiento6Valor = $conocimientos[6];
}
if (isset($conocimientos[7]) && $conocimientos[7] == '1') {
    $conocimiento7Valor = $conocimientos[7];
}




$conocimiento1texto = isset($_POST['conocimiento1texto']) ? $_POST['conocimiento1texto'] : '';
$conocimiento2texto = isset($_POST['conocimiento2texto']) ? $_POST['conocimiento2texto'] : '';
$conocimiento3texto = isset($_POST['conocimiento3texto']) ? $_POST['conocimiento3texto'] : '';
$conocimiento4texto = isset($_POST['conocimiento4texto']) ? $_POST['conocimiento4texto'] : '';
$conocimiento5texto = isset($_POST['conocimiento5texto']) ? $_POST['conocimiento5texto'] : '';
$conocimiento6texto = isset($_POST['conocimiento6texto']) ? $_POST['conocimiento6texto'] : '';
$conocimiento7texto = isset($_POST['conocimiento7texto']) ? $_POST['conocimiento7texto'] : '';




try {
    if ($crud->update_descripcion_cargo(
        $id,
        $organigrama[0],
        $proposito,
        $funcion2,
        $funcion1,
        $funcion3,
        $funcion4,
        $funcion5,
        $funcion6,
        $funcion7,
        $funcion8,
        $funcion9,
        $funcion10,
        $actividad1,
        $actividad2,
        $actividad3,
        $actividad4,
        $actividad5,
        $actividad6,
        $actividad7,
        $actividad8,
        $actividad9,
        $actividad10,
        $actividad11,
        $actividad12,
        $actividad13,
        $actividad14,
        $actividad15,
        $selectactividad1,
        $selectactividad2,
        $selectactividad3,
        $selectactividad4,
        $selectactividad5,
        $selectactividad6,
        $selectactividad7,
        $selectactividad8,
        $selectactividad9,
        $selectactividad10,
        $selectactividad11,
        $selectactividad12,
        $selectactividad13,
        $selectactividad14,
        $selectactividad15,
        $conocimiento1Valor,
        $conocimiento2Valor,
        $conocimiento3Valor,
        $conocimiento4Valor,
        $conocimiento5Valor,
        $conocimiento6Valor,
        $conocimiento7Valor,
        $conocimiento1texto,
        $conocimiento2texto,
        $conocimiento3texto,
        $conocimiento4texto,
        $conocimiento5texto,
        $conocimiento6texto,
        $conocimiento7texto,
        $competencia1,
        $competencia2,
        $competencia3,
        $competencia4,
        $competencia5,
        $competencia6,
        $competencia7,
        $competencia8,
        $competencia9,
        $competencia10,
        $presupuesto[0],
        $ingreso[0],
        $gasto[0],
        $empleados,
        $obreros,
        $ejecutivos,
        $especialidad,
        $adicional,
        $relacionesInternasString,
        $relacionesExternasString,
        $ambientales[0],
        $riesgo[0],
        $comentarios,
        $destrezas,
        $fecha_preparacion,
        $revisado,
        $supervisor,
        $ambiente[0],
        $instrumento[0],
        $manipulacion[0],
        $traslado[0],
        $destrezainstrumento,
        $destrezaequipo,
        $destrezasistema,
        $destrezacomputacion,
        $destrezaotro,
        $experiencia[0],
        $idiomasString
    )) {
        header("Location: ../cargos/?ca=1&des&inserteddes");
    } else {
        header("Location: ../cargos/?ca=1&des&faildes");
    }
} catch (Exception $e) {
    // código de manejo de error
    echo "Error al registrar la empresa: " . $e->getMessage();
}
