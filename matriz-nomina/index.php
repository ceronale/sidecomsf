<?php include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; 


function tiempoTranscurridoFechas($fecha1)
{
    $fechaInicio = date("Y-m-d", strtotime($fecha1));
    $fechaFin = date("Y-m-d", strtotime('now'));
    $fecha1 = new DateTime($fechaInicio);
    $fecha2 = new DateTime($fechaFin);
    $fecha = $fecha1->diff($fecha2);
    $tiempo = "";
    //años
    if($fecha->y > 0)
    {
        $tiempo .= $fecha->y;
             
        if($fecha->y == 1)
            $tiempo .= " año, ";
        else
            $tiempo .= " años, ";
    }  
    //meses
    if($fecha->m > 0)
    {
        $tiempo .= $fecha->m;
             
        if($fecha->m == 1)
            $tiempo .= " mes, ";
        else
            $tiempo .= " meses, ";
    }
    //dias
    if($fecha->d > 0)
    {
        $tiempo .= $fecha->d;
             
        if($fecha->d == 1)
            $tiempo .= " día ";
        else
            $tiempo .= " días ";
    }      
    return $tiempo;
}
            
$matriz_nomina = "Cargar los datos requeridos en la Matriz, le permitirá revisar la estructura de los puestos/cargos valorados vs. Ingresos reales (Sueldos o Salarios mensuales y paquete anual); además visualizar en un gráfico, el orden o jerarquía tal como se presentan en la valoración.";
            ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <div class="card text-left">
            <div class="card-header">
                <span style="font-weight: bold; font-size: 25px; color: #3c8dbc;" onclick="info_tabla('Matriz de Nómina:','<?php echo $matriz_nomina; ?>')">Matriz de Nómina</span>
            </div>
        </div>

    </section>
    <!-- Content Header (Page header) -->

    <?php

    include_once 'class.crud.php';
    $crud = new crud();
    $categoria = $_GET['ca'];
    if (isset($_GET['inserted'])) {
    ?>
    <script>
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'La Nueva Nómina se ha registrado con exito!',
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
        title: 'Error al registrar la Nómina Nueva!',
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
        title: 'La Nómina se ha editado con exito!',
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
        title: 'Error al editar La Nómina!',
        showConfirmButton: false,
        timer: 3000
    })
    </script>
    <?php
    }
    ?>
<?php 

$info_sueldo_base_mensual = "Es la porción del sueldo o salario mensual que sirve de base para el cálculos de los aumentos por meritos ó desempeño.";
$info_ingreso_mensual = "Incluye todos los sueldos o salarios, bonos, gratificaciones, fondo de ahorro, ayuda despensa, bono alimentación, transporte y otros pagos (ingresos bruto), que perciba el trabajador en forma regular y permanente.";
$info_paquete_anual = "Incluye toda remuneración que percibe el trabajador anualmente tales como: Doce meses del ingreso mensual, bono vacacional, utilidades, bono de fin de año, aguinaldos, bonos especiales, bonos por desempeño o productividad, entre otros pagos.";
$info_factor_meses = "Es un indicador que señala los meses (y fracción) contenidos en el PAQUETE ANUAL (resulta de dividir el paquete anual entre el ingreso mensual).";
$info_otras_divisas = "Nos referimos al PAGO ADICIONAL que se realiza a ciertos trabajadores en moneda extranjera. (PAGO MENSUAL)";
$cargo_critico = "Lo podemos definir como aquellas funciones, actividades y tareas de un cargo, asociados al proceso productivo que se considera IMPRESCINDIBLE en la operación y cuyo ocupante ES ESCASO EN EL MERCADO, genera un alto costo. Los Cargos críticos no deben exceder el 10% del total de cargos."; 
$cargo_supervisor = "Cualquier persona que tenga el poder y la autoridad sobre uno o más trabajadores para realizar tareas y actividades de producción, es responsable de la productividad de sus subalternos. Según el nivel, la denominación del cargo varía como: Capataz, Jefe, Supervisor, Gerente, Coordinador o Encargado de una unidad, departamento o gerencia de nivel medio o alto."; 
?>
    <script>
    $(document).ready(function() {
        $('#example').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
            },
        });
    });
    </script>

    <div class='container'>
 <?php extract($crud->get_nombre_moneda()); ?>


    <input type="hidden" id="graficashow" name="graficashow" value="0">
        <div class="box-header with-border">
            <h4>Mostrar Gráfica</h4>
            <div class="row">
                <div class="col-sm-3 form-group">
                <select name="cboCategoria" id="cboCategoria" class="form-control input-sm"
                        onchange="redirectcategoria(this.value)">
                        <option value="1" <?php if($categoria == 1){echo "selected";} ?>>Administrativo</option>
                        <option value="2" <?php if($categoria == 2){echo "selected";} ?>>Plata - Taller - Fábrica
                        </option>
                    </select>
                </div>
                <div class="col-sm-3 form-group">
                    <select class="form-control input-sm" id="cboAsignaciones">
                        <option value="" selected disabled>-- Seleccione --</option>
                        <option value="1">Sueldo Base Mensual</option>
                        <option value="2">Ingreso Total Mensual</option>
                        <option value="3">Paquete Anual</option>
                    </select>
                </div>
                <div class="col-sm-2 form-group">
                    <button type="button" class="btn btn-success btn-block btn-sm" title="Generar gráfica"
                        id="btn-gengraph" onclick="showGraph()">Generar Gráfica</button>
                </div>

                <div class="col-sm-2 form-group">
                    <button type="button" class="btn btn-danger btn-block btn-sm" title="Mostrar/Ocultar gráfica"
                        id="toggle-grafica" onclick="mostrar_ocultar_grafica()">Mostrar/Ocultar Gráfica</button>
                </div>

                <?php /*
                <div class="col-sm-2 form-group">
                    <button type="button" class="btn btn-primary btn-block btn-sm open"
                        title="mostrar/ocultar gráfica">MOSTRAR</button>
                </div>
                <div class="col-sm-2 form-group">
                    <button type="button" id="delgraph" class="btn btn-danger btn-block btn-sm"
                        title="borrar gráfica">BORRAR</button>
                </div>
               */ ?>
            </div>

        </div>

       
            <div id="chart-container" style="display: none; background-color: white;">
            <br>
            <div class="row">
            <div class="col-md-5">  </div>
            <div class="col-md-3">
            <button type="button" class="btn btn-success btn-block btn-sm" title="Mostrar/Ocultar gráfica"
                        id="fs-doc-button">Pantalla Completa</button>
                        </div>
                        </div>
                <canvas id="graphCanvas"></canvas>
            </div>
        

        <div class='clearfix'></div><br />

        <?php
        
                $user = $_SESSION['user'];
                $escalas = $crud->dataview_escalas($categoria);
               
                extract($crud->get_datos_empresa($user['id_empresa']));	
                extract($crud->get_sum_empleados($categoria));	
                extract($crud->get_nivel_empresarial($nivel_empresarial));	
          
                
        ?>

        <div class="row">
            <div class="col-sm-2 form-group">
            <a href='#' onclick="crear_nomina('<?php echo date('d/m/Y', strtotime('now')); ?>')"
                    class='btn btn-large btn-dark'> &nbsp;
                    <img src="../assets/img/icons/nuevo-blanco.png" style="color: white !important;" height="20"
                        width="20" alt="Nuevo"> Nuevo</a>
                          
            </div>

            <div class="col-sm-2 form-group">
            <a href='#' onclick="ver_escala(<?php echo htmlspecialchars(json_encode($escalas)); ?>,'<?= $nombre_empresa ?>','<?= $categoria ?>','<?= $conteo ?>','<?= $nombre_nivel ?>','<?= $minimo_nivel ?>','<?= $maximo_nivel ?>')"
                    class='btn btn-large btn-info'> Ver Escala</a>

                       
            </div>

            <div class="col-sm-8 form-group" style="text-align: right;">
                <span style="font-size: 12px; color:red">(MONTOS EXPRESADOS EN <?=strtoupper($nombre_moneda)?>)</span>
            </div>
        </div>
        <br>
        <div class='container' style="overflow: auto; max-height: 600px;">
            <table id="example" class="table table-striped dt-responsive nowrap" style="width:100%">
                <thead style="position: sticky; top: 0; background-color: white;">
                    <tr>
                        <th></th>
                        <th>Grado</th>
                        <th>Puntaje</th>
                        <th>Puesto/Cargo</th>
                        <th style="color: #3c8dbc;" onclick="info_tabla('Cargo Crítico:','<?php echo $cargo_critico; ?>')">Cargo <br> Crítico</th>
                        <th style="color: #3c8dbc;" onclick="info_tabla('Cargo Supervisor:','<?php echo $cargo_supervisor; ?>')">Cargo <br> Supervisor</th>
                        <th>Departamento</th>
                        <th>Trabajador</th>
                        <th>Género</th>
                        <th>Nro de Identificación</th> 
                        <th>Fecha Ingreso</th>
                        <th>Tiempo de Servicio</th>
                        <th>Modalidad de <br> Trabajo</th>
                        <th style="color: #3c8dbc;" onclick="info_tabla('Sueldo Base Mensual:','<?php echo $info_sueldo_base_mensual; ?>')">Sueldo Base <br> Mensual</th>
                        <th style="color: #3c8dbc;" onclick="info_tabla('Ingreso Mensual:','<?php echo $info_ingreso_mensual; ?>')">Ingreso <br> Mensual</th>
                        <th style="color: #3c8dbc;" onclick="info_tabla('Paquete Anual:','<?php echo $info_paquete_anual; ?>')">Paquete <br> Anual</th>
                        <th style="color: #3c8dbc;" onclick="info_tabla('Factor:','<?php echo $info_factor_meses; ?>')">Factor <br> Meses</th>
                        <th style="color: #3c8dbc;" onclick="info_tabla('Otra Divisa:','<?php echo $info_otras_divisas; ?>')">Otra <br> Divisa</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                $nominas = $crud->dataview_nomina($categoria);
                if ($nominas != null) {
                    foreach ($nominas as $nomina) {
                        $tiempotrans = "<script>" . "tiempotranscurrido(".$nomina['fechaingreso'].")" . "</script>";
                ?>
                    <tr>
                        <td></td>
                        <td style="text-align: center;"><?php print($nomina['grado']); ?></td>
                        <td><?php print($nomina['mnpuntaje']); ?></td>
                        <td><?php print($nomina['nombrecargo']); ?></td>
                        <td style="text-align: center;"><?php if ($nomina['critico'] == "1") {
                                    print "Si";
                                } else {
                                    print "No";
                                }
                                ?></td>
                        <td style="text-align: center;"><?php if ($nomina['supervisor'] == "1") {
                                    print "Si";
                                } else {
                                    print "No";
                                }
                                ?></td>
                        <td><?php print($nomina['nombredepartamento']); ?></td>
                        <td><?php print($nomina['nombretrabajador']); ?></td>
                        <td><?php if ($nomina['mngenero'] == "M") {
                                    print "Masculino";
                                } else {
                                    print "Femenino";
                                }
                                ?>
                        </td>
                        <td><?php print($nomina['mndocumento']); ?></td>
                        <td><?php print( date("d/m/Y", strtotime($nomina['fechaingreso']))); ?></td>
                        <td><?php echo tiempoTranscurridoFechas($nomina['fechaingreso']); ?> </td>
                        <td><?php if ($nomina['modelotrabajo'] == "R") {
                                    print "Remoto (Home Office)";
                                }  
                                if ($nomina['modelotrabajo'] == "P") {
                                    print "Presencial";
                                }
                                if ($nomina['modelotrabajo'] == "M") { ?>
                                    <span style="font-weight: bold;  color: #3c8dbc; cursor: pointer;" onclick="info_tabla('Modalidad Mixta:','Presencial: <?= $nomina['porcentajepresencial']; ?>% ;; Remoto (Home Office): <?= $nomina['porcentajeremoto']; ?>%')">Mixto</span>
                                <?php }
                                ?>
                        </td>
                        <td><?php print($nomina['sueldobase']); ?></td>
                        <td><?php print($nomina['sueldo_mensual']); ?></td>
                        <td><?php print($nomina['paquete_anual']); ?></td>
                        <td><?php print($nomina['factormeses']); ?></td>
                        <td><?php if($nomina['idtipodivisa'] == 233)
                            { ?>
                            <i class="fas fa-dollar-sign"></i>
                       <?php }
                       if($nomina['idtipodivisa'] == 68)
                       { ?>
                          <i class="fas fa-euro-sign"></i>
                      <?php }
                       
                       print($nomina['monto_divisa']); ?></td>

                        <?php $funcioncargo = str_replace("\n", " " ,$nomina['funcioncargo']);   ?>
                        <td style="text-align: center">
                            <a onclick="editar_nomina('<?php print($nomina['id_nomina']); ?>',
                                '<?php print($nomina['categoriadepartamento']); ?>',
                                '<?php print($nomina['iddepartamento']); ?>',
                                '<?php print($nomina['nombredepartamento']); ?>',
                                '<?php print($nomina['idcargo']); ?>',
                                '<?php print($nomina['nombrecargo']); ?>',
                                '<?php echo $funcioncargo ?>',
                                '<?php print($nomina['mnpuntaje']); ?>',
                                '<?php print($nomina['grado']); ?>',
                                '<?php print($nomina['critico']); ?>',
                                '<?php print($nomina['supervisor']); ?>',
                                '<?php print($nomina['modelotrabajo']); ?>',
                                '<?php print($nomina['porcentajeremoto']); ?>',
                                '<?php print($nomina['porcentajepresencial']); ?>',
                                '<?php print($nomina['nombretrabajador']); ?>',
                                '<?php print($nomina['mndocumento']); ?>',
                                '<?php print($nomina['mngenero']); ?>',
                                '<?php echo $nomina['fechaingreso']; ?>',
                                '<?php echo tiempoTranscurridoFechas($nomina['fechaingreso']); ?>',
                                '<?php print($nomina['sueldobase']); ?>',
                                '<?php print($nomina['sueldo_mensual']); ?>',
                                '<?php print($nomina['paquete_anual']); ?>',
                                '<?php print($nomina['factormeses']); ?>',
                                '<?php print($nomina['monto_divisa']); ?>',
                                '<?php print($nomina['idtipodivisa']); ?>',
                                '<?php echo date('d/m/Y', strtotime('now')); ?>')">
                                <i class="fa fa-pencil" aria-hidden="true"></i></a>
                            &nbsp;&nbsp;&nbsp;&nbsp;

                            <a
                                onclick="eliminar_nomina('<?php print($nomina['id_nomina']); ?>','<?php print($nomina['nombretrabajador']); ?>')">
                                <i class="fa fa-trash" aria-hidden="true"></i></a>

                        </td>
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
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Grado</th>
                        <th>Puntaje</th>
                        <th>Cargo</th>
                        <th>Cargo Critico</th>
                        <th>Cargo Supervisor</th>
                        <th>Departamento</th>
                        <th>Trabajador</th>
                        <th>Género</th>
                        <th>Nro de Identificación</th>
                        <th>Fecha Ingreso</th>
                        <th>Tiempo de Servicio</th>
                        <th>Modalidad de <br> Trabajo</th>
                        <th>Sueldo Base Mensual</th>
                        <th>Ingreso Mensual</th>
                        <th>Paquete Anual</th>
                        <th>Factor Meses</th>
                        <th>Otra Divisa</th>
                        <th>Acción</th>
                    </tr>
                </tfoot>
            </table>




        </div>
    </div>
    <?php include_once('../layouts/footer.php'); ?>

    <script src="assets/js/nomina.js"></script>

    <script>
        function redirectcategoria(categoria) {
        window.location.href = "../matriz-nomina/?ca=" + categoria;
    }

$(document).ready(function() {
    $(".hidden").hide();

});

function ver_escala(escalas, nombre_empresa,categoria,conteo,nombre_nivel,minimo_nivel,maximo_nivel) {
    var catego= "";
    if(categoria == 1)
    {
        catego = "Administrativo";
    }
    if(categoria == 2)
    {
        catego = "Planta - Taller - Fábrica";
    }
    var html= `   <span class="text-center"><span class="glyphicon glyphicon-check"></span> Clasificación de Empresas en base al N° de trabajadores</span><br>
                    <span class="text-center">(cifras aproximadas) </span><br>
                    
                    <br>
                    <br>

                    <div class="text-left" style="font-size: 14px">
                    <span style="color: 25B9FF">Empresa: ${nombre_empresa} </span><br>
                    <span style="color: 25B9FF">Categoria: ${catego} </span><br>
                    <span style="color: red">Total Trabajadores: ${conteo} </span>
                    </div>
                    <br>

                    <span style="font-size: 30px"><strong>${nombre_nivel.trim()}s Empresas </strong></span><br>
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
                        escalas.forEach(function (escalas) {
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
      title: "Escala Empresarial",
      html: html,
      width: '800px',
      showConfirmButton: false,
   });
   $(document).ready(function() {
        $('#escalas').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
            },
        });
    });


    }

function mostrar_ocultar_grafica() 
{
   
const toggleButton = document.getElementById('toggle-grafica');
const graficaContainer = document.getElementById('chart-container');


  // Verificar si la gráfica está visible
  if (graficaContainer.style.display === 'none') {
    // Mostrar la gráfica
    graficaContainer.style.display = 'block';
    // Crear la instancia de la gráfica
  }
  else
  {
     // Ocultar la gráfica
     graficaContainer.style.display = 'none';
    // Destruir la instancia de la gráfica
  }



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
        var tipoempresa = 0;
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
                tipoempresa = data[i].tipoempresa;
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

        var promediosueldomaximo = 0;
        var promediopuntajemaximo = 0;

        var promediopuntajegradoI = 0;
        var promediosueldogradoI = 0;
        const xygradoI = [];

        promediopuntajegradoI = puntajegradoI / conteogradoI;
        promediosueldogradoI = sueldogradoI / conteogradoI;

        promediosueldomaximo = promediosueldogradoI;
        promediopuntajemaximo = promediopuntajegradoI;

        grados = [];
        grados.push({
            x: 0,
            y: 0
        });
        grados.push({
            x: promediopuntajegradoI,
            y: promediosueldogradoI
        });

        if(tipoempresa >= 2)
        {
        var promediopuntajegradoII = 0;
        var promediosueldogradoII = 0;
        const xygradoII = [];

        promediopuntajegradoII = puntajegradoII / conteogradoII;
        promediosueldogradoII = sueldogradoII / conteogradoII;

        promediosueldomaximo = promediosueldogradoII;
        promediopuntajemaximo = promediopuntajegradoII;

        grados.push({
            x: promediopuntajegradoII,
            y: promediosueldogradoII
        });
        }
       
        if(tipoempresa >= 3)
        {

        var promediopuntajegradoIII = 0;
        var promediosueldogradoIII = 0;
        const xygradoIII = [];

        promediopuntajegradoIII = puntajegradoIII / conteogradoIII;
        promediosueldogradoIII = sueldogradoIII / conteogradoIII;

        promediosueldomaximo = promediosueldogradoIII;
        promediopuntajemaximo = promediopuntajegradoIII; 

        grados.push({
            x: promediopuntajegradoIII,
            y: promediosueldogradoIII
        });
        }

        if(tipoempresa >= 4)
        {
        var promediopuntajegradoIV = 0;
        var promediosueldogradoIV = 0;
        const xygradoIV = [];

        promediopuntajegradoIV = puntajegradoIV / conteogradoIV;
        promediosueldogradoIV = sueldogradoIV / conteogradoIV;

        promediosueldomaximo = promediosueldogradoIV;
        promediopuntajemaximo = promediopuntajegradoIV; 

        grados.push({
            x: promediopuntajegradoIV,
            y: promediosueldogradoIV
        });
        }

        if(tipoempresa >= 5)
        {
        var promediopuntajegradoV = 0;
        var promediosueldogradoV = 0;
        const xygradoV = [];

        promediopuntajegradoV = puntajegradoV / conteogradoV;
        promediosueldogradoV = sueldogradoV / conteogradoV;

        promediosueldomaximo = promediosueldogradoV;
        promediopuntajemaximo = promediopuntajegradoV; 

        grados.push({
            x: promediopuntajegradoV,
            y: promediosueldogradoV
        });
        }

        if(tipoempresa >= 6)
        {
        var promediopuntajegradoVI = 0;
        var promediosueldogradoVI = 0;
        const xygradoVI = [];

        promediopuntajegradoVI = puntajegradoVI / conteogradoVI;
        promediosueldogradoVI = sueldogradoVI / conteogradoVI;

        promediosueldomaximo = promediosueldogradoVI;
        promediopuntajemaximo = promediopuntajegradoVI; 

        grados.push({
            x: promediopuntajegradoVI,
            y: promediosueldogradoVI
        });
        }

        if(tipoempresa >= 7)
        {
        var promediopuntajegradoVII = 0;
        var promediosueldogradoVII = 0;
        const xygradoVII = [];

        promediopuntajegradoVII = puntajegradoVII / conteogradoVII;
        promediosueldogradoVII = sueldogradoVII / conteogradoVII;

        promediosueldomaximo = promediosueldogradoVII;
        promediopuntajemaximo = promediopuntajegradoVII; 

        grados.push({
            x: promediopuntajegradoVII,
            y: promediosueldogradoVII
        });
        }

        if(tipoempresa >= 8)
        {
        var promediopuntajegradoVIII = 0;
        var promediosueldogradoVIII = 0;
        const xygradoVIII = [];

        promediopuntajegradoVIII = puntajegradoVIII / conteogradoVIII;
        promediosueldogradoVIII = sueldogradoVIII / conteogradoVIII;

        promediosueldomaximo = promediosueldogradoVIII;
        promediopuntajemaximo = promediopuntajegradoVIII; 

        grados.push({
            x: promediopuntajegradoVIII,
            y: promediosueldogradoVIII
        });
        }

        if(tipoempresa >= 9)
        {
        var promediopuntajegradoIX = 0;
        var promediosueldogradoIX = 0;
        const xygradoIX = [];

        promediopuntajegradoIX = puntajegradoIX / conteogradoIX;
        promediosueldogradoIX = sueldogradoIX / conteogradoIX;

        promediosueldomaximo = promediosueldogradoIX;
        promediopuntajemaximo = promediopuntajegradoIX; 

        grados.push({
            x: promediopuntajegradoIX,
            y: promediosueldogradoIX
        });
        }

        if(tipoempresa >= 10)
        {
        var promediopuntajegradoX = 0;
        var promediosueldogradoX = 0;
        const xygradoX = [];

        promediopuntajegradoX = puntajegradoX / conteogradoX;
        promediosueldogradoX = sueldogradoX / conteogradoX;

        promediosueldomaximo = promediosueldogradoX;
        promediopuntajemaximo = promediopuntajegradoX; 

        grados.push({
            x: promediopuntajegradoX,
            y: promediosueldogradoX
        });
        }

        if(tipoempresa >= 11)
        {
        var promediopuntajegradoXI = 0;
        var promediosueldogradoXI = 0;
        const xygradoXI = [];

        promediopuntajegradoXI = puntajegradoXI / conteogradoXI;
        promediosueldogradoXI = sueldogradoXI / conteogradoXI;

        promediosueldomaximo = promediosueldogradoXI;
        promediopuntajemaximo = promediopuntajegradoXI; 

        grados.push({
            x: promediopuntajegradoXI,
            y: promediosueldogradoXI
        });
        }

        if(tipoempresa >= 12)
        {
        var promediopuntajegradoXII = 0;
        var promediosueldogradoXII = 0;
        const xygradoXII = [];

        promediopuntajegradoXII = puntajegradoXII / conteogradoXII;
        promediosueldogradoXII = sueldogradoXII / conteogradoXII;

        promediosueldomaximo = promediosueldogradoXII;
        promediopuntajemaximo = promediopuntajegradoXII;
        
        grados.push({
            x: promediopuntajegradoXII,
            y: promediosueldogradoXII
        });
        }

        if(tipoempresa >= 13)
        {
        var promediopuntajegradoXIII = 0;
        var promediosueldogradoXIII = 0;
        const xygradoXIII = [];

        promediopuntajegradoXIII = puntajegradoXIII / conteogradoXIII;
        promediosueldogradoXIII = sueldogradoXIII / conteogradoXIII;

        promediosueldomaximo = promediosueldogradoXIII;
        promediopuntajemaximo = promediopuntajegradoXIII; 

        grados.push({
            x: promediopuntajegradoXIII,
            y: promediosueldogradoXII
        });
        }

        if(tipoempresa >= 14)
        {
        var promediopuntajegradoXIV = 0;
        var promediosueldogradoXIV = 0;
        const xygradoXIV = [];

        promediopuntajegradoXIV = puntajegradoXIV / conteogradoXIV;
        promediosueldogradoXIV = sueldogradoXIV / conteogradoXIV;

        promediosueldomaximo = promediosueldogradoXIV;
        promediopuntajemaximo = promediopuntajegradoXIV; 

        grados.push({
            x: promediopuntajegradoXIV,
            y: promediosueldogradoXIV
        });
        }

        if(tipoempresa >= 15)
        {
        var promediopuntajegradoXV = 0;
        var promediosueldogradoXV = 0;
        const xygradoXV = [];

        promediopuntajegradoXV = puntajegradoXV / conteogradoXV;
        promediosueldogradoXV = sueldogradoXV / conteogradoXV;

        promediosueldomaximo = promediosueldogradoXV;
        promediopuntajemaximo = promediopuntajegradoXV; 

        grados.push({
            x: promediopuntajegradoXV,
            y: promediosueldogradoXV
        });
        }
    

// Calcular la media de x e y
const x_mean = sueldosxy.reduce((total, value) => total + parseFloat(value.x), 0) / sueldosxy.length;
const y_mean = sueldosxy.reduce((total, value) => total + parseFloat(value.y), 0) / sueldosxy.length;

// Calcular la pendiente (m) y la intersección en el eje y (b)
const numerator = sueldosxy.reduce((total, value) => total + ((parseFloat(value.x) - x_mean) * (parseFloat(value.y) - y_mean)), 0);
const denominator = sueldosxy.reduce((total, value) => total + ((parseFloat(value.x) - x_mean) ** 2), 0);
const m = numerator / denominator;
const b = y_mean - (m * x_mean);

// Crear un arreglo con los valores de la recta de regresión
const regressionLine = [];
for (let i = 0; i < sueldosxy.length; i++) {
  const x = parseFloat(sueldosxy[i].x);
  const y = m * x + b;
  regressionLine.push({x, y});
}

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
                        data: regressionLine,
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
                            label:((tooltipItem, data) => {
                            var nombre = tooltipItem.raw.nombre
                            var cargo = tooltipItem.raw.cargo
                            var puntos = "Puntaje: " + tooltipItem.raw.x
                            var sueldo = "Sueldo: " + tooltipItem.raw.y
                            return  [nombre, cargo, puntos, sueldo ]
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
    <script src="https://momentjs.com/downloads/moment.js"></script>