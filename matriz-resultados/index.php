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
$matriz_resultados = "1.- Combina ambas Matrices (de Nómina y Jerarquización). ;; 2.- Compara cada uno de los datos de la matriz de nómina (Ingreso mensual y Paquete anual), con Mínimo, Medio y Máximo. ;; 3.- Se totalizan los ingresos mensual y paquete, para luego compararlo con el Presupuesto y Ventas, debe arrojar un saldo igual, positivo o negativo.";
$indicadores = "Característica específica, observable y medible que permite ser usada para mostrar los cambios y progresos de la información hacia el logro de los resultados previstos o planificados.";



include_once 'class.crud.php';
$crud = new crud();
$categoria = $_GET['ca'];

$user = $_SESSION['user'];
extract($crud->get_matriz_resultados($user['id_empresa']));	

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
                    onclick="info_tabla('Matriz de Resultados:','<?php echo $matriz_resultados; ?>')">Matriz de
                    Resultados <?= $cat; ?> </span>
            </div>
        </div>

    </section>
    <!-- Content Header (Page header) -->

    <?php


$info_sueldo_base_mensual = "Es la porción del sueldo o salario mensual que sirve de base para el cálculos de los aumentos por meritos ó desempeño.";
$info_ingreso_mensual = "Incluye todos los sueldos o salarios, bonos, gratificaciones, fondo de ahorro, ayuda despensa, bono alimentación, transporte y otros pagos (ingresos bruto), que perciba el trabajador en forma regular y permanente.";
$info_paquete_anual = "Incluye toda remuneración que percibe el trabajador anualmente tales como: Doce meses del ingreso mensual, bono vacacional, utilidades, bono de fin de año, aguinaldos, bonos especiales, bonos por desempeño o productividad, entre otros pagos.";
$info_factor_meses = "Es un indicador que señala los meses (y fracción) contenidos en el PAQUETE ANUAL (resulta de dividir el paquete anual entre el ingreso mensual).";
$info_otras_divisas = "Nos referimos al PAGO ADICIONAL que se realiza a ciertos trabajadores en moneda extranjera. (PAGO MENSUAL)";
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



            <form id='create' action="save.php?ca=<?= $categoria; ?>" method='post'>

                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h4>Mostrar Resultados: <span id="loadergm"></span></h4>
                        <div class="row" id="formcss">
                            <div class="col-sm-2 form-group">
                                <label for="cboCategoria">Categoria</label>
                                <select name="cboCategoria" id="cboCategoria" class="form-control input-sm"
                                    onchange="redirectcategoria(this.value)">
                                    <option value="1" <?php if($categoria == 1){echo "selected";} ?>>Administrativo
                                    </option>
                                    <option value="2" <?php if($categoria == 2){echo "selected";} ?>>Plata - Taller -
                                        Fábrica</option>
                                </select>
                            </div>
                            <div class="col-sm-3 form-group">
                                <label for="presupuesto_ingreso_mensual1">Presupuesto Mensual</label>
                                <input type="text" class="form-control input-sm number"
                                    id="presupuesto_ingreso_mensual1" name="presupuesto_ingreso_mensual1" value="<?= $presupuesto_mensual; ?>"
                                    placeholder="Indique Presupuesto Mensual" required
                                    title="Indique el Presupuesto Mensual" />
                            </div>
                            <div class="col-sm-5 form-group">
                                <label for="presupuesto_ingreso_mensual1">Presupuesto Anual</label>
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" class="form-control input-sm number"
                                            id="presupuesto_paquete_anual1" name="presupuesto_paquete_anual1" value="<?= $presupuesto_anual; ?>"
                                            placeholder="Indique Presupuesto Paquete" required
                                            title="Indique el Presupuesto del Paquete" />
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary btn3d" id="btn-genResultados"
                                            name="btn-genResultados"></span> GENERAR</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2 form-group">
                                <label for="Guardar"></label>
                                <br>


                            </div>

                        </div>

                        <div class="row">
                            <div class="row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-3">
                                    <label for="ventas_mensuales1">Ventas Mensuales</label>
                                    <input type="text" class="form-control input-sm number" id="ventas_mensuales1" name="ventas_mensuales1"
                                        value="<?= $ventas_mensual; ?>" placeholder="Indique Ventas Mensuales" required
                                        title="Indique las Ventas Mensuales" />
                                </div>
                                <div class="col-sm-3">
                                    <label for="ventas_anuales1">Ventas Anuales</label>
                                    <input type="text" class="form-control input-sm number" id="ventas_anuales1" name="ventas_anuales1" 
                                        value="<?= $ventas_anual; ?>" placeholder="Indique Ventas Anuales" required
                                        title="Indique las Ventas Mensuales" />
                                </div>

                            </div>

                        </div>
                    </div> <!-- /.box-body danger-->

            </form>

            <br>
            <!-- Indicadores -->
            <div class="box box-default">

                <div class="box-header with-border">

                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <h4><i class="fa fa-tachometer" aria-hidden="true"></i><a href="javascript:void"
                                        onclick="myIndicador();" class="alert-link"><span
                                            style="font-weight: bold; font-size: 25px; color: #3c8dbc; cursor: pointer;"
                                            onclick="info_tabla('Indicadores:','<?= $indicadores; ?>')">
                                            Indicadores:</em><span id="loader2"></span></a>
                                </h4>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-bs-toggle="collapse"
                                        data-bs-target="#collapseindicadores" aria-expanded="false"
                                        aria-controls="collapseindicadores" title="Collapse"><i
                                            class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="collapse" id="collapseindicadores" name="collapseindicadores">

                        <div class="card card-body">

                            <div class="box-body">

                                <div class="col-md-12" style="text-align: center !important;">
                                    <div class="row">
                                        <span style="font-weight: bold; font-size: 25px;">Presupuestos Vs
                                            Salarios</span>
                                    </div>
                                </div>

                                <br>
                                <br>

                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-2" style="text-align: left !important;">
                                            <label for="presupuesto_ingreso_mensual">Presupuesto / Mes</label>
                                            <input type="text" class="form-control input-sm number"
                                                id="presupuesto_ingreso_mensual" placeholder="...."
                                                title="Presupuesto de Ingresos Mensuales" readonly />
                                        </div>

                                        <div class="col-md-1" style="text-align: center !important;">
                                            <br> <span style="font-weight: bold; font-size: 25px;">VS</span>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="total_ingreso_mensual">Ingreso / Mes</label>
                                            <input type="text" class="form-control input-sm" id="total_ingreso_mensual"
                                                placeholder="...." title="Total Ingreso Mensual" readonly />
                                        </div>

                                        <div class="col-md-1" style="text-align: center !important;">

                                        </div>

                                        <div class="col-md-2">
                                            <label for="diferencia_ingreso_mensual">Diferencia</label>
                                            <input type="text" class="form-control input-sm"
                                                id="diferencia_ingreso_mensual" name="diferencia_ingreso_mensual"
                                                placeholder="...." title="Diferencia Presupuesto Mensual" readonly />
                                        </div>

                                        <div class="col-md-1" style="text-align: center !important;">

                                        </div>

                                        <div class="col-md-2" style="text-align: center;">
                                            <label for="proporcionmensual">%</label>
                                            <input type="text" class="form-control input-sm" id="proporcionmensual"
                                                name="proporcionmensual" placeholder="Proporcion % Mensual" readonly
                                                title="Proporcion % Mensual" />
                                        </div>

                                    </div>
                                </div>

                                <br>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2" style="text-align: left !important;">
                                            <label for="presupuesto_paquete_anual">Presupuesto / Anual</label>
                                            <input type="text" class="form-control input-sm"
                                                id="presupuesto_paquete_anual" placeholder="...."
                                                title="Presupuesto de Paquete Mensuales" readonly />
                                        </div>

                                        <div class="col-md-1" style="text-align: center !important;">
                                            <br> <span style="font-weight: bold; font-size: 25px;">VS</span>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="total_paquete_anual">Paquete / Anual</label>
                                            <input type="text" class="form-control input-sm" id="total_paquete_anual"
                                                placeholder="...." title="Total Paquete año" readonly />
                                        </div>

                                        <div class="col-md-1" style="text-align: center !important;">

                                        </div>

                                        <div class="col-md-2">
                                            <label for="diferencia_paquete_anual">Diferencia</label>
                                            <input type="text" class="form-control input-sm"
                                                id="diferencia_paquete_anual" name="diferencia_paquete_anual"
                                                placeholder="...." title="Diferencia Presupuesto Mensual" readonly />
                                        </div>

                                        <div class="col-md-1" style="text-align: center !important;">

                                        </div>

                                        <div class="col-md-2" style="text-align: center;">
                                            <label for="proporcionanual">%</label>
                                            <input type="text" class="form-control input-sm" id="proporcionanual"
                                                name="proporcionanual" placeholder="Proporcion % Anual" readonly
                                                title="Proporcion % Anual" />
                                        </div>

                                    </div>
                                </div>

                                <br>
                                <br>


                                <div class="col-md-12" style="text-align: center !important;">
                                    <div class="row">
                                        <span style="font-weight: bold; font-size: 25px;">Ventas Vs Salarios</span>
                                    </div>
                                </div>

                                <br>
                                <br>


                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2" style="text-align: left !important;">
                                            <label for="ventas_mensuales">Ventas / Mes</label>
                                            <input type="text" class="form-control input-sm" id="ventas_mensuales"
                                                placeholder="...." title="Ventas Mensuales" readonly />
                                        </div>

                                        <div class="col-md-1" style="text-align: center !important;">
                                            <br> <span style="font-weight: bold; font-size: 25px;">VS</span>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="total_ingreso_mensual_ventas">Ingreso / Mes</label>
                                            <input type="text" class="form-control input-sm"
                                                id="total_ingreso_mensual_ventas" placeholder="...."
                                                title="Diferencia Presupuesto Mensual" readonly />
                                        </div>

                                        <div class="col-md-1" style="text-align: center !important;">

                                        </div>

                                        <div class="col-md-2">
                                            <label for="diferencia_ventas_mensuales">Diferencia</label>
                                            <input type="text" class="form-control input-sm"
                                                id="diferencia_ventas_mensuales" placeholder="...."
                                                title="Diferencia Presupuesto Mensual" readonly />
                                        </div>

                                        <div class="col-md-1" style="text-align: center !important;">

                                        </div>

                                        <div class="col-md-2" style="text-align: center;">
                                            <label for="proporcionventasmensual">%</label>
                                            <input type="text" class="form-control input-sm"
                                                id="proporcionventasmensual" placeholder="Proporcion % Mensual" readonly
                                                title="Proporcion % Mensual" />
                                        </div>

                                    </div>
                                </div>

                                <br>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2" style="text-align: left !important;">
                                            <label for="ventas_anuales">Ventas / Año</label>
                                            <input type="text" class="form-control input-sm" id="ventas_anuales"
                                                placeholder="...." title="Ventas Anuales" readonly />
                                        </div>

                                        <div class="col-md-1" style="text-align: center !important;">
                                            <br> <span style="font-weight: bold; font-size: 25px;">VS</span>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="total_paquete_anual_ventas"> Ingreso / Año</label>
                                            <input type="text" class="form-control input-sm"
                                                id="total_paquete_anual_ventas" placeholder="...."
                                                title="Diferencia Presupuesto Anual" readonly />
                                        </div>

                                        <div class="col-md-1" style="text-align: center !important;">

                                        </div>

                                        <div class="col-md-2">
                                            <label for="diferencia_ventas_anuales">Diferencia</label>
                                            <input type="text" class="form-control input-sm"
                                                id="diferencia_ventas_anuales" placeholder="...."
                                                title="Diferencia Ventas Anuales" readonly />
                                        </div>

                                        <div class="col-md-1" style="text-align: center !important;">

                                        </div>

                                        <div class="col-md-2" style="text-align: center;">
                                            <label for="proporcionventasanual">%</label>
                                            <input type="text" class="form-control input-sm" id="proporcionventasanual"
                                                placeholder="Proporcion % Anual" readonly title="Proporcion % Anual" />
                                        </div>

                                    </div>
                                </div>

                                <br>
                                <br>



                                <div class="col-md-12" style="text-align: center !important;">
                                    <div class="row">
                                        <span style="font-weight: bold; font-size: 25px;">Información General</span>
                                    </div>
                                </div>

                                <br>
                                <br>

                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-4" style="text-align: center !important;">
                                            <div class="form-group">
                                                <label for="promedio_ingreso_mensual">Promedio Ingreso
                                                    Mensual</label>
                                                <input type="text" class="form-control input-sm"
                                                    id="promedio_ingreso_mensual" placeholder="...."
                                                    title="Promedio Ingreso Mensual" readonly />
                                            </div>

                                            <div class="form-group">
                                                <label for="total_trabajadores">Total Trabajadores</label>
                                                <input type="text" class="form-control input-sm" id="total_trabajadores"
                                                    placeholder="...." title="Total trabajadores" readonly />
                                            </div>

                                            <div class="form-group">
                                                <label for="total_dolares">Total Pago Dolares</label>
                                                <input type="text" class="form-control input-sm" id="total_dolares"
                                                    placeholder="...." title="Total Dolares" readonly />
                                            </div>

                                        </div>

                                        <div class="col-md-4">

                                        </div>

                                        <div class="col-md-4" style="text-align: center !important;">
                                            <div class="form-group">
                                                <label for="promedio_paquete_anual">Promedio Paquete Anual</label>
                                                <input type="text" class="form-control input-sm"
                                                    id="promedio_paquete_anual" placeholder="...."
                                                    title="Promedio Paquete año" readonly />
                                            </div>

                                            <div class="form-group">
                                                <label for="promedio_antiguedad">Promedio Antiguedad</label>
                                                <input type="text" class="form-control input-sm"
                                                    id="promedio_antiguedad" placeholder="...."
                                                    title="Promedio Antiguedad" readonly />
                                            </div>

                                            <div class="form-group">
                                                <label for="total_euros">Total Pago Euros</label>
                                                <input type="text" class="form-control input-sm" id="total_euros"
                                                    placeholder="...." title="Total Euros" readonly />
                                            </div>
                                        </div>

                                    </div>
                                </div>


                            </div>

                            <br>
                            <br>

                        </div> <!-- /.box-body default -->

                    </div>
                </div>

            </div>

            <div class="col-sm-12">
                <!-- Tips Indicadores-->
                <div class="alert alert-default" id="indicador" style="display:none; font-size:16px;">
                    <strong><i class="fa fa-warning"></i> INDICADORES:</strong><br />
                    <em>
                        <p>Característica específica, observable y medible que permite ser usada para mostrar
                            los
                            cambios y progresos de la información hacia el logro de los resultados previstos o
                            planificados.</p>
                    </em>
                </div>
            </div>
    </div>


</div>

<div id="chart-container" style="display: none">
    <canvas id="graphCanvas"></canvas>
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

<br>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-sm-4 form-group">
            <div class="row">
                <div class="col-md-4">
                    <button type="button" class="btn btn-primary btn3d" title="Ver Escala Empresarial" id="ver_escala"
                        onclick="ver_escala(<?php echo htmlspecialchars(json_encode($escalas)); ?>,'<?= $nombre_empresa ?>','<?= $categoria ?>','<?= $conteo ?>','<?= $nombre_nivel ?>','<?= $minimo_nivel ?>','<?= $maximo_nivel ?>')">Ver
                        Escala</button>
                </div>
                <div class="col-md-6" style="text-align: left;">
                    <button type="button" class="btn btn-primary btn3d" title="Ver Percentiles" id="percentiles"
                        onclick="redirectpercentiles('<?= $categoria ?>')">Ver Percentiles</button>
                </div>
            </div>
        </div>

        <div class="col-md-3 form-group">
            <div class="row">
                <div class="col-md-2" style="text-align: right !important;">
                    <label for="id_grado">Grados</label>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="id_grado" name="id_grado"
                        onchange="redirectgrados(this.value, <?= $_GET['ca']; ?>)">
                        <option value="">Todos</option>
                        <?php
                    if ($grados != null){
                    foreach ($grados as $grado) { ?>
                        <option value="<?= $grado['grado']?>" <?php
                            if(isset($_GET['g'])){ if($grado['grado'] == $_GET['g']){echo "Selected";} }?>>
                            <?= $grado['grado'];?>
                        </option>
                        <?php }
                    }
                    ?>
                    </select>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-3 form-group" style="text-align: right;">
            <span style="font-size: 12px; color:red">(MONTOS EXPRESADOS EN <?=strtoupper($nombre_moneda)?>)</span>
        </div>
    </div>
</div>


<div class='container' id="container99" name="container99" style="overflow: auto; max-height: 600px;">


    <table id="example" class="table table-striped dt-responsive nowrap" style="width:100%">
        <thead style="position: sticky; top: 0; background-color: white;">
            <tr>

                <th>Grado</th>
                <th>Puesto/Cargo</th>
                <th>Trabajador</th>
                <th style="border-left: solid 2px #A8A8A8">Ingreso Mensual</th>
                <th style="text-align: center">Real <br> vs <br> Mínimo</th>
                <th style="text-align: center">Real <br> vs <br> Medio</th>
                <th style="text-align: center">Real <br> vs <br> Máximo</th>
                <th style="border-left: solid 2px #A8A8A8">Paquete Anual</th>
                <th style="text-align: center">Real <br> vs <br> Mínimo</th>
                <th style="text-align: center">Real <br> vs <br> Medio</th>
                <th style="text-align: center">Real <br> vs <br> Máximo</th>

            </tr>
        </thead>
        <tbody>
            <?php

                    if(isset($_GET['g']))
                    {
                        $resultados = $crud->dataview_resultados($categoria,$_GET['g']);
                    
                    }
                    else
                    {
                        $resultados = $crud->dataview_resultados($categoria,"");
                    }

             
                if ($resultados != null) {
                    foreach ($resultados as $resultado) {
                       
                ?>
            <tr>

                <td style="text-align: center;">
                    <span style="opacity: .0;">
                        <?php                        
                        switch ($resultado['grado']) {
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

                    <?php print($resultado['grado']); ?>
                </td>
                <td><?php print($resultado['nombrecargo']); ?></td>
                <td><?php print($resultado['nombretrabajador']); ?></td>

                <?php if($resultado['sueldomensual'] < 0)
                { ?>
                <td style="border-left: solid 2px #A8A8A8"> <span style="color: red;">
                        <?= number_format($resultado['sueldomensual'],2,',','.');  ?></span></td>
                <?php }
                else
                { ?>
                <td style="border-left: solid 2px #A8A8A8">
                    <?= number_format($resultado['sueldomensual'],2,',','.');  ?></td>
                <?php } ?>

                <?php if($resultado['realvsminimo'] < 0)
                { ?>
                <td> <span style="color: red;"> <?= number_format($resultado['realvsminimo'],2,',','.');  ?>
                    </span>
                </td>
                <?php }
                else
                { ?>
                <td><?= number_format($resultado['realvsminimo'],2,',','.');  ?></td>
                <?php } ?>

                <?php if($resultado['realvsmedio'] < 0)
                { ?>
                <td> <span style="color: red;"> <?= number_format($resultado['realvsmedio'],2,',','.');  ?>
                    </span>
                </td>
                <?php }
                else
                { ?>
                <td><?= number_format($resultado['realvsmedio'],2,',','.');  ?></td>
                <?php } ?>

                <?php if($resultado['realvsmaximo'] < 0)
                { ?>
                <td> <span style="color: red;"> <?= number_format($resultado['realvsmaximo'],2,',','.');  ?>
                    </span>
                </td>
                <?php }
                else
                { ?>
                <td><?= number_format($resultado['realvsmaximo'],2,',','.');  ?></td>
                <?php } ?>

                <?php if($resultado['paqueteanual'] < 0)
                { ?>
                <td style="border-left: solid 2px #A8A8A8"> <span style="color: red;">
                        <?= number_format($resultado['paqueteanual'],2,',','.');  ?></span></td>
                <?php }
                else
                { ?>
                <td style="border-left: solid 2px #A8A8A8">
                    <?= number_format($resultado['paqueteanual'],2,',','.');  ?></td>
                <?php } ?>

                <?php if($resultado['realvsminimoanual'] < 0)
                { ?>
                <td> <span style="color: red;">
                        <?= number_format($resultado['realvsminimoanual'],2,',','.');  ?>
                    </span></td>
                <?php }
                else
                { ?>
                <td><?= number_format($resultado['realvsminimoanual'],2,',','.');  ?></td>
                <?php } ?>

                <?php if($resultado['realvsmedioanual'] < 0)
                { ?>
                <td> <span style="color: red;"> <?= number_format($resultado['realvsmedioanual'],2,',','.');  ?>
                    </span></td>
                <?php }
                else
                { ?>
                <td><?= number_format($resultado['realvsmedioanual'],2,',','.');  ?></td>
                <?php } ?>

                <?php if($resultado['realvsmaximoanual'] < 0)
                { ?>
                <td> <span style="color: red;">
                        <?= number_format($resultado['realvsmaximoanual'],2,',','.');  ?>
                    </span></td>
                <?php }
                else
                { ?>
                <td><?= number_format($resultado['realvsmaximoanual'],2,',','.');  ?></td>
                <?php } ?>


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
</div>

<?php include_once('../layouts/footer.php'); ?>

<script src="assets/js/resultados.js"></script>

<script>
function redirectpercentiles(categoria) {
    window.location.href = "../matriz-resultados/percentiles?ca=" + categoria;
}

$('input.number').keyup(function(event) {
    // skip for arrow keys
    if (event.which >= 37 && event.which <= 40) {
        event.preventDefault();
    }

    $(this).val(function(index, value) {
        return value
            .replace(/\D/g, "")
            .replace(/([0-9])([0-9]{2})$/, '$1,$2')
            .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
    });
});

$(document).ready(function() {
    $(".hidden").hide();

});

function mostrar_ocultar_grafica() {

    const toggleButton = document.getElementById('toggle-grafica');
    const graficaContainer = document.getElementById('chart-container');


    // Verificar si la gráfica está visible
    if (graficaContainer.style.display === 'none') {
        // Mostrar la gráfica
        graficaContainer.style.display = 'block';
        // Crear la instancia de la gráfica
    } else {
        // Ocultar la gráfica
        graficaContainer.style.display = 'none';
        // Destruir la instancia de la gráfica
    }



}

function redirectcategoria(categoria) {
    window.location.href = "../matriz-resultados/?ca=" + categoria;
}

function redirectgrados(grado, categoria) {
    window.location.href = "../matriz-resultados/?ca=" + categoria + "&g=" + grado;
}

function redirectpercentil(percentil, categoria) {
    window.location.href = "../matriz-resultados/?ca=" + categoria + "&per=" + percentil;
}


function result() {
    var myCollapse = document.getElementById('collapseindicadores')
    var bsCollapse = new bootstrap.Collapse(myCollapse, {
  toggle: true
})
}

function indicadores() {
    let categoria = $("#cboCategoria").val();

    var presupuesto_ingreso_mensual1 = document.getElementById("presupuesto_ingreso_mensual1");
    var presupuesto_paquete_anual1 = document.getElementById("presupuesto_paquete_anual1");
    var ventas_mensuales1 = document.getElementById("ventas_mensuales1");
    var ventas_anuales1 = document.getElementById("ventas_anuales1");

    var total_ingreso_mensual = document.getElementById("total_ingreso_mensual");
    var presupuesto_ingreso_mensual = document.getElementById("presupuesto_ingreso_mensual");
    var diferencia_ingreso_mensual = document.getElementById("diferencia_ingreso_mensual");
    var porcentaje_mensual = document.getElementById("proporcionmensual");
    // var factor_ingreso_mensual = document.getElementById("factor_ingreso_mensual");


    var total_paquete_anual = document.getElementById("total_paquete_anual");
    var presupuesto_paquete_anual = document.getElementById("presupuesto_paquete_anual");
    var diferencia_paquete_anual = document.getElementById("diferencia_paquete_anual");
    var porcentaje_anual = document.getElementById("proporcionanual");

    //var factor_paquete_anual = document.getElementById("factor_paquete_anual");

    var ventas_mensuales = document.getElementById("ventas_mensuales");
    var total_ingreso_mensual_ventas = document.getElementById("total_ingreso_mensual_ventas");
    var diferencia_ventas_mensuales = document.getElementById("diferencia_ventas_mensuales");
    var porcentaje_ventas_mensual = document.getElementById("proporcionventasmensual");

    var ventas_anuales = document.getElementById("ventas_anuales");
    var presupuesto_paquete_anual_ventas = document.getElementById("presupuesto_paquete_anual_ventas");
    var diferencia_ventas_anuales = document.getElementById("diferencia_ventas_anuales");
    var porcentaje_ventas_anuales = document.getElementById("proporcionventasanual");

    var promedio_ingreso_mensual = document.getElementById("promedio_ingreso_mensual");
    var promedio_paquete_anual = document.getElementById("promedio_paquete_anual");
    var promedio_antiguedad = document.getElementById("promedio_antiguedad");
    var total_trabajadores = document.getElementById("total_trabajadores");
    var total_dolares = document.getElementById("total_dolares");
    var total_euros = document.getElementById("total_euros");


    presupuesto_ingreso_mensual.value = presupuesto_ingreso_mensual1.value;
    presupuesto_paquete_anual.value = presupuesto_paquete_anual1.value;

    ventas_mensuales.value = ventas_mensuales1.value;
    ventas_anuales.value = ventas_anuales1.value;

    $.post("datos_indicadores.php", {
        categoria: categoria
    }, function(data) {
        console.log(data);


        var contador = 1;
        for (var i in data) {


            if (contador == 1) {
                totalingresomensual = data[i].totalingresomensual;
                totalpaqueteanual = data[i].totalpaqueteanual;
                total_ingreso_mensual_ventas.value = data[i].totalingresomensual;
                total_paquete_anual_ventas.value = data[i].totalpaqueteanual;
                promediomensual = data[i].promediomensual;

                promedioanual = data[i].promedioanual;
                totaltrabajadores = data[i].totaltrabajadores;
                promedioantiguedad = data[i].promedioantiguedad;

                totaldolares = data[i].totaldolares;
                totaleuros = data[i].totaleuros;

                total_ingreso_mensual.value = totalingresomensual;
                //diferencia_ingreso_mensual.value = (presupuesto_ingreso_mensual.value - totalingresomensual)
                //    .toFixed(2);

                /*    
                let txtIngresoM = total_ingreso_mensual.value;
                let txtPaqueteA = diferencia_ingreso_mensual.value;
                let sldm = txtIngresoM.replace(".", "");
                sldm = sldm.replace(",", ".");

                let pqta = txtPaqueteA.replace(".", "");
                pqta = pqta.replace(",", ".");

                if (parseFloat(sldm) > 0) {

                    let factor = (pqta / sldm).toFixed(2);
                    factor = factor.replace(".", ",");
                    // document.getElementById("resultado").innerHTML = factor; //(pqta / sldm).toFixed(2);
                    factor_ingreso_mensual.value = factor; //(pqta / sldm).toFixed(2);
                    //factor = replaceAll(factor, ".", ",");
                } else {
                    factor = "0,00";
                }

                */


                total_paquete_anual.value = totalpaqueteanual;
                //diferencia_paquete_anual.value = (presupuesto_paquete_anual.value - totalpaqueteanual);

                /*
                let txtIngresoM2 = total_paquete_anual.value;
                let txtPaqueteA2 = diferencia_paquete_anual.value;
                let sldm2 = txtIngresoM2.replace(".", "");
                sldm2 = sldm2.replace(",", ".")

                let pqta2 = txtPaqueteA2.replace(".", "");
                pqta2 = pqta2.replace(",", ".");

                if (parseFloat(sldm2) > 0) {

                    let factor2 = (pqta2 / sldm2).toFixed(2);
                    factor2 = factor2.replace(".", ",");
                    // document.getElementById("resultado").innerHTML = factor; //(pqta / sldm).toFixed(2);
                    factor_paquete_anual.value = factor2; //(pqta / sldm).toFixed(2);
                    //factor = replaceAll(factor, ".", ",");
                } else {
                    factor2 = "0,00";
                }
                */

                promedio_ingreso_mensual.value = promediomensual

                promedio_paquete_anual.value = promedioanual;
                promedio_antiguedad.value = promedioantiguedad;
                total_trabajadores.value = totaltrabajadores;

                if (parseFloat(totaldolares) >= 1) {

                    total_dolares.value = parseFloat(totaldolares);
                    if (total_dolares.value.charAt(total_dolares.value.length - 3) != ',' && total_dolares.value
                        .charAt(total_dolares.value.length - 2) != ',') {
                        total_dolares.value = total_dolares.value + ",00";
                    }
                } else {
                    total_dolares.value = 0;
                }

                if (parseFloat(totaleuros) >= 1) {
                    total_euros.value = parseFloat(totaleuros);
                    if (total_euros.value.charAt(total_euros.value.length - 3) != ',' && total_euros.value
                        .charAt(total_euros.value.length - 2) != ',') {
                        total_euros.value = total_euros.value + ",00";
                    }
                } else {
                    total_euros.value = 0;
                }

                //DIFERENCIA MENSUAL  --------------------------------------------------------------------------------------------
                presupuestomensual = presupuesto_ingreso_mensual.value.replaceAll('.', '');
                presupuestomensual = presupuestomensual.replaceAll(',', '.');

                totallingresomen = totalingresomensual.replaceAll('.', '');
                totallingresomen = totallingresomen.replaceAll(',', '.');
                diferenciaingresomensual = parseFloat(presupuestomensual - totallingresomen);
                diferencia_ingreso_mensual.value = new Intl.NumberFormat('de-DE').format(
                    diferenciaingresomensual);



                if (diferencia_ingreso_mensual.value.charAt(diferencia_ingreso_mensual.value.length - 3) !=
                    ',' && diferencia_ingreso_mensual.value.charAt(diferencia_ingreso_mensual.value.length -
                    2) != ',') {
                    diferencia_ingreso_mensual.value = diferencia_ingreso_mensual.value + ",00";
                }

                difnegativamensual = diferencia_ingreso_mensual.value.replaceAll('.', '');
                difnegativamensual = difnegativamensual.replaceAll(',', '.');

                if (parseFloat(difnegativamensual) < 0) {
                    document.getElementById("diferencia_ingreso_mensual").style.color = "red";
                } else {
                    document.getElementById("diferencia_ingreso_mensual").style.color = "black";
                }
                // FIN DIFERENCIA MENSUAL  --------------------------------------------------------------------------------------------

                //DIFERENCIA PAQUETE ANUAL   --------------------------------------------------------------------------------------------
                presupuestopaqueteanu = presupuesto_paquete_anual.value.replaceAll('.', '');
                presupuestopaqueteanu = presupuestopaqueteanu.replaceAll(',', '.');

                totallpaqueteanu = totalpaqueteanual.replaceAll('.', '');
                totallpaqueteanu = totallpaqueteanu.replaceAll(',', '.');
                diferenciapaqueteanual = parseFloat(presupuestopaqueteanu - totallpaqueteanu).toFixed(2);
                diferencia_paquete_anual.value = new Intl.NumberFormat('de-DE').format(diferenciapaqueteanual);

                if (diferencia_paquete_anual.value.charAt(diferencia_paquete_anual.value.length - 3) != ',' &&
                    diferencia_paquete_anual.value.charAt(diferencia_paquete_anual.value.length - 2) != ',') {
                    diferencia_paquete_anual.value = diferencia_paquete_anual.value + ",00";
                }

                if (parseFloat(diferencia_paquete_anual.value) < 0) {
                    document.getElementById("diferencia_paquete_anual").style.color = "red";
                } else {
                    document.getElementById("diferencia_paquete_anual").style.color = "black";
                }

                // FIN DIFERENCIA PAQUETE ANUAL  --------------------------------------------------------------------------------------------


                //DIFERENCIA VENTA MENSUAL   --------------------------------------------------------------------------------------------
                ventasmensua = ventas_mensuales.value.replaceAll('.', '');
                ventasmensua = ventasmensua.replaceAll(',', '.');

                total_mensualventas = total_ingreso_mensual_ventas.value.replaceAll('.', '');
                total_mensualventas = total_mensualventas.replaceAll(',', '.');
                diferenciaventasmensuales = parseFloat(ventasmensua - total_mensualventas).toFixed(2);
                diferencia_ventas_mensuales.value = new Intl.NumberFormat('de-DE').format(
                    diferenciaventasmensuales);

                if (diferencia_ventas_mensuales.value.charAt(diferencia_ventas_mensuales.value.length - 3) !=
                    ',' && diferencia_ventas_mensuales.value.charAt(diferencia_ventas_mensuales.value.length -
                        2) != ',') {
                    diferencia_ventas_mensuales.value = diferencia_ventas_mensuales.value + ",00";
                }

                if (parseFloat(diferencia_ventas_mensuales.value) < 0) {
                    document.getElementById("diferencia_ventas_mensuales").style.color = "red";
                } else {
                    document.getElementById("diferencia_ventas_mensuales").style.color = "black";
                }
                // FIN DIFERENCIA VENTA MENSUAL  --------------------------------------------------------------------------------------------


                //DIFERENCIA VENTAS ANUALES  --------------------------------------------------------------------------------------------
                ventasanual = ventas_anuales.value.replaceAll('.', '');
                ventasanual = ventasanual.replaceAll(',', '.');

                totalpaqueteanua = total_paquete_anual.value.replaceAll('.', '');
                totalpaqueteanua = totalpaqueteanua.replaceAll(',', '.');
                diferenciaventasanuales = parseFloat(ventasanual - totalpaqueteanua).toFixed(2);
                diferencia_ventas_anuales.value = new Intl.NumberFormat('de-DE').format(
                diferenciaventasanuales);

                if (diferencia_ventas_anuales.value.charAt(diferencia_ventas_anuales.value.length - 3) != ',' &&
                    diferencia_ventas_anuales.value.charAt(diferencia_ventas_anuales.value.length - 2) != ',') {
                    diferencia_ventas_anuales.value = diferencia_ventas_anuales.value + ",00";
                }

                if (parseFloat(diferencia_ventas_anuales.value) < 0) {
                    document.getElementById("diferencia_ventas_anuales").style.color = "red";
                } else {
                    document.getElementById("diferencia_ventas_anuales").style.color = "black";
                }
                // FIN DIFERENCIA VENTAS ANUALES  --------------------------------------------------------------------------------------------






                //PORCENTAJE DIFERENCIA INGRESO MENSUAL  --------------------------------------------------------------------------------------------
                difingremen = diferencia_ingreso_mensual.value.replaceAll('.', '');
                difingremen = difingremen.replaceAll(',', '.');

                presuingrmensual = presupuesto_ingreso_mensual.value.replaceAll('.', '');
                presuingrmensual = presuingrmensual.replaceAll(',', '.');
                porceningremensual = parseFloat(parseFloat(difingremen / presuingrmensual) * 100).toFixed(2);


                porcentaje_mensual.value = new Intl.NumberFormat('de-DE').format(porceningremensual);

                if (parseFloat(porcentaje_mensual.value) < 0) {
                    document.getElementById("proporcionmensual").style.color = "red";
                } else {
                    document.getElementById("proporcionmensual").style.color = "black";
                }
                // FIN PORCENTAJE DIFERENCIA INGRESO MENSUAL  --------------------------------------------------------------------------------------------


                //PORCENTAJE DIFERENCIA PAQUETE ANUAL  --------------------------------------------------------------------------------------------
                difpaqueanu = diferencia_paquete_anual.value.replaceAll('.', '');
                difpaqueanu = difpaqueanu.replaceAll(',', '.');

                presupaqanu = presupuesto_paquete_anual.value.replaceAll('.', '');
                presupaqanu = presupaqanu.replaceAll(',', '.');
                porcenanu = parseFloat((difpaqueanu / presupaqanu) * 100).toFixed(2);
                porcentaje_anual.value = new Intl.NumberFormat('de-DE').format(porcenanu);

                if (parseFloat(porcentaje_anual.value) < 0) {
                    document.getElementById("proporcionanual").style.color = "red";
                } else {
                    document.getElementById("proporcionanual").style.color = "black";
                }
                // FIN PORCENTAJE DIFERENCIA PAQUETE ANUAL  --------------------------------------------------------------------------------------------


                //PORCENTAJE DIFERENCIA VENTAS MENSUALES  --------------------------------------------------------------------------------------------
                difventmensua = diferencia_ventas_mensuales.value.replaceAll('.', '');
                difventmensua = difventmensua.replaceAll(',', '.');

                venmensu = ventas_mensuales.value.replaceAll('.', '');
                venmensu = venmensu.replaceAll(',', '.');
                porventmens = parseFloat((difventmensua / venmensu) * 100).toFixed(2);
                porcentaje_ventas_mensual.value = new Intl.NumberFormat('de-DE').format(porventmens);

                if (parseFloat(porcentaje_ventas_mensual.value) < 0) {
                    document.getElementById("proporcionventasmensual").style.color = "red";
                } else {
                    document.getElementById("proporcionventasmensual").style.color = "black";
                }
                // FIN PORCENTAJE DIFERENCIA VENTAS MENSUALES --------------------------------------------------------------------------------------------


                //PORCENTAJE DIFERENCIA VENTAS ANUALES  --------------------------------------------------------------------------------------------
                difvean = diferencia_ventas_anuales.value.replaceAll('.', '');
                difvean = difvean.replaceAll(',', '.');

                prepaan = ventas_anuales.value.replaceAll('.', '');
                prepaan = prepaan.replaceAll(',', '.');
                porvean = parseFloat((difvean / prepaan) * 100).toFixed(2);
                porcentaje_ventas_anuales.value = new Intl.NumberFormat('de-DE').format(porvean);

                if (parseFloat(porcentaje_ventas_anuales.value) < 0) {
                    document.getElementById("proporcionventasanual").style.color = "red";
                } else {
                    document.getElementById("proporcionventasanual").style.color = "black";
                }
                // FIN PORCENTAJE DIFERENCIA VENTAS ANUALES --------------------------------------------------------------------------------------------


                contador++;
            }

        }
    });





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


function showGraph() {


    const toggleButton = document.getElementById('toggle-grafica');
    const graficaContainer = document.getElementById('chart-container');
    if (graficaContainer.style.display === 'none') {
        // Mostrar la gráfica
        graficaContainer.style.display = 'block';
        // Crear la instancia de la gráfica
    }


    let categoria = $("#cboCategoria").val();
    let asignacion = $("#cboAsignaciones").val(); //
    var categ = "";
    var titulo = "";
    var tipo_asign = "";

    if (($("#cboAsignaciones").val()) === '1') {
        tipo_asign = "INGRESO MENSUAL"
    }
    if (($("#cboAsignaciones").val()) === '2') {
        tipo_asign = "INGRESO TOTAL MENSUAL"
    }
    if (($("#cboAsignaciones").val()) === '3') {
        tipo_asign = "PAQUETE ANUAL"
    }


    if (($("#cboCategoria").val()) === '1') {
        var min = 214;
        var max = 1000;
        categ = "ADMINISTRATIVO";
    } else {
        var min = 299;
        var max = 1000;
        categ = "PLANTA - TALLER - FÁBRICA";
    }

    titulo = "RECTA DE REGRESIÓN LINEAL - " + categ + " - " + tipo_asign;




    $.post("datos_grafica.php", {
        categoria: categoria,
        asignacion: asignacion
    }, function(data) {
        console.log(data);

        var puntajegrado2 = 0;
        var conteogradoI = 0;
        var sueldogradoI = 0;

        var puntajegradoII = 0;
        var conteogradoII = 0;
        var sueldogradoII = 0;

        var puntajegradoIII = 0;
        var conteogradoIII = 0;
        var sueldogradoIII = 0;

        var puntajegradoIV = 0;
        var conteogradoIV = 0;
        var sueldogradoIV = 0;

        var puntajegradoV = 0;
        var conteogradoV = 0;
        var sueldogradoV = 0;

        var puntajegradoVI = 0;
        var conteogradoVI = 0;
        var sueldogradoVI = 0;

        var puntajegradoVII = 0;
        var conteogradoVII = 0;
        var sueldogradoVII = 0;

        var puntajegradoVIII = 0;
        var conteogradoVIII = 0;
        var sueldogradoVIII = 0;

        var puntajegradoIX = 0;
        var conteogradoIX = 0;
        var sueldogradoIX = 0;

        var puntajegradoX = 0;
        var conteogradoX = 0;
        var sueldogradoX = 0;

        var puntajegradoXI = 0;
        var conteogradoXI = 0;
        var sueldogradoXI = 0;

        var puntajegradoXII = 0;
        var conteogradoXII = 0;
        var sueldogradoXII = 0;

        var puntajegradoXIII = 0;
        var conteogradoXIII = 0;
        var sueldogradoXIII = 0;

        var puntajegradoXIV = 0;
        var conteogradoXIV = 0;
        var sueldogradoXIV = 0;

        var puntajegradoXV = 0;
        var conteogradoXV = 0;
        var sueldogradoXV = 0;

        var maximosueldo = 0;

        const sueldosxy = [];


        var contador = 1;
        for (var i in data) {

            sueldosxy.push({
                x: data[i].puntajenomina,
                y: data[i].sueldonomina,
                nombre: data[i].nombres,
                cargo: data[i].nombrecargo,
            });


            if (contador == 1) {
                puntajegradoI = data[i].puntajegradoI;
                conteogradoI = data[i].conteogradoI;
                sueldogradoI = data[i].sueldogradoI;


                puntajegradoII = data[i].puntajegradoII;
                conteogradoII = data[i].conteogradoII;
                sueldogradoII = data[i].sueldogradoII;

                puntajegradoIII = data[i].puntajegradoIII;
                conteogradoIII = data[i].conteogradoIII;
                sueldogradoIII = data[i].sueldogradoIII;

                puntajegradoIV = data[i].puntajegradoIV;
                conteogradoIV = data[i].conteogradoIV;
                sueldogradoIV = data[i].sueldogradoIV;

                puntajegradoV = data[i].puntajegradoV;
                conteogradoV = data[i].conteogradoV;
                sueldogradoV = data[i].sueldogradoV;

                puntajegradoVI = data[i].puntajegradoVI;
                conteogradoVI = data[i].conteogradoVI;
                sueldogradoVI = data[i].sueldogradoVI;

                puntajegradoVII = data[i].puntajegradoVII;
                conteogradoVII = data[i].conteogradoVII;
                sueldogradoVII = data[i].sueldogradoVII;

                puntajegradoVIII = data[i].puntajegradoVIII;
                conteogradoVIII = data[i].conteogradoVIII;
                sueldogradoVIII = data[i].sueldogradoVIII;

                puntajegradoIX = data[i].puntajegradoIX;
                conteogradoIX = data[i].conteogradoIX;
                sueldogradoIX = data[i].sueldogradoIX;

                puntajegradoX = data[i].puntajegradoX;
                conteogradoX = data[i].conteogradoX;
                sueldogradoX = data[i].sueldogradoX;

                puntajegradoXI = data[i].puntajegradoXI;
                conteogradoXI = data[i].conteogradoXI;
                sueldogradoXI = data[i].sueldogradoXI;

                puntajegradoXII = data[i].puntajegradoXII;
                conteogradoXII = data[i].conteogradoXII;
                sueldogradoXII = data[i].sueldogradoXII;

                puntajegradoXIII = data[i].puntajegradoXIII;
                conteogradoXIII = data[i].conteogradoXIII;
                sueldogradoXIII = data[i].sueldogradoXIII;

                puntajegradoXIV = data[i].puntajegradoXIV;
                conteogradoXIV = data[i].conteogradoXIV;
                sueldogradoXIV = data[i].sueldogradoXIV;

                puntajegradoXV = data[i].puntajegradoXV;
                conteogradoXV = data[i].conteogradoXV;
                sueldogradoXV = data[i].sueldogradoXV;

                maximosueldo = data[i].maximosueldo;
                contador++
            }
        }


        var promediopuntajegradoI = 0;
        var promediosueldogradoI = 0;
        const xygradoI = [];

        promediopuntajegradoI = puntajegradoI / conteogradoI;
        promediosueldogradoI = sueldogradoI / conteogradoI;

        var promediopuntajegradoII = 0;
        var promediosueldogradoII = 0;
        const xygradoII = [];

        promediopuntajegradoII = puntajegradoII / conteogradoII;
        promediosueldogradoII = sueldogradoII / conteogradoII;



        var promediopuntajegradoIII = 0;
        var promediosueldogradoIII = 0;
        const xygradoIII = [];

        promediopuntajegradoIII = puntajegradoIII / conteogradoIII;
        promediosueldogradoIII = sueldogradoIII / conteogradoIII;



        var promediopuntajegradoIV = 0;
        var promediosueldogradoIV = 0;
        const xygradoIV = [];

        promediopuntajegradoIV = puntajegradoIV / conteogradoIV;
        promediosueldogradoIV = sueldogradoIV / conteogradoIV;



        var promediopuntajegradoV = 0;
        var promediosueldogradoV = 0;
        const xygradoV = [];

        promediopuntajegradoV = puntajegradoV / conteogradoV;
        promediosueldogradoV = sueldogradoV / conteogradoV;


        var promediopuntajegradoVI = 0;
        var promediosueldogradoVI = 0;
        const xygradoVI = [];

        promediopuntajegradoVI = puntajegradoVI / conteogradoVI;
        promediosueldogradoVI = sueldogradoVI / conteogradoVI;



        var promediopuntajegradoVII = 0;
        var promediosueldogradoVII = 0;
        const xygradoVII = [];

        promediopuntajegradoVII = puntajegradoVII / conteogradoVII;
        promediosueldogradoVII = sueldogradoVII / conteogradoVII;



        var promediopuntajegradoVIII = 0;
        var promediosueldogradoVIII = 0;
        const xygradoVIII = [];

        promediopuntajegradoVIII = puntajegradoVIII / conteogradoVIII;
        promediosueldogradoVIII = sueldogradoVIII / conteogradoVIII;



        var promediopuntajegradoIX = 0;
        var promediosueldogradoIX = 0;
        const xygradoIX = [];

        promediopuntajegradoIX = puntajegradoIX / conteogradoIX;
        promediosueldogradoIX = sueldogradoIX / conteogradoIX;


        var promediopuntajegradoX = 0;
        var promediosueldogradoX = 0;
        const xygradoX = [];

        promediopuntajegradoX = puntajegradoX / conteogradoX;
        promediosueldogradoX = sueldogradoX / conteogradoX;


        var promediopuntajegradoXI = 0;
        var promediosueldogradoXI = 0;
        const xygradoXI = [];

        promediopuntajegradoXI = puntajegradoXI / conteogradoXI;
        promediosueldogradoXI = sueldogradoXI / conteogradoXI;


        var promediopuntajegradoXII = 0;
        var promediosueldogradoXII = 0;
        const xygradoXII = [];

        promediopuntajegradoXII = puntajegradoXII / conteogradoXII;
        promediosueldogradoXII = sueldogradoXII / conteogradoXII;


        var promediopuntajegradoXIII = 0;
        var promediosueldogradoXIII = 0;
        const xygradoXIII = [];

        promediopuntajegradoXIII = puntajegradoXIII / conteogradoXIII;
        promediosueldogradoXIII = sueldogradoXIII / conteogradoXIII;


        var promediopuntajegradoXIV = 0;
        var promediosueldogradoXIV = 0;
        const xygradoXIV = [];

        promediopuntajegradoXIV = puntajegradoXIV / conteogradoXIV;
        promediosueldogradoXIV = sueldogradoXIV / conteogradoXIV;



        var promediopuntajegradoXV = 0;
        var promediosueldogradoXV = 0;
        const xygradoXV = [];

        promediopuntajegradoXV = puntajegradoXV / conteogradoXV;
        promediosueldogradoXV = sueldogradoXV / conteogradoXV;


        grados = [];
        grados.push({
            x: 0,
            y: 0
        });
        grados.push({
            x: promediopuntajegradoI,
            y: promediosueldogradoI
        });
        grados.push({
            x: promediopuntajegradoII,
            y: promediosueldogradoII
        });
        grados.push({
            x: promediopuntajegradoIII,
            y: promediosueldogradoIII
        });
        grados.push({
            x: promediopuntajegradoIV,
            y: promediosueldogradoIV
        });
        grados.push({
            x: promediopuntajegradoV,
            y: promediosueldogradoV
        });
        grados.push({
            x: promediopuntajegradoVI,
            y: promediosueldogradoVI
        });
        grados.push({
            x: promediopuntajegradoVII,
            y: promediosueldogradoVII
        });
        grados.push({
            x: promediopuntajegradoVIII,
            y: promediosueldogradoVIII
        });
        grados.push({
            x: promediopuntajegradoIX,
            y: promediosueldogradoIX
        });
        grados.push({
            x: promediopuntajegradoX,
            y: promediosueldogradoX
        });
        grados.push({
            x: promediopuntajegradoXI,
            y: promediosueldogradoXI
        });
        grados.push({
            x: promediopuntajegradoXII,
            y: promediosueldogradoXII
        });
        grados.push({
            x: promediopuntajegradoXIII,
            y: promediosueldogradoXII
        });
        grados.push({
            x: promediopuntajegradoXIV,
            y: promediosueldogradoXIV
        });
        grados.push({
            x: promediopuntajegradoXV,
            y: promediosueldogradoXV
        });


        console.log(grados);



        var graphTarget = document.getElementById('graphCanvas').getContext('2d');



        if (window.grafica) {
            window.grafica.clear();
            window.grafica.destroy();
        }



        window.grafica = new Chart(graphTarget, {
            data: {
                datasets: [{
                        label: "Ingreso",
                        data: sueldosxy,
                        borderColor: '#46d5f1',
                        backgroundColor: '#49e2ff',
                        type: 'bubble',
                        pointRadius: 6,
                        pointStyle: 'rectRot',
                        order: 1,
                    },
                    {
                        label: "Recta de Regresión",
                        data: [{
                            x: 0,
                            y: 0
                        }, {
                            x: 1000,
                            y: maximosueldo
                        }],
                        borderColor: '#44FF16',
                        backgroundColor: '#44FF16',
                        pointRadius: 1,
                        type: 'line',
                        order: 0
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        align: 'start',
                        display: true,
                        text: titulo

                    },
                    tooltip: {
                        callbacks: {
                            label: ((tooltipItem, data) => {
                                var nombre = tooltipItem.raw.nombre
                                var cargo = tooltipItem.raw.cargo
                                var puntos = "Puntaje: " + tooltipItem.raw.x
                                var sueldo = "Sueldo: " + tooltipItem.raw.y
                                return [nombre, cargo, puntos, sueldo]
                            })
                        }
                    }
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Puntaje'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Sueldos'
                        }
                    }
                }
            }
        });





    });

}
</script>

<?php 
            echo "<script>";
            echo "indicadores();";
            echo "</script>";
        

            if(isset($_GET['result'])){
                
                echo "<script>";
                echo "result();";
                echo "</script>";
            }
            
?>