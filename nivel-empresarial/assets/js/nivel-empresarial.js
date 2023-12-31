function eliminar_nivelempresarial(id, nivel) {
    Swal.fire({
        title: '¿Seguro que desea eliminar el Nivel de aplicación de beneficios: ' + nivel + '?',
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
                'El Nivel de aplicación de beneficios ha sido eliminado',
                'success'
            )
            window.location.href = 'save?deleteid=' + id
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