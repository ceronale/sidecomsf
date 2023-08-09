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
      setActiveStep(activePanelNum);
      setActivePanel(activePanelNum);

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
      showSweetAlert('Por favor, ingresa el nombre de la empresa', 'error');
      return false;
    }
    if (tributaria === '') {
      showSweetAlert('Por favor, ingresa el número de tributaria', 'error');
      return false;
    }
    if (pais === '') {
      showSweetAlert('Por favor, selecciona un país', 'error');
      return false;
    }
    if (moneda === '') {
      showSweetAlert('Por favor, ingresa la moneda', 'error');
      return false;
    }
    if (ciudad === '') {
      showSweetAlert('Por favor, ingresa la ciudad', 'error');
      return false;
    }
    if (estado === '') {
      showSweetAlert('Por favor, ingresa el estado', 'error');
      return false;
    }
    if (direccion === '') {
      showSweetAlert('Por favor, ingresa la dirección', 'error');
      return false;
    }

    if (telefonos === '') {
      showSweetAlert('Por favor, ingresa los teléfonos', 'error');
      return false;
    }
    if (codigoPostal === '') {
      showSweetAlert('Por favor, ingresa el código postal', 'error');
      return false;
    }

  }

  // Validación para el Grupo 2
  if (activePanelNum === 1) {
    var tipoEmpresa = document.getElementById('tipo-empresa').value;
    var sector = document.getElementById('sector').value;
    var actividad = document.getElementById('actividad').value;
    var opcionPersonalizada = document.getElementById('opcionPersonalizada').value;
    var opcionPersonalizada2 = document.getElementById('opcionPersonalizada2').value;
    var productosServicios = document.getElementById('productos-servicios').value;



    if (tipoEmpresa === '') {
      showSweetAlert('Por favor, selecciona el tipo de empresa', 'error');
      return false;
    }
    if (sector === '') {
      showSweetAlert('Por favor, ingresa el sector', 'error');
      return false;
    }

    if (actividad === '' && opcionPersonalizada === '') {
      showSweetAlert('Por favor, ingresa la actividad', 'error');
      return false;
    }
    if (productosServicios === '' && opcionPersonalizada2 === '') {
      showSweetAlert('Por favor, ingresa los productos o servicios', 'error');
      return false;
    }

  }
  if (activePanelNum === 2) {

    var mision = document.getElementById('mision').value;
    var vision = document.getElementById('vision').value;
    var valores = document.getElementById('valores').value;


    if (mision === '') {
      showSweetAlert('Por favor, ingresa la misión', 'error');
      return false;
    }
    if (vision === '') {
      showSweetAlert('Por favor, ingresa la visión', 'error');
      return false;
    }
    if (valores === '') {
      showSweetAlert('Por favor, ingresa los valores', 'error');
      return false;
    }
  }


  if (activePanelNum === 3) {

    var nombrerh = document.getElementById('nombrerh').value;
    var emailrh = document.getElementById('emailrh').value;
    var telefonorh = document.getElementById('telefonorh').value;
    var puestorh = document.getElementById('puestorh').value;

    if (nombrerh === '') {
      showSweetAlert('Por favor, ingresa el nombre del responsable de recursos humanos', 'error');
      return false;
    }
    if (emailrh === '') {
      showSweetAlert('Por favor, ingresa el email del responsable de recursos humanos', 'error');
      return false;
    }
    if (telefonorh === '') {
      showSweetAlert('Por favor, ingresa el teléfono del responsable de recursos humanos', 'error');
      return false;
    }
    if (puestorh === '') {
      showSweetAlert('Por favor, ingresa el puesto del responsable de recursos humanos', 'error');
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
        showSweetAlert(`Por favor, ingresa todos los campos de la primera sección`, 'error');
        return false;
      }
    }
  }

  if (activePanelNum === 1) {
    const grupo2Campos = ['tipo-empresa', 'sector', 'nivel-empresarial'];

    for (let campo of grupo2Campos) {
      const valor = document.getElementById(campo).value;

      if (valor === '') {
        showSweetAlert(`Por favor, ingresa todos los campos de la segunda sección`, 'error');
        return false;
      }
    }

    var actividad = document.getElementById('actividad').value;
    var opcionPersonalizada = document.getElementById('opcionPersonalizada').value;
    var opcionPersonalizada2 = document.getElementById('opcionPersonalizada2').value;
    var productosServicios = document.getElementById('productos-servicios').value;

    if (actividad === '' && opcionPersonalizada === '') {
      showSweetAlert(`Por favor, ingresa todos los campos de la segunda sección`, 'error');
      return false;
    }
    if (productosServicios === '' && opcionPersonalizada2 === '') {
      showSweetAlert(`Por favor, ingresa todos los campos de la segunda sección`, 'error');
      return false;
    }

  }



  if (activePanelNum === 2) {
    const grupo4Campos = ['mision', 'vision', 'valores'];

    for (let campo of grupo4Campos) {
      const valor = document.getElementById(campo).value;

      if (valor === '') {
        showSweetAlert(`Por favor, ingresa todos los campos de la tercera sección`, 'error');
        return false;
      }
    }

  }

  return true; // Si todas las validaciones pasan, retorna true
}