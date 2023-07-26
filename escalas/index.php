<?php include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; ?>

<?php
session_start();
require_once("class.crud.php");
require_once '../tools/functions.php';
$error = "";
$crud = new crud();
$user = $_SESSION['user'];



if (isset($_GET['inserted'])) {
?>
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'La escala se ha registrado con exito!',
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
            title: 'Error al editar la escala!',
            showConfirmButton: false,
            timer: 3000
        })
    </script>
<?php
}

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
                <span style="font-weight: bold; font-size: 25px">Escalas empresariales</span>
            </div>
        </div>

    </section>
    <!-- Content Header (Page header) -->

    <?php

    include_once 'class.crud.php';
    $crud = new crud();
    if (isset($_POST['btn-send'])) {


        $escala_administrativo  = isset($_POST['escala_administrativo']) ? $_POST['escala_administrativo'] : '';
        $escala_planta  = isset($_POST['escala_planta']) ? $_POST['escala_planta'] : '';
        var_dump($escala_administrativo);
        try {
            $result = $crud->changeEscala(
                $escala_administrativo,
                $escala_planta
            );
        } catch (Exception $e) {
            // código de manejo de error
            echo "Error al registrar la empresa: " . $e->getMessage();
        }
        if ($result == 2) {
            $sweetAlertCode = showSweetAlert('Exito', 'La empresa se ha editado correctamente', 'success', 'Aceptar');
            $currentURL = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $currentURL .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $basePath = dirname($currentURL);
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
        <form action="saveesacalas.php" method="post" id="form">
            <div class="form-row mt-3 mb-3">
                <div class="col-12 col-sm-6">
                    <label for="escala_administrativo">Administrativa</label>
                    <br />
                    <small>Seleccione la escala según los niveles del Organigrama.
                        Solo para el personal como: Secretarias, Auxiliares, Asistentes, Analistas, Almacenistas, Supervisores, Jefes, Gerentes, Directores, Vicepresidentes Administrativos y Administrativos de Planta, Industria o Taller.
                    </small>
                </div>
                <div class="col-12 col-sm-6">
                    <label for="escala_planta">Planta - Taller - Fábrica</label>
                    <br />
                    <small>Seleccione la escala según los niveles del Organigrama.
                        Solo para personal Operativo. Ejm.: Mecánico, Electricista, Tornero, Plomero, etc. No incluya puestos/cargos de supervición
                    </small>
                </div>
            </div>
            <div class="form-row">
                <div class="col-12 col-sm-6">
                    <div class="col-12 col-sm-3">
                        <select class="multisteps-form__input form-control" id="escala_administrativo" name="escala_administrativo">
                            <?php
                            $selectedEscalaAdministrativo = $escala_administrativo;
                            $ciclo = $escalas_administrativo;

                            $defaultSelected = ($selectedEscalaAdministrativo == '') ? 'selected' : ''; // Opción predeterminada solo si no hay ningún valor seleccionado

                            echo "<option value=\"\" disabled $defaultSelected>Seleccione</option>";

                            foreach ($ciclo as $var) {
                                $name = $var['tipo_empresa'];
                                $max = $var['descripcion'];
                                $max_array = explode(',', $max);
                                $max = implode(",", $max_array);
                                $selected = ($selectedEscalaAdministrativo == $name) ? "selected" : "";
                                echo "<option value=\"$name\" $selected data-max=\"$max\">$name</option>";
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
                                    html: '<p>Estos son los grados de la escala seleccionada:</p>' + tableHTML,
                                    icon: 'information',
                                    confirmButtonText: 'Aceptar',
                                    confirmButtonColor: '#3085d6'
                                });
                            });
                        </script>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="col-12 col-sm-3">
                        <select class="multisteps-form__input form-control" id="escala_planta" name="escala_planta">
                            <?php

                            $selectedEscalaPlanta = $escala_planta;
                            $ciclo = $escalas_planta;

                            $defaultSelected = ($selectedEscalaPlanta == '') ? 'selected' : ''; // Opción predeterminada solo si no hay ningún valor seleccionado

                            echo "<option value=\"\" disabled $defaultSelected>Seleccione</option>";
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
                                    html: '<p>Estos son los grados de la escala seleccionada:</p>' + tableHTML,
                                    icon: 'information',
                                    confirmButtonText: 'Aceptar',
                                    confirmButtonColor: '#3085d6'
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>

            <div style="text-align: center;">
                <button class="btn btn-success ml-auto js-btn-next mb-3 mt-5" type="submit" name="btn-send" id="btn-send" title="Next">Guardar</button>
            </div>
            <script>
                // Manejar el evento click del botón
                document.getElementById('btn-send').addEventListener('click', function(e) {

                    // Prevenir la acción por defecto del botón
                    e.preventDefault();
                    // Obtener referencia al elemento select de Escala Administrativo
                    var selectEscalaAdministrativo = document.getElementById("escala_administrativo");

                    // Validar el campo Escala Administrativo
                    if (selectEscalaAdministrativo.value === "") {
                        // El campo Escala Administrativo está vacío, mostrar mensaje de error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Por favor, selecciona una opción para la escala administrativa'
                        });
                        return; // Detener la ejecución del código si hay un error
                    }

                    // Obtener referencia al elemento select de Escala Planta
                    var selectEscalaPlanta = document.getElementById("escala_planta");

                    // Validar el campo Escala Planta
                    if (selectEscalaPlanta.value === "") {
                        // El campo Escala Planta está vacío, mostrar mensaje de error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Por favor, selecciona una opción para la escala de planta - taller - fábrica'
                        });
                        return; // Detener la ejecución del código si hay un error
                    }
                    // Mostrar la ventana modal de sweetalert
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: 'Esta acción modificará los grados de los cargos creados, en función del puntaje que tengan asignado',
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
        </form>
    </div>




    <?php include_once('../layouts/footer.php'); ?>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/departamentos.js"></script>