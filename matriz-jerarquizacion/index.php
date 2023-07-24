<?php include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <div class="card text-left">
            <div class="card-header">
                <span style="font-weight: bold; font-size: 25px">Matriz de Jerarquización</span>
            </div>
        </div>

    </section>
    <!-- Content Header (Page header) -->

    <?php

    include_once 'class.crud.php';
    $crud = new crud();  
 $categoria = $_GET['ca'];

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

    <div class="container">
        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-sm-3 form-group">
                    <select name="cboCategoria" id="cboCategoria" class="form-control input-sm"
                        onchange="redirectcategoria(this.value)">
                        <option value="1" <?php if($categoria == 1){echo "selected";} ?>>Administrativo</option>
                        <option value="2" <?php if($categoria == 2){echo "selected";} ?>>Plata - Taller - Fábrica
                        </option>
                    </select>
                </div>
                <div class="col-sm-3 form-group">
                    <select class="form-control input-sm" id="cboAsignaciones">
                        <option value="" selected disabled>-- Seleccione --</option>
                        <option value="1">Sueldo Base Mensual</option>
                        <option value="2">Ingreso Total Mensual</option>
                        <option value="3">Paquete Anual</option>
                    </select>
                </div>
                <div class="col-sm-2 form-group">
                    <button type="button" class="btn btn-success btn-block btn-sm" title="Generar gráfica"
                        id="btn-gengraph" 
                        onclick="showGraph('<?php if(isset($_GET['im'])){ echo $_GET['im']; } else {echo '0';} ?>',
                        '<?php if(isset($_GET['ig'])){ echo $_GET['ig']; } else {echo '0';} ?>',
                        '<?php if(isset($_GET['immm'])){ echo $_GET['immm']; } else {echo '0';} ?>')">Generar Gráfica</button>
                </div>

                <div class="col-sm-2 form-group">
                    <button type="button" class="btn btn-danger btn-block btn-sm" title="Mostrar/Ocultar gráfica"
                        id="toggle-grafica" onclick="mostrar_ocultar_grafica()">Mostrar/Ocultar Gráfica</button>
                </div>

            </div>





    </div>

    <div id="chart-container" style="display: none">
        <canvas id="graphCanvas"></canvas>
    </div>


    <br>


    <div class="container">
        <!-- Main content -->
        <section class="content">

            <div class="row" id="formcss">
                <div class="col-sm-3 form-group">
                    <label for="ingreso_minimo">Ingreso Minimo</label>
                    <input type="number" class="form-control input-sm" id="ingreso_minimo"
                        placeholder="Indique el Ingreso Minimo" required title="Indique el Ingreso Minimo" />
                </div>
                <div class="col-sm-3 form-group">
                    <label for="incremento_grados">% Incremento en Grados</label>
                    <input type="number" class="form-control input-sm" id="incremento_grados"
                        placeholder="% Incremento en Grados" title="% Incremento en Grados" />
                </div>
                <div class="col-sm-4 form-group">
                    <label for="incremento_min_med_max">% Incremento en Mín, Med, Máx</label>
                    <div class="row">
                        <div class="col-md-8">
                            <input type="number" class="form-control input-sm" id="incremento_min_med_max"
                                placeholder="% Incremento en Mín, Med, Máx" title="% Incremento en Mín, Med, Máx" />
                        </div>

                    <div class="col-md-4 ">
      
                    <button type="button" class="btn btn-success btn-block btn-sm" title="Generar Banda"
                        id="btn-banda" onclick="generar_banda(<?= $categoria ?>)">Generar Banda</button>
                </div>

                    </div>

                </div>

                

            </div>

            <?php
                extract($crud->get_nombre_moneda()); 
                $user = $_SESSION['user'];
                $escalas = $crud->dataview_escalas($categoria);
                extract($crud->get_datos_empresa($user['id_empresa']));	
                extract($crud->get_sum_empleados($categoria));	
                extract($crud->get_nivel_empresarial($nivel_empresarial));	
                
                
        ?>

        <div class="row">
            <div class="col-sm-1 form-group">
                        <button type="button" class="btn btn-info btn-block btn-sm" title="Ver Escala Empresarial"
                            id="ver_escala" onclick="ver_escala(<?php echo htmlspecialchars(json_encode($escalas)); ?>,'<?= $nombre_empresa ?>','<?= $categoria ?>','<?= $conteo ?>','<?= $nombre_nivel ?>','<?= $minimo_nivel ?>','<?= $maximo_nivel ?>')">Ver Escala</button>
            </div>

            <div class="col-sm-10 form-group" style="text-align: right;">
                <span style="font-size: 12px; color:red">(MONTOS EXPRESADOS EN <?=strtoupper($nombre_moneda)?>)</span>
            </div>
        </div>
        <br>

            <br>
            <div class='container' style="overflow: auto; max-height: 600px;">
                <table id="example" class="table table-striped dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>

                            <th>Grado</th>
                            <th>Mín</th>
                            <th>Máx</th>
                            <th>Promedio Puntaje</th>
                            <th>Promedio Ingreso Mensual</th>
                            <th>Promedio Ingreso Total Mensual</th>
                            <th>Promedio Paquete Anual</th>
                            <th>Promedio Factor Anual</th>
                            <th>Mínimo</th>
                            <th>Medio</th>
                            <th>Máximo</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php
                if ($categoria == 1)
                {
                    $jerarquizacions = $crud->dataview_admin();
                }
                if ($categoria == 2)
                {
                    $jerarquizacions = $crud->dataview_taller(); 
                }
               
                if(isset($_GET['im']))
                {
                    $ingreso_minimo = $_GET['im'];
                }
                else
                {
                    $ingreso_minimo = 150000;
                }

                if(isset($_GET['ig']))
                {
                    $incremento_grados = $_GET['ig'];
                }
                else
                {
                    $incremento_grados = 0.50;
                }

                if(isset($_GET['immm']))
                {
                    $incremento_min_med_max = $_GET['immm'];
                }
                else
                {
                    $incremento_min_med_max = 0.90;
                }
               
                $contador = 1;
                if ($jerarquizacions != null) {
                    foreach ($jerarquizacions as $jerarquizacion) {


                   if($contador == 1)
                   {
                    $minimo = round($ingreso_minimo,2);
                    $medio = round(($minimo + ($minimo * $incremento_min_med_max)),2);
                    $maximo = round($medio + ($medio * $incremento_min_med_max),2);
                    $contador++;
                   }
                   else
                   {
                    $minimo =  round(($minimo + ($minimo * $incremento_grados)),2);
                    $medio = round($minimo + ($minimo * $incremento_min_med_max),2);
                    $maximo = round($medio + ($medio * $incremento_min_med_max),2);
                   }
                       
                       
                ?>
                        <tr>

                            <td style="text-align: center;"><?php print($jerarquizacion['grado']); ?></td>
                            <td><?php print($jerarquizacion['minimo']); ?></td>
                            <td><?php print($jerarquizacion['maximo']); ?></td>

                            <td><?php print($jerarquizacion['promediopuntaje']); ?></td>
                            <td><?php print($jerarquizacion['promediosueldobase']); ?></td>

                            <td><?php print($jerarquizacion['promediosueldomensual']); ?></td>

                            <td><?php print($jerarquizacion['promediopaqueteanual']); ?></td>
                            <td><?php print($jerarquizacion['promediofactor']); ?></td>
                            <td><?php print($minimo); ?></td>
                            <td><?php print($medio); ?></td>
                            <td><?php print($maximo); ?></td>


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
                            <th>Grado</th>
                            <th>Mín</th>
                            <th>Máx</th>
                            <th>Promedio Puntaje</th>
                            <th>Promedio Ingreso Mensual</th>
                            <th>Promedio Ingreso Total Mensual</th>
                            <th>Promedio Paquete Anual</th>
                            <th>Promedio Factor Anual</th>
                            <th>Mínimo</th>
                            <th>Medio</th>
                            <th>Máximo</th>
                        </tr>
                    </tfoot>
                </table>




            </div>
    </div>
    <?php include_once('../layouts/footer.php'); ?>

    <script src="assets/js/jerarquizacion.js"></script>

    <script>
    $(document).ready(function() {
        $(".hidden").hide();

    });

    function mostrar_ocultar_grafica() {

        const toggleButton = document.getElementById('toggle-grafica');
        const graficaContainer = document.getElementById('chart-container');


        // Verificar si la gráfica está visible
        if (graficaContainer.style.display === 'none') {
            // Mostrar la gráfica
            graficaContainer.style.display = 'block';
            // Crear la instancia de la gráfica
        } else {
            // Ocultar la gráfica
            graficaContainer.style.display = 'none';
            // Destruir la instancia de la gráfica
        }



    }

    function redirectcategoria(categoria) {
        window.location.href = "../matriz-jerarquizacion/?ca=" + categoria;
    }

    function generar_banda(categoria) {

        var im = $("#ingreso_minimo").val();
        var ig = $("#incremento_grados").val();
        var immm = $("#incremento_min_med_max").val();

        ig = ig / 100;
        immm = immm / 100;

        if(im == "")
        {

        }
        else if(ig == "")
        {

        } 
        else if(immm == "")
        {

        }
        else
        {
            window.location.href = "../matriz-jerarquizacion/?ca=" + categoria+ "&im=" + im + "&ig=" + ig + "&immm=" + immm;
        }
       
    }


    function ver_escala(escalas, nombre_empresa,categoria,conteo,nombre_nivel,minimo_nivel,maximo_nivel) {
    var catego= "";
    if(categoria == 1)
    {
        catego = "Administrativo";
    }
    if(categoria == 2)
    {
        catego = "Planta - Taller - Fábrica";
    }
    var html= `   <span class="text-center"><span class="glyphicon glyphicon-check"></span> Clasificación de Empresas en base al N° de trabajadores</span><br>
                    <span class="text-center">(cifras aproximadas)</span><br>
                    <br>
                    <br>

                    <div class="text-left" style="font-size: 14px">
                    <span style="color: 25B9FF">Empresa: ${nombre_empresa} </span><br>
                    <span style="color: 25B9FF">Categoria: ${catego} </span><br>
                    <span style="color: red">Total Trabajadores: ${conteo} </span>
                    </div>
                    <br>

                    <span style="font-size: 30px"><strong> ${nombre_nivel.trim()}s Empresas </strong></span><br>
                    <span class="text-center"> De ${minimo_nivel} a ${maximo_nivel} Trabajadores </span><br>
                    <span class="text-center">Estructura de Grados y Puntos para la Valoración de Cargos: </span><br><br>
    `;


    console.log(escalas);
   
    html += `<table id="escalas" class="table table-striped dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Grado</th>
                            <th>Mínimo</th>
                            <th>Máximo</th>
                        </tr>
                    </thead>
                    <tbody> 
                        `;
                        escalas.forEach(function (escalas) {
html += `<tr>
            <td style="text-align: center;"> ${escalas["grado"]} </td>
            <td> ${escalas["minimo"]} </td>
            <td> ${escalas["maximo"]} </td>
            </tr>`;
});

html += `            
                       
                    </tbody>
                   
                </table>
                <br>
                <br>`;

    Swal.fire({
      title: "Escala Empresarial",
      html: html,
      width: '800px',
      showConfirmButton: false,
   });
   $(document).ready(function() {
        $('#escalas').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
            },
        });
    });


    }

    function showGraph(im,ig,immm) {


        const toggleButton = document.getElementById('toggle-grafica');
        const graficaContainer = document.getElementById('chart-container');
        if (graficaContainer.style.display === 'none') {
            // Mostrar la gráfica
            graficaContainer.style.display = 'block';
            // Crear la instancia de la gráfica
        }


     
        let categoria = $("#cboCategoria").val();
        let asignacion = $("#cboAsignaciones").val(); //
        var categ = "";
        var titulo = "";
        var tipo_asign = "";

        if (($("#cboAsignaciones").val()) === '1') {
            tipo_asign = "INGRESO MENSUAL"
        }
        if (($("#cboAsignaciones").val()) === '2') {
            tipo_asign = "INGRESO TOTAL MENSUAL"
        }
        if (($("#cboAsignaciones").val()) === '3') {
            tipo_asign = "PAQUETE ANUAL"
        }

        titulo = "RECTA DE REGRESIÓN LINEAL - " + categ + " - " + tipo_asign;




        $.post("datos_grafica.php", {
            categoria: categoria,
            asignacion: asignacion
        }, function(data) {
            console.log(data);

            
            for (var i in data) {
                sueldominimo = data[i].sueldominimo;
                sminimo = data[i].sminimo;
                tipoempresa = data[i].tipoempresa;

                if(tipoempresa >= 2)
                {
                    promediosueldogradoII =  data[i].promediosueldogradoII;
                }
                if(tipoempresa >= 3)
                {
                    promediosueldogradoIII =  data[i].promediosueldogradoIII;
                }
                if(tipoempresa >= 4)
                {
                    promediosueldogradoIV =  data[i].promediosueldogradoIV;
                }
                if(tipoempresa >= 5)
                {
                    promediosueldogradoV =  data[i].promediosueldogradoV;
                }
                if(tipoempresa >= 6)
                {
                    promediosueldogradoVI =  data[i].promediosueldogradoVI; 
                }
                if(tipoempresa >= 7)
                {
                    promediosueldogradoVII =  data[i].promediosueldogradoVII;
                }
                if(tipoempresa >= 8)
                {
                    promediosueldogradoVIII =  data[i].promediosueldogradoVIII;
                }
                if(tipoempresa >= 9)
                {
                    promediosueldogradoIX =  data[i].promediosueldogradoIX;
                }
                if(tipoempresa >= 10)
                {
                    promediosueldogradoX =  data[i].promediosueldogradoX;
                }
                if(tipoempresa >= 11)
                {
                    promediosueldogradoXI =  data[i].promediosueldogradoXI;
                }
                if(tipoempresa >= 12)
                {
                    promediosueldogradoXII =  data[i].promediosueldogradoXII;
                }
                if(tipoempresa >= 13)
                {
                    promediosueldogradoXIII =  data[i].promediosueldogradoXIII;
                }
                if(tipoempresa >= 14)
                {
                    promediosueldogradoXIV =  data[i].promediosueldogradoXIV; 
                }
                if(tipoempresa >= 15)
                {
                    promediosueldogradoXV =  data[i].promediosueldogradoXV;  
                }
            }
            const minimo = [];

        if (im == 0)
        {
            im = sueldominimo;
        }

        if (ig == 0)
        {
            ig = ig;
        }

        if (immm == 0)
        {
            immm = immm;
        }


            minimo.push({
            x: 'I',
            y: im
        });

            const medio = [];
            var sueldomedio = parseFloat(parseFloat(im) + (im * immm));

            medio.push({
            x: 'I',
            y: sueldomedio
        });

            const maximo = [];
            var sueldomaximo = parseFloat(parseFloat(sueldomedio) + (sueldomedio * immm));

            maximo.push({
            x: 'I',
            y: sueldomaximo
        });

            const promedio = [];

           


             if(tipoempresa >= 2)
                {
                    promedio.push({
                    x: 'II',
                    y: promediosueldogradoII
                });
                }
                if(tipoempresa >= 3)
                {
                    promedio.push({
                    x: 'III',
                    y: promediosueldogradoIII
                });
                }
                if(tipoempresa >= 4)
                {
                    promedio.push({
                    x: 'IV',
                    y: promediosueldogradoIV
                });
                }
                if(tipoempresa >= 5)
                {                   
                    promedio.push({
                    x: 'V',
                    y: promediosueldogradoV
                });
                }
                if(tipoempresa >= 6)
                {
                    promedio.push({
                    x: 'VI',
                    y: promediosueldogradoVI
                });
                }
                if(tipoempresa >= 7)
                {
                    promedio.push({
                    x: 'VII',
                    y: promediosueldogradoVII
                });
                }
                if(tipoempresa >= 8)
                {
                    promedio.push({
                    x: 'VIII',
                    y: promediosueldogradoVIII
                });
                }
                if(tipoempresa >= 9)
                {
                    promedio.push({
                    x: 'IX',
                    y: promediosueldogradoIX
                });
                }
                if(tipoempresa >= 10)
                {
                    promedio.push({
                    x: 'X',
                    y: promediosueldogradoX
                });
                }
                if(tipoempresa >= 11)
                {
                    promedio.push({
                    x: 'XI',
                    y: promediosueldogradoXI
                });
                }
                if(tipoempresa >= 12)
                {
                    promedio.push({
                    x: 'XII',
                    y: promediosueldogradoXII
                });
                }
                if(tipoempresa >= 13)
                {
                    promedio.push({
                    x: 'XIII',
                    y: promediosueldogradoXIII
                });
                }
                if(tipoempresa >= 14)
                {
                    promedio.push({
                    x: 'XIV',
                    y: promediosueldogradoXIV
                });
                }
                if(tipoempresa >= 15)
                {
                    promedio.push({
                    x: 'XV',
                    y: promediosueldogradoXV
                });
                }


        if(tipoempresa >= 2)
        {
           
            sueldominimo = parseFloat(parseFloat(im) + parseFloat(im * ig));
            
            minimo.push({
            x: 'II',
            y: sueldominimo
        });

            sueldomedio = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * immm));

            medio.push({
            x: 'II',
            y: sueldomedio
        });

        sueldomaximo = parseFloat(parseFloat(sueldomedio) + parseFloat(sueldomedio * immm));

            maximo.push({
            x: 'II',
            y: sueldomaximo
        });

        }

        if(tipoempresa >= 3)
        {
            sueldominimo = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * ig));
            
            minimo.push({
            x: 'III',
            y: sueldominimo
        });

        sueldomedio = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * immm));

            medio.push({
            x: 'III',
            y: sueldomedio
        });

        sueldomaximo = parseFloat(parseFloat(sueldomedio) + parseFloat(sueldomedio * immm));

            maximo.push({
            x: 'III',
            y: sueldomaximo
        });
        }

        if(tipoempresa >= 4)
        {
            sueldominimo = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * ig));
            
            minimo.push({
            x: 'IV',
            y: sueldominimo
        });

        sueldomedio = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * immm));

            medio.push({
            x: 'IV',
            y: sueldomedio
        });

        sueldomaximo = parseFloat(parseFloat(sueldomedio) + parseFloat(sueldomedio * immm));

            maximo.push({
            x: 'IV',
            y: sueldomaximo
        });
        }

        if(tipoempresa >= 5)
        {
            sueldominimo = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * ig));
            
            minimo.push({
            x: 'V',
            y: sueldominimo
        });

        sueldomedio = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * immm));

            medio.push({
            x: 'V',
            y: sueldomedio
        });

        sueldomaximo = parseFloat(parseFloat(sueldomedio) + parseFloat(sueldomedio * immm));

            maximo.push({
            x: 'V',
            y: sueldomaximo
        });
        }

        if(tipoempresa >= 6)
        {
            sueldominimo = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * ig));
            
            minimo.push({
            x: 'VI',
            y: sueldominimo
        });

        sueldomedio = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * immm));

            medio.push({
            x: 'VI',
            y: sueldomedio
        });

        sueldomaximo = parseFloat(parseFloat(sueldomedio) + parseFloat(sueldomedio * immm));

            maximo.push({
            x: 'VI',
            y: sueldomaximo
        });
        }

        if(tipoempresa >= 7)
        {
            sueldominimo = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * ig));
            
            minimo.push({
            x: 'VII',
            y: sueldominimo
        });

        sueldomedio = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * immm));

            medio.push({
            x: 'VII',
            y: sueldomedio
        });

        sueldomaximo = parseFloat(parseFloat(sueldomedio) + parseFloat(sueldomedio * immm));

            maximo.push({
            x: 'VII',
            y: sueldomaximo
        });
        }

        if(tipoempresa >= 8)
        {
            sueldominimo = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * ig));
            
            minimo.push({
            x: 'VIII',
            y: sueldominimo
        });

        sueldomedio = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * immm));

            medio.push({
            x: 'VIII',
            y: sueldomedio
        });

        sueldomaximo = parseFloat(parseFloat(sueldomedio) + parseFloat(sueldomedio * immm));

            maximo.push({
            x: 'VIII',
            y: sueldomaximo
        });
        }

        if(tipoempresa >= 9)
        {
            sueldominimo = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * ig));
            
            minimo.push({
            x: 'IX',
            y: sueldominimo
        });

        sueldomedio = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * immm));

            medio.push({
            x: 'IX',
            y: sueldomedio
        });

        sueldomaximo = parseFloat(parseFloat(sueldomedio) + parseFloat(sueldomedio * immm));

            maximo.push({
            x: 'IX',
            y: sueldomaximo
        }); 
        }

        if(tipoempresa >= 10)
        {
            sueldominimo = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * ig));
            
            minimo.push({
            x: 'X',
            y: sueldominimo
        });

        sueldomedio = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * immm));

            medio.push({
            x: 'X',
            y: sueldomedio
        });

        sueldomaximo = parseFloat(parseFloat(sueldomedio) + parseFloat(sueldomedio * immm));

            maximo.push({
            x: 'X',
            y: sueldomaximo
        });
        }

        if(tipoempresa >= 11)
        {
            sueldominimo = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * ig));
            
            minimo.push({
            x: 'XI',
            y: sueldominimo
        });

        sueldomedio = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * immm));

            medio.push({
            x: 'XI',
            y: sueldomedio
        });

        sueldomaximo = parseFloat(parseFloat(sueldomedio) + parseFloat(sueldomedio * immm));

            maximo.push({
            x: 'XI',
            y: sueldomaximo
        });
        }

        if(tipoempresa >= 12)
        {
            sueldominimo = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * ig));
            
            minimo.push({
            x: 'XII',
            y: sueldominimo
        });

        sueldomedio = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * immm));

            medio.push({
            x: 'XII',
            y: sueldomedio
        });

        sueldomaximo = parseFloat(parseFloat(sueldomedio) + parseFloat(sueldomedio * immm));

            maximo.push({
            x: 'XII',
            y: sueldomaximo
        });
        }

        if(tipoempresa >= 13)
        {
            sueldominimo = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * ig));
            
            minimo.push({
            x: 'XIII',
            y: sueldominimo
        });

        sueldomedio = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * immm));

            medio.push({
            x: 'XIII',
            y: sueldomedio
        });

        sueldomaximo = parseFloat(parseFloat(sueldomedio) + parseFloat(sueldomedio * immm));

            maximo.push({
            x: 'XIII',
            y: sueldomaximo
        }); 
        }

        if(tipoempresa >= 14)
        {
            sueldominimo = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * ig));
            
            minimo.push({
            x: 'XIV',
            y: sueldominimo
        });

        sueldomedio = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * immm));

            medio.push({
            x: 'XIV',
            y: sueldomedio
        });

        sueldomaximo = parseFloat(parseFloat(sueldomedio) + parseFloat(sueldomedio * immm));

            maximo.push({
            x: 'XIV',
            y: sueldomaximo
        });
        }

        if(tipoempresa >= 15)
        {
            sueldominimo = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * ig));
            
            minimo.push({
            x: 'XV',
            y: sueldominimo
        });

        sueldomedio = parseFloat(parseFloat(sueldominimo) + parseFloat(sueldominimo * immm));

            medio.push({
            x: 'XV',
            y: sueldomedio
        });

        sueldomaximo = parseFloat(parseFloat(sueldomedio) + parseFloat(sueldomedio * immm));

            maximo.push({
            x: 'XV',
            y: sueldomaximo
        }); 
        }
           

        console.log(minimo);
        console.log(medio);
        console.log(maximo);

            var graphTarget = document.getElementById('graphCanvas').getContext('2d');



            if (window.grafica) {
                window.grafica.clear();
                window.grafica.destroy();
            }



            window.grafica = new Chart(graphTarget, {
                data: {
                    datasets: [{
                            label: "Minimo",
                            data: minimo,
                            borderColor: '#FF9700',
                            backgroundColor: '#FF9700',
                            type: 'line',
                            pointRadius: 3,
                            order: 1,
                        },
                        {
                            label: "Medio",
                            data: medio,
                            borderColor: '#FBFF00',
                            backgroundColor: '#FBFF00',
                            pointRadius: 3,
                            type: 'line',
                            order: 2
                        },
                        {
                            label: "Máximo",
                            data: maximo,
                            borderColor: '#00A2FF',
                            backgroundColor: '#00A2FF',
                            pointRadius: 3,
                            type: 'line',
                            order: 3
                        },
                        {
                            label: "Promedio",
                            data: promedio,
                            borderColor: '#0C00FF',
                            backgroundColor: '#0C00FF',
                            pointRadius: 3,
                            type: 'line',
                            order: 4
                        }

                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            align: 'start',
                            display: true,
                            text: titulo

                        },
                        
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Puntaje'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Sueldos'
                            }
                        }
                    }
                }
            });





        });

    }
    </script>