function eliminar_glosario(id, glosario) {
    Swal.fire({
        title: '¿Seguro que desea eliminar el termino: ' + glosario + '?',
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
                'El termino ha sido eliminado',
                'success'
            )
            window.location.href = 'save?deleteid=' + id
        }
    })
}

