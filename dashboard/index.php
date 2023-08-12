<?php include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; ?>
<style>
    .sector-title {
        font-size: 20px;
        margin-top: 20px;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: black;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: auto;
        margin-right: 10px;
        margin-left: 10px;
    }

    .sector-text {
        font-size: 18px;
        margin-bottom: 20px;
        padding-right: 50px;
        padding-left: 50px;
        text-align: justify;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <h1>
            <?php //echo mb_strtoupper($_SESSION['nomemp']); 
            ?>
            <!-- <small>Control panel</small> -->
        </h1>

        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel"  data-interval="false" style="background-image: url('../assets/img/carrousel2.jpg');background-repeat:no-repeat; background-size: 100% 100%; padding: 30px 100px 100px 100px;">
            <div class="carousel-inner" >
                <div class="carousel-item active">
                    <h4 class="sector-title">La presente aplicación contiene</h4>
                    <p class="sector-text">

                    <ol><em>
                            <li>
                                <p class="lead text-left"><strong>Formato de Descripción de
                                        Puestos/Cargos.</strong></p>
                            </li>
                            <li>
                                <p class="lead text-left"><strong>Acceso al sistema de Valoración de
                                Puestos/Cargos por puntos.</strong></p>
                            </li>
                            <li>
                                <p class="lead text-left"><strong>Matrices para registrar.</strong></p>
                                <ul>
                                    <li>
                                        <p class="lead text-justify"><strong><u>Matriz de Nómina</u>:
                                                Título del Puestos/Cargos, departamento, nombre del ocupante,
                                                ingreso mensual, paquete anual, fecha de ingreso, valor
                                                del Puestos/Cargos (entre cero mil puntos) pagos en divisas,
                                                etc., automáticamente se generará un gráfico donde podrá
                                                visualizar su estructura con su recta de
                                                regresión.</strong></p>
                                    </li>
                                    <li>
                                        <p class="lead text-justify"><strong><u>Matriz de
                                                    Jerarquización</u>: Crear banda salarial (mínimos,
                                                medio y máximo).</strong></p>
                                    </li>
                                    <li>
                                        <p class="lead text-justify"><strong><u>Matriz de
                                                    resultados</u>: Comparación con presupuesto y
                                                jerarquización de los Puestos/Cargos, comparada con la banda
                                                salarial.</strong></p>
                                    </li>
                                    <li>
                                        <p class="lead text-justify"><strong><u>Matriz de
                                                    Beneficios</u>: Identificación de los beneficios
                                                socioeconómicos, sus costos y relación con el
                                                presupuesto.</strong></p>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <p class="lead text-justify"><strong>Link de interés, glosario de
                                        términos y más información.</strong></p>
                            </li>
                        </em></ol>
                    </p>
                </div>
                <div class="carousel-item">
                    <h4 class="sector-title">Pasos para iniciar el proceso</h4>
                    <p class="sector-text">
                    <ol><em>
                            <li>
                                <p class="lead text-justify"><strong> DEBE REGISTRAR TODOS LOS
                                        DEPARTAMENTOS, GERENCIAS, UNIDADES, VP Y PRESIDENCIA, VER EN LA
                                        COLUMNA IZQUIERDA, INICIO – DEPARTAMENTOS.</strong></p>
                            </li>
                            <li>
                                <p class="lead text-justify"><strong> ASIGNAR TODOS LOS PUESTOS/CARGOS ADSCRITOS
                                        A CADA DEPARTAMENTO, GERENCIA, ETC. En este formato puede anotar
                                        las funciones de cada puesto/cargo y su valor o peso en escala de uno a
                                        mil puntos, si las posee. VER EN LA COLUMNA IZQUIERDA, INICIO –
                                        PUESTOS/CARGOS; de lo contrario utilice los formatos correspondientes
                                        (Descripción y Valoración de Cargos).</strong></p>
                            </li>
                            <li>
                                <p class="lead text-justify"><strong> EN MATRICES, la primera carga de
                                        información está en la MATRIZ DE NÓMINA; encontrara en el botón
                                        “NUEVO”, el REGISTRO DE INFORMACION, en ella aparecerán todos
                                        los departamentos registrados y sus puestos/cargos adscritos
                                        respectivamente. Si anoto las funciones y valoración de los
                                        puestos/cargos, también aparecerán. Adicionalmente complete la
                                        información solicitada en dicho registro.</strong></p>
                            </li>
                            <p class="lead text-justify"><strong><u> NOTA IMPORTANTE</u>: Para
                                    visualizar los gráficos correctamente, todos los puestos/cargos deben tener
                                    su puntaje, ingreso mensual y paquete anual.</strong></p>
                            <p class="lead text-justify"><strong> De la Matriz de nómina se derivan las
                                    Matrices de JERARQUIZACION Y LA DE RESULTADOS.</strong></p>
                            <li>
                                <p class="lead text-justify"><strong> MATRIZ DE BENEFICIOS. Esta permite
                                        cargar: los departamentos, gerencias, etc., por niveles
                                        jerárquicos; la lista de Beneficios Socio económicos, según la
                                        política de la organización y los costos de cada beneficio con
                                        su respectivo presupuesto.</strong></p>
                            </li>
                        </em> </ol>
                    </p>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>


    </section>
    <!-- Content Header (Page header) -->

    <!-- /.content -->
</div><!-- /.content-wrapper -->


<?php include '../layouts/footer.php' ?>