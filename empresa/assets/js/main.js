//DOM elements
const DOMstrings = {
  stepsBtnClass: 'multisteps-form__progress-btn',
  stepsBtns: document.querySelectorAll(`.multisteps-form__progress-btn`),
  stepsBar: document.querySelector('.multisteps-form__progress'),
  stepsForm: document.querySelector('.multisteps-form__form'),
  stepsFormTextareas: document.querySelectorAll('.multisteps-form__textarea'),
  stepFormPanelClass: 'multisteps-form__panel',
  stepFormPanels: document.querySelectorAll('.multisteps-form__panel'),
  stepPrevBtnClass: 'js-btn-prev',
  stepNextBtnClass: 'js-btn-next'
};

$(document).ready(function () {

  dselect(document.querySelector('#pais'), {
    search: true
  })
  dselect(document.querySelector('#actividad'), {
    search: true
  })

  dselect(document.querySelector('#productos-servicios'), {
    search: true
  })




  $('#basic').selectpicker({
    liveSearch: true
  }).on('loaded.bs.select', function (e) {

    // console.log('bs.select loaded event');

    // save the element
    var $el = $(this);

    // console.log( $el.data('selectpicker') );

    // the list items with the options
    var $lis = $el.data('selectpicker').$lis;

    $lis.each(function (i) {

      // get the title from the option
      var tooltip_title = $el.find('option').eq(i).attr('title');

      $(this).tooltip({
        'title': tooltip_title,
        'placement': 'right'
      });

    });

  });

});
//remove class from a set of items
const removeClasses = (elemSet, className) => {

  elemSet.forEach(elem => {

    elem.classList.remove(className);

  });

};

//return exect parent node of the element
const findParent = (elem, parentClass) => {

  let currentNode = elem;

  while (!(currentNode.classList.contains(parentClass))) {
    currentNode = currentNode.parentNode;
  }

  return currentNode;

};

//get active button step number
const getActiveStep = elem => {
  return Array.from(DOMstrings.stepsBtns).indexOf(elem);
};

//set all steps before clicked (and clicked too) to active
const setActiveStep = (activeStepNum) => {

  //remove active state from all the state
  removeClasses(DOMstrings.stepsBtns, 'js-active');

  //set picked items to active
  DOMstrings.stepsBtns.forEach((elem, index) => {

    if (index <= (activeStepNum)) {
      elem.classList.add('js-active');
    }

  });
};

//get active panel
const getActivePanel = () => {

  let activePanel;

  DOMstrings.stepFormPanels.forEach(elem => {

    if (elem.classList.contains('js-active')) {

      activePanel = elem;

    }

  });

  return activePanel;

};

//open active panel (and close unactive panels)
const setActivePanel = activePanelNum => {

  //remove active class from all the panels
  removeClasses(DOMstrings.stepFormPanels, 'js-active');

  //show active panel
  DOMstrings.stepFormPanels.forEach((elem, index) => {
    if (index === (activePanelNum)) {

      elem.classList.add('js-active');

      setFormHeight(elem);

    }
  })

};

//set form height equal to current panel height
const formHeight = (activePanel) => {

  const activePanelHeight = activePanel.offsetHeight;

  DOMstrings.stepsForm.style.height = `${activePanelHeight}px`;

};

const setFormHeight = () => {
  const activePanel = getActivePanel();

  formHeight(activePanel);
}

//STEPS BAR CLICK FUNCTION
DOMstrings.stepsBar.addEventListener('click', e => {

  //check if click target is a step button
  const eventTarget = e.target;

  if (!eventTarget.classList.contains(`${DOMstrings.stepsBtnClass}`)) {
    return;
  }

  //get active button step number
  const activeStep = getActiveStep(eventTarget);

  // validate fields in the current active panel
  const isValid = validarCamposForGroup(activeStep - 1);

  if (!isValid) {
    // fields are not valid, prevent advancing to the next step
    return;
  }

  //set all steps before clicked (and clicked too) to active
  setActiveStep(activeStep);

  //open active panel
  setActivePanel(activeStep);
});


//PREV/NEXT BTNS CLICK
DOMstrings.stepsForm.addEventListener('click', e => {

  const eventTarget = e.target;

  //check if we clicked on `PREV` or NEXT` buttons
  if (!((eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) || (eventTarget.classList.contains(`${DOMstrings.stepNextBtnClass}`)))) {
    return;
  }

  //find active panel
  const activePanel = findParent(eventTarget, `${DOMstrings.stepFormPanelClass}`);
  let activePanelNum = Array.from(DOMstrings.stepFormPanels).indexOf(activePanel);

  // Comprobar si estamos en la pantalla final
  if (activePanelNum === 3) {
    // Realizar acciones específicas de la pantalla final
    if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
      activePanelNum--;
      setActiveStep(activePanelNum);
      setActivePanel(activePanelNum);
    } else {
      if (!validarCampos(activePanelNum)) {
        event.preventDefault();
        return;
      }



    }
  } else {
    // Realizar acciones para las pantallas anteriores
    if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
      activePanelNum--;
    } else {
      if (!validarCampos(activePanelNum)) {
        return;
      }
      activePanelNum++;
    }

    if (activePanelNum <= 3) {
      if (activePanelNum === 3) {
        Swal.fire({
          title: '¿Estás seguro?',
          text: 'Una vez seleccionada la escala, no podrá cambiar o pasar a otra escala',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Continuar'
        }).then((result) => {
          if (result.isConfirmed) {
            setActiveStep(activePanelNum);
            setActivePanel(activePanelNum);
          }
        });
      } else {
        setActiveStep(activePanelNum);
        setActivePanel(activePanelNum);
      }

    }
  }

});


//SETTING PROPER FORM HEIGHT ONLOAD
window.addEventListener('load', setFormHeight, false);

//SETTING PROPER FORM HEIGHT ONRESIZE
window.addEventListener('resize', setFormHeight, false);

//changing animation via animation select !!!YOU DON'T NEED THIS CODE (if you want to change animation type, just change form panels data-attr)

const setAnimationType = (newType) => {
  DOMstrings.stepFormPanels.forEach(elem => {
    elem.dataset.animation = newType;
  })
};

//selector onchange - changing animation
const animationSelect = document.querySelector('.pick-animation__select');

animationSelect.addEventListener('change', () => {
  const newAnimationType = animationSelect.value;

  setAnimationType("fadeIn");
});



function validarCampos(activePanelNum) {
  //cierra la alerta anterior
  closeAlert();
  // Validación para el Grupo 1
  if (activePanelNum === 0) {
    var empresa = document.getElementById('empresa').value;
    var tributaria = document.getElementById('tributaria').value;
    var pais = document.getElementById('pais').value;
    var ciudad = document.getElementById('ciudad').value;
    var estado = document.getElementById('estado').value;
    var direccion = document.getElementById('direccion').value;
    var moneda = document.getElementById('moneda').value;
    var telefonos = document.getElementById('telefonos').value;
    var codigoPostal = document.getElementById('codigo_postal').value;


    if (empresa === '') {
      showAlert('Por favor, ingresa el nombre de la empresa', 'alert-danger');
      return false;
    }
    if (tributaria === '') {
      showAlert('Por favor, ingresa el número de tributaria', 'alert-danger');
      return false;
    }
    if (pais === '') {
      showAlert('Por favor, selecciona un país', 'alert-danger');
      return false;
    }
    if (moneda === '') {
      showAlert('Por favor, ingresa la moneda', 'alert-danger');
      return false;
    }
    if (ciudad === '') {
      showAlert('Por favor, ingresa la ciudad', 'alert-danger');
      return false;
    }
    if (estado === '') {
      showAlert('Por favor, ingresa el estado', 'alert-danger');
      return false;
    }
    if (direccion === '') {
      showAlert('Por favor, ingresa la dirección', 'alert-danger');
      return false;
    }

    if (telefonos === '') {
      showAlert('Por favor, ingresa los teléfonos', 'alert-danger');
      return false;
    }
    if (codigoPostal === '') {
      showAlert('Por favor, ingresa el código postal', 'alert-danger');
      return false;
    }

  }

  // Validación para el Grupo 2
  if (activePanelNum === 1) {
    var tipoEmpresa = document.getElementById('tipo-empresa').value;
    var sector = document.getElementById('sector').value;
    var actividad = document.getElementById('actividad').value;
    var opcionPersonalizada = document.getElementById('opcionPersonalizada').value;
    var productosServicios = document.getElementById('productos-servicios').value;
    console.log(productosServicios);


    if (tipoEmpresa === '') {
      showAlert('Por favor, selecciona el tipo de empresa', 'alert-danger');
      return false;
    }
    if (sector === '') {
      showAlert('Por favor, ingresa el sector', 'alert-danger');
      return false;
    }

    if (actividad === '' && opcionPersonalizada === '') {
      showAlert('Por favor, ingresa la actividad', 'alert-danger');
      return false;
    }
    if (productosServicios === '' && opcionPersonalizada2 === '') {
      showAlert('Por favor, ingresa los productos o servicios', 'alert-danger');
      return false;
    }

  }

  // Validación para el Grupo 3
  if (activePanelNum === 2) {

    var escala_administrativo = document.getElementById('escala_administrativo').value;
    var escala_taller = document.getElementById('escala_planta').value;


    if (escala_administrativo === '') {
      showAlert('Por favor, ingresa la escala de la area administrativa', 'alert-danger');
      return false;
    }
    if (escala_taller === '') {
      showAlert('Por favor, ingresa la escala de la area de taller/planta', 'alert-danger');
      return false;
    }
  }

  if (activePanelNum === 3) {

    var nombrerh = document.getElementById('nombrerh').value;
    var emailrh = document.getElementById('emailrh').value;
    var telefonorh = document.getElementById('telefonorh').value;
    var puestorh = document.getElementById('puestorh').value;

    if (nombrerh === '') {
      showAlert('Por favor, ingresa el nombre del responsable de recursos humanos', 'alert-danger');
      return false;
    }
    if (emailrh === '') {
      showAlert('Por favor, ingresa el email del responsable de recursos humanos', 'alert-danger');
      return false;
    }
    if (telefonorh === '') {
      showAlert('Por favor, ingresa el teléfono del responsable de recursos humanos', 'alert-danger');
      return false;
    }
    if (puestorh === '') {
      showAlert('Por favor, ingresa el puesto del responsable de recursos humanos', 'alert-danger');
      return false;
    }



  }

  return true; // Si todas las validaciones pasan, retorna true
}

function validarCamposForGroup(activePanelNum) {
  closeAlert();

  if (activePanelNum === 0) {
    const grupo1Campos = ['empresa', 'tributaria', 'pais', 'ciudad', 'estado', 'direccion', 'telefonos', 'codigo_postal', 'moneda'];

    for (let campo of grupo1Campos) {
      const valor = document.getElementById(campo).value;

      if (valor === '') {
        showAlert(`Por favor, ingresa todos los campos de la primera sección`, 'alert-danger');
        return false;
      }
    }
  }

  if (activePanelNum === 1) {
    const grupo2Campos = ['tipo-empresa', 'sector', 'actividad', 'productos-servicios', 'nivel-empresarial'];

    for (let campo of grupo2Campos) {
      const valor = document.getElementById(campo).value;

      if (valor === '') {
        showAlert(`Por favor, ingresa todos los campos de la segunda sección`, 'alert-danger');
        return false;
      }
    }
  }

  if (activePanelNum === 2) {
    const grupo3Campos = ['escala_administrativo', 'escala_planta', 'tipo-empresa', 'sector', 'actividad', 'productos-servicios', 'nivel-empresarial', 'empresa',
      'tributaria', 'pais', 'ciudad', 'estado', 'direccion', 'telefonos', 'codigo_postal', 'moneda'];


    for (let campo of grupo3Campos) {
      const valor = document.getElementById(campo).value;

      if (valor === '') {
        showAlert(`Por favor, ingresa todos los campos de las secciones anteriores`, 'alert-danger');
        return false;
      }
    }
  }

  if (activePanelNum === 3) {
    const grupo4Campos = ['nombrerh', 'emailrh', 'telefonorh', 'puestorh'];

    for (let campo of grupo4Campos) {
      const valor = document.getElementById(campo).value;

      if (valor === '') {
        showAlert(`Por favor, ingresa todos los campos de la cuarta sección`, 'alert-danger');
        return false;
      }
    }

  }

  return true; // Si todas las validaciones pasan, retorna true
}



