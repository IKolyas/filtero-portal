document.addEventListener("DOMContentLoaded", () => {

    let btnEdit = document.querySelectorAll('.js-types-link__edit');
    let form = document.getElementById('form-edit');
    let formEditFields = form.getElementsByTagName('input');
    let formEditFieldsTextarea = form.getElementsByTagName('textarea');
    let formEditFieldsSelect = form.getElementsByTagName('select');
    const buttonClear = document.querySelector('.js-button-clear');
    const buttonSubmit = document.querySelector('.js-button-submit');

    let startEdit = false;

    buttonClear.addEventListener('click', (e) => {
        e.preventDefault();
        if (buttonSubmit.innerHTML == 'Сохранить') {
            buttonSubmit.innerHTML = 'Добавить';
        };
        if(startEdit) {
            form.action = "/admin/create" + form.action.split("/admin/update")[1];
        }
        
        form.querySelectorAll('input').forEach((e) => {
            e.value = "";
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
    })
    
    let addDataToChangeInput = (active_row, edit_fields) => {
        for(let field of edit_fields) {
            let selector = active_row.querySelector(`[data-field='${field.name}']`);
            if(field.tagName === 'INPUT' || field.tagName === 'TEXTAREA') {
                if(selector) {
                    field.value = selector.innerHTML;
                }
            } else if (field.tagName === 'SELECT') {
                field.querySelectorAll('option').forEach(option => {
                    if(selector.hasAttribute('data-target-institute-id')) {
                        option.value !== selector.getAttribute('data-target-institute-id')
                        ? option.removeAttribute('selected')
                        : option.setAttribute('selected', true)
                    } else if(selector.hasAttribute('data-target-type-id')) {
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
        }
    }

    if (btnEdit.length > 0 && formEditFields.length > 0) {
        btnEdit.forEach(btn => {
            btn.addEventListener('click', e => {
                window.scroll(0, 0);
                console.log('---', buttonSubmit);
                if (buttonSubmit.innerHTML == 'Добавить') {
                    buttonSubmit.innerHTML = 'Сохранить';
                };
                if(!startEdit) {
                    form.action = "/admin/update" + form.action.split("/admin/create")[1];
                    startEdit = true;
                }
                let row = btn.parentElement.parentElement;
                addDataToChangeInput(row, formEditFields);
                if(formEditFieldsTextarea.length > 0) {
                    addDataToChangeInput(row, formEditFieldsTextarea);
                }
                if(formEditFieldsSelect.length > 0) {
                    addDataToChangeInput(row, formEditFieldsSelect);
                }
            })
        })
    }
});
