


function eliminar_beneficio(id, beneficio, id_p) {
    Swal.fire({
        title: '¿Seguro que desea eliminar el Beneficio: ' + beneficio + '?',
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
                'Se han deseleccionado los beneficios para los niveles que estaban seleccionados.',
                'success'
            )
            window.location.href = 'save?deleteid=' + id + '&idp=' + id_p;
        }
    })
}


function info_tabla(title, info) {
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