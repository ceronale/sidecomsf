<?php 
$seccion = 'p_perfil_usuario';
include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; ?>
<link rel="stylesheet" href="../assets/css/stylebuttons.css">
<?php
session_start();
require_once("class.crud.php");
require_once '../tools/functions.php';
$error = "";
$crud = new crud();
$user = $_SESSION['user'];
$contrasena_actual = "";
$contrasena_nueva = "";
$confirmar_contrasena = "";
$sweetAlertCode = "";



?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="card text-left">
            <div class="card-header">
                <span style="font-weight: bold; font-size: 25px">Perfil Usuario</span>
            </div>
        </div>
    </section>
    <!-- Content Header (Page header) -->

    <?php

    include_once 'class.crud.php';
    $crud = new crud();
    if (isset($_POST['btn-send'])) {

        $contrasena_actual = strip_tags($_POST['contrasena_actual']);
        $contrasena_nueva = strip_tags($_POST['contrasena_nueva']);
        $confirmar_contrasena = strip_tags($_POST['confirmar_contrasena']);



        $user['email'] =
            strip_tags($_POST['email']);
        $user['nombre'] =
            strip_tags($_POST['nombre']);
        $user['apellido']
            = strip_tags($_POST['apellido']);


        $pass2 = $crud->decryption($user['password']);

        if ($contrasena_actual != $pass2) {
            $sweetAlertCode = showSweetAlert('Error', 'La contraseña no es igual al la contraseña actual', 'error');
        } else if ($contrasena_nueva != $confirmar_contrasena) {
            $sweetAlertCode = showSweetAlert('Error', 'La contraseñas nuevas no coinciden', 'error');
        }
        $new = $crud->encryption($contrasena_nueva);
        if (!$sweetAlertCode) {
            try {
                $result = $crud->updateUser(
                    $user['email'],
                    $user['nombre'],
                    $user['apellido'],
                    $new,
                    $user['id']
                );
            } catch (Exception $e) {
                // código de manejo de error
                echo "Error al registrar la empresa: " . $e->getMessage();
            }

            if ($result == 2) {
                $crud->doLogin($user['email'], $new);
                $currentURL = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
                $currentURL .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $basePath = dirname($currentURL);
                $sweetAlertCode = showSweetAlert('Exito', 'La empresa se ha editado correctamente', 'success', 'Aceptar', '/perfil-usuario');
            } else {
                $sweetAlertCode = showSweetAlert('Error', 'Se ha generado un error a la hora de editar la empresa', 'error');
            }
        }
    }

    ?>

    <div class='container' style="overflow: auto; max-height: 600px;">
        <?php echo isset($sweetAlertCode) ? $sweetAlertCode : ''; ?>
    </div>
    <div class='container' style="overflow: auto; max-height: 600px;">
        <form method="post">
            <div class="form-row mt-3">
                <div class="col-12 col-sm-4">
                    <label for="email">Email</label>
                    <br />
                    <input class="multisteps-form__input form-control" type="text" id="email" name="email" placeholder="Email" value="<?php echo $user['email']; ?>" maxLength="150" required>
                </div>
                <div class="col-12 col-sm-4">
                    <label for="nombre">Nombre</label>
                    <br />
                    <input class="multisteps-form__input form-control" type="text" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo $user['nombre']; ?>" maxLength="150" required>
                </div>
                <div class="col-12 col-sm-4">
                    <label for="apellido">Apellido</label>
                    <br />
                    <input class="multisteps-form__input form-control" type="text" id="apellido" name="apellido" placeholder="Apellido" value="<?php echo $user['apellido']; ?>" maxLength="150" required>
                </div>

                <div class="col-12 col-sm-4">
                    <label for="contrasena_actual">Contraseña Actual</label>
                    <br />
                    <div class="password-input">
                        <input class="multisteps-form__input form-control" type="password" id="contrasena_actual" name="contrasena_actual" value="<?php echo $contrasena_actual; ?>" placeholder="Contraseña actual" maxLength="150" required autocomplete="off">
                        <span class="password-toggle" onclick="togglePassword('contrasena_actual')">
                            <i class="far fa-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="col-12 col-sm-4">
                    <label for="contrasena_nueva">Nueva Contraseña</label>
                    <br />
                    <div class="password-input">
                        <input class="multisteps-form__input form-control" type="password" id="contrasena_nueva" name="contrasena_nueva" value="<?php echo $contrasena_nueva; ?>" placeholder="Nueva contraseña" maxLength="150" required>
                        <span class="password-toggle" onclick="togglePassword('contrasena_nueva')">
                            <i class="far fa-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="col-12 col-sm-4">
                    <label for="confirmar_contrasena">Confirmar contraseña nueva</label>
                    <br />
                    <div class="password-input">
                        <input class="multisteps-form__input form-control" type="password" id="confirmar_contrasena" name="confirmar_contrasena" value="<?php echo $confirmar_contrasena; ?>" placeholder="Confirmar contraseña" maxLength="150" required>
                        <span class="password-toggle" onclick="togglePassword('confirmar_contrasena')">
                            <i class="far fa-eye"></i>
                        </span>
                    </div>
                </div>
                <style>
                    .password-input {
                        position: relative;
                    }

                    .password-toggle {
                        position: absolute;
                        top: 50%;
                        right: 10px;
                        transform: translateY(-50%);
                        cursor: pointer;
                    }
                </style>
                <script>
                    function togglePassword(inputId) {
                        const input = document.getElementById(inputId);
                        const icon = input.nextElementSibling.querySelector("i");
                        if (input.type === "password") {
                            input.type = "text";
                            icon.classList.remove("far", "fa-eye");
                            icon.classList.add("far", "fa-eye-slash");
                        } else {
                            input.type = "password";
                            icon.classList.remove("far", "fa-eye-slash");
                            icon.classList.add("far", "fa-eye");
                        }
                    }
                </script>
            </div>
            <div style="text-align: center;">
                <button class="btn btn-success ml-auto js-btn-next mb-3 mt-3" type="submit" name="btn-send" title="Next">Guardar</button>
            </div>
        </form>
    </div>

    <?php include_once('../layouts/footer.php'); ?>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/departamentos.js"></script>