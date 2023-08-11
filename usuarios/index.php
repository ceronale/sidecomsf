<?php include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; ?>
<link rel="stylesheet" href="../assets/css/stylebuttons.css">
<style>

/* Adjust the width of the buttons */
 .dt-buttons {
    flex: 2; /* Occupy two-thirds of the available space */
    text-align: right; /* Align the buttons to the right */
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <section class="content-header">

        <div class="card text-left">
            <div class="card-header">
                <span style="font-weight: bold; font-size: 25px; color: #3c8dbc; cursor: pointer;" onclick="info_tabla('Usuarios:','El administrador , atendiendo a la política de la organización, puede permitir acceso a Funcionarios, Ejecutivos, Gerentes altos y medio o Supervisores; con el objeto de que registren información para alimentar la base de datos; Ejm. Descripciones de Puesto/Cargo, Valoración de Puesto/Cargo (luego validado por un comité) y cualquier otra información requerida.')">Usuarios</span>
            </div>
        </div>

    </section>

    <!-- Content Header (Page header) -->

    <?php

    include_once 'class.crud.php';
    $crud = new crud();
    $cargos = $crud->get_cargos();
    $cargos_json = json_encode($cargos);

    if (isset($_GET['inserted'])) {
    ?>
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'El usuario se ha registrado con exito!',
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
                title: 'El usuario se ha registrado con exito!',
                showConfirmButton: false,
                timer: 3000
            })
        </script>
    <?php
    }
    if (isset($_GET['failureSameEmail'])) { ?>
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'El email ingresado ya existe, por favor ingrese uno nuevo!',
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
                title: 'El usuario se ha editado con exito!',
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
                title: 'Error al editar el usuario!',
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
        buttons: [
            { extend: 'excel', className: 'btn btn-primary btn3d' },
            { extend: 'pdf', className: 'btn btn-primary btn3d' },
            { extend: 'print', className: 'btn btn-primary btn3d' }
        ],
                'iDisplayLength': 50,
            });
        });
    </script>

    <div class='container' style="overflow: auto; max-height: 600px;">

        <div class="row row-col-8">
            <div class="col">
                <a href='#' onclick="crear_usuario('<?php echo addslashes(htmlspecialchars(json_encode($cargos))); ?>')" class='btn btn-large btn-dark'> &nbsp;
                    + Agregar usuario</a>
            </div>

        </div>

        <div class='clearfix'></div><br />

        <table id="example" class="table table-striped dt-responsive nowrap" style="width:100%">
            <thead style="position: sticky; top: 0; background-color: white;">
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cargo</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $usuarios = $crud->dataview_usuarios();
                if ($usuarios != null) {
                    foreach ($usuarios as $usuario) {
                        $cargoNombre = "";

                        // Obtener el nombre del cargo correspondiente al ID del cargo
                        foreach ($cargos as $cargo) {
                            if ($cargo['id'] == $usuario['idcargo']) {
                                $cargoNombre = $cargo['nombre']; // Devolvemos el cargo completo (incluyendo el nombre)
                            }
                        }

                ?>
                        <tr>

                            <td><?php print($usuario['nombre']); ?></td>
                            <td><?php print($usuario['apellido']); ?></td>
                            <td><?php print($cargoNombre); ?></td>
                            <td><?php print($usuario['email']); ?></td>
                            <td><?php if ($usuario['status'] == "1") {
                                    print "Activo";
                                } else {
                                    print "Inactivo";
                                }
                                ?></td>


                            <td style="text-align: center">
                                <a onclick="editar_usuario('<?php echo htmlspecialchars($usuario['id']); ?>','<?php echo htmlspecialchars($usuario['nombre']); ?>', '<?php echo htmlspecialchars($usuario['apellido']); ?>', '<?php echo htmlspecialchars($usuario['idcargo']); ?>', '<?php echo htmlspecialchars($usuario['email']); ?>', '<?php echo htmlspecialchars($usuario['status']); ?>','<?php echo addslashes(htmlspecialchars(json_encode($cargos))); ?>','<?php echo htmlspecialchars($usuario['email']); ?>')">
                                    <i class=" fa fa-pencil" aria-hidden="true"></i></a>

                                &nbsp;&nbsp;&nbsp;&nbsp;

                                <a onclick="eliminar_usuario('<?php print($usuario['id']) ?>','<?php print($usuario['nombre']) ?>')">
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
                    </tr>

                <?php } ?>

            </tbody>

        </table>
    </div>
    <?php include_once('../layouts/footer.php'); ?>

    <script src="assets/js/usuarios.js"></script>

    <script>

    </script>