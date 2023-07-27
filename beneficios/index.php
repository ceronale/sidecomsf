<?php include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <div class="card text-left">
            <div class="card-header">
                <span style="font-weight: bold; font-size: 25px">Beneficios</span>
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
                title: 'El beneficio se ha registrado con exito!',
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
                title: 'Error al registrar el beneficio!',
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
                title: 'El beneficio se ha editado con exito!',
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
                title: 'Error al editar el beneficio!',
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
                <a href='#' onclick="crear_beneficio()" class='btn btn-large btn-dark'> &nbsp;
                    + Nuevo Beneficio</a>
            </div>

        </div>

        <div class='clearfix'></div><br />

        <table id="example" class="table table-striped dt-responsive nowrap" style="width:100%">
            <thead style="position: sticky; top: 0; background-color: white;">
                <tr>
                    <th>Nombre</th>
                    <th>Tipo pago</th>
                    <th>Status</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $beneficios = $crud->dataview_beneficio();
                if ($beneficios != null) {
                    foreach ($beneficios as $beneficio) {
                ?>
                        <tr>
                            <td><?php print($beneficio['nombre']); ?></td>
                            <td><?php print($beneficio['tipo_pago']); ?></td>
                            <td><?php if ($beneficio['status'] == "1") {
                                    print "Activo";
                                } else {
                                    print "Inactivo";
                                }
                                ?></td>


                            <td style="text-align: center">
                                <a onclick="editar_beneficio('<?php print($beneficio['id']) ?>','<?php print($beneficio['nombre']) ?>','<?php print($beneficio['tipo_pago']) ?>','<?php print($beneficio['status']) ?>')">
                                    <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;

                                <a onclick="eliminar_beneficio('<?php print($beneficio['id']) ?>','<?php print($beneficio['nombre']) ?>')">
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
                    <th>Nombre</th>
                    <th>Tipo pago</th>
                    <th>Status</th>
                    <th>Acción</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <?php include_once('../layouts/footer.php'); ?>

    <script src="assets/js/beneficios.js"></script>

    <script>
        function crear_beneficio() {
            Swal.fire({
                title: "Nuevo Beneficio",
                html: ` <form id='crear_beneficio' action="save.php" method='post'>
            <div class="row">
                <div class="col-md-12">

                    <div class="row">

                        <div class="col-12">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type='text' name='nombre' class='form-control' required autocomplete="on">
                            </div>
                        </div>

      

                    </div>

                    <div class="row">
                  <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_pago">Tipo de Pago</label>
                                <select class="form-control" name="tipo_pago" id="tipo_pago">
                                    <option value="Fijo">Fijo</option>
                                    <option value="Ocasional">Ocasional</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
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

        function editar_beneficio(id, nombre, tipo_pago, status) {
            Swal.fire({
                title: "Editar Beneficio",
                html: ` <form id='editar_beneficio' action="save.php" method='post' style="text-align: center !important;">
            <div class="row">
                <div class="col-md-12">

                    <br>

                    <div class="row">

                        <div class="col-12">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type='text' name='nombre' id='nombre' value="` + nombre + `" class='form-control' required autocomplete="on">
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_pago">Tipo de Pago</label>
                                <select class="form-control" name="tipo_pago" id="tipo_pago">
                                    <option value="Fijo" ${tipo_pago==='Fijo' ? ' selected' : '' }>Fijo</option>
                                    <option value="Ocasional" ${tipo_pago==='Ocasional' ? ' selected' : '' }>Ocasional</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
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
                        <input type='hidden' name='id' class='form-control' value="` + id + `" required autocomplete="on">
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