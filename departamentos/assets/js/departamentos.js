function eliminar_departamento(id,departamento,categoria) {
  Swal.fire({
      title: '¿Seguro que desea eliminar el Departamento: ' + departamento + '?',
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
              'El Departamento ha sido eliminado',
              'success'
          )
          window.location.href = 'save?deleteid=' + id + '&ca=' + categoria
      }
  })
}

function info_tabla(title,info) 
{
    Swal.fire({
        title: title,
        width: '500px',
            html: `         <div class="card card-body" style="text-align: left; font-size: 20px">
                                <p>
                                ` + info + `
                                </p>
                            </div>
                        `,
    showConfirmButton: true,
    })
   
}