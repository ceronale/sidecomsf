<?php
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();
$empresa = strip_tags($_POST['empresa']);
$tributaria = strip_tags($_POST['tributaria']);
$pais = strip_tags($_POST['pais']);
$ciudad = strip_tags($_POST['ciudad']);
$estado = strip_tags($_POST['estado']);
$direccion = strip_tags($_POST['direccion']);
$telefonos = strip_tags($_POST['telefonos']);
$codigo_postal = strip_tags($_POST['codigo_postal']);
$tipo_empresa = strip_tags($_POST['tipo-empresa']);
$sector = strip_tags($_POST['sector']);
$moneda = strip_tags($_POST['moneda-seleccionada']);
$nombrerh = strip_tags($_POST['nombrerh']);
$puestorh = strip_tags($_POST['puestorh']);
$emailrh = strip_tags($_POST['emailrh']);


$mision = strip_tags($_POST['mision']);
$vision = strip_tags($_POST['vision']);
$valores = strip_tags($_POST['valores']);

$telefonorh = strip_tags($_POST['telefonorh']);
if (isset($_POST['valor_activos'])) {
    $valor_activos = strip_tags($_POST['valor_activos']);
} else {
    $valor_activos = 0;
}
if (isset($_POST['volumen_ventas'])) {
    $volumen_ventas = strip_tags($_POST['volumen_ventas']);
} else {
    $volumen_ventas = 0;
}
if (isset($_POST['opcionPersonalizada'])) {
    $opcionPersonalizada = strip_tags($_POST['opcionPersonalizada']);
    if ($opcionPersonalizada == '') {
        $actividad = strip_tags($_POST['actividad']);
        $checkedActividad = false;
    } else {
        $checkedActividad = true;
        $actividad = $opcionPersonalizada;
    }
} else {
    $actividad = strip_tags($_POST['actividad']);
    $checkedActividad = false;
}
if (isset($_POST['opcionPersonalizada2'])) {
    $opcionPersonalizada2 = strip_tags($_POST['opcionPersonalizada2']);
    if ($opcionPersonalizada2 == '') {
        $productos_servicios = strip_tags($_POST['productos-servicios']);
        $checkedActividad2 = false;
    } else {
        $checkedActividad2 = true;
        $productos_servicios = $opcionPersonalizada2;
    }
} else {
    $productos_servicios = strip_tags($_POST['productos-servicios']);
    $checkedActividad2 = false;
}

$nivel_empresarial = strip_tags($_POST['nivel-empresarial']);
// $escala_administrativo = strip_tags($_POST['escala_administrativo']);
//$escala_planta = strip_tags($_POST['escala_planta']);
try {
    if ($crud->doRegisterEmpresa(
        $empresa,
        $tributaria,
        $direccion,
        $pais,
        $ciudad,
        $estado,
        $telefonos,
        $codigo_postal,
        $tipo_empresa,
        $sector,
        $actividad,
        $productos_servicios,
        //$escala_administrativo,
        //$escala_planta,
        $nivel_empresarial,
        $valor_activos,
        $volumen_ventas,
        $moneda,
        $nombrerh,
        $puestorh,
        $emailrh,
        $telefonorh,
        $mision,
        $vision,
        $valores

    )) {
        header("Location: ../dashboard/?inserted");
    } else {
        header("Location: ../insert-empresa/?failure");
    }
} catch (Exception $e) {
    // código de manejo de error
    echo "Error al registrar la empresa: " . $e->getMessage();
}
