<?php 
$seccion = 'p_usuarios';
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
                <span style="font-weight: bold; font-size: 25px; color: #3c8dbc; cursor: pointer;"
                    onclick="info_tabla('Usuarios:','El administrador , atendiendo a la política de la organización, puede permitir acceso a Funcionarios, Ejecutivos, Gerentes altos y medio o Supervisores; con el objeto de que registren información para alimentar la base de datos; Ejm. Descripciones de Puesto/Cargo, Valoración de Puesto/Cargo (luego validado por un comité) y cualquier otra información requerida.')">Usuarios</span>
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

        <div class="row row-col-8">
            <div class="col">
                <a href='#'
                    onclick="crear_usuario2('<?php echo addslashes(htmlspecialchars(json_encode($cargos))); ?>')"
                    class='btn btn-primary btn3d'> &nbsp;
                    Agregar usuario</a>
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
                        <a
                            onclick="editar_usuario2('<?php echo htmlspecialchars($usuario['id']); ?>','<?php echo htmlspecialchars($usuario['nombre']); ?>', '<?php echo htmlspecialchars($usuario['apellido']); ?>', '<?php echo htmlspecialchars($usuario['idcargo']); ?>', '<?php echo htmlspecialchars($usuario['email']); ?>', '<?php echo htmlspecialchars($usuario['status']); ?>','<?php echo addslashes(htmlspecialchars(json_encode($cargos))); ?>','<?php echo htmlspecialchars($usuario['email']); ?>')">
                            <i class=" fa fa-pencil" aria-hidden="true"></i></a>

                        &nbsp;&nbsp;&nbsp;&nbsp;

                        <a
                            onclick="eliminar_usuario('<?php print($usuario['id']) ?>','<?php print($usuario['nombre']) ?>')">
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
    function crear_usuario2(cargos) {
        var cargosArray = JSON.parse(cargos);

        let html = `
        <link rel="stylesheet" href="assets/css/styles.css">
    <form id='crear_usuario' action="save.php" method='post' style="text-align: center !important;">
    <div class="card text-left">

        <ul class="tabs">
            <li style="width: 200px !important; margin-top: 1px !important"><a href="#tab1"><i class="fas fa-university"></i><span class="tab-text">Credenciales</span></a> </li>
           
            <li style="width: 200px !important; margin-top: 1px !important"><a href="#tab2"><i class="fas fa-phone-laptop"></i><span class="tab-text">Permisología</span></a>    </li>
        
           
        </ul>

    </div>

    <div class="secciones">
                <article id="tab1">

        <div class="row">
            <div class="col-md-6">
                <br>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type='text' name='nombre' class='form-control' required autocomplete="on">
                </div>
                               <div class="form-group">
                <label for="email">Email</label>
                <input type='email' name='email' class='form-control' required autocomplete="on">
            </div>
 

                <div class="form-group">
                    <label for="cargo">Puesto/Cargo</label>
                    <select class="form-select" name="cargo" id="cargo">`;

        cargosArray.forEach(function(cargoOption) {
            html += `<option  value = "${cargoOption["id"]}" > ${cargoOption["nombre"]}</option > `;
        });

        html += `</select >
                </div >
            </div >
    <div class="col-md-6">
        <br>
            <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type='text' name='apellido' class='form-control' required autocomplete="on">
                </div>
           

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type='text' name='password' class='form-control' required autocomplete="on">
                </div>

                <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
    </div>
        </div>

        </article>

        <article id="tab2">


        <?php
        include_once 'class.crud.php';
        $crud = new crud();
        $crud->permisos(); ?>
        </article>
        <div class="col-md-12">
            <br>
            <button type="submit" class="btn btn-dark" name="add" id='add'>
                          Guardar
            </button>
        </div>
        <br>
    </form>`;


        Swal.fire({
            title: "Nuevo ",
            html: html,
            showConfirmButton: false,
        })
        dselect(document.querySelector('#cargo'), {
            search: true
        })

        $(document).ready(function() {
            $('ul.tabs li a:first').addClass('active');
            $('.secciones article').hide();
            $('.secciones article:first').show();
            $('ul.tabs li a').click(function() {
                $('ul.tabs li a').removeClass('active');
                $(this).addClass('active');
                $('.secciones article').hide();

                var activeTab = $(this).attr('href');
                $(activeTab).show();
                return false;
            });
        });
    };



    function editar_usuario2(id, nombre, apellido, cargo, email, status, cargos, lastemail, password) {
        var cargosArray = JSON.parse(cargos);
        let html = `
    <link rel="stylesheet" href="assets/css/styles.css">
    
        <form id='editar_usuario' action ="save.php?id=${id}" method = 'post' style = "text-align: center !important;">
        <div class="card text-left">

        <ul class="tabs">
            <li style="width: 200px !important; margin-top: 1px !important"><a href="#tab1"><i class="fas fa-university"></i><span class="tab-text">Credenciales</span></a> </li>
        
            <li style="width: 200px !important; margin-top: 1px !important"><a href="#tab2"><i class="fas fa-phone-laptop"></i><span class="tab-text">Permisología</span></a>    </li>

        
        </ul>

        </div>

        <div class="secciones">
                <article id="tab1">
                
            <div class="row">
                <div class="col-md-6">
                    <br>
                    <div class="form-group" hidden>
                     <label for="lastemail">lastemail</label>
                        <input type='text' name='lastemail' value="${lastemail}" class='form-control' required >
                    </div>

                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type='text' name='nombre' value="${nombre}" class='form-control' required autocomplete="on">
                    </div>
           <div class="form-group">
                        <label for="email">Email</label>
                        <input type='email' name='email' value="${email}" class='form-control' required autocomplete="on">
                    </div>


                    <div class="form-group">
                        <label for="cargo">Puesto/Cargo</label>
                        <select class="form-select" name="cargo" id="cargo">
                          <option disabled selected value="">Selecciona una opción</option>`;

        cargosArray.forEach(function(cargoOption) {
            html +=
                `<option value="${cargoOption["id"]}" ${cargoOption["id"] == cargo ? 'selected' : ''}>${cargoOption["nombre"]}</option>`;
        });
        html += `</select>
                    </div>
                </div>
                <div class="col-md-6">
                    <br>

       
   
                                 <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type='text' name='apellido' value="${apellido}" class='form-control' required autocomplete="on">
                    </div>

                    
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type='text' name='password' class='form-control' value="${password}" required autocomplete="on">
                    </div>

      
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-select" id="status" name="status"required>
                            <option value="1" ${status === '1' ? 'selected' : ''}>Activo</option>
                            <option value="0" ${status === '0' ? 'selected' : ''}>Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type='hidden' name='id' class='form-control' value="${id}" required autocomplete="on">
            </div>
  

        </article>

        <article id="tab2">


        <div id="permisos" name="permisos">

        </div>`

      
         $.post("data_permisos.php", {
            id: id
        }, function(data) {
            $("#permisos").html(data)
        })

       html += ` </article>
        <div class="col-md-12">
            <br>
            <button type="submit" class="btn btn-dark" name="update" id='update'>
                          Guardar
            </button>
        </div>
        <br>
    </form>`;


        Swal.fire({
            title: "Editar Usuario",
            html: html,
            showConfirmButton: false,
        })
        dselect(document.querySelector('#cargo'), {
            search: true
        })

        $(document).ready(function() {
            $('ul.tabs li a:first').addClass('active');
            $('.secciones article').hide();
            $('.secciones article:first').show();
            $('ul.tabs li a').click(function() {
                $('ul.tabs li a').removeClass('active');
                $(this).addClass('active');
                $('.secciones article').hide();

                var activeTab = $(this).attr('href');
                $(activeTab).show();
                return false;
            });
        });
    };
    </script>