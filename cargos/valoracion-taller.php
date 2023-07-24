<?php include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; ?>
<link rel="stylesheet" href="assets/css/styles.css">
<script src="assets/js/main.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <div class="card text-left">
            <div class="card-header">
                <span style="font-weight: bold; font-size: 25px">Valoración de Puestos/Cargos: Planta - Taller - Fábrica</span>
            </div>
        </div>
    </section>

    <!-- Content Header (Page header) -->
    <section class="content-header">

        <div class="card text-left">

            <ul class="tabs">
                <li><a href="#tab1"><i class="fas fa-university"></i><span class="tab-text">Conocimientos</span></a></li>
                <li><a href="#tab2"><i class="fas fa-phone-laptop"></i><span class="tab-text">Responsabilidad
                            I</span></a>
                </li>
                <li><a href="#tab3"><i class="fas fa-sitemap"></i><span class="tab-text">Responsabilidad
                            II</span></a></li>
                <li><a href="#tab4"><i class="fas fa-weight-hanging"></i><span class="tab-text">Esfuerzo</span></a></li>
                <li><a href="#tab5"><i class="fas fa-user-injured"></i><span class="tab-text">Condiciones de
                            Trabajo</span></a></li>
            </ul>

        </div>

    </section>
    <!-- Content Header (Page header) -->

    <?php

include_once 'class.crud.php';
$crud = new crud();
$id_cargo = $_GET['idc'];
extract($crud->get_valoracion_taller($id_cargo));

?>


    <form id="form-valoracion-adm" action="save.php?vt&idc=<?php echo $_GET['idc']; ?>&ca=<?php echo $_GET['ca']; ?>" method="POST">
        <div class='container'>
            <div class="row">
                <div class="col-md-9">
                    <h4>Departamento: <?php echo $nombredepartamento ?></span> </h4>
                </div>
                <div class="col-md-3">

                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-9">
                    <h4>Puesto/Cargo: <?php echo $nombrecargo ?> </h4>
                </div>
                <div class="col-md-3">
                    <h4>Puntaje: <span id="puntajetotal" name="puntajetotal"><?php echo $puntaje; ?></span>
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
                        <span><strong>Conocimientos:</strong> Entendido como el aporte del raciocinio de cada persona para realizar el trabajo, y se
                                expresa a
                                través de categorías o sub factores conocidos, tales como: Educación, Experiencia y
                                Solución de
                                problemas. Es la demostración del conocimiento teórico y práctico. Contiene los
                                siguientes sub
                                factores, discriminados a su vez en grados.
                        </span>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <div class="col-xs-12">
                        <p class="text-justify">
                        <span> <strong>1.1 EDUCACION:</strong> Es la formación académica mínima y conocimientos
                                adquiridos a
                                través de distintas fuentes de instrucción, necesarios para desempeñar el cargo en forma
                                idónea.
                                Incluye desde la educación secundaria hasta la educación técnica Universitaria. <span
                                    style="color:red;">*</span></span>
                        </p>
                    </div> <!-- col-xs-12 -->



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
                                    <p class="text-justify"><strong>Bachillerato completo</strong> con conocimientos
                                        generales
                                        adquiridos y necesarios para realizar el trabajo.
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        40&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline" type="radio" name="radio_Edu[]"
                                            id="radio_Edu11" <?php if($educacion == "40"){echo "checked";} ?>
                                            value="40">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify">Bachillerato completo a nivel de <strong>Técnico
                                            Medio</strong>
                                        con mención en áreas diversas, tales como: mecánica, técnica, producción,
                                        electricidad, electrónica u otras; con conocimientos adquiridos y necesarios
                                        para ejecutar el trabajo.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        80&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline" type="radio" name="radio_Edu[]"
                                            id="radio_Edu12" <?php if($educacion == "80"){echo "checked";} ?>
                                            value="80">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">Educación <strong>técnica universitaria</strong>
                                        con conocimientos técnicos especializados en áreas diversas, tales como:
                                        mecánica, producción, electricidad, electrónica, tecnología, u otras, o su
                                        equivalente en años de estudios universitarios para optar a licenciatura
                                        similar.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        120&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline" type="radio" name="radio_Edu[]"
                                            id="radio_Edu14" <?php if($educacion == "120"){echo "checked";} ?>
                                            value="120">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_Edu[]"
                                            id="radio_Edu19"
                                            <?php if($educacion != "40" && $educacion != "80" && $educacion != "120"){echo "checked";} ?>
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
                                            id="educacion" value="<?php echo $educacion; ?>" readonly style="width:70px" onchange="sumPuntaje()"
                                            onfocusout="checkRangos('educacion');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                    <div class="col-xs-12">
                        <p class="text-justify">
                        <span><strong>1.2 EXPERIENCIA:</strong> Es el tiempo mínimo requerido para desempeñar el cargo
                                en forma idónea. No debe asociarse este factor con el tiempo de servicio o antigüedad
                                que posea la persona.<span class="required"> *</span></span>
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
                                        24&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline" type="radio" name="radio_Exp[]"
                                            id="radio_Exp11" <?php if($experiencia == "24"){echo "checked";} ?>
                                            value="24">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify">Más de uno (1) hasta dos (2) años.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        48&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline" type="radio" name="radio_Exp[]"
                                            id="radio_Exp12" <?php if($experiencia == "48"){echo "checked";} ?>
                                            value="48">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">Más de dos (2) hasta cinco (5) años.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        72&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($experiencia == "72"){echo "checked";} ?> type="radio"
                                            name="radio_Exp[]" id="radio_Exp13" value="72">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">4</th>
                                <td>
                                    <p class="text-justify">Más de seis (6) hasta nueve (9) años.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        96&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($experiencia == "96"){echo "checked";} ?> type="radio"
                                            name="radio_Exp[]" id="radio_Exp14" value="96">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">5</th>
                                <td>
                                    <p class="text-justify">Más de diez (10) años.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        120&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($experiencia == "120"){echo "checked";} ?> type="radio"
                                            name="radio_Exp[]" id="radio_Exp15" value="120">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_Exp[]"
                                            id="radio_Exp15"
                                            <?php if($experiencia != "24" && $experiencia != "48" && $experiencia != "72" && $experiencia != "96" && $experiencia != "120"){echo "checked";} ?>
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
                                            id="experiencia" value="<?php echo $experiencia; ?>" readonly onchange="sumPuntaje()"
                                            style="width:70px" onfocusout="checkRangos('experiencia');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="expErr"></div>

                    <div class="col-xs-12">
                        <p class="text-justify">
                        <span><strong>1.3 SOLUCIÓN DE PROBLEMAS:</strong> Se refiere a la capacidad mental para
                                identificar, definir y encontrar soluciones viables a situaciones o problemas inherentes
                                a la ejecución adecuada del trabajo.<span class="required"> *</span></span>
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
                                    <p class="text-justify">Requiere identificar y entender <strong>soluciones
                                            conocidas</strong> (existentes). Por lo general, las soluciones tienen como
                                        referencia situaciones similares de acuerdo con experiencias que han ocurrido
                                        antes, siguiendo técnicas, normas y procedimientos, manuales e instrucciones.
                                        Las reparaciones de equipos o maquinarias son rutinarias o de mantenimiento.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        46&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($problemas == "46"){echo "checked";} ?> type="radio"
                                            name="radio_Pro[]" id="radio_Pro11" value="46">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify">Requiere modificar o incorporar elementos de
                                        <strong>soluciones conocidas y adaptarlas a las nuevas situaciones</strong>,
                                        permitiendo más alternativas. Se requiere habilidad y buen nivel para
                                        reparaciones de maquinas y equipos.
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        93&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($problemas == "93"){echo "checked";} ?> type="radio"
                                            name="radio_Pro[]" id="radio_Pro12" value="93">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">Requiere de criterios técnicos especializados para la
                                        solución de reparaciones de equipos, adaptaciones mecánicas o eléctricas,
                                        <strong>búsqueda e investigación</strong> de elementos que deben considerarse
                                        para alcanzar soluciones originales. Enfrenta situaciones que requieren de
                                        pensamiento analítico, evaluativo e interpretativo. Las reparaciones complejas
                                        de equipos generan grandes ahorros para la empresa.
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        140&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($problemas == "140"){echo "checked";} ?> type="radio"
                                            name="radio_Pro[]" id="radio_Pro13" value="140">
                                    </div>
                                </td>
                            </tr>
                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_Pro[]"
                                            id="radio_Pro15"
                                            <?php if($problemas != "46" && $problemas != "93" && $problemas != "140"){echo "checked";} ?>
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
                                            id="problemas" value="<?php echo $problemas; ?>" readonly style="width:70px" onchange="sumPuntaje()"
                                            onfocusout="checkRangos('problemas');">
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
                        <span><strong>Responsabilidad:</strong> Entendida como el compromiso o capacidad de responder que exige el cargo al individuo,
                                ante obligaciones o circunstancias presentes en el entorno del trabajo, tales como:
                                información o bienes, uso de materiales, equipos, maquinarias o herramientas; relaciones
                                de trabajo, toma de decisiones.
                                </span>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <div class="col-xs-12">
                        <p class="text-justify">
                        <span><strong>2.1 RESPONSABILIDAD POR EQUIPOS, MAQUINARIAS, HERRAMIENTAS O
                                    MATERIALES:</strong> Evalúa las relaciones dentro y/o fuera de la
                                institución, necesarias para el desempeño del cargo. Considérese la naturaleza de la
                                relación, con quién se mantiene contacto y la importancia que tiene para la
                                institución.<span class="required"> *</span></span>
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
                                    <p class="text-justify"><strong>Poca </strong> responsabilidad por el uso y cuidado
                                        de equipos, maquinarias, herramientas o material, sistemas eléctricos,
                                        computadoras
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        66&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($maquinarias == "66"){echo "checked";} ?> type="radio"
                                            name="radio_RespMq[]" id="radio_RespMq21" value="66" autofocus>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify"><strong>Apreciable responsabilidad</strong> por el uso y
                                        cuidado de equipos, maquinarias, herramientas o materiales, sistemas eléctricos,
                                        computadoras y su posible daño, deterioro o sustracción puede ocasionar pérdidas
                                        a la institución.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        133&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($maquinarias == "133"){echo "checked";} ?> type="radio"
                                            name="radio_RespMq[]" id="radio_RespMq22" value="133">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify"><strong>Muy apreciable</strong>
                                        responsabilidad por el uso y cuidado de equipos, maquinarias, herramientas o
                                        materiales, sistemas eléctricos, computadoras y su posible daño, deterioro o
                                        sustracción puede ocasionar grandes pérdidas a la institución.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        200&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($maquinarias == "200"){echo "checked";} ?> type="radio"
                                            name="radio_RespMq[]" id="radio_RespMq23" value="200">
                                    </div>
                                </td>
                            </tr>
                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_RespMq[]"
                                            id="radio_RespMq24"
                                            <?php if($maquinarias != "66" && $maquinarias != "133" && $maquinarias != "200"){echo "checked";} ?>
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
                                            id="maquinarias" value="<?php echo $maquinarias; ?>" readonly onchange="sumPuntaje()"
                                            style="width:70px" onfocusout="checkRangos('maquinarias');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="supErr"></div>

                    <div class="col-xs-12">
                        <p class="text-justify">
                        <span><strong>2.2 RESPONSABILIDAD POR CONTACTOS INTERNOS Y EXTERNOS:</strong> Evalúa las
                                relaciones dentro y/o fuera de la institución, necesarias para el desempeño del cargo.
                                Considérese la naturaleza de la relación, con quién se mantiene contacto y la
                                importancia que tiene para la institución.<span class="required">
                                *</span></span>
                        </h5>
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
                                    <p class="text-justify"><strong>Contactos de rutina</strong> con personas de otras
                                        áreas, dando o recibiendo información. Requiere simple cortesía. Poco o ningún
                                        contacto externo. Los contactos y su frecuencia no son un elemento importante
                                        del trabajo.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        17&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($contactos == "17"){echo "checked";} ?> type="radio"
                                            name="radio_RespCon[]" id="radio_RespCon21" value="17">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify"><strong>Contactos frecuentes</strong> con personas de otras
                                        áreas, o externas a la institución. Implica obtener, dar o consultar datos.
                                        Requiere cierto tacto, trato cortés y conocimiento de normas y procedimientos
                                        internos. Los contactos son un elemento importante del trabajo.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        33&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($contactos == "33"){echo "checked";} ?> type="radio"
                                            name="radio_RespCon[]" id="radio_RespCon22" value="33">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify"><strong>El contacto</strong> o trato con personas dentro y
                                        fuera de la institución es parte importante en el desempeño del cargo, tiene
                                        carácter frecuente. <strong>Implica manejo de información técnica,</strong>
                                        persuasión, acuerdos importante, cooperación, intercambio. Requiere mucho tacto
                                        y discreción. La forma de asumir los contactos puede afectar la imagen de la
                                        institución.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        50&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($contactos == "50"){echo "checked";} ?> type="radio"
                                            name="radio_RespCon[]" id="radio_RespCon23" value="50">
                                    </div>
                                </td>
                            </tr>
                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_RespCon[]"
                                            id="radio_RespCon25"
                                            <?php if($contactos != "17" && $contactos != "33" && $contactos != "50"){echo "checked";} ?>
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
                                            id="contactos" value="<?php echo $contactos; ?>" readonly style="width:70px" onchange="sumPuntaje()"
                                            onfocusout="checkRangos('contactos');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="finErr"></div>


                </article>


                <article id="tab3">

                    <br>


                    <div class="col-xs-12">
                        <p class="text-justify">
                        <span><strong>Responsabilidad II:</strong> Entendida como el compromiso o capacidad de responder que exige el cargo al individuo,
                                ante obligaciones o circunstancias presentes en el entorno del trabajo, tales como:
                                información o bienes, uso de materiales, equipos, maquinarias o herramientas; relaciones
                                de trabajo, toma de decisiones.
                                </span>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <div class="col-xs-12">
                        <p class="text-justify">
                        <span><strong>2.3 RESPONSABILIDAD POR TOMA DE DECISIONES:</strong>
                                Evalúa la capacidad de elegir una vía de acción determinada, con el consiguiente riesgo
                                y
                                responsabilidad que implica dicha acción. Considérese la facultad de decidir con un “si”
                                o
                                un “no”, es accionar o no hacia determinada dirección. Se asociará con la consecuencia
                                que
                                implica y no con solución de problemas o iniciativa. Este sub. Factor enfatiza sobre
                                cargos
                                a los cuales se le ha delegado autoridad, en menor o mayor grado.<span
                                class="required"> *</span></span>
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
                                    <p class="text-justify">Mínima responsabilidad por decisiones, no ocasionan
                                        dificultad para prever las consecuencias de las mismas. Revisten poco o ningún
                                        riesgo, además se encuentran sujetas a revisiones o aprobaciones de una
                                        autoridad superior.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        6&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($decisiones == "6"){echo "checked";} ?> type="radio"
                                            name="radio_RespDec[]" id="radio_RespDec21" value="6">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify">Responsabilidad por decisiones donde existe cierta
                                        dificultad para prever sus consecuencias, afectan una unidad de trabajo y
                                        revisten cierto riesgo.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        14&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($decisiones == "14"){echo "checked";} ?> type="radio"
                                            name="radio_RespDec[]" id="radio_RespDec22" value="14">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">
                                        Responsabilidad por decisiones donde las consecuencias de las acciones tomadas
                                        afectan varias unidades de trabajo en cuanto a personas, costos y actividades.
                                        Son decisiones que están sujetas a la revisión del superior inmediato, revisten
                                        cierto grado de nulidad o posibilidad de ser reconsideradas.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        20&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($decisiones == "20"){echo "checked";} ?> type="radio"
                                            name="radio_RespDec[]" id="radio_RespDec23" value="20">
                                    </div>
                                </td>
                            </tr>
                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_RespDec[]"
                                            id="radio_RespDec24"
                                            <?php if($decisiones != "6" && $decisiones != "14" && $decisiones != "20"){echo "checked";} ?>
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
                                            id="decisiones" value="<?php echo $decisiones; ?>" readonly onchange="sumPuntaje()"
                                            style="width:70px" onfocusout="checkRangos('decisiones');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="maqErr"></div>


                    <div class="col-xs-12">
                        <p class="text-justify">
                        <span><strong>2.4 Responsabilidad por información valiosa o confidencial: </strong> Considera
                                la responsabilidad por manejo o acceso a información valiosa, sensible o confidencial
                                cuyo uso indebido o revelación podría causar perjuicios a la institución. Se toma en
                                cuenta el grado de acceso y posibles efectos por su divulgación o manejo inapropiado.
                           <span class="required"> *</span></span>
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
                                    <p class="text-justify"><strong>No requiere</strong> manejar información valiosa o
                                        maneja ocasionalmente información valiosa, o sensible o confidencial, cuya
                                        revelación o uso indebido produciría trastornos menores, disgusto o malestar.
                                        Esta información es del conocimiento de otras personas.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        6&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($informacion == "6"){echo "checked";} ?> type="radio"
                                            name="radio_RespInf[]" id="radio_RespInf21" value="6">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify"><strong>Maneja regularmente </strong> información valiosa, o
                                        sensible o confidencial, cuya revelación o uso inapropiado produciría trastornos
                                        internos o trastornos de importancia en lo económico, financiero, prestigio de
                                        la institución y demás intereses.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        14&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($informacion == "14"){echo "checked";} ?> type="radio"
                                            name="radio_RespInf[]" id="radio_RespInf22" value="14">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify"><strong>Maneja continuamente información valiosa,</strong> o
                                        sensible o confidencial, cuya revelación o uso inapropiado puede perjudicar los
                                        diversos intereses e imagen de la institución.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        20&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($informacion == "20"){echo "checked";} ?> type="radio"
                                            name="radio_RespInf[]" id="radio_RespInf23" value="20">
                                    </div>
                                </td>
                            </tr>
                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_RespInf[]"
                                            id="radio_RespInf25"
                                            <?php if($informacion != "6" && $informacion != "14" && $informacion != "20" && $decisiones != "80"){echo "checked";} ?>
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
                                <td class="text-center">5
                                    <div class="form-check">
                                        <input type="number" class="form-control input-sm" name="informacion"
                                            id="informacion" value="<?php echo $informacion; ?>" readonly onchange="sumPuntaje()"
                                            style="width:70px" onfocusout="checkRangos('informacion');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="decErr"></div>


                </article>


                <article id="tab4">

                    <br>

                    <div class="col-xs-12">
                        <p class="text-justify">
                        <span><strong>Esfuerzo:</strong> Entendida como la energía o rigor requerido para realizar adecuadamente el trabajo,
                            considerandose el grado de energía corporal y la atención mental en términos de intensidad,
                            duración y frecuencia. Contiene los siguientes subfactores: 
                        </span>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <div class="col-xs-12">
                        <p class="text-justify">
                        <span><strong>3.1 ESFUERZO FÍSICO:</strong>
                                Mide el grado de energía física requerida para
                                realizar el trabajo en términos de posiciones corporales, movilización de un sitio a
                                otro, manejo de objetos, operación de equipos u otros actos o movimientos.<span
                                class="required"> *</span></span>
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
                                    <p class="text-justify">Se requiere <strong>mínimo esfuerzo físico</strong>. No se
                                        produce
                                        fatiga al ejecutar el trabajo.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        20&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($esfuerzo == "20"){echo "checked";} ?> type="radio"
                                            name="radio_Esff[]" id="radio_Esff31" value="20">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify">Se requiere <strong>esfuerzo moderado</strong> y no
                                        continuado,
                                        por
                                        uso de máquinas, equipos, mecanismos; por permanencia de pie, por trabajos que
                                        impliquen
                                        elevación, traslado de un sitio a otro, levantamiento de objetos o materiales de
                                        poco
                                        volumen o peso. Se produce fatiga moderada.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        40&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($esfuerzo == "40"){echo "checked";} ?> type="radio"
                                            name="radio_Esff[]" id="radio_Esff32" value="40">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">Se requiere <strong>mayor esfuerzo en forma
                                            frecuente</strong>,
                                        continuada y prolongada. Se produce fatiga continua y moderada por levantar y
                                        transportar objetos de poco o mayor volumen o peso, operar equipos, máquinas o
                                        herramientas, operar mecanismos, trabajar en posiciones incómodas o trabajar
                                        sostenidamente en posiciones de pie, realizar trabajos que impliquen elevación.
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        60&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($esfuerzo == "60"){echo "checked";} ?> type="radio"
                                            name="radio_Esff[]" id="radio_Esff33" value="60">
                                    </div>
                                </td>
                            </tr>
                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_Esff[]"
                                            id="radio_Esff24"
                                            <?php if($esfuerzo != "20" && $esfuerzo != "40" && $esfuerzo != "60"){echo "checked";} ?>
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
                                            value="<?php echo $esfuerzo; ?>" readonly style="width:70px" onchange="sumPuntaje()"
                                            onfocusout="checkRangos('esfuerzo');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="fisErr"></div>

                    <div class="col-xs-12">
                        <p class="text-justify">
                        <span><strong>3.2 Esfuerzo mental:</strong> Se refiere al grado de energía psíquica que exige
                                la ejecución del trabajo, en términos de concentración, atención y coordinación de
                                ideas, siguiendo criterios de intensidad, duración y frecuencia<span
                                class="required"> *</span></span>
                        </h5>
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
                                        12&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($mental == "12"){echo "checked";} ?> type="radio"
                                            name="radio_Esfm[]" id="radio_Esfm31" value="12">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify">Requiere <strong>moderado esfuerzo o concentración mental
                                        </strong> para realizar tareas variadas no rutinarias.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        24&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($mental == "24"){echo "checked";} ?> type="radio"
                                            name="radio_Esfm[]" id="radio_Esfm32" value="24">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">Requiere <strong>apreciable esfuerzo o concentración mental
                                        </strong> para realizar trabajos bastantes variados y complejos.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        36&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($mental == "36"){echo "checked";} ?> type="radio"
                                            name="radio_Esfm[]" id="radio_Esfm33" value="36">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">4</th>
                                <td>
                                    <p class="text-justify">Requiere <strong>considerable esfuerzo y concentración
                                            mental</strong> para realizar trabajos bastantes variados y complejos.
                                        Requiriendo frecuente coordinación de ideas, concentración mental y esfuerzo
                                        continuo para planear y desarrollar actividades.</p>
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
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_Esfm[]"
                                            id="radio_Esfm35"
                                            <?php if($mental != "12" && $mental != "24" && $mental != "36" && $mental != "60"){echo "checked";} ?>
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
                                            value="<?php echo $mental; ?>" readonly style="width:70px" onchange="sumPuntaje()"
                                            onfocusout="checkRangos('mental');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="menErr"></div>

                    <div class="col-xs-12">
                        <p class="text-justify">
                        <span><strong>3.3 Esfuerzo sensorial:</strong> Se refiere a la atención visual y/o auditiva
                                que exige la ejecución del trabajo, en términos de la intensidad y grado de continuidad
                                del esfuerzo realizado con los ojos o con los oídos. Considérese el reconocer o
                                discriminar elementos o instrumentos fijos o en movimiento, así como distinguir entre
                                tono, intensidad o calidad de los sonidos, ya sea combinados o un sonido particular.
                            <span class="required"> *</span></span>
                
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
                                    <p class="text-justify">Requiere <strong>mínimo esfuerzo o atención</strong>, ya sea
                                        visual
                                        o auditivo, para realizar tareas sencillas.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        12&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($sensorial == "12"){echo "checked";} ?> type="radio"
                                            name="radio_Esfs[]" id="radio_Esfs31" value="12">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify"><strong>Requiere moderado esfuerzo o atención</strong>
                                        visual o
                                        auditiva, para realizar tareas variadas no rutinarias. Puede ocasionalmente
                                        incrementarse.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        24&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($sensorial == "24"){echo "checked";} ?> type="radio"
                                            name="radio_Esfs[]" id="radio_Esfs32" value="24">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">Requiere <strong>apreciable y continuo esfuerzo y
                                            atención</strong>
                                        visual o auditiva para realizar tareas variadas o medianamente complejos.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        36&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($sensorial == "36"){echo "checked";} ?> type="radio"
                                            name="radio_Esfs[]" id="radio_Esfs33" value="36">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">4</th>
                                <td>
                                    <p class="text-justify">Requiere <strong>muy apreciable y continuo esfuerzo o
                                            atención</strong> visual o auditiva para realizar trabajos medianamente
                                        complejos o
                                        complejos. Los ojos o los oídos pueden resentirse.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        60&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($sensorial == "60"){echo "checked";} ?> type="radio"
                                            name="radio_Esfs[]" id="radio_Esfs34" value="60">
                                    </div>
                                </td>
                            </tr>
                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_Esfs[]"
                                            id="radio_Esfs35"
                                            <?php if($sensorial != "12" && $sensorial != "24" && $sensorial != "36" && $sensorial != "60"){echo "checked";} ?>
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
                                            id="sensorial" value="<?php echo $sensorial; ?>" readonly style="width:70px" onchange="sumPuntaje()"
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
                        <span> Mide las <strong>Condiciones de Trabajo</strong> a las cuales se expone el cargo en su desempeño, tales
                                como: estar en ambientes de fábrica o los propios de un taller o planta industrial,
                                horario irregular de trabajo, jornadas especiales o por turnos, llamadas de emergencia,
                                presión de trabajo, quejas o reclamos, ambiente con humedad, frío, calor, ruido,
                                iluminación, vibración u otras condiciones. Este factor también incluye la exposición a
                                situaciones de riesgo que pueden afectar la integridad física del ocupante del cargo.
                                Comprende los siguientes subfactores y grados:</span>
                        </p>
                    </div> <!-- col-xs-12 -->

                    <div class="col-xs-12">
                        <p class="text-justify">
                        <span><strong>3.1 CONDICIONES AMBIENTALES:</strong>
                                Se refiere a las condiciones del ambiente
                                de trabajo donde se desenvuelve el cargo las cuales pueden ocasionar desagrado o
                                molestias nocivas</em><span class="required"> *</span></span>
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
                                    <p class="text-justify"><strong>Poco afectado </strong>por las condiciones de
                                        trabajo
                                        presentes en un <strong>ambiente de oficina</strong>.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        20&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($ambiental == "20"){echo "checked";} ?> type="radio"
                                            name="radio_Cond[]" id="radio_Cond41" value="20">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify">Está <strong>afectado </strong>por las condiciones de
                                        trabajo
                                        presentes en un ambiente de <strong>taller, fábrica o laboratorio</strong>.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        40&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($ambiental == "40"){echo "checked";} ?> type="radio"
                                            name="radio_Cond[]" id="radio_Cond42" value="40">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">Frecuentemente puede estar <strong>muy afectado </strong>por
                                        condiciones mixtas, en donde ocasionalmente esta presente situaciones fuera del
                                        puesto
                                        de trabajo habitual, como se describe en el inicio del factor.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        60&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($ambiental == "60"){echo "checked";} ?> type="radio"
                                            name="radio_Cond[]" id="radio_Cond43" value="60">
                                    </div>
                                </td>
                            </tr>
                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_Cond[]"
                                            id="radio_Cond44"
                                            <?php if($ambiental != "20" && $ambiental != "40" && $ambiental != "60"){echo "checked";} ?>
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
                                            id="ambiental" value="<?php echo $ambiental; ?>" readonly style="width:70px" onchange="sumPuntaje()"
                                            onfocusout="checkRangos('ambiental');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="conaErr"></div>


                    <div class="col-xs-12">
                        <p class="text-justify">
                        <span><strong>4.2 Riesgos: </strong>Evalúa el grado de exposición a situaciones o hechos que
                                pueden afectar la integridad física del ocupante del cargo, en cuanto a posibles
                                accidentes de trabajo, o enfermedades profesionales u otras contingencias.<span
                                class="required"> *</span></span>
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
                                        30&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($riesgo == "30"){echo "checked";} ?> type="radio"
                                            name="radio_Rsg[]" id="radio_Rsg41" value="30">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">2</th>
                                <td>
                                    <p class="text-justify">Exposición moderada a riesgos propios de las actividades que
                                        realice
                                        y del ambientedonde se desenvuelve.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        60&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($riesgo == "60"){echo "checked";} ?> type="radio"
                                            name="radio_Rsg[]" id="radio_Rsg42" value="60">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">3</th>
                                <td>
                                    <p class="text-justify">Requiere apreciable y continuo esfuerzo y atención visual o
                                        auditiva
                                        para realizar tareas variadas o medianamente complejos.</p>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        90&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                            class="form-check-input radio-inline"
                                            <?php if($riesgo == "90"){echo "checked";} ?> type="radio"
                                            name="radio_Rsg[]" id="radio_Rsg43" value="90">
                                    </div>
                                </td>
                            </tr>
                            <!--Promedio-->
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td>
                                    <p class="text-right text-primary">Puede asignar puntaje intermedio entre dos
                                        sub-factores.
                                        <i class="fa fa-hand-o-right" aria-text="true"></i>
                                </td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input radio-inline" type="radio" name="radio_Rsg[]"
                                            id="radio_Rsg44"
                                            <?php if($riesgo != "30" && $riesgo != "60" && $riesgo != "90"){echo "checked";} ?>
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
                                        <input type="number" class="form-control input-sm" name="riesgo" id="riesgo" onchange="sumPuntaje()"
                                            value="<?php echo $riesgo; ?>" readonly style="width:70px"
                                            onfocusout="checkRangos('riesgo');">
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="error" id="rsgErr"></div>


                </article>

                <input type='hidden' name='puntaje' id="puntaje" value="<?php echo $puntaje; ?>" class='form-control'
                    required autocomplete="on">

                <div class="col-md-12">
                    <br></br>
                    <button type="submit" class="btn btn-dark" name="btn-save-val" id='btn-save-val'>
                        Guardar
                    </button>
                    <a href="../es/?idc=" class="btn btn-large btn-danger">
                        Volver</a>
                </div>
            </div>






        </div>
    </form>
    <?php include_once ( '../layouts/footer.php' ); ?>

    <script src="assets/js/valoracion-taller.js"></script>