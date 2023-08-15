<?php 
$seccion = 'p_perfil_organizacion';
include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; ?>
<link rel="stylesheet" href="../assets/css/stylebuttons.css">
<?php
session_start();
require_once("class.crud.php");
require_once '../tools/functions.php';
$error = "";
$crud = new crud();
$user = $_SESSION['user'];

//Consultas a la bd
$getEmpresa = $crud->get_empresa($user['id_empresa']);
$countries = $crud->get_countries();
$niveles = $crud->get_nivel();
$acitvity = $crud->get_acitvity();
$products = $crud->get_products();
$tipo_sector = $crud->get_sector();
$tipo_empresas = $crud->get_tipo_empresa();
$tipo_frecuencia_salarial = $crud->get_tipo_frecuencia_salarial();
$escalas_planta = $crud->get_escala_planta();
$escalas_administrativo = $crud->get_escala_administrativo();

//Inicializaciíon de variables para el form
$id = $getEmpresa['id'];
$empresa = $getEmpresa['nombre'];
$tributaria  = $getEmpresa['codigo_tributario'];
$direccion = $getEmpresa['direccion'];
$pais = $getEmpresa['id_pais'];
$ciudad = $getEmpresa['ciudad'];
$estado = $getEmpresa['estado'];
$telefonos = $getEmpresa['telefonos'];
$codigo_postal  = $getEmpresa['zipcode'];
$actividad = $getEmpresa['actividad'];
$tipo_empresa = $getEmpresa['id_tipoempresa'];
$sector = $getEmpresa['id_sector'];
$total_empleados = $getEmpresa['total_empleados'];
$total_obreros = $getEmpresa['total_obreros'];
$id_frecuenciasalarial = $getEmpresa['id_frecuenciasalarial'];
$porcentaje_aumento = $getEmpresa['porcentaje_aumento'];
$status = $getEmpresa['status'];
$creado = $getEmpresa['creado'];
$modificado = $getEmpresa['modificado'];
$escala_administrativo  = $getEmpresa['id_escala_administrativo'];
$escala_planta = $getEmpresa['id_escala_planta'];
$productos_servicios = $getEmpresa['productos_servicios'];
$nivel_empresarial = $getEmpresa['nivel_empresarial'];
$volumen_ventas = $getEmpresa['volumen_ventas'];
$valor_activos = $getEmpresa['valor_activos'];
$moneda = $getEmpresa['moneda'];
$nombrerh = $getEmpresa['nombrerh'];
$puestorh = $getEmpresa['puestorh'];
$emailrh = $getEmpresa['emailrh'];
$telefonorh = $getEmpresa['telefonorh'];
$moneda_pais = $getEmpresa['moneda_pais'];

$mision = $getEmpresa['mision'];
$vision = $getEmpresa['vision'];
$valores = $getEmpresa['valores'];

$opciones = array('EUR', 'USD');

if (!in_array($moneda_pais, $opciones)) { // Si $moneda_pais no está en $opciones, se agrega como tercera opción
    $opciones[] = $moneda_pais;
}

$codigo_telefonico = $getEmpresa['codigo_telefonico'];
$checkedActividad = false;
$checkedActividad2 = false;
$opcionPersonalizada = isset($_POST['opcionPersonalizada']) ? $_POST['opcionPersonalizada'] : '';
$opcionPersonalizada2 = isset($_POST['opcionPersonalizada2']) ? $_POST['opcionPersonalizada2'] : '';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="card text-left">
            <div class="card-header">
                <span style="font-weight: bold; font-size: 25px">Perfil Empresa / Organismo / Entidad</span>
            </div>
        </div>
    </section>
    <!-- Content Header (Page header) -->

    <?php

    include_once 'class.crud.php';
    $crud = new crud();
    if (isset($_POST['btn-send'])) {
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
        $telefonorh = strip_tags($_POST['telefonorh']);


        $mision = strip_tags($_POST['mision']);
        $vision = strip_tags($_POST['vision']);
        $valores = strip_tags($_POST['valores']);
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
        try {
            $result = $crud->doRegisterEmpresa(
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
                $escala_administrativo,
                $escala_planta,
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
            );
        } catch (Exception $e) {
            // código de manejo de error
            echo "Error al registrar la empresa: " . $e->getMessage();
        }
        if ($result == 2) {

            $currentURL = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $currentURL .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $basePath = dirname($currentURL);
            $sweetAlertCode = showSweetAlert('Exito', 'La empresa se ha editado correctamente', 'success', 'Aceptar', '/empresa');
        } else {
            $sweetAlertCode = showSweetAlert('Error', 'Se ha generado un error a la hora de editar la empresa', 'error');
            echo '<script>
        window.onload = function() {
            // Aquí puedes agregar tu función JavaScript
            cambiarValor();
            alternarInput();
        };
    </script>';
        }
    }

    ?>

    <div class='container' style="overflow: auto; max-height: 600px;">
        <?php echo isset($sweetAlertCode) ? $sweetAlertCode : ''; ?>
    </div>
    <div class='container' style="overflow: auto; max-height: 600px;">
        <form method="post">
            <div class="form-row ">
                <div class="col-12 col-sm-3">
                    <label for="empresa">Empresa, Entidad u Organismo</label>
                    <input class="multisteps-form__input form-control" type="text" id="empresa" name="empresa" placeholder="Empresa, Entidad u Organismo" value="<?php echo $empresa; ?>" maxLength="150">
                </div>
                <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                    <label for="tributaria">Identificación Tributaria</label>
                    <input class="multisteps-form__input form-control" type="text" id="tributaria" name="tributaria" placeholder="Identificación Tributaria" value="<?php echo $tributaria; ?>" maxLength="20">
                </div>
                <div class="col-12 col-sm-3">
                    <label for="pais">País</label>
                    <select id="pais" name="pais" onchange="cambiarValor()">
                        <option value="">País</option>
                        <?php
                        $selectedPais = $pais;
                        if ($countries) {
                            foreach ($countries as $country) {
                                $countryName = $country['nombre'];
                                $countryId = $country['id'];
                                $countryCode = $country['codigotelefonico'];
                                $countryMoneda = $country['moneda'];
                                $selected = ($selectedPais == $countryId) ? "selected" : "";
                                echo "<option value=\"$countryId\" data-code=\"$countryCode\" data-moneda=\"$countryMoneda\" $selected>$countryName</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-12 col-sm-1">
                    <label for="moneda">Moneda</label>
                    <input class="multisteps-form__input form-control" type="text" id="moneda" name="moneda" placeholder="Moneda" maxLength="30" value="<?php echo $moneda_pais; ?>" disabled>
                </div>
                <script>
                    function cambiarValor() {
                        var select = document.getElementById("pais");
                        var selectedOption = select.options[select.selectedIndex];
                        var countryCode = selectedOption.getAttribute("data-code");
                        var countryMoneda = selectedOption.getAttribute("data-moneda");
                        var span = document.getElementById("valor-span");
                        var span4 = document.getElementById("valor-span4");
                        var span2 = document.getElementById("valor-span2");
                        var span3 = document.getElementById("valor-span3");

                        if (countryCode) {
                            span.textContent = "+" + countryCode;
                            span4.textContent = "+" + countryCode;
                        } else {
                            span.textContent = "Selecciona un país";
                        }


                        var monedaInput = document.getElementById("moneda");
                        monedaInput.value = countryMoneda;

                        var selectMoneda = document.getElementById("moneda2");

                        // Eliminar la opción anterior si existe
                        if (selectMoneda.options.length > 2) {
                            selectMoneda.removeChild(selectMoneda.options[2]);
                        }

                        // Verificar si la moneda es diferente de EUR y USD
                        if (countryMoneda !== "EUR" && countryMoneda !== "USD") {
                            // Agregar una nueva opción con la moneda del país seleccionado
                            var optionMonedaPais = document.createElement("option");
                            optionMonedaPais.text = countryMoneda;
                            optionMonedaPais.value = countryMoneda;
                            optionMonedaPais.id = "moneda-pais"; // Agregar un id al nuevo option
                            selectMoneda.appendChild(optionMonedaPais);

                            // Guardar el valor de la moneda seleccionada en una variable
                            var monedaSeleccionada = selectMoneda.value;

                            span2.textContent = countryMoneda;
                            span3.textContent = countryMoneda;
                            var monedaInput = document.getElementById("moneda-seleccionada");
                            monedaInput.value = countryMoneda;
                            selectMoneda.options[2].selected = true;
                        } else {
                            // Seleccionar EUR o USD automáticamente
                            if (countryMoneda === "EUR") {
                                selectMoneda.options[0].selected = true;
                            } else {
                                selectMoneda.options[1].selected = true;
                            }
                            var monedaSeleccionada = selectMoneda.value;
                            span2.textContent = countryMoneda;
                            span3.textContent = countryMoneda;
                            var monedaInput = document.getElementById("moneda-seleccionada");
                            monedaInput.value = countryMoneda;
                        }
                    }
                </script>
            </div>
            <div class="form-row mt-3">
                <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                    <label for="ciudad">Ciudad</label>
                    <input class="multisteps-form__input form-control" type="text" id="ciudad" name="ciudad" placeholder="Ciudad" value="<?php echo $ciudad; ?>" maxLength="30">
                </div>
                <div class="col-12 col-sm-3">
                    <label for="estado">Estado o Provincia</label>
                    <input class="multisteps-form__input form-control" type="text" id="estado" name="estado" placeholder="Estado o Provincia" value="<?php echo $estado; ?>" maxLength="30">
                </div>
                <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                    <label for="direccion">Dirección</label>
                    <input class="multisteps-form__input form-control" type="text" id="direccion" name="direccion" placeholder="Dirección" value="<?php echo $direccion; ?>" maxLength="250">
                </div>
                <div class="col-12 col-sm-3">
                    <label for="codigo_postal">Código Postal</label>
                    <input class="multisteps-form__input form-control" type="text" id="codigo_postal" name="codigo_postal" placeholder="Código Postal" value="<?php echo $codigo_postal; ?>" maxLength="15">
                </div>
            </div>
            <div class="form-row mt-3">
                <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                    <label for="telefonos">Teléfono oficina</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span id="valor-span" class="input-group-text" id="basic-addon1">+<?php echo $codigo_telefonico; ?></span>
                        </div>
                        <input class="multisteps-form__input form-control" type="text" id="telefonos" name="telefonos" placeholder="Teléfonos" value="<?php echo $telefonos; ?>" oninput="validateNumericInputs(this, 15)">
                    </div>
                </div>
            </div>
            <div class="form-row mt-3">
                <div class="col-12 col-sm-3">
                    <label for="tipo-empresa">Tipo según propiedad del capital</label>
                    <select class="multisteps-form__input form-control" id="tipo-empresa" name="tipo-empresa">

                        <?php
                        $selectedTipoEmpresa = $tipo_empresa;
                        if ($tipo_empresas) {
                            foreach ($tipo_empresas as $var) {
                                $name = $var['nombre'];
                                $id = $var['id'];
                                $selected = ($selectedTipoEmpresa == $id) ? "selected" : "";
                                echo "<option value=\"$id\" $selected>$name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-12 col-sm-3">
                    <label for="sector" id="sector-label" style="color: #007BFF; cursor: pointer;">Sector al que pertenece</label>
                    <script>
                        // Selecciona el label por su ID
                        var sectorLabel = document.getElementById('sector-label');

                        // Agrega un evento "click" al label
                        sectorLabel.addEventListener('click', function() {
                            // Muestra el Sweet Alert
                            Swal.fire({
                                title: 'Sectores económicos',
                                html: ` <style>
                                            .sector-title {
                                                font-size: 20px;
                                                margin-top: 20px;
                                            }
                                            .carousel-control-prev-icon,
                                        .carousel-control-next-icon {
                                        background-color: black;
                                        }
                                        .carousel-control-prev,
                                        .carousel-control-next {
                                        width: auto;
                                        margin-right: 10px;
                                        margin-left: 10px;
                                        }
                                            .sector-text {
                                                font-size: 18px;
                                                margin-bottom: 20px;
                                                padding-right: 50px;
                                        padding-left: 50px;
                                            text-align: justify;
                                            }
                                            </style>
                                            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel" data-bs-interval="8000">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                <h4 class="sector-title">Sector primario</h4>
                                                <p class="sector-text">Comprende las actividades productivas de la extracción y obtención de materias primas, como la agricultura, la ganadería, la apicultura, la acuicultura, la pesca, la minería, la silvicultura y la explotación forestal. Se relacionan con la obtención de las materias primas destinadas al consumo o a la industria a partir de los recursos naturales.</p>
                                                </div>
                                                <div class="carousel-item">
                                                <h4 class="sector-title">Sector secundario</h4>
                                                <p class="sector-text">Se encarga de procesar y transformar las materias primas en bienes o productos para el consumo. Es el sector industrial, caracterizado por el uso de maquinaria. Comprende fábricas, talleres, laboratorios, así como la industria de la construcción.</p>
                                                </div>
                                                <div class="carousel-item">
                                                <h4 class="sector-title">Sector terciario</h4>
                                                <p class="sector-text">Engloba todas las actividades económicas relacionadas con los servicios. En este sentido, no produce bienes materiales, sino que se encarga de distribuir los productos elaborados por el sector secundario hasta el consumidor. En el sector terciario, entre otras actividades, se encuentran el comercio, las comunicaciones y los transportes.</p>
                                                </div>
                                                <div class="carousel-item">
                                                <h4 class="sector-title">Sector cuaternario</h4>
                                                <p class="sector-text">Basado en el conocimiento, servicios de intercambio de información, tecnología, consultoría, educación, investigación y desarrollo, planificación financiera y otros servicios de índole intelectual. Se incluyen tareas relacionadas con la cultura y el gobierno.</p>
                                                </div>
                                                <div class="carousel-item"> 
                                                    <h4 class="sector-title">Sector quinario</h4> 
                                                    <p class="sector-text">Engloba las actividades que se enfocan en la satisfacción de necesidades sociales y personales. Esto incluye servicios de salud, educación, cultura, deporte, turismo, ocio, entre otros.</p> 
                                                </div>
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Anterior</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Siguiente</span>
                                            </button>
                                            </div>
                                        `,
                                icon: 'info',
                                confirmButtonText: 'Aceptar',
                                confirmButtonColor: '#3085d6',

                                customClass: {
                                    title: 'sector-modal-title',
                                    container: 'sector-modal-container',
                                    prevButton: 'carousel-control-prev text-dark',
                                    nextButton: 'carousel-control-next text-dark',
                                    sectorTitle: 'sector-title font-size-lg',
                                    sectorText: 'sector-text font-size-md'
                                },
                                onAfterRender: function() {
                                    $('.carousel').carousel();
                                }
                            });
                        });
                    </script>
                    <select class="multisteps-form__input form-control" id="sector" name="sector">

                        <?php
                        $selectedSector = $sector;
                        if ($tipo_sector) {
                            foreach ($tipo_sector as $var) {
                                $name = $var['nombre'];
                                $id = $var['id'];
                                $selected = ($selectedSector == $id) ? "selected" : "";
                                echo "<option value=\"$id\" $selected>$name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row mt-3">
                <div>
                    <label>Seleccione el nivel de su empresa, según:</label>
                </div>
            </div>
            <div class="form-row justify-content-center">
                <div class="col-12 col-sm-3">
                    <div class="text-center">
                        <label for="nivel-empresarial">Numero de trabajadores</label>
                    </div>
                </div>
            </div>
            <div class="form-row justify-content-center">
                <div class="col-12 col-sm-3">
                    <style>
                        option {
                            text-indent: 20px;
                        }
                    </style>

                    <select class="multisteps-form__input form-control" id="nivel-empresarial" name="nivel-empresarial">
                        <?php
                        $selectedNivel = $nivel_empresarial;
                        $nivlesE = $niveles;
                        foreach ($nivlesE as $var) {
                            $name = $var['nombre'];
                            $mensaje = $var['mensaje'];
                            $id = $var['ID'];
                            $selected = ($selectedNivel == $id) ? "selected" : "";
                            echo "<option value=\"$id\" $selected>$name&nbsp;$mensaje</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row justify-content-center mt-3">
                <div class="col-12 col-sm-3">
                    <label for="nivel-empresarial">¿Desea utilizar otra moneda?</label>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="text-center">
                        <label for="nivel-empresarial">Volumen de ventas/año</label>
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="text-center">
                        <label for="nivel-empresarial">Valor de activos totales</label>
                    </div>
                </div>
            </div>
            <div class="form-row justify-content-center">
                <div class="col-12 col-sm-3">
                    <div class="col-12 col-sm-4">
                        <select class="multisteps-form__input form-control" id="moneda2" name="moneda2" onchange="cambiarMoneda()">
                            <?php foreach ($opciones as $opcion) { ?>
                                <option value="<?php echo $opcion; ?>" <?php if ($moneda == $opcion) {
                                                                            echo 'selected';
                                                                        } ?>>
                                    <?php echo $opcion; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <input type="hidden" id="moneda-seleccionada" name="moneda-seleccionada" value="<?php echo $moneda; ?>">
                    </div>
                </div>
                <div class="col-12 col-sm-3">

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span id="valor-span2" class="input-group-text" id="basic-addon1"><?php echo $moneda; ?></span>
                        </div>
                        <input class="multisteps-form__input form-control" type="text" name="volumen_ventas" id="volumen_ventas" value="<?php echo $volumen_ventas; ?>">
                    </div>
                </div>
                <div class="col-12 col-sm-3">

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span id="valor-span3" class="input-group-text" id="basic-addon1"><?php echo $moneda; ?></span>
                        </div>
                        <input class="multisteps-form__input form-control" type="text" name="valor_activos" id="valor_activos" value="<?php echo $valor_activos; ?>">
                    </div>
                </div>

                <script>
                    function cambiarMoneda() {
                        var selectMoneda = document.getElementById("moneda2");
                        var monedaSeleccionada = selectMoneda.value;

                        var span2 = document.getElementById("valor-span2");
                        var span3 = document.getElementById("valor-span3");

                        span2.textContent = monedaSeleccionada;
                        span3.textContent = monedaSeleccionada;
                        var monedaInput = document.getElementById("moneda-seleccionada");
                        monedaInput.value = monedaSeleccionada;
                    }
                </script>
            </div>
            <div class="form-row mt-3">
                <div class="col-12 col-sm-6">
                    <label for="actividad">Actividad</label>
                    <select id="actividad" name="actividad">
                        <option value="">Actividad Empresarial</option>
                        <?php
                        $selectedActividad = $actividad;
                        $actividadesEmpresariales = $acitvity;
                        foreach ($actividadesEmpresariales as $var) {
                            $name = $var['nombre'];
                            $id = $var['id'];
                            $selected = ($selectedActividad == $name) ? "selected" : "";
                            echo "<option value=\"$name\" $selected>$name</option>";
                        }
                        ?>
                    </select>
                    <label for="opcionPersonalizadaCheckbox">Opción Personalizada</label>
                    <input type="checkbox" id="opcionPersonalizadaCheckbox" onchange="alternarInput()" <?php if ($checkedActividad == true) echo 'checked'; ?>>

                    <input class="multisteps-form__input form-control" type="text" name="opcionPersonalizada" id="opcionPersonalizada" value="<?php echo $opcionPersonalizada; ?>" disabled placeholder="Escriba su opción personalizada">

                    <script>
                        function alternarInput() {
                            var checkboxElement = document.getElementById("opcionPersonalizadaCheckbox");
                            var selectElement = document.getElementById("actividad");
                            var inputElement = document.getElementById("opcionPersonalizada");

                            if (checkboxElement.checked) {
                                inputElement.disabled = false;
                                selectElement.disabled = true;
                            } else {
                                inputElement.disabled = true;
                                selectElement.disabled = false;
                            }
                        }
                    </script>
                </div>
                <div class="col-12 col-sm-6">
                    <label for="productos-servicios">Productos/Servicios que elabora</label>
                    <select id="productos-servicios" name="productos-servicios">
                        <option value="">Productos / Servicios</option>
                        <?php
                        $selectedProductos = $productos_servicios;
                        $productosServicios = $products;
                        foreach ($productosServicios as $var) {
                            $name = $var['nombre'];
                            $id = $var['id'];
                            $selected = ($selectedProductos == $name) ? "selected" : "";
                            echo "<option value=\"$name\" $selected>$name</option>";
                        }
                        ?>
                    </select>
                    <label for="opcionPersonalizadaCheckbox2">Opción Personalizada</label>
                    <input type="checkbox" id="opcionPersonalizadaCheckbox2" onchange="alternarInput2()" <?php if ($checkedActividad2 == true) echo 'checked'; ?>>
                    <input class="multisteps-form__input form-control" type="text" name="opcionPersonalizada2" id="opcionPersonalizada2" value="<?php echo $opcionPersonalizada2; ?>" disabled placeholder="Escriba su opción personalizada">
                    <script>
                        function alternarInput2() {
                            var checkboxElement = document.getElementById("opcionPersonalizadaCheckbox2");
                            var selectElement = document.getElementById("productos-servicios");
                            var inputElement = document.getElementById("opcionPersonalizada2");

                            if (checkboxElement.checked) {
                                inputElement.disabled = false;
                                selectElement.disabled = true;
                            } else {
                                inputElement.disabled = true;
                                selectElement.disabled = false;
                            }
                        }
                    </script>
                </div>
            </div>

            <div class="form-row" hidden>
                <div class="col-12 col-sm-6">
                    <div class="col-12 col-sm-2">
                        <select class="multisteps-form__input form-control" id="escala_administrativo" name="escala_administrativo" disabled>
                            <?php
                            $selectedEscalaAdministrativo = $escala_administrativo;
                            $ciclo = $escalas_administrativo;
                            foreach ($ciclo as $var) {
                                $name = $var['tipo_empresa'];
                                $max = $var['descripcion'];
                                $max_array = explode(',', $max);
                                $max = implode(",", $max_array);
                                $selected = ($selectedEscalaAdministrativo == $name) ? "selected" : "";
                                echo "<option value=\"$name\" $selected  data-max=\"$max\">$name</option>";
                            }
                            ?>
                        </select>
                        <script>
                            document.getElementById("escala_administrativo").addEventListener("change", function() {
                                var selectedOption = this.options[this.selectedIndex];
                                var max = selectedOption.dataset.max;

                                const maxArray = max.split(',');
                                const datosSeparados = maxArray.map((item) => {
                                    const regex = /^(\w+)\s+\((\d+)\s+-\s+(\d+)\)$/;
                                    const match = item.match(regex);
                                    const grados = match[1];
                                    const puntaje_min = match[2];
                                    const puntaje_max = match[3];

                                    return {
                                        grados,
                                        puntaje_min,
                                        puntaje_max
                                    }
                                });

                                let tableHTML = '<style>#customers {font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;}#customers td, #customers th {border: 1px solid #ddd;padding: 8px;}#customers tr:nth-child(even){background-color: #f2f2f2;}#customers tr:hover {background-color: #ddd;}#customers th {padding-top: 12px;padding-bottom: 12px;text-align: center;background-color: #04AA6D;color: white;}</style> <table id="customers"><thead><tr><th>Grados</th><th>Puntaje Mínimo</th><th>Puntaje Máximo</th></tr></thead><tbody>';

                                for (const departamento of datosSeparados) {
                                    tableHTML += `<tr><td>${departamento.grados}</td><td>${departamento.puntaje_min}</td><td>${departamento.puntaje_max}</td></tr>`;
                                }

                                tableHTML += '</tbody></table>';

                                Swal.fire({
                                    title: 'Escala #' + selectedOption.value,
                                    text: 'Has seleccionado ' + selectedOption.value,
                                    html: '<p>Estos son los grados y puntaje de la escala seleccionada:</p>' + tableHTML,
                                    icon: 'information',
                                    confirmButtonText: 'Aceptar',
                                    confirmButtonColor: '#3085d6'
                                });
                            });
                        </script>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="col-12 col-sm-2">
                        <select class="multisteps-form__input form-control" id="escala_planta" name="escala_planta" disabled>
                            <?php

                            $selectedEscalaPlanta = $escala_planta;
                            $ciclo = $escalas_planta;
                            foreach ($ciclo as $var) {
                                $name = $var['tipo_empresa'];
                                $max = $var['descripcion'];
                                $max_array = explode(',', $max);
                                $max = implode(",", $max_array);
                                $selected = ($selectedEscalaPlanta == $name) ? "selected" : "";
                                echo "<option value=\"$name\" $selected  data-max=\"$max\">$name</option>";
                            }
                            ?>
                        </select>
                        <script>
                            document.getElementById("escala_planta").addEventListener("change", function() {
                                console.log("hey")
                                var selectedOption = this.options[this.selectedIndex];
                                var max = selectedOption.dataset.max;

                                const maxArray = max.split(',');
                                const datosSeparados = maxArray.map((item) => {
                                    const regex = /^(\w+)\s+\((\d+)\s+-\s+(\d+)\)$/;
                                    const match = item.match(regex);
                                    const grados = match[1];
                                    const puntaje_min = match[2];
                                    const puntaje_max = match[3];

                                    return {
                                        grados,
                                        puntaje_min,
                                        puntaje_max
                                    }
                                });

                                let tableHTML = '<style>#customers {font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;}#customers td, #customers th {border: 1px solid #ddd;padding: 8px;}#customers tr:nth-child(even){background-color: #f2f2f2;}#customers tr:hover {background-color: #ddd;}#customers th {padding-top: 12px;padding-bottom: 12px;text-align: center;background-color: #04AA6D;color: white;}</style> <table id="customers"><thead><tr><th>Grados</th><th>Puntaje Mínimo</th><th>Puntaje Máximo</th></tr></thead><tbody>';

                                for (const departamento of datosSeparados) {
                                    tableHTML += `<tr><td>${departamento.grados}</td><td>${departamento.puntaje_min}</td><td>${departamento.puntaje_max}</td></tr>`;
                                }

                                tableHTML += '</tbody></table>';

                                Swal.fire({
                                    title: 'Escala #' + selectedOption.value,
                                    text: 'Has seleccionado ' + selectedOption.value,
                                    html: '<p>Estos son los grados y puntaje de la escala seleccionada:</p>' + tableHTML,
                                    icon: 'information',
                                    confirmButtonText: 'Aceptar',
                                    confirmButtonColor: '#3085d6'
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>

            <div class="form-row mt-3">
                <div class="col-4 ">
                    <label for="mision">Misión</label>
                    <textarea class="multisteps-form__input form-control" id="mision" name="mision" placeholder="Misión"><?php echo $mision; ?></textarea>
                </div>
                <div class="col-4 ">
                    <label for="vision">Visión</label>
                    <textarea class="multisteps-form__input form-control" id="vision" name="vision" placeholder="Visión"><?php echo $vision; ?></textarea>
                </div>
                <div class="col-4  ">
                    <label for="valores">Valores</label>
                    <textarea class="multisteps-form__input form-control" id="valores" name="valores" placeholder="Valores"><?php echo $valores; ?></textarea>
                </div>
            </div>
            <label class="mt-3">Datos suministrados por:</label>
            <div class="form-row mt-3">
                <div class="col-12 col-sm-3">
                    <label for="escala_administrativo">Nombre</label>
                    <br />
                    <input class="multisteps-form__input form-control" type="text" id="nombrerh" name="nombrerh" placeholder="Nombre" value="<?php echo $nombrerh; ?>" maxLength="150">
                </div>
                <div class="col-12 col-sm-3">
                    <label for="escala_planta">Puesto/Cargo</label>
                    <br />
                    <input class="multisteps-form__input form-control" type="text" id="puestorh" name="puestorh" placeholder="Puesto/Cargo" value="<?php echo $puestorh; ?>" maxLength="150">
                </div>
                <div class="col-12 col-sm-3">
                    <label for="escala_administrativo">Email</label>
                    <br />
                    <input class="multisteps-form__input form-control" type="text" id="emailrh" name="emailrh" placeholder="Email" value="<?php echo $emailrh; ?>" maxLength="150">
                </div>
                <div class="col-12 col-sm-3">
                    <label for="escala_planta">Nro. Telefónico</label>
                    <br />
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span id="valor-span4" class="input-group-text" id="basic-addon1">+<?php echo $codigo_telefonico; ?></span>
                        </div>
                        <input class="multisteps-form__input form-control" type="text" id="telefonorh" name="telefonorh" placeholder="Nro.Telefónico" value="<?php echo $telefonorh; ?>" oninput="validateNumericInputs(this, 15)">
                    </div>
                </div>
            </div>
            <div style="text-align: center;">
                <button class="btn btn-success ml-auto js-btn-next mb-3" type="submit" name="btn-send" title="Next">Guardar</button>
            </div>
        </form>
    </div>




    <?php include_once('../layouts/footer.php'); ?>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/departamentos.js"></script>