<?php

ob_start(); // Start output buffering
$seccion = 'p_descripcion';
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

$id = isset($_POST['id']) ? $_POST['id'] : '';
$departamento = isset($_POST['departamento']) ? $_POST['departamento'] : '';
$cargo = isset($_POST['cargo']) ? $_POST['cargo'] : '';
$proposito = isset($_POST['proposito']) ? $_POST['proposito'] : '';
$funciones = isset($_POST['funciones']) ? $_POST['funciones'] : '';
$actividades = isset($_POST['actividades']) ? $_POST['actividades'] : '';

$destrezainstrumento = isset($_POST['destrezainstrumento']) ? $_POST['destrezainstrumento'] : '';
$destrezaequipo = isset($_POST['destrezaequipo']) ? $_POST['destrezaequipo'] : '';
$destrezasistema = isset($_POST['destrezasistema']) ? $_POST['destrezasistema'] : '';
$destrezacomputacion = isset($_POST['destrezacomputacion']) ? $_POST['destrezacomputacion'] : '';
$destrezaotro = isset($_POST['destrezaotro']) ? $_POST['destrezaotro'] : '';



$gasto = isset($_POST['radio_Gasto']) ? $_POST['radio_Gasto'] : '';
$empleados = isset($_POST['empleados']) ? $_POST['empleados'] : '';
$obreros = isset($_POST['obreros']) ? $_POST['obreros'] : '';
$conocimiento = isset($_POST['radio_Con']) ? $_POST['radio_Con'] : '';
$experiencia = isset($_POST['radio_Exp']) ? $_POST['radio_Exp'] : '';
$especialidad = isset($_POST['especialidad']) ? $_POST['especialidad'] : '';
$adicional = isset($_POST['adicional']) ? $_POST['adicional'] : '';
$relacionesInternas = isset($_POST['relacionesInternas']) ? $_POST['relacionesInternas'] : '';
$relacionesExternas = isset($_POST['relacionesExternas']) ? $_POST['relacionesExternas'] : '';
$manipular_elementos = isset($_POST['manipular_elementos']) ? $_POST['manipular_elementos'] : '';


$riesgo = isset($_POST['radio_Rie']) ? $_POST['radio_Rie'] : '';
$comentarios = isset($_POST['comentarios']) ? $_POST['comentarios'] : '';
$destrezas = isset($_POST['destrezas']) ? $_POST['destrezas'] : '';


$habilidades = isset($_POST['check_Hab']) ? $_POST['check_Hab'] : [];
$ambientes = isset($_POST['check_Amb']) ? $_POST['check_Amb'] : [];
$instrumentos = isset($_POST['check_Ins']) ? $_POST['check_Ins'] : [];
$maquinas = isset($_POST['check_Maq']) ? $_POST['check_Maq'] : [];
$traslados = isset($_POST['check_Tra']) ? $_POST['check_Tra'] : [];
$otras_maquinas = isset($_POST['otras_maquinas']) ? $_POST['otras_maquinas'] : '';
$frecuencia_traslado = isset($_POST['frecuencia_traslado']) ? $_POST['frecuencia_traslado'] : '';
$observacion_ambiente = isset($_POST['observacion_ambiente']) ? $_POST['observacion_ambiente'] : '';


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

$proposito = isset($_POST['proposito']) ? $_POST['proposito'] : '';




$cargoDescripcion["nombre_departamento"] =   $departamento;
$cargoDescripcion["nombre_cargo"] =   $cargo;
$cargoDescripcion["funciones"] =   $funciones;
$cargoDescripcion["actividades"] =   $actividades;
$cargoDescripcion["conocimiento"] =   $conocimiento[0];
$cargoDescripcion["experiencia"] =    $experiencia[0];
$cargoDescripcion["especialidad_carrera"] =   $especialidad;
$cargoDescripcion["especialidad_adicional"] =   $adicional;
$cargoDescripcion["relacion_interna"] =   $relacionesInternas;
$cargoDescripcion["relacion_externa"] =   $relacionesExternas;
$cargoDescripcion["riesgo"] =   $riesgo[0];
$cargoDescripcion["comentarios_riesgo"] =   $comentarios;
$cargoDescripcion["destrezas"] =   $destrezas;
$cargoDescripcion["otras_maquinas"] =   $otras_maquinas;
$cargoDescripcion["observacion_ambiente"] =   $observacion_ambiente;
$cargoDescripcion["frecuencia_traslado"] =   $frecuencia_traslado;


$habilidad1Valor = 0;
$habilidad2Valor = 0;
$habilidad3Valor = 0;
$habilidad4Valor = 0;
$habilidad5Valor = 0;
$habilidad6Valor = 0;
$habilidad7Valor = 0;
$habilidad8Valor = 0;
$habilidad9Valor = 0;
$habilidad10Valor = 0;
$habilidad11Valor = 0;
$habilidad12Valor = 0;


$ambiente1Valor = 0;
$ambiente2Valor = 0;
$ambiente3Valor = 0;
$ambiente4Valor = 0;
$ambiente5Valor = 0;
$ambiente6Valor = 0;
$ambiente7Valor = 0;
$ambiente8Valor = 0;

$instrumento1Valor = 0;
$instrumento2Valor = 0;

$maquina1Valor = 0;
$maquina2Valor = 0;
$maquina3Valor = 0;
$maquina4Valor = 0;
$maquina5Valor = 0;
$maquina6Valor = 0;

$traslado1Valor = 0;
$traslado2Valor = 0;
$traslado3Valor = 0;
$traslado4Valor = 0;
$traslado5Valor = 0;
$traslado6Valor = 0;



// Check if "Capacidad de razonamiento y análisis" checkbox is selected
if (isset($habilidades[1]) && $habilidades[1] == '1') {
    $habilidad1Valor = $habilidades[1];
}
if (isset($habilidades[2]) && $habilidades[2] == '1') {
    $habilidad2Valor = $habilidades[2];
}
if (isset($habilidades[3]) && $habilidades[3] == '1') {
    $habilidad3Valor = $habilidades[3];
}
if (isset($habilidades[4]) && $habilidades[4] == '1') {
    $habilidad4Valor = $habilidades[4];
}
if (isset($habilidades[5]) && $habilidades[5] == '1') {
    $habilidad5Valor = $habilidades[5];
}
if (isset($habilidades[6]) && $habilidades[6] == '1') {
    $habilidad6Valor = $habilidades[6];
}
if (isset($habilidades[7]) && $habilidades[7] == '1') {
    $habilidad7Valor = $habilidades[7];
}
if (isset($habilidades[8]) && $habilidades[8] == '1') {
    $habilidad8Valor = $habilidades[8];
}

$cargoDescripcion["habilidad1"] =   $habilidad1Valor;
$cargoDescripcion["habilidad2"] =   $habilidad2Valor;
$cargoDescripcion["habilidad3"] =   $habilidad3Valor;
$cargoDescripcion["habilidad4"] =   $habilidad4Valor;
$cargoDescripcion["habilidad5"] =   $habilidad5Valor;
$cargoDescripcion["habilidad6"] =   $habilidad6Valor;
$cargoDescripcion["habilidad7"] =   $habilidad7Valor;
$cargoDescripcion["habilidad8"] =   $habilidad8Valor;
$cargoDescripcion["habilidad9"] =   $habilidad9Valor;
$cargoDescripcion["habilidad10"] =   $habilidad10Valor;
$cargoDescripcion["habilidad11"] =   $habilidad11Valor;
$cargoDescripcion["habilidad12"] =   $habilidad12Valor;

// Verificar si se seleccionó la casilla "Ambiente 1"
if (isset($ambientes[1]) && $ambientes[1] == '1') {
    $ambiente1Valor = $ambientes[1];
}

// Verificar si se seleccionó la casilla "Ambiente 2"
if (isset($ambientes[2]) && $ambientes[2] == '1') {
    $ambiente2Valor = $ambientes[2];
}

// Verificar si se seleccionó la casilla "Ambiente 3"
if (isset($ambientes[3]) && $ambientes[3] == '1') {
    $ambiente3Valor = $ambientes[3];
}

// Verificar si se seleccionó la casilla "Ambiente 4"
if (isset($ambientes[4]) && $ambientes[4] == '1') {
    $ambiente4Valor = $ambientes[4];
}

// Verificar si se seleccionó la casilla "Ambiente 5"
if (isset($ambientes[5]) && $ambientes[5] == '1') {
    $ambiente5Valor = $ambientes[5];
}

// Verificar si se seleccionó la casilla "Ambiente 6"
if (isset($ambientes[6]) && $ambientes[6] == '1') {
    $ambiente6Valor = $ambientes[6];
}

// Verificar si se seleccionó la casilla "Ambiente 7"
if (isset($ambientes[7]) && $ambientes[7] == '1') {
    $ambiente7Valor = $ambientes[7];
}

// Verificar si se seleccionó la casilla "Ambiente 8"
if (isset($ambientes[8]) && $ambientes[8] == '1') {
    $ambiente8Valor = $ambientes[8];
}

$cargoDescripcion["ambiente1"] =   $ambiente1Valor;
$cargoDescripcion["ambiente2"] =   $ambiente2Valor;
$cargoDescripcion["ambiente3"] =   $ambiente3Valor;
$cargoDescripcion["ambiente4"] =   $ambiente4Valor;
$cargoDescripcion["ambiente5"] =   $ambiente5Valor;
$cargoDescripcion["ambiente6"] =   $ambiente6Valor;
$cargoDescripcion["ambiente7"] =   $ambiente7Valor;
$cargoDescripcion["ambiente8"] =   $ambiente8Valor;

// Verificar si se seleccionó la casilla "Instrumento 1"
if (isset($instrumentos[1]) && $instrumentos[1] == '1') {
    $instrumento1Valor = $instrumentos[1];
}

// Verificar si se seleccionó la casilla "Instrumento 2"
if (isset($instrumentos[2]) && $instrumentos[2] == '1') {
    $instrumento2Valor = $instrumentos[2];
}


$cargoDescripcion["instrumentos1"] = $instrumento1Valor;
$cargoDescripcion["instrumentos2"] = $instrumento2Valor;


// Verificar si se seleccionó la casilla "Máquina 1"
if (isset($maquinas[1]) && $maquinas[1] == '1') {
    $maquina1Valor = $maquinas[1];
}

// Verificar si se seleccionó la casilla "Máquina 2"
if (isset($maquinas[2]) && $maquinas[2] == '1') {
    $maquina2Valor = $maquinas[2];
}

// Verificar si se seleccionó la casilla "Máquina 3"
if (isset($maquinas[3]) && $maquinas[3] == '1') {
    $maquina3Valor = $maquinas[3];
}

// Verificar si se seleccionó la casilla "Máquina 4"
if (isset($maquinas[4]) && $maquinas[4] == '1') {
    $maquina4Valor = $maquinas[4];
}

// Verificar si se seleccionó la casilla "Máquina 5"
if (isset($maquinas[5]) && $maquinas[5] == '1') {
    $maquina5Valor = $maquinas[5];
}

// Verificar si se seleccionó la casilla "Máquina 6"
if (isset($maquinas[6]) && $maquinas[6] == '1') {
    $maquina6Valor = $maquinas[6];
}

$cargoDescripcion["maquina1"] = $maquina1Valor;
$cargoDescripcion["maquina2"] = $maquina2Valor;
$cargoDescripcion["maquina3"] = $maquina3Valor;
$cargoDescripcion["maquina4"] = $maquina4Valor;
$cargoDescripcion["maquina5"] = $maquina5Valor;
$cargoDescripcion["maquina6"] = $maquina6Valor;


// Verificar si se seleccionó la casilla "Traslado 1"
if (isset($traslados[1]) && $traslados[1] == '1') {
    $traslado1Valor = $traslados[1];
}

// Verificar si se seleccionó la casilla "Traslado 2"
if (isset($traslados[2]) && $traslados[2] == '1') {
    $traslado2Valor = $traslados[2];
}

// Verificar si se seleccionó la casilla "Traslado 3"
if (isset($traslados[3]) && $traslados[3] == '1') {
    $traslado3Valor = $traslados[3];
}

// Verificar si se seleccionó la casilla "Traslado 4"
if (isset($traslados[4]) && $traslados[4] == '1') {
    $traslado4Valor = $traslados[4];
}

// Verificar si se seleccionó la casilla "Traslado 5"
if (isset($traslados[5]) && $traslados[5] == '1') {
    $traslado5Valor = $traslados[5];
}

// Verificar si se seleccionó la casilla "Traslado 6"
if (isset($traslados[6]) && $traslados[6] == '1') {
    $traslado6Valor = $traslados[6];
}

$cargoDescripcion["traslado1"] = $traslado1Valor;
$cargoDescripcion["traslado2"] = $traslado2Valor;
$cargoDescripcion["traslado3"] = $traslado3Valor;
$cargoDescripcion["traslado4"] = $traslado4Valor;
$cargoDescripcion["traslado5"] = $traslado5Valor;
$cargoDescripcion["traslado6"] = $traslado6Valor;


switch ($cargoDescripcion["conocimiento"]) {
    case 'Bachiller':
        $radioConocimiento = 'radio_Con1';
        break;
    case 'Tecnico Medio':
        $radioConocimiento = 'radio_Con2';
        break;
    case 'Tecnico Superior Universitario':
        $radioConocimiento = 'radio_Con3';
        break;
    case 'Graduado Universitario':
        $radioConocimiento = 'radio_Con4';
        break;
    default:
        $radioConocimiento = ''; // Assign default radio button if desired or handle the case based on your logic
        break;
}

switch ($cargoDescripcion["experiencia"]) {
    case 'Menos de un (1) año':
        $radioExperiencia = 'radio_Exp1';
        break;
    case 'Mas de un (1) hasta dos (2) años':
        $radioExperiencia = 'radio_Exp2';
        break;
    case 'Mas de dos (2) a cinco (5) años':
        $radioExperiencia = 'radio_Exp3';
        break;
    case 'De seis (6) a nueve (9) años':
        $radioExperiencia = 'radio_Exp4';
        break;
    case 'Mas de nueve (9) años':
        $radioExperiencia = 'radio_Exp5';
        break;
    default:
        $radioExperiencia = ''; // Assign default radio button if desired or handle the case based on your logic
        break;
}

switch ($cargoDescripcion["riesgo"]) {
    case 'Minimas posibilidades de exposicion a accidentes de trabajo o enfermedades profesionales';
        $radioRiesgos = 'radio_Rie1';
        break;
    case 'Medianas posibilidades de exposicion a accidentes de trabajo o enfermedades profesionales':
        $radioRiesgos = 'radio_Rie2';
        break;
    case 'Grandes posibilidades de exposicion a accidentes de trabajo o enfermedades profesionales':
        $radioRiesgos = 'radio_Rie3';
        break;
    default:
        $radioRiesgos = ''; // Assign default radio button if desired or handle the case based on your logic
        break;
}





try {
    if ($crud->update_descripcion_cargo_taller(
        $id,
        $funciones,
        $actividades,
        $ambiente1Valor,
        $ambiente2Valor,
        $ambiente3Valor,
        $ambiente4Valor,
        $ambiente5Valor,
        $instrumento1Valor,
        $instrumento2Valor,
        $manipular_elementos,
        $maquina1Valor,
        $maquina2Valor,
        $maquina3Valor,
        $maquina4Valor,
        $maquina5Valor,
        $maquina6Valor,
        $otras_maquinas,
        $traslado1Valor,
        $traslado2Valor,
        $traslado3Valor,
        $traslado4Valor,
        $frecuencia_traslado,
        $observacion_ambiente,
        $conocimiento[0],
        $especialidad,
        $adicional,
        $experiencia[0],
        $relacionesInternas,
        $relacionesExternas,
        $riesgo[0],
        $comentarios,
        $habilidad1Valor,
        $habilidad2Valor,
        $habilidad3Valor,
        $habilidad4Valor,
        $habilidad5Valor,
        $habilidad6Valor,
        $habilidad7Valor,
        $habilidad8Valor,
        $destrezas,
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
        $destrezainstrumento,
        $destrezaequipo,
        $destrezasistema,
        $destrezacomputacion,
        $destrezaotro
    )) {
        header("Location: ../cargos/?ca=2&des&inserteddes");
    } else {
        header("Location: ../cargos/?ca=1&des&faildes");
    }
} catch (Exception $e) {
    // código de manejo de error
    echo "Error al registrar la empresa: " . $e->getMessage();
}
