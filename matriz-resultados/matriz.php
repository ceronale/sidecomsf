<?php include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <div class="card text-left">
            <div class="card-header">
                <span style="font-weight: bold; font-size: 25px">Matriz de Nómina</span>
            </div>
        </div>

    </section>
    <!-- Content Header (Page header) -->



    <div class='container'>
        <!-- graficas inicio -->
        <div class="box box-danger">


            <div class="box-header with-border">
                <h4>Mostrar Gráfica</h4>
                <div class="row">
                    <div class="col-sm-3 form-group">
                        <select name="cboCategoria" id="cboCategoria" class="form-control input-sm">
                            <option value="1">Administrativo</option>
                            <option value="2">Plata - Taller - Fábrica</option>
                        </select>
                    </div>
                    <div class="col-sm-3 form-group">
                        <select class="form-control input-sm" id="cboAsignaciones">
                            <option value="" selected disabled>-- Seleccione --</option>
                            <option value="1">Ingreso Mensual</option>
                            <option value="2">Ingreso Total Mensual</option>
                            <option value="3">Paquete Anual</option>
                        </select>
                    </div>
                    <div class="col-sm-2 form-group">
                        <button type="button" class="btn btn-success btn-block btn-sm" title="Generar gráfica"
                            id="btn-gengraph" onclick="showGraph()">Generar Gráfica</button>
                    </div>
                    <div class="col-sm-2 form-group">
                        <button type="button" class="btn btn-primary btn-block btn-sm open"
                            title="mostrar/ocultar gráfica">MOSTRAR</button>
                    </div>
                    <div class="col-sm-2 form-group">
                        <button type="button" id="delgraph" class="btn btn-danger btn-block btn-sm"
                            title="borrar gráfica">BORRAR</button>
                    </div>
                </div>

            </div>

            <div id="chart-container">
                <canvas id="graphCanvas"></canvas>
            </div>


        </div>







    </div>
</div>
<?php include_once('../layouts/footer.php'); ?>
<script>
function showGraph() {
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


    if (($("#cboCategoria").val()) === '1') {
        var min = 214;
        var max = 1000;
        categ = "ADMINISTRATIVO";
    } else {
        var min = 299;
        var max = 1000;
        categ = "PLANTA - TALLER - FÁBRICA";
    }

    titulo = "RECTA DE REGRESIÓN LINEAL - " + categ + " - " + tipo_asign;



    $.post("datos_grafica.php", {
        categoria: categoria,
        asignacion: asignacion
    }, function(data) {
        console.log(data);

        var puntajegrado2 = 0;
        var conteogradoI = 0;
        var sueldogradoI = 0;

        var puntajegradoII = 0;
        var conteogradoII = 0;
        var sueldogradoII = 0;

        var puntajegradoIII = 0;
        var conteogradoIII = 0;
        var sueldogradoIII = 0;

        var puntajegradoIV = 0;
        var conteogradoIV = 0;
        var sueldogradoIV = 0;

        var puntajegradoV = 0;
        var conteogradoV = 0;
        var sueldogradoV = 0;

        var puntajegradoVI = 0;
        var conteogradoVI = 0;
        var sueldogradoVI = 0;

        var puntajegradoVII = 0;
        var conteogradoVII = 0;
        var sueldogradoVII = 0;

        var puntajegradoVIII = 0;
        var conteogradoVIII = 0;
        var sueldogradoVIII = 0;

        var puntajegradoIX = 0;
        var conteogradoIX = 0;
        var sueldogradoIX = 0;

        var puntajegradoX = 0;
        var conteogradoX = 0;
        var sueldogradoX = 0;

        var puntajegradoXI = 0;
        var conteogradoXI = 0;
        var sueldogradoXI = 0;

        var puntajegradoXII = 0;
        var conteogradoXII = 0;
        var sueldogradoXII = 0;

        var puntajegradoXIII = 0;
        var conteogradoXIII = 0;
        var sueldogradoXIII = 0;

        var puntajegradoXIV = 0;
        var conteogradoXIV = 0;
        var sueldogradoXIV = 0;

        var puntajegradoXV = 0;
        var conteogradoXV = 0;
        var sueldogradoXV = 0;

        const sueldosxy = [];
      
        var contador = 1;
        for (var i in data) {

      
            sueldosxy.push({
            x: data[i].sueldonomina,
            y: data[i].puntajenomina,
            nombre: data[i].nombres,
            cargo: data[i].nombrecargo,
        });

            if (contador == 1) {
                puntajegradoI = data[i].puntajegradoI;
                conteogradoI = data[i].conteogradoI;
                sueldogradoI = data[i].sueldogradoI;

                
                puntajegradoII = data[i].puntajegradoII;
                conteogradoII = data[i].conteogradoII;
                sueldogradoII = data[i].sueldogradoII;

                puntajegradoIII = data[i].puntajegradoIII;
                conteogradoIII = data[i].conteogradoIII;
                sueldogradoIII = data[i].sueldogradoIII;

                puntajegradoIV = data[i].puntajegradoIV;
                conteogradoIV = data[i].conteogradoIV;
                sueldogradoIV = data[i].sueldogradoIV;

                puntajegradoV = data[i].puntajegradoV;
                conteogradoV = data[i].conteogradoV;
                sueldogradoV = data[i].sueldogradoV;

                puntajegradoVI = data[i].puntajegradoVI;
                conteogradoVI = data[i].conteogradoVI;
                sueldogradoVI = data[i].sueldogradoVI;

                puntajegradoVII = data[i].puntajegradoVII;
                conteogradoVII = data[i].conteogradoVII;
                sueldogradoVII = data[i].sueldogradoVII;

                puntajegradoVIII = data[i].puntajegradoVIII;
                conteogradoVIII = data[i].conteogradoVIII;
                sueldogradoVIII = data[i].sueldogradoVIII;

                puntajegradoIX = data[i].puntajegradoIX;
                conteogradoIX = data[i].conteogradoIX;
                sueldogradoIX = data[i].sueldogradoIX;

                puntajegradoX = data[i].puntajegradoX;
                conteogradoX = data[i].conteogradoX;
                sueldogradoX = data[i].sueldogradoX;

                puntajegradoXI = data[i].puntajegradoXI;
                conteogradoXI = data[i].conteogradoXI;
                sueldogradoXI = data[i].sueldogradoXI;

                puntajegradoXII = data[i].puntajegradoXII;
                conteogradoXII = data[i].conteogradoXII;
                sueldogradoXII = data[i].sueldogradoXII;

                puntajegradoXIII = data[i].puntajegradoXIII;
                conteogradoXIII = data[i].conteogradoXIII;
                sueldogradoXIII = data[i].sueldogradoXIII;

                puntajegradoXIV = data[i].puntajegradoXIV;
                conteogradoXIV = data[i].conteogradoXIV;
                sueldogradoXIV = data[i].sueldogradoXIV;

                puntajegradoXV = data[i].puntajegradoXV;
                conteogradoXV = data[i].conteogradoXV;
                sueldogradoXV = data[i].sueldogradoXV;
                contador++
            }

     

        }


        var promediopuntajegradoI = 0;
        var promediosueldogradoI = 0;
        const xygradoI = [];

        promediopuntajegradoI = puntajegradoI / conteogradoI;
        promediosueldogradoI = sueldogradoI / conteogradoI;

        xygradoI.push({
            x: promediopuntajegradoI,
            y: promediosueldogradoI
        })


        var promediopuntajegradoII = 0;
        var promediosueldogradoII = 0;
        const xygradoII = [];

        promediopuntajegradoII = puntajegradoII / conteogradoII;
        promediosueldogradoII = sueldogradoII / conteogradoII;

        xygradoII.push({
            x: promediopuntajegradoII,
            y: promediosueldogradoII
        })

        var promediopuntajegradoIII = 0;
        var promediosueldogradoIII = 0;
        const xygradoIII = [];

        promediopuntajegradoIII = puntajegradoIII / conteogradoIII;
        promediosueldogradoIII = sueldogradoIII / conteogradoIII;

        xygradoIII.push({
            x: promediopuntajegradoIII,
            y: promediosueldogradoIII
        })

        var promediopuntajegradoIV = 0;
        var promediosueldogradoIV = 0;
        const xygradoIV = [];

        promediopuntajegradoIV = puntajegradoIV / conteogradoIV;
        promediosueldogradoIV = sueldogradoIV / conteogradoIV;

        xygradoIV.push({
            x: promediopuntajegradoIV,
            y: promediosueldogradoIV
        })

        var promediopuntajegradoV = 0;
        var promediosueldogradoV = 0;
        const xygradoV = [];

        promediopuntajegradoV = puntajegradoV / conteogradoV;
        promediosueldogradoV = sueldogradoV / conteogradoV;

        xygradoV.push({
            x: promediopuntajegradoV,
            y: promediosueldogradoV
        })

        var promediopuntajegradoVI = 0;
        var promediosueldogradoVI = 0;
        const xygradoVI = [];

        promediopuntajegradoVI = puntajegradoVI / conteogradoVI;
        promediosueldogradoVI = sueldogradoVI / conteogradoVI;

        xygradoVI.push({
            x: promediopuntajegradoVI,
            y: promediosueldogradoVI
        })

        var promediopuntajegradoVII = 0;
        var promediosueldogradoVII = 0;
        const xygradoVII = [];

        promediopuntajegradoVII = puntajegradoVII / conteogradoVII;
        promediosueldogradoVII = sueldogradoVII / conteogradoVII;

        xygradoVII.push({
            x: promediopuntajegradoVII,
            y: promediosueldogradoVII
        })

        var promediopuntajegradoVIII = 0;
        var promediosueldogradoVIII = 0;
        const xygradoVIII = [];

        promediopuntajegradoVIII = puntajegradoVIII / conteogradoVIII;
        promediosueldogradoVIII = sueldogradoVIII / conteogradoVIII;

        xygradoVIII.push({
            x: promediopuntajegradoVIII,
            y: promediosueldogradoVIII
        })

        var promediopuntajegradoIX = 0;
        var promediosueldogradoIX = 0;
        const xygradoIX = [];

        promediopuntajegradoIX = puntajegradoIX / conteogradoIX;
        promediosueldogradoIX = sueldogradoIX / conteogradoIX;

        xygradoIX.push({
            x: promediopuntajegradoIX,
            y: promediosueldogradoIX
        })

        var promediopuntajegradoX = 0;
        var promediosueldogradoX = 0;
        const xygradoX = [];

        promediopuntajegradoX = puntajegradoX / conteogradoX;
        promediosueldogradoX = sueldogradoX / conteogradoX;

        xygradoX.push({
            x: promediopuntajegradoX,
            y: promediosueldogradoX
        })

        var promediopuntajegradoXI = 0;
        var promediosueldogradoXI = 0;
        const xygradoXI = [];

        promediopuntajegradoXI = puntajegradoXI / conteogradoXI;
        promediosueldogradoXI = sueldogradoXI / conteogradoXI;

        xygradoXI.push({
            x: promediopuntajegradoXI,
            y: promediosueldogradoXI
        })

        var promediopuntajegradoXII = 0;
        var promediosueldogradoXII = 0;
        const xygradoXII = [];

        promediopuntajegradoXII = puntajegradoXII / conteogradoXII;
        promediosueldogradoXII = sueldogradoXII / conteogradoXII;

        xygradoXII.push({
            x: promediopuntajegradoXII,
            y: promediosueldogradoXII
        })

        var promediopuntajegradoXIII = 0;
        var promediosueldogradoXIII = 0;
        const xygradoXIII = [];

        promediopuntajegradoXIII = puntajegradoXIII / conteogradoXIII;
        promediosueldogradoXIII = sueldogradoXIII / conteogradoXIII;

        xygradoXII.push({
            x: promediopuntajegradoXII,
            y: promediosueldogradoXII
        })

        var promediopuntajegradoXIV = 0;
        var promediosueldogradoXIV = 0;
        const xygradoXIV = [];

        promediopuntajegradoXIV = puntajegradoXIV / conteogradoXIV;
        promediosueldogradoXIV = sueldogradoXIV / conteogradoXIV;

        xygradoXIV.push({
            x: promediopuntajegradoXIV,
            y: promediosueldogradoXIV
        })

        var promediopuntajegradoXV = 0;
        var promediosueldogradoXV = 0;
        const xygradoXV = [];

        promediopuntajegradoXV = puntajegradoXV / conteogradoXV;
        promediosueldogradoXV = sueldogradoXV / conteogradoXV;

        xygradoXV.push({
            x: promediopuntajegradoXV,
            y: promediosueldogradoXV
        });


        grados = [];
        grados.push({
            x: 0,
            y: 0
        });
        grados.push({
            x: promediopuntajegradoI,
            y: promediosueldogradoI
        });
        grados.push({
            x: promediopuntajegradoII,
            y: promediosueldogradoII
        });
        grados.push({
            x: promediopuntajegradoIII,
            y: promediosueldogradoIII
        });
        grados.push({
            x: promediopuntajegradoIV,
            y: promediosueldogradoIV
        });
        grados.push({
            x: promediopuntajegradoV,
            y: promediosueldogradoV
        });
        grados.push({
            x: promediopuntajegradoVI,
            y: promediosueldogradoVI
        });
        grados.push({
            x: promediopuntajegradoVII,
            y: promediosueldogradoVII
        });
        grados.push({
            x: promediopuntajegradoVIII,
            y: promediosueldogradoVIII
        });
        grados.push({
            x: promediopuntajegradoIX,
            y: promediosueldogradoIX
        });
        grados.push({
            x: promediopuntajegradoX,
            y: promediosueldogradoX
        });
        grados.push({
            x: promediopuntajegradoXI,
            y: promediosueldogradoXI
        });
        grados.push({
            x: promediopuntajegradoXII,
            y: promediosueldogradoXII
        });
        grados.push({
            x: promediopuntajegradoXIII,
            y: promediosueldogradoXII
        });
        grados.push({
            x: promediopuntajegradoXIV,
            y: promediosueldogradoXIV
        });
        grados.push({
            x: promediopuntajegradoXV,
            y: promediosueldogradoXV
        });


        console.log(sueldosxy);
        var graphTarget = $("#graphCanvas");


        window.grafica = new Chart(graphTarget, {
            data: {
                datasets: [{
                        label: "Ingreso",
                        data: sueldosxy,
                        borderColor: '#46d5f1',
                        backgroundColor: '#49e2ff',
                        type: 'bubble',
                        pointRadius: 6,
                        pointStyle: 'rectRot',
                        order: 1,
                    },
                    {
                        label: "Recta de Regresión",
                        data: [{x: 0, y:0}, {x:1000,y:maximosueldo}],
                        borderColor: '#44FF16',
                        backgroundColor: '#44FF16',
                        pointRadius: 1,
                        type: 'line',
                        order: 0
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
                    tooltip: {
                        callbacks: {
                            label:((tooltipItem, data) => {
                            var nombre = tooltipItem.raw.nombre
                            var cargo = tooltipItem.raw.cargo
                            var puntos = "Puntaje: " + tooltipItem.raw.x
                            var sueldo = "Sueldo: " + tooltipItem.raw.y
                            return  [nombre, cargo, puntos, sueldo ]
                           })
                        }
                    }
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


}
</script>

<?php 
        /* 

  var barGraph = new Chart(graphTarget, {
                        type: 'line',
                        data: {
                            labels: [0,100,200,300,400,500,600,700,800,900,1000],
                            datasets: [
                                chartdata1,
                                chartdata2,
                                // Aquí más datos...
                            ]
                        },
                    });


                    */