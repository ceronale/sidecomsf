<?php
$seccion = 'p_descripcion_taller';
include_once "../layouts/session.php"; ?>
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
    $cargoDescripcion = [];
    $getEmpresa = $crud->get_empresa();
    $competencias = $crud->get_competencias();

    if (isset($_GET['id'])) {

        $id = $_GET['id'];
        if (isset($_GET['nombre'])) {
            $nombre = $_GET['nombre'];
        } else if (isset($_GET['cargo'])) {
            $nombre = $_GET['cargo'];
        }
        if (isset($_GET['departamento'])) {
            $departamento = $_GET['departamento'];
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




    ?>
    <!-- Content Header (Page header) -->

    <script>
        var indexInputMostradox = 2;
        var indexActividadMostrado = 2;
        var indexInputMostradoz = 6;
        document.addEventListener("DOMContentLoaded", function start() {
            mostrarSiguienteActividadf();
            mostrarInputSiguientef();
            mostrarInputSiguientexf();
            desbloquearCampoAmbiente();
            desbloquearCampoManipulacion();
            desbloquearCampoInstrumento();
            desbloquearCampoTraslado();
            addEventListeners();
        });

        function desbloquearCampoInstrumento() {
            var radioIns5 = document.getElementById("radio_Ins5");
            var otroinstrumento = document.getElementById("otroinstrumento");
            if (radioIns5.checked) {
                otroinstrumento.disabled = false;
            } else {
                otroinstrumento.disabled = true;
            }
        }

        function desbloquearCampoManipulacion() {
            var radioMan5 = document.getElementById("radio_Man5");
            var otromanipulacion = document.getElementById("otromanipulacion");
            if (radioMan5.checked) {
                otromanipulacion.disabled = false;
            } else {
                otromanipulacion.disabled = true;
            }
        }


        function desbloquearCampoTraslado() {
            var radioTras5 = document.getElementById("radio_Tras5");
            var otrotraslado = document.getElementById("otrotraslado");
            if (radioTras5.checked) {
                otrotraslado.disabled = false;
            } else {
                otrotraslado.disabled = true;
            }
        }

        function desbloquearCampoAmbiente() {
            var radioAmb6 = document.getElementById("radio_Amb6");
            var otroAmbiente = document.getElementById("otroambiente");
            if (radioAmb6.checked) {
                otroAmbiente.disabled = false;
            } else {
                otroAmbiente.disabled = true;
            }
        }

        function mostrarInputSiguientef() {

            var contenedorInputsx = document.getElementById("contenedor-inputs");
            for (let i = 0; i < 9; i++) {
                // Crear el siguiente input y su correspondiente etiqueta
                if (indexInputMostradox <= 11) {
                    var inputLabel = document.createElement("div");
                    inputLabel.classList.add("input-group", "mb-3");
                    inputLabel.id = "input-labelx-" + indexInputMostradox;

                    var inputLabelPrepend = document.createElement("div");
                    inputLabelPrepend.classList.add("input-group-prepend");

                    var inputLabelSpan = document.createElement("span");
                    inputLabelSpan.classList.add("input-group-text");
                    inputLabelSpan.innerHTML = indexInputMostradox;

                    inputLabelPrepend.appendChild(inputLabelSpan);
                    inputLabel.appendChild(inputLabelPrepend);

                    var input = document.createElement("textarea");
                    input.id = "funcion" + indexInputMostradox;
                    input.name = "funcion" + indexInputMostradox;
                    input.classList.add("form-control");
                    input.rows = 1;
                    input.cols = 50;

                    if (indexInputMostradox == 2) {
                        var valorPredefinido2 = "<?php echo !empty($cargoDescripcion['funcion2']) ? $cargoDescripcion['funcion2'] : ''; ?>";
                        if (valorPredefinido2 == '') {
                            break;
                        }
                        input.value = valorPredefinido2; // Establecemos el valor predefinido aquí
                    } else if (indexInputMostradox == 3) {
                        var valorPredefinido3 = "<?php echo !empty($cargoDescripcion['funcion3']) ? $cargoDescripcion['funcion3'] : ''; ?>";
                        if (valorPredefinido3 == '') {
                            break;
                        }
                        input.value = valorPredefinido3; // Establecemos el valor predefinido aquí
                    } else if (indexInputMostradox == 4) {
                        var valorPredefinido4 = "<?php echo !empty($cargoDescripcion['funcion4']) ? $cargoDescripcion['funcion4'] : ''; ?>";
                        if (valorPredefinido4 == '') {
                            break;
                        }
                        input.value = valorPredefinido4; // Establecemos el valor predefinido aquí
                    } else if (indexInputMostradox == 5) {
                        var valorPredefinido5 = "<?php echo !empty($cargoDescripcion['funcion5']) ? $cargoDescripcion['funcion5'] : ''; ?>";
                        if (valorPredefinido5 == '') {
                            break;
                        }
                        input.value = valorPredefinido5; // Establecemos el valor predefinido aquí
                    } else if (indexInputMostradox == 6) {
                        var valorPredefinido6 = "<?php echo !empty($cargoDescripcion['funcion6']) ? $cargoDescripcion['funcion6'] : ''; ?>";
                        if (valorPredefinido6 == '') {
                            break;
                        }
                        input.value = valorPredefinido6; // Establecemos el valor predefinido aquí
                    } else if (indexInputMostradox == 7) {
                        var valorPredefinido7 = "<?php echo !empty($cargoDescripcion['funcion7']) ? $cargoDescripcion['funcion7'] : ''; ?>";
                        if (valorPredefinido7 == '') {
                            break;
                        }
                        input.value = valorPredefinido7; // Establecemos el valor predefinido aquí
                    } else if (indexInputMostradox == 8) {
                        var valorPredefinido8 = "<?php echo !empty($cargoDescripcion['funcion8']) ? $cargoDescripcion['funcion8'] : ''; ?>";
                        if (valorPredefinido8 == '') {
                            break;
                        }
                        input.value = valorPredefinido8; // Establecemos el valor predefinido aquí
                    } else if (indexInputMostradox == 9) {
                        var valorPredefinido9 = "<?php echo !empty($cargoDescripcion['funcion9']) ? $cargoDescripcion['funcion9'] : ''; ?>";
                        if (valorPredefinido9 == '') {
                            break;
                        }
                        input.value = valorPredefinido9; // Establecemos el valor predefinido aquí
                    } else if (indexInputMostradox == 10) {
                        var valorPredefinido10 = "<?php echo !empty($cargoDescripcion['funcion10']) ? $cargoDescripcion['funcion10'] : ''; ?>";
                        if (valorPredefinido10 == '') {
                            break;
                        }
                        input.value = valorPredefinido10; // Establecemos el valor predefinido aquí
                    } else if (indexInputMostradox == 11) {
                        var valorPredefinido11 = "<?php echo !empty($cargoDescripcion['funcion11']) ? $cargoDescripcion['funcion11'] : ''; ?>";
                        if (valorPredefinido11 == '') {
                            break;
                        }
                        input.value = valorPredefinido11; // Establecemos el valor predefinido aquí
                    }

                    inputLabel.appendChild(input);
                    contenedorInputsx.appendChild(inputLabel);

                    input.focus();
                    indexInputMostradox++;
                }

                // Desactivar el botón si se han mostrado todos los inputs
                if (indexInputMostradox == 11) {
                    document.getElementById("boton-agregar2").disabled = true;
                }
            }
            if (indexInputMostradox < 3) {
                document.getElementById("eliminar2").hidden = true;
            }

        }

        function mostrarSiguienteActividadf() {

            for (let i = 0; i < 14; i++) {
                // Crear el siguiente input y su correspondiente etiqueta
                if (indexActividadMostrado <= 15) {
                    var actividadLabel = document.createElement("div");
                    actividadLabel.classList.add("input-group", "mb-3");
                    actividadLabel.id = "actividad-label-" + indexActividadMostrado;

                    var actividadLabelPrepend = document.createElement("div");
                    actividadLabelPrepend.classList.add("input-group-prepend");

                    var actividadLabelSpan = document.createElement("span");
                    actividadLabelSpan.classList.add("input-group-text");
                    actividadLabelSpan.innerHTML = indexActividadMostrado;

                    actividadLabelPrepend.appendChild(actividadLabelSpan);
                    actividadLabel.appendChild(actividadLabelPrepend);

                    var actividad = document.createElement("textarea");
                    actividad.id = "actividad" + indexActividadMostrado;
                    actividad.name = "actividad" + indexActividadMostrado;
                    actividad.classList.add("form-control");
                    actividad.rows = "2";
                    actividad.removeAttribute("type");


                    actividadLabel.appendChild(actividad);

                    var selectActividad = document.createElement("div");
                    selectActividad.classList.add("input-group-append");

                    var select = document.createElement("select");
                    select.classList.add("form-control");
                    select.id = "selectactividad" + indexActividadMostrado;
                    select.name = "selectactividad" + indexActividadMostrado;

                    var option1 = document.createElement("option");
                    option1.value = "1";
                    option1.text = "Diario";


                    var option2 = document.createElement("option");
                    option2.value = "2";
                    option2.text = "Semanal";


                    var option3 = document.createElement("option");
                    option3.value = "3";
                    option3.text = "Mensual";

                    var option4 = document.createElement("option");
                    option4.value = "4";
                    option4.text = "Bimestral";


                    var option5 = document.createElement("option");
                    option5.value = "5";
                    option5.text = "Trimestral";


                    var option6 = document.createElement("option");
                    option6.value = "6";
                    option6.text = "Cuatrimestral";


                    var option7 = document.createElement("option");
                    option7.value = "7";
                    option7.text = "Semestral";


                    var option8 = document.createElement("option");
                    option8.value = "8";
                    option8.text = "Anual";



                    if (indexActividadMostrado == 2) {
                        var valorPredefinidoAct2 = "<?php echo !empty($cargoDescripcion['actividad2']) ? $cargoDescripcion['actividad2'] : ''; ?>";
                        if (valorPredefinidoAct2 == '') {
                            break;
                        }
                        actividad.value = valorPredefinidoAct2; // Establecemos el valor predefinido aquí

                        var valorPredefinidoSelectAct2 = "<?php echo !empty($cargoDescripcion['selectactividad2']) ? $cargoDescripcion['selectactividad2'] : ''; ?>";


                        switch (valorPredefinidoSelectAct2) {
                            case "1":
                                option1.selected = true;
                                break;
                            case "2":
                                option2.selected = true;
                                break;
                            case "3":
                                option3.selected = true;
                                break;
                            case "4":
                                option4.selected = true;
                                break;
                            case "5":
                                option5.selected = true;
                                break;
                            case "6":
                                option6.selected = true;
                                break;
                            case "7":
                                option7.selected = true;
                                break;
                            case "8":
                                option8.selected = true;
                                break;
                        }





                    } else if (indexActividadMostrado == 3) {
                        var valorPredefinidoAct3 = "<?php echo !empty($cargoDescripcion['actividad3']) ? $cargoDescripcion['actividad3'] : ''; ?>";
                        if (valorPredefinidoAct3 == '') {
                            break;
                        }
                        actividad.value = valorPredefinidoAct3; // Establecemos el valor predefinido aquí



                        var valorPredefinidoSelectAct3 = "<?php echo !empty($cargoDescripcion['selectactividad3']) ? $cargoDescripcion['selectactividad3'] : ''; ?>";


                        switch (valorPredefinidoSelectAct3) {
                            case "1":
                                option1.selected = true;
                                break;
                            case "2":
                                option2.selected = true;
                                break;
                            case "3":
                                option3.selected = true;
                                break;
                            case "4":
                                option4.selected = true;
                                break;
                            case "5":
                                option5.selected = true;
                                break;
                            case "6":
                                option6.selected = true;
                                break;
                            case "7":
                                option7.selected = true;
                                break;
                            case "8":
                                option8.selected = true;
                                break;
                        }





                    } else if (indexActividadMostrado == 4) {
                        var valorPredefinidoAct4 = "<?php echo !empty($cargoDescripcion['actividad4']) ? $cargoDescripcion['actividad4'] : ''; ?>";
                        if (valorPredefinidoAct4 == '') {
                            break;
                        }
                        actividad.value = valorPredefinidoAct4; // Establecemos el valor predefinido aquí



                        var valorPredefinidoSelectAct4 = "<?php echo !empty($cargoDescripcion['selectactividad4']) ? $cargoDescripcion['selectactividad4'] : ''; ?>";


                        switch (valorPredefinidoSelectAct4) {
                            case "1":
                                option1.selected = true;
                                break;
                            case "2":
                                option2.selected = true;
                                break;
                            case "3":
                                option3.selected = true;
                                break;
                            case "4":
                                option4.selected = true;
                                break;
                            case "5":
                                option5.selected = true;
                                break;
                            case "6":
                                option6.selected = true;
                                break;
                            case "7":
                                option7.selected = true;
                                break;
                            case "8":
                                option8.selected = true;
                                break;
                        }
                    } else if (indexActividadMostrado == 5) {
                        var valorPredefinidoAct5 = "<?php echo !empty($cargoDescripcion['actividad5']) ? $cargoDescripcion['actividad5'] : ''; ?>";
                        if (valorPredefinidoAct5 == '') {
                            break;
                        }
                        actividad.value = valorPredefinidoAct5; // Establecemos el valor predefinido aquí

                        var valorPredefinidoSelectAct5 = "<?php echo !empty($cargoDescripcion['selectactividad5']) ? $cargoDescripcion['selectactividad5'] : ''; ?>";


                        switch (valorPredefinidoSelectAct5) {
                            case "1":
                                option1.selected = true;
                                break;
                            case "2":
                                option2.selected = true;
                                break;
                            case "3":
                                option3.selected = true;
                                break;
                            case "4":
                                option4.selected = true;
                                break;
                            case "5":
                                option5.selected = true;
                                break;
                            case "6":
                                option6.selected = true;
                                break;
                            case "7":
                                option7.selected = true;
                                break;
                            case "8":
                                option8.selected = true;
                                break;
                        }



                    } else if (indexActividadMostrado == 6) {
                        var valorPredefinidoAct6 = "<?php echo !empty($cargoDescripcion['actividad6']) ? $cargoDescripcion['actividad6'] : ''; ?>";
                        if (valorPredefinidoAct8 == '') {
                            break;
                        }
                        actividad.value = valorPredefinidoAct6; // Establecemos el valor predefinido aquí



                        var valorPredefinidoSelectAct6 = "<?php echo !empty($cargoDescripcion['selectactividad6']) ? $cargoDescripcion['selectactividad6'] : ''; ?>";


                        switch (valorPredefinidoSelectAct6) {
                            case "1":
                                option1.selected = true;
                                break;
                            case "2":
                                option2.selected = true;
                                break;
                            case "3":
                                option3.selected = true;
                                break;
                            case "4":
                                option4.selected = true;
                                break;
                            case "5":
                                option5.selected = true;
                                break;
                            case "6":
                                option6.selected = true;
                                break;
                            case "7":
                                option7.selected = true;
                                break;
                            case "8":
                                option8.selected = true;
                                break;
                        }
                    } else if (indexActividadMostrado == 7) {
                        var valorPredefinidoAct7 = "<?php echo !empty($cargoDescripcion['actividad7']) ? $cargoDescripcion['actividad7'] : ''; ?>";
                        if (valorPredefinidoAct8 == '') {
                            break;
                        }
                        actividad.value = valorPredefinidoAct7; // Establecemos el valor predefinido aquí


                        var valorPredefinidoSelectAct7 = "<?php echo !empty($cargoDescripcion['selectactividad7']) ? $cargoDescripcion['selectactividad7'] : ''; ?>";


                        switch (valorPredefinidoSelectAct7) {
                            case "1":
                                option1.selected = true;
                                break;
                            case "2":
                                option2.selected = true;
                                break;
                            case "3":
                                option3.selected = true;
                                break;
                            case "4":
                                option4.selected = true;
                                break;
                            case "5":
                                option5.selected = true;
                                break;
                            case "6":
                                option6.selected = true;
                                break;
                            case "7":
                                option7.selected = true;
                                break;
                            case "8":
                                option8.selected = true;
                                break;
                        }
                    } else if (indexActividadMostrado == 8) {
                        var valorPredefinidoAct8 = "<?php echo !empty($cargoDescripcion['actividad8']) ? $cargoDescripcion['actividad8'] : ''; ?>";
                        if (valorPredefinidoAct8 == '') {
                            break;
                        }
                        actividad.value = valorPredefinidoAct8; // Establecemos el valor predefinido aquí
                        var valorPredefinidoSelectAct8 = "<?php echo !empty($cargoDescripcion['selectactividad8']) ? $cargoDescripcion['selectactividad8'] : ''; ?>";

                        switch (valorPredefinidoSelectAct8) {
                            case "1":
                                option1.selected = true;
                                break;
                            case "2":
                                option2.selected = true;
                                break;
                            case "3":
                                option3.selected = true;
                                break;
                            case "4":
                                option4.selected = true;
                                break;
                            case "5":
                                option5.selected = true;
                                break;
                            case "6":
                                option6.selected = true;
                                break;
                            case "7":
                                option7.selected = true;
                                break;
                            case "8":
                                option8.selected = true;
                                break;
                        }
                    } else if (indexActividadMostrado == 9) {
                        var valorPredefinidoAct9 = "<?php echo !empty($cargoDescripcion['actividad9']) ? $cargoDescripcion['actividad9'] : ''; ?>";
                        if (valorPredefinidoAct9 == '') {
                            break;
                        }
                        actividad.value = valorPredefinidoAct9; // Establecemos el valor predefinido aquí
                        var valorPredefinidoSelectAct9 = "<?php echo !empty($cargoDescripcion['selectactividad9']) ? $cargoDescripcion['selectactividad9'] : ''; ?>";

                        switch (valorPredefinidoSelectAct9) {
                            case "1":
                                option1.selected = true;
                                break;
                            case "2":
                                option2.selected = true;
                                break;
                            case "3":
                                option3.selected = true;
                                break;
                            case "4":
                                option4.selected = true;
                                break;
                            case "5":
                                option5.selected = true;
                                break;
                            case "6":
                                option6.selected = true;
                                break;
                            case "7":
                                option7.selected = true;
                                break;
                            case "8":
                                option8.selected = true;
                                break;
                        }






                    } else if (indexActividadMostrado == 10) {
                        var valorPredefinidoAct10 = "<?php echo !empty($cargoDescripcion['actividad10']) ? $cargoDescripcion['actividad10'] : ''; ?>";
                        if (valorPredefinidoAct10 == '') {
                            break;
                        }
                        actividad.value = valorPredefinidoAct10; // Establecemos el valor predefinido aquí


                        var valorPredefinidoSelectAct10 = "<?php echo !empty($cargoDescripcion['selectactividad10']) ? $cargoDescripcion['selectactividad10'] : ''; ?>";


                        switch (valorPredefinidoSelectAct10) {
                            case "1":
                                option1.selected = true;
                                break;
                            case "2":
                                option2.selected = true;
                                break;
                            case "3":
                                option3.selected = true;
                                break;
                            case "4":
                                option4.selected = true;
                                break;
                            case "5":
                                option5.selected = true;
                                break;
                            case "6":
                                option6.selected = true;
                                break;
                            case "7":
                                option7.selected = true;
                                break;
                            case "8":
                                option8.selected = true;
                                break;
                        }
                    } else if (indexActividadMostrado == 11) {
                        var valorPredefinidoAct11 = "<?php echo !empty($cargoDescripcion['actividad11']) ? $cargoDescripcion['actividad11'] : ''; ?>";
                        if (valorPredefinidoAct11 == '') {
                            break;
                        }
                        actividad.value = valorPredefinidoAct11; // Establecemos el valor predefinido aquí


                        var valorPredefinidoSelectAct11 = "<?php echo !empty($cargoDescripcion['selectactividad11']) ? $cargoDescripcion['selectactividad11'] : ''; ?>";


                        switch (valorPredefinidoSelectAct11) {
                            case "1":
                                option1.selected = true;
                                break;
                            case "2":
                                option2.selected = true;
                                break;
                            case "3":
                                option3.selected = true;
                                break;
                            case "4":
                                option4.selected = true;
                                break;
                            case "5":
                                option5.selected = true;
                                break;
                            case "6":
                                option6.selected = true;
                                break;
                            case "7":
                                option7.selected = true;
                                break;
                            case "8":
                                option8.selected = true;
                                break;
                        }


                    } else if (indexActividadMostrado == 12) {
                        var valorPredefinidoAct12 = "<?php echo !empty($cargoDescripcion['actividad12']) ? $cargoDescripcion['actividad12'] : ''; ?>";
                        actividad.value = valorPredefinidoAct12; // Establecemos el valor predefinido aquí
                        if (valorPredefinidoAct12 == '') {
                            break;
                        }


                        var valorPredefinidoSelectAct12 = "<?php echo !empty($cargoDescripcion['selectactividad12']) ? $cargoDescripcion['selectactividad12'] : ''; ?>";


                        switch (valorPredefinidoSelectAct12) {
                            case "1":
                                option1.selected = true;
                                break;
                            case "2":
                                option2.selected = true;
                                break;
                            case "3":
                                option3.selected = true;
                                break;
                            case "4":
                                option4.selected = true;
                                break;
                            case "5":
                                option5.selected = true;
                                break;
                            case "6":
                                option6.selected = true;
                                break;
                            case "7":
                                option7.selected = true;
                                break;
                            case "8":
                                option8.selected = true;
                                break;
                        }






                    } else if (indexActividadMostrado == 13) {
                        var valorPredefinidoAct13 = "<?php echo !empty($cargoDescripcion['actividad13']) ? $cargoDescripcion['actividad13'] : ''; ?>";
                        if (valorPredefinidoAct13 == '') {
                            break;
                        }
                        actividad.value = valorPredefinidoAct13; // Establecemos el valor predefinido aquí

                        var valorPredefinidoSelectAct13 = "<?php echo !empty($cargoDescripcion['selectactividad13']) ? $cargoDescripcion['selectactividad13'] : ''; ?>";


                        switch (valorPredefinidoSelectAct13) {
                            case "1":
                                option1.selected = true;
                                break;
                            case "2":
                                option2.selected = true;
                                break;
                            case "3":
                                option3.selected = true;
                                break;
                            case "4":
                                option4.selected = true;
                                break;
                            case "5":
                                option5.selected = true;
                                break;
                            case "6":
                                option6.selected = true;
                                break;
                            case "7":
                                option7.selected = true;
                                break;
                            case "8":
                                option8.selected = true;
                                break;
                        }
                    } else if (indexActividadMostrado == 14) {
                        var valorPredefinidoAct14 = "<?php echo !empty($cargoDescripcion['actividad14']) ? $cargoDescripcion['actividad14'] : ''; ?>";
                        if (valorPredefinidoAct14 == '') {
                            break;
                        }
                        actividad.value = valorPredefinidoAct14; // Establecemos el valor predefinido aquí


                        var valorPredefinidoSelectAct14 = "<?php echo !empty($cargoDescripcion['selectactividad14']) ? $cargoDescripcion['selectactividad14'] : ''; ?>";


                        switch (valorPredefinidoSelectAct14) {
                            case "1":
                                option1.selected = true;
                                break;
                            case "2":
                                option2.selected = true;
                                break;
                            case "3":
                                option3.selected = true;
                                break;
                            case "4":
                                option4.selected = true;
                                break;
                            case "5":
                                option5.selected = true;
                                break;
                            case "6":
                                option6.selected = true;
                                break;
                            case "7":
                                option7.selected = true;
                                break;
                            case "8":
                                option8.selected = true;
                                break;
                        }
                    } else if (indexActividadMostrado == 15) {
                        var valorPredefinidoAct15 = "<?php echo !empty($cargoDescripcion['actividad15']) ? $cargoDescripcion['actividad15'] : ''; ?>";
                        if (valorPredefinidoAct15 == '') {
                            break;
                        }
                        actividad.value = valorPredefinidoAct15; // Establecemos el valor predefinido aquí

                        var valorPredefinidoSelectAct15 = "<?php echo !empty($cargoDescripcion['selectactividad15']) ? $cargoDescripcion['selectactividad15'] : ''; ?>";

                        switch (valorPredefinidoSelectAct15) {
                            case "1":
                                option1.selected = true;
                                break;
                            case "2":
                                option2.selected = true;
                                break;
                            case "3":
                                option3.selected = true;
                                break;
                            case "4":
                                option4.selected = true;
                                break;
                            case "5":
                                option5.selected = true;
                                break;
                            case "6":
                                option6.selected = true;
                                break;
                            case "7":
                                option7.selected = true;
                                break;
                            case "8":
                                option8.selected = true;
                                break;
                        }

                    }

                    select.appendChild(option1);
                    select.appendChild(option2);
                    select.appendChild(option3);
                    select.appendChild(option4);
                    select.appendChild(option5);
                    select.appendChild(option6);
                    select.appendChild(option7);
                    select.appendChild(option8);


                    selectActividad.appendChild(select);
                    actividadLabel.appendChild(selectActividad);

                    contenedorActividades.appendChild(actividadLabel);

                    actividad.focus();
                    indexActividadMostrado++;
                }


                // Desactivar el botón si se han mostrado todos los inputs
                if (indexActividadMostrado == 16) {
                    document.getElementById("boton-agregar").disabled = true;
                }
            }

            if (indexActividadMostrado < 3) {
                document.getElementById("eliminar-actividad").hidden = true;
            }
        }

        function mostrarInputSiguientexf() {

            for (let i = 0; i < 5; i++) {
                // Crear el siguiente input y su correspondiente etiqueta
                if (indexInputMostradoz <= 10) {
                    if (indexInputMostradoz == 6) {
                        var valorcompetencia6 = "<?php echo !empty($cargoDescripcion['competencia6']) ? $cargoDescripcion['competencia6'] : ''; ?>";
                        if (valorcompetencia6 == '') {
                            break;
                        }
                    } else if (indexInputMostradoz == 7) {
                        var valorcompetencia7 = "<?php echo !empty($cargoDescripcion['competencia7']) ? $cargoDescripcion['competencia7'] : ''; ?>";
                        if (valorcompetencia7 == '') {
                            break;
                        }
                    } else if (indexInputMostradoz == 8) {
                        var valorcompetencia8 = "<?php echo !empty($cargoDescripcion['competencia8']) ? $cargoDescripcion['competencia8'] : ''; ?>";
                        if (valorcompetencia8 == '') {
                            break;
                        }
                    } else if (indexInputMostradoz == 9) {
                        var valorcompetencia9 = "<?php echo !empty($cargoDescripcion['competencia9']) ? $cargoDescripcion['competencia9'] : ''; ?>";
                        if (valorcompetencia9 == '') {
                            break;
                        }
                    } else if (indexInputMostradoz == 10) {
                        var valorcompetencia10 = "<?php echo !empty($cargoDescripcion['competencia10']) ? $cargoDescripcion['competencia10'] : ''; ?>";
                        if (valorcompetencia10 == '') {
                            break;
                        }
                    }
                    var inputLabel = document.createElement("div");
                    inputLabel.classList.add("input-group", "mb-3");
                    inputLabel.id = "input-label-" + indexInputMostradoz;

                    var inputLabelPrepend = document.createElement("div");
                    inputLabelPrepend.classList.add("input-group-prepend");

                    var inputLabelSpan = document.createElement("span");
                    inputLabelSpan.classList.add("input-group-text");
                    inputLabelSpan.innerHTML = indexInputMostradoz;

                    inputLabelPrepend.appendChild(inputLabelSpan);
                    inputLabel.appendChild(inputLabelPrepend);

                    var select = document.createElement("select");
                    select.id = "competencia" + indexInputMostradoz;
                    select.name = "competencia" + indexInputMostradoz;
                    select.classList.add("form-control");
                    // Agregar las opciones del array al select
                    <?php foreach ($competencias as $country) { ?>
                        var option = document.createElement("option");
                        option.value = "<?php echo $country['id']; ?>";
                        option.text = "<?php echo $country['nombre']; ?>";
                        option.setAttribute("data-max", "<?php echo $country['descripcion']; ?>");
                        option.setAttribute("data-nombre", "<?php echo $country['nombre']; ?>");

                        var idx = "<?php echo $country['id']; ?>";

                        switch (indexInputMostradoz) {
                            case 6:
                                var valorcompetencia6 = "<?php echo !empty($cargoDescripcion['competencia6']) ? $cargoDescripcion['competencia6'] : ''; ?>";
                                if (valorcompetencia6 == '') {
                                    break;
                                }
                                if (idx === valorcompetencia6) {
                                    option.selected = true;
                                }
                                break;
                            case 7:
                                var valorcompetencia7 = "<?php echo !empty($cargoDescripcion['competencia7']) ? $cargoDescripcion['competencia7'] : ''; ?>";
                                if (valorcompetencia7 == '') {
                                    break;
                                }
                                if (idx === valorcompetencia7) {
                                    option.selected = true;
                                }
                                break;
                            case 8:
                                var valorcompetencia8 = "<?php echo !empty($cargoDescripcion['competencia8']) ? $cargoDescripcion['competencia8'] : ''; ?>";
                                if (valorcompetencia8 == '') {
                                    break;
                                }
                                if (idx === valorcompetencia8) {
                                    option.selected = true;
                                }
                                break;
                            case 9:
                                var valorcompetencia9 = "<?php echo !empty($cargoDescripcion['competencia9']) ? $cargoDescripcion['competencia9'] : ''; ?>";
                                if (valorcompetencia9 == '') {
                                    break;
                                }
                                if (idx === valorcompetencia9) {
                                    option.selected = true;
                                }
                                break;
                            case 10:
                                var valorcompetencia10 = "<?php echo !empty($cargoDescripcion['competencia10']) ? $cargoDescripcion['competencia10'] : ''; ?>";
                                if (valorcompetencia10 == '') {
                                    break;
                                }
                                if (idx === valorcompetencia10) {
                                    option.selected = true;
                                }
                                break;
                        }
                        select.add(option);
                    <?php } ?>

                    inputLabel.appendChild(select);
                    contenedorInputs.appendChild(inputLabel);

                    select.focus();
                    indexInputMostradoz++;
                }

                // Desactivar el botón si se han mostrado todos los inputs
                if (indexInputMostradoz == 11) {
                    document.getElementById("agregamos").disabled = true;
                }
            }
            if (indexInputMostradoz < 7) {
                document.getElementById("eliminar").hidden = true;
            }
        }
    </script>

    <section class="content-header">
        <div class="card text-left">
            <div class="card-header">
                <span style="font-weight: bold; font-size: 25px; color: #3c8dbc; cursor: pointer;" onclick="info_tabla('Descripción de Puestos/Cargos: Planta - Taller - Fábrica','Es un documento donde se registra formalmente el propósito, las funciones, tareas y requisitos de cada puesto/cargo en una empresa u organización, es además fuente de información para la selección, capacitación, incentivos, seguridad ocupacional y administración de los sueldos.')">Descripción Puesto/Cargo (Planta - Taller - Fábrica)</span>
                <br>
                <span style="font-weight: bold; font-size: 25px">Cargo: <?php echo $nombre; ?> - Departamento: <?php echo $departamento; ?> </span>
            </div>
        </div>
    </section>
    <!-- Content Header (Page header) -->




    <?php echo isset($sweetAlertCode) ? $sweetAlertCode : ''; ?>

    <ul class="tabs">
        <li><a href="#tab1"><span class="fa fa-home"></span><span class="tab-text">Identificación</span></a></li>
        <li><a href="#tab2"><span class="fa fa-group"></span><span class="tab-text">Descripción</span></a></li>
        <li><a href="#tab3"><span class="fa fa-briefcase"></span><span class="tab-text">Ambiente e Instrumentos</span></a></li>
        <li><a href="#tab4"><span class="fa fa-bookmark"></span><span class="tab-text">Conocimientos</span></a></li>
        <li><a href="#tab7"><span class="fa fa-arrows-h"></span><span class="tab-text">Competencias</span></a></li>
        <li><a href="#tab5"><span class="fa fa-superpowers"></span><span class="tab-text">Relaciones</span></a></li>
        <li><a href="#tab6"><span class="fa fa-window-restore "></span><span class="tab-text">Condiciones de trabajo</span></a></li>

    </ul>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="assets/js/descripcion-cargo.js"></script>
    <div class="container" style="overflow: auto; max-height: 1000px;">
        <div class="secciones">
            <form action="savedescripciontaller.php" id="formulario" method="POST" onkeydown="return event.key != 'Enter';">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <article id="tab1">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 mt-3 mt-md-0">
                            <div class="form-group">
                                <label for="cargo">Denominación del Puesto/Cargo:</label>
                                <input type="text" value="<?php echo $cargoDescripcion["nombre_cargo"]; ?>" name="cargo" id="cargo" class="form-control" autocomplete="on">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="departamento">Adscrito a la Unidad / Departamento / Gerencia:</label>
                                <input type="text" value="<?php echo $cargoDescripcion["nombre_departamento"]; ?>" name="departamento" id="departamento" class="form-control" autocomplete="on">
                            </div>
                        </div>
                    </div>
                </article>


                <article id="tab2">
                    <div class="form-group">
                        <label for="proposito">Breve descripción del puesto/cargo:</label>
                        <small>Se refiere al objetivo principal, que hace y para qué lo hace.</small>
                        <textarea class="form-control" id="proposito" name="proposito" rows="2"><?php echo $cargoDescripcion["proposito"]; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="funciones">Funciones:</label>
                        <small>Describa las funciones más importantes que permiten alcanzar su propósito general.</small>
                        <style>
                            .oculto {
                                display: none;
                            }
                        </style>
                        <div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">1</span>
                                </div>
                                <textarea id="funcion1" name="funcion1" class="form-control" rows="1" cols="50"><?php echo $cargoDescripcion["funcion1"]; ?></textarea>
                            </div>


                        </div>

                        <div id="contenedor-inputs">
                        </div>
                        <button id="boton-agregar2" class="btn btn-primary btn-md" type="button" onclick="mostrarInputSiguiente()">+ Agregar Campo</button>
                        <button id="eliminar2" class="btn btn-danger btn-md" type="button" onclick="eliminarUltimoTextarea()">- Cerrar campo</button>
                        <script>
                            var contenedorInputsx = document.getElementById("contenedor-inputs");

                            function mostrarInputSiguiente() {

                                // Crear el siguiente textarea y su correspondiente etiqueta
                                if (indexInputMostradox <= 11) {
                                    var inputLabel = document.createElement("div");
                                    inputLabel.classList.add("input-group", "mb-3");
                                    inputLabel.id = "input-labelx-" + indexInputMostradox;

                                    var inputLabelPrepend = document.createElement("div");
                                    inputLabelPrepend.classList.add("input-group-prepend");

                                    var inputLabelSpan = document.createElement("span");
                                    inputLabelSpan.classList.add("input-group-text");
                                    inputLabelSpan.innerHTML = indexInputMostradox;

                                    inputLabelPrepend.appendChild(inputLabelSpan);
                                    inputLabel.appendChild(inputLabelPrepend);

                                    var input = document.createElement("textarea");
                                    input.id = "funcion" + indexInputMostradox;
                                    input.name = "funcion" + indexInputMostradox;
                                    input.classList.add("form-control");
                                    input.rows = 1;
                                    input.cols = 50;

                                    if (indexInputMostradox == 2) {
                                        var valorPredefinido2 = "<?php echo !empty($cargoDescripcion['funcion2']) ? $cargoDescripcion['funcion2'] : ''; ?>";
                                        input.value = valorPredefinido2; // Establecemos el valor predefinido aquí
                                    } else if (indexInputMostradox == 3) {
                                        var valorPredefinido3 = "<?php echo !empty($cargoDescripcion['funcion3']) ? $cargoDescripcion['funcion3'] : ''; ?>";
                                        input.value = valorPredefinido3; // Establecemos el valor predefinido aquí
                                    } else if (indexInputMostradox == 4) {
                                        var valorPredefinido4 = "<?php echo !empty($cargoDescripcion['funcion4']) ? $cargoDescripcion['funcion4'] : ''; ?>";
                                        input.value = valorPredefinido4; // Establecemos el valor predefinido aquí
                                    } else if (indexInputMostradox == 5) {
                                        var valorPredefinido5 = "<?php echo !empty($cargoDescripcion['funcion5']) ? $cargoDescripcion['funcion5'] : ''; ?>";
                                        input.value = valorPredefinido5; // Establecemos el valor predefinido aquí
                                    } else if (indexInputMostradox == 6) {
                                        var valorPredefinido6 = "<?php echo !empty($cargoDescripcion['funcion6']) ? $cargoDescripcion['funcion6'] : ''; ?>";
                                        input.value = valorPredefinido6; // Establecemos el valor predefinido aquí
                                    } else if (indexInputMostradox == 7) {
                                        var valorPredefinido7 = "<?php echo !empty($cargoDescripcion['funcion7']) ? $cargoDescripcion['funcion7'] : ''; ?>";
                                        input.value = valorPredefinido7; // Establecemos el valor predefinido aquí
                                    } else if (indexInputMostradox == 8) {
                                        var valorPredefinido8 = "<?php echo !empty($cargoDescripcion['funcion8']) ? $cargoDescripcion['funcion8'] : ''; ?>";
                                        input.value = valorPredefinido8; // Establecemos el valor predefinido aquí
                                    } else if (indexInputMostradox == 9) {
                                        var valorPredefinido9 = "<?php echo !empty($cargoDescripcion['funcion9']) ? $cargoDescripcion['funcion9'] : ''; ?>";
                                        input.value = valorPredefinido9; // Establecemos el valor predefinido aquí
                                    } else if (indexInputMostradox == 10) {
                                        var valorPredefinido10 = "<?php echo !empty($cargoDescripcion['funcion10']) ? $cargoDescripcion['funcion10'] : ''; ?>";
                                        input.value = valorPredefinido10; // Establecemos el valor predefinido aquí
                                    } else if (indexInputMostradox == 11) {
                                        var valorPredefinido11 = "<?php echo !empty($cargoDescripcion['funcion11']) ? $cargoDescripcion['funcion11'] : ''; ?>";
                                        input.value = valorPredefinido11; // Establecemos el valor predefinido aquí
                                    }

                                    inputLabel.appendChild(input);
                                    contenedorInputsx.appendChild(inputLabel);

                                    input.focus();
                                    indexInputMostradox++;
                                    document.getElementById("eliminar2").hidden = false;
                                }

                                // Desactivar el botón si se han mostrado todos los inputs
                                if (indexInputMostradox == 11) {
                                    document.getElementById("boton-agregar2").disabled = true;
                                }
                            }

                            function eliminarUltimoTextarea() {
                                if (indexInputMostradox > 1) {
                                    var ultimoTextarea = document.getElementById("input-labelx-" + (indexInputMostradox - 1));
                                    if (ultimoTextarea.parentNode === contenedorInputsx) {
                                        contenedorInputsx.removeChild(ultimoTextarea);
                                        indexInputMostradox--;
                                        document.getElementById("boton-agregar2").disabled = false;
                                        if (indexInputMostradox < 3) {
                                            document.getElementById("eliminar2").hidden = true;
                                        }
                                    } else {
                                        console.log("The child node is not a child of the parent node.");
                                    }
                                }
                            }
                        </script>


                    </div>
                    <div class="form-group">
                        <label for="actividades">Actividades:</label>
                        <small>Indique el conjunto de tareas/actividades que se deben realizar en el puesto/cargo para el logro de las funciones anteriormente señalada.</small>
                        <div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">1</span>
                                </div>
                                <textarea id="actividad1" name="actividad1" class="form-control" rows="1"><?php echo $cargoDescripcion["actividad1"]; ?></textarea>
                                <div class="input-group-append">
                                    <select class="form-control" id="selectactividad1" name="selectactividad1">
                                        <option disabled selected value="">Frecuencia</option>
                                        <option value="1" <?php if ($cargoDescripcion["selectactividad1"] == "1") {
                                                                echo "selected";
                                                            } ?>>Diario</option>
                                        <option value="2" <?php if ($cargoDescripcion["selectactividad1"] == "2") {
                                                                echo "selected";
                                                            } ?>>Semanal</option>
                                        <option value="3" <?php if ($cargoDescripcion["selectactividad1"] == "3") {
                                                                echo "selected";
                                                            } ?>>Mensual</option>
                                        <option value="4" <?php if ($cargoDescripcion["selectactividad1"] == "4") {
                                                                echo "selected";
                                                            } ?>>Bimestral</option>
                                        <option value="5" <?php if ($cargoDescripcion["selectactividad1"] == "5") {
                                                                echo "selected";
                                                            } ?>>Trimestral</option>
                                        <option value="6" <?php if ($cargoDescripcion["selectactividad1"] == "6") {
                                                                echo "selected";
                                                            } ?>>Cuatrimestral</option>
                                        <option value="7" <?php if ($cargoDescripcion["selectactividad1"] == "7") {
                                                                echo "selected";
                                                            } ?>>Semestral</option>
                                        <option value="8" <?php if ($cargoDescripcion["selectactividad1"] == "8") {
                                                                echo "selected";
                                                            } ?>>Anual</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="contenedor-actividades">
                        </div>

                        <button id="boton-agregar" class="btn btn-primary btn-md" type="button" onclick="mostrarSiguienteActividad()">+ Agregar Campo</button>
                        <button id="eliminar-actividad" class="btn btn-danger btn-md" type="button" onclick="eliminarUltimaActividad()">- Cerrar campo</button>
                        <script>
                            var contenedorActividades = document.getElementById("contenedor-actividades");

                            function mostrarSiguienteActividad() {


                                // Crear el siguiente input y su correspondiente etiqueta
                                if (indexActividadMostrado <= 15) {

                                    document.getElementById("eliminar-actividad").hidden = false;
                                    var actividadLabel = document.createElement("div");
                                    actividadLabel.classList.add("input-group", "mb-3");
                                    actividadLabel.id = "actividad-label-" + indexActividadMostrado;

                                    var actividadLabelPrepend = document.createElement("div");
                                    actividadLabelPrepend.classList.add("input-group-prepend");

                                    var actividadLabelSpan = document.createElement("span");
                                    actividadLabelSpan.classList.add("input-group-text");
                                    actividadLabelSpan.innerHTML = indexActividadMostrado;

                                    actividadLabelPrepend.appendChild(actividadLabelSpan);
                                    actividadLabel.appendChild(actividadLabelPrepend);

                                    var actividad = document.createElement("textarea");
                                    actividad.id = "actividad" + indexActividadMostrado;
                                    actividad.name = "actividad" + indexActividadMostrado;
                                    actividad.classList.add("form-control");
                                    actividad.rows = "2";
                                    actividad.removeAttribute("type");

                                    actividadLabel.appendChild(actividad);
                                    var selectActividad = document.createElement("div");
                                    selectActividad.classList.add("input-group-append");

                                    var select = document.createElement("select");
                                    select.classList.add("form-control");
                                    select.id = "selectactividad" + indexActividadMostrado;
                                    select.name = "selectactividad" + indexActividadMostrado;

                                    var option0 = document.createElement("option");
                                    option0.value = "";
                                    option0.text = "Frecuencia";
                                    option0.disabled = true;
                                    option0.selected = true;

                                    var option1 = document.createElement("option");
                                    option1.value = "1";
                                    option1.text = "Diario";


                                    var option2 = document.createElement("option");
                                    option2.value = "2";
                                    option2.text = "Semanal";


                                    var option3 = document.createElement("option");
                                    option3.value = "3";
                                    option3.text = "Mensual";

                                    var option4 = document.createElement("option");
                                    option4.value = "4";
                                    option4.text = "Bimestral";


                                    var option5 = document.createElement("option");
                                    option5.value = "5";
                                    option5.text = "Trimestral";


                                    var option6 = document.createElement("option");
                                    option6.value = "6";
                                    option6.text = "Cuatrimestral";


                                    var option7 = document.createElement("option");
                                    option7.value = "7";
                                    option7.text = "Semestral";


                                    var option8 = document.createElement("option");
                                    option8.value = "8";
                                    option8.text = "Anual";



                                    if (indexActividadMostrado == 2) {
                                        var valorPredefinidoAct2 = "<?php echo !empty($cargoDescripcion['actividad2']) ? $cargoDescripcion['actividad2'] : ''; ?>";
                                        actividad.value = valorPredefinidoAct2; // Establecemos el valor predefinido aquí

                                        var valorPredefinidoSelectAct2 = "<?php echo !empty($cargoDescripcion['selectactividad2']) ? $cargoDescripcion['selectactividad2'] : ''; ?>";


                                        switch (valorPredefinidoSelectAct2) {
                                            case "1":
                                                option1.selected = true;
                                                break;
                                            case "2":
                                                option2.selected = true;
                                                break;
                                            case "3":
                                                option3.selected = true;
                                                break;
                                            case "4":
                                                option4.selected = true;
                                                break;
                                            case "5":
                                                option5.selected = true;
                                                break;
                                            case "6":
                                                option6.selected = true;
                                                break;
                                            case "7":
                                                option7.selected = true;
                                                break;
                                            case "8":
                                                option8.selected = true;
                                                break;
                                        }





                                    } else if (indexActividadMostrado == 3) {
                                        var valorPredefinidoAct3 = "<?php echo !empty($cargoDescripcion['actividad3']) ? $cargoDescripcion['actividad3'] : ''; ?>";
                                        actividad.value = valorPredefinidoAct3; // Establecemos el valor predefinido aquí



                                        var valorPredefinidoSelectAct3 = "<?php echo !empty($cargoDescripcion['selectactividad3']) ? $cargoDescripcion['selectactividad3'] : ''; ?>";


                                        switch (valorPredefinidoSelectAct3) {
                                            case "1":
                                                option1.selected = true;
                                                break;
                                            case "2":
                                                option2.selected = true;
                                                break;
                                            case "3":
                                                option3.selected = true;
                                                break;
                                            case "4":
                                                option4.selected = true;
                                                break;
                                            case "5":
                                                option5.selected = true;
                                                break;
                                            case "6":
                                                option6.selected = true;
                                                break;
                                            case "7":
                                                option7.selected = true;
                                                break;
                                            case "8":
                                                option8.selected = true;
                                                break;
                                        }





                                    } else if (indexActividadMostrado == 4) {
                                        var valorPredefinidoAct4 = "<?php echo !empty($cargoDescripcion['actividad4']) ? $cargoDescripcion['actividad4'] : ''; ?>";
                                        actividad.value = valorPredefinidoAct4; // Establecemos el valor predefinido aquí



                                        var valorPredefinidoSelectAct4 = "<?php echo !empty($cargoDescripcion['selectactividad4']) ? $cargoDescripcion['selectactividad4'] : ''; ?>";


                                        switch (valorPredefinidoSelectAct4) {
                                            case "1":
                                                option1.selected = true;
                                                break;
                                            case "2":
                                                option2.selected = true;
                                                break;
                                            case "3":
                                                option3.selected = true;
                                                break;
                                            case "4":
                                                option4.selected = true;
                                                break;
                                            case "5":
                                                option5.selected = true;
                                                break;
                                            case "6":
                                                option6.selected = true;
                                                break;
                                            case "7":
                                                option7.selected = true;
                                                break;
                                            case "8":
                                                option8.selected = true;
                                                break;
                                        }
                                    } else if (indexActividadMostrado == 5) {
                                        var valorPredefinidoAct5 = "<?php echo !empty($cargoDescripcion['actividad5']) ? $cargoDescripcion['actividad5'] : ''; ?>";
                                        actividad.value = valorPredefinidoAct5; // Establecemos el valor predefinido aquí

                                        var valorPredefinidoSelectAct5 = "<?php echo !empty($cargoDescripcion['selectactividad5']) ? $cargoDescripcion['selectactividad5'] : ''; ?>";


                                        switch (valorPredefinidoSelectAct5) {
                                            case "1":
                                                option1.selected = true;
                                                break;
                                            case "2":
                                                option2.selected = true;
                                                break;
                                            case "3":
                                                option3.selected = true;
                                                break;
                                            case "4":
                                                option4.selected = true;
                                                break;
                                            case "5":
                                                option5.selected = true;
                                                break;
                                            case "6":
                                                option6.selected = true;
                                                break;
                                            case "7":
                                                option7.selected = true;
                                                break;
                                            case "8":
                                                option8.selected = true;
                                                break;
                                        }



                                    } else if (indexActividadMostrado == 6) {
                                        var valorPredefinidoAct6 = "<?php echo !empty($cargoDescripcion['actividad6']) ? $cargoDescripcion['actividad6'] : ''; ?>";
                                        actividad.value = valorPredefinidoAct6; // Establecemos el valor predefinido aquí



                                        var valorPredefinidoSelectAct6 = "<?php echo !empty($cargoDescripcion['selectactividad6']) ? $cargoDescripcion['selectactividad6'] : ''; ?>";


                                        switch (valorPredefinidoSelectAct6) {
                                            case "1":
                                                option1.selected = true;
                                                break;
                                            case "2":
                                                option2.selected = true;
                                                break;
                                            case "3":
                                                option3.selected = true;
                                                break;
                                            case "4":
                                                option4.selected = true;
                                                break;
                                            case "5":
                                                option5.selected = true;
                                                break;
                                            case "6":
                                                option6.selected = true;
                                                break;
                                            case "7":
                                                option7.selected = true;
                                                break;
                                            case "8":
                                                option8.selected = true;
                                                break;
                                        }
                                    } else if (indexActividadMostrado == 7) {
                                        var valorPredefinidoAct7 = "<?php echo !empty($cargoDescripcion['actividad7']) ? $cargoDescripcion['actividad7'] : ''; ?>";
                                        actividad.value = valorPredefinidoAct7; // Establecemos el valor predefinido aquí


                                        var valorPredefinidoSelectAct7 = "<?php echo !empty($cargoDescripcion['selectactividad7']) ? $cargoDescripcion['selectactividad7'] : ''; ?>";


                                        switch (valorPredefinidoSelectAct7) {
                                            case "1":
                                                option1.selected = true;
                                                break;
                                            case "2":
                                                option2.selected = true;
                                                break;
                                            case "3":
                                                option3.selected = true;
                                                break;
                                            case "4":
                                                option4.selected = true;
                                                break;
                                            case "5":
                                                option5.selected = true;
                                                break;
                                            case "6":
                                                option6.selected = true;
                                                break;
                                            case "7":
                                                option7.selected = true;
                                                break;
                                            case "8":
                                                option8.selected = true;
                                                break;
                                        }




















                                    } else if (indexActividadMostrado == 8) {
                                        var valorPredefinidoAct8 = "<?php echo !empty($cargoDescripcion['actividad8']) ? $cargoDescripcion['actividad8'] : ''; ?>";
                                        actividad.value = valorPredefinidoAct8; // Establecemos el valor predefinido aquí




                                        var valorPredefinidoSelectAct8 = "<?php echo !empty($cargoDescripcion['selectactividad8']) ? $cargoDescripcion['selectactividad8'] : ''; ?>";


                                        switch (valorPredefinidoSelectAct8) {
                                            case "1":
                                                option1.selected = true;
                                                break;
                                            case "2":
                                                option2.selected = true;
                                                break;
                                            case "3":
                                                option3.selected = true;
                                                break;
                                            case "4":
                                                option4.selected = true;
                                                break;
                                            case "5":
                                                option5.selected = true;
                                                break;
                                            case "6":
                                                option6.selected = true;
                                                break;
                                            case "7":
                                                option7.selected = true;
                                                break;
                                            case "8":
                                                option8.selected = true;
                                                break;
                                        }
                                    } else if (indexActividadMostrado == 9) {
                                        var valorPredefinidoAct9 = "<?php echo !empty($cargoDescripcion['actividad9']) ? $cargoDescripcion['actividad9'] : ''; ?>";
                                        actividad.value = valorPredefinidoAct9; // Establecemos el valor predefinido aquí

                                        var valorPredefinidoSelectAct9 = "<?php echo !empty($cargoDescripcion['selectactividad9']) ? $cargoDescripcion['selectactividad9'] : ''; ?>";


                                        switch (valorPredefinidoSelectAct9) {
                                            case "1":
                                                option1.selected = true;
                                                break;
                                            case "2":
                                                option2.selected = true;
                                                break;
                                            case "3":
                                                option3.selected = true;
                                                break;
                                            case "4":
                                                option4.selected = true;
                                                break;
                                            case "5":
                                                option5.selected = true;
                                                break;
                                            case "6":
                                                option6.selected = true;
                                                break;
                                            case "7":
                                                option7.selected = true;
                                                break;
                                            case "8":
                                                option8.selected = true;
                                                break;
                                        }






                                    } else if (indexActividadMostrado == 10) {
                                        var valorPredefinidoAct10 = "<?php echo !empty($cargoDescripcion['actividad10']) ? $cargoDescripcion['actividad10'] : ''; ?>";
                                        actividad.value = valorPredefinidoAct10; // Establecemos el valor predefinido aquí


                                        var valorPredefinidoSelectAct10 = "<?php echo !empty($cargoDescripcion['selectactividad10']) ? $cargoDescripcion['selectactividad10'] : ''; ?>";


                                        switch (valorPredefinidoSelectAct10) {
                                            case "1":
                                                option1.selected = true;
                                                break;
                                            case "2":
                                                option2.selected = true;
                                                break;
                                            case "3":
                                                option3.selected = true;
                                                break;
                                            case "4":
                                                option4.selected = true;
                                                break;
                                            case "5":
                                                option5.selected = true;
                                                break;
                                            case "6":
                                                option6.selected = true;
                                                break;
                                            case "7":
                                                option7.selected = true;
                                                break;
                                            case "8":
                                                option8.selected = true;
                                                break;
                                        }
                                    } else if (indexActividadMostrado == 11) {
                                        var valorPredefinidoAct11 = "<?php echo !empty($cargoDescripcion['actividad11']) ? $cargoDescripcion['actividad11'] : ''; ?>";
                                        actividad.value = valorPredefinidoAct11; // Establecemos el valor predefinido aquí


                                        var valorPredefinidoSelectAct11 = "<?php echo !empty($cargoDescripcion['selectactividad11']) ? $cargoDescripcion['selectactividad11'] : ''; ?>";


                                        switch (valorPredefinidoSelectAct11) {
                                            case "1":
                                                option1.selected = true;
                                                break;
                                            case "2":
                                                option2.selected = true;
                                                break;
                                            case "3":
                                                option3.selected = true;
                                                break;
                                            case "4":
                                                option4.selected = true;
                                                break;
                                            case "5":
                                                option5.selected = true;
                                                break;
                                            case "6":
                                                option6.selected = true;
                                                break;
                                            case "7":
                                                option7.selected = true;
                                                break;
                                            case "8":
                                                option8.selected = true;
                                                break;
                                        }


                                    } else if (indexActividadMostrado == 12) {
                                        var valorPredefinidoAct12 = "<?php echo !empty($cargoDescripcion['actividad12']) ? $cargoDescripcion['actividad12'] : ''; ?>";
                                        actividad.value = valorPredefinidoAct12; // Establecemos el valor predefinido aquí

                                        var valorPredefinidoSelectAct12 = "<?php echo !empty($cargoDescripcion['selectactividad12']) ? $cargoDescripcion['selectactividad12'] : ''; ?>";


                                        switch (valorPredefinidoSelectAct12) {
                                            case "1":
                                                option1.selected = true;
                                                break;
                                            case "2":
                                                option2.selected = true;
                                                break;
                                            case "3":
                                                option3.selected = true;
                                                break;
                                            case "4":
                                                option4.selected = true;
                                                break;
                                            case "5":
                                                option5.selected = true;
                                                break;
                                            case "6":
                                                option6.selected = true;
                                                break;
                                            case "7":
                                                option7.selected = true;
                                                break;
                                            case "8":
                                                option8.selected = true;
                                                break;
                                        }






                                    } else if (indexActividadMostrado == 13) {
                                        var valorPredefinidoAct13 = "<?php echo !empty($cargoDescripcion['actividad13']) ? $cargoDescripcion['actividad13'] : ''; ?>";
                                        actividad.value = valorPredefinidoAct13; // Establecemos el valor predefinido aquí

                                        var valorPredefinidoSelectAct13 = "<?php echo !empty($cargoDescripcion['selectactividad13']) ? $cargoDescripcion['selectactividad13'] : ''; ?>";


                                        switch (valorPredefinidoSelectAct13) {
                                            case "1":
                                                option1.selected = true;
                                                break;
                                            case "2":
                                                option2.selected = true;
                                                break;
                                            case "3":
                                                option3.selected = true;
                                                break;
                                            case "4":
                                                option4.selected = true;
                                                break;
                                            case "5":
                                                option5.selected = true;
                                                break;
                                            case "6":
                                                option6.selected = true;
                                                break;
                                            case "7":
                                                option7.selected = true;
                                                break;
                                            case "8":
                                                option8.selected = true;
                                                break;
                                        }





                                    } else if (indexActividadMostrado == 14) {
                                        var valorPredefinidoAct14 = "<?php echo !empty($cargoDescripcion['actividad14']) ? $cargoDescripcion['actividad14'] : ''; ?>";
                                        actividad.value = valorPredefinidoAct14; // Establecemos el valor predefinido aquí


                                        var valorPredefinidoSelectAct14 = "<?php echo !empty($cargoDescripcion['selectactividad14']) ? $cargoDescripcion['selectactividad14'] : ''; ?>";


                                        switch (valorPredefinidoSelectAct14) {
                                            case "1":
                                                option1.selected = true;
                                                break;
                                            case "2":
                                                option2.selected = true;
                                                break;
                                            case "3":
                                                option3.selected = true;
                                                break;
                                            case "4":
                                                option4.selected = true;
                                                break;
                                            case "5":
                                                option5.selected = true;
                                                break;
                                            case "6":
                                                option6.selected = true;
                                                break;
                                            case "7":
                                                option7.selected = true;
                                                break;
                                            case "8":
                                                option8.selected = true;
                                                break;
                                        }






                                    } else if (indexActividadMostrado == 15) {
                                        var valorPredefinidoAct15 = "<?php echo !empty($cargoDescripcion['actividad15']) ? $cargoDescripcion['actividad15'] : ''; ?>";
                                        actividad.value = valorPredefinidoAct15; // Establecemos el valor predefinido aquí

                                        var valorPredefinidoSelectAct15 = "<?php echo !empty($cargoDescripcion['selectactividad15']) ? $cargoDescripcion['selectactividad15'] : ''; ?>";
                                        switch (valorPredefinidoSelectAct15) {
                                            case "1":
                                                option1.selected = true;
                                                break;
                                            case "2":
                                                option2.selected = true;
                                                break;
                                            case "3":
                                                option3.selected = true;
                                                break;
                                            case "4":
                                                option4.selected = true;
                                                break;
                                            case "5":
                                                option5.selected = true;
                                                break;
                                            case "6":
                                                option6.selected = true;
                                                break;
                                            case "7":
                                                option7.selected = true;
                                                break;
                                            case "8":
                                                option8.selected = true;
                                                break;
                                        }

                                    }
                                    select.appendChild(option0);

                                    select.appendChild(option1);
                                    select.appendChild(option2);
                                    select.appendChild(option3);
                                    select.appendChild(option4);
                                    select.appendChild(option5);
                                    select.appendChild(option6);
                                    select.appendChild(option7);
                                    select.appendChild(option8);


                                    selectActividad.appendChild(select);
                                    actividadLabel.appendChild(selectActividad);

                                    contenedorActividades.appendChild(actividadLabel);

                                    actividad.focus();
                                    indexActividadMostrado++;
                                }

                                // Desactivar el botón si se han mostrado todos los inputs
                                if (indexActividadMostrado == 16) {
                                    document.getElementById("boton-agregar").disabled = true;
                                }
                            }

                            function eliminarUltimaActividad() {
                                if (indexActividadMostrado > 1) {
                                    var ultimaActividad = document.getElementById("actividad-label-" + (indexActividadMostrado - 1));
                                    if (ultimaActividad.parentNode === contenedorActividades) {
                                        contenedorActividades.removeChild(ultimaActividad);
                                        indexActividadMostrado--;
                                        document.getElementById("boton-agregar").disabled = false;
                                        if (indexActividadMostrado < 3) {
                                            document.getElementById("eliminar-actividad").hidden = true;
                                        }
                                    } else {
                                        console.log("The child node is not a child of the parent node.");
                                    }
                                }
                            }
                        </script>
                    </div>
                </article>

                <article id="tab3">
                    <div class="form-group">
                        <div class="row mt-3">

                            <div class="col-xs-12 col-md-6">
                                <label for="ambientes">Ambiente de trabajo:</label>
                                <small>Se refiere a los atributos para el adecuado desempeño de las actividades y funciones del puesto o cargo. (Seleccione las principales habilidades): </small>




                                <div class="frb frb-primary">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Amb[1]" id="check_Amb1" value="1" <?php if ($cargoDescripcion["ambiente1"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Amb1">
                                        <span class="frb-title">Capacidad organizativa.</span>
                                    </label>
                                </div>



                                <div class="frb frb-primary">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Amb[3]" id="check_Amb3" value="1" <?php if ($cargoDescripcion["ambiente3"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Amb3"><span class="frb-title">Fábrica ó Planta Industrial</span></label>
                                    <br />
                                </div>
                                <div class="frb frb-primary">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Amb[4]" id="check_Amb4" value="1" <?php if ($cargoDescripcion["ambiente4"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Amb4"><span class="frb-title"> Al Aire Libre</span></label>
                                    <br />
                                </div>
                                <div class="frb frb-primary">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Amb[5]" id="check_Amb5" value="1" <?php if ($cargoDescripcion["ambiente5"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Amb5"><span class="frb-title">Movil (Motorizado ó Chofer)</span></label>
                                    <br />
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <label for="maquinas">Maquinas que opera:</label>
                                <small>Se refiere a los atributos para el adecuado desempeño de las actividades y funciones del puesto o cargo. (Seleccione las principales habilidades): </small>


                                <div class="frb frb-primary">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Maq[1]" id="check_Maq1" value="1" <?php if ($cargoDescripcion["maquina1"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Maq1">
                                        <span class="frb-title">Computador</span>
                                    </label>
                                </div>


                                <div class="frb frb-primary">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Maq[2]" id="check_Maq2" value="1" <?php if ($cargoDescripcion["maquina2"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Maq2">
                                        <span class="frb-title">Tablero Electrónico</span>
                                    </label>
                                </div>

                                <div class="frb frb-primary">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Maq[3]" id="check_Maq3" value="1" <?php if ($cargoDescripcion["maquina3"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Maq3">
                                        <span class="frb-title">Torno Fresadora</span>
                                    </label>
                                </div>

                                <div class="frb frb-primary">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Maq[4]" id="check_Maq4" value="1" <?php if ($cargoDescripcion["maquina4"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Maq4">
                                        <span class="frb-title">Montacargas</span>
                                    </label>
                                </div>
                                <div class="frb frb-primary">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Maq[5]" id="check_Maq5" value="1" <?php if ($cargoDescripcion["maquina5"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Maq5">
                                        <span class="frb-title">Otros: (menciónelos)</span>
                                    </label>
                                </div>


                                <input type="text" value="<?php echo $cargoDescripcion["otras_maquinas"]; ?>" name="otras_maquinas" id="otras_maquinas" class="form-control" autocomplete="on" disabled>

                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-xs-12 col-md-6">
                                <label for="instrumentos">Instrumentos de trabajo:</label>
                                <small>Se refiere a los atributos para el adecuado desempeño de las actividades y funciones del puesto o cargo. (Seleccione las principales habilidades): </small>





                                <div class="frb frb-primary">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Ins[1]" id="check_Ins1" value="1" <?php if ($cargoDescripcion["instrumento1"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Ins1">
                                        <span class="frb-title">Herramientas (Llaves, Martillo, Destornillador, Alicates, etc.)</span>
                                    </label>
                                </div>



                                <div class="frb frb-primary">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Ins[2]" id="check_Ins2" value="1" <?php if ($cargoDescripcion["instrumento2"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Ins2">
                                        <span class="frb-title">Probadores eléctricos (probadores de voltaje, multímetro, tester eléctrico, etc.)</span>
                                    </label>
                                </div>

                            </div>

                            <div class="col-xs-12 col-md-6">

                                <label for="traslados">Traslados</label>
                                <small>Describa si para desempeñar su trabajo requiere la realización de traslados: </small>

                                <div class="frb frb-primary">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Tra[1]" id="check_Tra1" value="1" <?php if ($cargoDescripcion["traslado1"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Tra1"><span class="frb-title">Computador</span></label>
                                    <br />
                                </div>
                                <div class="frb frb-primary">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Tra[2]" id="check_Tra2" value="1" <?php if ($cargoDescripcion["traslado2"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Tra2"><span class="frb-title">Tablero Electrónico</span></label>
                                    <br />
                                </div>
                                <div class="frb frb-primary">
                                    <input class="form-check-input checkbox-inline" type="checkbox" name="check_Tra[3]" id="check_Tra3" value="1" <?php if ($cargoDescripcion["traslado3"] == 1) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="check_Tra3"><span class="frb-title">Torno Fresadora</span></label>
                                    <br />
                                </div>
                                <label for="frecuencia_traslado">Frecuencia traslados</label>
                                <input type="text" value="<?php echo $cargoDescripcion["frecuencia_traslado"]; ?>" name="frecuencia_traslado" id="frecuencia_traslado" class="form-control" autocomplete="on">

                            </div>
                        </div>



                        <div class="row mt-5">
                            <div class="col-xs-12 col-md-6">
                                <label for="manipular_elementos">Elementos peligrosos </label>
                                <small>
                                    Describa si para desempeñar su trabajo requiere la manipulación de liquidos u otros elementos químicos, biológicos, etc. Especifique:
                                </small>
                                <textarea class="form-control" id="manipular_elementos" name="manipular_elementos" rows="5"><?php echo $cargoDescripcion["manipular_elementos"]; ?></textarea>
                            </div>
                            <div class="col-xs-12 col-md-6">
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
                            <label for="educacionFormal">Educación Formal</label>
                            <small></small>























                            <div class="frb frb-primary">
                                <input class="form-check-input radio-inline" type="radio" name="radio_Con[]" id="radio_Con1" value="Bachiller" <?php if ($radioConocimiento === 'radio_Con1') echo ' checked'; ?>>
                                <label class="form-check-label" for="radio_Con1"><span class="frb-title">Bachiller</span></label>
                                <br />
                            </div>

                            <div class="frb frb-primary">
                                <input class="form-check-input radio-inline" type="radio" name="radio_Con[]" id="radio_Con2" value="Tecnico Medio" <?php if ($radioConocimiento === 'radio_Con2') echo ' checked'; ?>>
                                <label class="form-check-label" for="radio_Con2"><span class="frb-title">Técnico Medio</span></label>
                                <br />
                            </div>
                            <div class="frb frb-primary">
                                <input class="form-check-input radio-inline" type="radio" name="radio_Con[]" id="radio_Con3" value="Tecnico Superior Universitario" <?php if ($radioConocimiento === 'radio_Con3') echo ' checked'; ?>>
                                <label class="form-check-label" for="radio_Con3"><span class="frb-title">Técnico Superior Universitario</span></label>
                                <br />
                            </div>
                            <div class="frb frb-primary">
                                <input class="form-check-input radio-inline" type="radio" name="radio_Con[]" id="radio_Con4" value="Graduado Universitario" <?php if ($radioConocimiento === 'radio_Con4') echo ' checked'; ?>>
                                <label class="form-check-label" for="radio_Con4"><span class="frb-title">Graduado Universitario</span></label>
                                <br />
                            </div>

                        </div>

                        <div class="col-xs-12 col-md-6">
                            <label for="experiencia">Experiencia:</label>
                            <small></small>

                            <div class="frb frb-primary">
                                <input class="form-check-input radio-inline" type="radio" name="radio_Exp[]" id="radio_Exp1" value="Menos de un (1) año" <?php if ($radioExperiencia === 'radio_Exp1') echo ' checked'; ?>>
                                <label class="form-check-label" for="radio_Exp1"><span class="frb-title">Menos de un (1) año</span></label>
                                <br />
                            </div>
                            <div class="frb frb-primary">
                                <input class="form-check-input radio-inline" type="radio" name="radio_Exp[]" id="radio_Exp2" value="Mas de un (1) hasta dos (2) años" <?php if ($radioExperiencia === 'radio_Exp2') echo ' checked'; ?>>
                                <label class="form-check-label" for="radio_Exp2"><span class="frb-title">Más de un (1) hasta dos (2) años</span></label>
                                <br />
                            </div>
                            <div class="frb frb-primary">
                                <input class="form-check-input radio-inline" type="radio" name="radio_Exp[]" id="radio_Exp3" value="Más de dos (2) a cinco (5) años" <?php if ($radioExperiencia === 'radio_Exp3') echo ' checked'; ?>>
                                <label class="form-check-label" for="radio_Exp3"><span class="frb-title">Más de dos (2) a cinco (5) años</span></label>
                                <br />
                            </div>
                            <div class="frb frb-primary">
                                <input class="form-check-input radio-inline" type="radio" name="radio_Exp[]" id="radio_Exp4" value="De seis (6) a nueve (9) años" <?php if ($radioExperiencia === 'radio_Exp4') echo ' checked'; ?>>
                                <label class="form-check-label" for="radio_Exp4"><span class="frb-title">Más de seis (6) años</span></label>
                                <br />
                            </div>
                            <div class="frb frb-primary">
                                <input class="form-check-input radio-inline" type="radio" name="radio_Exp[]" id="radio_Exp5" value="Mas de nueve (9) años" <?php if ($radioExperiencia === 'radio_Exp5') echo ' checked'; ?>>
                                <label class="form-check-label" for="radio_Exp5"><span class="frb-title">Más de nueve (9) años</span></label>
                                <br />
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

                            <label for="relacionesInternas" style="font-weight: bold; color: #3c8dbc; cursor: pointer;" onclick="info_tabla('Relaciones internas:','Con qué otras unidades de la organización deben mantener relaciones frecuentes para el logro de los resultados de su puesto. Relaciones 4 ó 5 de estas unidades y describa brevemente para qué. Cliente Interno')"> Relaciones internas: </label>

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
                                <div class="frb frb-primary">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Rie[]" id="radio_Rie1" value="Minimas posibilidades de exposicion a accidentes de trabajo o enfermedades profesionales" <?php if ($radioRiesgos === 'radio_Rie1') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Rie1"><span class="frb-title">Mínimas posibilidades de exposición a accidentes de trabajo o enfermedades profesionales.</span></label>
                                </div>
                                <div class="frb frb-primary">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Rie[]" id="radio_Rie2" value="Medianas posibilidades de exposicion a accidentes de trabajo o enfermedades profesionales" <?php if ($radioRiesgos === 'radio_Rie2') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Rie2"><span class="frb-title">Medianas posibilidades de exposición a accidentes de trabajo o enfermedades profesionales.</span></label>
                                </div>
                                <div class="frb frb-primary">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Rie[]" id="radio_Rie3" value="Grandes posibilidades de exposicion a accidentes de trabajo o enfermedades profesionales" <?php if ($radioRiesgos === 'radio_Rie3') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Rie3"><span class="frb-title">Grandes posibilidades de exposición a accidentes de trabajo o enfermedades profesionales.</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comentarios">Comentarios u observaciones:</label>
                        <textarea class="form-control" id="comentarios" name="comentarios" rows="5"><?php echo $cargoDescripcion["comentarios_riesgo"]; ?></textarea>
                    </div>

                    <div class="d-flex justify-content-center mt-5">
                        <button id="btn-send" class="btn btn-success btn-lg" type="button" title="Next">Enviar</button>
                    </div>
                </article>


                <article id="tab7">
                    <div class="row mt-3">
                        <div class="col-xs-12 col-md-6  ">
                            <label for="competencias" style="font-weight: bold; color: #3c8dbc; cursor: pointer;" onclick="info_tabla('Competencias:','“Es una característica propia de un individuo que está directamente relacionada a un estándar de efectividad y/o a un desempeño superior en un trabajo o situación.{ Son comportamientos observables en la realidad cotidiana del trabajo y en situaciones de evaluación; son un rasgo de unión entre las características individuales y las cualidades requeridas para el desempeño en una empresa”. (Martha Alicia Alles, 2001).')"> Competencias: </label>
                            <small>Seleccione de 5 a 10 competencias principales, requeridas por el puesto/cargo</small>
                            <small>Antes de iniciar la selección de las competencias requeridas por el Puesto/Cargo, es necesario tomar en cuenta la Misión, Visión y Valores de la Organización.</small>
                            <div class=" col-6 mt-3 mb-3">
                                <label for="destrezas" class="mr-3" style="font-weight: bold; color: #3c8dbc; cursor: pointer;" onclick="info_tabla('Misión:','<?php echo $getEmpresa['mision']; ?>')"> Misión </label>
                                <label for="destrezas" class="mr-3" style="font-weight: bold; color: #3c8dbc; cursor: pointer;" onclick="info_tabla('Visión:','<?php echo $getEmpresa['vision']; ?>')"> Visión </label>
                                <label for="destrezas" style="font-weight: bold; color: #3c8dbc; cursor: pointer;" onclick="info_tabla('Valores:','<?php echo $getEmpresa['valores']; ?>')"> Valores </label>

                            </div>
                        </div>

                        <div class="col-xs-12 col-md-6">
                            <label for="destrezas" style="font-weight: bold; color: #3c8dbc; cursor: pointer;" onclick="info_tabla('Destrezas:','Capacidad aprendida que tiene una persona para realizar una actividad de manera ágil, rápida y eficiente, generalmente vinculada con el cuerpo u oficios manuales.')"> Destrezas: </label>
                            <small>
                                Mencione las principales destrezas necesarias para el correcto desempeño del puesto/cargo.</small>
                        </div>
                    </div>
                    <div class="row ">
                        <label>



                        </label>
                        <div class="col-xs-12 col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">1</span>
                                </div>
                                <select id="competencia1" name="competencia1" class="form-control">
                                    <?php
                                    $selectedDefault = "";
                                    if (empty($cargoDescripcion["competencia1"])) {
                                        $selectedDefault = "selected";
                                    }
                                    ?>
                                    <option disabled value="" <?php echo $selectedDefault; ?>>Seleccione</option>
                                    <?php

                                    if ($competencias) {
                                        foreach ($competencias as $country) {

                                            $countryName = $country['nombre'];
                                            $countryId = $country['id'];
                                            $des = $country['descripcion'];
                                            $selected = "";
                                            if (isset($cargoDescripcion["competencia1"]) && $countryId == $cargoDescripcion["competencia1"]) {
                                                $selected = "selected";
                                            }
                                            echo "<option value=\"$countryId\" data-max=\"$des\" data-nombre=\"$countryName\" $selected>$countryName</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">2</span>
                                </div>
                                <select id="competencia2" name="competencia2" class="form-control">
                                    <?php
                                    $selectedDefault = "";
                                    if (empty($cargoDescripcion["competencia2"])) {
                                        $selectedDefault = "selected";
                                    }
                                    ?>
                                    <option disabled value="" <?php echo $selectedDefault; ?>>Seleccione</option>
                                    <?php
                                    if ($competencias) {
                                        foreach ($competencias as $country) {
                                            $countryName = $country['nombre'];
                                            $countryId = $country['id'];
                                            $selected = "";
                                            $des = $country['descripcion'];
                                            if (isset($cargoDescripcion["competencia2"]) && $countryId == $cargoDescripcion["competencia2"]) {
                                                $selected = "selected";
                                            }
                                            echo "<option value=\"$countryId\" data-max=\"$des\" data-nombre=\"$countryName\" $selected>$countryName</option>";
                                        }
                                    }
                                    ?>
                                </select>


                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">3</span>
                                </div>
                                <select id="competencia3" name="competencia3" class="form-control">
                                    <?php
                                    $selectedDefault = "";
                                    if (empty($cargoDescripcion["competencia3"])) {
                                        $selectedDefault = "selected";
                                    }
                                    ?>
                                    <option disabled value="" <?php echo $selectedDefault; ?>>Seleccione</option>
                                    <?php

                                    if ($competencias) {
                                        foreach ($competencias as $country) {
                                            $countryName = $country['nombre'];
                                            $countryId = $country['id'];
                                            $selected = "";
                                            $des = $country['descripcion'];
                                            if (isset($cargoDescripcion["competencia3"]) && $countryId == $cargoDescripcion["competencia3"]) {
                                                $selected = "selected";
                                            }
                                            echo "<option value=\"$countryId\" data-max=\"$des\" data-nombre=\"$countryName\" $selected>$countryName</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">4</span>
                                </div>
                                <select id="competencia4" name="competencia4" class="form-control">
                                    <?php
                                    $selectedDefault = "";
                                    if (empty($cargoDescripcion["competencia4"])) {
                                        $selectedDefault = "selected";
                                    }
                                    ?>
                                    <option disabled value="" <?php echo $selectedDefault; ?>>Seleccione</option>
                                    <?php

                                    if ($competencias) {
                                        foreach ($competencias as $country) {
                                            $countryName = $country['nombre'];
                                            $countryId = $country['id'];
                                            $selected = "";
                                            $des = $country['descripcion'];
                                            if (isset($cargoDescripcion["competencia4"]) && $countryId == $cargoDescripcion["competencia4"]) {
                                                $selected = "selected";
                                            }
                                            echo "<option value=\"$countryId\" data-max=\"$des\" data-nombre=\"$countryName\" $selected>$countryName</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">5</span>
                                </div>
                                <select id="competencia5" name="competencia5" class="form-control">
                                    <?php
                                    $selectedDefault = "";
                                    if (empty($cargoDescripcion["competencia5"])) {
                                        $selectedDefault = "selected";
                                    }
                                    ?>
                                    <option disabled value="" <?php echo $selectedDefault; ?>>Seleccione</option>
                                    <?php

                                    if ($competencias) {
                                        foreach ($competencias as $country) {
                                            $countryName = $country['nombre'];
                                            $countryId = $country['id'];
                                            $selected = "";
                                            $des = $country['descripcion'];
                                            if (isset($cargoDescripcion["competencia5"]) && $countryId == $cargoDescripcion["competencia5"]) {
                                                $selected = "selected";
                                            }
                                            echo "<option value=\"$countryId\" data-max=\"$des\" data-nombre=\"$countryName\" $selected>$countryName</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div id="contenedor-inputs2">
                            </div>



                            <script>
                                var previousValues = {};
                                $(document).ready(function() {
                                    // Objeto para rastrear valores anteriores de los selects
                                    // Recorre los selects al cargar la página
                                    $("select[id^='competencia']").each(function() {
                                        var selectId = $(this).attr("id");
                                        var selectedValue = $(this).val();

                                        // Deshabilita la opción seleccionada en otros selects
                                        $("select[id^='competencia']").not(this).find("option[value='" + selectedValue + "']").prop("disabled", true);

                                        // Registra el valor actual del select
                                        previousValues[selectId] = selectedValue;
                                    });
                                    // Manejar cambios en cualquiera de los selects
                                    $(document).on("change", "select[id^='competencia']", function() {
                                        var selectId = $(this).attr("id");
                                        var selectedValue = $(this).val();

                                        // Habilitar la opción previamente seleccionada en otros selects
                                        if (previousValues[selectId]) {
                                            $("select[id^='competencia']").not(this).find("option[value='" + previousValues[selectId] + "']").prop("disabled", false);
                                        }

                                        // Deshabilitar la opción seleccionada en otros selects
                                        $("select[id^='competencia']").not(this).find("option[value='" + selectedValue + "']").prop("disabled", true);

                                        // Registrar el valor actual del select
                                        previousValues[selectId] = selectedValue;
                                    });
                                });
                            </script>

                            <script>
                                function addEventListeners() {
                                    for (let i = 1; i <= 10; i++) {

                                        document.getElementById("competencia" + i).addEventListener("change", function() {
                                            var selectedOption = this.options[this.selectedIndex];
                                            var des = selectedOption.dataset.max;
                                            var nombre = selectedOption.dataset.nombre;
                                            let tableHTML = `<p>${des}</p>`;

                                            Swal.fire({
                                                title: nombre,

                                                html: '<h5>Descripción:</h5>' + tableHTML,
                                                icon: 'information',
                                                confirmButtonText: 'Aceptar',
                                                confirmButtonColor: '#3085d6'
                                            });
                                        });
                                    }
                                }

                                function disableCompetencias(i) {
                                    var selectedOption = document.getElementById("competencia" + i).options[0]; // Cambia el índice según tu necesidad
                                    var selectedValue = selectedOption.value;
                                    for (var key in previousValues) {
                                        if (key !== "competencia" + i) {
                                            var value = previousValues[key];
                                            $("select[id^='competencia']").find("option[value='" + value + "']").prop("disabled", true);
                                        }
                                    }
                                    previousValues["competencia" + i] = selectedValue;
                                }



                                function addEventListeners2(i) {
                                    document.getElementById("competencia" + i).addEventListener("change", function() {
                                        var selectedOption = this.options[this.selectedIndex];
                                        var des = selectedOption.dataset.max;
                                        var nombre = selectedOption.dataset.nombre;
                                        let tableHTML = `<p>${des}</p>`;

                                        Swal.fire({
                                            title: nombre,
                                            html: '<h5>Descripción:</h5>' + tableHTML,
                                            icon: 'information',
                                            confirmButtonText: 'Aceptar',
                                            confirmButtonColor: '#3085d6'
                                        });

                                        var selectedValue = selectedOption.value;
                                        for (var key in previousValues) {
                                            if (key !== "competencia" + i) {
                                                var value = previousValues[key];
                                                $("select[id^='competencia']").find("option[value='" + value + "']").prop("disabled", true);

                                            }
                                        }

                                        // Registrar valor actual del select
                                        previousValues["competencia" + i] = selectedValue;
                                    });
                                }
                            </script>
                            <button id="agregamos" class="btn btn-primary btn-md" type="button" onclick="mostrarInputSiguientex()">+ Agregar Campo</button>
                            <button id="eliminar" class="btn btn-danger btn-md" type="button" onclick="eliminarUltimoInput()">- Cerrar campo</button>

                            <script>
                                var contenedorInputs = document.getElementById("contenedor-inputs2");

                                function mostrarInputSiguientex() {
                                    // Crear el siguiente input y su correspondiente etiqueta
                                    if (indexInputMostradoz <= 10) {
                                        var inputLabel = document.createElement("div");
                                        inputLabel.classList.add("input-group", "mb-3");
                                        inputLabel.id = "input-label-" + indexInputMostradoz;

                                        var inputLabelPrepend = document.createElement("div");
                                        inputLabelPrepend.classList.add("input-group-prepend");

                                        var inputLabelSpan = document.createElement("span");
                                        inputLabelSpan.classList.add("input-group-text");
                                        inputLabelSpan.innerHTML = indexInputMostradoz;

                                        inputLabelPrepend.appendChild(inputLabelSpan);
                                        inputLabel.appendChild(inputLabelPrepend);

                                        var select = document.createElement("select");
                                        select.id = "competencia" + indexInputMostradoz;
                                        select.name = "competencia" + indexInputMostradoz;
                                        select.classList.add("form-control");
                                        var option0 = document.createElement("option");
                                        option0.value = "";
                                        option0.text = "Seleccione";
                                        option0.disabled = true;
                                        option0.selected = true;
                                        select.appendChild(option0);




                                        // Agregar las opciones del array al select
                                        <?php foreach ($competencias as $country) { ?>
                                            var option = document.createElement("option");
                                            option.value = "<?php echo $country['id']; ?>";
                                            option.text = "<?php echo $country['nombre']; ?>";
                                            option.setAttribute("data-max", "<?php echo $country['descripcion']; ?>");
                                            option.setAttribute("data-nombre", "<?php echo $country['nombre']; ?>");
                                            var idx = "<?php echo $country['id']; ?>";

                                            switch (indexInputMostradoz) {
                                                case 6:
                                                    var valorcompetencia6 = "<?php echo !empty($cargoDescripcion['competencia6']) ? $cargoDescripcion['competencia6'] : ''; ?>";
                                                    if (idx === valorcompetencia6) {
                                                        option.selected = true;
                                                    }
                                                    break;
                                                case 7:
                                                    var valorcompetencia7 = "<?php echo !empty($cargoDescripcion['competencia7']) ? $cargoDescripcion['competencia7'] : ''; ?>";
                                                    if (idx === valorcompetencia7) {
                                                        option.selected = true;
                                                    }
                                                    break;
                                                case 8:
                                                    var valorcompetencia8 = "<?php echo !empty($cargoDescripcion['competencia8']) ? $cargoDescripcion['competencia8'] : ''; ?>";
                                                    if (idx === valorcompetencia8) {
                                                        option.selected = true;
                                                    }
                                                    break;
                                                case 9:
                                                    var valorcompetencia9 = "<?php echo !empty($cargoDescripcion['competencia9']) ? $cargoDescripcion['competencia9'] : ''; ?>";
                                                    if (idx === valorcompetencia9) {
                                                        option.selected = true;
                                                    }
                                                    break;
                                                case 10:
                                                    var valorcompetencia10 = "<?php echo !empty($cargoDescripcion['competencia10']) ? $cargoDescripcion['competencia10'] : ''; ?>";
                                                    if (idx === valorcompetencia10) {
                                                        option.selected = true;
                                                    }
                                                    break;
                                            }
                                            select.add(option);
                                        <?php } ?>

                                        inputLabel.appendChild(select);
                                        contenedorInputs.appendChild(inputLabel);
                                        disableCompetencias(indexInputMostradoz);
                                        select.focus();
                                        addEventListeners2(indexInputMostradoz);
                                        indexInputMostradoz++;

                                    }

                                    if (indexInputMostradoz > 6) {
                                        document.getElementById("eliminar").hidden = false;
                                    }

                                    // Desactivar el botón si se han mostrado todos los inputs
                                    if (indexInputMostradoz == 11) {
                                        document.getElementById("agregamos").disabled = true;
                                    }

                                }

                                function eliminarUltimoInput() {
                                    if (indexInputMostradoz > 1) {
                                        var ultimoInput = document.getElementById("input-label-" + (indexInputMostradoz - 1));
                                        if (ultimoInput.parentNode === contenedorInputs) {
                                            // Obtener el valor seleccionado del último select
                                            var selectId = "competencia" + (indexInputMostradoz - 1);
                                            var selectedValue = document.getElementById(selectId).value;

                                            contenedorInputs.removeChild(ultimoInput);
                                            indexInputMostradoz--;

                                            // Volver a habilitar la opción en los demás selects
                                            $("select[id^='competencia']").each(function() {
                                                var currentSelectId = $(this).attr("id");
                                                var optionToEnable = $(this).find("option[value='" + selectedValue + "']");
                                                if (currentSelectId !== selectId && optionToEnable.length > 0) {
                                                    optionToEnable.prop("disabled", false);
                                                }
                                            });

                                            document.getElementById("agregamos").disabled = false;
                                            if (indexInputMostradoz < 7) {
                                                document.getElementById("eliminar").hidden = true;
                                            }
                                        } else {
                                            console.log("The child node is not a child of the parent node.");
                                        }
                                    }
                                }
                            </script>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="destrezainstrumento"> Instrumento: </label>
                            <input type="text" value="<?php echo $cargoDescripcion["destrezainstrumento"]; ?>" id="destrezainstrumento" name="destrezainstrumento" class="form-control">
                            <label for="destrezaequipo"> Equipo: </label>
                            <input type="text" value="<?php echo $cargoDescripcion["destrezaequipo"]; ?>" id="destrezaequipo" name="destrezaequipo" class="form-control">
                            <label for="destrezasistema"> Sistema: </label>
                            <input type="text" value="<?php echo $cargoDescripcion["destrezasistema"]; ?>" id="destrezasistema" name="destrezasistema" class="form-control">
                            <label for="destrezacomputacion"> Computación: </label>
                            <input type="text" value="<?php echo $cargoDescripcion["destrezacomputacion"]; ?>" id="destrezacomputacion" name="destrezacomputacion" class="form-control">
                            <label for="destrezaotro"> Otro: </label>
                            <input type="text" value="<?php echo $cargoDescripcion["destrezaotro"]; ?>" id="destrezaotro" name="destrezaotro" class="form-control">

                        </div>
                    </div>


                </article>
                <script>
                    // Manejar el evento click del botón
                    document.getElementById('btn-send').addEventListener('click', function(e) {
                        // Prevenir la acción por defecto del botón
                        e.preventDefault();

                        var activdadError = false;
                        var activdadErrorMsj = "";

                        for (let i = 1; i <= 15; i++) {
                            const actividadElement = document.getElementById(`actividad${i}`);
                            if (actividadElement) {
                                const actividad = actividadElement.value;
                                if (actividad !== '') {
                                    const selectactividadElement = document.getElementById(`selectactividad${i}`);
                                    const selectactividad = selectactividadElement.value;

                                    if (selectactividad === '') {
                                        // Si alguno de los campos está vacío, muestra un mensaje de error.
                                        activdadErrorMsj = `El campo frecuencia en la actividad ${i} es obligatorio.`;
                                        activdadError = true;

                                    }

                                }
                            }
                        }

                        const organigrama = document.querySelectorAll('input[name="radio_Org[]"]:checked');
                        const presupuesto = document.querySelectorAll('input[name="radio_Ppto[]"]:checked');
                        const ingreso = document.querySelectorAll('input[name="radio_Ingr[]"]:checked');
                        const gasto = document.querySelectorAll('input[name="radio_Gasto[]"]:checked');
                        const experiencia = document.querySelectorAll('input[name="radio_Exp[]"]:checked');
                        const ambiente = document.querySelectorAll('input[name="radio_Amb[]"]:checked');
                        const instrumento = document.querySelectorAll('input[name="radio_Ins[]"]:checked');
                        const manipulacion = document.querySelectorAll('input[name="radio_Man[]"]:checked');
                        const traslado = document.querySelectorAll('input[name="radio_Tras[]"]:checked');
                        const funcion1 = document.getElementById('funcion1');
                        const actividad1 = document.getElementById('actividad1');
                        const empleados = document.getElementById('empleados');
                        const obreros = document.getElementById('obreros');
                        // Selecciona todos los checkboxes
                        const checkboxes = document.querySelectorAll('input[name^="check_Con"]');
                        // Crea una variable para almacenar si al menos un checkbox ha sido marcado
                        let alMenosUnoMarcado = false;

                        // Itera sobre los checkboxes y comprueba si alguno está marcado
                        for (let i = 0; i < checkboxes.length; i++) {
                            if (checkboxes[i].checked) {
                                alMenosUnoMarcado = true;
                                break; // Si uno está marcado, no necesitas seguir comprobando los demás
                            }
                        }

                        const adicional = document.getElementById('adicional');
                        const competencia1 = document.getElementById('competencia1');
                        const competencia2 = document.getElementById('competencia2');
                        const competencia3 = document.getElementById('competencia3');
                        const competencia4 = document.getElementById('competencia4');
                        const competencia5 = document.getElementById('competencia5');
                        const fecha_preparacion = document.getElementById('fecha_preparacion');
                        const revisado = document.getElementById('revisado');
                        const supervisor = document.getElementById('supervisor');





                        const proposito = document.getElementById('proposito');
                        const ambienteCheckboxes = document.querySelectorAll('input[name^="check_Amb"]:checked');
                        const instrumentoCheckboxes = document.querySelectorAll('input[name^="check_Ins"]:checked');
                        const manipularElementosTextarea = document.getElementById('manipular_elementos');
                        const maquinaCheckboxes = document.querySelectorAll('input[name^="check_Maq"]:checked');
                        const otrasMaquinasInput = document.getElementById('otras_maquinas');
                        const trasladoCheckboxes = document.querySelectorAll('input[name^="check_Tra"]:checked');
                        const frecuenciaTrasladoInput = document.getElementById('frecuencia_traslado');
                        const especialidadInput = document.getElementById('especialidad');
                        const adicionalInput = document.getElementById('adicional');
                        const relacionesInternasTextarea = document.getElementById('relacionesInternas');
                        const relacionesExternasTextarea = document.getElementById('relacionesExternas');
                        const radioRiesgos = document.querySelectorAll('input[name="radio_Rie[]"]:checked');
                        const comentariosTextarea = document.getElementById('comentarios');

                        const radioConocimiento = document.querySelectorAll('input[name="radio_Con[]"]:checked');

                        const radioExperiencia = document.querySelectorAll('input[name="radio_Exp[]"]:checked');

                        const destrezasInputs = document.querySelectorAll('input[id^="destreza"]:not([type="hidden"])');
                        let alMenosUnaDestrezaIngresada = false;

                        destrezasInputs.forEach(input => {
                            if (input.value.trim() !== '') {
                                alMenosUnaDestrezaIngresada = true;
                            }
                        });




                        if (proposito.value === '') {
                            showSweetAlert('Error', 'El campo breve descripción es obligatorio.', 'error');
                        } else if (funcion1.value === '') {
                            showSweetAlert('Error', 'Es obligatorio al menos ingresar una función.', 'error');
                        } else if (actividad1.value === '') {
                            showSweetAlert('Error', 'Es obligatorio al menos ingresar una acvtividad.', 'error');
                        } else if (activdadError) {
                            showSweetAlert('Error', activdadErrorMsj, 'error');
                        } else if (ambienteCheckboxes.length === 0) {
                            showSweetAlert('Error', 'Debes seleccionar al menos una opción de ambiente de trabajo.', 'error');
                        } else if (instrumentoCheckboxes.length === 0) {
                            showSweetAlert('Error', 'Debes seleccionar al menos una opción de instrumento.', 'error');
                        } else if (manipularElementosTextarea.value.trim() === '') {
                            showSweetAlert('Error', 'Debes ingresar información sobre la manipulación de elementos.', 'error');
                        } else if (maquinaCheckboxes.length === 0) {
                            showSweetAlert('Error', 'Debes seleccionar al menos una opción de maquinaria.', 'error');
                        } else if (trasladoCheckboxes.length === 0) {
                            showSweetAlert('Error', 'Debes seleccionar al menos una opción de traslado.', 'error');
                        } else if (frecuenciaTrasladoInput.value.trim() === '') {
                            showSweetAlert('Error', 'Debes ingresar la frecuencia de traslados.', 'error');
                        } else if (radioConocimiento.length === 0) {
                            showSweetAlert('Error', 'Debes seleccionar al menos una opción de nivel de conocimiento.', 'error');
                        } else if (radioExperiencia.length === 0) {
                            showSweetAlert('Error', 'Debes seleccionar al menos una opción de experiencia laboral.', 'error');
                        } else if (especialidadInput.value.trim() === '') {
                            showSweetAlert('Error', 'Debes especificar una especialidad o carrera.', 'error');
                        } else if (competencia1.value === '') {
                            showSweetAlert('Error', 'El campo competencia 1 es obligatorio.', 'error');
                        } else if (competencia2.value === '') {
                            showSweetAlert('Error', 'El campo competencia 2 es obligatorio.', 'error');
                        } else if (competencia3.value === '') {
                            showSweetAlert('Error', 'El campo competencia 3 es obligatorio.', 'error');
                        } else if (competencia4.value === '') {
                            showSweetAlert('Error', 'El campo competencia 4 es obligatorio.', 'error');
                        } else if (competencia5.value === '') {
                            showSweetAlert('Error', 'El campo competencia 5 es obligatorio.', 'error');
                        } else if (!alMenosUnaDestrezaIngresada) {
                            showSweetAlert('Error', 'Debes ingresar al menos una destreza.', 'error');
                        } else if (adicionalInput.value.trim() === '') {
                            showSweetAlert('Error', 'Debes ingresar requisitos adicionales al cargo.', 'error');
                        } else if (relacionesInternasTextarea.value.trim() === '') {
                            showSweetAlert('Error', 'Debes ingresar las relaciones internas del cargo.', 'error');
                        } else if (relacionesExternasTextarea.value.trim() === '') {
                            showSweetAlert('Error', 'Debes ingresar las relaciones externas del cargo.', 'error');
                        } else if (radioRiesgos.length === 0) {
                            showSweetAlert('Error', 'Debes seleccionar al menos una opción de riesgo laboral.', 'error');
                        } else if (comentariosTextarea.value.trim() === '') {
                            showSweetAlert('Error', 'Debes ingresar comentarios sobre los riesgos.', 'error');
                        } else {
                            // Si los campos son válidos, enviar el formulario
                            const form = document.getElementById("formulario");
                            $("select[id^='competencia'] option").prop("disabled", false);
                            form.submit();
                        }



                        function showSweetAlert(title, message, type) {
                            Swal.fire({
                                title: title,
                                text: message,
                                icon: type,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Aceptar'
                            });
                        }

                    });
                </script>
            </form>
        </div>
    </div>


    <?php include_once('../layouts/footer.php'); ?>
    <script src="assets/js/usuarios.js"></script>