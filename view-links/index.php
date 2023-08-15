<?php 
$seccion = 'p_view_links';
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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <section class="content-header">
        <div class="card text-left">
            <div class="card-header">
                <span style="font-weight: bold; font-size: 25px; color: #3c8dbc; cursor: pointer;" onclick="info_tabla('Links de interes','Permite conectar videos (url) o grabaciones relacionadas con el campo laboral, para presentaciones, cursos, inducción u otros fines didácticos.')">Links de interés</span>
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
                title: 'El link se ha registrado con exito!',
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
                title: 'Error al registrar el link!',
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
                title: 'El link se ha editado con exito!',
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
                title: 'Error al editar el link!',
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

    <div class='container' style="overflow: auto; max-height: 600px;">



        <div class='clearfix'></div><br />

        <table id="example" class="table table-striped dt-responsive nowrap" style="width:100%">
            <thead style="position: sticky; top: 0; background-color: white;">
                <tr>
                    <th>Website</th>
                    <th>Título</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $links = $crud->dataview_link();
                if ($links != null) {
                    foreach ($links as $link) {
                ?>
                        <tr>
                            <td style="width:10%"><a href="<?php echo $link['website']; ?>" target="_blank">
                                    <i class="fas fa-external-link-alt"></i> <!-- Icono de enlace externo -->
                                </a></td>
                            <td><?php print($link['titulo']); ?></td>


                        </tr>

                    <?php }
                } else {  ?>
                    <tr>
                        <td>No hay registros</td>
                        <td></td>
                        <td></td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php include_once('../layouts/footer.php'); ?>

    <script src="assets/js/links.js"></script>

    <script>
        function crear_link() {
            Swal.fire({
                title: "Agregar Link",
                html: ` <form id='crear_link' action="save.php" method='post'>
            <div class="row">
                <div class="col-md-12">

                    <div class="row">

                        <div class="col-12">
                            <div class="form-group">
                                <label for="titulo">Título</label>
                                <input type='text' name='titulo' class='form-control' required autocomplete="on">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                             <div class="form-group">
                                <label for="website">Website</label>
                                <input type='text' name='website' class='form-control' required autocomplete="on">
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

        function editar_link(id, titulo, website, status) {
            Swal.fire({
                title: "Editar Beneficio",
                html: ` <form id='editar_link' action="save.php" method='post' style="text-align: center !important;">
            <div class="row">
                <div class="col-md-12">

                    <br>

                    <div class="row">

                        <div class="col-12">
                            <div class="form-group">
                                <label for="titulo">Título</label>
                                <input type='text' name='titulo' id='titulo' value="` + titulo + `" class='form-control' required autocomplete="on">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="titulo">Website</label>
                                <input type='text' name='website' id='website' value="` + website + `" class='form-control' required autocomplete="on">
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