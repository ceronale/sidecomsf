<?php include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; ?>
<link rel="stylesheet" href="../assets/css/stylebuttons.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <div class="card text-left">
            <div class="card-header">
                <span style="font-weight: bold; font-size: 25px">Relaciones externas</span>
            </div>
        </div>

    </section>
    <!-- Content Header (Page header) -->

    <?php

    include_once 'class.crud.php';
    $crud = new crud();
    if (isset($_GET['same'])) {
    ?>
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'El nombre ya existe en la base de datos',
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
                title: 'La relación se ha registrado con exito!',
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
                title: 'Error al registrar la relación!',
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
                title: 'La relación se ha editado con exito!',
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
                title: 'Error al editar La relación!',
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
                'iDisplayLength': 50,
            });
        });
    </script>

    <div class='container' style="overflow: auto; max-height: 600px;">

        <div class="row row-col-8">
            <div class="col">
                <a href='#' onclick="crear_relacion()" class='btn btn-large btn-dark'> &nbsp;
                    + Nueva relación externa</a>
            </div>

        </div>

        <div class='clearfix'></div><br />

        <table id="example" class="table table-striped dt-responsive nowrap" style="width:100%">
            <thead style="position: sticky; top: 0; background-color: white;">
                <tr>
                    <th>Relación</th>
                    <th>Descripción</th>
                    <th>Status</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $relacions = $crud->dataview_relacion();
                if ($relacions != null) {
                    foreach ($relacions as $relacion) {
                ?>
                        <tr>
                            <td><?php print($relacion['nombre']); ?></td>
                            <td style="white-space: normal;"><?php print($relacion['descripcion']); ?></td>
                            <td><?php if ($relacion['status'] == "1") {
                                    print "Activo";
                                } else {
                                    print "Inactivo";
                                }
                                ?></td>


                            <td style="text-align: center">
                                <a onclick="editar_relacion('<?php print($relacion['id']) ?>','<?php print($relacion['nombre']) ?>','<?php print($relacion['descripcion']) ?>','<?php print($relacion['status']) ?>')">
                                    <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;

                                <a onclick="eliminar_relacion('<?php print($relacion['id']) ?>','<?php print($relacion['nombre']) ?>')">
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
            
        </table>
    </div>
    <?php include_once('../layouts/footer.php'); ?>

    <script src="assets/js/relacion.js"></script>

    <script>
        function crear_relacion() {
            Swal.fire({
                title: "Nueva relación externa",
                html: ` <form id='crear_relacion' action="save.php" method='post'>
            <div class="row">
                <div class="col-md-12">

                    <div class="row">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type='text' name='nombre' class='form-control' required autocomplete="on">
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

                    <div class="row">
                        <div class="col-md-12">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="3" required></textarea>
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

        function editar_relacion(id, nombre, descripcion, status) {
            Swal.fire({
                title: "Editar Relación",
                html: ` <form id='editar_relacion' action="save.php" method='post' style="text-align: center !important;">
            <div class="row">
                <div class="col-md-12">
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="nombre">Relación</label>
                                <input type='text' name='nombre' id='nombre' value="` + nombre + `" class='form-control' required autocomplete="on">
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
                    <div class="row">
                        <div class="col-md-12">
  <div class="form-group">
    <label for="descripcion">Descripción</label>
    <textarea name="descripcion" class="form-control" rows="3" required>` + descripcion + `</textarea>
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