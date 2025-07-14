@extends('admin.layouts.app')
@section('title', 'Form Edit')
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-fluid">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    {{-- <div class="page-pretitle">
                        Overview
                    </div> --}}
                    <h2 class="page-title">
                        Form Create
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.forms.index') }}" class="btn btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 6l-6 6l6 6" />
                            </svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-fluid">
            <div class="row row-deck row-cards">
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Components</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="row g-3 align-items-center">
                                        <div class="col text-truncate">
                                            <button class="btn btn-secondary w-100 btn-add-field" data-type="text"
                                                data-label="Input" data-name="input">Input</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row g-3 align-items-center">
                                        <div class="col text-truncate">
                                            <button class="btn btn-secondary w-100 btn-add-field" data-type="textarea"
                                                data-label="Textarea" data-name="textarea">Textarea</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row g-3 align-items-center">
                                        <div class="col text-truncate">
                                            <button class="btn btn-secondary w-100 btn-add-field" data-type="select"
                                                data-label="Select" data-name="select">Select</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row g-3 align-items-center">
                                        <div class="col text-truncate">
                                            <button class="btn btn-secondary w-100 btn-add-field" data-type="multiselect"
                                                data-label="Multi Select" data-name="multi_select">Multi Select</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row g-3 align-items-center">
                                        <div class="col text-truncate">
                                            <button class="btn btn-secondary w-100 btn-add-field" data-type="checkbox"
                                                data-label="Checkbox" data-name="checkbox">Checkbox</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row g-3 align-items-center">
                                        <div class="col text-truncate">
                                            <button class="btn btn-secondary w-100 btn-add-field" data-type="radio"
                                                data-label="Radio Options" data-name="radio">Radio Options</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row g-3 align-items-center">
                                        <div class="col text-truncate">
                                            <button class="btn btn-secondary w-100 btn-add-field" data-type="file"
                                                data-label="File Input" data-name="file">File Input</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8">
                    <div class="card">
                        <form action="{{ route('admin.forms.update', $form->id) }}" method="post">
                            @csrf
                            <div class="card-header">
                                <h3 class="card-title">Create new form</h3>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <label for="formName" class="form-label">Form Name</label>
                                    <input type="text" class="form-control" id="formName" name="name"
                                        value="{{ $form->name }}" required>
                                </div>

                                <h3>Fields</h3>
                                {{-- <div id="fields-wrapper"></div> --}}

                                <div id="fields-preview-wrapper" class="sortable-list">
                                    <!-- Form fields get appended here visually -->
                                </div>
                                {{-- <button type="button" class="btn btn-secondary mb-3" id="add-field-btn">Add
                                    Field</button> --}}

                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
        <div class="offcanvas-header">
            <h2 class="offcanvas-title" id="offcanvasEndLabel">Edit Field</h2>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="mb-3">
                <label>Label</label>
                <input type="text" class="form-control" id="offcanvas-label">
            </div>
            <div class="mb-3">
                <label>Field Name</label>
                <input type="text" class="form-control" id="offcanvas-name">
            </div>
            <div class="mb-3">
                <label>Validation Rules</label>
                <input type="text" class="form-control" id="offcanvas-validation" placeholder="e.g. required,email">
            </div>
            <div class="mb-3 d-none" id="options-container">
                <label class="form-label">Options</label>
                <div id="options-list"></div>
                <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="add-option-btn">Add Option</button>
            </div>

            <div class="mt-4">
                {{-- <button class="btn btn-primary w-100" type="button" id="save-offcanvas-btn">Save</button> --}}
                <button class="btn btn-primary" type="button" id="save-offcanvas-btn" data-bs-dismiss="offcanvas">Save</button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
 <script>
        const existingFields = @json($fields);
        console.log(existingFields)
        let fieldIndex = 0;
        let editingIndex = null;
        
        function addField(type, fieldData={}) {
            const wrapper = document.createElement('div');
            wrapper.className = 'field-preview border p-3 mb-3';
            wrapper.dataset.index = fieldIndex;
            wrapper.dataset.type = type;

            let label = fieldData?.label || `Untitled ${type}`;
            let name = fieldData?.name || `${type}_${fieldIndex}`;
            let validation = Array.isArray(fieldData?.validation) ? fieldData.validation.join(',') : fieldData?.validation || '';
            let options = fieldData?.options || [];

            // Convert string options (comma-separated or JSON) to array of {key, value}
            if (typeof options === 'string') {
                try {
                    options = JSON.parse(options);
                } catch {
                    options = options.split(',').map(opt => ({ key: opt.trim(), value: opt.trim() }));
                }
            }

            let html = '';
            switch (type) {
                case 'text':
                    html = `<input type="text" class="form-control" disabled placeholder="Input Preview">`;
                    break;
                case 'textarea':
                    html = `<textarea class="form-control" disabled placeholder="Textarea Preview"></textarea>`;
                    break;
                case 'select':
                html = `<select class="form-select" disabled><option>Option 1</option></select>`;
                break;
                case 'radio':
                case 'checkbox':
                    html = `<div><input type="${type}" disabled> <label>Option 1</label></div>`;
                    break;
                default:
                    html = `<input type="text" class="form-control" disabled>`;
            }

            wrapper.innerHTML = `
                <label class="form-label field-label">${label}</label>
                ${html}
                <a class="btn edit-field-btn" data-bs-toggle="offcanvas" href="#offcanvasEnd" role="button" aria-controls="offcanvasEnd">Edit</a>
                <input type="hidden" name="fields[${fieldIndex}][type]" value="${type}">
                <input type="hidden" name="fields[${fieldIndex}][label]" value="${label}">
                <input type="hidden" name="fields[${fieldIndex}][name]" value="${name}">
                <input type="hidden" name="fields[${fieldIndex}][options]" value='${JSON.stringify(options)}'>
                <input type="hidden" name="fields[${fieldIndex}][validation]" value="${validation}">
                ${fieldData?.id ? `<input type="hidden" name="fields[${fieldIndex}][id]" value="${fieldData.id}">` : ''}
                <button type="button" class="btn btn-danger remove-field-btn">Remove Field</button>`;

            document.getElementById('fields-preview-wrapper').appendChild(wrapper);
            fieldIndex++;

            wrapper.querySelector('.remove-field-btn').addEventListener('click', () => {
                wrapper.remove();
            });
        }

        document.querySelectorAll('.btn-add-field').forEach(btn => {
            btn.addEventListener('click', () => {
                const type = btn.dataset.type;
                addField(type);
            });
        });

        existingFields.forEach(field => {
            addField(field.type, field)
        });

        

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
            document.getElementById('options-list').appendChild(createOptionRow());
        });

        document.addEventListener('click', e => {
            if (e.target.classList.contains('edit-field-btn')) {
                    const field = e.target.closest('.field-preview');
                    editingIndex = field.dataset.index;

                    const label = field.querySelector(`input[name="fields[${editingIndex}][label]"]`).value;
                    const name = field.querySelector(`input[name="fields[${editingIndex}][name]"]`).value;
                    const validation = field.querySelector(`input[name="fields[${editingIndex}][validation]"]`).value;
                    const options = field.querySelector(`input[name="fields[${editingIndex}][options]"]`).value;
                    const type = field.dataset.type;

                    document.getElementById('offcanvas-label').value = label;
                    document.getElementById('offcanvas-name').value = name;
                    document.getElementById('offcanvas-validation').value = validation;

                    // Show/hide options section
                    document.getElementById('options-container').classList.toggle('d-none', !['select', 'radio', 'checkbox'].includes(type));

                    const optionsList = document.getElementById('options-list');
                    optionsList.innerHTML = '';
                    try {
                        const parsed = JSON.parse(options || '[]');
                        if (Array.isArray(parsed)) {
                            parsed.forEach(opt => {
                                optionsList.appendChild(createOptionRow(opt.key || '', opt.value || ''));
                            });
                        }
                    } catch (err) {
                        console.warn('Invalid options JSON');
                    }
                }
            });
            // Handle Save
        document.getElementById('save-offcanvas-btn').addEventListener('click', () => {
            if (editingIndex === null) return;
            const label = document.getElementById('offcanvas-label').value;
            const name = document.getElementById('offcanvas-name').value;
            const validation = document.getElementById('offcanvas-validation').value;

            const optionRows = document.querySelectorAll('#options-list .option-row');
            const options = [];
            optionRows.forEach(row => {
                const key = row.querySelector('.option-key').value.trim();
                const value = row.querySelector('.option-value').value.trim();
                if (key || value) {
                    options.push({ key, value });
                }
            });

            const preview = document.querySelector(`.field-preview[data-index="${editingIndex}"]`);
            preview.querySelector('.field-label').innerText = label;
            preview.querySelector(`input[name="fields[${editingIndex}][label]"]`).value = label;
            preview.querySelector(`input[name="fields[${editingIndex}][name]"]`).value = name;
            preview.querySelector(`input[name="fields[${editingIndex}][validation]"]`).value = validation;
            preview.querySelector(`input[name="fields[${editingIndex}][options]"]`).value = JSON.stringify(options);
        });
    </script>
    {{-- <script>
        const allowedTypes = ['text', 'email', 'textarea', 'select', 'checkbox', 'radio'];
        let fieldIndex = 0;
        const existingFields = @json($fields);

        function createField(index, data = {}) {
            const wrapper = document.createElement('div');
            wrapper.classList.add('mb-4', 'border', 'p-3');
            wrapper.dataset.index = index;

            const type = data.type || 'text';
            const label = data.label || '';
            const name = data.name || '';
            const options = data.options || [];
            const validation = data.validation || [];
            const id = data.id ?? '';

            wrapper.innerHTML = `
            ${id ? `<input type="hidden" name="fields[${index}][id]" value="${id}">` : ''}
            <div class="mb-2">
                <label>Field Type</label>
                <select name="fields[${index}][type]" class="form-select" required>
                    ${allowedTypes.map(t => `<option value="${t}" ${t === type ? 'selected' : ''}>${t}</option>`).join('')}
                </select>
            </div>
            <div class="mb-2">
                <label>Label</label>
                <input type="text" name="fields[${index}][label]" class="form-control" value="${label}" required>
            </div>
            <div class="mb-2">
                <label>Name (HTML name attribute)</label>
                <input type="text" name="fields[${index}][name]" class="form-control" value="${name}" required>
            </div>
            <div class="mb-2 options-wrapper" style="display: ${['select', 'checkbox', 'radio'].includes(type) ? 'block' : 'none'};">
                <label>Options (comma separated)</label>
                <input type="text" name="fields[${index}][options]" class="form-control" value="${options.join(', ')}">
            </div>
            <div class="mb-2">
                <label>Validation Rules (comma separated)</label>
                <input type="text" name="fields[${index}][validation]" class="form-control" value="${validation.join(', ')}" placeholder="e.g. required,email">
            </div>
            <button type="button" class="btn btn-danger remove-field-btn">Remove Field</button>
        `;

            // Show/hide options input on type change
            wrapper.querySelector('select').addEventListener('change', e => {
                const optionsWrapper = wrapper.querySelector('.options-wrapper');
                if (['select', 'checkbox', 'radio'].includes(e.target.value)) {
                    optionsWrapper.style.display = 'block';
                } else {
                    optionsWrapper.style.display = 'none';
                    optionsWrapper.querySelector('input').value = '';
                }
            });

            wrapper.querySelector('.remove-field-btn').addEventListener('click', () => {
                wrapper.remove();
            });

            return wrapper;
        }

        const container = document.getElementById('fields-wrapper');
        existingFields.forEach(field => {
            container.appendChild(createField(fieldIndex++, field));
        });

        document.getElementById('add-field-btn').addEventListener('click', () => {
            container.appendChild(createField(fieldIndex++));
        });
    </script> --}}
    
@endpush
