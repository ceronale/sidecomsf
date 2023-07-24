function eliminar_producto(id, actividad) {
    Swal.fire({
        title: '¿Seguro que desea eliminar el porducto/servicio: ' + actividad + '?',
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
                'El porducto/servicio ha sido eliminado',
                'success'
            )
            window.location.href = 'save?deleteid=' + id
        }
    })
}

