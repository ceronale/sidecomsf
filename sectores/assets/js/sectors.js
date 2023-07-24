function eliminar_sector(id, sector) {
    Swal.fire({
        title: '¿Seguro que desea eliminar el sector: ' + sector + '?',
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
                'El sector ha sido eliminado',
                'success'
            )
            window.location.href = 'save?deleteid=' + id
        }
    })
}

