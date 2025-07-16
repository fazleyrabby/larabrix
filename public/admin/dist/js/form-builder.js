"use strict";

const existingFields = JSON.parse(document.getElementById('existingFields')?.value || "[]");
let fieldIndex = 0;
let editingIndex = null;

const offcanvasElements = {
    label: document.getElementById('offcanvas-label'),
    name: document.getElementById('offcanvas-name'),
    placeholder: document.getElementById('offcanvas-placeholder'),
    validation: document.getElementById('offcanvas-validation'),
    optionsList: document.getElementById('options-list'),
    container: document.getElementById('options-container'),
    saveBtn: document.getElementById('save-offcanvas-btn')
};

function createFieldElement(type, fieldData = {}) {
    const wrapper = document.createElement('div');
    wrapper.className = 'field-preview border p-3 mb-3';
    wrapper.dataset.index = fieldIndex;
    wrapper.dataset.type = type;

    let label = fieldData?.label || `Untitled ${type}`;
    let placeholder = fieldData?.placeholder || `Untitled ${type}`;
    let name = fieldData?.name || `${type}_${fieldIndex}`;
    const validation = Array.isArray(fieldData?.validation) ? fieldData.validation.join(',') : (fieldData.validation || '');
    const options = parseOptions(fieldData.options);

    let html = '';
    switch (type) {
        case 'text': html = `<input type="text" class="form-control" placeholder="${placeholder || 'Input Preview'}">`; break;
        case 'textarea': html = `<textarea class="form-control" placeholder="${placeholder || 'Textarea Preview'}"></textarea>`; break;
        case 'file': html = '<input type="file" class="form-control">'; break;
        case 'select':
        case 'multiselect':
        case 'radio':
        case 'checkbox':
            html = renderOptionsHTML(type, name, placeholder, options);
            break;
        default: html = '<input type="text" class="form-control">';
    }

    wrapper.innerHTML = `
                <label class="form-label field-label">${label}</label>
                ${html}
                <div class="edit-btns"><a class="edit-field-btn" data-bs-toggle="offcanvas" href="#offcanvasEnd" role="button" aria-controls="offcanvasEnd"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg></a>
                <span type="button" class="remove-field-btn"><svg xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg></span></div>
                <input type="hidden" name="fields[${fieldIndex}][type]" value="${type}">
                <input type="hidden" name="fields[${fieldIndex}][label]" value="${label}">
                <input type="hidden" name="fields[${fieldIndex}][placeholder]" value="${placeholder}">
                <input type="hidden" name="fields[${fieldIndex}][name]" value="${name}">
                <input type="hidden" name="fields[${fieldIndex}][options]" value='${JSON.stringify(options)}'>
                <input type="hidden" name="fields[${fieldIndex}][validation]" value="${validation}">
                ${fieldData?.id ? `<input type="hidden" name="fields[${fieldIndex}][id]" value="${fieldData.id}">` : ''}
                `;

    wrapper.querySelector('.remove-field-btn').addEventListener('click', () => {
        wrapper.remove();
    });
    return wrapper;
}

function addField(type, field = {}) {
    const newField = createFieldElement(type, field);
    document.getElementById('fields-preview-wrapper').appendChild(newField);
    fieldIndex++;
}

function renderOptionsHTML(type, name, placeholder, options) {
    let html = '';
    if (['select', 'multiselect'].includes(type)) {
        html += `<option>${placeholder || 'Default Option'}</option>`;
        options.forEach(opt => {
            html += `<option value="${opt.key}">${opt.value}</option>`;
        });
        return `<select class="form-select">${html}</select>`;
    }
    if (['radio', 'checkbox'].includes(type)) {
        options.forEach(opt => {
            html += `<label class="form-check form-check-inline">
                <input class="form-check-input" type="${type}" name="${name}" value="${opt.key}">
                <span class="form-check-label">${opt.value}</span>
            </label>`;
        });
        return `<div class="${type}-container">${html || `<label class=\"form-check form-check-inline\"><input class=\"form-check-input\" type=\"${type}\" name=\"${name}\"><span class=\"form-check-label\">Default Option</span></label>`}</div>`;
    }
    return '';
}

function parseOptions(input) {
    if (typeof input === 'string') {
        try {
            return JSON.parse(input);
        } catch {
            return input.split(',').map(opt => ({ key: opt.trim(), value: opt.trim() }));
        }
    }
    return Array.isArray(input) ? input : [];
}
// Create option input row
function createOptionRow(key = '', value = '') {
    const div = document.createElement('div');
    div.classList.add('d-flex', 'gap-2', 'mb-2', 'option-row');
    div.innerHTML = `
        <input type="text" class="form-control form-control-sm option-key" placeholder="Key" value="${key}">
        <input type="text" class="form-control form-control-sm option-value" placeholder="Value" value="${value}">
        <button type="button" class="btn btn-sm btn-danger remove-option-btn">&times;</button>
    `;
    div.querySelector('.remove-option-btn').addEventListener('click', () => div.remove());
    return div;
}
// Add new option row in offcanvas
document.getElementById('add-option-btn').addEventListener('click', () => {
    offcanvasElements.optionsList.appendChild(createOptionRow());
});

document.body.addEventListener('click', (e) => {
    const editBtn = e.target.closest('.edit-field-btn');
    if (!editBtn) return;
    const field = editBtn.closest('.field-preview');
    editingIndex = field.dataset.index;

    const getInputValue = name => field.querySelector(`[name="fields[${editingIndex}][${name}]"]`).value;
    const type = field.dataset.type;

    offcanvasElements.label.value = getInputValue('label');
    offcanvasElements.name.value = getInputValue('name');
    offcanvasElements.placeholder.value = getInputValue('placeholder');
    offcanvasElements.validation.value = getInputValue('validation');
    offcanvasElements.saveBtn.dataset.type = type;


    offcanvasElements.container.classList.toggle('d-none', !['select', 'radio', 'checkbox', 'multiselect'].includes(type));
    offcanvasElements.optionsList.innerHTML = '';
    parseOptions(getInputValue('options')).forEach(opt => {
        offcanvasElements.optionsList.appendChild(createOptionRow(opt.key, opt.value));
    });
});
// Handle Save
offcanvasElements.saveBtn.addEventListener('click', (e) => {
    if (editingIndex === null) return;

    const label = offcanvasElements.label.value;
    const name = offcanvasElements.name.value;
    const placeholder = offcanvasElements.placeholder.value;
    const validation = offcanvasElements.validation.value;
    const type = e.target.dataset.type;

    const options = [...offcanvasElements.optionsList.querySelectorAll('.option-row')].map(row => {
        return {
            key: row.querySelector('.option-key').value.trim(),
            value: row.querySelector('.option-value').value.trim()
        };
    }).filter(opt => opt.key || opt.value);

    const preview = document.querySelector(`.field-preview[data-index="${editingIndex}"]`);
    preview.querySelector('.field-label').innerText = label;
    
    ['label', 'name', 'placeholder', 'validation'].forEach(field => {
        preview.querySelector(`[name="fields[${editingIndex}][${field}]"]`).value = {
            label,
            name,
            placeholder,
            validation
        }[field];
    });
    preview.querySelector(`[name="fields[${editingIndex}][options]"]`).value = JSON.stringify(options);

    const html = renderOptionsHTML(type, name, placeholder, options);
    if (['select', 'multiselect'].includes(type)) {
        preview.querySelector('select.form-select').innerHTML = html;
    } else if (['radio', 'checkbox'].includes(type)) {
        preview.querySelector(`.${type}-container`).innerHTML = html;
    } else if(type == 'text') {
        preview.querySelector('input[type="text"]').setAttribute('placeholder', placeholder); 
    }else if(type == 'textarea'){
        preview.querySelector('textarea').setAttribute('placeholder', placeholder);
    }
});

document.querySelectorAll('.btn-add-field').forEach(btn => {
    btn.addEventListener('click', () => addField(btn.dataset.type));
});

existingFields.forEach(field => addField(field.type, field));

new Sortable(document.querySelector('.components'), {
    ghostClass: 'sortable-ghost',
    group: {
        name: 'shared',
        pull: 'clone',
        put: false
    },
    animation: 150,
    sort: false
});

new Sortable(document.querySelector('.sortable-list'), {
    group: 'shared',
    animation: 150,
    fallbackOnBody: true,
    swapThreshold: 0.5,
    fallbackTolerance: 10,
    onAdd: function (evt) {
        const type = evt.item.querySelector('.btn-add-field').dataset.type;
        const dropIndex = evt.newIndex;
        evt.item.remove();
        const newField = createFieldElement(type);
        const container = document.querySelector('.sortable-list');
        const children = container.children;
        dropIndex >= children.length ? container.appendChild(newField) : container.insertBefore(newField, children[dropIndex]);
        fieldIndex++;
    }
});
