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

//Educacion
$('#tbleducacion input:radio').click(function() {
    //debugger;
    $("input[name='educacion']").val("");
    var puntaje=null;
    puntaje = $(this).val();
    $("input[name='educacion']").val(puntaje);
    if($(this).val() == "0") { 
    $("input[name='educacion']").removeAttr("readonly");
    $("input[name='educacion']").focus();
    }
    sumPuntaje();
});
//Experiencia
$('#tblexperiencia input:radio').click(function() {
    $("input[name='experiencia']").val("");
    var puntaje=null;
    puntaje = $(this).val();
    $("input[name='experiencia']").val(puntaje);
    if($(this).val() == "0") { 
        $("input[name='experiencia']").removeAttr("readonly");
        $("input[name='experiencia']").focus();
        }
    sumPuntaje();
});
//Problemas
$('#tblproblemas input:radio').click(function() {
    $("input[name='problemas']").val("");
    var puntaje=null;
    puntaje = $(this).val();
    $("input[name='problemas']").val(puntaje);
    if($(this).val() == "0") { 
        $("input[name='problemas']").removeAttr("readonly");
        $("input[name='problemas']").focus();
        }
    sumPuntaje();
});

//Supervision
$('#tblsupervision input:radio').click(function() {
    $("input[name='supervision']").val("");
    var puntaje=null;
    puntaje = $(this).val();
    $("input[name='supervision']").val(puntaje);
    if($(this).val() == "0") { 
        $("input[name='supervision']").removeAttr("readonly");
        $("input[name='supervision']").focus();
        }
    sumPuntaje();
});
//financiera
$('#tblfinanciera input:radio').click(function() {
    $("input[name='financiera']").val("");
    var puntaje=null;
    puntaje = $(this).val();
    $("input[name='financiera']").val(puntaje);
    if($(this).val() == "0") { 
        $("input[name='financiera']").removeAttr("readonly");
        $("input[name='financiera']").focus();
        }
    sumPuntaje();
});
//Maquinarias
$('#tblmaquinarias input:radio').click(function() {
    $("input[name='maquinarias']").val("");
    var puntaje=null;
    puntaje = $(this).val();
    $("input[name='maquinarias']").val(puntaje);
    if($(this).val() == "0") { 
        $("input[name='maquinarias']").removeAttr("readonly");
        $("input[name='maquinarias']").focus();
        }
    sumPuntaje();
});
//Contactos
$('#tblcontactos input:radio').click(function() {
    $("input[name='contactos']").val("");
    var puntaje=null;
    puntaje = $(this).val();
    $("input[name='contactos']").val(puntaje);
    if($(this).val() == "0") { 
        $("input[name='contactos']").removeAttr("readonly");
        $("input[name='contactos']").focus();
        }
    sumPuntaje();
});
//Desiciones
$('#tbldecisiones input:radio').click(function() {
    $("input[name='decisiones']").val("");
    var puntaje=null;
    puntaje = $(this).val();
    $("input[name='decisiones']").val(puntaje);
    if($(this).val() == "0") { 
        $("input[name='decisiones']").removeAttr("readonly");
        $("input[name='decisiones']").focus();
        }
    sumPuntaje();
});
//Informacion
$('#tblinformacion input:radio').click(function() {
    $("input[name='informacion']").val("");
    var puntaje=null;
    puntaje = $(this).val();
    $("input[name='informacion']").val(puntaje);
    if($(this).val() == "0") { 
        $("input[name='informacion']").removeAttr("readonly");
        $("input[name='informacion']").focus();
        }
    sumPuntaje();
});


//Esfuerzo Fisico
$('#tblfisico input:radio').click(function() {
    $("input[name='esfuerzo']").val("");
    var puntaje=null;
    puntaje = $(this).val();
    $("input[name='esfuerzo']").val(puntaje);
    if($(this).val() == "0") { 
        $("input[name='esfuerzo']").removeAttr("readonly");
        $("input[name='esfuerzo']").focus();
        }
    sumPuntaje();
});

//Esfuerzo Mental
$('#tblmental input:radio').click(function() {
    $("input[name='mental']").val("");
    var puntaje=null;
    puntaje = $(this).val();
    $("input[name='mental']").val(puntaje);
    if($(this).val() == "0") { 
        $("input[name='mental']").removeAttr("readonly");
        $("input[name='mental']").focus();
        }
    sumPuntaje();
});
//Esfuerzo Sensorial
$('#tblsensorial input:radio').click(function() {
    $("input[name='sensorial']").val("");
    var puntaje=null;
    puntaje = $(this).val();
    $("input[name='sensorial']").val(puntaje);
    if($(this).val() == "0") { 
        $("input[name='sensorial']").removeAttr("readonly");
        $("input[name='sensorial']").focus();
        }
    sumPuntaje();
});


// Condicion ambiental
$('#tblambiente input:radio').click(function() {
    $("input[name='ambiental']").val("");
    var puntaje=null;
    puntaje = $(this).val();
    $("input[name='ambiental']").val(puntaje);
    if($(this).val() == "0") { 
        $("input[name='ambiental']").removeAttr("readonly");
        $("input[name='ambiental']").focus();
        }
    sumPuntaje();
});
// Riesgo
$('#tblriesgo input:radio').click(function() {
    $("input[name='riesgo']").val("");
    var puntaje=null;
    puntaje = $(this).val();
    $("input[name='riesgo']").val(puntaje);
    if($(this).val() == "0") { 
        $("input[name='riesgo']").removeAttr("readonly");
        $("input[name='riesgo']").focus();
        }
    sumPuntaje();
});
//
function sumPuntaje(){

    //debugger;

    var total=0;

    var educacion=$("input[name='educacion']").val();
    var experiencia=$("input[name='experiencia']").val();
    var problemas=$("input[name='problemas']").val();
    //
    var supervision=$("input[name='supervision']").val();
    var financiera=$("input[name='financiera']").val();
    var maquinarias=$("input[name='maquinarias']").val();
    var contactos=$("input[name='contactos']").val();
    var decisiones=$("input[name='decisiones']").val();
    var informacion=$("input[name='informacion']").val();
    //
    var esfuerzo=$("input[name='esfuerzo']").val();
    var mental=$("input[name='mental']").val();
    var sensorial=$("input[name='sensorial']").val();
    //
    var ambiental=$("input[name='ambiental']").val();
    var riesgo=$("input[name='riesgo']").val();
    //
    total= parseInt(educacion) + parseInt(experiencia) + parseInt(problemas) + parseInt(supervision) + parseInt(financiera) + parseInt(maquinarias) + parseInt(contactos) + parseInt(decisiones) + parseInt(informacion) + parseInt(esfuerzo) + parseInt(mental) + parseInt(sensorial) + parseInt(ambiental) + parseInt(riesgo);
    //
  
    document.getElementById("puntaje").value = total;
    document.getElementById("puntajetotal").innerText = total;

    
}
//

//
function checkRangos(num) {
    switch(num) {
        case "educacion":
            var value= $("input[name='educacion']").val();
            if(value<17||value>125){
                $("#btn-save-val").prop("disabled", true);
              $("input[name='educacion']").css('color', 'red');
              $("input[name='educacion']").css('font-weight','bold');
              swal("Error..! Ingrese un valor entre\nel valor mínimo y máximo permitidos");
              $("input[name='educacion']").focus();
              
            }else{
              //$("input[name='puntaje21']").css('border', 'solid 2px black');
              $("#btn-save-val").prop("disabled", false);
              $("input[name='educacion']").css('color', 'black');
              $("input[name='educacion']").css('font-weight','normal');
             
            }
            break;
        case "experiencia":
            var value= $("input[name='experiencia']").val();
            if(value<25||value>125){
                $("#btn-save-val").prop("disabled", true);
                $("input[name='experiencia']").css('color', 'red');
                $("input[name='experiencia']").css('font-weight','bold');
                swal("Error..! Ingrese un valor entre\nel valor mínimo y máximo permitidos");
                $("input[name='experiencia']").focus();
            }else{
                //$("input[name='puntaje21']").css('border', 'solid 2px black');
                $("input[name='experiencia']").css('color', 'black');
                $("input[name='experiencia']").css('font-weight','normal');
            }
            break;
        case "problemas":
            var value= $("input[name='problemas']").val();
            if(value<37||value>150){
                $("#btn-save-val").prop("disabled", true);
              $("input[name='problemas']").css('color', 'red');
              $("input[name='problemas']").css('font-weight','bold');
              swal("Error..! Ingrese un valor entre\nel valor mínimo y máximo permitidos");
              $("input[name='problemas']").focus();
            }else{
                $("#btn-save-val").prop("disabled", false);
              //$("input[name='puntaje21']").css('border', 'solid 2px black');
              $("input[name='problemas']").css('color', 'black');
              $("input[name='problemas']").css('font-weight','normal');
            }
            break;
        case "supervision":
          var value= $("input[name='supervision']").val();
          if(value<17||value>100){
            $("#btn-save-val").prop("disabled", true);
            $("input[name='supervision']").css('color', 'red');
            $("input[name='supervision']").css('font-weight','bold');
            swal("Error..! Ingrese un valor entre\nel valor mínimo y máximo permitidos");
            $("input[name='supervision']").focus();
          }else{
            $("#btn-save-val").prop("disabled", false);
            //$("input[name='puntaje21']").css('border', 'solid 2px black');
            $("input[name='supervision']").css('color', 'black');
            $("input[name='supervision']").css('font-weight','normal');
          }
          break;
        case "financiera":
            var value= $("input[name='financiera']").val();
            if(value<15||value>60){
                $("#btn-save-val").prop("disabled", true);
              $("input[name='financiera']").css('color', 'red');
              $("input[name='financiera']").css('font-weight','bold');
              swal("Error..! Ingrese un valor entre\nel valor mínimo y máximo permitidos");
              $("input[name='financiera']").focus();
            }else{
                $("#btn-save-val").prop("disabled", false);
              $("input[name='financiera']").css('color', 'black');
              $("input[name='financiera']").css('font-weight','normal');
            }
           break;
        case "maquinarias":
            var value= $("input[name='maquinarias']").val();
            if(value<17||value>50){
                $("#btn-save-val").prop("disabled", true);
              $("input[name='maquinarias']").css('color', 'red');
              $("input[name='maquinarias']").css('font-weight','bold');
              swal("Error..! Ingrese un valor entre\nel valor mínimo y máximo permitidos");
              $("input[name='maquinarias']").focus();
            }else{
                $("#btn-save-val").prop("disabled", false);
              $("input[name='maquinarias']").css('color', 'black');
              $("input[name='maquinarias']").css('font-weight','normal');
            }
           break;
        case "contactos":
            var value= $("input[name='contactos']").val();
            if(value<10||value>40){
                $("#btn-save-val").prop("disabled", true);
              $("input[name='contactos']").css('color', 'red');
              $("input[name='contactos']").css('font-weight','bold');
              swal("Error..! Ingrese un valor entre\nel valor mínimo y máximo permitidos");
              $("input[name='contactos']").focus();
            }else{
                $("#btn-save-val").prop("disabled", false);
              $("input[name='contactos']").css('color', 'black');
              $("input[name='contactos']").css('font-weight','normal');
            }
           break;
        case "decisiones":
            var value= $("input[name='decisiones']").val();
            if(value<20||value>80){
                $("#btn-save-val").prop("disabled", true);
              $("input[name='decisiones']").css('color', 'red');
              $("input[name='decisiones']").css('font-weight','bold');
              swal("Error..! Ingrese un valor entre\nel valor mínimo y máximo permitidos");
              $("input[name='decisiones']").focus();
            }else{
                $("#btn-save-val").prop("disabled", false);
              $("input[name='decisiones']").css('color', 'black');
              $("input[name='decisiones']").css('font-weight','normal');
            }
        case "informacion":
                var value= $("input[name='informacion']").val();
                if(value<17||value>70){
                    $("#btn-save-val").prop("disabled", true);
                  $("input[name='informacion']").css('color', 'red');
                  $("input[name='informacion']").css('font-weight','bold');
                  swal("Error..! Ingrese un valor entre\nel valor mínimo y máximo permitidos");
                  $("input[name='informacion']").focus();
                }else{
                    $("#btn-save-val").prop("disabled", false);
                  $("input[name='informacion']").css('color', 'black');
                  $("input[name='informacion']").css('font-weight','normal');
                }
           break;
        case "esfuerzo":
            var value= $("input[name='esfuerzo']").val();
            if(value<10||value>30){
                $("#btn-save-val").prop("disabled", true);
              $("input[name='esfuerzo']").css('color', 'red');
              $("input[name='esfuerzo']").css('font-weight','bold');
              swal("Error..! Ingrese un valor entre\nel valor mínimo y máximo permitidos");
              $("input[name='esfuerzo']").focus();
            }else{
                $("#btn-save-val").prop("disabled", false);
              $("input[name='esfuerzo']").css('color', 'black');
              $("input[name='esfuerzo']").css('font-weight','normal');
            }
            break;
        case "mental":
            var value= $("input[name='mental']").val();
            if(value<15||value>60){
                $("#btn-save-val").prop("disabled", true);
                $("input[name='mental']").css('color', 'red');
                $("input[name='mental']").css('font-weight','bold');
                swal("Error..! Ingrese un valor entre\nel valor mínimo y máximo permitidos");
                $("input[name='mental']").focus();
            }else{
                $("#btn-save-val").prop("disabled", false);
                $("input[name='mental']").css('color', 'black');
                $("input[name='mental']").css('font-weight','normal');
            }
            break;
        case "sensorial":
            var value= $("input[name='sensorial']").val();
            if(value<7||value>30){
                $("#btn-save-val").prop("disabled", true);
                $("input[name='sensorial']").css('color', 'red');
                $("input[name='sensorial']").css('font-weight','bold');
                swal("Error..! Ingrese un valor entre\nel valor mínimo y máximo permitidos");
                $("input[name='sensorial']").focus();
            }else{
                $("#btn-save-val").prop("disabled", false);
                $("input[name='sensorial']").css('color', 'black');
                $("input[name='sensorial']").css('font-weight','normal');
            }
            break;
        case "ambiental":
            var value= $("input[name='ambiental']").val();
            if(value<10||value>30){
                $("#btn-save-val").prop("disabled", true);
                $("input[name='ambiental']").css('color', 'red');
                $("input[name='ambiental']").css('font-weight','bold');
                swal("Error..! Ingrese un valor entre\nel valor mínimo y máximo permitidos");
                $("input[name='ambiental']").focus();
            }else{
                $("#btn-save-val").prop("disabled", false);
                $("input[name='ambiental']").css('color', 'black');
                $("input[name='ambiental']").css('font-weight','normal');
            }
            break;
        case "riesgo":
            var value= $("input[name='riesgo']").val();
            if(value<17||value>50){
                $("#btn-save-val").prop("disabled", true);
                $("input[name='riesgo']").css('color', 'red');
                $("input[name='riesgo']").css('font-weight','bold');
                swal("Error..! Ingrese un valor entre\nel valor mínimo y máximo permitidos");
                $("input[name='riesgo']").focus();
            }else{
                $("#btn-save-val").prop("disabled", false);
                $("input[name='riesgo']").css('color', 'black');
                $("input[name='riesgo']").css('font-weight','normal');
            }
            break;        
        default:
          // code block
      }

  }

  function info_tabla(title,info) 
  {
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
