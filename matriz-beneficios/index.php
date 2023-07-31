<?php include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <div class="card text-left">
            <div class="card-header">
                <span style="font-weight: bold; font-size: 25px; ">Matriz de beneficios</span>
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
                title: 'El periodo se ha registrado con exito!',
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
                title: 'Error al registrar el periodo!',
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
                title: 'El periodo se ha editado con exito!',
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
                title: 'Error al editar el periodo!',
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
                }
            });
        });
        $(document).ready(function() {
            $.fn.dataTable.ext.errMode = 'none';
            $('#example2').on('error.dt', function(e, settings, techNote, message) {
                console.log('An error has been reported by DataTables: ', message);
            }).DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                }
            });
        });
    </script>




    <div class='container' style="overflow: auto; max-height: 600px;">
        <div>
            <div class="row">
                <div class="col-sm">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href='#' onclick="crear_periodo()" class='btn btn-large btn-dark'>+ Agregar periodo</a>
                        <a href="/sidecoms/beneficios" class="btn btn-large btn-dark">Beneficios</a>
                        <a href="/sidecoms/nivel-empresarial" class="btn btn-large btn-dark">Nivel empresarial</a>
                    </div>
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
                                                                                } ?>><?php echo $periodo['nombre'] . ' (' . $periodo['fecha_inicio'] . ' - ' . $periodo['fecha_fin'] . ')'; ?></option>
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
                <a class="nav-link active" data-toggle="tab" href="#tab1">Asignación de Beneficios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab2">Cálculos - Resultados</a>
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
                                <th>Calculos</th>
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
                                            <a onclick="editar_calculos(<?php echo htmlspecialchars(json_encode($idx)); ?>,<?php print($beneficio['id']) ?>)">
                                                <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            &nbsp;&nbsp;&nbsp;&nbsp;

                                            <a onclick="eliminar_beneficio('<?php print($beneficio['id']) ?>','<?php print($beneficio['nombre']) ?>','<?php print($id_pe) ?>')">
                                                <i class="fa fa-trash" aria-hidden="true"></i></a>

                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="9" style="text-align: center;">Mensaje después de los beneficios fijos</td>
                                </tr>
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
                                <th>Calculos</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>

            </div>
            <div id="tab2" class="tab-pane fade">

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
                                <th>Total Anual</th>
                                <th>Presupuesto Anual</th>
                                <th>Diferencia</th>
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
                            foreach ($beneficios as $beneficio) {
                                if ($beneficio['tipo_pago'] == 'Ocasional') {
                                    $beneficios_ocasionales[] = $beneficio;
                                } else {
                                    $beneficios_fijos[] = $beneficio;
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

                                        // Validar que los valores numéricos sean válidos
                                        if (is_numeric($monto) && is_numeric($cantidad_trabajadores) && is_numeric($frecuencia) && is_numeric($presupuesto)) {
                                            // Calcular los valores necesarios
                                            $total = $monto * $cantidad_trabajadores * $frecuencia;
                                            $total_fijos += $total;
                                            $diferencia = $total - $presupuesto;
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

                                                <td><?php echo $monto; ?></td>
                                                <td><?php echo $cantidad_trabajadores; ?></td>
                                                <td><?php echo $frecuencia; ?></td>
                                                <td><?php echo $total; ?></td>
                                                <td><?php echo $presupuesto; ?></td>
                                                <td><?php echo $diferencia; ?></td>
                                            </tr>
                                <?php
                                        } else {
                                            // Alguno de los valores no es numérico
                                            echo '<tr><td colspan="9">Los valores de cálculo no son válidos</td></tr>';
                                        }
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
                                    <td><strong><?php echo $total_fijos; ?></strong></td>
                                    <td><strong><?php echo $total_presupuesto; ?></strong></td>
                                    <td><strong><?php echo $total_diferencia; ?></strong></td>
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

                                        // Validar que los valores numéricos sean válidos
                                        if (is_numeric($monto) && is_numeric($cantidad_trabajadores) && is_numeric($frecuencia) && is_numeric($presupuesto)) {
                                            // Calcular los valores necesarios
                                            $total = $monto * $cantidad_trabajadores * $frecuencia;
                                            $total_ocasionales += $total;
                                            $diferencia = $total - $presupuesto;
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

                                                <td><?php echo $monto; ?></td>
                                                <td><?php echo $cantidad_trabajadores; ?></td>
                                                <td><?php echo $frecuencia; ?></td>
                                                <td><?php echo $total; ?></td>
                                                <td><?php echo $presupuesto; ?></td>
                                                <td><?php echo $diferencia; ?></td>
                                            </tr>
                                <?php
                                        } else {
                                            // Alguno de los valores no es numérico
                                            echo '<tr><td colspan="9">Los valores de cálculo no son válidos</td></tr>';
                                        }
                                    } else {
                                        // $calculox está vacío

                                    }
                                }
                            }

                            // Generar la línea extra para los beneficios ocasionales
                            if (!empty($beneficios_ocasionales)) {
                                ?>
                                <tr>
                                    <td colspan="6" style="text-align: right;"><strong>S U B - T O T A L E S: </strong></td>
                                    <td><strong><?php echo $total_ocasionales; ?></strong></td>
                                    <td><strong><?php echo $total_presupuesto_ocasionales; ?></strong></td>
                                    <td><strong><?php echo $total_diferencia_ocasionales; ?></strong></td>
                                </tr>
                            <?php
                            }
                            if (!empty($beneficios_ocasionales) && !empty($beneficios_fijos)) {
                            ?>
                                <tr>
                                    <td colspan="6" style="text-align: right;"><strong> T O T A L - G E N E R A L: </strong></td>
                                    <td><strong><?php echo $total_ocasionales + $total_fijos; ?></strong></td>
                                    <td><strong><?php echo $total_presupuesto_ocasionales + $total_presupuesto; ?></strong></td>
                                    <td><strong><?php echo $total_diferencia_ocasionales + $total_diferencia; ?></strong></td>
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
                                <th>Total Anual</th>
                                <th>Presupuesto Anual</th>
                                <th>Diferencia</th>
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
                    location.reload(); // recargar la página
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

        // Define the input fields outside the function
        const montoInput = document.createElement('input');
        const frecuenciaInput = document.createElement('input');
        const cantidadInput = document.createElement('input');
        const totalInput = document.createElement('input');
        const diferenciaInput = document.createElement('input');

        function updateTotal() {
            // Get the values of monto and cantidad
            const monto = parseFloat(montoInput.value) || 0;
            const cantidad = parseFloat(cantidadInput.value) || 0;
            const frecuencia = parseFloat(frecuenciaInput.value) || 0;

            // Multiply the values and set the result in the total input field
            totalInput.value = (monto * cantidad * frecuencia).toFixed(2);
            updateDiferencia();
        }

        function updateDiferencia() {
            const presupuesto = parseFloat(document.querySelector('input[name="presupuesto"]').value) || 0;
            const total = parseFloat(totalInput.value) || 0;
            const diferencia = presupuesto - total;
            document.querySelector('input[name="diferencia"]').value = diferencia.toFixed(2);
        }

        function editar_calculos(calculob, id) {
            console.log(calculob);
            var html = `
            
        <form id='editar_periodo' action="save.php" method='post' style="text-align: center !important;">
            <div class="row">
                <div class="col-md-12">
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="monto">Monto del Pago</label>
                              
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="nombre">Cantidad de Trabajadores</label>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="frecuencia">Frecuencia del Pago</label>
                               
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                            <br/>
                                <label for="total">Total Anual</label>
                               
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="nombre">Presupuesto Anual</label>
<input type='text' name='presupuesto' value="` + (calculob && calculob.length > 0 ? calculob[0].presupuesto : '') + `" class='form-control' required autocomplete="on'>
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
                montoInput.setAttribute('value', calculob[0].monto);
            } else {
                montoInput.setAttribute('value', '');
            }
            montoInput.setAttribute('class', 'form-control');
            montoInput.setAttribute('required', '');
            montoInput.setAttribute('autocomplete', 'on');
            montoInput.addEventListener("input", updateTotal);

            cantidadInput.setAttribute('name', 'cantidad');
            if (calculob && calculob.length > 0) {
                cantidadInput.setAttribute('value', calculob[0].cantidad_trabajadores);
            } else {
                cantidadInput.setAttribute('value', '');
            }
            cantidadInput.setAttribute('class', 'form-control');
            cantidadInput.setAttribute('required', '');
            cantidadInput.setAttribute('autocomplete', 'on');
            cantidadInput.addEventListener("input", updateTotal);

            frecuenciaInput.setAttribute('name', 'frecuencia');
            if (calculob && calculob.length > 0) {
                frecuenciaInput.setAttribute('value', calculob[0].frecuencia);
            } else {
                frecuenciaInput.setAttribute('value', '');
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
                title: "Calculos",
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
        }
    </script>