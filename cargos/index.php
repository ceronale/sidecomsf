<?php include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; ?>
<?php
if (isset($_GET['ca'])) {
    if ($_GET['ca'] == 1) {
        $categ = "Puestos/Cargos: Administrativos";
    } else {
        $categ = "Puestos/Cargos: Planta - Taller - Fábrica";
    }
}

if (isset($_GET['des'])) {
    if ($_GET['ca'] == 1) {
        $categ = "Descripción de Puestos/Cargos: Administrativos";
    } else {
        $categ = "Descripción de Puestos/Cargos: Planta - Taller - Fábrica";
    }
}

if (isset($_GET['val'])) {
    if ($_GET['ca'] == 1) {
        $categ = "Valoración de Puestos/Cargos: Administrativos";
    } else {
        $categ = "Valoración de Puestos/Cargos: Planta - Taller - Fábrica";
    }
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="card text-left">
            <div class="card-header">
                <span style="font-weight: bold; font-size: 25px"><?php echo $categ; ?></span>
            </div>
        </div>
    </section>
    <!-- Content Header (Page header) -->

    <?php
    include_once 'class.crud.php';
    $crud = new crud();
    $departamentos = $crud->get_departamentos($_GET['ca']);
    $user = $_SESSION['user'];
    $grados_administrativos = $crud->get_grados_administrativos($user['id_empresa']);
    $grados_taller = $crud->get_grados_taller($user['id_empresa']);
    $categoriax = $_GET['ca'];

    if ($categoriax == 1) {
        $grados = $grados_administrativos;
    } else {
        $grados = $grados_taller;
    }

    if (isset($_GET['inserteddes'])) {
    ?>
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'La descripción de cargo se ha registrado con exito!',
                showConfirmButton: false,
                timer: 3000
            })
        </script>
    <?php
    }
    if (isset($_GET['faildes'])) {
    ?>
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Error al registrar la descripción del cargo',
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
                title: 'El cargo se ha registrado con exito!',
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
                title: 'Error al registrar el Cargo!',
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
                title: 'El cargo se ha editado con exito!',
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
                title: 'Error al editar el cargo!',
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
            <?php if (isset($_GET['new'])) { ?>
                <div class="col">
                    <a href='#' onclick="crear_cargo(<?php echo htmlspecialchars(json_encode($departamentos)); ?>, <?php echo htmlspecialchars(json_encode($grados)); ?>,<?php echo ($categoriax); ?>)" class='btn btn-large btn-dark'> &nbsp;
                        + Agregar Puesto/Cargo</a>
                </div>

            <?php  } ?>
        </div>

        <div class='clearfix'></div><br />

        <table id="example" class="table table-striped dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Departamento</th>
                    <th>Puesto/Cargo</th>
                    <th>Grado</th>
                    <th>Puntaje</th>
                    <th>Status</th>
                    <?php if (isset($_GET['new'])) { ?>
                        <th style="text-align: center;">Acción</th>
                    <?php } ?>

                    <?php if (isset($_GET['des'])) { ?>
                        <th style="text-align: center;">Descripción de Puesto/Cargo</th>
                    <?php } ?>

                    <?php if (isset($_GET['val'])) { ?>
                        <th style="text-align: center;">Valoración de Puesto/Cargo</th>
                    <?php } ?>


                </tr>
            </thead>
            <tbody>
                <?php
                $categoria = $_GET['ca'];

                $cargos = $crud->dataview_cargos($categoria);

                if ($cargos != null) {
                    foreach ($cargos as $cargo) {
                ?>
                        <tr>
                            <td><?php print($cargo['nombre_departamento']); ?></td>
                            <td><?php print($cargo['nombre']); ?></td>
                            <td><?php print($cargo['grado']); ?></td>
                            <td><?php print($cargo['puntaje']); ?></td>
                            <td>
                                <?php if ($cargo['status'] == "1") {
                                    print "Activo";
                                } else {
                                    print "Inactivo";
                                } ?>
                            </td>

                            <td style="text-align: center">

                                <?php if (isset($_GET['new'])) { ?>

                                    <a onclick="editar_cargo('<?php echo htmlspecialchars($cargo['id']); ?>',
                                '<?php echo htmlspecialchars($cargo['nombre']); ?>',
                                '<?php echo htmlspecialchars($cargo['id_departamento']); ?>',
                                '<?php echo htmlspecialchars($cargo['grado']); ?>',
                                '<?php echo htmlspecialchars($cargo['puntaje']); ?>',
                                '<?php echo htmlspecialchars($cargo['categoria']); ?>',
                                '<?php echo htmlspecialchars($cargo['status']); ?>',
                                '<?php echo htmlspecialchars($cargo['descripcion']); ?>',
                                '<?php echo addslashes(htmlspecialchars(json_encode($departamentos))); ?>',
                                '<?php echo htmlspecialchars(json_encode($grados_administrativos)); ?>',
                                '<?php echo htmlspecialchars(json_encode($grados_taller)); ?>')" title="Editar Cargo">
                                        <i class='fa fa-pencil' aria-hidden='true'></i></a>

                                    &nbsp;&nbsp;&nbsp;&nbsp;

                                    <a onclick="eliminar_cargo('<?php print($cargo['id']) ?>','<?php print($cargo['nombre']) ?>','<?php print($cargo['categoria']) ?>')" title="Eliminar Cargo">
                                        <i class="fa fa-trash" aria-hidden="true"></i></a>

                                <?php  } ?>

                                <?php if (isset($_GET['val'])) { ?>

                                    <?php if ($_GET['ca'] == 1) { ?>
                                        <a href="valoracion-adm?idc=<?= $cargo['id']; ?>&ca=<?= $cargo['categoria']; ?>" title="Valorar Cargo">
                                            <i class="fa fa-balance-scale" aria-hidden="true" style="color:black"></i></a>
                                    <?php  } ?>

                                    <?php if ($_GET['ca'] == 2) { ?>
                                        <a href="valoracion-taller?idc=<?= $cargo['id']; ?>&ca=<?= $cargo['categoria']; ?>" title="Valorar Cargo">
                                            <i class="fa fa-balance-scale" aria-hidden="true" style="color:black"></i></a>

                                <?php }
                                } ?>

                                <?php if (isset($_GET['des'])) { ?>

                                    <?php if ($_GET['ca'] == 1) { ?>
                                        <a href="descripcion-cargo-administrativo.php?id=<?= $cargo['id']; ?>&nombre=<?= $cargo['nombre']; ?>&departamento=<?= $cargo['nombre_departamento']; ?>&empresa=<?= $cargo['nombre_empresa']; ?>" title="Describir Cargo">
                                            <i class="fa fa-align-justify" aria-hidden="true" style="color:black"></i></a>
                                    <?php  } ?>

                                    <?php if ($_GET['ca'] == 2) { ?>
                                        <a href="descripcion-cargo-taller.php?id=<?= $cargo['id']; ?>&nombre=<?= $cargo['nombre']; ?>&departamento=<?= $cargo['nombre_departamento']; ?>&empresa=<?= $cargo['nombre_empresa']; ?>" title="Describir Cargo">
                                            <i class="fa fa-align-justify" aria-hidden="true" style="color:black"></i></a>

                                <?php  }
                                } ?>

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
                    </tr>

                <?php } ?>

            </tbody>
            <tfoot>
                <tr>
                    <th>Departamento</th>
                    <th>Puesto/Cargo</th>
                    <th>Grado</th>
                    <th>Puntaje</th>
                    <th>Status</th>
                    <th>Descripción de puesto/cargo</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <?php include_once('../layouts/footer.php'); ?>

    <script src="assets/js/cargos.js"></script>

    <script>

    </script>