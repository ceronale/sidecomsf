<?php 
if ($_GET['ca'] == 1) {
    if(isset($_GET['new']))
    {
        $seccion = 'p_cargos_adm';
    }
    if(isset($_GET['des']))
    {
        $seccion = 'p_descripcion_adm';
    }
    if(isset($_GET['val']))
    {
        $seccion = 'p_valoracion_adm';
    }
   
    }
if ($_GET['ca'] == 2) {
    if(isset($_GET['new']))
    {
        $seccion = 'p_cargos_taller';
    }
    if(isset($_GET['des']))
    {
        $seccion = 'p_descripcion_taller';
    }
    if(isset($_GET['val']))
    {
        $seccion = 'p_valoracion_taller';
    }
}
include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; ?>
<link rel="stylesheet" href="../assets/css/stylebuttons.css">
<style>
/* Adjust the width of the buttons */
.dt-buttons {
    flex: 2;
    /* Occupy two-thirds of the available space */
    text-align: right;
    /* Align the buttons to the right */
}
</style>
<?php
if (isset($_GET['ca'])) {
    if ($_GET['ca'] == 1) {
        $categ = "Puestos/Cargos: Administrativos";
        $info = "Un <b>Cargo</b> es un conjunto de funciones, tareas y operaciones específicas representativas, relacionadas con la actividad laboral, cuyo ejercicio conlleva responsabilidades, conocimientos y habilidades para su desempeño.<br><br>Un <b>Puesto</b> Se refiere a la ubicación física de un determinado Cargo dentro de la jerarquía y dentro del espacio físico donde se desempeña la persona. Con el avance de la tecnología, los puestos de trabajo no tienen en muchos casos, espacio físico, el trabajo es realizado en forma virtual, en cualquier espacio físico, a cualquier hora y en cualquier lugar o ciudad. En la práctica, hemos observado que empresas privadas consideran el Puesto como sinónimo de Cargo, aunque técnicamente no es lo mismo.";
    } else {
        $categ = "Puestos/Cargos: Planta - Taller - Fábrica";
        $info = "Un <b>Cargo</b> es un conjunto de funciones, tareas y operaciones específicas representativas, relacionadas con la actividad laboral, cuyo ejercicio conlleva responsabilidades, conocimientos y habilidades para su desempeño.<br><br>Un <b>Puesto</b> Se refiere a la ubicación física de un determinado Cargo dentro de la jerarquía y dentro del espacio físico donde se desempeña la persona. Con el avance de la tecnología, los puestos de trabajo no tienen en muchos casos, espacio físico, el trabajo es realizado en forma virtual, en cualquier espacio físico, a cualquier hora y en cualquier lugar o ciudad. En la práctica, hemos observado que empresas privadas consideran el Puesto como sinónimo de Cargo, aunque técnicamente no es lo mismo.<br><br>No incluyen supervisores o cualquier otra actividad administrativa aunque laboren en planta, industria o taller.";
    }
}

if (isset($_GET['des'])) {
    if ($_GET['ca'] == 1) {
        $categ = "Descripción de Puestos/Cargos: Administrativos";
    } else {
        $categ = "Descripción de Puestos/Cargos: Planta - Taller - Fábrica";
    }
    $info = "Es un documento donde se registra formalmente el propósito, las funciones, tareas y requisitos de cada puesto/cargo en una empresa u organización, es además fuente de información para la selección, capacitación, incentivos, seguridad ocupacional y administración de los sueldos.";

}

if (isset($_GET['val'])) {
    if ($_GET['ca'] == 1) {
        $categ = "Valoración de Puestos/Cargos Administrativos";
    } else {
        $categ = "Valoración de Puestos/Cargos Planta - Taller - Fábrica";
    }
    $info = "La valoración permite establecer una jerarquía, si comparamos cada puesto/cargo con un conjunto de factores que impactan de manera diferente. Como consecuencia de esta jerarquización se establece la remuneración, para cada posición. <strong> A MAYOR RESPONSABILIDAD Y RESULTADO, MAYOR REMUNERACIÓN</strong>";

}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="card text-left">
            <div class="card-header">
                <span style="font-weight: bold; font-size: 25px; color: #3c8dbc; cursor: pointer;"
                    onclick="info_tabla('<?= $categ; ?>','<?php echo $info; ?>')"><?= $categ; ?></span>

            </div>
        </div>
    </section>
    <!-- Content Header (Page header) -->

    <?php
    include_once 'class.crud.php';
    $crud = new crud();
    $departamentos = $crud->get_departamentos($_GET['ca']);
    $user = $_SESSION['user'];
    $grados_administrativos = $crud->get_grados_administrativos($user['id_empresa']);
    $grados_taller = $crud->get_grados_taller($user['id_empresa']);
    $categoriax = $_GET['ca'];

    if ($categoriax == 1) {
        $grados = $grados_administrativos;
    } else {
        $grados = $grados_taller;
    }

    if (isset($_GET['inserteddes'])) {
    ?>
    <script>
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'La descripción de cargo se ha registrado con exito!',
        showConfirmButton: false,
        timer: 3000
    })
    </script>
    <?php
    }
    if (isset($_GET['faildes'])) {
    ?>
    <script>
    Swal.fire({
        position: 'top-end',
        icon: 'error',
        title: 'Error al registrar la descripción del cargo',
        showConfirmButton: false,
        timer: 3000
    })
    </script>
    <?php
    }
    if (isset($_GET['inserted'])) {
    ?>
    <script>
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'El cargo se ha registrado con exito!',
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
        title: 'Error al registrar el Cargo!',
        showConfirmButton: false,
        timer: 3000
    })
    </script>
    <?php
    }

    if (isset($_GET['edited'])) {
    ?>
    <script>
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'El cargo se ha editado con exito!',
        showConfirmButton: false,
        timer: 3000
    })
    </script>
    <?php
    }
    if (isset($_GET['failureedited'])) { ?>
    <script>
    Swal.fire({
        position: 'top-end',
        icon: 'error',
        title: 'Error al editar el cargo!',
        showConfirmButton: false,
        timer: 3000
    })
    </script>
    <?php
    }
    if (isset($_GET['failureSameCargo'])) { ?>
    <script>
    Swal.fire({
        position: 'top-end',
        icon: 'error',
        title: 'Puesto/Cargo repetido',
        showConfirmButton: false,
        timer: 3000
    })
    </script>
    <?php
    }


    ?>


    <script>
    $(document).ready(function() {
        $('#example').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
            },
            dom: "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'f><'col-sm-12 col-md-4'B>>" +
                "<'row'<'col-sm-12't>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [{
                    extend: 'excel',
                    className: 'btn btn-primary btn3d'
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-primary btn3d'
                },
                {
                    extend: 'print',
                    className: 'btn btn-primary btn3d'
                }
            ],
            'iDisplayLength': 50,
        });


    });
    </script>

    <?php if (isset($_GET['val'])) { ?>

    <div id="texto-valoracion" style="">
        <div class='container' style="overflow: auto; max-height: 600px;">
            <div class="row row-col-8">
                <div class="col">
                    <a href='#' onclick="mostrar_ocultar_texto()" class='btn btn-primary btn3d'> &nbsp;
                        Menu</a>
                </div>
            </div>
            <h4><strong>VALORACIÓN DE PUESTOS O CARGOS</strong></h4>
            <br>
            <div style="font-size: 16px"><strong>PASOS A SEGUIR:</strong>
                <br><br>
                <ol>
                    <li>
                        <p class="text-justify"> Nombrar un comité de valoración, integrado por personas conocedoras de
                            la organización y los puestos de trabajo, recomendable de 3 a 7 miembros incluido un asesor
                            externo (si lo desea)</p>
                    </li>
                    <br>
                    <li>
                        <p class="text-justify"> Elaborar lista de cargos que necesiten valorar.</p>
                    </li>
                    <br>
                    <li>
                        <p class="text-justify"> Cada miembro del comité de valoración con el análisis de las
                            Descripciones de Cargos, estará en conocimiento para asignar la puntuación en cada
                            sub-factor en el Sistema de Valoración, hasta obtener el total de puntos en una escala de
                            uno (1) a mil (1.000).</p>
                    </li>
                    <br>
                    <li>
                        <p class="text-justify"> <strong>Si el comité lo decide</strong>, podrá asignar puntajes
                            intermedios entre un sub-factor y otro, según la apreciación de sus miembros.</p>
                    </li>
                    <br>
                    <li>
                        <p class="text-justify"> La valoración de cada cargo, debe contar con el consenso de todos los
                            miembros.</p>
                    </li>
                    <br>
                    <li>
                        <p class="text-justify"> Una vez valorados en el sistema, el resultado se reflejara en la MATRIZ
                            DE DATOS.</p>
                    </li>
                </ol>

                <br>
                <h5>
                    <p class="text-center"><i class="fa fa-envelope"></i> Para consulta con nuestros Asesores
                        escríbenos a: <a href="mailto:asesoresrrhh.eventos@gmail.com">asesoresrrhh.eventos@gmail.com
                            </<i></a></p>
                </h5>
            </div>
        </div>
    </div>

    <?php }; ?>
    <?php if (isset($_GET['val'])) { ?>
    <div id="tabla-valoracion" style=" display:none;">
    <?php } ?>
        <div class='container' style="overflow: auto; max-height: 600px;">

            <div class="row row-col-8">
                <?php if (isset($_GET['new'])) { ?>
                <div class="col">
                    <a href='#'
                        onclick="crear_cargo(<?php echo htmlspecialchars(json_encode($departamentos)); ?>,<?php echo ($categoriax); ?>)"
                        class='btn btn-primary btn3d'> &nbsp;
                        Agregar Puesto/Cargo</a>
                </div>

                <?php  } ?>
            </div>

            <div class='clearfix'></div><br />
                <table id="example" class="table table-striped dt-responsive nowrap" style="width:100%">   
                <thead style="position: sticky; top: 0; background-color: white;">
                    <tr>
                        <th>Departamento</th>
                        <th>Puesto/Cargo</th>
                        <?php if (isset($_GET['val'])) { ?>
                        <th>Grado</th>
                        <th>Puntaje</th>
                        <?php } ?>
                        <th>Status</th>
                        <?php if (isset($_GET['new'])) { ?>
                        <th style="text-align: center;">Acción</th>
                        <?php } ?>

                        <?php if (isset($_GET['des'])) { ?>
                        <th style="text-align: center;">Formato de Descripción</th>
                        <?php } ?>

                        <?php if (isset($_GET['val'])) { ?>
                        <th style="text-align: center;">Formato de Valoración</th>
                        <?php } ?>


                    </tr>
                </thead>
                <tbody>
                    <?php
                    $categoria = $_GET['ca'];

                    $cargos = $crud->dataview_cargos($categoria);

                    if ($cargos != null) {
                        foreach ($cargos as $cargo) {
                    ?>
                    <tr>
                        <td style="white-space: normal;"><?php print($cargo['nombre_departamento']); ?></td>
                        <td style="white-space: normal;"><?php print($cargo['nombre']); ?></td>
                        <?php if (isset($_GET['val'])) { ?>
                        <td>
                            <span style="opacity: .0;">
                                <?php                        
                                    switch ($cargo['grado']) {
                                        case 'I':
                                            echo "a";
                                            break;
                                        case 'II':
                                            echo "b";
                                            break;
                                        case 'III':
                                            echo "c";
                                            break;
                                        case 'IV':
                                            echo "d";
                                            break;    
                                        case 'V':
                                            echo "e";
                                            break;
                                        case 'VI':
                                            echo "f";
                                            break;
                                        case 'VII':
                                            echo "g";
                                            break;
                                        case 'VIII':
                                            echo "h";
                                            break;
                                        case 'IX':
                                            echo "i";
                                            break;    
                                        case 'X':
                                            echo "j";
                                            break;
                                        case 'XI':
                                            echo "k";
                                            break;
                                        case 'XII':
                                            echo "l";
                                            break;
                                        case 'XIII':
                                            echo "m";
                                            break;
                                        case 'XIV':
                                            echo "n";
                                            break;   
                                        case 'XV':
                                            echo "o";
                                            break;                                                                  
                                    }?>
                            </span>
                            <?php print($cargo['grado']); ?>
                        </td>
                        <td><?php print($cargo['puntaje']); ?></td>
                        <?php } ?>
                        <td>
                            <?php if ($cargo['status'] == "1") {
                                        print "Activo";
                                    } else {
                                        print "Inactivo";
                                    } ?>
                        </td>

                        <td style="text-align: center">

                            <?php if (isset($_GET['new'])) { 
                            $descripcargo =  str_replace(PHP_EOL, ';' ,$cargo['descripcion']);
                            ?>

                            <a onclick="editar_cargo('<?php echo htmlspecialchars($cargo['id']); ?>',
                                    '<?php echo htmlspecialchars($cargo['nombre']); ?>',
                                    '<?php echo htmlspecialchars($cargo['id_departamento']); ?>',
                                    '<?php echo htmlspecialchars($cargo['categoria']); ?>',
                                    '<?php echo htmlspecialchars($cargo['status']); ?>',
                                    '<?php echo htmlspecialchars($descripcargo); ?>',
                                    '<?php echo addslashes(htmlspecialchars(json_encode($departamentos))); ?>')"
                                title="Editar Cargo">
                                <i class='fa fa-pencil' aria-hidden='true'></i></a>

                            &nbsp;&nbsp;&nbsp;&nbsp;

                            <a onclick="eliminar_cargo('<?php print($cargo['id']) ?>','<?php print($cargo['nombre']) ?>','<?php print($cargo['categoria']) ?>')"
                                title="Eliminar Cargo">
                                <i class="fa fa-trash" aria-hidden="true"></i></a>

                            <?php  } ?>

                            <?php if (isset($_GET['val'])) { ?>

                            <?php if ($_GET['ca'] == 1) { ?>
                            <a href="valoracion-adm?idc=<?= $cargo['id']; ?>&ca=<?= $cargo['categoria']; ?>"
                                title="Valorar Cargo">
                                <i class="fa fa-list-ol" aria-hidden="true" style="color:black"></i></a>
                            <?php  } ?>

                            <?php if ($_GET['ca'] == 2) { ?>
                            <a href="valoracion-taller?idc=<?= $cargo['id']; ?>&ca=<?= $cargo['categoria']; ?>"
                                title="Valorar Cargo">
                                <i class="fa fa-list-ol" aria-hidden="true" style="color:black"></i></a>

                            <?php }
                                    } ?>

                            <?php if (isset($_GET['des'])) { ?>

                            <?php if ($_GET['ca'] == 1) { ?>
                            <a href="descripcion-cargo-administrativo.php?id=<?= $cargo['id']; ?>&nombre=<?= $cargo['nombre']; ?>&departamento=<?= $cargo['nombre_departamento']; ?>&empresa=<?= $cargo['nombre_empresa']; ?>"
                                title="Describir Cargo">
                                <i class="fa fa-align-justify" aria-hidden="true" style="color:black"></i></a>
                            <?php  } ?>

                            <?php if ($_GET['ca'] == 2) { ?>
                            <a href="descripcion-cargo-taller.php?id=<?= $cargo['id']; ?>&nombre=<?= $cargo['nombre']; ?>&departamento=<?= $cargo['nombre_departamento']; ?>&empresa=<?= $cargo['nombre_empresa']; ?>"
                                title="Describir Cargo">
                                <i class="fa fa-align-justify" aria-hidden="true" style="color:black"></i></a>

                            <?php  }
                                    } ?>

                        </td>


                    </tr>


                    <?php }
                    } else {  ?>

                    <tr>
                        <td>No hay registros</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <?php if (isset($_GET['val'])) { ?>
                        <td></td>
                        <td></td>
                        <?php } ?>
                    </tr>

                    <?php } ?>

                </tbody>

            </table>
        </div>
    </div>
</div>
<?php include_once('../layouts/footer.php'); ?>

<script src="assets/js/cargos.js"></script>

<script>
function ver_escala(escalas, nombre_empresa, categoria, conteo, nombre_nivel, minimo_nivel, maximo_nivel) {
    var catego = "";
    if (categoria == 1) {
        catego = "Administrativo";
    }
    if (categoria == 2) {
        catego = "Planta - Taller - Fábrica";
    }
    var html = `   <span class="text-center"><span class="glyphicon glyphicon-check"></span> Clasificación de Empresas en base al N° de trabajadores</span><br>
                    <span class="text-center">(cifras aproximadas)</span><br>
                    <br>
                    <br>

                    <div class="text-left" style="font-size: 14px">
                    <span style="color: 25B9FF">Empresa: ${nombre_empresa} </span><br>
                    <span style="color: 25B9FF">Categoria: ${catego} </span><br>
                    <span style="color: red">Total Trabajadores: ${conteo} </span>
                    </div>
                    <br>

                    <span style="font-size: 30px"><strong> ${nombre_nivel.trim()}s Empresas </strong></span><br>
                    <span class="text-center"> De ${minimo_nivel} a ${maximo_nivel} Trabajadores </span><br>
                    <span class="text-center">Estructura de Grados y Puntos para la Valoración de Cargos: </span><br><br>
    `;


    console.log(escalas);

    html += `<table id="escalas" class="table table-striped dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Grado</th>
                            <th>Mínimo</th>
                            <th>Máximo</th>
                        </tr>
                    </thead>
                    <tbody> 
                        `;
    escalas.forEach(function(escalas) {
        html += `<tr>
            <td style="text-align: center;"> ${escalas["grado"]} </td>
            <td> ${escalas["minimo"]} </td>
            <td> ${escalas["maximo"]} </td>
            </tr>`;
    });

    html += `            
                       
                    </tbody>
                   
                </table>
                <br>
                <br>`;

    Swal.fire({
        title: "Escala - Sistema de Puntos",
        html: html,
        width: '800px',
        showConfirmButton: false,
    });
    $(document).ready(function() {
        $('#escalas').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
            },
            order: [
                [1, 'asc']
            ],
        });
    });


}

function mostrar_ocultar_texto() {

    const tablaValoracion = document.getElementById('tabla-valoracion');
    const textoValoracion = document.getElementById('texto-valoracion');

    textoValoracion.style.display = 'none';
    tablaValoracion.style.display = 'block';


}
</script>