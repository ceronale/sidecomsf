$(document).ready(function () {
   $('body .dropdown-toggle').dropdown();
});
function eliminar_cargo(id, cargo, categoria) {
   Swal.fire({
      title: '¿Seguro que desea eliminar el cargo: ' + cargo + '?',
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
            'El cargo ha sido eliminado',
            'success'
         )
         window.location.href = 'save?deleteid=' + id + "&ca=" + categoria;
      }
   })
}
function actualizarGrados(categoria, admin, taller) {
   let grados = [];
   if (categoria === "1") {
      grados = admin;
   } else if (categoria === "2") {
      grados = taller;
   }

   // Actualizar las opciones del campo "admin" en el formulario
   let adminSelect = document.getElementsByName("grado")[0];
   adminSelect.innerHTML = "";
   grados.forEach(function (option) {
      let optionElement = document.createElement("option");
      optionElement.value = option["grado"];
      optionElement.innerText = option["grado"];

      adminSelect.appendChild(optionElement);
   });
}

function actualizarGradosEditar(categoria, admin, taller) {

   let grados = [];

   if (categoria === "1") {
      grados = JSON.parse(admin);
   } else if (categoria === "2") {
      grados = JSON.parse(taller);
   }


   // Actualizar las opciones del campo "admin" en el formulario
   let adminSelect = document.getElementsByName("grado2")[0];
   adminSelect.innerHTML = "";
   grados.forEach(function (option) {
      let optionElement = document.createElement("option");
      optionElement.value = option["grado"];
      optionElement.innerText = option["grado"];

      adminSelect.appendChild(optionElement);
   });
}

function crear_cargo(departamentos, categoria) {

   let html = `
<form id='crear_cargo' action="save.php?ca=${categoria}" method='post' style="text-align: center !important;">
   <br>

   <input type="hidden" name="grado-oculto" id="grado-oculto">
   <input class="hidden" id="cargo_info" name="cargo_info" value="0">


   <div class="hidden" id="info_cargo">
       <div class="card card-body" style="text-align: justify; font-size: 14px">
           <p>
               <em><strong>Cargo/Puesto:</strong></em><br> 
               Un <strong>Cargo</strong> es un conjunto de funciones, tareas y operaciones específicas representativas, relacionadas con la actividad laboral, cuyo ejercicio conlleva responsabilidades, conocimientos y habilidades para su desempeño.<br><br>
               Un <strong>Puesto</strong> Se refiere a la ubicación física de un determinado Cargo dentro de la jerarquía y dentro del espacio físico donde se desempeña la persona. Con el avance de la tecnología, los puestos de trabajo no tienen en muchos casos, espacio físico, el trabajo es realizado en forma virtual, en cualquier espacio físico, a cualquier hora y en cualquier lugar o ciudad. En la práctica, hemos observado que empresas privadas consideran el Puesto como sinónimo de Cargo, aunque técnicamente no es lo mismo.`;   

   if (categoria == 2) {
      html += `<br><br><strong>Cargos Planta - Taller - Fábrica: <br> No incluyen supervisores o cualquier otra actividad
               administrativa aunque laboren en planta, industria o
               taller.</em></strong>`;

   }

   html += `</p>
       </div>
   </div>

   
<input class="hidden" id="puntaje_info" name="puntaje_info" value="0">

<div class="hidden" id="info_puntaje">
    <div class="card card-body" style="text-align: justify; font-size: 14px">
        <p>
            <em><strong>
               Si posee los cargos valorados en escala de uno (1) a mil
               (1000) puntos, puede agregarlo (el grado aparecerá
               automáticamente), de lo contrario, valore sus cargos en el
               formato VALORACIÓN DE CARGOS.
            </strong></em><br> 
         </p>
    </div>
</div>

<input class="hidden" id="descripcion_info" name="cargo_info" value="0">

<div class="hidden" id="info_descripcion">
    <div class="card card-body" style="text-align: justify; font-size: 14px">
        <p>
            <em><strong>
               Si tiene definidas las funciones, puede agregarlas y se
               reflejarán en la planilla DESCRIPCIÓN DE CARGOS.
            </em><br> 
        </p>
    </div>
</div>

   <div class="row">
      <div class="col-md-6">
         
         <div class="form-group">
               <label for="cargo" style="color: #3c8dbc;" onclick="show_info_cargo()"> Puesto/Cargo: <span><i class="fas fa-question-circle"></i></span></label>
            <input type='text' name='cargo' class='form-control' maxlength="255" required autocomplete="on">
         </div>


         <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-select" id="status" name="status" required>
               <option value="1">Activo</option>
               <option value="0">Inactivo</option>
            </select>
         </div>
      </div>
      <div class="col-md-6">
        
      <div class="form-group">
               <label for="departamento">Departamento:</label>
                                       <select class="form-select" name="departamento" id="departamento" required>
                           <option disabled selected value="">Selecciona una opción</option>`;

   departamentos.forEach(function (departamento) {
      html += `<option  value="${departamento["id"]}">${departamento["nombre"]}</option>`;
   });
   html += `</select>
         </div>


      </div>
   </div>
   <div class="form-group">
      <label for="descripcion" style="color: #3c8dbc;"  onclick="show_info_descripcion()">Breve descripción del Puesto/Cargo:</label>
      <textarea name="descripcion" class="form-control" maxlength="8000" required ></textarea>
   </div>
   <div class="col-md-12">
      <br>
      <button type="submit" class="btn btn-dark" name="add" id='add'>
         Guardar
      </button>
   </div>
   <br>
</form>
`;

   Swal.fire({
      title: "Nuevo Puesto/Cargo",
      html: html,
      showConfirmButton: false,
   })
   dselect(document.querySelector('#departamento'), {
      search: true
   })
   $(document).ready(function () {
      $(".hidden").hide();
   });
};

function editar_cargo(id, nombre, id_departamento, categoria, status, descripcion, departamentos) {
   departamentos = JSON.parse(departamentos);

   let html = `
<form id='crear_cargo' action="save.php?ca=${categoria}" method='post' style="text-align: center !important;">
<input class="hidden" id="cargo_info" name="cargo_info" value="0">

<div class="hidden" id="info_cargo">
    <div class="card card-body" style="text-align: justify !important; font-size: 14px">
        <p>
            <em><strong>Cargo/Puesto:</strong></em><br> 
            Un <strong>Cargo</strong> es un conjunto de funciones, tareas y operaciones específicas representativas, relacionadas con la actividad laboral, cuyo ejercicio conlleva responsabilidades, conocimientos y habilidades para su desempeño.<br><br>
            Un <strong>Puesto</strong>  Se refiere a la ubicación física de un determinado Cargo dentro de la jerarquía y dentro del espacio físico donde se desempeña la persona. Con el avance de la tecnología, los puestos de trabajo no tienen en muchos casos, espacio físico, el trabajo es realizado en forma virtual, en cualquier espacio físico, a cualquier hora y en cualquier lugar o ciudad. En la práctica, hemos observado que empresas privadas consideran el Puesto como sinónimo de Cargo, aunque técnicamente no es lo mismo.`;

   if (categoria == 2) {
      html += `<br><br><strong>Cargos Planta - Taller - Fábrica: <br> No incluyen supervisores o cualquier otra actividad
            administrativa aunque laboren en planta, industria o
            taller.</em></strong>`;

   }

   html += `</p>
    </div>
</div>

<input class="hidden" id="puntaje_info" name="puntaje_info" value="0">

<div class="hidden" id="info_puntaje">
    <div class="card card-body" style="text-align: justify; font-size: 14px">
        <p>
            <em><strong>
               Si posee los cargos valorados en escala de uno (1) a mil
               (1000) puntos, puede agregarlo (el grado aparecerá
               automáticamente), de lo contrario, valore sus cargos en el
               formato VALORACIÓN DE CARGOS.
            </strong></em><br> 
         </p>
    </div>
</div>

<input class="hidden" id="descripcion_info" name="cargo_info" value="0">

<div class="hidden" id="info_descripcion">
    <div class="card card-body" style="text-align: justify; font-size: 14px">
        <p>
            <em><strong>
               Si tiene definidas las funciones, puede agregarlas y se
               reflejarán en la planilla DESCRIPCIÓN DE CARGOS.
            </em><br> 
        </p>
    </div>
</div>

<input type="hidden" name="id" id="id"  value="${id}">
   <br>
   <div class="row">
      <div class="col-md-6">
      <div class="form-group">
      <label for="cargo"  style="color: #3c8dbc;"  onclick="show_info_cargo()"> Puesto/Cargo: <span ><i class="fas fa-question-circle"></i></span></label>
      <input type='text' name='cargo' class='form-control' maxlength="255" required autocomplete="on" value="${nombre}">
      </div>
        

         <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-select" id="status" name="status" required>
               <option value="1" ${status === "1" ? "selected" : ""}>Activo</option>
               <option value="0" ${status === "0" ? "selected" : ""}>Inactivo</option>
            </select>
         </div>
      </div>
      <div class="col-md-6">

      <div class="form-group">
      <label for="departamento">Departamento:</label>
      <select class="form-select" name="departamento" id="departamento" required>
         <option disabled selected value="">Selecciona una opción</option>`;
departamentos.forEach(function (departamento) {
let selected = "";
if (departamento["id"] == id_departamento) {
   selected = "selected";
}
html += `<option value="${departamento["id"]}" ${selected}>${departamento["nombre"]}</option>`;
});
html += `</select>
   </div>
 
         
         
      </div>
   </div>
<div class="form-group">
  <label for="descripcion" style="color: #3c8dbc;"  onclick="show_info_descripcion()" >Breve descripción del Puesto/Cargo:</label>
  <textarea name="descripcion" class="form-control" min="1" max="1000" required>${descripcion}</textarea>
</div>

<input type='hidden' name='cargoold' class='form-control' maxlength="255" required autocomplete="on" value="${nombre}">
<input type='hidden' name='departamentoold' class='form-control' maxlength="255"  autocomplete="on" value="${id_departamento}">
<input type='hidden' name='categoria' class='form-control' maxlength="255"  autocomplete="on" value="${categoria}">

   <div class="col-md-12">
      <br>
      <button type="submit" class="btn btn-dark" name="update" id='update'>
         Guardar
      </button>
   </div>
   <br>

</form>`;
   Swal.fire({
      title: "Editar Puesto/Cargo",
      html: html,
      showConfirmButton: false,
   });
   dselect(document.querySelector('#departamento'), {
      search: true
   })
   $(document).ready(function () {
      $(".hidden").hide();
   });
}

function show_info_cargo() {
   cargo_info = document.getElementById("cargo_info").value;
   puntaje_info = document.getElementById("puntaje_info").value;
   descripcion_info = document.getElementById("descripcion_info").value;

   if (cargo_info == 0) {
      $("#info_cargo").show("fast");
      $("#info_puntaje").hide();
      $("#info_descripcion").hide();
      document.getElementById("cargo_info").value = 1;
      document.getElementById("puntaje_info").value = 0;
      document.getElementById("descripcion_info").value = 0;
   }
   if (cargo_info == 1) {
      $("#info_cargo").hide();
      document.getElementById("cargo_info").value = 0;
   }

}

function actualizarSelect(valor) {
   const select = document.getElementById('grado2');
   select.selectedIndex = 0; // Reiniciar selección
   const gradoInput = document.getElementById('grado-oculto2');
   for (let i = 1; i < select.options.length; i++) {
      const minimo = parseInt(select.options[i].getAttribute('data-minimo'));
      const maximo = parseInt(select.options[i].getAttribute('data-maximo'));

      if (valor >= minimo && valor <= maximo) {
         select.selectedIndex = i;
         gradoInput.value = select.value;
         break;
      }
   }
}

function actualizarSelect2(valor) {
   const select = document.getElementById('grado');
   select.selectedIndex = 0; // Reiniciar selección
   const gradoInput = document.getElementById('grado-oculto');

   for (let i = 1; i < select.options.length; i++) {
      const minimo = parseInt(select.options[i].getAttribute('data-minimo'));
      const maximo = parseInt(select.options[i].getAttribute('data-maximo'));



      if (valor >= minimo && valor <= maximo) {
         select.selectedIndex = i;
         gradoInput.value = select.value;
         break;
      }
   }
}

function actualizarCampoOculto() {
   const select = document.getElementById('grado');
   const oculto = document.getElementById('grado-oculto');
   oculto.value = select.value;
}

function show_info_puntaje() {
   cargo_info = document.getElementById("cargo_info").value;
   puntaje_info = document.getElementById("puntaje_info").value;
   descripcion_info = document.getElementById("descripcion_info").value;

   if (puntaje_info == 0) {
      $("#info_puntaje").show("fast");
      $("#info_cargo").hide();
      $("#info_descripcion").hide();
      document.getElementById("cargo_info").value = 0;
      document.getElementById("puntaje_info").value = 1;
      document.getElementById("descripcion_info").value = 0;
   }
   if (puntaje_info == 1) {
      $("#info_puntaje").hide();
      document.getElementById("puntaje_info").value = 0;
   }

}

function show_info_descripcion() {
   cargo_info = document.getElementById("cargo_info").value;
   puntaje_info = document.getElementById("puntaje_info").value;
   descripcion_info = document.getElementById("descripcion_info").value;

   if (descripcion_info == 0) {
      $("#info_descripcion").show("fast");
      $("#info_cargo").hide();
      $("#info_puntaje").hide();
      document.getElementById("cargo_info").value = 0;
      document.getElementById("puntaje_info").value = 0;
      document.getElementById("descripcion_info").value = 1;
   }
   if (descripcion_info == 1) {
      $("#info_descripcion").hide();
      document.getElementById("descripcion_info").value = 0;
   }

}