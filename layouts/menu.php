<?php
require_once("class.menu.php");
$menu_class = new menu();
?>

<style>
#treeview2 {
    background-color: #2d5260 !important
}

#treeview3 {
    background-color: #4c92af !important
}

;
</style>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
</nav>
<!-- /.navbar -->
<style>
/* ... Otros estilos que ya tienes ... */

.sticky-sidebar {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    /* Puedes ajustar la anchura del menú según tus necesidades */
    width: 250px;
    /* Agrega otros estilos que necesites para que el menú se vea bien */
}
</style>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 sticky-sidebar">

    <!-- Brand Logo -->
    <a href="../dashboard/" class="brand-link">
        <img src="../assets/img/logo/sidecoms-logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Sidecoms</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->




        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


                <?php
                $permisos = $_SESSION['permisos'];
					if ($permisos['p_setup'] == 1){
                ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-database"></i>
                        <p>
                            Setup
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">


                        <li class="nav-item">
                            <a href="../actividades" class="nav-link">
                                <i class="fa fa-database nav-icon"></i>
                                <p>Actividades</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../productos-servicios" class="nav-link">
                                <i class="fa fa-database nav-icon"></i>
                                <p>Productos-Servicios</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../sectores" class="nav-link">
                                <i class="fa fa-database nav-icon"></i>
                                <p>Sectores</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../frecuencias" class="nav-link">
                                <i class="fa fa-database nav-icon"></i>
                                <p>Frecuencia Aumento &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Salarial</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <?php
                        }
                        ?>


                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-circle-o text-yellow"></i>
                        <p>
                            Inicio
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <?php
                        if ($permisos['p_usuarios'] == 1){
                    ?>
                        <li class="nav-item">
                            <a href="../usuarios" class="nav-link">
                                <i class="fa fa-users nav-icon"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>
                        <?php
                        }
                        ?>
                        <?php
                        if ($permisos['p_departamentos'] == 1){
                    ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-sitemap nav-icon"></i>
                                <p>
                                    Departamentos
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" id="treeview2" name="treeview2">

                                <?php
                        if ($permisos['p_departamentos_adm'] == 1){
                    ?>

                                <li class="nav-item">
                                    <a href="../departamentos?ca=1" class="nav-link">
                                        <i class="fa fa-laptop nav-icon"></i>
                                        <p>Administrativos</p>
                                    </a>
                                </li>
                                <?php
                        }
                        ?>
                                <?php
                        if ($permisos['p_departamentos_taller'] == 1){
                    ?>
                                <li class="nav-item">
                                    <a href="../departamentos?ca=2" class="nav-link">
                                        <i class="fa fa-wrench nav-icon"></i>
                                        <p>Planta - Taller - Fábrica</p>
                                    </a>
                                </li>
                                <?php
                        }
                        ?>
                            </ul>
                        </li>

                        <?php
                        }
                        ?>

                        <?php
                        if ($permisos['p_cargos'] == 1){
                    ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-object-group nav-icon"></i>
                                <p>
                                    Puestos/Cargos
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" id="treeview2" name="treeview2">
                                <?php
                        if ($permisos['p_cargos_adm'] == 1){
                    ?>
                                <li class="nav-item">
                                    <a href="../cargos?ca=1&new" class="nav-link">
                                        <i class="fa fa-laptop nav-icon"></i>
                                        <p>Administrativos</p>
                                    </a>
                                </li>

                                <?php
                        }
                        ?>
                                <?php
                        if ($permisos['p_cargos_taller'] == 1){
                    ?>
                                <li class="nav-item">
                                    <a href="../cargos?ca=2&new" class="nav-link">
                                        <i class="fa fa-wrench nav-icon"></i>
                                        <p>Planta - Taller - Fábrica</p>
                                    </a>
                                </li>
                                <?php
                        }
                        ?>
                            </ul>
                        </li>

                        <?php
                        }
                        ?>
                    </ul>
                </li>


                <?php
                        if ($permisos['p_descripcion'] == 1){
                    ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-vcard-o"></i>
                        <p>
                            Descripción de &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Puestos/Cargos
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <?php
                        if ($permisos['p_descripcion_adm'] == 1){
                    ?>
                        <li class="nav-item">
                            <a href="../cargos?ca=1&des" class="nav-link">
                                <i class="fa fa-laptop nav-icon"></i>
                                <p>Administrativos</p>
                            </a>
                        </li>
                        <?php
                        }
                        ?>

                        <?php
                        if ($permisos['p_descripcion_taller'] == 1){
                    ?>
                        <li class="nav-item">
                            <a href="../cargos?ca=2&des" class="nav-link">
                                <i class="fa fa-wrench nav-icon"></i>
                                <p>Planta - Taller - Fábrica</p>
                            </a>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </li>

                <?php
                        }
                        ?>

                <?php
                        if ($permisos['p_escalas'] == 1){
                    ?>
                <li class="nav-item">
                    <a href="../escalas" class="nav-link">
                        <i class="fa fa-vcard-o nav-icon"></i>
                        <p>Escalas - Sistema de &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Puntos</p>
                    </a>
                </li>

                <?php
                        }
                        ?>

                <?php
                        if ($permisos['p_valoracion'] == 1){
                    ?>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-list-ol nav-icon"></i>
                        <p>
                            Valoración de &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Puestos/Cargos
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php
                        if ($permisos['p_valoracion_adm'] == 1){
                    ?>

                        <li class="nav-item">
                            <a href="../cargos?ca=1&val" class="nav-link">
                                <i class="fa fa-laptop nav-icon"></i>
                                <p>Administrativos</p>
                            </a>
                        </li>
                        <?php
                        }
                        ?>
                        <?php
                        if ($permisos['p_valoracion_taller'] == 1){
                    ?>

                        <li class="nav-item">
                            <a href="../cargos?ca=2&val" class="nav-link">
                                <i class="fa fa-wrench nav-icon"></i>
                                <p>Planta - Taller - Fábrica</p>
                            </a>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </li>

                <?php
                        }
                        ?>

                <?php
                        if ($permisos['p_matrices'] == 1){
                    ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-gears"></i>
                        <p>
                            Matrices
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <?php
                        if ($permisos['p_nomina'] == 1){
                    ?>
                        <li class="nav-item">
                            <a href="../matriz-nomina?ca=1" class="nav-link">
                                <i class="fa fa-edit nav-icon"></i>
                                <p>Matriz de Nómina</p>
                            </a>
                        </li>
                        <?php
                        }
                        ?>

                        <?php
                        if ($permisos['p_jerarquizacion'] == 1){
                    ?>
                        <li class="nav-item">
                            <a href="../matriz-jerarquizacion" class="nav-link">
                                <i class="fa fa-list-ol nav-icon"></i>
                                <p>Matriz de &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jerarquización</p>
                            </a>
                        </li>
                        <?php
                        }
                        ?>

                        <?php
                        if ($permisos['p_resultados'] == 1){
                    ?>
                        <li class="nav-item">
                            <a href="../matriz-resultados?ca=1" class="nav-link">
                                <i class="fa fa-check nav-icon"></i>
                                <p>Matriz de Resultados</p>
                            </a>
                        </li>

                        <?php
                        }
                        ?>
                        <?php
                        if ($permisos['p_beneficios'] == 1){
                    ?>
                        <li class="nav-item">
                            <a href="../matriz-beneficios" class="nav-link">
                                <i class="fa fa-puzzle-piece nav-icon"></i>
                                <p>Matriz de Beneficios</p>
                            </a>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </li>

                <?php
                        }
                        ?>

                <?php
                        if ($permisos['p_tablas'] == 1){
                    ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-database nav-icon"></i>
                        <p>
                            Tablas
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">


                        <?php
                        if ($permisos['p_links'] == 1){
                    ?>
                        <li class="nav-item">
                            <a href="../links" class="nav-link">
                                <i class="fa fa-external-link nav-icon"></i>
                                <p>Links de Interés</p>
                            </a>
                        </li>
                        <?php
                        }
                        ?>

                        <?php
                        if ($permisos['p_glosario'] == 1){
                    ?>

                        <li class="nav-item">
                            <a href="../glosario" class="nav-link">
                                <i class="fa fa-comments-o nav-icon"></i>
                                <p>Glosario de Términos</p>
                            </a>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </li>

                <?php
                        }
                        ?>

                <?php
                        if ($permisos['p_perfiles'] == 1){
                    ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-address-card-o nav-icon"></i>
                        <p>
                            Perfiles
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <?php
                        if ($permisos['p_perfil_organizacion'] == 1){
                    ?>
                        <li class="nav-item">
                            <a href="../empresa" class="nav-link">
                                <i class="fa fa-registered nav-icon"></i>
                                <p>Perfil de Organización</p>
                            </a>
                        </li>
                        <?php
                        }
                        ?>
                        <?php
                        if ($permisos['p_perfil_usuario'] == 1){
                    ?>
                        <li class="nav-item">
                            <a href="../perfil-usuario" class="nav-link">
                                <i class="fa fa-user nav-icon"></i>
                                <p>Perfil de Usuario</p>
                            </a>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </li>

                <?php
                        }
                        ?>
                <?php
                        if ($permisos['p_view_links'] == 1){
                    ?>
                <li class="nav-item">
                    <a href="../view-links" class="nav-link">
                        <i class="fa fa-external-link nav-icon"></i>
                        <p>Links de Interés</p>
                    </a>
                </li>

                <?php
                        }
                        ?>

                <?php
                        if ($permisos['p_view_glosario'] == 1){
                    ?>
                <li class="nav-item">
                    <a href="../view-glosario" class="nav-link">
                        <i class="fa fa-comments-o nav-icon"></i>
                        <p>Glosario de Términos</p>
                    </a>
                </li>

                <?php
                        }
                        ?>

                <li class="nav-item">
                    <a href="../layouts/logout" class="nav-link">
                        <i class="fa fa-power-off nav-icon"></i>
                        <p>Salir</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>