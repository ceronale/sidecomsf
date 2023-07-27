<?php include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <div class="card text-left">
            <div class="card-header">
                <span style="font-weight: bold; font-size: 25px">Matriz de beneficios</span>
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


    if (isset($_POST['btn-send'])) {
        $id_pe = strip_tags($_POST['mi-select']);
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
            $('#example').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
                },
            });
        });
    </script>




    <div class='container' style="overflow: auto; max-height: 600px;">
        <div>
            <div class="form-row ">
                <div class="col-12 col-sm-2">
                    <a href='#' onclick="crear_periodo()" class='btn btn-large btn-dark'>+ Agregar periodo</a>
                </div>
                <div class="col-12 col-sm-4">
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
                                    var_dump($idx); ?>
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

                                            <a onclick="eliminar_beneficio('<?php print($beneficio['id']) ?>','<?php print($beneficio['nombre']) ?>')">
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
                                                console.log(beneficioId);
                                                console.log(nivelId);
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
                <h3>Content for Tab 2</h3>
                <p>Nullam ultricies magna in neque venenatis, eu hendrerit sem tincidunt. Fusce tristique, nulla eu venenatis lobortis, purus metus imperdiet nisi, vel tempus sapien quam ac massa.</p>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('.nav-tabs a').click(function() {
                    $(this).tab('show');
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
        const cantidadInput = document.createElement('input');
        const totalInput = document.createElement('input');
        const diferenciaInput = document.createElement('input');

        function updateTotal() {
            // Get the values of monto and cantidad
            const monto = parseFloat(montoInput.value) || 0;
            const cantidad = parseFloat(cantidadInput.value) || 0;

            // Multiply the values and set the result in the total input field
            totalInput.value = (monto * cantidad).toFixed(2);
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
                                <label for="nombre">Frecuencia del Pago</label>
                                <input type='text' name='frecuencia' value="` + calculob[0].frecuencia + `" class='form-control' required autocomplete="on'>
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
                                <input type='text' name='presupuesto' value="` + calculob[0].presupuesto + `" class='form-control' required autocomplete="on'>
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
            montoInput.setAttribute('value', calculob[0].monto);
            montoInput.setAttribute('class', 'form-control');
            montoInput.setAttribute('required', '');
            montoInput.setAttribute('autocomplete', 'on');
            montoInput.addEventListener("input", updateTotal);

            cantidadInput.setAttribute('name', 'cantidad');
            cantidadInput.setAttribute('value', calculob[0].cantidad_trabajadores);
            cantidadInput.setAttribute('class', 'form-control');
            cantidadInput.setAttribute('required', '');
            cantidadInput.setAttribute('autocomplete', 'on');
            cantidadInput.addEventListener("input", updateTotal);

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