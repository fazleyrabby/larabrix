@extends('admin.layouts.app')
@section('title', 'Product Edit')
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
        <form action="{{ route('admin.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Edit form</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Product title</label>
                                    <div class="col">
                                        <input type="text" class="form-control" aria-describedby="emailHelp"
                                            placeholder="Product Name" name="title" value="{{ $product->title }}">
                                        <small class="form-hint">
                                            @error('title')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-3 col-form-label required">Product Image</div>
                                    <div class="col">
                                        <input type="file" class="form-control" name="image" />
                                        <small class="form-hint">
                                            @error('image')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                        <div>Previous Image:</div>
                                        @if (isset($product->image) && filled($product->image))
                                            <img width="100" src="{{ asset($product->image) }}" alt="">
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Product Sku</label>
                                    <div class="col">
                                        <input type="text" class="form-control" aria-describedby=""
                                            placeholder="Product Sku" name="sku" value="{{ $product->sku }}">
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
                                            value="{{ $product->price }}">
                                        <small class="form-hint">
                                        </small>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Category</label>
                                    <div class="col">
                                        <select type="text" class="form-select" id="categories" name="category_id"
                                            value="">
                                            @foreach ($categories as $index => $value)
                                                <option value="{{ $index }}" @selected($index == $product->category_id)>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Descripion</label>
                                    <div class="col">
                                        <textarea name="description" class="form-control" id="" cols="30" rows="10">{{ $product->description }}</textarea>
                                        <small class="form-hint">
                                            @error('description')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Type</label>
                                    <div class="col">
                                        <select type="text" class="form-select" id="type" name="type">
                                            <option value="simple" @selected($product->type == 'simple')>Simple</option>
                                            <option value="variable" @selected($product->type == 'variable')>Variable</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 variants {{ $product->type == 'simple' ? 'd-none' : '' }}">
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
                                @forelse ($attrRows as $index => $attrRow)
                                <div class="row attribute-value-row">
                                    <div class="col-md-5 mb-3">
                                        <select class="form-control variant-select" id="variant-{{ $index }}">
                                            <option value="" selected>Select</option>
                                            @foreach ($attributes as $attribute)
                                                <option value="{{ $attribute->id }}" @selected($attribute->id == $attrRow['attr_id'])
                                                    data-values='@json($attribute->values->pluck("title", "id"))'>{{ $attribute->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5 mb-3">
                                        <select class="form-select variant-values" name="" placeholder="Select values" id="variant-{{ $index }}-values" value="" multiple
                                        data-selected-values='@json(array_map("strval", $attrRow["attr_value_ids"]))'
                                        >
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <button type="button" class="btn btn-danger remove-row">Remove</button>
                                    </div>
                                </div>

                                @empty
                                <div class="row attribute-value-row">
                                    <div class="col-md-5 mb-3">
                                        <select class="form-control variant-select" id="variant-0">
                                            <option value="" selected>Select</option>
                                            @foreach ($attributes as $attribute)
                                                <option value="{{ $attribute->id }}"
                                                    data-values='@json($attribute->values->pluck("title", "id"))'>{{ $attribute->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5 mb-3">
                                        <select class="form-select variant-values" name="variant[0][value]" placeholder="Select values" id="variant-0-values" value="" multiple>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <button type="button" class="btn btn-danger remove-row">Remove</button>
                                    </div>
                                </div>

                                @endforelse

                            </div>
                            <button type="button" class="btn btn-dark" id="add-new">Add New</button>
                        </div>
                    </div>
                </div>
                    <div class="col-12 variant-combo {{ $product->type == 'simple' ? 'd-none' : '' }}">
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

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var el;
            window.TomSelect && (new TomSelect(el = document.getElementById('categories'), {
                allowEmptyOption: true,
                create: true
            }));

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
    </script>
    <script>
        window.initialCombinations = @json($combinations);
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

                    selectEl.addEventListener('change', function () {
                        const selected = this.selectedOptions[0];
                        const valueSelectId = this.id + '-values';
                        const valueSelect = document.getElementById(valueSelectId);
                        const choicesInstance = valueChoicesMap[valueSelectId];

                        if (!choicesInstance || !selected || !selected.dataset.values) return;

                        try {
                            const values = JSON.parse(selected.dataset.values);
                            const selectedValues = JSON.parse(valueSelect.dataset.selectedValues || '[]');
                            // console.log(values)

                            // Remove all existing options and values
                            choicesInstance.clearStore();
                            choicesInstance.clearChoices();

                            const newOptions = Object.entries(values).map(([value, label]) => ({
                                value,
                                label,
                                selected: selectedValues.includes(value),
                                disabled: false,
                            }));

                            choicesInstance.setChoices(newOptions, 'value', 'label', true);
                        } catch (err) {
                            console.warn("Invalid data-values JSON", selected.dataset.values);
                        }
                    });
                }
            });
            document.querySelectorAll('.variant-select').forEach((selectEl) => {
                selectEl.dispatchEvent(new Event('change'));
            });
        }

        function setupVariantChangeListeners() {
            const generate = () => generateVariantCombinations();

            document.querySelectorAll('.variant-select').forEach((el) => {
                el.addEventListener('change', generate);
            });

            document.querySelectorAll('.variant-values').forEach((el) => {
                const choices = el.choices;
                if (choices) {
                    // Ensure Choices events trigger generation
                    choices.passedElement.element.addEventListener('addItem', generate);
                    choices.passedElement.element.addEventListener('removeItem', generate);
                } else {
                    // fallback for plain select (in case Choices is not initialized yet)
                    el.addEventListener('change', generate);
                }
            });

            generate(); // trigger once initially
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

            if (attributeValuePairs.length === 0) return;

            const idArrays = attributeValuePairs.map(p => p.valueIds);
            const nameArrays = attributeValuePairs.map(p => p.valueNames);

            const combinationsIds = getCombinations(idArrays);
            const combinationsNames = getCombinations(nameArrays);

            const wrapper = document.getElementById('variant-combinations-wrapper');
            const renderedKeys = new Set();
            wrapper.innerHTML = ``;

            let newIndex = 0;
            combinationsIds.forEach((comboIds, i) => {
                const comboKey = comboIds.join('-');
                if (renderedKeys.has(comboKey)) return;
                renderedKeys.add(comboKey);

                const comboNames = combinationsNames[i];
                const label = comboNames.join(' / ');

                const existing = (window.initialCombinations || []).find(c =>
                    c.ids.join('-') === comboKey
                );

                const idHTML = comboIds.map(id =>
                    `<input type="hidden" name="combinations[${newIndex}][ids][]" value="${id}">`
                ).join('');

                wrapper.innerHTML += `<tr>
                        <td>
                            <label class="form-label"><strong>${label}</strong></label>
                            <input type="hidden" name="combinations[${newIndex}][variant_id]" value="${existing?.variant_id ?? ''}">
                            <input type="hidden" name="combinations[${newIndex}][label]" value="${label}">
                            ${idHTML}
                        </td>
                        <td>
                            <input type="number" name="combinations[${newIndex}][price]" class="form-control" required value="${existing?.price ?? ''}">
                        </td>
                        <td>
                            <input type="text" name="combinations[${newIndex}][sku]" class="form-control" required value="${existing?.sku ?? ''}">
                        </td>
                        <td>
                            <input type="file" name="combinations[${newIndex}][image]" class="form-control">
                            ${existing?.image ? `<img src="/storage/${existing.image}" alt="variant image" class="mt-2" width="80">` : ''}
                        </td>
                    </tr>`;

                newIndex++;
            });
        }
        function getCombinations(arrays) {
            if (!arrays.length) return [];
            let result = [[]];

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

        document.addEventListener("DOMContentLoaded", function () {
            setupVariantSelects();
            setupVariantChangeListeners();

            const type = document.getElementById('type');
            const variants = document.querySelector('.variants');
            type.addEventListener('change', function () {
                if (this.value == 'variable') {
                    variants.classList.remove('d-none');
                } else {
                    variants.classList.add('d-none');
                }
            });
        });

        let newIndex = 1;

        document.getElementById('add-new').addEventListener('click', function () {
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
                                data-values='@json($attribute->values->pluck("title", "id"))'>{{ $attribute->title }}</option>
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

        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-row')) {
                e.target.closest('.attribute-value-row').remove();
                generateVariantCombinations();
            }
        });
    </script>
@endpush
