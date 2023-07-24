function eliminar_usuario(id, usuario) {
    Swal.fire({
        title: '¿Seguro que desea eliminar el usuario: ' + usuario + '?',
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
                'El usuario ha sido eliminado',
                'success'
            )
            window.location.href = 'save?deleteid=' + id
        }
    })
}

function crear_usuario(cargos) {

    var cargosArray = JSON.parse(cargos);

    let html = `
        <form id='crear_usuario' action="save.php" method='post' style="text-align: center !important;">
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

    cargosArray.forEach(function (cargoOption) {
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
                    <label for="status">Status:</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>

                                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type='text' name='password' class='form-control' required autocomplete="on">
                    </div>
        </div>
            </div >
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
};

function editar_usuario(id, nombre, apellido, cargo, email, status, cargos, lastemail) {
    var cargosArray = JSON.parse(cargos);
    let html = `
        <form id = 'editar_usuario' action = "save.php" method = 'post' style = "text-align: center !important;">
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

    cargosArray.forEach(function (cargoOption) {
        html += `<option value="${cargoOption["id"]}" ${cargoOption["id"] === cargo ? 'selected' : ''}>${cargoOption["nombre"]}</option>`;
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
    });
    dselect(document.querySelector('#cargo'), {
        search: true
    })
}

