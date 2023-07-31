<?php include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?php
    include_once 'class.crud.php';
    require_once '../tools/functions.php';
    $crud = new crud();
    $id = 0;
    $nombre = "";
    $departamento = "";
    $sweetAlertCode = "";


    if (isset($_POST['id'])) {

        $id = $_POST['id'];
        if (isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
        } else if (isset($_POST['cargo'])) {
            $nombre = $_POST['cargo'];
        }

        if (isset($_POST['departamento'])) {
            $departamento = $_POST['departamento'];
        }


        // Realiza las acciones necesarias con el ID

        $cargoDescripcion = $crud->get_cargo_descripcion_taller($id);

        $cargoDescripcion = $cargoDescripcion[0];
        $radioSeleccionado = '';

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
    }
    if (isset($_POST['btn-send'])) {
        $departamento = isset($_POST['departamento']) ? $_POST['departamento'] : '';
        $cargo = isset($_POST['cargo']) ? $_POST['cargo'] : '';
        $proposito = isset($_POST['proposito']) ? $_POST['proposito'] : '';
        $funciones = isset($_POST['funciones']) ? $_POST['funciones'] : '';
        $actividades = isset($_POST['actividades']) ? $_POST['actividades'] : '';


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



        //Make a validation for all empty fields
        if (empty($departamento) || $departamento == "") {
            $sweetAlertCode = showSweetAlert('Error', 'El campo Departamento es obligatorio.', 'error');
        } elseif (empty($cargo) || $cargo == "") {
            $sweetAlertCode = showSweetAlert('Error', 'El campo Cargo es obligatorio.', 'error');
        } elseif (empty($funciones) || $funciones == "") {
            $sweetAlertCode = showSweetAlert('Error', 'El campo Funciones es obligatorio.', 'error');
        } elseif (empty($actividades) || $actividades == "") {
            $sweetAlertCode = showSweetAlert('Error', 'El campo Actividades es obligatorio.', 'error');
        } elseif (empty($conocimiento) || $conocimiento == "") {
            $sweetAlertCode = showSweetAlert('Error', 'El campo Conocimiento es obligatorio.', 'error');
        } elseif (empty($experiencia) || $experiencia == "") {
            $sweetAlertCode = showSweetAlert('Error', 'El campo Experiencia es obligatorio.', 'error');
        } elseif (empty($especialidad) || $especialidad == "") {
            $sweetAlertCode = showSweetAlert('Error', 'El campo Especialidad es obligatorio.', 'error');
        } elseif (empty($adicional) || $adicional == "") {
            $sweetAlertCode = showSweetAlert('Error', 'El campo Adicional es obligatorio.', 'error');
        } elseif (empty($relacionesInternas) || $relacionesInternas == "") {
            $sweetAlertCode = showSweetAlert('Error', 'El campo Relaciones Internas es obligatorio.', 'error');
        } elseif (empty($relacionesExternas) || $relacionesExternas == "") {
            $sweetAlertCode = showSweetAlert('Error', 'El campo Relaciones Externas es obligatorio.', 'error');
        } elseif (empty($riesgo) || $riesgo == "") {
            $sweetAlertCode = showSweetAlert('Error', 'El campo Riesgo es obligatorio.', 'error');
        } elseif (empty($comentarios) || $comentarios == "") {
            $sweetAlertCode = showSweetAlert('Error', 'El campo Comentarios es obligatorio.', 'error');
        } elseif (empty($destrezas) || $destrezas == "") {
            $sweetAlertCode = showSweetAlert('Error', 'El campo Destrezas es obligatorio.', 'error');
        }


        if (!$sweetAlertCode) {
            $result = $crud->update_descripcion_cargo_taller(
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
                $destrezas
            );


            if ($result == 2) {
                $sweetAlertCode =
                    showSweetAlert('Exito', 'Se ha descrito el cargo con exito', 'success', 'Aceptar', '/?ca=2');
            } else {
                $sweetAlertCode = showSweetAlert('Error', 'Se ha generado un error a la hora de describir el cargo', 'error');
            }
        }
    }

    ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="card text-left">
            <div class="card-header">
                <span style="font-weight: bold; font-size: 25px">Descripción Puesto/Cargo (Planta - Taller - Fábrica)</span>
                <br>
                <span style="font-weight: bold; font-size: 25px">Cargo: <?php echo $nombre; ?> - Departamento: <?php echo $departamento; ?> </span>
            </div>
        </div>
    </section>
    <!-- Content Header (Page header) -->




    <?php echo isset($sweetAlertCode) ? $sweetAlertCode : ''; ?>

    <ul class="tabs">
        <li><a href="#tab1"><span class="fa fa-home"></span><span class="tab-text">Información</span></a></li>
        <li><a href="#tab2"><span class="fa fa-group"></span><span class="tab-text">Descripción</span></a></li>
        <li><a href="#tab3"><span class="fa fa-briefcase"></span><span class="tab-text">Ambiente e Instrumentos</span></a></li>
        <li><a href="#tab4"><span class="fa fa-bookmark"></span><span class="tab-text">Conocimientos</span></a></li>
        <li><a href="#tab5"><span class="fa fa-superpowers"></span><span class="tab-text">Relaciones</span></a></li>
        <li><a href="#tab6"><span class="fa fa-window-restore "></span><span class="tab-text">Condiciones de trabajo</span></a></li>
        <li><a href="#tab7"><span class="fa fa-arrows-h"></span><span class="tab-text">Competencias</span></a></li>
    </ul>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="assets/js/descripcion-cargo.js"></script>
    <div class="container" style="overflow: auto; max-height: 1000px;">
        <div class="secciones">
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <article id="tab1">
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="departamento">Adscrito a la Unidad / Departamento / Gerencia:</label>
                                <input type="text" value="<?php echo $cargoDescripcion["nombre_departamento"]; ?>" name="departamento" id="departamento" class="form-control" autocomplete="on">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 mt-3 mt-md-0">
                            <div class="form-group">
                                <label for="cargo">Denominación del Puesto/Cargo:</label>
                                <input type="text" value="<?php echo $cargoDescripcion["nombre_cargo"]; ?>" name="cargo" id="cargo" class="form-control" autocomplete="on">
                            </div>
                        </div>
                    </div>
                </article>

                <article id="tab2">
                    <div class="form-group">
                        <label for="funciones">Funciones:</label>
                        <small>Describa las funciones más importantes que permiten alcanzar su propósito general.</small>
                        <textarea class="form-control" id="funciones" name="funciones" rows="5"><?php echo $cargoDescripcion["funciones"]; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="actividades">Actividades:</label>
                        <small>Indique el conjunto de tareas y operaciones que se deben realizar en el cargo para el logro de las funciones anteriormente señaladas (Ubíquese en lo que se debe hacer en un día normal de su trabajo).</small>
                        <textarea class="form-control" id="actividades" name="actividades" rows="5"><?php echo $cargoDescripcion["actividades"]; ?></textarea>
                    </div>
                </article>

                <article id="tab3">
                    <div class="form-group">
                        <div class="row mt-3">
                            <label>
                                <h4>Competencias</h4>
                            </label>
                            <div class="col-xs-12 col-md-6">
                                <label for="ambientes">Ambiente de trabajo:</label>
                                <small>Se refiere a los atributos para el adecuado desempeño de las actividades y funciones del puesto o cargo. (Seleccione las principales habilidades): </small>
                                <div class="form-check">
                                    <div class="form-check">
                                        <input class="form-check-input checkbox-inline" type="checkbox" name="check_Amb[1]" id="check_Amb1" value="1" <?php if ($cargoDescripcion["ambiente1"] == 1) {
                                                                                                                                                            echo "checked";
                                                                                                                                                        } ?>>
                                        <label class="form-check-label" for="check_Amb1">Capacidad organizativa.</label>
                                        <br />
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input checkbox-inline" type="checkbox" name="check_Amb[2]" id="check_Amb2" value="1" <?php if ($cargoDescripcion["ambiente2"] == 1) {
                                                                                                                                                            echo "checked";
                                                                                                                                                        } ?>>
                                        <label class="form-check-label" for="check_Amb2">Taller</label>
                                        <br />
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input checkbox-inline" type="checkbox" name="check_Amb[3]" id="check_Amb3" value="1" <?php if ($cargoDescripcion["ambiente3"] == 1) {
                                                                                                                                                            echo "checked";
                                                                                                                                                        } ?>>
                                        <label class="form-check-label" for="check_Amb3">Fábrica ó Planta Industrial</label>
                                        <br />
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input checkbox-inline" type="checkbox" name="check_Amb[4]" id="check_Amb4" value="1" <?php if ($cargoDescripcion["ambiente4"] == 1) {
                                                                                                                                                            echo "checked";
                                                                                                                                                        } ?>>
                                        <label class="form-check-label" for="check_Amb4"> Al Aire Libre</label>
                                        <br />
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input checkbox-inline" type="checkbox" name="check_Amb[5]" id="check_Amb5" value="1" <?php if ($cargoDescripcion["ambiente5"] == 1) {
                                                                                                                                                            echo "checked";
                                                                                                                                                        } ?>>
                                        <label class="form-check-label" for="check_Amb5">Movil (Motorizado ó Chofer)</label>
                                        <br />
                                    </div>
                                </div>
                                <br />
                                <label for="instrumentos">Instrumentos de trabajo:</label>
                                <small>Se refiere a los atributos para el adecuado desempeño de las actividades y funciones del puesto o cargo. (Seleccione las principales habilidades): </small>
                                <div class="form-check">
                                    <div class="form-check">
                                        <input class="form-check-input checkbox-inline" type="checkbox" name="check_Ins[1]" id="check_Ins1" value="1" <?php if ($cargoDescripcion["instrumento1"] == 1) {
                                                                                                                                                            echo "checked";
                                                                                                                                                        } ?>>
                                        <label class="form-check-label" for="check_Ins1">Herramientas (Llaves, Martillo, Destornillador, Alicates, etc.)</label>
                                        <br />
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input checkbox-inline" type="checkbox" name="check_Ins[2]" id="check_Ins2" value="1" <?php if ($cargoDescripcion["instrumento2"] == 1) {
                                                                                                                                                            echo "checked";
                                                                                                                                                        } ?>>
                                        <label class="form-check-label" for="check_Ins2">Probadores eléctricos (probadores de voltaje, multímetro, tester eléctrico, etc.)</label>
                                        <br />
                                    </div>
                                </div>
                                <br />
                                <label for="manipular_elementos">Elementos peligrosos </label>
                                <small>
                                    Describa si para desempeñar su trabajo requiere la manipulación de liquidos u otros elementos químicos, biológicos, etc. Especifique:
                                </small>
                                <textarea class="form-control" id="manipular_elementos" name="manipular_elementos" rows="5"><?php echo $cargoDescripcion["manipular_elementos"]; ?></textarea>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <label for="maquinas">Maquinas que opera:</label>
                                <small>Se refiere a los atributos para el adecuado desempeño de las actividades y funciones del puesto o cargo. (Seleccione las principales habilidades): </small>
                                <div class="form-check">
                                    <div class="form-check">
                                        <input class="form-check-input checkbox-inline" type="checkbox" name="check_Maq[1]" id="check_Maq1" value="1" <?php if ($cargoDescripcion["maquina1"] == 1) {
                                                                                                                                                            echo "checked";
                                                                                                                                                        } ?>>
                                        <label class="form-check-label" for="check_Maq1">Computador</label>
                                        <br />
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input checkbox-inline" type="checkbox" name="check_Maq[2]" id="check_Maq2" value="1" <?php if ($cargoDescripcion["maquina2"] == 1) {
                                                                                                                                                            echo "checked";
                                                                                                                                                        } ?>>
                                        <label class="form-check-label" for="check_Maq2">Tablero Electrónico</label>
                                        <br />
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input checkbox-inline" type="checkbox" name="check_Maq[3]" id="check_Maq3" value="1" <?php if ($cargoDescripcion["maquina3"] == 1) {
                                                                                                                                                            echo "checked";
                                                                                                                                                        } ?>>
                                        <label class="form-check-label" for="check_Maq3">Torno Fresadora</label>
                                        <br />
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input checkbox-inline" type="checkbox" name="check_Maq[4]" id="check_Maq4" value="1" <?php if ($cargoDescripcion["maquina4"] == 1) {
                                                                                                                                                            echo "checked";
                                                                                                                                                        } ?>>
                                        <label class="form-check-label" for="check_Maq4">Montacargas</label>
                                        <br />
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input checkbox-inline" type="checkbox" name="check_Maq[5]" id="check_Maq5" value="1" <?php if ($cargoDescripcion["maquina5"] == 1) {
                                                                                                                                                            echo "checked";
                                                                                                                                                        } ?>>
                                        <label class="form-check-label" for="check_Maq5">Otros: (menciónelos)</label>
                                        <br />
                                    </div>
                                    <input type="text" value="<?php echo $cargoDescripcion["otras_maquinas"]; ?>" name="otras_maquinas" id="otras_maquinas" class="form-control" autocomplete="on" disabled>
                                </div>
                                <br />
                                <label for="traslados">Traslados</label>
                                <small>Describa si para desempeñar su trabajo requiere la realización de traslados: </small>
                                <div class="form-check">
                                    <div class="form-check">
                                        <input class="form-check-input checkbox-inline" type="checkbox" name="check_Tra[1]" id="check_Tra1" value="1" <?php if ($cargoDescripcion["traslado1"] == 1) {
                                                                                                                                                            echo "checked";
                                                                                                                                                        } ?>>
                                        <label class="form-check-label" for="check_Tra1">Computador</label>
                                        <br />
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input checkbox-inline" type="checkbox" name="check_Tra[2]" id="check_Tra2" value="1" <?php if ($cargoDescripcion["traslado2"] == 1) {
                                                                                                                                                            echo "checked";
                                                                                                                                                        } ?>>
                                        <label class="form-check-label" for="check_Tra2">Tablero Electrónico</label>
                                        <br />
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input checkbox-inline" type="checkbox" name="check_Tra[3]" id="check_Tra3" value="1" <?php if ($cargoDescripcion["traslado3"] == 1) {
                                                                                                                                                            echo "checked";
                                                                                                                                                        } ?>>
                                        <label class="form-check-label" for="check_Tra3">Torno Fresadora</label>
                                        <br />
                                    </div>
                                    <label for="frecuencia_traslado">Frecuencia traslados</label>
                                    <input type="text" value="<?php echo $cargoDescripcion["frecuencia_traslado"]; ?>" name="frecuencia_traslado" id="frecuencia_traslado" class="form-control" autocomplete="on">
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-12 mt-3">
                                <label for="observacion_ambiente">Observaciones</label>
                                <textarea class="form-control" id="observacion_ambiente" name="observacion_ambiente" rows="5"><?php echo $cargoDescripcion["observacion_ambiente"]; ?></textarea>
                            </div>
                        </div>
                </article>

                <script>
                    var checkbox = document.getElementById("check_Maq5");
                    var inputText = document.getElementById("otras_maquinas");

                    checkbox.addEventListener("change", function() {
                        if (this.checked) {
                            inputText.disabled = false;
                        } else {
                            inputText.disabled = true;
                        }
                    });
                </script>
                <article id="tab4">

                    <label>
                        <h4>Conocimientos</h4>
                    </label>
                    <div class="row">
                        <div class="col-xs-12 col-md-6 mt-3 mt-md-0">
                            <label for="educacionFormal">Educacion Formal</label>
                            <small></small>
                            <div class="form-check">
                                <div class="form-check">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Con[]" id="radio_Con1" value="Bachiller" <?php if ($radioConocimiento === 'radio_Con1') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Con1">Bachiller</label>
                                    <br />
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Con[]" id="radio_Con2" value="Tecnico Medio" <?php if ($radioConocimiento === 'radio_Con2') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Con2">Técnico Medio</label>
                                    <br />
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Con[]" id="radio_Con3" value="Tecnico Superior Universitario" <?php if ($radioConocimiento === 'radio_Con3') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Con3">Técnico Superior Universitario</label>
                                    <br />
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Con[]" id="radio_Con4" value="Graduado Universitario" <?php if ($radioConocimiento === 'radio_Con4') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Con4">Graduado Universitario</label>
                                    <br />
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-6">
                            <label for="experiencia">Experiencia:</label>
                            <small></small>
                            <div class="form-check">
                                <div class="form-check">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Exp[]" id="radio_Exp1" value="Menos de un (1) año" <?php if ($radioExperiencia === 'radio_Exp1') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Exp1">Menos de un (1) año</label>
                                    <br />
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Exp[]" id="radio_Exp2" value="Mas de un (1) hasta dos (2) años" <?php if ($radioExperiencia === 'radio_Exp2') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Exp2">Más de un (1) hasta dos (2) años</label>
                                    <br />
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Exp[]" id="radio_Exp3" value="Más de dos (2) a cinco (5) años" <?php if ($radioExperiencia === 'radio_Exp3') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Exp3">Más de dos (2) a cinco (5) años</label>
                                    <br />
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Exp[]" id="radio_Exp4" value="De seis (6) a nueve (9) años" <?php if ($radioExperiencia === 'radio_Exp4') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Exp4">Más de seis (6) años</label>
                                    <br />
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Exp[]" id="radio_Exp5" value="Mas de nueve (9) años" <?php if ($radioExperiencia === 'radio_Exp5') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Exp5">Más de nueve (9) años</label>
                                    <br />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="txtEspecialidad">Carrea o especialidad:</label>
                                <div class="col-xs-12">
                                    <input type="text" class="form-control input-sm" name="especialidad" id="especialidad" placeholder="" title="Especificar especialidad ó carrera." maxlength="255" value="<?php echo $cargoDescripcion["especialidad_carrera"]; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="txtespAdicional"> Conocimientos adicionales que se pueden requerir en el cargo:</label>
                                <input type="text" class="form-control input-sm" name="adicional" id="adicional" placeholder="" title="Requisitos adicionales al cargo." maxlength="255" value="<?php echo $cargoDescripcion["especialidad_adicional"]; ?>">
                            </div>
                        </div>
                    </div>

                </article>

                <article id="tab5">
                    <div class="row mt-3">
                        <label>
                            <h4>Relaciones</h4>
                        </label>
                        <div class="col-xs-12 col-md-6 mt-3 mt-md-0">
                            <label for="relacionesInternas">Relaciones internas: </label>
                            <small>
                                Con qué otras unidades de la organización deben mantener relaciones frecuentes para el logro de los resultados de su puesto. Relaciones 4 ó 5 de estas unidades (no sus superiores o subordinados). Cliente Interno
                                y describa brevemente para qué.
                            </small>
                            <textarea class="form-control" id="relacionesInternas" name="relacionesInternas" rows="5"><?php echo $cargoDescripcion["relacion_interna"]; ?></textarea>
                        </div>
                        <div class="col-xs-12 col-md-6 mt-3 mt-md-0">
                            <label for="relacionesExternas">Relaciones externas: </label>
                            <small>
                                Con qué instituciones, organismos, empresas y personas externas a la organización debe mantener relaciones frecuentes para el logro de los resultados en su puesto. Relaciones 4 ó 5 de estas y describa brevemente
                                para qué. Cliente Externo
                            </small>
                            <textarea class="form-control" id="relacionesExternas" name="relacionesExternas" rows="5"><?php echo $cargoDescripcion["relacion_externa"]; ?></textarea>
                        </div>
                    </div>
                </article>

                <article id="tab6">
                    <div class="row mt-3">
                        <div class="col-xs-12 col-md-6">
                            <label for="riesgos">Riesgos:</label>
                            <small>Experiencia mínima requerida en el puesto o cargo</small>
                            <div class="form-check">
                                <div class="form-check">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Rie[]" id="radio_Rie1" value="Minimas posibilidades de exposicion a accidentes de trabajo o enfermedades profesionales" <?php if ($radioRiesgos === 'radio_Rie1') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Rie1">Mínimas posibilidades de exposición a accidentes de trabajo o enfermedades profesionales.</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Rie[]" id="radio_Rie2" value="Medianas posibilidades de exposicion a accidentes de trabajo o enfermedades profesionales" <?php if ($radioRiesgos === 'radio_Rie2') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Rie2">Medianas posibilidades de exposición a accidentes de trabajo o enfermedades profesionales.</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Rie[]" id="radio_Rie3" value="Grandes posibilidades de exposicion a accidentes de trabajo o enfermedades profesionales" <?php if ($radioRiesgos === 'radio_Rie3') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Rie3">Grandes posibilidades de exposición a accidentes de trabajo o enfermedades profesionales.</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comentarios">Comentarios u observaciones:</label>
                        <textarea class="form-control" id="comentarios" name="comentarios" rows="5"><?php echo $cargoDescripcion["comentarios_riesgo"]; ?></textarea>
                    </div>
                </article>

                <article id="tab7">
                    <div class="row mt-3">
                        <label>
                            <h4>Competencias</h4>
                        </label>
                        <div class="col-xs-12 col-md-6">
                            <label for="habilidades">Habilidades:</label>
                            <small>Se refiere a los atributos para el adecuado desempeño de las actividades y funciones del puesto o cargo. (Seleccione las principales habilidades): </small>
                            <div class="form-check">
                                <div class="form-check">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Hab[1]" id="check_Hab1" value="1" <?php if ($cargoDescripcion["habilidad1"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Hab1">Capacidad organizativa.</label>
                                    <br />
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Hab[2]" id="check_Hab2" value="1" <?php if ($cargoDescripcion["habilidad2"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Hab2">Capacidad de razonamiento y análisis.</label>
                                    <br />
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Hab[3]" id="check_Hab3" value="1" <?php if ($cargoDescripcion["habilidad3"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Hab3">Habilidad para tratar con terceros.</label>
                                    <br />
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Hab[4]" id="check_Hab4" value="1" <?php if ($cargoDescripcion["habilidad4"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Hab4">Adecuada Expresión oral y escrita.</label>
                                    <br />
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Hab[5]" id="check_Hab5" value="1" <?php if ($cargoDescripcion["habilidad5"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Hab5">Habilidad numérica.</label>
                                    <br />
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Hab[6]" id="check_Hab6" value="1" <?php if ($cargoDescripcion["habilidad6"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Hab6">Iniciativa.</label>
                                    <br />
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Hab[7]" id="check_Hab7" value="1" <?php if ($cargoDescripcion["habilidad7"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Hab7">Orden y limpieza.</label>
                                    <br />
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Hab[8]" id="check_Hab8" value="1" <?php if ($cargoDescripcion["habilidad8"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Hab8">Apego a las normas y procedimientos.</label>
                                    <br />
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-6 mt-3 mt-md-0">
                            <label for="destrezas">Destrezas:</label>
                            <small>
                                Mencione las principales destrezas necesarias para el correcto desempeño del cargo, entendiéndose por estas, el grado de pericia en el manejo u operación de instrumentos, equipos, sistemas, computación:
                            </small>
                            <textarea class="form-control" id="destrezas" name="destrezas" rows="5"><?php echo $cargoDescripcion["destrezas"]; ?></textarea>
                        </div>
                    </div>


                    <div class="d-flex justify-content-center mt-5">
                        <button class="btn btn-success btn-lg" type="submit" name="btn-send" title="Next">Enviar</button>
                    </div>

                </article>

            </form>
        </div>
    </div>


    <?php include_once('../layouts/footer.php'); ?>
    <script src="assets/js/usuarios.js"></script>