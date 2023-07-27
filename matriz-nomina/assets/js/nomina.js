function eliminar_nomina(id,nombretrabajador) {
  Swal.fire({
      title: '¿Seguro que desea eliminar el Trabajador: ' + nombretrabajador + '?',
      text: "Esta acción no se puede revertir",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Eliminar!'
  }).then((result) => {
      if (result.isConfirmed) {
          Swal.fire(
              'Eliminado!',
              'El Trabajador ha sido eliminado',
              'success'
          )
          window.location.href = 'save?deleteid=' + id
      }
  })
}

function crear_nomina(fecha_act) {
    Swal.fire({
        title: "Registro de Información",
        width: '700px',
            html: `  <form id='create' action="save.php" method='post'>

            <div class="row">
                <div class="col-md-12" style="text-align: center !important;">

                <span style="font-size: 14px">Datos del Cargo/Trabajador</span>
                </div>
                <div class="col-md-12" style="text-align: left !important;">
             
                <span style="font-weight: bold; "font-size: 15px;">IMPORTANTE</span>
                <br>
                <span style="font-size: 14px">Antes de introducir información de los puestos/cargos en la matriz, es necesario que seleccione 
                a que segmento corresponde. (una de las dos opciones).</span>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input radio-inline" type="radio" name="radio_categoria[]"
                                                id="radio_categoria" value="1" onchange="get_departamentos(this.value)"> <a
                                         data-toggle="collapse" href="#" role="button"
                                         aria-expanded="false" data-toggle="tooltip" data-html="true" title="" onclick="show_info_cargos_adm()">
                                         <span style="font-size: 15px;"> Cargos Administrativos </span></a>  
                        </div>
                    </div>
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input radio-inline" type="radio" name="radio_categoria[]" 
                        id="radio_categoria" value="2" onchange="get_departamentos(this.value)"> <a
                                         data-toggle="collapse" href="#" role="button"
                                         aria-expanded="false" data-toggle="tooltip" data-html="true"  aria-controls="collapsePlanta"
                                         title="Mostrar descripción" onclick="show_info_cargos_planta()">
                                         <span style="font-size: 15px;"> Cargos Planta - Taller - Obrero </span></a>   
                                        </div>
                                    </div>
                                </div>

            <input class="hidden" id="cargos_adm_info" name="cargos_adm_info" value="0">
            <input class="hidden" id="cargos_planta_info" name="cargos_planta_info" value="0">
            <input class="hidden" id="cargo_puesto" name="cargo_puesto" value="0">
        

            <div class="hidden" id="info_cargos_adm">
                <div class="card card-body" style="text-align: left; font-size: 14px">
                    <p>
                        <em><strong>Cargos Administrativos - Gerenciales</strong></em><br> 
                        Ejemplos: Secretarias, Auxiliares, Asistentes, Analistas, Almacenistas, Supervisores, Jefes, Gerentes, Directores, Vicepresidentes y Administrativos de Planta, Industria o Taller.
                    </p>
                </div>
            </div>
            <div class="hidden" id="info_cargos_planta">
                <div class="card card-body" style="text-align: left; font-size: 14px">
                    <p class="text">
                        <em><strong>Cargos Operativos-Técnicos, Talleres ó Plantas
                                    Industriales</em></strong><br> 
                                    Ejemplos: Mecánicos,
                        Torneros, Fresadores, Operarios de producción, Soldadores,
                        Electricistas, Montacarguistas, Operadores, etc...
                    </p>
                    <p class="text">
                        <em><strong>No incluye supervisores o cualquier otra actividad
                                    administrativa aunque laboren en planta, industria o
                                    taller.</em></strong>
                    </p>
                </div>
            </div>
            <div class="hidden" id="info_cargo_puesto">
                <div class="card card-body" style="text-align: left; font-size: 14px">
                    <p>
                    <em><strong>Puesto/Cargo:</strong></em><br> 
                        Un <strong>Cargo</strong> es un conjunto de funciones, tareas y operaciones específicas representativas, relacionadas con la actividad laboral, cuyo ejercicio conlleva responsabilidades, conocimientos y habilidades para su desempeño.<br><br>
                        Un <strong>Puesto</strong>  Se refiere a la ubicación física de un determinado Cargo dentro de la jerarquía y dentro del espacio físico donde se desempeña la persona. Con el avance de la tecnología, los puestos de trabajo no tienen en muchos casos, espacio físico, el trabajo es realizado en forma virtual, en cualquier espacio físico, a cualquier hora y en cualquier lugar o ciudad. En la práctica, hemos observado que empresas privadas consideran el Puesto como sinónimo de Cargo, aunque técnicamente no es lo mismo.
                    </p>
                </div>
            </div>
                                
            <br>
                      <div class="row">
                          <div class="col-md-12">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="id_departamento">Departamento:</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-select" aria-label=".form-select-lg example" id="id_departamento" name="id_departamento"  onchange="get_cargos(this.value)">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="id_cargo" onclick="show_info_cargo_puesto()" style="color: #007bff;">Puesto/Cargo:</label>
                                </div>
                                <div class="col-md-8">
                                <select class="form-select" id="id_cargo" name="id_cargo" onchange="get_datos(this.value)">
                                            
                                            </select>
                                </div>
                            </div>
                        </div>
                          
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="funcion_cargo">Funciones del Cargo:</label>
                                </div>
                                <div class="col-md-8">
                                    <textarea class="form-control" name="funcion_cargo" id="funcion_cargo" readonly rows="3"></textarea>
                                </div>
                            </div>
                        </div> 
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                         <div class="col-md-6" style="text-align: right !important;">
                                            <label for="puntaje">Puntaje:</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type='text' name="puntaje" id="puntaje" class='form-control' readonly required autocomplete="on">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="grado">Grado:</label>
                                        </div>
                                        <div class="col-md-6">
                                        <input type='text' name="grado" id="grado" class='form-control' readonly required autocomplete="on">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                            
                  
                    
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <input type="checkbox" name="cargocritico" id="cargocritico">
                                </div>
                                <div class="col-md-4" style="text-align: left !important;">
                                    <a
                                         data-toggle="collapse" href="#" role="button"
                                         aria-expanded="false" data-toggle="tooltip" data-html="true" title="" onclick="show_info_cargo_critico()">
                                         <span style="font-size: 15px;">¿ Es Cargo Crítico ? </span></a>
                                </div>
                            </div>
                        </div> 

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <input type="checkbox" name="cargosupervisor" id="cargosupervisor">
                                </div>
                                <div class="col-md-8" style="text-align: left !important;">
                                    <a data-toggle="collapse" href="#" role="button"
                                            aria-expanded="false" data-toggle="tooltip" data-html="true" title="" onclick="show_info_cargo_supervisor()">
                                            <span style="font-size: 15px;">¿ Marque si la posición dirige ó tiene personal su Cargo ?</span></a>
                                    
                                </div>
                            </div>
                        </div> 


                        <input class="hidden" id="cargo_critico_info" name="cargo_critico_info" value="0">

                        <input class="hidden" id="cargo_supervisor_info" name="cargo_supervisor_info" value="0">

                        <div class="hidden" id="info_cargo_critico">
                        <div class="card card-body" style="text-align: left; font-size: 14px">
                            <p>
                                <em><strong>Cargo Critico:</strong></em><br> 
                                Lo podemos definir como aquellas funciones, actividades y tareas de un cargo, asociados al
                                proceso productivo que se considera IMPRESCINDIBLE en la operación y
                                cuyo ocupante ES ESCASO EN EL MERCADO, genera un alto costo. Los Cargos
                                críticos no deben exceder el 10% del total de cargos.
                            </p>
                        </div>
                    </div>
        
                        <div class="hidden" id="info_cargo_supervisor">
                            <div class="card card-body" style="text-align: left; font-size: 14px">
                                <p>
                                    <em><strong>Cargo Supervisor:</strong></em><br> 
                                    Cualquier persona que tenga el poder y la autoridad sobre uno o más trabajadores para
                                    realizar tareas y actividades de producción, es responsable de la
                                    productividad de sus subalternos. Según el nivel, la denominación del
                                    cargo varía como: Capataz, Jefe, Supervisor, Gerente, Coordinador o
                                    Encargado de una unidad, departamento o gerencia de nivel medio o alto.
                                </p>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="modelo_trabajo">Modalidad de Trabajo:</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-select" aria-label=".form-select-lg example" id="modelo_trabajo" name="modelo_trabajo" onchange="porcentajes(this.value)">
                                    <option value="0" > Seleccione... </option>;
                                    <option value="R" > Remoto (Home Office)</option>;
                                    <option value="P" > Presencial </option>;
                                    <option value="M" > Mixto </option>;
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="hidden" id="porcentajes">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6" style="text-align: right !important;">
                                            <label for="porcentaje_presencial">% Presencial:</label>
                                            </div>
                                            <div class="col-md-4">
                                            <input type='number' min="0" max="100"' name="porcentaje_presencial" id="porcentaje_presencial" class='form-control' onchange="validarmodalidad()" required autocomplete="on">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                            <label for="porcentaje_remoto">% Remoto:</label>
                                            </div>
                                            <div class="col-md-6">
                                            <input type='number' min="0" max="100" name="porcentaje_remoto" id="porcentaje_remoto" class='form-control' readonly  required autocomplete="on">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div> 


                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="nombre">Nombre del Trabajador:</label>
                                </div>
                                <div class="col-md-8">
                                    <input type='text' name='nombre' class='form-control' required autocomplete="on">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="documento">Número de Identidad</label>
                                </div>
                                <div class="col-md-8">
                                    <input type='text' name='documento' id='documento' onkeyup="validardocumento()" class='form-control' required autocomplete="on">
                                </div>
                            </div>
                        </div>

                        <div id="error" style="display: none; color: red;"><br><br></div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="genero">Genero:</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-select" aria-label=".form-select-lg example" id="genero" name="genero">
                                    <option value="0" > Seleccione... </option>;
                                    <option value="F" > Femenino </option>;
                                    <option value="M" > Masculino </option>;
                                    </select>
                                </div>
                            </div>
                        </div>
                             
                       

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                         <div class="col-md-6" style="text-align: right !important;">
                                            <label for="fecha_ingreso">Fecha de Ingreso</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type='date' onchange="calculartiemposervicio(this.value);" name="fecha_ingreso" id="fecha_ingreso" class='form-control'  required autocomplete="on">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type='text' readonly name="fecha_act" id="fecha_act" value="` + fecha_act + `" class='form-control' readonly required autocomplete="on">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="anos_servicio">Años en Servicio</label>
                                </div>
                                <div class="col-md-8">
                                    <input type='text' readonly name="anos_servicio" id="anos_servicio" class='form-control' required autocomplete="on">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="sueldo_base_mensual">Sueldo Base Mensual:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type='number'  name='sueldo_base_mensual' id='sueldo_base_mensual' class='form-control' required autocomplete="on">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="total_ingreso_mensual">Total Ingreso Mensual:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type='number'  name='total_ingreso_mensual' id='total_ingreso_mensual' onchange="calcularfactor()" class='form-control' required autocomplete="on">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="total_paquete_anual">Total Paquete Anual:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type='number' name='total_paquete_anual' id='total_paquete_anual' onchange="calcularfactor()" class='form-control' required autocomplete="on">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="factor_meses">Factor/Meses:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type='text' readonly name="factor_meses" id="factor_meses" class='form-control' required autocomplete="on">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">                      
                                    <a data-toggle="collapse" href="#collapseDivisa" role="button"
                                            aria-expanded="false" aria-controls="collapseDivisa"
                                            title="Mostrar descripción">
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" data-html="true" title="" onclick="show_info_divisas()"> <span style="font-size: 15px;">Asignación en Divisas:   </span></span></a>
                                </div>
                                <div class="col-md-8" style="text-align: left !important;">
                                <input type="checkbox" id="pagoDivisas" name="pagoDivisas"
                                            value="1" >

                                </div>
                            </div>
                        </div>
                        
                        <input class="hidden" id="divisas_info" name="divisas_info" value="0">
        
                        <div class="hidden" id="info_divisas">
                            <div class="card card-body" style="text-align: left; font-size: 14px">
                                <p>
                                    <em><strong>Asignación en divisas:</strong></em><br> 
                                    Nos referimos al PAGO ADICIONAL que se realiza a ciertos trabajadores en moneda extranjera.
                                </p>
                            </div>
                        </div>

                        <div class="hidden" id="divisa">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                    <div class="col-md-4">
                                            <label for="grado">Divisa:</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="id_tipodivisa" id="id_tipodivisa" onchange="validardivisa(this.value)"
                                                title="Seleccione tipo de divisas">
                                                <option value="0" selected disabled> ..... </option>
                                                <option value="233">Dolares</option>
                                                <option value="68">Euros</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                    <div class="col-md-8" style="text-align: right !important;">
                                    <label for="monto_divisas">Monto en Divisas:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type='number' name="montodivisa" id="montodivisa" class='form-control' readonly  required autocomplete="on">
                                </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                          
                       
                       

                           
  
                          </div>
                          <br>
                          <div class="col-md-12">
                             
                              <button type="submit" class="btn btn-dark" name="add" id='add'>
                                  Guardar
                              </button>
                              <br></br>
                          </div>
                      </div>
  
                     
  
                  </form>`,
    showConfirmButton: false,
    })
       

    $(document).ready(function() {
    $(".hidden").hide();

    $( '#pagoDivisas' ).on( 'click', function() {
    if( $(this).is(':checked') ){
        $("#divisa").show("fast");
    } else {
        $("#divisa").hide("fast");
        $("#montodivisa").val("");
        $("#montodivisa").attr("readonly","readonly");
        $("#id_tipodivisa").val(0);
    }
});
});


 

    };



    function editar_nomina(id_nomina,
                                categoriadepartamento,
                                iddepartamento,
                                nombredepartamento,
                                idcargo,
                                nombrecargo,
                                funcioncargo,
                                mnpuntaje,
                                idgrado,
                                critico,
                                supervisor,
                                modelo_trabajo,
                                porcentaje_remoto,
                                porcentaje_presencial,
                                nombretrabajador,
                                mndocumento,
                                mngenero,
                                fechaingreso,
                                tiempoTranscurrido,
                                sueldobase,
                                sueldo_mensual,
                                paquete_anual,
                                factormeses,
                                monto_divisa,
                                idtipodivisa,
                                fecha_act) {
    Swal.fire({
        title: "Registro de Información",
        width: '700px',
            html: `  <form id='create' action="save.php" method='post'>

            <div class="row">
                <div class="col-md-12" style="text-align: center !important;">
                <span style="font-size: 14px">Datos del Cargo/Trabajador</span>
                </div>
                <div class="col-md-12" style="text-align: left !important;">
                
                <span style="font-weight: bold; "font-size: 15px;">IMPORTANTE</span>
                <br>
                <span style="font-size: 14px">Antes de introducir información de los puestos/cargos en la matriz, es necesario que seleccione 
                a que segmento corresponde. (una de las dos opciones).</span>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input radio-inline" type="radio" name="radio_categoria[]"
                                                id="radio_categoria" value="1"  ${categoriadepartamento === "1" ? "checked" : ""} onchange="get_departamentos(this.value)"> <a
                                         data-toggle="collapse" href="#" role="button"
                                         aria-expanded="false" data-toggle="tooltip" data-html="true" title="" onclick="show_info_cargos_adm()">
                                         <span style="font-size: 15px;"> Cargos Administrativos </span></a>  
                        </div>
                    </div>
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input radio-inline" type="radio" name="radio_categoria[]" 
                        id="radio_categoria" ${categoriadepartamento === "2" ? "checked" : ""} value="2" onchange="get_departamentos(this.value)"> <a
                                         data-toggle="collapse" href="#" role="button"
                                         aria-expanded="false" data-toggle="tooltip" data-html="true" title="" onclick="show_info_cargos_planta()">
                                         <span style="font-size: 15px;"> Cargos Planta - Taller - Obrero </span></a>   
                    </div>
                </div>
            </div>

          
            <input class="hidden" id="cargos_adm_info" name="cargos_adm_info" value="0">
            <input class="hidden" id="cargos_planta_info" name="cargos_planta_info" value="0">
            <input class="hidden" id="cargo_puesto" name="cargo_puesto" value="0">

            <div class="hidden" id="info_cargos_adm">
                <div class="card card-body" style="text-align: left; font-size: 14px">
                    <p>
                        <em><strong>Cargos Administrativos - Gerenciales</strong></em><br> 
                        Ejemplos: Secretarias, Auxiliares, Asistentes, Analistas, Almacenistas, Supervisores, Jefes, Gerentes, Directores, Vicepresidentes y Administrativos de Planta, Industria o Taller.
                    </p>
                </div>
            </div>
            <div class="hidden" id="info_cargos_planta">
                <div class="card card-body" style="text-align: left; font-size: 14px">
                    <p class="text">
                        <em><strong>Cargos Operativos-Técnicos, Talleres ó Plantas
                                    Industriales</em></strong><br> 
                                    Ejemplos: Mecánicos,
                        Torneros, Fresadores, Operarios de producción, Soldadores,
                        Electricistas, Montacarguistas, Operadores, etc...
                    </p>
                    <p class="text">
                        <em><strong>No incluye supervisores o cualquier otra actividad
                                    administrativa aunque laboren en planta, industria o
                                    taller.</em></strong>
                    </p>
                </div>
            </div>
            <div class="hidden" id="info_cargo_puesto">
                <div class="card card-body" style="text-align: left; font-size: 14px">
                    <p>
                    <em><strong>Puesto/Cargo:</strong></em><br> 
                        Un <strong>Cargo</strong> es un conjunto de funciones, tareas y operaciones específicas representativas, relacionadas con la actividad laboral, cuyo ejercicio conlleva responsabilidades, conocimientos y habilidades para su desempeño.<br><br>
                        Un <strong>Puesto</strong>  Se refiere a la ubicación física de un determinado Cargo dentro de la jerarquía y dentro del espacio físico donde se desempeña la persona. Con el avance de la tecnología, los puestos de trabajo no tienen en muchos casos, espacio físico, el trabajo es realizado en forma virtual, en cualquier espacio físico, a cualquier hora y en cualquier lugar o ciudad. En la práctica, hemos observado que empresas privadas consideran el Puesto como sinónimo de Cargo, aunque técnicamente no es lo mismo.
                    </p>
                </div>
            </div>

            <br>
                      <div class="row">
                          <div class="col-md-12">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="id_departamento">Departamento:</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-select" aria-label=".form-select-lg example" id="id_departamento" name="id_departamento"  onchange="get_cargos(this.value)">
                                    
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="id_cargo" onclick="show_info_cargo_puesto()" style="color: #007bff;">Puesto/Cargo</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-select"
                                                aria-label=".form-select-lg example" id="id_cargo" name="id_cargo" onchange="get_datos(this.value)">
                                                <option value="` + idcargo + `" selected> ` + nombrecargo + `</option>;
                                                
                                            </select>
                                </div>
                            </div>
                        </div>
            
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="funcion_cargo">Funciones del Cargo:</label>
                                </div>
                                <div class="col-md-8">
                                    <textarea class="form-control" name="funcion_cargo" id="funcion_cargo" readonly rows="3">` + funcioncargo + `</textarea>
                                </div>
                            </div>
                        </div> 
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                         <div class="col-md-6" style="text-align: right !important;">
                                            <label for="puntaje">Puntaje:</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type='text' name="puntaje" id="puntaje" value="` + mnpuntaje + `" class='form-control' readonly required autocomplete="on">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="grado">Grado:</label>
                                        </div>
                                        <div class="col-md-6">
                                        <input type='text' name="grado" id="grado" value="` + idgrado + `" class='form-control' readonly required autocomplete="on">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                            
                  
                    
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <input type="checkbox" name="cargocritico" id="cargocritico"  ${critico === "1" ? "checked" : ""}>
                                </div>
                                <div class="col-md-4" style="text-align: left !important;">
                                    <a
                                         data-toggle="collapse" href="#" role="button"
                                         aria-expanded="false" data-toggle="tooltip" data-html="true" title="" onclick="show_info_cargo_critico()">
                                         <span style="font-size: 15px;">¿ Es Cargo Crítico ? </span></a>
                                </div>
                            </div>
                        </div> 
                    
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <input type="checkbox" name="cargosupervisor" id="cargosupervisor" ${supervisor === "1" ? "checked" : ""}>
                                </div>
                                <div class="col-md-8" style="text-align: left !important;">
                                    <a data-toggle="collapse" href="#" role="button"
                                            aria-expanded="false" data-toggle="tooltip" data-html="true" title="" onclick="show_info_cargo_supervisor()">
                                            <span style="font-size: 15px;">¿ Marque si la posición dirige ó tiene personal su Cargo ?</span></a>
                                    
                                </div>
                            </div>
                        </div> 

                        <input class="hidden" id="cargo_critico_info" name="cargo_critico_info" value="0">

                        <input class="hidden" id="cargo_supervisor_info" name="cargo_supervisor_info" value="0">

                        <div class="hidden" id="info_cargo_critico">
                            <div class="card card-body" style="text-align: left; font-size: 14px">
                                <p>
                                    <em><strong>Cargo Critico:</strong></em><br> 
                                    Lo podemos definir como aquellas funciones, actividades y tareas de un cargo, asociados al
                                    proceso productivo que se considera IMPRESCINDIBLE en la operación y
                                    cuyo ocupante ES ESCASO EN EL MERCADO, genera un alto costo. Los Cargos
                                    críticos no deben exceder el 10% del total de cargos.
                                </p>
                            </div>
                        </div>
        
                        <div class="hidden" id="info_cargo_supervisor">
                            <div class="card card-body" style="text-align: left; font-size: 14px">
                                <p>
                                    <em><strong>Cargo Supervisor:</strong></em><br> 
                                    Cualquier persona que tenga el poder y la autoridad sobre uno o más trabajadores para
                                    realizar tareas y actividades de producción, es responsable de la
                                    productividad de sus subalternos. Según el nivel, la denominación del
                                    cargo varía como: Capataz, Jefe, Supervisor, Gerente, Coordinador o
                                    Encargado de una unidad, departamento o gerencia de nivel medio o alto.
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                        <div class="row">
                            <div class="col-md-4" style="text-align: right !important;">
                                <label for="modelo_trabajo">Modalidad de Trabajo:</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" aria-label=".form-select-lg example" id="modelo_trabajo" name="modelo_trabajo" onchange="porcentajes(this.value)">
                                <option value="0" > Seleccione... </option>;
                                <option value="R" ${modelo_trabajo === "R" ? "selected" : ""}> Remoto (Home Office)</option>;
                                <option value="P" ${modelo_trabajo === "P" ? "selected" : ""}> Presencial </option>;
                                <option value="M" ${modelo_trabajo === "M" ? "selected" : ""}> Mixto </option>;
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="hidden" id="porcentajes">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6" style="text-align: right !important;">
                                        <label for="porcentaje_presencial">% Presencial:</label>
                                        </div>
                                        <div class="col-md-4">
                                        <input type='number' min="0" max="100"' value="` + porcentaje_presencial + `" name="porcentaje_presencial" id="porcentaje_presencial" class='form-control' onchange="validarmodalidad()"  required autocomplete="on">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                        <label for="porcentaje_remoto">% Remoto:</label>
                                        </div>
                                        <div class="col-md-6">
                                        <input type='number' min="0" max="100" value="` + porcentaje_remoto + `" name="porcentaje_remoto" id="porcentaje_remoto" class='form-control' readonly required autocomplete="on">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div> 


                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="nombre">Nombre del Trabajador:</label>
                                </div>
                                <div class="col-md-8">
                                    <input type='text' name='nombre' value="` + nombretrabajador + `" class='form-control' required autocomplete="on">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="documento">Número de Identidad</label>
                                </div>
                                <div class="col-md-8">
                                    <input type='text' name='documento' id='documento' onkeyup="validardocumentoeditar()" value="` + mndocumento + `" class='form-control' required autocomplete="on">
                                </div>
                            </div>
                        </div>

                        <div id="error" style="display: none; color: red;"><br><br></div>

                        <input type='hidden' name='documentoold' id='documentoold' value="` + mndocumento + `" class='form-control' required autocomplete="on">

                                  
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="genero">Genero:</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-select" aria-label=".form-select-lg example" id="genero" name="genero">
                                    <option value="F" ${mngenero === "F" ? "selected" : ""}> Femenino </option>;
                                    <option value="M" ${mngenero === "M" ? "selected" : ""}> Masculino </option>;
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                         <div class="col-md-6" style="text-align: right !important;">
                                            <label for="fecha_ingreso">Fecha de Ingreso</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type='date' value="` + fechaingreso + `" onchange="calculartiemposervicio(this.value);" name="fecha_ingreso" id="fecha_ingreso" class='form-control'  required autocomplete="on">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type='text' readonly name="fecha_act" id="fecha_act" value="` + fecha_act + `" class='form-control' readonly required autocomplete="on">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="anos_servicio">Años en Servicio</label>
                                </div>
                                <div class="col-md-8">
                                    <input type='text' readonly name="anos_servicio" value="` + tiempoTranscurrido + `" id="anos_servicio" class='form-control' required autocomplete="on">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="sueldo_base_mensual">Sueldo Base Mensual:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type='number' name='sueldo_base_mensual' id='sueldo_base_mensual' value="` + sueldobase + `" class='form-control' required autocomplete="on">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="total_ingreso_mensual">Total Ingreso Mensual:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type='number'  name='total_ingreso_mensual' id='total_ingreso_mensual' value="` + sueldo_mensual + `" onchange="calcularfactor()" class='form-control' required autocomplete="on">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="total_paquete_anual">Total Paquete Anual:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type='number' name='total_paquete_anual' id='total_paquete_anual' value="` + paquete_anual + `" onchange="calcularfactor()" class='form-control' required autocomplete="on">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">
                                    <label for="factor_meses">Factor/Meses:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type='text' readonly name="factor_meses" id="factor_meses" value="` + factormeses + `" class='form-control' required autocomplete="on">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right !important;">                      
                                    <a data-toggle="collapse" href="#collapseDivisa" role="button"
                                            aria-expanded="false" aria-controls="collapseDivisa"
                                            title="Mostrar descripción">
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" data-html="true" title="" onclick="show_info_divisas()"> <span style="font-size: 15px;">Asignación en Divisas:   </span></span></a>
                                </div>
                                <div class="col-md-8" style="text-align: left !important;">
                                <input type="checkbox" id="pagoDivisas" name="pagoDivisas"
                                            value="1" ${monto_divisa !== "0.00" ? "checked" : ""} >

                                </div>
                            </div>
                        </div>
                        
                        <input class="hidden" id="divisas_info" name="divisas_info" value="0">
        
                        <div class="hidden" id="info_divisas">
                            <div class="card card-body" style="text-align: left; font-size: 14px">
                                <p>
                                    <em><strong>Asignación en divisas:</strong></em><br> 
                                    Nos referimos al PAGO ADICIONAL que se realiza a ciertos trabajadores en moneda extranjera.
                                </p>
                            </div>
                        </div>

                        <div class="hidden" id="divisa">


                        <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                <div class="col-md-4">
                                        <label for="grado">Divisa:</label>
                                    </div>
                                    <div class="col-md-6">
                                    <select class="form-control" name="id_tipodivisa" id="id_tipodivisa" onchange="validardivisa(this.value)"
                                        title="Seleccione tipo de divisas">
                                        <option value="0" disabled ${idtipodivisa === "0" ? "selected" : ""}> ..... </option>
                                        <option value="233" ${idtipodivisa === "233" ? "selected" : ""}>Dolares</option>
                                        <option value="68" ${idtipodivisa === "68" ? "selected" : ""}>Euros</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                <div class="col-md-8" style="text-align: right !important;">
                                <label for="monto_divisas">Monto en Divisas:</label>
                            </div>
                            <div class="col-md-4">
                                <input type='number' name="montodivisa" id="montodivisa" value="` + monto_divisa + `" class='form-control'  readonly autocomplete="on">
                            </div>
                                </div>
                            </div>
                        </div>
                    </div> 


                        
                          
                       

                        <input type='hidden' name="id_nomina" id="id_nomina" value="` + id_nomina + `" class='form-control' readonly required autocomplete="on">
  
                          </div>
                          <br>
                          <div class="col-md-12">
                             
                              <button type="submit" class="btn btn-dark" name="update" id='update'>
                                  Guardar
                              </button>
                              <br></br>
                          </div>
                      </div>
  
                     
  
                  </form>`,
    showConfirmButton: false,
    })


    
    window.onload = get_departamentos_edit(categoriadepartamento,iddepartamento),get_cargos_edit(iddepartamento,idcargo)
 

    $(document).ready(function() {
    if(monto_divisa == 0)
    {
        $("#divisa").hide();
    }
    else
    {
        $("#divisa").show("fast");
    }

    if(modelo_trabajo == "M")
    {
        $("#porcentajes").show("fast");
    }
    else
    {
        $("#porcentajes").hide();
       
    }

    $("#cargos_adm_info").hide();
    $("#cargos_planta_info").hide();
    $("#info_cargos_adm").hide();
    $("#info_cargos_planta").hide();
    $("#cargo_puesto").hide();
    $("#info_cargo_puesto").hide();

    $("#cargo_critico_info").hide();
    $("#cargo_supervisor_info").hide();
    $("#info_cargo_critico").hide();
    $("#info_cargo_supervisor").hide();

    $("#divisas_info").hide();
    $("#info_divisas").hide();

    $( '#pagoDivisas' ).on( 'click', function() {
    if( $(this).is(':checked') ){
        $("#divisa").show("fast");
    } else {
        $("#divisa").hide("fast");
        $("#montodivisa").val("");
        $("#montodivisa").attr("readonly","readonly");
        $("#id_tipodivisa").val(0);   
        
    }
});



});


    };

    function show_info_cargos_adm() 
    {
        cargos_adm_info = document.getElementById("cargos_adm_info").value;
        cargos_planta_info = document.getElementById("cargos_planta_info").value;
        cargo_puesto = document.getElementById("cargo_puesto").value;

        if(cargos_adm_info == 0)
        {
            $("#info_cargos_adm").show("fast");
            $("#info_cargos_planta").hide();
            $("#info_cargo_puesto").hide();
            document.getElementById("cargos_adm_info").value = 1;
            document.getElementById("cargos_planta_info").value = 0;
            document.getElementById("cargo_puesto").value = 0;
        }
        if(cargos_adm_info == 1)
        {
            $("#info_cargos_adm").hide();
            document.getElementById("cargos_adm_info").value = 0;
        }
             
    }

    function show_info_cargos_planta() 
    {
        cargos_adm_info = document.getElementById("cargos_adm_info").value;
        cargos_planta_info = document.getElementById("cargos_planta_info").value;

        
        if(cargos_planta_info == 0)
        {
            $("#info_cargos_planta").show("fast");
            $("#info_cargos_adm").hide();
            $("#info_cargo_puesto").hide();
            document.getElementById("cargos_planta_info").value = 1;
            document.getElementById("cargos_adm_info").value = 0;
            document.getElementById("cargo_puesto").value = 0;
        }
        if(cargos_planta_info == 1)
        {
            $("#info_cargos_planta").hide();
            document.getElementById("cargos_planta_info").value = 0;
        }
       
    }

    function validarmodalidad()
    {
        var porcentaje_presencial = document.getElementById("porcentaje_presencial").value;
        if (document.getElementById("porcentaje_presencial").value > 100)
        {
            document.getElementById("porcentaje_presencial").value = 100;
        }


        if (porcentaje_presencial.charAt(0) == "0")
        {
            document.getElementById("porcentaje_presencial").value = 0;
        }

        document.getElementById("porcentaje_remoto").value = 100 - document.getElementById("porcentaje_presencial").value;
    }


    function show_info_cargo_puesto() 
    {
        cargo_puesto = document.getElementById("cargo_puesto").value;
        
        if(cargo_puesto == 0)
        {
            $("#info_cargo_puesto").show("fast");
            $("#info_cargos_adm").hide();
            $("#info_cargos_planta").hide();
            document.getElementById("cargos_planta_info").value = 0;
            document.getElementById("cargos_adm_info").value = 0;
            document.getElementById("cargo_puesto").value = 1;
        }
        if(cargo_puesto == 1)
        {
            $("#info_cargo_puesto").hide();
            document.getElementById("cargo_puesto").value = 0;
        }
       
    }


    function show_info_cargo_critico() 
    {
        cargo_critico_info = document.getElementById("cargo_critico_info").value;
        cargo_supervisor_info = document.getElementById("cargo_supervisor_info").value;

        if(cargo_critico_info == 0)
        {
            $("#info_cargo_critico").show("fast");
            $("#info_cargo_supervisor").hide();
            document.getElementById("cargo_critico_info").value = 1;
            document.getElementById("cargo_supervisor_info").value = 0;
        }
        if(cargo_critico_info == 1)
        {
            $("#info_cargo_critico").hide();
            document.getElementById("cargo_critico_info").value = 0;
        }
             
    }

    function show_info_cargo_supervisor() 
    {
        cargo_critico_info = document.getElementById("cargo_critico_info").value;
        cargo_supervisor_info = document.getElementById("cargo_supervisor_info").value;

        if(cargo_supervisor_info == 0)
        {
            $("#info_cargo_supervisor").show("fast");
            $("#info_cargo_critico").hide();
            document.getElementById("cargo_supervisor_info").value = 1;
            document.getElementById("cargo_critico_info").value = 0;
        }
        if(cargo_supervisor_info == 1)
        {
            $("#info_cargo_supervisor").hide();
            document.getElementById("cargo_supervisor_info").value = 0;
        }
       
    }

    function show_info_divisas() 
    {
        divisas_info = document.getElementById("divisas_info").value;
        
        if(divisas_info == 0)
        {
            $("#info_divisas").show("fast");
            document.getElementById("divisas_info").value = 1;
        }
        if(divisas_info == 1)
        {
            $("#info_divisas").hide();
            document.getElementById("divisas_info").value = 0;
        }
       
    }

    function info_tabla(title,info) 
    {
        Swal.fire({
            title: title,
            width: '500px',
                html: `         <div class="card card-body" style="text-align: left; font-size: 20px">
                                    <p>
                                    ` + info.replace(/;/g, '<br>') + `
                                    </p>
                                </div>
                            `,
        showConfirmButton: true,
        })
       
    }
    
    function validardivisa(tipo_divisa)
    {
        if(tipo_divisa != 0)
        {
            $("#montodivisa").removeAttr("readonly");
        }

    }

    function get_departamentos(id_categoria) 
    {
        $.post("data.php?iddepa", {
            id_categoria: id_categoria
        }, function(data) {
            $("#id_departamento").html(data)
             // search
           dselect(document.querySelector('#id_departamento'), {
            search: true
          })
        })
          
    }

    function get_departamentos_edit(id_categoria,iddepartamento) 
    {
        $.post("data.php?iddepaedit", {
            categoria: id_categoria,
            id_dp: iddepartamento,
        }, function(data) {
            $("#id_departamento").html(data)
             // search
           dselect(document.querySelector('#id_departamento'), {
            search: true
          })
        })
          
    }

    function get_cargos(id_departamento) 
    {
        $.post("data.php?idcargo", {
            id_departamento: id_departamento
        }, function(data) {
            $("#id_cargo").html(data)
                // search
           dselect(document.querySelector('#id_cargo'), {
            search: true
          })
        })
    }

    function get_cargos_edit(id_departamento,idcargo) 
    {
        $.post("data.php?idcargoedit", {
            id_departamento: id_departamento,
            idcargo: idcargo
        }, function(data) {
            $("#id_cargo").html(data)
                // search
           dselect(document.querySelector('#id_cargo'), {
            search: true
          })
        })
    }

    function get_datos(id_cargo) 
    {
        $.post("data.php?grado", {
            id_cargo: id_cargo
        }, function(data) {
           
            $("#grado").val(data.dato1);
            $("#funcion_cargo").html(data.dato2);
            $("#puntaje").val(data.dato3);
        });
       
    }

    function porcentajes(modelo_trabajo) 
    {
        if(modelo_trabajo == "R")
        {
            document.getElementById("porcentaje_remoto").value = 100;
            document.getElementById("porcentaje_presencial").value = 0;
            $("#porcentajes").hide();
        }
        if(modelo_trabajo == "P")
        {
            document.getElementById("porcentaje_remoto").value = 0;
            document.getElementById("porcentaje_presencial").value = 100;
            $("#porcentajes").hide();   
        }

        if(modelo_trabajo == "M")
        {
            document.getElementById("porcentaje_remoto").value = 50;
            document.getElementById("porcentaje_presencial").value = 50;
            $("#porcentajes").show("fast");
        }
          
    }

    function calculartiemposervicio(fecha_ingreso)
    {
     // Crear un objeto Date con la fecha y hora actual
const fechaActual = new Date();

// Obtener los componentes de la fecha
const dia = fechaActual.getDate().toString().padStart(2, '0');
const mes = (fechaActual.getMonth() + 1).toString().padStart(2, '0');
const anio = fechaActual.getFullYear();

// Crear una cadena de texto con la fecha actual en el formato deseado
const fechaActualFormato = `${anio}-${mes}-${dia}`;

        if (fecha_ingreso > fechaActualFormato)
        {
            document.getElementById("fecha_ingreso").value = fechaActualFormato;
            fecha_ingreso = fechaActualFormato;
        }

        $.post("data.php?fecin", {
            fecha_ingreso: fecha_ingreso
        }, function(data) {
           
            $("#anos_servicio").val(data.dato);
           
        });
    }

    function calcularfactor()
    {
        let txtIngresoM = $("#total_ingreso_mensual").val();
        let txtPaqueteA = $("#total_paquete_anual").val();
        let sldm = txtIngresoM.replace(".", "")
        sldm = sldm.replace(",", ".")
      
        let pqta = txtPaqueteA.replace(".", "");
        pqta = pqta.replace(",", ".");

        if (parseFloat(sldm) > 0) {

        let factor = (pqta / sldm).toFixed(2);
        factor = factor.replace(".", ",");
        // document.getElementById("resultado").innerHTML = factor; //(pqta / sldm).toFixed(2);
        document.getElementById("factor_meses").value = factor; //(pqta / sldm).toFixed(2);
        //factor = replaceAll(factor, ".", ",");
        } else {
        factor = "0,00";
        }
    //$("#txtFactor").val(factor);

    }

    document.getElementById('fs-doc-button').addEventListener('click', function() {
        toggleFullscreen();
      });

      // Fullscreen 

function toggleFullscreen(elem) {
    elem = elem || document.getElementById("chart-container");
    if (!document.fullscreenElement && !document.mozFullScreenElement &&
      !document.webkitFullscreenElement && !document.msFullscreenElement) {
      if (elem.requestFullscreen) {
        elem.requestFullscreen();
      } else if (elem.msRequestFullscreen) {
        elem.msRequestFullscreen();
      } else if (elem.mozRequestFullScreen) {
        elem.mozRequestFullScreen();
      } else if (elem.webkitRequestFullscreen) {
        elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
      }
    } else {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
      } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
      } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
      }
    }
  }
  

  function validardocumento(){
    var documento = document.getElementById('documento').value;
    const add = document.getElementById('add');
    
    $.post("data.php?doc", {
        documento: documento
    }, function(data) {
        if(data.dato == 2)
        {
            var errorDiv = document.getElementById('error');
            errorDiv.innerHTML = 'El Número de Documento ya Existe.';
            errorDiv.style.display = 'block';
            add.disabled = true;
        }
        else
        {
            add.disabled = false; 
            var errorDiv = document.getElementById('error');
            errorDiv.innerHTML = '';
            errorDiv.style.display = 'none';
        }
    });

  }


  function validardocumentoeditar(){
    var documento = document.getElementById('documento').value;
    var documentoold = document.getElementById('documentoold').value;
    const update = document.getElementById('update');
    
    if(documento != documentoold)
    {
    $.post("data.php?doc", {
        documento: documento
    }, function(data) {
        if(data.dato == 2)
        {
            var errorDiv = document.getElementById('error');
            errorDiv.innerHTML = 'El Número de Documento ya Existe.';
            errorDiv.style.display = 'block';
            update.disabled = true;
        }
        else
        {
            update.disabled = false; 
            var errorDiv = document.getElementById('error');
            errorDiv.innerHTML = '';
            errorDiv.style.display = 'none';
        }
    });
    }
    else
    {
        update.disabled = false; 
        var errorDiv = document.getElementById('error');
        errorDiv.innerHTML = '';
        errorDiv.style.display = 'none'; 
    }
  }

 