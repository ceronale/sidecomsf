<?php
$seccion = 'p_setup';
include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<link rel="stylesheet" href="../assets/css/stylebuttons.css">
<?php include_once "../layouts/menu.php";
$documento = "Se registran leyes, Decretos, Jurisprudencia, Contratos de trabajo individual, Convenciones Colectiva, entre otros"
?>
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
                <span style="font-weight: bold; font-size: 25px; color: #3c8dbc; cursor: pointer;" onclick="info_tabla('Leyes y Documentos:','<?php echo $documento; ?>')">Leyes y Documentos</span>

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
                title: 'Nombre de documento repetido',
                showConfirmButton: false,
                timer: 3000
            })
        </script>
    <?php
    }
    if (isset($_GET['same2'])) {
    ?>
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'El documento esta repetido',
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
                title: 'El documento se ha registrado con exito!',
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
                title: 'Error al registrar el documento!',
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
                title: 'El documento se ha editado con exito!',
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
                title: 'Error al editar el documento!',
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
                <a href='#' onclick="crear_documento()" class='btn btn-primary btn3d'> &nbsp;
                    Agregar Documento</a>
            </div>

        </div>

        <div class='clearfix'></div><br />

        <table id="example" class="table table-striped dt-responsive nowrap" style="width:100%">
            <thead style="position: sticky; top: 0; background-color: white;">
                <tr>
                    <th>Nombre</th>
                    <th>Archivo</th>
                    <th>Registrado el</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $documentos = $crud->dataview_activdades();
                if ($documentos != null) {
                    foreach ($documentos as $documento) {
                ?>
                        <tr>
                            <td><?php print($documento['nombre']); ?></td>
                            <td><?php print($documento['titulo']); ?></td>
                            <td><?php print($documento['creacion']); ?></td>
                            <td style="text-align: center">
                                <a onclick="editar_documento('<?php print($documento['id']) ?>','<?php print($documento['nombre']) ?>')">
                                    <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;

                                <a onclick="eliminar_documento('<?php print($documento['id']) ?>','<?php print($documento['nombre']) ?>','<?php print($documento['titulo']) ?>')">
                                    <i class="fa fa-trash" aria-hidden="true"></i></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <a onclick="descargar_documento('<?php echo $documento['id']; ?>', '<?php echo $documento['titulo']; ?>')">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                </a>

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
                    <th>Archivo</th>
                    <th>Registrado el</th>
                    <th>Acción</th>
                </tr>
            </tfoot>
        </table>




    </div>
    <?php include_once('../layouts/footer.php'); ?>

    <script src="assets/js/documentos.js"></script>
    <script>
        function descargar_documento(id, titulo) {
            var filePath = '../uploads/' + titulo;

            // Comprobar si el archivo existe
            var xhr = new XMLHttpRequest();
            xhr.open('HEAD', filePath, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        // El archivo existe, abrir el enlace de descarga en una nueva pestaña/ventana
                        window.open(filePath, '_blank');
                    } else {
                        // El archivo no existe, mostrar un mensaje de error con SweetAlert2
                        Swal.fire({
                            icon: 'error',
                            title: 'Archivo no encontrado',
                            text: 'El archivo solicitado no existe.',
                        });
                    }
                }
            };
            xhr.send();
        }
    </script>


    <script>
        function crear_documento() {
            Swal.fire({
                title: "+ Agregar Documento",
                html: ` <form id='crear_actvidad' action="save.php" method='post'  enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">

                    <div class="row">

                        <div class="col-12">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type='text' name='nombre' class='form-control' required autocomplete="on">
                            </div>
                        </div>
                        <div class="col-md-12">
                             <input type="file" name="archivo" id="archivo" class="form-control" required>
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

        function editar_documento(id, nombre, status) {
            Swal.fire({
                title: "Editar Actvidad",
                html: ` <form id='editar_documento' action="save.php" method='post' style="text-align: center !important;">
            <div class="row">
                <div class="col-md-12">
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="nombre">Documento</label>
                                <input type='text' name='nombre' value="` + nombre + `" class='form-control' required autocomplete="on">
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