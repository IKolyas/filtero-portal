document.addEventListener("DOMContentLoaded", () => {
  if (document.querySelector('.js-types-link__edit')) {
    
    const links = document.querySelectorAll('.js-types-link__edit');
    const inputs = document.querySelectorAll('.js-types-input');
    const contents = document.querySelectorAll('.js-types-content');
    const notification = document.querySelector('.js-types-notification');
    const form = document.querySelector('.js-types-form');
    const typeId = document.querySelector('.js-type-id');
    const buttonClear = document.querySelector('.js-button-clear');
    
    let actionForm = form.action
    let paramsActionForm = actionForm.split("/admin/create");
    
    typeId.style.display = "none";
    buttonClear.addEventListener('click', (e)=> {
      e.preventDefault();
      inputs.forEach((input)=>{
        input.value = '';
      });
      typeId.value = '';
      typeId.name = '';
      notification.style.visibility = "hidden";

      actionForm = form.action
      paramsActionForm = actionForm.split("/admin/update");
      form.action = "/admin/create" + paramsActionForm[1];
    });
    
    
    let idActiveLink = -1;
    links.forEach((link)=> {
      ++idActiveLink;
      let parentLink = link.parentElement.parentElement
      let idItemLink = idActiveLink;
      let inputLenght = inputs.length;
      let currentIdContent = idItemLink * inputLenght;
      
      const content = contents[idItemLink];
      
      let isFirstClick = true;
      let startIdCurrentContent = 0;
      let idActiveInput = -1;
      link.addEventListener('click', (e) => {
        e.preventDefault();
        let idLink = link.getAttribute('data-id');
        
        inputs.forEach((input)=>{
          ++idActiveInput;
          if (inputs[idActiveInput].tagName == 'INPUT') {
            inputs[idActiveInput].value = content.innerHTML;
            inputs[idActiveInput].value = idActiveInput;
          }

          if (inputs[idActiveInput].classList.contains('js-institute-id')) {
            let valueOptions = inputs[idActiveInput].querySelectorAll('option')
            if (valueOptions.length > 0) {
              let instituteId = parentLink
              .querySelector('[data-target-institute-id]')
              .getAttribute('data-target-institute-id');
              
              valueOptions.forEach((elem)=>{
                // console.log('--', elem);
                if (elem.value != instituteId) {
                  elem.removeAttribute('selected');
                } else { 
                  elem.setAttribute('selected', instituteId);
                }
              });
            }
          }

          if (inputs[idActiveInput].classList.contains('js-types-id')) {
            let valueOptions = inputs[idActiveInput].querySelectorAll('option')
            if (valueOptions.length > 0) {
              let typesId = parentLink
              .querySelector('[data-target-type-id]')
              .getAttribute('data-target-type-id');
              
              valueOptions.forEach((elem)=>{
                if (elem.value != typesId) {
                  elem.removeAttribute('selected');
                } else { 
                  elem.setAttribute('selected', typesId);
                }
              });
            }
          }

          // TODO: da
          if (
            isFirstClick && !inputs[idActiveInput].classList.contains('js-institute-id') &&
            !inputs[idActiveInput].classList.contains('js-types-id')
            ) {
            startIdCurrentContent = (idActiveInput + currentIdContent);
            inputs[idActiveInput].value = contents[startIdCurrentContent].innerHTML;
          } else if (
            !inputs[idActiveInput].classList.contains('js-institute-id') &&
            !inputs[idActiveInput].classList.contains('js-types-id')
          ) {
            startIdCurrentContent = (idActiveInput + currentIdContent);
            inputs[idActiveInput].value = contents[startIdCurrentContent].innerHTML;
          }
        });
        isFirstClick = false;
        idActiveInput = -1;
        
        typeId.value = idLink;
        typeId.name = 'id';
        if (notification.innerHTML.indexOf(content.innerHTML) < 0) {

          notification.innerHTML = 'Идет редактирование "типа активности": ';
          notification.innerHTML = 'Идет редактирование "типа активности": ' + contents[currentIdContent].innerHTML;
        }
        notification.style.visibility = "visible";
        
        form.action = "/admin/update" + paramsActionForm[1];
      });
    });
  }
});


// 