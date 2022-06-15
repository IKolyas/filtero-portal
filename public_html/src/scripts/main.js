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
        
        inputs.forEach(()=>{
          ++idActiveInput;
          inputs[idActiveInput].value = content.innerHTML;
          inputs[idActiveInput].value = idActiveInput;
          
          if (isFirstClick) {
            startIdCurrentContent = (idActiveInput + currentIdContent);
            inputs[idActiveInput].value = contents[startIdCurrentContent].innerHTML;
          } else {
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