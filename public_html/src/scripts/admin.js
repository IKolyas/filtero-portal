document.addEventListener("DOMContentLoaded", () => {
  console.log('adminJS');

  let btnEdit = document.querySelectorAll('.js-types-link__edit');
  let form = document.getElementById('form-edit');

  if (form && btnEdit.length > 0) {
      let formEditFields = form.getElementsByTagName('input');
      let formEditFieldsTextarea = form.getElementsByTagName('textarea');
      let formEditFieldsSelect = form.getElementsByTagName('select');

      const buttonClear = document.querySelector('.js-button-clear');
      const buttonSubmit = document.querySelector('.js-button-submit');
      const notification = document.querySelector('.js-types-notification');
      
      let startEdit = false;
      
      buttonClear.addEventListener('click', (e) => {
          e.preventDefault();
          if (buttonSubmit.innerHTML == 'Сохранить') {
              buttonSubmit.innerHTML = 'Добавить';
          };
          if (startEdit) {
              form.action = "/admin/create" + form.action.split("/admin/update")[1];
          }
          
          form.querySelectorAll('input').forEach((e) => {
              if (e.id === 'password') {
                  e.disabled = false;
              }
              if (e.id === 'is_admin') {
                  e.disabled = false;
              }
              if (e.name != 'user_id') { // делаю проверку чтобы не очистить поле у input name user_id так как оно нужно при добавление в БД
                  e.value = "";
              }
          });
          form.querySelectorAll('textarea').forEach((e) => {
              e.value = "";
          });
          form.querySelectorAll('select').forEach((e) => {
              e.querySelectorAll('option').forEach((option, key) => {
                  key !== 0 ? option.removeAttribute('selected') : option.setAttribute('selected', true)
              })
          })
          
          startEdit = false;
          notification.innerHTML = '';
          clearErrorsNotification();
      })

      let addDataToChangeInput = (active_row, edit_fields) => {
          for (let field of edit_fields) {
              let selector = active_row.querySelector(`[data-field='${field.name}']`);
              if (field.tagName === 'INPUT' || field.tagName === 'TEXTAREA') {
                  if (selector) {
                      field.value = selector.innerHTML;
                  }
              } else if (field.tagName === 'SELECT') {
                  field.querySelectorAll('option').forEach(option => {
                      if (selector.hasAttribute('data-target-institute-id')) {
                          option.value !== selector.getAttribute('data-target-institute-id')
                              ? option.removeAttribute('selected')
                              : option.setAttribute('selected', true)
                      } else if (selector.hasAttribute('data-target-type-id')) {
                          option.value !== selector.getAttribute('data-target-type-id')
                              ? option.removeAttribute('selected')
                              : option.setAttribute('selected', true)
                      } else {
                          option.value !== selector.innerHTML
                              ? option.removeAttribute('selected')
                              : option.setAttribute('selected', true)
                      }

                  })
              }

              if (field.id === 'password') {
                  field.disabled = true;
              }
              if (field.id === 'is_admin') {
                  field.disabled = true;
              }
          }
      }

      if (btnEdit.length > 0 && formEditFields.length > 0) {
          btnEdit.forEach(btn => {
              btn.addEventListener('click', e => {
                  clearErrorsNotification();
                  window.scroll(0, 0);
                  if (buttonSubmit.innerHTML == 'Добавить') {
                      buttonSubmit.innerHTML = 'Сохранить';
                  };
                  if (!startEdit) {
                      form.action = "/admin/update" + form.action.split("/admin/create")[1];
                      startEdit = true;
                  }
                  let row = btn.parentElement.parentElement;
                  addDataToChangeInput(row, formEditFields);
                  if (formEditFieldsTextarea.length > 0) {
                      addDataToChangeInput(row, formEditFieldsTextarea);
                  }
                  if (formEditFieldsSelect.length > 0) {
                      addDataToChangeInput(row, formEditFieldsSelect);
                  }
                  
                  // Удаляем из html кнопки редактировать и удалить
                  let editLineTable = '';
                  row.querySelectorAll('th').forEach((elem) => {
                      elem.classList.add("col-1");
                      editLineTable+=elem.outerHTML;
                  });
                  row.querySelectorAll('td').forEach((elem) => {
                      if (elem.querySelector('i') == null) { // проверяем чтобы не было кнопки  редактировать
                          editLineTable+=elem.outerHTML;
                      }
                  });

                  let htmlStartTable = `<span style="color: green">Редактирование:</span><br><table class="table table-striped table-hover align-middle"><tbody>`
                  let htmlEndTable = `</tbody></table>`;
                  let htmlRow = editLineTable;
                  notification.innerHTML = htmlStartTable + htmlRow + htmlEndTable;
              })
          })
      }
  }

  function clearErrorsNotification() {
      if (document.querySelector('.js-errors-notification')) {
          const errorsNotification = document.querySelectorAll('.js-errors-notification');
          errorsNotification.forEach(element => {
              element.innerHTML = '';
          })
      }
  }
});
