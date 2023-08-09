function eliminar_beneficio(id, beneficio) {
    Swal.fire({
        title: '¿Seguro que desea eliminar el beneficio: ' + beneficio + '?',
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
                'El beneficio ha sido eliminado',
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