function showAlert(mensaje, tipo) {
    var alertContainer = document.getElementById('alert-container');

    // Generar un ID único para la alerta
    var alertId = 'last-alert';

    var alertHTML = `
        <div id="${alertId}" class="alert ${tipo} alert-dismissible fade show" role="alert">
            <strong>${mensaje}</strong>
            <button type="button" class="close" onclick="closeAlert()" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `;
    alertContainer.innerHTML = alertHTML;
}

function closeAlert() {
    var alertElement = document.getElementById("last-alert");
    if (alertElement) {
        alertElement.remove();
    }
}

function validateNumericInputs(input, maxLength) {
    // Remove non-digit characters
    input.value = input.value.replace(/\D/g, '');

    // Limit length to maxLength characters
    if (input.value.length > maxLength) {
        input.value = input.value.slice(0, maxLength);
    }
}


function showSweetAlert(mensaje, tipo) {
    let titulo, icono;
    switch (tipo) {
        case 'success':
            titulo = '¡Éxito!';
            icono = 'success';
            break;
        case 'error':
            titulo = '¡Error!';
            icono = 'error';
            break;
        case 'warning':
            titulo = '¡Advertencia!';
            icono = 'warning';
            break;
        default:
            titulo = '¡Atención!';
            icono = 'info';
            break;
    }

    Swal.fire({
        title: titulo,
        text: mensaje,
        icon: icono,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Aceptar'
    });
}