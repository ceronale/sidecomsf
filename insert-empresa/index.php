<?php include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper mt-5" style="overflow: auto; max-height: 480px;">
    <?php
    session_start();
    require_once("class.crud.php");
    require_once '../tools/functions.php';
    $error = "";
    $crud = new crud();

    if (isset($_GET['inserted'])) {
    ?>
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Los datos de la empresa se ha registrado con exito!',
                showConfirmButton: false,
                timer: 3000
            })
        </script>
    <?php
    }
    if (isset($_GET['failure'])) { ?>
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Error al ingresar la empresa!',
                showConfirmButton: false,
                timer: 3000
            })
        </script>
    <?php
    }
    //Consultas a la bd
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
    $empresa = isset($_POST['empresa']) ? $_POST['empresa'] : '';
    $tributaria = isset($_POST['tributaria']) ? $_POST['tributaria'] : '';
    $pais = isset($_POST['pais']) ? $_POST['pais'] : '';
    $ciudad = isset($_POST['ciudad']) ? $_POST['ciudad'] : '';
    $estado = isset($_POST['estado']) ? $_POST['estado'] : '';
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';

    $telefonos = isset($_POST['telefonos']) ? $_POST['telefonos'] : '';
    $codigo_postal = isset($_POST['codigo_postal']) ? $_POST['codigo_postal'] : '';
    $tipo_empresa = isset($_POST['tipo-empresa']) ? $_POST['tipo-empresa'] : '';
    $sector = isset($_POST['sector']) ? $_POST['sector'] : '';
    $actividad = isset($_POST['actividad']) ? $_POST['actividad'] : '';
    $opcionPersonalizada = isset($_POST['opcionPersonalizada']) ? $_POST['opcionPersonalizada'] : '';
    $opcionPersonalizada2 = isset($_POST['opcionPersonalizada2']) ? $_POST['opcionPersonalizada2'] : '';
    $productos_servicios = isset($_POST['productos-servicios']) ? $_POST['productos-servicios'] : '';
    $nivel_empresarial = isset($_POST['nivel-empresarial']) ? $_POST['nivel-empresarial'] : '';
    //$escala_administrativo  = isset($_POST['escala_administrativo']) ? $_POST['escala_administrativo'] : '';
    //$escala_planta  = isset($_POST['escala_planta']) ? $_POST['escala_planta'] : '';
    $checkedActividad = false;
    $checkedActividad2 = false;
    $countryMoneda = isset($_POST['moneda']) ? $_POST['moneda'] : '';
    $valor_activos = isset($_POST['valor_activos']) ? $_POST['valor_activos'] : '';
    $volumen_ventas = isset($_POST['volumen_ventas']) ? $_POST['volumen_ventas'] : '';
    $moneda = isset($_POST['moneda-seleccionada']) ? $_POST['moneda-seleccionada'] : '';
    $nombrerh = isset($_POST['nombrerh']) ? $_POST['nombrerh'] : '';
    $puestorh = isset($_POST['puestorh']) ? $_POST['puestorh'] : '';
    $emailrh = isset($_POST['emailrh']) ? $_POST['emailrh'] : '';
    $telefonorh = isset($_POST['telefonorh']) ? $_POST['telefonorh'] : '';

    ?>

    <div id="alert-container"></div>
    <div class='container' style="overflow: auto; max-height: auto;">
        <link rel="stylesheet" href="assets/css/registration.css" />
        <div class='container' style="overflow: auto; max-height: 600px;">
            <?php echo isset($sweetAlertCode) ? $sweetAlertCode : ''; ?>
        </div>
        <div class="container overflow-hidden">
            <!-- multisteps-form -->
            <div class="multisteps-form">
                <!-- progress bar -->
                <div class="row">
                    <div class="col-12 col-lg-8 ml-auto mr-auto mb-4">
                        <div class="multisteps-form__progress">
                            <button class="multisteps-form__progress-btn js-active" type="button" title="Registro de información">Registro de información de Empresa</button>
                            <button class="multisteps-form__progress-btn" type="button" title="Registro de información">Registro de información de Empresa</button>
                            <button class="multisteps-form__progress-btn" type="button" title="Registro de información">Registro de información de Empresa</button>

                        </div>
                    </div>
                </div>
                <!-- form panels -->
                <div class="row">
                    <div class="col-12 col-lg-8 m-auto">
                        <form action="saveempresa.php" method="post" id="form" class="multisteps-form__form">
                            <!-- single form panel -->
                            <div class="multisteps-form__panel  js-active" data-animation="scaleIn">
                                <h3 class="multisteps-form__title">Registro de información de Empresa</h3>
                                <div class="multisteps-form__content">
                                    <div class="form-row mt-3">
                                        <div class="col-12 col-sm-6">
                                            <label for="empresa">Empresa, Entidad u Organismo</label>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <label for="tributaria">Identificación Tributaria</label>
                                        </div>
                                    </div>
                                    <div class="form-row ">
                                        <div class="col-12 col-sm-6">
                                            <input class="multisteps-form__input form-control" type="text" id="empresa" name="empresa" placeholder="Empresa, Entidad u Organismo" value="<?php echo $empresa; ?>" maxLength="150">
                                        </div>
                                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                            <input class="multisteps-form__input form-control" type="text" id="tributaria" name="tributaria" placeholder="Identificación Tributaria" value="<?php echo $tributaria; ?>" maxLength="20">
                                        </div>
                                    </div>
                                    <div class="form-row mt-3">
                                        <div class="col-12 col-sm-6">
                                            <label for="pais">País</label>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <label for="ciudad">Ciudad</label>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-12 col-sm-4">
                                            <select class="multisteps-form__input form-control" id="pais" name="pais" onchange="cambiarValor()">
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
                                        <div class="col-12 col-sm-2">
                                            <input class="multisteps-form__input form-control" type="text" id="moneda" name="moneda" placeholder="Moneda" maxLength="30" disabled>
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

                                                span2.textContent = countryMoneda;
                                                span3.textContent = countryMoneda;

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

                                                    // Seleccionar automáticamente la nueva opción
                                                    var index = selectMoneda.options.selectedIndex;
                                                    selectMoneda.options[index].selected = false;
                                                    selectMoneda.options[selectMoneda.options.length - 1].selected = true;

                                                    // Guardar el valor de la moneda seleccionada en una variable
                                                    var monedaSeleccionada = selectMoneda.value;
                                                } else {
                                                    // Seleccionar EUR o USD automáticamente
                                                    if (countryMoneda === "EUR") {
                                                        selectMoneda.options[0].selected = true;
                                                    } else {
                                                        selectMoneda.options[1].selected = true;
                                                    }
                                                    var monedaSeleccionada = selectMoneda.value;
                                                }

                                                // Guardar el valor de la moneda seleccionada en una variable
                                                var monedaSeleccionada = selectMoneda.value;
                                                var monedaInput = document.getElementById("moneda-seleccionada");
                                                monedaInput.value = monedaSeleccionada;
                                            }
                                        </script>
                                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                            <input class="multisteps-form__input form-control" type="text" id="ciudad" name="ciudad" placeholder="Ciudad" value="<?php echo $ciudad; ?>" maxLength="30">
                                        </div>
                                    </div>
                                    <div class="form-row mt-3">
                                        <div class="col-12 col-sm-6">
                                            <label for="estado">Estado o Provincia</label>

                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <label for="direccion">Dirección</label>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-12 col-sm-6">
                                            <input class="multisteps-form__input form-control" type="text" id="estado" name="estado" placeholder="Estado o Provincia" value="<?php echo $estado; ?>" maxLength="30">
                                        </div>
                                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                            <input class="multisteps-form__input form-control" type="text" id="direccion" name="direccion" placeholder="Dirección" value="<?php echo $direccion; ?>" maxLength="250">
                                        </div>
                                    </div>

                                    <div class="form-row mt-3">
                                        <div class="col-12 col-sm-6">
                                            <label for="codigo_postal">Código Postal</label>

                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <label for="telefonos">Teléfono oficina</label>

                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-12 col-sm-6">

                                            <input class="multisteps-form__input form-control" type="text" id="codigo_postal" name="codigo_postal" placeholder="Código Postal" value="<?php echo $codigo_postal; ?>" maxLength="15">

                                        </div>
                                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span id="valor-span" class="input-group-text" id="basic-addon1">+0</span>
                                                </div>
                                                <input class="multisteps-form__input form-control" type="text" id="telefonos" name="telefonos" placeholder="Teléfonos" value="<?php echo $telefonos; ?>" oninput="validateNumericInputs(this, 15)">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="button-row d-flex mt-4">
                                        <button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next">Siguiente</button>
                                    </div>
                                </div>
                            </div>

                            <!-- single form panel -->
                            <div class="multisteps-form__panel" data-animation="scaleIn">
                                <h3 class="multisteps-form__title">Registro de información de Empresa</h3>
                                <div class="multisteps-form__content">
                                    <div class="form-row mt-3">
                                        <div class="col-12 col-sm-6">
                                            <label for="tipo-empresa">Tipo según propiedad del capital</label>

                                        </div>
                                        <div class="col-12 col-sm-6">
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
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-12 col-sm-6">
                                            <select class="multisteps-form__input form-control" id="tipo-empresa" name="tipo-empresa">
                                                <option value="">Tipo</option>
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
                                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                            <select class="multisteps-form__input form-control" id="sector" name="sector">
                                                <option value="">Sector al que pertenece</option>
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
                                    <div class="mt-5 ">
                                        <label>Seleccione el nivel de su empresa, según:</label>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <div class="form-row ">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-center">
                                                    <label for="nivel-empresarial">Número de trabajadores</label>
                                                </div>
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
                                                        echo "<option value=\"$id\" $selected>$name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$mensaje</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <br />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-row ">
                                    <div class="col-4 ">
                                        <div class="d-flex justify-content-center">
                                            <label for="nivel-empresarial">¿Desea utilizar otra moneda?</label>
                                        </div>
                                    </div>
                                    <div class="col-4 ">
                                        <div class="d-flex justify-content-center">
                                            <label for="nivel-empresarial">Volumen de ventas/año</label>
                                        </div>
                                    </div>
                                    <div class="col-4 ">
                                        <div class="d-flex justify-content-center">
                                            <label for="nivel-empresarial">Valor de activos totales</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row ">
                                    <div class="col-2 ">
                                        <select class="multisteps-form__input form-control" id="moneda2" name="moneda2" onchange="cambiarMoneda()">
                                            <option value="EUR">EUR</option>
                                            <option value="USD">USD</option>
                                        </select>
                                        <input type="hidden" id="moneda-seleccionada" name="moneda-seleccionada" value="">
                                    </div>
                                    <div class="col-2 "></div>
                                    <div class="col-4 ">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span id="valor-span2" class="input-group-text" id="basic-addon1">+0</span>
                                            </div>
                                            <input class="multisteps-form__input form-control" type="text" name="volumen_ventas" id="volumen_ventas" value="<?php echo $volumen_ventas; ?>">
                                        </div>
                                    </div>

                                    <div class="col-4 ">

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span id="valor-span3" class="input-group-text" id="basic-addon1">+0</span>
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
                                    <div class="col-12">

                                        <div class="form-row mt-3">
                                            <div class="col-12">
                                                <label for="actividad">Actividad</label>

                                                <select class="multisteps-form__input form-control" id="actividad" name="actividad">
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
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row mt-3">
                                    <div class="col-12">
                                        <label for="productos-servicios">Productos/Servicios que elabora</label>
                                        <select class="multisteps-form__input form-control" id="productos-servicios" name="productos-servicios">
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
                                <div class="button-row d-flex mt-4 mb-5">
                                    <button class="btn btn-primary js-btn-prev" type="button" title="Prev">Anterior</button>
                                    <button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next">Siguiente</button>
                                </div>
                            </div>

                            <!-- single form panel -->
                            <div class="multisteps-form__panel" data-animation="scaleIn">
                                <h3 class="multisteps-form__title">Persona que suministra la información</h3>
                                <div class="multisteps-form__content">
                                    <div class="form-row mt-3">
                                        <div class="col-12 col-sm-6">
                                            <label for="escala_administrativo">Nombre</label>
                                            <br />
                                            <input class="multisteps-form__input form-control" type="text" id="nombrerh" name="nombrerh" placeholder="Nombre" value="<?php echo $nombrerh; ?>" maxLength="150">
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <label for="escala_planta">Puesto/Cargo</label>
                                            <br />
                                            <input class="multisteps-form__input form-control" type="text" id="puestorh" name="puestorh" placeholder="Puesto/Cargo" value="<?php echo $puestorh; ?>" maxLength="150">
                                        </div>
                                    </div>

                                    <div class="form-row mt-3">
                                        <div class="col-12 col-sm-6">
                                            <label for="escala_administrativo">Email</label>
                                            <br />
                                            <input class="multisteps-form__input form-control" type="text" id="emailrh" name="emailrh" placeholder="Email" value="<?php echo $emailrh; ?>" maxLength="150">
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <label for="escala_planta">Nro. Telefónico</label>
                                            <br />




                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span id="valor-span4" class="input-group-text" id="basic-addon1">+0</span>
                                                </div>
                                                <input class="multisteps-form__input form-control" type="text" id="telefonorh" name="telefonorh" placeholder="Nro.Telefónico" value="<?php echo $telefonorh; ?>" oninput="validateNumericInputs(this, 15)">
                                            </div>


                                        </div>
                                    </div>

                                    <div class="button-row d-flex mt-4">

                                        <button class="btn btn-primary js-btn-prev" type="button" title="Prev">Anterior</button>
                                        <button class="btn btn-success ml-auto js-btn-next" type="submit" name="btn-send" id="btn-send" title="Next">Enviar</button>
                                    </div>
                                    <script>
                                        // Manejar el evento click del botón
                                        document.getElementById('btn-send').addEventListener('click', function(e) {

                                            // Prevenir la acción por defecto del botón
                                            e.preventDefault();

                                            // Mostrar la ventana modal de sweetalert
                                            Swal.fire({
                                                title: '¿Estás seguro?',
                                                text: 'Esta acción no se puede deshacer',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Sí, enviar',
                                                cancelButtonText: 'Cancelar'
                                            }).then((result) => {
                                                // Manejar la respuesta del usuario
                                                if (result.isConfirmed) {
                                                    // Si el usuario confirma, enviar el formulario
                                                    document.getElementById('form').submit();
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>


</div>

<script src="../tools/tools.js"></script>
<script src="assets/js/main.js"></script>

<?php include_once('../layouts/footer.php'); ?>