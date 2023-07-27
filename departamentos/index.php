<?php include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

    <?php if($_GET['ca'] == 1)
            {
                $categoria = "Administrativos";
            }
            if($_GET['ca'] == 2)
            {
                $categoria = "Planta - Taller - Fábrica";
            }
            $departamento_info = " Para abreviar utilizamos el término Departamento, pero se deben registrar todas las unidades, Gerencias, Departamentos, Secciones, Vicepresidencias, Presidencia, etc.";
    ?>
        <div class="card text-left">
            <div class="card-header">
                <span style="font-weight: bold; font-size: 25px; color: #3c8dbc; cursor: pointer;" onclick="info_tabla('Departamentos:','<?php echo $departamento_info; ?>')">Departamentos: <?= $categoria; ?></span>
            </div>
        </div>

    </section>
    <!-- Content Header (Page header) -->

    <?php

    include_once 'class.crud.php';
    $crud = new crud();

    if (isset($_GET['inserted'])) {
    ?>
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'El departamento se ha registrado con exito!',
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
                title: 'Error al registrar el departamento!',
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
                title: 'El departamento se ha editado con exito!',
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
                title: 'Error al editar el departamento!',
                showConfirmButton: false,
                timer: 3000
            })
        </script>
    <?php
    }
    if (isset($_GET['failureSameDpto'])) { ?>
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Error al registrar el Departamento. Ya existe un Departamento registrado con ese nombre.',
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

        <div class="row row-col-8">
            <div class="col">
                <a href='#' onclick="crear_departamento(<?= $_GET['ca'] ?>)" class='btn btn-large btn-dark'> &nbsp;
                    Nuevo Departamento</a>
            </div>

        </div>

        <div class='clearfix'></div><br />

        <table id="example" class="table table-striped dt-responsive nowrap" style="width:100%">
            <thead style="position: sticky; top: 0; background-color: white;">
                <tr>
                    <th>Departamento</th>
                    <th>Status</th>
                    <th>Fecha de Creación</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $departamentos = $crud->dataview_departamentos($_GET['ca']);
                if ($departamentos != null) {
                    foreach ($departamentos as $departamento) {
                ?>
                        <tr>
                            <td><?php print($departamento['nombre']); ?></td>
                            <td><?php if ($departamento['status'] == "1") {
                                    print "Activo";
                                } else {
                                    print "Inactivo";
                                }
                                ?></td>
                            <td><?php print(date("d/m/Y", strtotime($departamento['creacion']))); ?></td>
            

                            <td style="text-align: center">
                                <a onclick="editar_departamento('<?php print($departamento['id']) ?>','<?php print($departamento['nombre']) ?>','<?php print($departamento['id_categoria']) ?>','<?php print($departamento['status']) ?>')">
                                    <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;

                                <a onclick="eliminar_departamento('<?php print($departamento['id']) ?>','<?php print($departamento['nombre']) ?>','<?php print($departamento['id_categoria']) ?>')">
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
             

                    </tr>

                <?php } ?>

            </tbody>
            <tfoot>
                <tr>
                    <th>Departamento</th>
                    <th>Status</th>
                    <th>Fecha de Creación</th>
                    <th>Acción</th>
                </tr>
            </tfoot>
        </table>




    </div>
    <?php include_once('../layouts/footer.php'); ?>

    <script src="assets/js/departamentos.js"></script>

    <script>
        function crear_departamento(categoria) {
        Swal.fire({
        title: "Nuevo Departamento",
        html: ` <form id='crear_departamento' action="save.php?ca=${categoria}" method='post'>
            <div class="row">
                <div class="col-md-12">

                    <div class="row">

                        <div class="col-12">
                            <div class="form-group">
                                <label for="nombre">Departamento</label>
                                <input type='text' name='nombre' class='form-control' required autocomplete="on">
                            </div>
                        </div>
                        <input type='hidden' name='categoria' value="`+categoria+`" class='form-control' required autocomplete="on">
                    </div>
                

                    <div class="col-md-12">
                        <br>
                        <button type="submit" class="btn btn-dark" name="add" id='add'>
                            Guardar
                        </button>

                    </div>

                    <br>
                </div>

        </form>`,
        showConfirmButton: false,
        })
        };

        function editar_departamento(id,nombre,id_categoria,status) {
        Swal.fire({
        title: "Editar Departamento",
        html: ` <form id='editar_departamento' action="save.php?ca=${id_categoria}" method='post' style="text-align: center !important;">
            <div class="row">
                <div class="col-md-12">

                    <br>

                    <div class="row">
                        <div class="col-2"> </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label for="nombre">Departamento</label>
                                <input type='text' name='nombre' value="`+nombre+`" class='form-control' required autocomplete="on">
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-2"> </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="1" ${status==='1' ? ' selected' : '' }>Activo</option>
                                    <option value="0" ${status==='0' ? ' selected' : '' }>Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type='hidden' name='id' class='form-control' value="`+id+`" required autocomplete="on">
                        <input type='hidden' name='nombreold' value="`+nombre+`" class='form-control' required autocomplete="on">
                        <input type='hidden' name='categoria' class='form-control' value="`+id_categoria+`" required autocomplete="on">

                    </div>


                    <div class="col-md-12">
                        <br>
                        <button type="submit" class="btn btn-dark" name="update" id='update'>
                            Guardar
                        </button>

                    </div>
                    <br>
                </div>

        </form>`,
        showConfirmButton: false,
        })
        };
        </script>
 