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
    $radioPesupuesto = "";
    $sweetAlertCode = "";
    $cargoDescripcion = "";
    $departamentos = $crud->get_departamentos(1);
    $relacionesExternasx = $crud->get_relaciones_externas();
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
        if (isset($_GET['empresa'])) {
            $empresa = $_GET['empresa'];
        }
        // Realiza las acciones necesarias con el ID
        $cargoDescripcion = $crud->get_cargo_descripcion_admin($id);
        $cargoDescripcion = $cargoDescripcion[0];
        $radioSeleccionado = '';


        switch ($cargoDescripcion["organigrama"]) {
            case '1er Nivel: Dirección (Presidencia / VP / Gerencia General)':
                $radioOrganigrama = 'radio_Org1';
                break;
            case '2do Nivel: Gerencia':
                $radioOrganigrama = 'radio_Org2';
                break;
            case '3er Nivel: Jefetura/Departamentos':
                $radioOrganigrama = 'radio_Org3';
                break;
            case '4to Nivel: Unidades Secciones':
                $radioOrganigrama = 'radio_Org4';
                break;
            case '5to Nivel: Personal Administrativo Operativo':
                $radioOrganigrama = 'radio_Org5';
                break;
            default:
                $radioOrganigrama = '';
                break;
        }

        $cargoDescripcion['otroambiente'] = "";
        switch ($cargoDescripcion["ambiente"]) {
            case 'Oficina':
                $radioAmbanigrama = 'radio_Amb1';
                break;
            case 'Taller':
                $radioAmbanigrama = 'radio_Amb2';
                break;
            case 'Al aire libre':
                $radioAmbanigrama = 'radio_Amb3';
                break;
            case 'Movil':
                $radioAmbanigrama = 'radio_Amb4';
                break;
            case 'Ninguno':
                $radioAmbanigrama = 'radio_Amb5';
                break;
            default:
                $radioAmbanigrama = 'radio_Amb6';
                $cargoDescripcion['otroambiente'] = $cargoDescripcion["ambiente"];
                break;
        }

        $cargoDescripcion['otroinstrumento'] = "";
        switch ($cargoDescripcion["instrumento"]) {
            case 'Computador':
                $radioInsanigrama = 'radio_Ins1';
                break;
            case 'Herramientas':
                $radioInsanigrama = 'radio_Ins2';
                break;
            case 'Vehiculo':
                $radioInsanigrama = 'radio_Ins3';
                break;
            case 'Ninguno':
                $radioInsanigrama = 'radio_Ins4';
                break;
            default:
                $radioInsanigrama = 'radio_Ins5';
                $cargoDescripcion['otroinstrumento'] = $cargoDescripcion["instrumento"];
                break;
        }



        $cargoDescripcion['otromanipulacion'] = "";
        switch ($cargoDescripcion["manipulacion"]) {
            case 'Quimicos':
                $radioMananigrama = 'radio_Man1';
                break;
            case 'Biologicos':
                $radioMananigrama = 'radio_Man2';
                break;
            case 'Inflamable':
                $radioMananigrama = 'radio_Man3';
                break;
            case 'Ninguno':
                $radioMananigrama = 'radio_Man4';
                break;
            default:
                $radioMananigrama = 'radio_Man5';
                $cargoDescripcion['otromanipulacion'] = $cargoDescripcion["manipulacion"];
                break;
        }


        $cargoDescripcion['otrotraslado'] = "";
        switch ($cargoDescripcion["traslado"]) {
            case 'Areos':
                $radioTrasanigrama = 'radio_Tras1';
                break;
            case 'Terrestres':
                $radioTrasanigrama = 'radio_Tras2';
                break;
            case 'Maritimo':
                $radioTrasanigrama = 'radio_Tras3';
                break;
            case 'Ninguno':
                $radioTrasanigrama = 'radio_Tras4';
                break;
            default:
                $radioTrasanigrama = 'radio_Tras5';
                $cargoDescripcion['otrotraslado'] = $cargoDescripcion["traslado"];
                break;
        }







        switch ($cargoDescripcion["ingreso"]) {
            case 'Directa':
                $radioIngreso = 'radio_Ingr1';
                break;
            case 'Parcial':

                $radioIngreso = 'radio_Ingr2';
                break;
            case 'Seguimiento y Control':
                $radioIngreso = 'radio_Ingr3';
                break;
            case 'No tiene impacto significativo':
                $radioIngreso = 'radio_Ingr4';
                break;
            default:
                // Valor no reconocido o valor vacío, seleccionar el radio por defecto o manejar el caso según tu lógica
                $radioIngreso = ''; // Aquí puedes asignar el radio por defecto si lo deseas
                break;
        }
        switch ($cargoDescripcion["presupuesto"]) {
            case 'Directa':
                $radioPesupuesto = 'radio_Ppto1';
                break;
            case 'Parcial':
                $radioPesupuesto = 'radio_Ppto2';
                break;
            case 'Seguimiento y Control':
                $radioPesupuesto = 'radio_Ppto3';
                break;
            case 'No tiene impacto significativo':
                $radioPesupuesto = 'radio_Ppto4';
                break;
            default:
                // Valor no reconocido o valor vacío, seleccionar el radio por defecto o manejar el caso según tu lógica
                $radiopPesupuesto = ''; // Aquí puedes asignar el radio por defecto si lo deseas
                break;
        }
        switch ($cargoDescripcion["gasto"]) {
            case 'Directa':
                $radioGasto = 'radio_Gasto1';
                break;
            case 'Parcial':
                $radioGasto = 'radio_Gasto2';
                break;
            case 'Seguimiento y Control':
                $radioGasto = 'radio_Gasto3';
                break;
            case 'No tiene impacto significativo':
                $radioGasto = 'radio_Gasto4';
                break;
            default:
                // Valor no reconocido o valor vacío, seleccionar el radio por defecto o manejar el caso según tu lógica
                $radioGasto = ''; // Aquí puedes asignar el radio por defecto si lo deseas
                break;
        }
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
            case 'Post Grado / Diplomado':
                $radioConocimiento = 'radio_Con5';
                break;
            case 'Maestria':
                $radioConocimiento = 'radio_Con6';
                break;
            case 'Doctarado / PHD':
                $radioConocimiento = 'radio_Con7';
                break;
            default:
                $radioConocimiento = ''; // Assign default radio button if desired or handle the case based on your logic
                break;
        }

        switch ($cargoDescripcion["experiencia"]) {
            case 'Menos de un (1) año':
                $radioExperiencia = 'radio_Exp1';
                break;
            case 'De un (1) a cinco (5) años':
                $radioExperiencia = 'radio_Exp2';
                break;
            case 'De cinco (5) a diez (10) años':
                $radioExperiencia = 'radio_Exp3';
                break;
            case 'De diez (10) a quince (15) años':
                $radioExperiencia = 'radio_Exp4';
                break;
            case 'Más de quince (15) años':
                $radioExperiencia = 'radio_Exp5';
                break;
            default:
                $radioExperiencia = ''; // Asigna un valor por defecto o maneja el caso según tu lógica
                break;
        }

        switch ($cargoDescripcion["ambiental"]) {
            case 'Condiciones normales de oficina':
                $radioAmbientales = 'radio_Ambz1';
                break;
            case 'Condiciones normales de un ambiente externo (Calle, Trafico, Ruido, etc.)':
                $radioAmbientales = 'radio_Ambz2';
                break;
            case 'Condiciones tipicas de un ambiente de Planta / Fabrica / Taller':
                $radioAmbientales = 'radio_Ambz3';
                break;
            default:
                $radioAmbientales = ''; // Assign default radio button if desired or handle the case based on your logic
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

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="card text-left">
            <div class="card-header">


                <span style="font-weight: bold; font-size: 25px">Descripción de Puesto/Cargo (Administrativo)</span>
                <br>
                <span style="font-size: 18px">Departamento: <?php echo $departamento; ?></span>
                <br>
                <span style="font-size: 18px">Cargo: <?php echo $nombre; ?></span>
            </div>
        </div>
    </section>
    <!-- Content Header (Page header) -->



    <?php echo isset($sweetAlertCode) ? $sweetAlertCode : ''; ?>

    <ul class="tabs">
        <li><a href="#tab1"><span class="fa fa-home"></span><span class="tab-text">Indentificación / Ubicación</span></a></li>
        <li><a href="#tab2"><span class="fa fa-group"></span><span class="tab-text">Descripción</span></a></li>
        <li><a href="#tab3"><span class="fa fa-briefcase"></span><span class="tab-text">Responsabilidades</span></a></li>
        <li><a href="#tab4"><span class="fa fa-bookmark"></span><span class="tab-text">Conocimientos</span></a></li>
        <li><a href="#tab5"><span class="fa fa-arrows-h"></span><span class="tab-text">Competencias</span></a></li>
        <li><a href="#tab6"><span class="fa fa-superpowers"></span><span class="tab-text">Relaciones</span></a></li>
        <li><a href="#tab7"><span class="fa fa-window-restore "></span><span class="tab-text">Condiciones de trabajo</span></a></li>
        <li><a href="#tab8"><span class="fa fa-exclamation-circle"></span><span class="tab-text">Riesgos</span></a></li>
    </ul>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="assets/js/descripcion-cargo.js"></script>
    <div class="container" style=" max-height: 1000px;">
        <div class="secciones">
            <form action="savedescripcion.php" id="formulario" method="POST" onkeydown="return event.key != 'Enter';">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <article id="tab1">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 mt-3 mt-md-0">
                            <div class="form-group">
                                <label for="cargo">Denominación del puesto/cargo:</label>
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

                    <div class="col-xs-12 mt-3">

                        <label for="organigrama">Ubique el puesto/cargo en su nivel organizativo:</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="radio_Org[]" id="radio_Org1" value="1er Nivel: Dirección (Presidencia / VP / Gerencia General)" <?php if ($radioOrganigrama === 'radio_Org1') echo 'checked'; ?>>
                            <label class="form-check-label" for="radio_Org1">1er Nivel: Dirección (Presidencia / VP / Gerencia General)</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="radio_Org[]" id="radio_Org2" value="2do Nivel: Gerencia" <?php if ($radioOrganigrama === 'radio_Org2') echo 'checked'; ?>>
                            <label class="form-check-label" for="radio_Org2">2do Nivel: Gerencia</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="radio_Org[]" id="radio_Org3" value="3er Nivel: Jefetura/Departamentos" <?php if ($radioOrganigrama === 'radio_Org3') echo 'checked'; ?>>
                            <label class="form-check-label" for="radio_Org3">3er Nivel: Jefetura/Departamentos</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="radio_Org[]" id="radio_Org4" value="4to Nivel: Unidades Secciones" <?php if ($radioOrganigrama === 'radio_Org4') echo 'checked'; ?>>
                            <label class="form-check-label" for="radio_Org4">4to Nivel: Unidades Secciones</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="radio_Org[]" id="radio_Org5" value="5to Nivel: Personal Administrativo Operativo" <?php if ($radioOrganigrama === 'radio_Org5') echo 'checked'; ?>>
                            <label class="form-check-label" for="radio_Org5">5to Nivel: Personal Administrativo Operativo</label>
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
                        <button id="eliminar2" class="btn btn-danger btn-md" type="button" onclick="eliminarUltimoTextarea()">- Eliminar Campo</button>
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
                        <button id="eliminar-actividad" class="btn btn-danger btn-md" type="button" onclick="eliminarUltimaActividad()">- Eliminar Campo</button>
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
                        <div class="col-xs-12">
                            <p>
                                <label for="selectResponsabilidad">Seleccione en qué magnitud posee responsabilidad sobre:<span class=""> *</span></label>
                            </p>
                            <p>
                                <label for="selectPresupuesto">Presupuesto: </label>
                            </p>
                            <div class="form-check">

                                <div class="form-check-inline">
                                    <input class="form-check-input ml-4" type="radio" name="radio_Ppto[]" id="radio_Ppto1" value="Directa" <?php if ($radioPesupuesto === 'radio_Ppto1') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Ppto1">Directa</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input ml-4" type="radio" name="radio_Ppto[]" id="radio_Ppto2" value="Parcial" <?php if ($radioPesupuesto === 'radio_Ppto2') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Ppto2">Parcial</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input ml-4" type="radio" name="radio_Ppto[]" id="radio_Ppto3" value="Seguimiento y Control" <?php if ($radioPesupuesto === 'radio_Ppto3') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Ppto3">Seguimiento y Control</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input ml-4" type="radio" name="radio_Ppto[]" id="radio_Ppto4" value="No tiene impacto significativo" <?php if ($radioPesupuesto === 'radio_Ppto4') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Ppto4">No tiene impacto significativo</label>
                                </div>
                            </div>
                        </div>
                        <!--B.- INGRESOS ECONÓMICO/FINANCIERO: -->
                        <div class="col-xs-12">
                            <p>
                                <label for="selectIngresos">Ingresos económico/financiero </label>
                            </p>
                            <div class="form-check">

                                <div class="form-check-inline">
                                    <input class="form-check-input ml-4" type="radio" name="radio_Ingr[]" id="radio_Ingr1" value="Directa" <?php if ($radioIngreso === 'radio_Ingr1') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Ingr1">Directa</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input ml-4" type="radio" name="radio_Ingr[]" id="radio_Ingr2" value="Parcial" <?php if ($radioIngreso === 'radio_Ingr2') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Ingr2">Parcial</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input ml-4" type="radio" name="radio_Ingr[]" id="radio_Ingr3" value="Seguimiento y Control" <?php if ($radioIngreso === 'radio_Ingr3') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Ingr3">Seguimiento y Control</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input ml-4" type="radio" name="radio_Ingr[]" id="radio_Ingr4" value="No tiene impacto significativo" <?php if ($radioIngreso === 'radio_Ingr4') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Ingr4">No tiene impacto significativo</label>
                                </div>
                            </div>
                        </div>

                        <!--C.- GASTOS OPERATIVOS DE LA UNIDAD/GERENCIA: -->
                        <div class="col-xs-12">
                            <p>
                                <label for="selectGastos"> Costos/Gastos operativos de la unidad/gerencia </label>
                            </p>
                            <div class="form-check">

                                <div class="form-check-inline">
                                    <input class="form-check-input ml-4" type="radio" name="radio_Gasto[]" id="radio_Gasto1" value="Directa" <?php if ($radioGasto === 'radio_Gasto1') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Gasto1">Directa</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input ml-4" type="radio" name="radio_Gasto[]" id="radio_Gasto2" value="Parcial" <?php if ($radioGasto === 'radio_Gasto2') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Gasto2">Parcial</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input ml-4" type="radio" name="radio_Gasto[]" id="radio_Gasto3" value="Seguimiento y Control" <?php if ($radioGasto === 'radio_Gasto3') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Gasto3">Seguimiento y Control</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input ml-4" type="radio" name="radio_Gasto[]" id="radio_Gasto4" value="No tiene impacto significativo" <?php if ($radioGasto === 'radio_Gasto4') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Gasto4">No tiene impacto significativo</label>
                                </div>
                            </div>
                            <div class="error" id="gastosErr"></div>
                        </div>

                        <div class="col-12 mt-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="empleados">Nómina mensual (Empleados):</label>
                                        <input type="text" class="form-control input-sm" name="empleados" id="empleados" title="Total Empleados" value="<?php echo $cargoDescripcion["empleados"]; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 4); updateTotal();">
                                    </div>
                                    <div class="col-4">
                                        <label for="obreros">Nómina diaria (Obreros):</label>
                                        <input type="text" class="form-control input-sm" name="obreros" id="obreros" title="Total Obreros" value="<?php echo $cargoDescripcion["obreros"]; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 4); updateTotal();">

                                    </div>
                                    <div class="col-4">
                                        <label for="totalTrab">Total trabajadores:</label>
                                        <input type="text" class="form-control input-sm" name="totalTrab" id="totalTrab" title="Total Trabajadores." readonly />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </article>
                <article id="tab4">
                    <label>
                        <h4>Conocimientos</h4>
                    </label>
                    <div class="row">
                        <div class="col-xs-12 col-md-6 mt-3 mt-md-0">
                            <div class="row">
                                <div class="col-xs-12 col-md-6 mt-3 mt-md-0">
                                    <label for="educacionFormal">Educación Formal</label>
                                </div>
                                <div class="col-xs-12 col-md-6 mt-3 mt-md-0">
                                    <label for="educacionFormal">Carrera/Especialidad</label>
                                </div>
                            </div>

                            <div class="form-check ">
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" name="check_Con[1]" id="check_Con1" value="1" <?php if ($cargoDescripcion["conocimiento1"] == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?>>
                                                </div>
                                            </div>
                                            <label class="form-check-label ml-2" for="check_Con1">Bachiller</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="conocimiento1texto" id="conocimiento1texto" placeholder="Especificar" maxlength="255" value="<?php echo $cargoDescripcion["conocimiento1texto"]; ?>" <?php if ($cargoDescripcion["conocimiento1"] != 1) {
                                                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                                                            } ?>>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" name="check_Con[2]" id="check_Con2" value="1" <?php if ($cargoDescripcion["conocimiento2"] == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?>>
                                                </div>
                                            </div>
                                            <label class="form-check-label ml-2" for="check_Con2">Técnico Medio</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="conocimiento2texto" id="conocimiento2texto" placeholder="Especificar" maxlength="255" value="<?php echo $cargoDescripcion["conocimiento2texto"]; ?>" <?php if ($cargoDescripcion["conocimiento2"] != 1) {
                                                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                                                            } ?>>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" name="check_Con[3]" id="check_Con3" value="1" <?php if ($cargoDescripcion["conocimiento3"] == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?>>
                                                </div>
                                            </div>

                                            <label class="form-check-label ml-2" for="check_Con3">Técnico Superior</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="conocimiento3texto" id="conocimiento3texto" placeholder="Especificar" maxlength="255" value="<?php echo $cargoDescripcion["conocimiento3texto"]; ?>" <?php if ($cargoDescripcion["conocimiento3"] != 1) {
                                                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                                                            } ?>>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" name="check_Con[4]" id="check_Con4" value="1" <?php if ($cargoDescripcion["conocimiento4"] == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?>>
                                                </div>
                                            </div>
                                            <label class="form-check-label ml-2" for="check_Con4">Graduado Universitario</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="conocimiento4texto" id="conocimiento4texto" placeholder="Especificar" maxlength="255" value="<?php echo $cargoDescripcion["conocimiento4texto"]; ?>" <?php if ($cargoDescripcion["conocimiento4"] != 1) {
                                                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                                                            } ?>>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" name="check_Con[5]" id="check_Con5" value="1" <?php if ($cargoDescripcion["conocimiento5"] == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?>>
                                                </div>
                                            </div>
                                            <label class="form-check-label ml-2" for="check_Con5">Post Grado / Diplomado</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="conocimiento5texto" id="conocimiento5texto" placeholder="Especificar" maxlength="255" value="<?php echo $cargoDescripcion["conocimiento5texto"]; ?>" <?php if ($cargoDescripcion["conocimiento5"] != 1) {
                                                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                                                            } ?>>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" name="check_Con[6]" id="check_Con6" value="1" <?php if ($cargoDescripcion["conocimiento6"] == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?>>
                                                </div>
                                            </div>
                                            <label class="form-check-label ml-2" for="check_Con6">Maestría</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="conocimiento6texto" id="conocimiento6texto" placeholder="Especificar" maxlength="255" value="<?php echo $cargoDescripcion["conocimiento6texto"]; ?>" <?php if ($cargoDescripcion["conocimiento6"] != 1) {
                                                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                                                            } ?>>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" name="check_Con[7]" id="check_Con7" value="1" <?php if ($cargoDescripcion["conocimiento7"] == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?>>
                                                </div>
                                            </div>
                                            <label class="form-check-label ml-2" for="check_Con7">Doctarado / PHD</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="conocimiento7texto" id="conocimiento7texto" placeholder="Especificar" maxlength="255" value="<?php echo $cargoDescripcion["conocimiento7texto"]; ?>" <?php if ($cargoDescripcion["conocimiento7"] != 1) {
                                                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                                                            } ?>>
                                    </div>
                                </div>
                                <script>
                                    // Get all the checkbox elements by ID
                                    const check_Con1 = document.getElementById('check_Con1');
                                    const check_Con2 = document.getElementById('check_Con2');
                                    const check_Con3 = document.getElementById('check_Con3');
                                    const check_Con4 = document.getElementById('check_Con4');
                                    const check_Con5 = document.getElementById('check_Con5');
                                    const check_Con6 = document.getElementById('check_Con6');
                                    const check_Con7 = document.getElementById('check_Con7');

                                    // Get all the input text elements by ID
                                    const conocimiento1texto = document.getElementById('conocimiento1texto');
                                    const conocimiento2texto = document.getElementById('conocimiento2texto');
                                    const conocimiento3texto = document.getElementById('conocimiento3texto');
                                    const conocimiento4texto = document.getElementById('conocimiento4texto');
                                    const conocimiento5texto = document.getElementById('conocimiento5texto');
                                    const conocimiento6texto = document.getElementById('conocimiento6texto');
                                    const conocimiento7texto = document.getElementById('conocimiento7texto');

                                    // Add an event listener to each checkbox
                                    check_Con1.addEventListener('change', function() {
                                        if (this.checked) {
                                            conocimiento1texto.removeAttribute('disabled');
                                        } else {
                                            conocimiento1texto.setAttribute('disabled', true);
                                        }
                                    });

                                    check_Con2.addEventListener('change', function() {
                                        if (this.checked) {
                                            conocimiento2texto.removeAttribute('disabled');
                                        } else {
                                            conocimiento2texto.setAttribute('disabled', true);
                                        }
                                    });

                                    check_Con3.addEventListener('change', function() {
                                        if (this.checked) {
                                            conocimiento3texto.removeAttribute('disabled');
                                        } else {
                                            conocimiento3texto.setAttribute('disabled', true);
                                        }
                                    });

                                    check_Con4.addEventListener('change', function() {
                                        if (this.checked) {
                                            conocimiento4texto.removeAttribute('disabled');
                                        } else {
                                            conocimiento4texto.setAttribute('disabled', true);
                                        }
                                    });

                                    check_Con5.addEventListener('change', function() {
                                        if (this.checked) {
                                            conocimiento5texto.removeAttribute('disabled');
                                        } else {
                                            conocimiento5texto.setAttribute('disabled', true);
                                        }
                                    });

                                    check_Con6.addEventListener('change', function() {
                                        if (this.checked) {
                                            conocimiento6texto.removeAttribute('disabled');
                                        } else {
                                            conocimiento6texto.setAttribute('disabled', true);
                                        }
                                    });

                                    check_Con7.addEventListener('change', function() {
                                        if (this.checked) {
                                            conocimiento7texto.removeAttribute('disabled');
                                        } else {
                                            conocimiento7texto.setAttribute('disabled', true);
                                        }
                                    });
                                </script>
                            </div>

                        </div>

                        <div class="col-xs-12 ml-5 col-md-5">
                            <label for="experiencia">Experiencia:</label>
                            <small></small>
                            <div class="form-check">
                                <div class="form-check">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Exp[]" id="radio_Exp1" value="Menos de un (1) año" <?php if ($radioExperiencia === 'radio_Exp1') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Exp1">Menos de un (1) año</label>
                                    <br />
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Exp[]" id="radio_Exp2" value="De un (1) a cinco (5) años" <?php if ($radioExperiencia === 'radio_Exp2') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Exp2">De un (1) a cinco (5) años</label>
                                    <br />
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Exp[]" id="radio_Exp3" value="De cinco (5) a diez (10) años" <?php if ($radioExperiencia === 'radio_Exp3') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Exp3">De cinco (5) a diez (10) años</label>
                                    <br />
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Exp[]" id="radio_Exp4" value="De diez (10) a quince (15) años" <?php if ($radioExperiencia === 'radio_Exp4') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Exp4">De diez (10) a quince (15) años</label>
                                    <br />
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Exp[]" id="radio_Exp5" value="Más de quince (15) años" <?php if ($radioExperiencia === 'radio_Exp5') echo ' checked'; ?>>
                                    <label class="form-check-label" for="radio_Exp5">Más de quince (15) años</label>
                                    <br />
                                </div>
                            </div>
                            </br>
                            <label for="experiencia">¿Otro idioma?:</label>
                            <small></small>
                            <select class="form-select" name="idiomas[]" id="idiomas" multiple>
                                <option disabled value="">Seleccione</option>
                                <?php
                                $opciones = array("Español", "Ingles", "Francés", "Alemán", "Mandarin", "Portugues", "Ruso", "Persa");
                                $idiomasArray = array_map('trim', explode(",", $cargoDescripcion["idiomas"]));

                                foreach ($opciones as $opcion) {
                                    $selected = "";
                                    if (in_array($opcion, $idiomasArray)) {
                                        $selected = "selected";
                                    }
                                    echo '<option value="' . $opcion . '" ' . $selected . '>' . $opcion . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                    </div>
                    <div class="row mt-3">

                        <div class="col-xs-12 col-md-12 mt-2">
                            <div class="form-group">
                                <label for="txtespAdicional"> Conocimientos adicionales que se pueden requerir en el cargo:</label>
                                <input type="text" class="form-control input-sm" name="adicional" id="adicional" placeholder="" title="Requisitos adicionales al cargo." maxlength="255" value="<?php echo $cargoDescripcion["especialidad_adicional"]; ?>">
                            </div>
                        </div>
                    </div>

                </article>

                <article id="tab6">
                    <div class="row mt-3">
                        <label>
                            <h4>Relaciones</h4>
                        </label>
                        <div class="col-xs-12 col-md-6 mt-3 mt-md-0">
                            <label for="relacionesInternas">Relaciones internas: </label>
                            <small>
                                Con qué otras unidades/departamentos de la organización mantiene relaciones frecuentes para el logro de los resultados de su puesto/cargo. Cliente Interno.
                            </small>
                            <select class="form-select" name="relacionesInternas[]" id="relacionesInternas" multiple>
                                <option disabled value="">Seleccione</option>
                                <?php
                                foreach ($departamentos as $departamento) {
                                    $selected = "";
                                    $relacionesInternasArray = explode(",", $cargoDescripcion["relacion_interna"]);
                                    if (in_array($departamento["id"], $relacionesInternasArray)) {
                                        $selected = "selected";
                                    }
                                    echo '<option value="' . $departamento["id"] . '" ' . $selected . '>' . $departamento["nombre"] . '</option>';
                                }
                                ?>
                            </select>


                        </div>
                        <div class="col-xs-12 col-md-6 mt-3 mt-md-0">
                            <label for="relacionesExternas">Relaciones externas: </label>
                            <small>
                                Con qué instituciones, organismos, empresas y personas externas a la organización debe mantener relaciones frecuentes para el logro de los resultados en su puesto/cargo. Cliente Externo
                            </small>

                            <select class="form-select" name="relacionesExternas[]" id="relacionesExternas" multiple>
                                <option disabled selected value="">Seleccione</option>
                                <?php
                                foreach ($relacionesExternasx as $departamento) {
                                    $selected = "";
                                    $relacionesExternasArray = explode(",", $cargoDescripcion["relacion_externa"]);
                                    if (in_array($departamento["id"], $relacionesExternasArray)) {
                                        $selected = "selected";
                                    }
                                    echo '<option value="' . $departamento["id"] . '" ' . $selected . '>' . $departamento["nombre"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </article>

                <article id="tab7">
                    <div class="row mt-3">
                        <label>
                            <h4>Condiciones de trabajo</h4>
                        </label>
                        <div class="col-xs-12 col-md-6">
                            <label for="condicionesAmbientales">Ambientales:</label>

                            <div class="form-check">
                                <div class="form-check">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Ambz[]" id="radio_Ambz1" value="Condiciones normales de oficina" <?php if ($radioAmbientales === 'radio_Ambz1') echo ' checked'; ?>> Condiciones normales de oficina.
                                    <br />
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Ambz[]" id="radio_Ambz2" value="Condiciones normales de un ambiente externo (Calle, Trafico, Ruido, etc.)" <?php if ($radioAmbientales === 'radio_Ambz2') echo ' checked'; ?>> Condiciones normales de un ambiente externo (Calle, Tráfico, Ruido, etc.).
                                    <br />
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input radio-inline" type="radio" name="radio_Ambz[]" id="radio_Ambz3" value="Condiciones tipicas de un ambiente de Planta / Fabrica / Taller" <?php if ($radioAmbientales === 'radio_Ambz3') echo ' checked'; ?>> Condiciones típicas de un ambiente de Planta / Fábrica / Taller.
                                    <br />
                                </div>
                                <div class="error" id="expertoErr"></div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="riesgos">Riesgos:</label>

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

                <article id="tab5">
                    <div class="row mt-3">
                        <label>

                            <h4 style="color: #3c8dbc;" onclick="info_tabla('Matriz de Nómina:','Texto preguntar Sr.Luis')">Competencias</h4>
                            <small>Seleccione de 5 a 10 competencias principales, requeridas por el puesto/cargo</small>
                        </label>
                        <div class="col-xs-12 col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">1</span>
                                </div>
                                <select id="competencia1" name="competencia1" class="form-control">
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

                                function addEventListeners2(i) {
                                    document.getElementById("competencia" + i).addEventListener("change", function() {
                                        var selectedOption = this.options[this.selectedIndex];
                                        var des = selectedOption.dataset.max;
                                        var nombre = selectedOption.dataset.nombre;
                                        let tableHTML = `<h1>${des}</h1>`;

                                        Swal.fire({
                                            title: nombre,

                                            html: '<h5>Descripción:</h5>' + tableHTML,
                                            icon: 'information',
                                            confirmButtonText: 'Aceptar',
                                            confirmButtonColor: '#3085d6'
                                        });
                                    });
                                }
                            </script>
                            <button id="agregamos" class="btn btn-primary btn-md" type="button" onclick="mostrarInputSiguientex()">+ Agregar Campo</button>
                            <button id="eliminar" class="btn btn-danger btn-md" type="button" onclick="eliminarUltimoInput()">- Eliminar Campo</button>
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
                                            contenedorInputs.removeChild(ultimoInput);
                                            indexInputMostradoz--;
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
                        <div class="col-xs-12 col-md-6 mt-3 mt-md-0">
                            <label for="destrezas"> Destrezas: </label>
                            <small>
                                Mencione las principales destrezas necesarias para el correcto desempeño del puesto/cargo, entendiéndose por estas, el grado de pericia en el manejo u operación de:
                                instrumentos, equipos, sistemas, computación:
                            </small>
                            <br><br />
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
                <article id="tab8">
                    <label>
                        <h4>Riesgos</h4>
                    </label>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="organigrama">Especificar ambiente de trabajo</label>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Amb[]" id="radio_Amb1" value="Oficina" <?php if ($radioAmbanigrama === 'radio_Amb1') echo 'checked'; ?> onclick="desbloquearCampo()">
                                <label class="form-check-label" for="radio_Amb1">Oficina</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Amb[]" id="radio_Amb2" value="Taller" <?php if ($radioAmbanigrama === 'radio_Amb2') echo 'checked'; ?> onclick="desbloquearCampo()">
                                <label class="form-check-label" for="radio_Amb2">Taller</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Amb[]" id="radio_Amb3" value="Al aire libre" <?php if ($radioAmbanigrama === 'radio_Amb3') echo 'checked'; ?> onclick="desbloquearCampo()">
                                <label class="form-check-label" for="radio_Amb3">Al aire libre</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Amb[]" id="radio_Amb4" value="Movil (motorizados o choferes)" <?php if ($radioAmbanigrama === 'radio_Amb4') echo 'checked'; ?> onclick="desbloquearCampo()">
                                <label class="form-check-label" for="radio_Amb4">Movil (motorizados o choferes)</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Amb[]" id="radio_Amb5" value="Ninguno" <?php if ($radioAmbanigrama === 'radio_Amb5') echo 'checked'; ?> onclick="desbloquearCampo()">
                                <label class="form-check-label" for="radio_Amb5">Ninguno</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Amb[]" id="radio_Amb6" value="Otro" <?php if ($radioAmbanigrama === 'radio_Amb6') echo 'checked'; ?> onclick="desbloquearCampo()">
                                <label class="form-check-label" for="radio_Amb6">Otro</label>
                                <input type="text" value="<?php echo $cargoDescripcion["otroambiente"]; ?>" id="otroambiente" name="otroambiente" class="form-control" disabled>
                            </div>

                            <script>
                                function desbloquearCampo() {
                                    var radioAmb6 = document.getElementById("radio_Amb6");
                                    var otroAmbiente = document.getElementById("otroambiente");
                                    if (radioAmb6.checked) {
                                        otroAmbiente.disabled = false;
                                    } else {
                                        otroAmbiente.disabled = true;
                                    }
                                }
                            </script>
                        </div>
                        <div class="col-md-6">
                            <label for="organigrama">Instrumento que utiliza para realizar su trabajo</label>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Ins[]" id="radio_Ins1" value="Computador" <?php if ($radioInsanigrama === 'radio_Ins1') echo 'checked'; ?> onclick="desbloquearCampo2()">
                                <label class="form-check-label" for="radio_Ins1">Computador</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Ins[]" id="radio_Ins2" value="Herramientas" <?php if ($radioInsanigrama === 'radio_Ins2') echo 'checked'; ?> onclick="desbloquearCampo2()">
                                <label class="form-check-label" for="radio_Ins2">Herramientas</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Ins[]" id="radio_Ins3" value="Vehiculo" <?php if ($radioInsanigrama === 'radio_Ins3') echo 'checked'; ?> onclick="desbloquearCampo2()">
                                <label class="form-check-label" for="radio_Ins3">Vehiculo</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Ins[]" id="radio_Ins4" value="Ninguno" <?php if ($radioInsanigrama === 'radio_Ins4') echo 'checked'; ?> onclick="desbloquearCampo2()">
                                <label class="form-check-label" for="radio_Ins4">Ninguno</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Ins[]" id="radio_Ins5" value="Otro" <?php if ($radioInsanigrama === 'radio_Ins5') echo 'checked'; ?> onclick="desbloquearCampo2()">
                                <label class="form-check-label" for="radio_Ins5">Otro</label>
                                <input type="text" value="<?php echo $cargoDescripcion["otroinstrumento"]; ?>" id="otroinstrumento" name="otroinstrumento" class="form-control" disabled>
                            </div>

                            <script>
                                function desbloquearCampo2() {
                                    var radioIns5 = document.getElementById("radio_Ins5");
                                    var otroinstrumento = document.getElementById("otroinstrumento");
                                    if (radioIns5.checked) {
                                        otroinstrumento.disabled = false;
                                    } else {
                                        otroinstrumento.disabled = true;
                                    }
                                }
                            </script>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="organigrama">Describa si para realizar el trabajo requiere la manipulacion de:</label>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Man[]" id="radio_Man1" value="Quimicos" <?php if ($radioMananigrama === 'radio_Man1') echo 'checked'; ?> onclick="desbloquearCampo3()">
                                <label class="form-check-label" for="radio_Man1">Quimicos</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Man[]" id="radio_Man2" value="Biologicos" <?php if ($radioMananigrama === 'radio_Man2') echo 'checked'; ?> onclick="desbloquearCampo3()">
                                <label class="form-check-label" for="radio_Man2">Biologicos</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Man[]" id="radio_Man3" value="Inflamable" <?php if ($radioMananigrama === 'radio_Man3') echo 'checked'; ?> onclick="desbloquearCampo3()">
                                <label class="form-check-label" for="radio_Man3">Inflamable</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Man[]" id="radio_Man4" value="Ninguno" <?php if ($radioMananigrama === 'radio_Man4') echo 'checked'; ?> onclick="desbloquearCampo3()">
                                <label class="form-check-label" for="radio_Man4">Ninguno</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Man[]" id="radio_Man5" value="Otro" <?php if ($radioMananigrama === 'radio_Man5') echo 'checked'; ?> onclick="desbloquearCampo3()">
                                <label class="form-check-label" for="radio_Man5">Otro</label>
                                <input type="text" value="<?php echo $cargoDescripcion["otromanipulacion"]; ?>" id="otromanipulacion" name="otromanipulacion" class="form-control" disabled>
                            </div>

                            <script>
                                function desbloquearCampo3() {
                                    var radioMan5 = document.getElementById("radio_Man5");
                                    var otromanipulacion = document.getElementById("otromanipulacion");
                                    if (radioMan5.checked) {
                                        otromanipulacion.disabled = false;
                                    } else {
                                        otromanipulacion.disabled = true;
                                    }
                                }
                            </script>
                        </div>

                        <div class="col-md-6">
                            <label for="organigrama">Describa si para desmpeñar su trabajo requiere la realización de traslados:</label>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Tras[]" id="radio_Tras1" value="Areos" <?php if ($radioTrasanigrama === 'radio_Tras1') echo 'checked'; ?> onclick="desbloquearCampo4()">
                                <label class="form-check-label" for="radio_Tras1">Areos</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Tras[]" id="radio_Tras2" value="Terrestres" <?php if ($radioTrasanigrama === 'radio_Tras2') echo 'checked'; ?> onclick="desbloquearCampo4()">
                                <label class="form-check-label" for="radio_Tras2">Terrestres</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Tras[]" id="radio_Tras3" value="Maritimo" <?php if ($radioTrasanigrama === 'radio_Tras3') echo 'checked'; ?> onclick="desbloquearCampo4()">
                                <label class="form-check-label" for="radio_Tras3">Maritimo</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Tras[]" id="radio_Tras4" value="Ninguno" <?php if ($radioTrasanigrama === 'radio_Tras4') echo 'checked'; ?> onclick="desbloquearCampo4()">
                                <label class="form-check-label" for="radio_Tras4">Ninguno</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="radio_Tras[]" id="radio_Tras5" value="Otro" <?php if ($radioTrasanigrama === 'radio_Tras5') echo 'checked'; ?> onclick="desbloquearCampo4()">
                                <label class="form-check-label" for="radio_Tras5">Otro</label>
                                <input type="text" value="<?php echo $cargoDescripcion["otrotraslado"]; ?>" id="otrotraslado" name="otrotraslado" class="form-control" disabled>
                            </div>

                            <script>
                                function desbloquearCampo4() {
                                    var radioTras5 = document.getElementById("radio_Tras5");
                                    var otrotraslado = document.getElementById("otrotraslado");
                                    if (radioTras5.checked) {
                                        otrotraslado.disabled = false;
                                    } else {
                                        otrotraslado.disabled = true;
                                    }
                                }
                            </script>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha1">Fecha de preparación:</label>
                                <input type="date" id="fecha_preparacion" name="fecha_preparacion" value="<?php echo $cargoDescripcion["fecha_preparacion"]; ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="texto1a">Elaborado por Supervisor/jefe:</label>
                                <input type="text" id="supervisor" name="supervisor" value="<?php echo $cargoDescripcion["supervisor"]; ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="texto1b">Revisado por RRHH:</label>
                                <input type="text" id="revisado" name="revisado" value="<?php echo $cargoDescripcion["revisado"]; ?>" class="form-control" id="texto1b">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-5">
                        <button id="btn-send" class="btn btn-success btn-lg" type="button" title="Next">Enviar</button>
                    </div>
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

                            if (organigrama.length <= 0) {
                                showSweetAlert('Error', 'El campo nivel organizativo es obligatorio.', 'error');
                            } else if (proposito.value === '') {
                                showSweetAlert('Error', 'El campo breve descripción es obligatorio.', 'error');
                            } else if (funcion1.value === '') {
                                showSweetAlert('Error', 'Es obligatorio al menos ingresar una función.', 'error');
                            } else if (activdadError) {
                                showSweetAlert('Error', activdadErrorMsj, 'error');
                            } else if (presupuesto.length <= 0) {
                                showSweetAlert('Error', 'El campo presupuesto es obligatorio.', 'error');
                            } else if (ingreso.length <= 0) {
                                showSweetAlert('Error', 'El campo ingreso es obligatorio.', 'error');
                            } else if (gasto.length <= 0) {
                                showSweetAlert('Error', 'El campo gasto es obligatorio.', 'error');
                            } else if (empleados.value === '' || empleados.value === "0") {
                                showSweetAlert('Error', 'El campo empleados es obligatorio.', 'error');
                            } else if (!alMenosUnoMarcado) {
                                showSweetAlert('Error', 'Debe seleccionar al menos un conocimiento.', 'error');
                            } else if (experiencia.length <= 0) {
                                showSweetAlert('Error', 'El campo experiencia es obligatorio.', 'error');
                            } else if (ambiente.length <= 0) {
                                showSweetAlert('Error', 'El campo ambiente es obligatorio.', 'error');
                            } else if (instrumento.length <= 0) {
                                showSweetAlert('Error', 'El campo instrumento es obligatorio.', 'error');
                            } else if (manipulacion.length <= 0) {
                                showSweetAlert('Error', 'El campo manipulación es obligatorio.', 'error');
                            } else if (traslado.length <= 0) {
                                showSweetAlert('Error', 'El campo traslado es obligatorio.', 'error');
                            } else if (adicional.value === '') {
                                showSweetAlert('Error', 'El campo conocimientos adicionales es obligatorio.', 'error');
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
                            } else if (fecha_preparacion.value === '') {
                                showSweetAlert('Error', 'El campo fecha de preparación es obligatorio.', 'error');
                            } else if (supervisor.value === '') {
                                showSweetAlert('Error', 'El campo Elaborado por Supervisor/jefe es obligatorio.', 'error');
                            } else if (revisado.value === '') {
                                showSweetAlert('Error', 'El campo Revisado por RRHH es obligatorio.', 'error');
                            } else {
                                // Si los campos son válidos, enviar el formulario
                                const form = document.getElementById("formulario");
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
        </div>
        </article>
        </form>
    </div>
</div>


<?php include_once('../layouts/footer.php'); ?>
<script src="assets/js/usuarios.js">
</script>
<script src="assets/js/main.js"></script>