$(document).ready(function () {
    $('ul.tabs li a:first').addClass('active');
    $('.secciones article').hide();
    $('.secciones article:first').show();

    $('ul.tabs li a').click(function () {
        $('ul.tabs li a').removeClass('active');
        $(this).addClass('active');
        $('.secciones article').hide();

        var activeTab = $(this).attr('href');
        $(activeTab).show();
        return false;
    });
});

window.onload = function () {
    updateTotal();
}


function updateTotal() {
    var empleados = parseInt(document.getElementById("empleados").value) || 0;
    var obreros = parseInt(document.getElementById("obreros").value) || 0;
    var total = empleados + obreros;
    document.getElementById("totalTrab").value = total;
}

function info_tabla(title, info) {
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