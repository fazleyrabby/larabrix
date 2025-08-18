@extends('admin.layouts.app')
@section('title', 'Product Create')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    @endpush
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
                        Products
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-danger">
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
        <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Create new product</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Product title</label>
                                    <div class="col">
                                        <input type="text" class="form-control" aria-describedby="emailHelp"
                                            placeholder="Product Name" name="title" value="{{ old('title') }}">
                                        <small class="form-hint">
                                            @error('title')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Product slug</label>
                                    <div class="col">
                                        <input type="text" class="form-control" aria-describedby="emailHelp"
                                            placeholder="Product slug" name="slug" value="{{ old('slug') }}">
                                        <small class="form-hint">
                                            @error('slug')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-3 col-form-label required">Product Image</div>
                                    <div class="col">
                                        <button type="button" class="btn btn-primary" id="product-btn"
                                            data-bs-toggle="offcanvas" data-bs-target="#product" aria-controls="product"
                                            aria-expanded="false">
                                            Upload File
                                        </button>

                                        <div id="product-wrapper">
                                        </div>
                                        <small class="form-hint">
                                            @error('image')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Product Sku</label>
                                    <div class="col">
                                        <input type="text" class="form-control" aria-describedby=""
                                            placeholder="Product Sku" name="sku" value="{{ old('sku') }}">
                                        <small class="form-hint">
                                            @error('sku')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Price</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="price" placeholder="price"
                                            value="">
                                        <small class="form-hint">
                                            @error('price')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Category</label>
                                    <div class="col">
                                        <select type="text" class="form-select" id="categories" name="category_id"
                                            value="">
                                            @foreach($categories as $index => $value)
                                                <option value="{{ $index }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <small class="form-hint">
                                            @error('category_id')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Brand</label>
                                    <div class="col">
                                        <select type="text" class="form-select" id="brands" name="brand_id"
                                            value="">
                                            @foreach($brands as $index => $value)
                                                <option value="{{ $index }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <small class="form-hint">
                                            @error('brand_id')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Description</label>
                                    <div class="col">
                                        {{-- <textarea name="description" class="form-control" id="" cols="30" rows="10"></textarea> --}}
                                        <textarea id="hugerte-mytextarea" name="description">{{ old('description') }}</textarea>
                                        <small class="form-hint">
                                            @error('description')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Short Descripion</label>
                                    <div class="col">
                                        <textarea name="short_description" class="form-control" id="" cols="30" rows="3"></textarea>
                                        <small class="form-hint">
                                            @error('short_description')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Is Pc Component</label>
                                    <div class="col">
                                        <select type="text" class="form-select" id="is_pc_component" name="is_pc_component">
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Compatibility Key</label>
                                    <div class="col">
                                        <input type="text" class="form-control" aria-describedby=""
                                            placeholder="Compatibility Key" name="compatibility_key" value="{{ old('compatibility_key') }}">
                                        <small class="form-hint">
                                            @error('compatibility_key')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Type</label>
                                    <div class="col">
                                        <select type="text" class="form-select" id="type" name="type">
                                            <option value="simple">Simple</option>
                                            <option value="variable">Variable</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Additional Info</label>
                                    <div class="col">
                                        <table class="table table-bordered" id="extra-details">
                                            <thead>
                                                <tr>
                                                    <th style="width: 40%">Key</th>
                                                    <th style="width: 40%">Value</th>
                                                    <th style="width: 20%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="detail-row">
                                                    <td><input type="text" name="detail_key[]" class="form-control" placeholder="Key"></td>
                                                    <td><input type="text" name="detail_value[]" class="form-control" placeholder="Value"></td>
                                                    <td><button type="button" class="btn btn-danger btn-sm remove-detail">X</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="button" id="add-detail" class="btn btn-info">+ Add Detail</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 variants d-none">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Variation</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="mb-3">
                                            <label class="form-label">Attribute Option</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Attribute Value</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="attribute-values-wrapper">
                                    <div class="row attribute-value-row">
                                        <div class="col-md-5 mb-3">
                                            <select class="form-control variant-select" id="variant-0">
                                                <option value="" selected>Select</option>
                                                @foreach ($attributes as $attribute)
                                                    <option value="{{ $attribute->id }}"
                                                        data-values='@json($attribute->values->pluck('title', 'id'))'>{{ $attribute->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5 mb-3">
                                            <select class="form-select variant-values" name="variant[0][value]"
                                                placeholder="Select values" id="variant-0-values" value=""
                                                multiple>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-danger remove-row">Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-dark" id="add-new">Add New</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 variant-combo d-none">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Variant</th>
                                                <th>Price</th>
                                                <th>SKU</th>
                                                <th>Image</th>
                                            </tr>
                                        </thead>
                                        <tbody id="variant-combinations-wrapper">
                                            <!-- JS-generated rows go here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>

        </form>
    </div>

    @include('admin.components.media.popup', [
        'modalId' => 'product',
        'inputType' => 'single',
        'imageInputName' => 'image',
    ])
    <template id="media-template">
        @include('admin.components.media.popup', [
            'modalId' => 'product-variant-__INDEX__',
            'inputType' => 'single',
            'imageInputName' => 'combinations[__INDEX__][image]',
        ])
    </template>
    <div id="product-media-container"></div>
@endsection


@push('scripts')
    <script src="{{ asset('admin/dist/libs/hugerte/hugerte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        // Global: define setupVariantSelects
        function setupVariantSelects() {
            const valueChoicesMap = {};

            document.querySelectorAll('.variant-values').forEach((el) => {
                if (!el.dataset.initialized) {
                    const instance = new Choices(el, {
                        removeItemButton: true,
                        placeholder: true,
                        searchEnabled: true,
                    });
                    el.dataset.initialized = true;
                    valueChoicesMap[el.id] = instance;
                }
            });

            document.querySelectorAll('.variant-select').forEach((selectEl) => {
                if (!selectEl.dataset.initialized) {
                    const instance = new Choices(selectEl, {
                        allowHTML: false,
                        searchEnabled: true,
                        placeholder: true,
                    });
                    selectEl.dataset.initialized = true;

                    selectEl.addEventListener('change', function() {
                        const selected = this.selectedOptions[0];
                        const valueSelectId = this.id + '-values';
                        const valueSelect = document.getElementById(valueSelectId);
                        const choicesInstance = valueChoicesMap[valueSelectId];

                        if (!choicesInstance || !selected || !selected.dataset.values) return;

                        try {
                            const values = JSON.parse(selected.dataset.values);

                            // Remove all existing options and values
                            choicesInstance.clearStore();
                            choicesInstance.clearChoices();

                            const newOptions = Object.entries(values).map(([value, label]) => ({
                                value,
                                label,
                                selected: false,
                                disabled: false,
                            }));

                            choicesInstance.setChoices(newOptions, 'value', 'label', true);
                        } catch (err) {
                            console.warn("Invalid data-values JSON", selected.dataset.values);
                        }
                    });
                }
            });
        }

        function setupVariantChangeListeners() {
            const run = () => generateVariantCombinations();

            document.querySelectorAll('.variant-select').forEach((el) =>
                el.addEventListener('change', run)
            );

            document.querySelectorAll('.variant-values').forEach((el) =>
                el.addEventListener('change', run)
            );
            run();
        }

        function generateVariantCombinations() {
            const attributeValuePairs = [];

            document.querySelectorAll('.attribute-value-row').forEach((row) => {
                const select = row.querySelector('.variant-select');
                const values = row.querySelector('.variant-values');

                const attributeName = select?.selectedOptions[0]?.textContent?.trim();
                const selectedValueIds = [...values?.selectedOptions || []].map(o => o.value);
                const selectedValueNames = [...values?.selectedOptions || []].map(o => o.textContent.trim());

                if (attributeName && selectedValueIds.length) {
                    attributeValuePairs.push({
                        attribute: attributeName,
                        valueIds: selectedValueIds,
                        valueNames: selectedValueNames
                    });
                }
            });

            // 🔥 Early exit if nothing selected
            if (attributeValuePairs.length === 0) return;

            const idArrays = attributeValuePairs.map(p => p.valueIds);
            const nameArrays = attributeValuePairs.map(p => p.valueNames);

            const combinationsIds = getCombinations(idArrays);
            const combinationsNames = getCombinations(nameArrays);

            const wrapper = document.getElementById('variant-combinations-wrapper');
            wrapper.innerHTML = '';

            combinationsIds.forEach((comboIds, index) => {
                const comboNames = combinationsNames[index];
                const label = comboNames.join(' / ');

                // ⛏️ Fix: generate all id inputs
                const idHTML = comboIds.map(id =>
                    `<input type="hidden" name="combinations[${index}][ids][]" value="${id}">`
                ).join('');
                const row = document.createElement('tr');

                row.innerHTML = `<td>
                        <label class="form-label"><strong>${label}</strong></label>
                        <input type="hidden" name="combinations[${index}][label]" value="${label}">
                        ${idHTML}
                    </td>
                    <td>
                        <input type="number" name="combinations[${index}][price]" class="form-control" required>
                    </td>
                    <td>
                        <input type="text" name="combinations[${index}][sku]" class="form-control" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary" id="product-variant-${index}-btn"
                                data-bs-toggle="offcanvas" data-bs-target="#product-variant-${index}"
                                aria-controls="product-variant-${index}" aria-expanded="false">
                                Upload File
                            </button>

                            <div id="product-variant-${index}-wrapper">  
                            </div>
                    </td>
            `;

                const mediaContainer = document.getElementById('product-media-container');
                const existingMedia = mediaContainer.querySelector(`#product-variant-${index}`);
                if (!existingMedia) {
                    const template = document.getElementById('media-template').innerHTML;
                    const rendered = template.replace(/__INDEX__/g, index);
                    mediaContainer.insertAdjacentHTML('beforeend', rendered);

                    const newModal = document.getElementById(`product-variant-${index}`);
                    if (newModal) {
                        const offcanvas = new tabler.Offcanvas(newModal);
                        newModal.addEventListener('shown.bs.offcanvas', function() {
                            const container = newModal.querySelector(`#ajax-container-${newModal.id}`);
                            const route = newModal.getAttribute('data-route');
                            if (container && route) {
                                loadData(`${route}`, container);
                            } else {
                                console.error('Missing required elements or data for modal:', newModal.id, {
                                    container,
                                    route,
                                    folderId
                                });
                            }
                        });
                    }
                }


                wrapper.appendChild(row)
            });
        }

        function getCombinations(arrays) {
            if (!arrays.length) return [];
            let result = [
                []
            ];

            arrays.forEach(array => {
                if (!Array.isArray(array)) array = [array];
                const temp = [];
                result.forEach(r => {
                    array.forEach(value => {
                        temp.push(r.concat(value));
                    });
                });
                result = temp;
            });

            return result;
        }

        document.addEventListener("DOMContentLoaded", function() {
            let el;
            if (window.TomSelect) {
                new TomSelect(el = document.getElementById('categories'), {
                    allowEmptyOption: true,
                    create: true
                });
                window.TomSelect && (new TomSelect(el = document.getElementById('brands'), {
                    allowEmptyOption: true,
                    create: true
                }));
            }

            setupVariantSelects();
            setupVariantChangeListeners();

            const type = document.getElementById('type');
            const variants = document.querySelector('.variants');
            const variantCombinations = document.querySelector('.variant-combo')
            type.addEventListener('change', function() {
                if (this.value == 'variable') {
                    variants.classList.remove('d-none')
                    variantCombinations.classList.remove('d-none')
                } else {
                    variants.classList.add('d-none')
                    variantCombinations.classList.add('d-none')
                }
            })
        });

        let newIndex = 1;

        document.getElementById('add-new').addEventListener('click', function() {
            const wrapper = document.getElementById('attribute-values-wrapper');

            const row = document.createElement('div');
            row.classList.add('row', 'attribute-value-row');

            const variantSelectId = `variant-${newIndex}`;
            const variantValuesId = `variant-${newIndex}-values`;

            row.innerHTML = `
            <div class="col-md-5 mb-3">
                <select name="variant[new_${newIndex}][option]" class="form-control variant-select" id="${variantSelectId}">
                    <option value="" selected>Select</option>
                    @foreach ($attributes as $attribute)
                        <option value="{{ $attribute->id }}"
                            data-values='@json($attribute->values->pluck('title', 'id'))'>{{ $attribute->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5 mb-3">
                <select class="form-select variant-values" name="variant[new_${newIndex}][value]" placeholder="Select values" id="${variantValuesId}" value="" multiple></select>
            </div>
            <div class="col-md-2 mb-3">
                <button type="button" class="btn btn-danger remove-row">Remove</button>
            </div>
        `;

            wrapper.appendChild(row);
            newIndex++;
            setupVariantSelects(); // Now works globally
            setupVariantChangeListeners();
        });

        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-row')) {
                e.target.closest('.attribute-value-row').remove();
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const tableBody = document.querySelector('#extra-details tbody');
            const addBtn = document.getElementById('add-detail');

            addBtn.addEventListener('click', function () {
                const newRow = document.createElement('tr');
                newRow.classList.add('detail-row');
                newRow.innerHTML = `
                    <td><input type="text" name="detail_key[]" class="form-control" placeholder="Key"></td>
                    <td><input type="text" name="detail_value[]" class="form-control" placeholder="Value"></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-detail">X</button></td>
                `;
                tableBody.appendChild(newRow);
            });

            tableBody.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-detail')) {
                    e.target.closest('tr').remove();
                }
            });

            let options={selector:"#hugerte-mytextarea",height:600,menubar:true,statusbar:true,license_key:"gpl",plugins:["fullscreen","advlist","autolink","lists","link","image","charmap","preview","anchor","searchreplace","visualblocks","code","fullscreen","insertdatetime","media","table","code","help","wordcount","codesample","markdown"],toolbar:"undo redo | formatselect |bold italic backcolor | alignleft aligncenteralignright alignjustify | bullist numlist outdent indent |code codesample removeformat markdown help fullscreen",content_style:"body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }"};
            if (localStorage.getItem("tablerTheme") === "dark") {
                options.skin = "oxide-dark";
                options.content_css = "dark";
            }
            hugeRTE.init(options);
        });
    </script>
@endpush
