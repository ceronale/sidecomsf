<?php include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; 
$experiencia_laboral = "La Experiencia laboral no solo se refiere al trabajo que se ha realizado, sino también a todo lo aprendido a partir de esta. ;; - Personas que no han finalizado sus estudios académicos y que se han incorporado al mundo laboral aprendiendo su profesión trabajando. ;; - Han Desarrollado competencias profesionales a través de una actividad laboral, pero no poseen una acreditación oficial.";
$puntaje_valorado = " Si posee los cargos valorados en escala de uno (1) a mil (1000) puntos, puede agregarlo (el grado aparecerá automáticamente), de lo contrario, valore sus cargos en el formato.";


include_once 'class.crud.php';
$crud = new crud();
$id_cargo = $_GET['idc'];
extract($crud->get_valoracion_adm($id_cargo));

extract($crud->get_formato_cargo($id_cargo));

$formatodeta = "";
$formatodirect = "";
?>

<link rel="stylesheet" href="assets/css/styles.css">
<script src="assets/js/main.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <div class="card text-left">
            <div class="card-header">
                <span style="font-weight: bold; font-size: 25px">Valoración de Puestos/Cargos: Administrativos</span>
            </div>
        </div>
    </section>

    <!-- Content Header (Page header) -->
    <section class="content-header">

        <?php 
    if($formatodetallado == 1)
    {
        $formatodeta = "";
        $formatodirect = "display: none;";
    }
    else
    {
        $formatodeta = "display: none;";
        $formatodirect = "";
    }
    ?>
        <div class="hidden" id="formatodirecto" name="formatodirecto" style="<?= $formatodirect ?>">
            <form id="form-valoracion-adm"
                action="save.php?va&idc=<?php echo $_GET['idc']; ?>&ca=<?php echo $_GET['ca']; ?>" method="POST">

                <span style="font-weight: bold; font-size: 20px;"> Si posee los cargos valorados en escala de uno (1) a
                    mil (1000) puntos, puede agregarlo (el grado
                    aparecerá automáticamente), de lo contrario, valore sus cargos en el formato detallado.</span>

                <br><br>

                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="col-md-6" style="text-align: left !important;">
                                <label for="puntajevalorado">Puntaje:</label>
                            </div>
                            <div class="col-md-6">
                                <input type='text' name="puntajevalorado" id="puntajevalorado"
                                    onchange="validargrado(this.value)" class='form-control' required autocomplete="on">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="col-md-6" style="text-align: left !important;">
                                <label for="gradovalorado">Grado:</label>
                            </div>
                            <div class="col-md-6">
                                <input type='text' name="gradovalorado" id="gradovalorado" class='form-control' readonly
                                    required autocomplete="on">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-dark" name="btn-save-val-direct"
                                id='btn-save-val-direct'>
                                Guardar
                            </button>
                        </div>
                        <div class="col-md-1">
                            <a href="../cargos/?ca=1&val" class="btn btn-large btn-danger">
                                Volver</a>
                        </div>

                        <div class="col-md-3">

                        </div>

                        <div class="col-md-4">
                            <a href="#" class="btn btn-dark" onclick="usarformatodetallado()" name="btn-formato"
                                id='btn-formato'>
                                Usar Formato Detallado</a>
                        </div>
                    </div>
            </form>
        </div>
</div>

<div class="hidden" id="formatodetallado" name="formatodetallado" style="<?= $formatodeta ?>">

    <div class="card text-left">

        <ul class="tabs">
            <li><a href="#tab1"><i class="fas fa-university"></i><span class="tab-text">Conocimientos</span></a>
            </li>
            <li><a href="#tab2"><i class="fas fa-phone-laptop"></i><span class="tab-text">Responsabilidad
                        I</span></a>
            </li>
            <li><a href="#tab3"><i class="fas fa-sitemap"></i><span class="tab-text">Responsabilidad
                        II</span></a></li>
            <li><a href="#tab4"><i class="fas fa-weight-hanging"></i><span class="tab-text">Esfuerzo</span></a>
            </li>
            <li><a href="#tab5"><i class="fas fa-user-injured"></i><span class="tab-text">Condiciones de
                        Trabajo</span></a></li>
        </ul>

    </div>


    <!-- Content Header (Page header) -->




    <form id="form-valoracion-adm" action="save.php?va&idc=<?php echo $_GET['idc']; ?>&ca=<?php echo $_GET['ca']; ?>"
        method="POST">
        <div class='container'>
            <div class="row">
                <div class="col-md-9">
                    <h4>Departamento: <?php echo $nombredepartamento ?></span> </h4>
                </div>
                <div class="col-md-3">
                    <h4>Puntaje: <span id="puntajetotal" name="puntajetotal"><?php echo $puntaje; ?></span>
                    </h4>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-9">
                    <h4>Puesto/Cargo: <?php echo $nombrecargo ?> </h4>
                </div>
                <div class="col-md-3">
                    <h4>Grado: <span id="gradototal" name="gradototal"><?php echo $gradocargo; ?></span>
                    </h4>
                </div>
            </div>
        </div>
        <div class='container' style="overflow: auto; max-height: 600px;">


            <div class="secciones">
                <article id="tab1">

                    <br>


                    <div class="col-xs-12">
                        <p class="text-justify">
                            <span><strong>Conocimientos:</strong> Entendido como el aporte del raciocinio de
                                cada
                                persona para realizar el trabajo, y se
                                expresa a
                                través
                                de categorías o sub factores conocidos, tales como: Educación, Experiencia y
                                Solución de
                                problemas.
                                Es
                                la demostración del conocimiento teórico y práctico. Contiene los siguientes
                                sub
                                factores,
                                discriminados
                                a su vez en grados:</span>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <div class="col-xs-12">
                        <p class="text-justify">
                            <span><strong> 1.1 EDUCACIÓN:</strong> Es la formación académica mínima y
                                conocimientos
                                adquiridos a través de distintas
                                fuentes
                                de instrucción, necesarios para desempeñar el cargo en forma idónea. Incluye
                                desde la
                                educación
                                secundaria hasta la educación post universitaria. <span
                                    style="color:red;">*</span></span>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <p>
                    </p>

                    <table class="table table-striped table-bordered dt-responsive table-sm" id="tbleducacion">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col" style="width:100px">GRADO</th>
                                <th class="text-center" scope="col" style="width:850px">SUBFACTOR</th>
                                <th class="text-center" scope="col">PUNTAJE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-center" scope="row">1</th>
                                <td>
                                    <p class="text-justify"><strong>Bachillerato Incompleto:</strong>
                                        conocimientos
                                        básicos
                                        de
                                        primaria (saber leer y escribir).</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        17&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline" type="radio" name="radio_Edu[]"
                                            id="radio_Edu11" <?php if($educacion == "17"){echo "checked";} ?>
                                            value="17">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify">Bachillerato completo a nivel de <strong>Técnico
                                            Medio</strong>
                                        con
                                        mención en áreas diversas, tales como: administrativa, técnica, de
                                        salud u
                                        otras;
                                        con
                                        conocimientos adquiridos y necesarios para ejecutar el trabajo.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        36&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline" type="radio" name="radio_Edu[]"
                                            id="radio_Edu13" <?php if($educacion == "36"){echo "checked";} ?>
                                            value="36">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">Educación <strong>técnico superior
                                            universitario</strong>
                                        con
                                        conocimientos técnicos especializados en áreas diversas, tales como:
                                        administrativa,
                                        tecnología, de salud u otras, o su equivalente en años de estudios
                                        universitarios
                                        para
                                        optar a licenciatura o similar</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        54&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline" type="radio" name="radio_Edu[]"
                                            id="radio_Edu14" <?php if($educacion == "54"){echo "checked";} ?>
                                            value="54">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">4</th>
                                <td>
                                    <p class="text-justify">Educación <strong>universitaria
                                            completa</strong> con
                                        conocimientos
                                        en un campo profesional determinado o en una disciplina técnica,
                                        administrativa,
                                        de
                                        salud, artística u otra.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        71&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline" type="radio" name="radio_Edu[]"
                                            id="radio_Edu15" <?php if($educacion == "71"){echo "checked";} ?>
                                            value="71">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">5</th>
                                <td>
                                    <p class="text-justify">Estudios de <strong>postgrado/diplomado
                                            completo</strong>, o
                                        Diplomado o especialización u otro tipo de programa académico
                                        realizado
                                        después de
                                        completar la educación universitaria; con conocimientos más
                                        especializados o más
                                        avanzados en una o más disciplinas.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        89&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline" type="radio" name="radio_Edu[]"
                                            id="radio_Edu16" <?php if($educacion == "89"){echo "checked";} ?>
                                            value="89">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">6</th>
                                <td>
                                    <p class="text-justify">Estudios completos de <strong>Maestría.</strong>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        107&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline" type="radio" name="radio_Edu[]"
                                            id="radio_Edu17" <?php if($educacion == "107"){echo "checked";} ?>
                                            value="107">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">7</th>
                                <td>
                                    <p class="text-justify">Estudios completos de <strong>Doctorado
                                            (PHD).</strong></p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        125&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline" type="radio" name="radio_Edu[]"
                                            id="radio_Edu18" <?php if($educacion == "125"){echo "checked";} ?>
                                            value="125">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio
                                        entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_Edu[]"
                                            id="radio_Edu19"
                                            <?php if($educacion != "17" && $educacion != "36" && $educacion != "54" && $educacion != "71" & $educacion != "89" && $educacion != "107" && $educacion != "125"){echo "checked";} ?>
                                            value="0">
                                    </div>

                                </td>
                            </tr>

                        </tbody>

                    </table>

                    <div class="col-xs-12">
                        <p class="text-justify">
                            <span><strong
                                    onclick="info_tabla('Acreditación por experiencia laboral:','<?= $experiencia_laboral; ?>')"
                                    style="color: blue;"> ACREDITACIÓN POR EXPERIENCIA LABORAL:</strong> El
                                comité de
                                valoración una vez evaluada la formación
                                por experiencia, puede bajo criterio técnico y profesional, asignar un valor
                                equivalente
                                a los puntos que se otorgan
                                en el FACTOR EDUCACIÓN, entre 17 y 125 puntos, según el nivel
                                alcanzado.</span>
                        </p>
                    </div> <!-- col-xs-12 -->


                    <table class="table table-striped table-bordered dt-responsive table-sm" id="tbleducacion">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col" style="width:100px"></th>
                                <th class="text-center" scope="col" style="width:850px"></th>
                                <th class="text-center" scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Asigne el puntaje
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_Edu[]"
                                            id="radio_Edu19"
                                            <?php if($educacion != "17" && $educacion != "36" && $educacion != "54" && $educacion != "71" & $educacion != "89" && $educacion != "107" && $educacion != "125"){echo "checked";} ?>
                                            value="0">
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <p class="text-right text-danger"><strong>PUNTAJE:</strong></p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="number" class="form-control input-sm" name="educacion"
                                            id="educacion" value="<?php echo $educacion; ?>" onchange="sumPuntaje()"
                                            readonly style="width:70px" onfocusout="checkRangos('educacion');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                    <div class="col-xs-12">
                        <p class="text-justify">
                            <span><strong>1.2 EXPERIENCIA:</strong> Es el tiempo mínimo requerido para
                                desempeñar el
                                cargo
                                en
                                forma idónea. No debe asociarse este factor con el tiempo de servicio o
                                antigüedad que
                                posea
                                la
                                persona.<span class="required"> *</span></span>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <table class="table table-striped table-bordered dt-responsive table-sm" id="tblexperiencia">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col" style="width:100px">GRADO</th>
                                <th class="text-center" scope="col" style="width:850px">SUBFACTOR</th>
                                <th class="text-center" scope="col">PUNTAJE</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th class="text-center" scope="row">1</th>
                                <td>
                                    <p class="text-justify">Menos de un (1) año.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        25&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline" type="radio" name="radio_Exp[]"
                                            id="radio_Exp11" <?php if($experiencia == "25"){echo "checked";} ?>
                                            value="25">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify">Más de uno (1) hasta cinco (5) años.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        50&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline" type="radio" name="radio_Exp[]"
                                            id="radio_Exp12" <?php if($experiencia == "50"){echo "checked";} ?>
                                            value="50">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">Más de cinco (5) hasta diez (10) años.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        75&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($experiencia == "75"){echo "checked";} ?> type="radio"
                                            name="radio_Exp[]" id="radio_Exp13" value="75">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">4</th>
                                <td>
                                    <p class="text-justify">Más de diez (10) hasta quince (15) años.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        100&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($experiencia == "100"){echo "checked";} ?> type="radio"
                                            name="radio_Exp[]" id="radio_Exp14" value="100">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">5</th>
                                <td>
                                    <p class="text-justify">Más de quince (15) años.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        125&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($experiencia == "125"){echo "checked";} ?> type="radio"
                                            name="radio_Exp[]" id="radio_Exp14" value="125">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio
                                        entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_Exp[]"
                                            id="radio_Exp15"
                                            <?php if($experiencia != "25" && $experiencia != "50" && $experiencia != "75" && $experiencia != "100" && $experiencia != "125"){echo "checked";} ?>
                                            value="0">
                                    </div>

                                </td>
                            </tr>
                            <!--Puntaje-->
                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <p class="text-right text-danger"><strong>PUNTAJE:</strong></p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="number" class="form-control input-sm" name="experiencia"
                                            id="experiencia" value="<?php echo $experiencia; ?>" onchange="sumPuntaje()"
                                            readonly style="width:70px" onfocusout="checkRangos('experiencia');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="expErr"></div>

                    <div class="col-xs-12">
                        <p class="text-justify">
                            <span><strong>1.3 SOLUCIÓN DE PROBLEMAS:</strong> Se refiere a la capacidad
                                mental para
                                identificar,
                                definir y encontrar soluciones viables a situaciones o problemas inherentes
                                a la
                                ejecución
                                adecuada del trabajo.<span class="required"> *</span></span>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <table class="table table-striped table-bordered dt-responsive table-sm" id="tblproblemas">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col" style="width:100px">GRADO</th>
                                <th class="text-center" scope="col" style="width:850px">SUBFACTOR</th>
                                <th class="text-center" scope="col">PUNTAJE</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th class="text-center" scope="row">1</th>
                                <td>
                                    <p class="text-justify">Requiere identificar y entender
                                        <strong>soluciones
                                            conocidas</strong> (existentes). Por lo general, las soluciones
                                        tienen como
                                        referencia situaciones similares de acuerdo con experiencias que han
                                        ocurrido
                                        antes,
                                        siguiendo técnicas, normas y procedimientos que permiten
                                        alternativas.
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        37&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($problemas == "37"){echo "checked";} ?> type="radio"
                                            name="radio_Pro[]" id="radio_Pro11" value="37">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify">Requiere modificar ó incorporar elementos de
                                        <strong>soluciones
                                            conocidas y adaptarlas a la nueva situación</strong>,
                                        permitiendo más
                                        alternativas.
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        75&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($problemas == "75"){echo "checked";} ?> type="radio"
                                            name="radio_Pro[]" id="radio_Pro12" value="75">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">Requiere de la <strong>búsqueda e
                                            investigación</strong> de
                                        elementos que deben considerarse para alcanzar soluciones
                                        originales. Enfrenta
                                        situaciones que requieren de pensamiento analítico, evaluativo e
                                        interpretativo.
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        113&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($problemas == "113"){echo "checked";} ?> type="radio"
                                            name="radio_Pro[]" id="radio_Pro13" value="113">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">4</th>
                                <td>
                                    <p class="text-justify">Requiere <strong>crear soluciones</strong> con
                                        muy pocos
                                        antecedentes o ninguno. Enfrenta situaciones especiales y complejas
                                        no conocidas
                                        de
                                        antemano. Requiere desarrollar conceptos y enfoques de avanzada.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        150&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($problemas == "150"){echo "checked";} ?> type="radio"
                                            name="radio_Pro[]" id="radio_Pro14" value="150">
                                    </div>
                                </td>
                            </tr>
                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio
                                        entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_Pro[]"
                                            id="radio_Pro15"
                                            <?php if($problemas != "37" && $problemas != "75" && $problemas != "113" && $problemas != "150"){echo "checked";} ?>
                                            value="0">
                                    </div>

                                </td>
                            </tr>
                            <!--Puntaje-->
                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <p class="text-right text-danger"><strong>PUNTAJE:</strong></p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="number" class="form-control input-sm" name="problemas"
                                            id="problemas" value="<?php echo $problemas; ?>" onchange="sumPuntaje()"
                                            readonly style="width:70px" onfocusout="checkRangos('problemas');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="proErr"></div>
                    <p aria-hidden="true" id="required-description">
                        <span class="required">*</span> Campo obligatorio
                    </p>


                </article>


                <article id="tab2">

                    <br>

                    <div class="col-xs-12">
                        <p class="text-justify">
                            <span><strong>Responsabilidad:</strong> Entendida como el compromiso o capacidad
                                de
                                responder que exige el cargo al individuo,
                                ante
                                obligaciones o circunstancias presentes en el entorno del trabajo, tales
                                como:
                                supervisión
                                de
                                personal, manejo de dinero, información o bienes, uso de materiales,
                                equipos,
                                maquinarias o
                                herramientas; relaciones de trabajo, toma de decisiones.</span>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <div class="col-xs-12">
                        <p class="text-justify">
                            <span><strong>2.1 RESPONSABILIDAD POR SUPERVISIÓN:</strong> Es el grado de
                                supervisión
                                ejercida para planear, organizar, dirigir y controlar el trabajo de otras
                                personas. Debe
                                tomarse
                                en cuenta la naturaleza de la supervisión ejercida y el nivel de
                                calificación de los
                                puestos
                                supervisados.</em><span class="required">*</span></span>
                        </p>
                    </div> <!-- col-xs-12 -->


                    <table class="table table-striped table-bordered dt-responsive table-sm" id="tblsupervision">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col" style="width:100px">GRADO</th>
                                <th class="text-center" scope="col" style="width:850px">SUBFACTOR</th>
                                <th class="text-center" scope="col">PUNTAJE</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th class="text-center" scope="row">1</th>
                                <td>
                                    <p class="text-justify"><strong>No se ejerce supervisión.</strong>
                                        Responsable por
                                        el
                                        trabajo propio. Alguna vez orienta a otros sobre la forma de
                                        realizar el
                                        trabajo.
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        17&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($supervision == "17"){echo "checked";} ?> type="radio"
                                            name="radio_Resps[]" id="radio_Resps21" value="17" autofocus>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify">Se ejerce <strong>supervisión de rutina</strong>
                                        sobre
                                        trabajadores
                                        con ocupaciones idénticas, siguiendo procedimientos estándares.
                                        Asigna trabajo
                                        que
                                        ya
                                        viene planeado, coordinado y programado, siendo responsable de la
                                        disciplina y
                                        comportamiento del personal subordinado. Da continuas instrucciones
                                        y controla
                                        resultados. Consulta con su supervisor.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        33&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($supervision == "33"){echo "checked";} ?> type="radio"
                                            name="radio_Resps[]" id="radio_Resps22" value="33">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">Se ejerce <strong>supervisión no continua o
                                            general</strong>
                                        sobre
                                        una unidad, sección o grupo de trabajadores con ocupaciones
                                        relacionadas.
                                        Coordina,
                                        programa y controla el trabajo de sus subordinados, pudiendo
                                        orientar o decidir
                                        ante
                                        situaciones de trabajo no usuales.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        50&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($supervision == "50"){echo "checked";} ?> type="radio"
                                            name="radio_Resps[]" id="radio_Resps23" value="50">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">4</th>
                                <td>
                                    <p class="text-justify">Se ejerce <strong>supervisión general</strong>
                                        sobre una
                                        unidad
                                        o de
                                        trabajo o grupo de trabajadores con ocupaciones relacionadas según
                                        su
                                        naturaleza.
                                        Los
                                        subordinados a su vez pueden tener personal a su cargo. Da su visto
                                        bueno o
                                        aprobación a
                                        actuaciones o trabajos finales, pudiendo completar o
                                        complementarlos. Coordina,
                                        programa
                                        y organiza el trabajo de sus subordinados, siguiendo directrices
                                        generales de su
                                        línea
                                        de reporte.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        67&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($supervision == "67"){echo "checked";} ?> type="radio"
                                            name="radio_Resps[]" id="radio_Resps24" value="67">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">5</th>
                                <td>
                                    <p class="text-justify">Se ejerce <strong>supervisión a nivel gerencial
                                            medio</strong> o
                                        grupo diverso de trabajadores, de distinta calificación técnica,
                                        profesional y
                                        tipo
                                        de
                                        trabajo. Sus subordinados a su vez, pueden tener personal a su
                                        cargo. Planifica,
                                        dirige
                                        y coordina el trabajo de unidades o grupo de trabajadores para
                                        cumplir
                                        directrices,
                                        políticas, normas, planes y metas. Rinde cuenta de resultados
                                        obtenidos.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        83&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($supervision == "83"){echo "checked";} ?> type="radio"
                                            name="radio_Resps[]" id="radio_Resps25" value="83">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">6</th>
                                <td>
                                    <p class="text-justify"><strong>Ejerce dirección</strong> sobre varias
                                        áreas y
                                        funciones
                                        de
                                        la institución para alcanzar los resultados operativos y
                                        estratégicos. Sus
                                        subordinados
                                        tienen personal a su cargo. Dirige y desarrolla planes y políticas.
                                        Rinde cuenta
                                        de
                                        su
                                        gestión. Corresponde a instancias de Dirección.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        100&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline enable_tb"
                                            <?php if($supervision == "100"){echo "checked";} ?> type="radio"
                                            name="radio_Resps[]" id="radio_Resps26" value="100">
                                    </div>
                                </td>
                            </tr>

                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio
                                        entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_Resps[]"
                                            id="radio_Resps27"
                                            <?php if($supervision != "17" && $supervision != "33" && $supervision != "50" && $supervision != "67" && $supervision != "83" && $supervision != "100"){echo "checked";} ?>
                                            value="0">
                                    </div>

                                </td>
                            </tr>
                            <!--Puntaje-->
                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <p class="text-right text-danger"><strong>PUNTAJE:</strong></p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="number" class="form-control input-sm" name="supervision"
                                            id="supervision" value="<?php echo $supervision; ?>" onchange="sumPuntaje()"
                                            readonly style="width:70px" onfocusout="checkRangos('supervision');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="supErr"></div>

                    <div class="col-xs-12">
                        <p class="text-justify">
                            <span><strong>2.2 RESPONSABILIDAD FINANCIERA:</strong> Evalúa el grado en que se
                                maneja y/o
                                custodia
                                dinero, valores, bienes negociables, u otros recursos financieros de la
                                organización, lo
                                cual
                                puede ocasionarle posibles perjuicios. Considérese el manejo o acceso
                                realmente
                                necesario
                                para
                                el desempeño del cargo, y no circunstancias temporales.<span class="required">
                                    *</span></span>

                        </p>
                    </div> <!-- col-xs-12 -->

                    <table class="table table-striped table-bordered dt-responsive table-sm" id="tblfinanciera">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col" style="width:100px">GRADO</th>
                                <th class="text-center" scope="col" style="width:850px">SUBFACTOR</th>
                                <th class="text-center" scope="col">PUNTAJE</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th class="text-center" scope="row">1</th>
                                <td>
                                    <p class="text-justify"><strong>Ninguna o muy poca
                                            responsabilidad</strong> por
                                        manejo o custodia de
                                        dinero,
                                        bienes negociables, valores o recursos financieros.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        15&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($financiera == "15"){echo "checked";} ?> type="radio"
                                            name="radio_Respf[]" id="radio_Respf21" value="15">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify">Maneja y/o custodia
                                        <strong>ocasionalmente</strong> dinero,
                                        bienes
                                        negociables,
                                        valores o recursos financieros, en cantidades variables.
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        30&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($financiera == "30"){echo "checked";} ?> type="radio"
                                            name="radio_Respf[]" id="radio_Respf22" value="30">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">Maneja y/o custodia
                                        <strong>regularmente</strong> dinero,
                                        bienes negociables,
                                        valores
                                        o recursos financieros, en cantidades variables.
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        45&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($financiera == "45"){echo "checked";} ?> type="radio"
                                            name="radio_Respf[]" id="radio_Respf23" value="45">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">4</th>
                                <td>
                                    <p class="text-justify">Maneja y/o custodia
                                        <strong>continuamente</strong> dinero,
                                        bienes
                                        negociables,
                                        valores o recursos financieros, en cantidades variables.
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        60&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline" type="radio"
                                            <?php if($financiera == "60"){echo "checked";} ?> name="radio_Respf[]"
                                            id="radio_Respf24" value="60">
                                    </div>
                                </td>
                            </tr>
                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio
                                        entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_Respf[]"
                                            id="radio_Respf25"
                                            <?php if($financiera != "15" && $financiera != "30" && $financiera != "45" && $financiera != "60"){echo "checked";} ?>
                                            value="0">
                                    </div>
                                </td>
                            </tr>
                            <!--Puntaje-->
                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <p class="text-right text-danger"><strong>PUNTAJE:</strong></p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="number" class="form-control input-sm" name="financiera"
                                            id="financiera" value="<?php echo $financiera; ?>" onchange="sumPuntaje()"
                                            readonly style="width:70px" onfocusout="checkRangos('financiera');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="finErr"></div>


                    <div class="col-xs-12">
                        <p class="text-justify">
                            <span><strong>2.3 Responsabilidad por equipos, maquinarias, herramientas o
                                    materiales:
                                </strong>
                                Mide
                                el compromiso que tiene el trabajador por el uso y cuidado de equipos,
                                maquinarias,
                                computadoras,
                                herramientas
                                o materiales necesarios, relacionados con el desempeño del cargo, y propios
                                de la
                                naturaleza
                                de
                                la organización.<span class="required"> *</span></span>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <table class="table table-striped table-bordered dt-responsive table-sm" id="tblmaquinarias">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col" style="width:100px">GRADO</th>
                                <th class="text-center" scope="col" style="width:850px">SUBFACTOR</th>
                                <th class="text-center" scope="col">PUNTAJE</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th class="text-center" scope="row">1</th>
                                <td>
                                    <p class="text-justify">Ninguna o poca responsabilidad por el uso y
                                        cuidado de
                                        equipos,
                                        maquinarias, herramientas o materiales.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        17&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($maquinarias == "17"){echo "checked";} ?> type="radio"
                                            name="radio_RespMq[]" id="radio_RespMq21" value="17">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify">Apreciable responsabilidad por el uso y cuidado
                                        de equipos,
                                        maquinarias, herramientas o materiales, y su posible daño, deterioro
                                        o
                                        sustracción
                                        puede
                                        ocasionar pérdidas a la organización.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        33&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($maquinarias == "33"){echo "checked";} ?> type="radio"
                                            name="radio_RespMq[]" id="radio_RespMq22" value="33">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">Muy apreciable responsabilidad por el uso y
                                        cuidado de
                                        equipos,
                                        maquinarias, herramientas o materiales, y su posible daño, deterioro
                                        o
                                        sustracción
                                        puede
                                        ocasionar grandes pérdidas a la organización.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        50&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($maquinarias == "50"){echo "checked";} ?> type="radio"
                                            name="radio_RespMq[]" id="radio_RespMq23" value="50">
                                    </div>
                                </td>
                            </tr>
                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio
                                        entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_RespMq[]"
                                            id="radio_RespMq24"
                                            <?php if($maquinarias != "17" && $maquinarias != "33" && $maquinarias != "50"){echo "checked";} ?>
                                            value="0">
                                    </div>
                                </td>
                            </tr>
                            <!--Puntaje-->
                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <p class="text-right text-danger"><strong>PUNTAJE:</strong></p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="number" class="form-control input-sm" name="maquinarias"
                                            id="maquinarias" value="<?php echo $maquinarias; ?>" onchange="sumPuntaje()"
                                            readonly style="width:70px" onfocusout="checkRangos('maquinarias');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="maqErr"></div>
                    <p aria-hidden="true" id="required-description">
                        <span class="required">*</span> Campo obligatorio
                    </p>

                </article>


                <article id="tab3">

                    <br>


                    <div class="col-xs-12">
                        <p class="text-justify">
                            <span><strong>Responsabilidad II:</strong> Entendida como el compromiso o
                                capacidad de
                                responder que exige el cargo al individuo,
                                ante
                                obligaciones o circunstancias presentes en el entorno del trabajo, tales
                                como:
                                supervisión
                                de
                                personal, manejo de dinero, información o bienes, uso de materiales,
                                equipos,
                                maquinarias o
                                herramientas; relaciones de trabajo, toma de decisiones.</span>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <div class="col-xs-12">
                        <p class="text-justify">
                            <span><strong>2.4 RESPONSABILIDAD POR CONTACTOS INTERNOS Y EXTERNOS: </strong>
                                Evalúa las
                                relaciones dentro y/o afuera
                                de la organización, necesarias para el desempeño del cargo. Considérese la
                                naturaleza
                                del contacto, con quién se mantiene
                                en contacto y la importancia que tiene para la organización.<span class="required">
                                    *</span></span>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <table class="table table-striped table-bordered dt-responsive table-sm" id="tblcontactos">

                        <thead>
                            <tr>
                                <th class="text-center" scope="col" style="width:100px">GRADO</th>
                                <th class="text-center" scope="col" style="width:850px">SUBFACTOR</th>
                                <th class="text-center" scope="col">PUNTAJE</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th class="text-center" scope="row">1</th>
                                <td>
                                    <p class="text-justify">Contactos de rutina, con personas de otras
                                        áreas, dando o
                                        recibiendo
                                        información. Requiere simple cortesía. Poco o ningún contacto
                                        externo. Los
                                        contactos
                                        y
                                        su frecuencia no son un elemento importante del trabajo.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        10&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($contactos == "10"){echo "checked";} ?> type="radio"
                                            name="radio_RespCon[]" id="radio_RespCon21" value="10">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify">Contactos frecuentes con personas de otras
                                        áreas, o externas
                                        a
                                        la
                                        institución. Implica obtener, dar o consultar datos. Requiere cierto
                                        tacto,
                                        trato
                                        cortés
                                        y conocimiento de normas y procedimientos internos. Los contactos
                                        son un
                                        elemento
                                        importante del trabajo.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        20&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($contactos == "20"){echo "checked";} ?> type="radio"
                                            name="radio_RespCon[]" id="radio_RespCon22" value="20">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">El contacto o trato con personas dentro y fuera
                                        de la
                                        institución es
                                        parte importante en el desempeño del cargo, tiene carácter
                                        frecuente. Implica
                                        manejo
                                        de
                                        negociación, persuasión, acuerdos importante, cooperación,
                                        intercambio. Requiere
                                        mucho
                                        tacto y discreción. La forma de asumir los contactos puede afectar
                                        la imagen de
                                        la
                                        institución.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        30&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($contactos == "30"){echo "checked";} ?> type="radio"
                                            name="radio_RespCon[]" id="radio_RespCon23" value="30">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">4</th>
                                <td>
                                    <p class="text-justify">Contactos externos que implican negociaciones
                                        que vinculan o
                                        impactan a todas las areas de la organización los cuales marcan su
                                        actuación.
                                        Los
                                        contactos internos son con todos los niveles. Generalmente
                                        representa a la
                                        institución e
                                        interpreta políticas, doctrinas y normas ante terceros. La
                                        frecuencia o no de
                                        los
                                        contactos está determinada por la naturaleza de la gestión.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        40&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($contactos == "40"){echo "checked";} ?> type="radio"
                                            name="radio_RespCon[]" id="radio_RespCon24" value="40">
                                    </div>
                                </td>
                            </tr>
                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio
                                        entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_RespCon[]"
                                            id="radio_RespCon25"
                                            <?php if($contactos != "10" && $contactos != "20" && $contactos != "30" && $contactos != "40"){echo "checked";} ?>
                                            value="0">
                                    </div>
                                </td>
                            </tr>
                            <!--Puntaje-->
                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <p class="text-right text-danger"><strong>PUNTAJE:</strong></p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="number" class="form-control input-sm" name="contactos"
                                            id="contactos" value="<?php echo $contactos; ?>" readonly
                                            onchange="sumPuntaje()" style="width:70px"
                                            onfocusout="checkRangos('contactos');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="conErr"></div>

                    <div class="col-xs-12">
                        <p class="text-justify">
                            <span><strong>2.5 RESPONSABILIDAD POR TOMA DE DECISIONES: </strong> Evalúa la
                                capacidad de
                                elegir
                                una
                                vía de acción determinada, con el consiguiente riesgo y responsabilidad que
                                implica
                                dicha
                                acción. Considérese la facultad de decidir con un “si” o un “no”, es
                                accionar o no hacia
                                determinada dirección. Se asociará con la consecuencia que implica y no con
                                solución de
                                problemas o iniciativa. Este sub. Factor enfatiza sobre cargos a los cuales
                                se le ha
                                delegado
                                autoridad, en menor o mayor grado.<span class="required"> *</span></span>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <table class="table table-striped table-bordered dt-responsive table-sm" id="tbldecisiones">

                        <thead>
                            <tr>
                                <th class="text-center" scope="col" style="width:100px">GRADO</th>
                                <th class="text-center" scope="col" style="width:850px">SUBFACTOR</th>
                                <th class="text-center" scope="col">PUNTAJE</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th class="text-center" scope="row">1</th>
                                <td>
                                    <p class="text-justify"><strong>Ninguna responsabilidad</strong> por
                                        decisiones que
                                        no
                                        ocasionan dificultad para prever las consecuencias de las mismas.
                                        Revisten poco
                                        o
                                        ningún
                                        riesgo, además se encuentran sujetas a revisiones o aprobaciones de
                                        una
                                        autoridad
                                        superior.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        20&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($decisiones == "20"){echo "checked";} ?> type="radio"
                                            name="radio_RespDec[]" id="radio_RespDec21" value="20">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify"><strong>Responsabilidad por decisiones</strong>
                                        donde existe
                                        cierta
                                        dificultad para prever sus consecuencias, afectan una unidad de
                                        trabajo y
                                        revisten
                                        cierto riesgo.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        40&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($decisiones == "40"){echo "checked";} ?> type="radio"
                                            name="radio_RespDec[]" id="radio_RespDec22" value="40">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify"><strong>Responsabilidad por decisiones</strong>
                                        donde las
                                        consecuencias de las acciones tomadas <strong>afectan varias
                                            unidades de
                                            trabajo</strong> en cuanto a personas, costos y actividades. Son
                                        decisiones
                                        que
                                        están sujetas a la revisión del superior inmediato, revisten cierto
                                        grado de
                                        nulidad
                                        o
                                        posibilidad de ser reconsideradas.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        60&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($decisiones == "60"){echo "checked";} ?> type="radio"
                                            name="radio_RespDec[]" id="radio_RespDec23" value="60">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">4</th>
                                <td>
                                    <p class="text-justify"><strong>Responsabilidad por la toma de
                                            decisiones que
                                            afectan a
                                            la
                                            institución</strong> en su gestión y administración, y en donde
                                        las
                                        consecuencias de
                                        las acciones tomadas son considerables.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        80&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($decisiones == "80"){echo "checked";} ?> type="radio"
                                            name="radio_RespDec[]" id="radio_RespDec24" value="80">
                                    </div>
                                </td>
                            </tr>
                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio
                                        entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_RespDec[]"
                                            id="radio_RespRespDec25"
                                            <?php if($decisiones != "20" && $decisiones != "40" && $decisiones != "60" && $decisiones != "80"){echo "checked";} ?>
                                            value="0">
                                    </div>
                                </td>
                            </tr>
                            <!--Puntaje-->
                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <p class="text-right text-danger"><strong>PUNTAJE:</strong></p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="number" class="form-control input-sm" name="decisiones"
                                            id="decisiones" value="<?php echo $decisiones; ?>" onchange="sumPuntaje()"
                                            readonly style="width:70px" onfocusout="checkRangos('decisiones');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="decErr"></div>

                    <div class="col-xs-12">
                        <p class="text-justify">
                            <span><strong>2.6 Responsabilidad por información valiosa o
                                    confidencial:</strong> Considera
                                la
                                responsabilidad por manejo o acceso a información valiosa, sensible o
                                confidencial cuyo
                                uso
                                indebido o revelación podría causar perjuicios a la institución. Se toma en
                                cuenta el
                                grado
                                de
                                acceso y posibles efectos por su divulgación o manejo inapropiado.<span
                                    class="required">
                                    *</span></span>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <table class="table table-striped table-bordered dt-responsive table-sm" id="tblinformacion">

                        <thead>
                            <tr>
                                <th class="text-center" scope="col" style="width:100px">GRADO</th>
                                <th class="text-center" scope="col" style="width:850px">SUBFACTOR</th>
                                <th class="text-center" scope="col">PUNTAJE</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th class="text-center" scope="row">1</th>
                                <td>
                                    <p class="text-justify"><strong>No requiere</strong> manejar información
                                        valiosa o
                                        maneja
                                        ocasionalmente información valiosa, o sensible o confidencial, cuya
                                        revelación o
                                        uso
                                        indebido produciría trastornos menores, disgusto o malestar. Esta
                                        información es
                                        del
                                        conocimiento de otras personas.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        17&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($informacion == "17"){echo "checked";} ?> type="radio"
                                            name="radio_RespInf[]" id="radio_RespInf21" value="17">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify"><strong>Maneja regularmente</strong> información
                                        valiosa, o
                                        sensible
                                        o confidencial, cuya revelación o uso inapropiado produciría
                                        trastornos internos
                                        o
                                        trastornos de importancia en lo económico, financiero, prestigio de
                                        la
                                        institución y
                                        demás intereses.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        35&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($informacion == "35"){echo "checked";} ?> type="radio"
                                            name="radio_RespInf[]" id="radio_RespInf22" value="35">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify"><strong>Maneja continuamente información
                                            valiosa</strong>, o
                                        sensible o confidencial, cuya revelación o uso inapropiado puede
                                        perjudicar los
                                        diversos
                                        intereses e imagen de la institución.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        53&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($informacion == "53"){echo "checked";} ?> type="radio"
                                            name="radio_RespInf[]" id="radio_RespInf23" value="53">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">4</th>
                                <td>
                                    <p class="text-justify"><strong>Tiene acceso sin restricciones a
                                            información
                                            sumamente
                                            valiosa</strong>, o sensible o confidencial de la institución,
                                        de la cual
                                        depende su
                                        gestión actual y futura.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        70&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($informacion == "70"){echo "checked";} ?> type="radio"
                                            name="radio_RespInf[]" id="radio_RespInf24" value="70">
                                    </div>
                                </td>
                            </tr>
                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio
                                        entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_RespInf[]"
                                            id="radio_RespInf25"
                                            <?php if($informacion != "17" && $informacion != "35" && $informacion != "53" && $informacion != "70"){echo "checked";} ?>
                                            value="0">
                                    </div>
                                </td>
                            </tr>
                            <!--Puntaje-->
                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <p class="text-right text-danger"><strong>PUNTAJE:</strong></p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="number" class="form-control input-sm" name="informacion"
                                            id="informacion" value="<?php echo $informacion; ?>" onchange="sumPuntaje()"
                                            readonly style="width:70px" onfocusout="checkRangos('informacion');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="infErr"></div>
                    <p aria-hidden="true" id="required-description">
                        <span class="required">*</span> Campo obligatorio
                    </p>

                </article>


                <article id="tab4">

                    <br>

                    <div class="col-xs-12">
                        <p class="text-justify">
                            <span><strong>Esfuerzo:</strong> Entendida como la energía o rigor requerido
                                para realizar
                                adecuadamente el trabajo,
                                considerandose el grado de energía corporal y la atención mental en términos
                                de
                                intensidad,
                                duración y frecuencia. Contiene los siguientes subfactores: </span>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <div class="col-xs-12">
                        <p class="text-justify">
                            </span><strong>3.1 Esfuerzo físico:</strong> Mide el grado de energía física
                            requerida para
                            realizar el
                            trabajo en términos de posiciones corporales, movilización de un sitio a otro,
                            manejo de
                            objetos, operación de equipos u otros actos o movimientos.<span class="required">
                                *</span></span>
                            </h5>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <table class="table table-striped table-bordered dt-responsive table-sm" id="tblfisico">

                        <thead>
                            <tr>
                                <th class="text-center" scope="col" style="width:100px">GRADO</th>
                                <th class="text-center" scope="col" style="width:850px">SUBFACTOR</th>
                                <th class="text-center" scope="col">PUNTAJE</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th class="text-center" scope="row">1</th>
                                <td>
                                    <p class="text-justify">Se requiere <strong>mínimo esfuerzo
                                            físico</strong>. No se
                                        produce
                                        fatiga al ejecutar el trabajo.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        10&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($esfuerzo == "10"){echo "checked";} ?> type="radio"
                                            name="radio_Esff[]" id="radio_Esff31" value="10">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify">Se requiere <strong>esfuerzo moderado</strong> y
                                        no
                                        continuado,
                                        por
                                        uso de máquinas, equipos, mecanismos; por permanencia de pie, por
                                        trabajos que
                                        impliquen
                                        elevación, traslado de un sitio a otro, levantamiento de objetos o
                                        materiales de
                                        poco
                                        volumen o peso. Se produce fatiga moderada.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        20&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($esfuerzo == "20"){echo "checked";} ?> type="radio"
                                            name="radio_Esff[]" id="radio_Esff32" value="20">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">Se requiere <strong>mayor esfuerzo en forma
                                            frecuente</strong>,
                                        continuada y prolongada. Se produce fatiga continua y moderada por
                                        levantar y
                                        transportar objetos de poco o mayor volumen o peso, operar equipos,
                                        máquinas o
                                        herramientas, operar mecanismos, trabajar en posiciones incómodas o
                                        trabajar
                                        sostenidamente en posiciones de pie, realizar trabajos que impliquen
                                        elevación.
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        30&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($esfuerzo == "30"){echo "checked";} ?> type="radio"
                                            name="radio_Esff[]" id="radio_Esff33" value="30">
                                    </div>
                                </td>
                            </tr>
                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio
                                        entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_Esff[]"
                                            id="radio_Esff24"
                                            <?php if($esfuerzo != "10" && $esfuerzo != "20" && $esfuerzo != "30"){echo "checked";} ?>
                                            value="0">
                                    </div>
                                </td>
                            </tr>
                            <!--Puntaje-->
                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <p class="text-right text-danger"><strong>PUNTAJE:</strong></p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="number" class="form-control input-sm" name="esfuerzo" id="esfuerzo"
                                            value="<?php echo $esfuerzo; ?>" readonly style="width:70px"
                                            onchange="sumPuntaje()" onfocusout="checkRangos('esfuerzo');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="fisErr"></div>

                    <div class="col-xs-12">
                        <p class="text-justify">
                            <span><strong>3.2 Esfuerzo mental:</strong> Se refiere al grado de energía
                                psíquica que
                                exige
                                la
                                ejecución del trabajo, en términos de concentración, atención y coordinación
                                de ideas,
                                siguiendo
                                criterios de intensidad, duración y frecuencia.<span class="required">
                                    *</span>
                            </span>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <table class="table table-striped table-bordered dt-responsive table-sm" id="tblmental">

                        <thead>
                            <tr>
                                <th class="text-center" scope="col" style="width:100px">GRADO</th>
                                <th class="text-center" scope="col" style="width:850px">SUBFACTOR</th>
                                <th class="text-center" scope="col">PUNTAJE</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th class="text-center" scope="row">1</th>
                                <td>
                                    <p class="text-justify">Requiere <strong>mínimo esfuerzo o concentración
                                            mental</strong>
                                        para realizar las tareas.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        15&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($mental == "15"){echo "checked";} ?> type="radio"
                                            name="radio_Esfm[]" id="radio_Esfm31" value="15">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify">Requiere moderado esfuerzo o atención visual o
                                        auditiva,
                                        para
                                        realizar tareas variadas no rutinarias. Puede ocasionalmente
                                        incrementarse.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        30&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($mental == "30"){echo "checked";} ?> type="radio"
                                            name="radio_Esfm[]" id="radio_Esfm32" value="30">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">Requiere apreciable y continuo esfuerzo y
                                        atención visual o
                                        auditiva
                                        para realizar tareas variadas o medianamente complejos.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        45&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($mental == "45"){echo "checked";} ?> type="radio"
                                            name="radio_Esfm[]" id="radio_Esfm33" value="45">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">4</th>
                                <td>
                                    <p class="text-justify">Requiere muy apreciable y continuo esfuerzo o
                                        atención
                                        visual o
                                        auditiva para realizar trabajos medianamente complejos o complejos.
                                        Los ojos o
                                        los
                                        oídos
                                        pueden resentirse.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        60&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($mental == "60"){echo "checked";} ?> type="radio"
                                            name="radio_Esfm[]" id="radio_Esfm34" value="60">
                                    </div>
                                </td>
                            </tr>
                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio
                                        entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_Esfm[]"
                                            id="radio_Esfm35"
                                            <?php if($mental != "15" && $mental != "30" && $mental != "45" && $mental != "60"){echo "checked";} ?>
                                            value="0">
                                    </div>
                                </td>
                            </tr>
                            <!--Puntaje-->
                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <p class="text-right text-danger"><strong>PUNTAJE:</strong></p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="number" class="form-control input-sm" name="mental" id="mental"
                                            value="<?php echo $mental; ?>" readonly style="width:70px"
                                            onchange="sumPuntaje()" onfocusout="checkRangos('mental');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="menErr"></div>

                    <div class="col-xs-12">
                        <p class="text-justify">
                            <span><strong>3.3 Esfuerzo sensorial:</strong> Se refiere a la atención visual
                                y/o auditiva
                                que
                                exige
                                la ejecución del trabajo, en términos de la intensidad y grado de
                                continuidad del
                                esfuerzo
                                realizado con los ojos o con los oídos. Considérese el reconocer o
                                discriminar elementos
                                o
                                instrumentos fijos o en movimiento, así como distinguir entre tono,
                                intensidad o calidad
                                de
                                los
                                sonidos, ya sea combinados o un sonido particular.<span class="required">
                                    *</span></span>
                            </h5>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <table class="table table-striped table-bordered dt-responsive table-sm" id="tblsensorial">

                        <thead>
                            <tr>
                                <th class="text-center" scope="col" style="width:100px">GRADO</th>
                                <th class="text-center" scope="col" style="width:850px">SUBFACTOR</th>
                                <th class="text-center" scope="col">PUNTAJE</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th class="text-center" scope="row">1</th>
                                <td>
                                    <p class="text-justify">Requiere <strong>mínimo esfuerzo o
                                            atención</strong>, ya sea
                                        visual
                                        o auditivo, para realizar tareas sencillas.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        7&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($sensorial == "7"){echo "checked";} ?> type="radio"
                                            name="radio_Esfs[]" id="radio_Esfs31" value="7">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify"><strong>Requiere moderado esfuerzo o
                                            atención</strong>
                                        visual o
                                        auditiva, para realizar tareas variadas no rutinarias. Puede
                                        ocasionalmente
                                        incrementarse.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        15&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($sensorial == "15"){echo "checked";} ?> type="radio"
                                            name="radio_Esfs[]" id="radio_Esfs32" value="15">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">Requiere <strong>apreciable y continuo esfuerzo
                                            y
                                            atención</strong>
                                        visual o auditiva para realizar tareas variadas o medianamente
                                        complejos.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        23&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($sensorial == "23"){echo "checked";} ?> type="radio"
                                            name="radio_Esfs[]" id="radio_Esfs33" value="23">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">4</th>
                                <td>
                                    <p class="text-justify">Requiere <strong>muy apreciable y continuo
                                            esfuerzo o
                                            atención</strong> visual o auditiva para realizar trabajos
                                        medianamente
                                        complejos o
                                        complejos. Los ojos o los oídos pueden resentirse.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        30&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($sensorial == "30"){echo "checked";} ?> type="radio"
                                            name="radio_Esfs[]" id="radio_Esfs34" value="30">
                                    </div>
                                </td>
                            </tr>
                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio
                                        entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_Esfs[]"
                                            id="radio_Esfs35"
                                            <?php if($sensorial != "7" && $sensorial != "15" && $sensorial != "23" && $sensorial != "30"){echo "checked";} ?>
                                            value="0">
                                    </div>
                                </td>
                            </tr>
                            <!--Puntaje-->
                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <p class="text-right text-danger"><strong>PUNTAJE:</strong></p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="number" class="form-control input-sm" name="sensorial"
                                            id="sensorial" value="<?php echo $sensorial; ?>" readonly
                                            onchange="sumPuntaje()" style="width:70px"
                                            onfocusout="checkRangos('sensorial');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="senErr"></div>
                    <p aria-hidden="true" id="required-description">
                        <span class="required">*</span> Campo obligatorio
                    </p>

                </article>


                <article id="tab5">

                    <br>

                    <div class="col-xs-12">
                        <p class="text-justify">
                            <span><strong>Condiciones de Trabajo</strong> a las cuales se expone el cargo en
                                su
                                desempeño, tales
                                como:
                                estar en ambientes de oficina o los propios de un teatro, horario irregular
                                de trabajo,
                                jornadas
                                especiales o por turnos, llamadas de emergencia, presión de trabajo, quejas
                                o reclamos,
                                ambiente
                                con humedad, frío, calor, ruido, iluminación, vibración u otras condiciones.
                                Este factor
                                también
                                incluye la exposición a situaciones de riesgo que pueden afectar la
                                integridad física
                                del
                                ocupante del cargo. Comprende los siguientes sub. factores y grados:</span>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <div class="col-xs-12">
                        <p class="text-justify">
                            <span><strong>4.1 Condiciones ambientales:</strong> Se refiere a las condiciones
                                del
                                ambiente
                                de
                                trabajo donde se desenvuelve el cargo las cuales pueden ocasionar desagrado
                                o molestias
                                nocivas.</em><span class="required"> *</span></span>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <table class="table table-striped table-bordered dt-responsive table-sm" id="tblambiente">

                        <thead>
                            <tr>
                                <th class="text-center" scope="col" style="width:100px">GRADO</th>
                                <th class="text-center" scope="col" style="width:850px">SUBFACTOR</th>
                                <th class="text-center" scope="col">PUNTAJE</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th class="text-center" scope="row">1</th>
                                <td>
                                    <p class="text-justify"><strong>Poco afectado </strong>por las
                                        condiciones de
                                        trabajo
                                        presentes en un <strong>ambiente de oficina</strong>.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        10&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($ambiental == "10"){echo "checked";} ?> type="radio"
                                            name="radio_Cond[]" id="radio_Cond41" value="10">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify">Está <strong>afectado </strong>por las
                                        condiciones de
                                        trabajo
                                        presentes en un ambiente de <strong>taller, fábrica o
                                            laboratorio</strong>.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        20&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($ambiental == "20"){echo "checked";} ?> type="radio"
                                            name="radio_Cond[]" id="radio_Cond42" value="20">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">Frecuentemente puede estar <strong>muy afectado
                                        </strong>por
                                        condiciones mixtas, en donde ocasionalmente esta presente
                                        situaciones fuera del
                                        puesto
                                        de trabajo habitual, como se describe en el inicio del factor.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        30&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($ambiental == "30"){echo "checked";} ?> type="radio"
                                            name="radio_Cond[]" id="radio_Cond43" value="30">
                                    </div>
                                </td>
                            </tr>
                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio
                                        entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_Cond[]"
                                            id="radio_Cond44"
                                            <?php if($ambiental != "10" && $ambiental != "20" && $ambiental != "30"){echo "checked";} ?>
                                            value="0">
                                    </div>
                                </td>
                            </tr>
                            <!--Puntaje-->
                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <p class="text-right text-danger"><strong>PUNTAJE:</strong></p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="number" class="form-control input-sm" name="ambiental"
                                            id="ambiental" value="<?php echo $ambiental; ?>" readonly
                                            onchange="sumPuntaje()" style="width:70px"
                                            onfocusout="checkRangos('ambiental');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="conaErr"></div>


                    <div class="col-xs-12">
                        <p class="text-justify">
                            <span><strong>4.2 Riesgos: </strong>Evalúa el grado de exposición a situaciones
                                o hechos que
                                pueden
                                afectar la integridad física del ocupante del cargo, en cuanto a posibles
                                accidentes de
                                trabajo,
                                o enfermedades profesionales u otras contingencias.<span class="required">
                                    *</span></span>
                            </h5>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <table class="table table-striped table-bordered dt-responsive table-sm" id="tblriesgo">

                        <thead>
                            <tr>
                                <th class="text-center" scope="col" style="width:100px">GRADO</th>
                                <th class="text-center" scope="col" style="width:850px">SUBFACTOR</th>
                                <th class="text-center" scope="col">PUNTAJE</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th class="text-center" scope="row">1</th>
                                <td>
                                    <p class="text-justify">Exposición mínima u ocasional a riesgos.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        17&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($riesgo == "17"){echo "checked";} ?> type="radio"
                                            name="radio_Rsg[]" id="radio_Rsg41" value="17">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify">Exposición moderada a riesgos propios de las
                                        actividades que
                                        realice
                                        y del ambientedonde se desenvuelve.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        33&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($riesgo == "33"){echo "checked";} ?> type="radio"
                                            name="radio_Rsg[]" id="radio_Rsg42" value="33">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">Requiere apreciable y continuo esfuerzo y
                                        atención visual o
                                        auditiva
                                        para realizar tareas variadas o medianamente complejos.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        50&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($riesgo == "50"){echo "checked";} ?> type="radio"
                                            name="radio_Rsg[]" id="radio_Rsg43" value="50">
                                    </div>
                                </td>
                            </tr>
                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio
                                        entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_Rsg[]"
                                            id="radio_Rsg44"
                                            <?php if($riesgo != "17" && $riesgo != "33" && $riesgo != "50"){echo "checked";} ?>
                                            value="0">
                                    </div>
                                </td>
                            </tr>
                            <!--Puntaje-->
                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <p class="text-right text-danger"><strong>PUNTAJE:</strong></p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="number" class="form-control input-sm" name="riesgo" id="riesgo"
                                            value="<?php echo $riesgo; ?>" readonly style="width:70px"
                                            onchange="sumPuntaje()" onfocusout="checkRangos('riesgo');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="rsgErr"></div>


                </article>

                <input type='hidden' name='puntaje' id="puntaje" value="<?php echo $puntaje; ?>" class='form-control'
                    autocomplete="on">
                <input type='hidden' name='grado' id="grado" value="<?php echo $gradocargo; ?>" class='form-control'
                    autocomplete="on">


                <div class="col-md-12">
                    <br></br>
                    <div class="row">
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-dark" name="btn-save-val" id='btn-save-val'>
                                Guardar
                            </button>
                        </div>
                        <div class="col-md-1">
                            <a href="../cargos/?ca=1&val" class="btn btn-large btn-danger">
                                Volver</a>
                        </div>

                        <div class="col-md-3">

                        </div>

                        <?php
                    if($formatodetallado == 0)
                    { ?>
                        <div class="col-md-4">
                            <a href="#" class="btn btn-dark" onclick="usarformatodirecto()" name="btn-formato"
                                id='btn-formato'>
                                Usar Formato Directo</a>
                        </div>
                        <?php }
                    ?>


                    </div>
                </div>

            </div>


        </div>



</div> <!-- Aqui Termina el formao detallado -->
</div> <!-- Aqui Termina el formao detallado -->






</div>
</form>
<?php include_once ( '../layouts/footer.php' ); ?>

<script src="assets/js/valoracion-adm.js"></script>

<script type="text/javascript">
function usarformatodetallado() {

    $("#formatodirecto").hide();
    $('#formatodetallado').show();

}

function usarformatodirecto() {

    $("#formatodetallado").hide();
    $('#formatodirecto').show();

}
</script>