@extends('admin.layouts.app')
@section('title', 'Form Create')
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    {{-- <div class="page-pretitle">
                        Overview
                    </div> --}}
                    <h2 class="page-title">
                        Form
                    </h2>
                </div>

                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.products.categories.index') }}" class="btn btn-danger">
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
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.forms.store') }}" method="post">
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
                                        value="{{ old('name') }}" required>
                                </div>

                                <h3>Fields</h3>
                                <div id="fields-wrapper"></div>

                                <button type="button" class="btn btn-secondary mb-3" id="add-field-btn">Add
                                    Field</button>

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

@endsection

@push('scripts')
    <script>
        const allowedTypes = ['text', 'email', 'textarea', 'select', 'checkbox', 'radio'];
        let fieldIndex = 0;

        function createField(index, data = {}) {
            const wrapper = document.createElement('div');
            wrapper.classList.add('mb-4', 'border', 'p-3');
            wrapper.dataset.index = index;

            const type = data.type || 'text';
            const label = data.label || '';
            const name = data.name || '';
            const options = data.options || [];
            const validation = data.validation || [];

            wrapper.innerHTML = `
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

        document.getElementById('add-field-btn').addEventListener('click', () => {
            const container = document.getElementById('fields-wrapper');
            container.appendChild(createField(fieldIndex++));
        });
    </script>
@endpush
