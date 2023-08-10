<?php include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; ?>
<link rel="stylesheet" href="assets/css/style.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <div class="card text-left">
            <div class="card-header">
                <span style="font-weight: bold; font-size: 25px; color: #3c8dbc; cursor: pointer;" onclick="info_tabla('Matriz de beneficios:','Representa la erogación de la empresa u organización para los trabajadores por concepto de beneficios legales o contractuales, relacionados con la calidad de vida y la protección laboral, pagados en dinero o especie por períodos determinados, sin incidencia en prestaciones sociales como vacaciones, utilidades, entre otras.')">Matriz de beneficios</span>
            </div>
        </div>

    </section>
    <!-- Content Header (Page header) -->

    <?php

    include_once 'class.crud.php';
    $crud = new crud();
    $niveles = $crud->getNivelEmpresarial();
    $periodos = $crud->getPeriodos();
    $beneficios = $crud->getBeneficios();
    extract($crud->get_nombre_moneda());
    if (isset($_POST['btn-send'])) {
        $id_pe = strip_tags($_POST['mi-select']);
        $niveles_beneficios = $crud->getNivelBeneficios($id_pe);
        if ($niveles_beneficios == null) {
            $niveles_beneficios = [];
        }
    } else if (isset($_GET['idp'])) {
        $id_pe = $_GET['idp'];
        $niveles_beneficios = $crud->getNivelBeneficios($id_pe);
        if ($niveles_beneficios == null) {
            $niveles_beneficios = [];
        }
    } else {
        $niveles_beneficios = $crud->getNivelBeneficiosinicial();
        if (count($niveles_beneficios) == 1 && isset($niveles_beneficios['max_id_periodo'])) {
            $id_pe = $niveles_beneficios["max_id_periodo"];
            unset($niveles_beneficios["max_id_periodo"]);
            $niveles_beneficios = [];
        } else {
            $id_pe = $niveles_beneficios["max_id_periodo"];
            unset($niveles_beneficios["max_id_periodo"]);
        }
    }

    if (isset($_GET['inserted'])) {
    ?>
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'El período se ha registrado con exito!',
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
                title: 'Error al registrar el período!',
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
                title: 'El período se ha editado con exito!',
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
                title: 'Error al editar el período!',
                showConfirmButton: false,
                timer: 3000
            })
        </script>
    <?php
    }
    ?>

    <script>
        $(document).ready(function() {
            $.fn.dataTable.ext.errMode = 'none';
            $('#example').on('error.dt', function(e, settings, techNote, message) {
                console.log('An error has been reported by DataTables: ', message);
            }).DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                },
                'iDisplayLength': 50,
            });
        });
        $(document).ready(function() {
            $.fn.dataTable.ext.errMode = 'none';
            $('#example2').on('error.dt', function(e, settings, techNote, message) {
                console.log('An error has been reported by DataTables: ', message);
            }).DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                },
                'iDisplayLength': 50,
            });
        });
    </script>




    <div class='container' style="overflow: auto; max-height: 600px;">
        <div>
            <div class="row">
                <div class="col-sm">
                    <a href="#" onclick="crear_periodo()" class="btn btn-primary btn3d">+ Agregar período</a>
                    <a href="/sidecoms/beneficios" class="btn btn-primary btn3d">Beneficios</a>
                    <a href="/sidecoms/nivel-empresarial" class="btn btn-primary btn3d">Nivel de aplicación de beneficios</a>
                </div>

                <div class="col-sm">

                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm">
                    <form id="mi-formulario" method="POST" action="">
                        <select name="mi-select" id="periodos" class="form-select form-control">
                            <?php foreach ($periodos as $periodo) { ?>
                                <option value="<?php echo $periodo['id']; ?>" <?php if ($periodo['id'] == $id_pe) {
                                                                                    echo 'selected';
                                                                                } ?>><?php echo $periodo['nombre'] . ' (' . $periodo['fecha_inicio_formato'] . ' - ' . $periodo['fecha_fin_formato'] . ')'; ?></option>
                            <?php } ?>
                        </select>
                        <button type="submit" name="btn-send" id="btn-send" style="display: none;"></button>
                    </form>

                    <script>
                        // Detectar el cambio en el select
                        $('#periodos').on('change', function() {
                            // Mostrar y hacer clic en el botón oculto
                            $('#btn-send').show().click();

                        });
                    </script>
                </div>
                <div class="col-sm-8 form-group" style="text-align: right;">
                    <span style="font-size: 12px; color:red">(MONTOS EXPRESADOS EN <?= strtoupper($nombre_moneda) ?>)</span>
                </div>

            </div>

        </div>
        <div class='clearfix'></div><br />

        <ul class="nav nav-tabs nav-fill">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab1" style="font-weight: bold; font-size: 1.2em;">Asignación de Beneficios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab2" style="font-weight: bold; font-size: 1.2em;">Cálculos - Resultados</a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="tab1" class="tab-pane fade show active">

                <div id="tabla-container" class="mt-3">
                    <table id="example" class="table table-striped dt-responsive nowrap" style="width:100%">
                        <thead style="position: sticky; top: 0; background-color: white;">
                            <tr>
                                <th>Tipo</th>
                                <th>Beneficios</th>
                                <?php
                                if (empty($niveles)) {
                                    $niveles = array(); // si está vacío, definir $niveles como un array vacío
                                }
                                if (!empty($niveles)) {
                                    foreach ($niveles as $nivel) {
                                ?>
                                        <th><?php echo $nivel['nombre']; ?></th>
                                <?php
                                    }
                                }
                                ?>
                                <th>Eliminar </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($beneficios)) { ?>
                                <?php foreach ($beneficios as $beneficio) {
                                    $idx = $crud->getCalculoBeneficio($beneficio['id'], $id_pe);
                                ?>
                                    <tr>
                                        <td><?php echo $beneficio['tipo_pago']; ?></td>
                                        <td><?php echo $beneficio['nombre']; ?></td>
                                        <?php foreach ($niveles as $nivel) {
                                            $checked = '';
                                            foreach ($niveles_beneficios as $nb) {

                                                if ($nb['id_beneficios'] == $beneficio['id'] && $nb['id_nivel_organizativo'] == $nivel['id']) {
                                                    $checked = 'checked';
                                                    break;
                                                }
                                            }
                                        ?>
                                            <td><input type="checkbox" name="niveles_beneficios[]" value="1" data-beneficio="<?php echo $beneficio['id']; ?>" data-nivel="<?php echo $nivel['id']; ?>" <?php echo $checked; ?>></td>
                                        <?php } ?>
                                        <td style="text-align: center">

                                            <a onclick="eliminar_beneficio('<?php print($beneficio['id']) ?>','<?php print($beneficio['nombre']) ?>','<?php print($id_pe) ?>')">
                                                <i class="fa fa-trash" aria-hidden="true"></i></a>

                                        </td>
                                    </tr>
                                <?php } ?>

                            <?php } else { ?>
                                <tr>
                                    <td colspan="9">No hay registros</td>
                                </tr>
                            <?php } ?>
                            <script>
                                $('input[type="checkbox"]').on('change', function() {
                                    var beneficioId = $(this).data('beneficio');
                                    var nivelId = $(this).data('nivel');
                                    var isChecked = $(this).prop('checked');
                                    if (isChecked) {

                                        // Call the insertNivelBeneficio() method in your PHP file if the checkbox is checked
                                        $.ajax({
                                            url: 'save.php',
                                            type: 'POST',
                                            data: {
                                                insertCheck: 'insertNivelBeneficio',
                                                beneficioId: beneficioId,
                                                nivelId: nivelId,
                                                id_pe: <?php echo $id_pe ?> // Agregar el valor 
                                            },
                                            success: function(response) {

                                            }
                                        });
                                    } else {
                                        $.ajax({
                                            url: 'save.php',
                                            type: 'POST',
                                            data: {
                                                deleteCheck: 'insertNivelBeneficio',
                                                beneficioId: beneficioId,
                                                nivelId: nivelId,
                                                id_pe: <?php echo $id_pe ?> // Agregar el valor 
                                            },
                                            success: function(response) {

                                            }
                                        });
                                    }
                                });
                            </script>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Tipo</th>
                                <th>Beneficios</th>
                                <?php
                                if (empty($niveles)) {
                                    $niveles = array(); // si está vacío, definir $niveles como un array vacío
                                }
                                if (!empty($niveles)) {
                                    foreach ($niveles as $nivel) {
                                ?>
                                        <th><?php echo $nivel['nombre']; ?></th>
                                <?php
                                    }
                                }
                                ?>
                                <th>Eliminar </th>
                            </tr>
                        </tfoot>
                    </table>

                </div>

            </div>
            <div id="tab2" class="tab-pane fade">
                <style>
                    /* Estilo por defecto */
                    .blue-text {
                        color: blue;
                    }

                    /* Estilo para valores negativos que sobreescribe el estilo anterior */
                    .red-text {
                        color: red;
                    }

                    /* Estilo más específico para los campos <td> con clase .blue-text */
                    td.blue-text {
                        color: blue !important;
                    }

                    /* Estilo más específico para los campos <td> con clase .red-text */
                    td.red-text {
                        color: red !important;
                    }
                </style>

                <div id="tabla-container" class="mt-3">
                    <table id="example2" class="table table-striped dt-responsive nowrap" style="width:100%">
                        <thead style="position: sticky; top: 0; background-color: white;">
                            <tr>
                                <th>Tipo</th>
                                <th>Beneficios</th>
                                <th>Niveles</th>
                                <th>Monto del pago</th>
                                <th>Nro de trabajdores</th>
                                <th>Frecuencia de pago</th>
                                <th>Total</th>
                                <th>Presupuesto</th>
                                <th>Diferencia</th>
                                <th>Cálculos</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            // Función de comparación personalizada
                            function compararBeneficios($a, $b)
                            {
                                if ($a['tipo_pago'] == $b['tipo_pago']) {
                                    return 0;
                                }
                                if ($a['tipo_pago'] == 'Fijo') {
                                    return -1;
                                }
                                return 1;
                            }

                            // Separar los beneficios en ocasionales y fijos
                            $beneficios_ocasionales = array();
                            $beneficios_fijos = array();
                            if ($beneficios) {
                                foreach ($beneficios as $beneficio) {
                                    if ($beneficio['tipo_pago'] == 'Ocasional') {
                                        $beneficios_ocasionales[] = $beneficio;
                                    } else {
                                        $beneficios_fijos[] = $beneficio;
                                    }
                                }
                            }




                            // Ordenar losbeneficios fijos por tipo_pago
                            usort($beneficios_fijos, 'compararBeneficios');

                            $total_fijos = 0;
                            $total_presupuesto = 0;
                            $total_diferencia = 0;

                            if (!empty($beneficios_fijos)) {
                                foreach ($beneficios_fijos as $beneficio) {
                                    $calculox = $crud->getCalculoBeneficio($beneficio['id'], $id_pe);

                                    // Validar si $calculox está vacío o no
                                    if (!empty($calculox)) {
                                        $monto = isset($calculox[0]['monto']) ? $calculox[0]['monto'] : '';
                                        $cantidad_trabajadores = isset($calculox[0]['cantidad_trabajadores']) ? $calculox[0]['cantidad_trabajadores'] : '';
                                        $frecuencia = isset($calculox[0]['frecuencia']) ? $calculox[0]['frecuencia'] : '';
                                        $presupuesto = isset($calculox[0]['presupuesto']) ? $calculox[0]['presupuesto'] : '';
                                    } else {
                                        $monto = 0;
                                        $cantidad_trabajadores = 0;
                                        $frecuencia = 0;
                                        $presupuesto = 0;
                                    }
                                    // Validar que los valores numéricos sean válidos
                                    if (is_numeric($monto) && is_numeric($cantidad_trabajadores) && is_numeric($frecuencia) && is_numeric($presupuesto)) {
                                        // Calcular los valores necesarios
                                        $total = $monto * $cantidad_trabajadores * $frecuencia;
                                        $total_fijos += $total;
                                        $diferencia = $presupuesto - $total;
                                        $styleClass = ($diferencia >= 0) ? 'blue-text' : 'red-text';
                                        $total_presupuesto += $presupuesto;
                                        $total_diferencia += $diferencia;
                            ?>
                                        <tr>
                                            <td><?php echo $beneficio['tipo_pago']; ?></td>
                                            <td><?php echo $beneficio['nombre']; ?></td>

                                            <?php
                                            $niveles_lista = '';
                                            foreach ($niveles as $nivel) {
                                                $checked = '';
                                                foreach ($niveles_beneficios as $nb) {
                                                    if ($nb['id_beneficios'] == $beneficio['id'] && $nb['id_nivel_organizativo'] == $nivel['id']) {
                                                        $checked = 'checked';
                                                        break;
                                                    }
                                                }
                                                if ($checked == 'checked') {
                                                    $niveles_lista .= '<li>' . $nivel['nombre'] . '</li>';
                                                }
                                            }
                                            ?>
                                            <td>
                                                <?php if (!empty($niveles_lista)) { ?>
                                                    <ul style="overflow-y: scroll; max-height: 65px;">
                                                        <?php echo $niveles_lista; ?>
                                                    </ul>
                                                <?php } ?>
                                            </td>

                                            <td><?php echo number_format($monto, 2, ',', '.'); ?></td>
                                            <td><?php echo $cantidad_trabajadores; ?></td>
                                            <td><?php echo $frecuencia; ?></td>
                                            <td><?php echo number_format($total, 2, ',', '.'); ?></td>
                                            <td><?php echo number_format($presupuesto, 2, ',', '.'); ?></td>
                                            <td class="<?php echo $styleClass; ?>"><?php echo number_format($diferencia, 2, ',', '.'); ?></td>
                                            <td style="text-align: center">
                                                <a onclick="editar_calculos(<?php echo htmlspecialchars(json_encode($calculox)); ?>, '<?php print($beneficio['id']) ?>', '<?php print($beneficio['tipo_pago']) ?>', '<?php print($beneficio['nombre']) ?>')">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                            </td>
                                        </tr>
                                <?php

                                    } else {
                                        // $calculox está vacío

                                    }
                                }
                            }

                            // Generar la línea extra para los beneficios fijos
                            if (!empty($beneficios_fijos)) {
                                ?>
                                <tr>
                                    <td colspan="6" style="text-align: right;"><strong>S U B - T O T A L E S: </strong></td>
                                    <td><strong><?php echo number_format($total_fijos, 2, ',', '.'); ?></strong></td>
                                    <td><strong><?php echo number_format($total_presupuesto, 2, ',', '.'); ?></strong></td>
                                    <td><strong><?php echo number_format($total_diferencia, 2, ',', '.'); ?></strong></td>
                                </tr>
                                <?php
                            }
                            // Ordenar los beneficios ocasionales por tipo_pago
                            usort($beneficios_ocasionales, 'compararBeneficios');

                            // Generar la tabla HTML para los beneficios ocasionales
                            $total_ocasionales = 0;
                            $total_presupuesto_ocasionales = 0;
                            $total_diferencia_ocasionales = 0;

                            if (!empty($beneficios_ocasionales)) {
                                foreach ($beneficios_ocasionales as $beneficio) {
                                    $calculox = $crud->getCalculoBeneficio($beneficio['id'], $id_pe);

                                    // Validar si $calculox está vacío o no
                                    if (!empty($calculox)) {
                                        $monto = isset($calculox[0]['monto']) ? $calculox[0]['monto'] : '';
                                        $cantidad_trabajadores = isset($calculox[0]['cantidad_trabajadores']) ? $calculox[0]['cantidad_trabajadores'] : '';
                                        $frecuencia = isset($calculox[0]['frecuencia']) ? $calculox[0]['frecuencia'] : '';
                                        $presupuesto = isset($calculox[0]['presupuesto']) ? $calculox[0]['presupuesto'] : '';
                                    } else {
                                        $monto = 0;
                                        $cantidad_trabajadores = 0;
                                        $frecuencia = 0;
                                        $presupuesto = 0;
                                    }
                                    // Validar que los valores numéricos sean válidos
                                    if (is_numeric($monto) && is_numeric($cantidad_trabajadores) && is_numeric($frecuencia) && is_numeric($presupuesto)) {
                                        // Calcular los valores necesarios
                                        $total = $monto * $cantidad_trabajadores * $frecuencia;
                                        $total_ocasionales += $total;
                                        $diferencia = $presupuesto - $total;
                                        $styleClass = ($diferencia >= 0) ? 'blue-text' : 'red-text';
                                        $total_presupuesto_ocasionales += $presupuesto;
                                        $total_diferencia_ocasionales += $diferencia;
                                ?>
                                        <tr>
                                            <td><?php echo $beneficio['tipo_pago']; ?></td>
                                            <td><?php echo $beneficio['nombre']; ?></td>

                                            <?php
                                            $niveles_lista = '';
                                            foreach ($niveles as $nivel) {
                                                $checked = '';
                                                foreach ($niveles_beneficios as $nb) {
                                                    if ($nb['id_beneficios'] == $beneficio['id'] && $nb['id_nivel_organizativo'] == $nivel['id']) {
                                                        $checked = 'checked';
                                                        break;
                                                    }
                                                }
                                                if ($checked == 'checked') {
                                                    $niveles_lista .= '<li>' . $nivel['nombre'] . '</li>';
                                                }
                                            }
                                            ?>
                                            <td>
                                                <?php if (!empty($niveles_lista)) { ?>
                                                    <ul style="overflow-y: scroll; max-height: 65px;">
                                                        <?php echo $niveles_lista; ?>
                                                    </ul>
                                                <?php } ?>
                                            </td>

                                            <td><?php echo number_format($monto, 2, ',', '.'); ?></td>
                                            <td><?php echo $cantidad_trabajadores; ?></td>
                                            <td><?php echo $frecuencia; ?></td>
                                            <td><?php echo number_format($total, 2, ',', '.'); ?></td>
                                            <td><?php echo number_format($presupuesto, 2, ',', '.'); ?></td>




                                            <td class="<?php echo $styleClass; ?>"><?php echo number_format($diferencia, 2, ',', '.'); ?></td>

                                            <td style="text-align: center">
                                                <a onclick="editar_calculos(<?php echo htmlspecialchars(json_encode($calculox)); ?>, '<?php print($beneficio['id']) ?>', '<?php print($beneficio['tipo_pago']) ?>', '<?php print($beneficio['nombre']) ?>')">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                            </td>
                                        </tr>

                                <?php
                                    } else {
                                        // Alguno de los valores no es numérico
                                        echo '<tr><td colspan="9">Los valores de cálculo no son válidos</td></tr>';
                                    }
                                }
                            }

                            // Generar la línea extra para los beneficios ocasionales
                            if (!empty($beneficios_ocasionales)) {
                                ?>
                                <tr>
                                    <td colspan="6" style="text-align: right;"><strong>S U B - T O T A L E S: </strong></td>
                                    <td><strong><?php echo number_format($total_ocasionales, 2, ',', '.'); ?></strong></td>
                                    <td><strong><?php echo number_format($total_presupuesto_ocasionales, 2, ',', '.'); ?></strong></td>
                                    <td><strong><?php echo number_format($total_diferencia_ocasionales, 2, ',', '.'); ?></strong></td>
                                </tr>
                            <?php
                            }
                            if (!empty($beneficios_ocasionales) && !empty($beneficios_fijos)) {
                            ?>
                                <tr>
                                    <td colspan="6" style="text-align: right;"><strong> T O T A L - G E N E R A L: </strong></td>
                                    <td><strong><?php echo number_format($total_ocasionales + $total_fijos, 2, ',', '.'); ?></strong></td>
                                    <td><strong><?php echo number_format($total_presupuesto_ocasionales + $total_presupuesto, 2, ',', '.'); ?></strong></td>
                                    <td><strong><?php echo number_format($total_diferencia_ocasionales + $total_diferencia, 2, ',', '.'); ?></strong></td>
                                </tr>
                            <?php
                            }

                            // Línea extra
                            ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Tipo</th>
                                <th>Beneficios</th>
                                <th>Niveles</th>
                                <th>Monto del pago</th>
                                <th>Nro de trabajdores</th>
                                <th>Frecuencia de pago</th>
                                <th>Total</th>
                                <th>Presupuesto</th>
                                <th>Diferencia</th>
                                <th>Cálculos</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('.nav-tabs a').click(function() {
                    $(this).tab('show');
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                // Leer el valor almacenado de la última pestaña activa
                var lastTab = localStorage.getItem('lastTab');
                if (lastTab) {
                    // Activar la última pestaña activa
                    $('.nav-tabs a[href="' + lastTab + '"]').tab('show');
                }


                // Manejar el evento 'shown.bs.tab' para guardar la última pestaña activa y recargar la página
                $('.nav-tabs a').on('shown.bs.tab', function(event) {
                    var currentTab = $(event.target).attr('href');
                    localStorage.setItem('lastTab', currentTab);
                    window.location.href = '../matriz-beneficios?idp=' + <?php echo $id_pe ?>;
                });
            });
        </script>
    </div>
    <?php include_once('../layouts/footer.php'); ?>

    <script src="assets/js/periodos.js"></script>
    <script>
        function crear_periodo() {
            Swal.fire({
                title: "Nuevo Periodo",
                html: `<form id='crear_periodo' action="save.php" method='post' onsubmit='return validarFechas(event)'>
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="nombre">Nombre del período</label>
                      <input type='text' name='nombre' class='form-control' required autocomplete="on">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label for="fecha_inicio">Fecha de inicio</label>
                      <input type='date' name='fecha_inicio' id='fecha_inicio' class='form-control' required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="fecha_fin">Fecha de fin</label>
                      <input type='date' name='fecha_fin' id='fecha_fin' class='form-control' required>
                    </div>
                  </div>
                </div> 
                <div class="col-md-12">
                  <div id="error" style="display: none; color: red;"></div>
                  <br>
                  <button type="submit" class="btn btn-dark" name="add" id='add'>
                    Guardar
                  </button>
                </div>
                <br>
              </div>
            </div>
          </form>`,
                showConfirmButton: false,
            });
        }

        function validarFechas(event) {
            var fechaInicio = new Date(document.getElementById('fecha_inicio').value);
            var fechaFin = new Date(document.getElementById('fecha_fin').value);
            if (fechaInicio > fechaFin) {
                var errorDiv = document.getElementById('error');
                errorDiv.innerHTML = 'La fecha de inicio no puede ser mayor a la fecha de fin';
                errorDiv.style.display = 'block';
                event.preventDefault();
                return false;
            }
            return true;
        }



        function updateTotal() {
            // Get the values of monto and cantidad
            const monto = parseFloat(montoInput.value) || 0;
            const cantidad = parseFloat(cantidadInput.value) || 0;
            const frecuencia = parseFloat(frecuenciaInput.value) || 0;

            // Multiply the values and set the result in the total input field
            totalInput.value = formatNumber(monto * cantidad * frecuencia);
            updateDiferencia();
        }

        function updateDiferencia() {
            const presupuesto = parseFloat(document.querySelector('input[name="presupuesto"]').value) || 0;
            const total = parseFloat(totalInput.value) || 0;
            const diferencia = presupuesto - total;

            // Set the result in the diferencia input field
            document.querySelector('input[name="diferencia"]').value = formatNumber(diferencia);

            // Update the style based on the sign of the diferencia value
            const diferenciaInput = document.querySelector('input[name="diferencia"]');
            diferenciaInput.style.color = diferencia >= 0 ? 'blue' : 'red';
        }


        function formatNumber(number) {
            // Primero, convierte el número a un valor numérico
            const numericValue = parseFloat(number);

            // Si no es un número válido, retorna el valor vacío
            if (isNaN(numericValue)) {
                return '';
            }

            // Formatear el número con las comas y puntos adecuados
            const formattedNumber = numericValue.toLocaleString('es', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });


            return formattedNumber;
        }

        const montoInput = document.createElement('input');
        const frecuenciaInput = document.createElement('input');
        const cantidadInput = document.createElement('input');
        const totalInput = document.createElement('input');
        const diferenciaInput = document.createElement('input');

        function editar_calculos(calculob, id, tipo, nombre) {
            var html = `
    <label style="display: flex; align-items: center; margin-bottom: 10px;">
      <span style="font-weight: bold; margin-right: 5px;">Tipo de pago:</span>
      <span >${tipo}</span>
    </label>
    <label style="display: flex; align-items: center; margin-bottom: 10px;">
      <span style="font-weight: bold; margin-right: 5px;">Beneficio:</span>
      <span >${nombre}</span>
    </label>
        <form id='editar_periodo' action="save.php" method='post' style="text-align: center !important;">
        
        <input class="hidden" id="monto_info" name="monto_info" value="0">

        <div class="hidden" id="info_monto">
            <div class="card card-body" style="text-align: justify; font-size: 14px">
                <p>
                    <em>
                    Cada beneficio tiene un costo para la empresa, por lo tanto, debe ser reflejado (costo por unidad, sea cual sea la medida).
                    </em><br> 
                </p>
            </div>
        </div>
                <input class="hidden" id="cantidad_info" name="cantidad_info" value="0">

        <div class="hidden" id="info_cantidad">
            <div class="card card-body" style="text-align: justify; font-size: 14px">
                <p>
                    <em>
                   Debe reflejar el total de trabajadores que reciben el beneficio.
                    </em><br> 
                </p>
            </div>
        </div>
        
        <input class="hidden" id="frecuencia_info" name="frecuencia_info" value="0">

        <div class="hidden" id="info_frecuencia">
            <div class="card card-body" style="text-align: justify; font-size: 14px">
                <p>
                 <em>Se indica el número de veces en que se efectúa el pago.</em><br>
<ul>
    <li>Si el pago es diario: 365</li>
    <li>Si el pago es mensual: 12</li>
    <li>Si el pago es bimestral: 06</li>
    <li>Si el pago es trimestral: 04</li>
    <li>Si el pago es cuatrimestral: 03</li>
    <li>Si el pago es semestral: 02</li>
</ul>

                </p>
            </div>
        </div>

            <div class="row">
                <div class="col-md-12">
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label style="color: #3c8dbc;"  onclick="show_info_monto()"  for="monto">Monto del Pago</label>
                              
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label style="color: #3c8dbc;"  onclick="show_info_cantidad()"  for="nombre">Cantidad de Trabajadores</label>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label style="color: #3c8dbc;"  onclick="show_info_frecuencia()" for="frecuencia">Frecuencia del Pago</label>
                               
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                            <br/>
                                <label for="total">Total</label>
                               
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="nombre">Presupuesto</label>
                               <input type='text' name='presupuesto' value="` + (calculob && calculob.length > 0 ? calculob[0].presupuesto : '') + `" class='form-control' required autocomplete="on">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                              <br/>
                                <label for="diferencia">Diferencia</label>
                              
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type='hidden' name='id_beneficio' class='form-control' value="` + id + `" required autocomplete="on'>
                         
                    </div>
                              <div class="form-group">
                        
                         <input type='hidden' name='id_periodo' class='form-control' value="<?php echo $id_pe ?>" required autocomplete="on'>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <button type="submit" class="btn btn-dark" name="update" id='update'>
                            Guardar
                        </button>
                    </div>
                    <br>
                </div>
            </div>
        </form>
    `;



            // Set the input fields' attributes
            montoInput.setAttribute('name', 'monto');
            if (calculob && calculob.length > 0) {
                montoInput.value = calculob[0].monto;

            } else {
                montoInput.value = "";
            }
            montoInput.setAttribute('class', 'form-control');
            montoInput.setAttribute('required', '');
            montoInput.setAttribute('autocomplete', 'on');
            montoInput.addEventListener("input", updateTotal);
            /*
            montoInput.addEventListener('blur', function() {
                usToEuCurrencyFormat(montoInput);
            });
            montoInput.addEventListener('focus', function() {
                borrarComaYDespues(montoInput);
            });
            */
            cantidadInput.setAttribute('name', 'cantidad');
            if (calculob && calculob.length > 0) {
                cantidadInput.value = calculob[0].cantidad_trabajadores;
            } else {
                cantidadInput.value = "";
            }
            cantidadInput.setAttribute('class', 'form-control');
            cantidadInput.setAttribute('required', '');
            cantidadInput.setAttribute('autocomplete', 'on');
            cantidadInput.addEventListener("input", updateTotal);

            frecuenciaInput.setAttribute('name', 'frecuencia');
            if (calculob && calculob.length > 0) {
                frecuenciaInput.value = calculob[0].frecuencia;
            } else {
                frecuenciaInput.value = "";
            }
            frecuenciaInput.setAttribute('class', 'form-control');
            frecuenciaInput.setAttribute('required', '');
            frecuenciaInput.setAttribute('autocomplete', 'on');
            frecuenciaInput.addEventListener("input", updateTotal);



            totalInput.setAttribute('name', 'total');
            //totalInput.setAttribute('value', ');
            totalInput.setAttribute('class', 'form-control');
            totalInput.setAttribute('required', '');
            totalInput.setAttribute('autocomplete', 'on');
            totalInput.setAttribute('readonly', '');


            diferenciaInput.setAttribute('name', 'diferencia');
            // diferenciaInput.setAttribute('value', '<?php echo $calculob["diferencia"] ?? ""; ?>');
            diferenciaInput.setAttribute('class', 'form-control');
            diferenciaInput.setAttribute('required', '');
            diferenciaInput.setAttribute('autocomplete', 'on');
            diferenciaInput.setAttribute('readonly', '');

            // Show the form using SweetAlert2
            Swal.fire({
                title: "Cálculos",
                html: html,
                showConfirmButton: false,
                didRender: () => {
                    // Append the input fields to the form after it has been rendered
                    const montoFormGroup = document.querySelector('label[for="monto"]').parentNode;
                    montoFormGroup.appendChild(montoInput);

                    const cantidadFormGroup = document.querySelector('label[for="nombre"]').parentNode;
                    cantidadFormGroup.appendChild(cantidadInput);

                    const frecuenciaFormGroup = document.querySelector('label[for="frecuencia"]').parentNode;
                    frecuenciaFormGroup.appendChild(frecuenciaInput);

                    const totalFormGroup = document.querySelector('label[for="total"]').parentNode;
                    totalFormGroup.appendChild(totalInput);

                    // Add event listener to update diferencia field
                    const presupuestoInput = document.querySelector('input[name="presupuesto"]');
                    presupuestoInput.addEventListener("input", updateDiferencia);

                    const diferenciaFormGroup = document.querySelector('label[for="diferencia"]').parentNode;
                    diferenciaFormGroup.appendChild(diferenciaInput);
                    updateTotal();
                },
            });
            $(document).ready(function() {
                $(".hidden").hide();
            });
        }

        function usToEuCurrencyFormat(inputElement) {
            const num = inputElement.value;
            const formattedNumber = formatNumber(num);
            inputElement.value = formattedNumber;
        }

        function borrarComaYDespues(inputElement) {
            const valor = inputElement.value;
            const posicionComa = valor.indexOf(',');
            if (posicionComa !== -1) {
                const valorSinComa = valor.slice(0, posicionComa);
                const numeroSinPuntos = valorSinComa.replace(/\./g, '');
                inputElement.value = numeroSinPuntos;

            }
        }

        function show_info_monto() {
            monto_info = document.getElementById("monto_info").value;
            cantidad_info = document.getElementById("cantidad_info").value;
            frecuencia_info = document.getElementById("frecuencia_info").value;


            if (monto_info == 0) {
                $("#info_monto").show("fast");
                $("#info_cantidad").hide();
                $("#info_frecuencia").hide();
                document.getElementById("cantidad_info").value = 0;
                document.getElementById("frecuencia_info").value = 0;
                document.getElementById("monto_info").value = 1;
            }
            if (monto_info == 1) {
                $("#info_monto").hide();
                document.getElementById("monto_info").value = 0;
            }
        }

        function show_info_cantidad() {
            monto_info = document.getElementById("monto_info").value;
            cantidad_info = document.getElementById("cantidad_info").value;
            frecuencia_info = document.getElementById("frecuencia_info").value;


            if (cantidad_info == 0) {
                $("#info_monto").hide();
                $("#info_cantidad").show("fast");
                $("#info_frecuencia").hide();
                document.getElementById("cantidad_info").value = 1;
                document.getElementById("frecuencia_info").value = 0;
                document.getElementById("monto_info").value = 0;
            }
            if (cantidad_info == 1) {
                $("#info_cantidad").hide();
                document.getElementById("cantidad_info").value = 0;
            }
        }

        function show_info_frecuencia() {
            monto_info = document.getElementById("monto_info").value;
            cantidad_info = document.getElementById("cantidad_info").value;
            frecuencia_info = document.getElementById("frecuencia_info").value;


            if (frecuencia_info == 0) {
                $("#info_monto").hide();
                $("#info_cantidad").hide();
                $("#info_frecuencia").show("fast");

                document.getElementById("cantidad_info").value = 0;
                document.getElementById("frecuencia_info").value = 1;
                document.getElementById("monto_info").value = 0;
            }
            if (frecuencia_info == 1) {
                $("#info_frecuencia").hide();
                document.getElementById("frecuencia_info").value = 0;
            }
        }
    </script>