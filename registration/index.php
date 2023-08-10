<link rel="stylesheet" href="../assets/css/stylebuttons.css">
<?php
session_start();
require_once("class.crud.php");
require_once '../tools/functions.php';
$error = "";
$register = new crud();
$firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
$lastname = isset($_POST['lastname']) ? strip_tags($_POST['lastname']) : '';
$email = isset($_POST['email']) ? strip_tags($_POST['email']) : '';


/*
if($login->is_loggedin()!="")
{

    if($_SESSION['user_type'] == 1)
    {
        $login->redirect('../usuarios');
    }
    if($_SESSION['user_type'] == 2)
    {
        $login->redirect('../clientes');
    }	

}
*/

if (isset($_POST['btn-register'])) {
    // Obtener los datos del formulario
    $firstname = strip_tags($_POST['firstname']);
    $lastname = strip_tags($_POST['lastname']);
    $email = strip_tags($_POST['email']);
    $password = strip_tags($_POST['password']);
    $confirm_password = strip_tags($_POST['confirm_password']);
    $successMessage = "";
    $errorMessage = "";

    // Validar los datos del formulario
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirm_password)) {
        $errorMessage = "Por favor, completa todos los campos.";
    } elseif ($password !== $confirm_password) {
        $errorMessage = "Las contraseñas no coinciden.";
    } else {
        $password = $register->encryption($password);
        // Llamar al método doRegister
        $registroExitoso = $register->doRegister($email, $password, $firstname, $lastname, $email);
        if ($registroExitoso == 2) {
            $sweetAlertCode = showSweetAlert('Exito', "Registro exitoso. Ahora puedes iniciar sesión.", 'success', 'Aceptar', "/login");
        } elseif ($registroExitoso == 1) {
            $errorMessage = "El email ya está en uso. Por favor, elige otro.";
        } else {
            $errorMessage = "Ocurrió un error durante el registro. Por favor, inténtalo nuevamente.";
        }
    }

    // Mostrar mensajes de error y éxito
    if ($errorMessage) {
        echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>' . $errorMessage . '</strong>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
}

?>

<?php include '../layouts/header.php'; ?>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="assets/css/registration.css" />
</head>

<body>
    <?php echo isset($sweetAlertCode) ? $sweetAlertCode : ''; ?>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="wrap">
                        <div class="img" style="background-image: url(../assets/img/login/logov1.jpg)"></div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Registrarse</h3>
                                </div>
                            </div>
                            <form method="post" class="signin-form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mt-3">
                                            <input name="firstname" id="firstname" type="text" class="form-control" required value="<?php echo $firstname; ?>" maxlength="24" />
                                            <label class="form-control-placeholder" for="firstname">Nombre</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mt-3">
                                            <input name="lastname" id="lastname" type="text" class="form-control" required value="<?php echo $lastname; ?>" maxlength="24" />
                                            <label class="form-control-placeholder" for="lastname">Apellido</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mt-3">
                                            <input name="email" id="email" type="email" class="form-control" required value="<?php echo $email; ?>" maxlength="40" />
                                            <label class="form-control-placeholder" for="email">Correo electrónico</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mt-3">
                                            <input name="password" id="password" type="password" class="form-control" required minlength="5" maxlength="20" />
                                            <label class="form-control-placeholder" for="password">Contraseña</label>
                                            <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mt-3">
                                            <input name="confirm_password" id="confirm_password" type="password" class="form-control" required minlength="5" maxlength="20" />
                                            <label class="form-control-placeholder" for="confirm_password">Confirmar Contraseña</label>
                                            <span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" name="btn-register" id="register" class="form-control btn btn-primary rounded submit px-3">
                                        Registrarse
                                    </button>
                                </div>
                            </form>
                            <p class="text-center">
                                ¿Ya tienes una cuenta? <a data-toggle="tab" href="../login">Iniciar sesión</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>