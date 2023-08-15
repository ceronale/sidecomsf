<?php 
$seccion = 'p_resultados';
include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
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

<?php include_once "../layouts/menu.php"; 
$percentiles_info = "Es una medida estadística de posición, que divide la distribución ordenada de los datos en cien partes iguales.";


include_once 'class.crud.php';
$crud = new crud();
$categoria = $_GET['ca'];

if($categoria == 1){
    $cat = "Administrativo";
}else
{
    $cat = "Planta - Taller - Fábrica";
}

if(isset($_GET['per']))
{
    $percent = $_GET['per'];
 
}
else
{
    $percent = 1;
}

function tiempoTranscurridoFechas($fecha1)
{
    $fechaInicio = date("Y-m-d", strtotime($fecha1));
    $fechaFin = date("Y-m-d", strtotime('now'));
    $fecha1 = new DateTime($fechaInicio);
    $fecha2 = new DateTime($fechaFin);
    $fecha = $fecha1->diff($fecha2);
    $tiempo = "";
    //años
    if ($fecha->y > 0) {
        $tiempo .= $fecha->y;

        if ($fecha->y == 1)
            $tiempo .= " año, ";
        else
            $tiempo .= " años, ";
    }
    //meses
    if ($fecha->m > 0) {
        $tiempo .= $fecha->m;

        if ($fecha->m == 1)
            $tiempo .= " mes, ";
        else
            $tiempo .= " meses, ";
    }
    //dias
    if ($fecha->d > 0) {
        $tiempo .= $fecha->d;

        if ($fecha->d == 1)
            $tiempo .= " día ";
        else
            $tiempo .= " días ";
    }
    return $tiempo;
}


?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <div class="card text-left">
            <div class="card-header">
                <span style="font-weight: bold; font-size: 25px; color: #3c8dbc; cursor: pointer;"
                    onclick="info_tabla('Percentil:','<?php echo $percentiles_info; ?>')">Percentiles
                    <?= $cat; ?> </span>
            </div>
        </div>

    </section>
    <!-- Content Header (Page header) -->

    <?php

$info_paquete_anual = "Incluye toda remuneración que percibe el trabajador anualmente tales como: Doce meses del ingreso mensual, bono vacacional, utilidades, bono de fin de año, aguinaldos, bonos especiales, bonos por desempeño o productividad, entre otros pagos.";
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

    <div class="container">
        <!-- Main content -->
        <section class="content">

<?php 
if(isset($_GET['per']))
{
    $percenti = $_GET['per'];
}
else
{
    $percenti = "";
}

?>
            <div class=" col-md-12 form-group" style="text-align: left !important;">

         

                <div class="col-md-12">
                    <div class="row">

                        <div class="col-sm-2 form-group">
                        <label for="cboCategoria">Categoria</label>
                        <select name="cboCategoria" id="cboCategoria" class="form-control input-sm"
                            onchange="redirectcategoria(this.value,'<?= $percenti; ?>')">
                            <option value="1" <?php if($categoria == 1){echo "selected";} ?>>Administrativo</option>
                            <option value="2" <?php if($categoria == 2){echo "selected";} ?>>Plata - Taller -
                                Fábrica</option>
                        </select>
                        </div>
                    

                        <div class="col-sm-4 form-group" style="text-align: left;">
                        <label for="percentil">Percentil</label>
                        <select class="form-select" id="percentil" name="percentil"
                        onchange="redirectpercentil(this.value, '<?= $_GET['ca']; ?>')">
                        <option value="1" <?php if(isset($_GET['per'])){if($_GET['per']==1){echo "Selected";}} ?>>
                            Paquete Anual por encima del percentil 75</option>
                        <option value="2" <?php if(isset($_GET['per'])){if($_GET['per']==2){echo "Selected";}} ?>>
                            Paquete Anual entre el percentil 50-75</option>
                        <option value="3" <?php if(isset($_GET['per'])){if($_GET['per']==3){echo "Selected";}} ?>>
                            Paquete Anual entre el percentil 25-50</option>
                        <option value="4" <?php if(isset($_GET['per'])){if($_GET['per']==4){echo "Selected";}} ?>>
                            Paquete Anual por debajo del percentil 25</option>
                    </select>
              
                        </div>

                        <div class="col-md-4"></div>
                        <div class="col-md-2 form-group" style="text-align: right;">
                            <br>
                        <button type="button" class="btn btn-primary btn3d" title="Volver a Matriz de Resultados"
                            id="volver-matriz" onclick="redirectmatriz(<?= $_GET['ca']; ?>)"
                           >Volver</button>
                        </div>


                    </div>
                </div>
            </div>


            <?php
                extract($crud->get_nombre_moneda());
                $user = $_SESSION['user'];
                $escalas = $crud->dataview_escalas($categoria);
                extract($crud->get_datos_empresa($user['id_empresa']));	
                extract($crud->get_sum_empleados($categoria));	
                extract($crud->get_nivel_empresarial($nivel_empresarial));	
                $grados = $crud->dataview_escalas($_GET['ca']); 
        ?>

            <div class="col-md-12">
                <div class="row">

                    <div class="col-sm-2 form-group">
                        <button type="button" class="btn btn-primary btn3d" title="Ver Escala Empresarial"
                            id="ver_escala"
                            onclick="ver_escala(<?php echo htmlspecialchars(json_encode($escalas)); ?>,'<?= $nombre_empresa ?>','<?= $categoria ?>','<?= $conteo ?>','<?= $nombre_nivel ?>','<?= $minimo_nivel ?>','<?= $maximo_nivel ?>')">Ver
                            Escala</button>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-5 form-group">

                    </div>

                    <div class="col-sm-3 form-group" style="text-align: right;">
                        <span style="font-size: 12px; color:red">(MONTOS EXPRESADOS EN
                            <?=strtoupper($nombre_moneda)?>)</span>
                    </div>
                </div>
            </div>




            <table id="example" class="table table-striped dt-responsive nowrap" style="width:100%">
                <thead style="position: sticky; top: 0; background-color: white;">
                    <tr>
                        <th>Grado</th>
                        <th>Departamento</th>
                        <th>Cargo</th>
                        <th>Trabajador</th>
                        <th>Tiempo de Servicio</th>
                        <th style="color: #3c8dbc;"> <span onclick="info_tabla('Paquete Anual:','<?php echo $info_paquete_anual; ?>')">Paquete Anual</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                $percentiles = $crud->dataview_percentiles($categoria,$percent);
                if ($percentiles != null) {
                    foreach ($percentiles as $percentil) {
                ?>
                    <tr>
                        <td><?php print($percentil['grado']); ?></td>
                        <td><?php print($percentil['nombredepartamento']); ?></td>
                        <td><?php print($percentil['nombrecargo']); ?></td>
                        <td><?php print($percentil['nombretrabajador']); ?></td>
                        <td><?php echo tiempoTranscurridoFechas($percentil['fechaingreso']); ?> </td>
                        <td><?php print($percentil['paquete_anual']); ?></td>

                    </tr>

                    <?php }
                } else {  ?>

                    <tr>
                        <td>No hay registros</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <?php } ?>

                </tbody>
            </table>
            </div>


            <br>







</div>
<?php include_once('../layouts/footer.php'); ?>

<script src="assets/js/resultados.js"></script>

<script>
function redirectcategoria(categoria,percentil) {
    if(percentil != "")
    {
        window.location.href = "../matriz-resultados/percentiles?ca=" + categoria + "&per=" + percentil;
    }
    else
    {
        window.location.href = "../matriz-resultados/percentiles?ca=" + categoria;
    }
    
}

function redirectpercentil(percentil, categoria) {
    window.location.href = "../matriz-resultados/percentiles?ca=" + categoria + "&per=" + percentil;
}

function redirectmatriz(categoria) {
    window.location.href = "../matriz-resultados/?ca=" + categoria;
}


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
</script>