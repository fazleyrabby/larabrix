@extends('frontend.app')

@section('content')
    <section class="page-container">
        <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                <!-- Left Column: Product Image -->
                <div class="w-full">
                    <div class="card bg-base-100 shadow-xl">
                        <figure>
                            <img id="variant-image" src="{{ $product->image ? asset($product->image) : 'https://placehold.co/400' }}"
                                alt="{{ $product->title }}" class="w-full h-auto object-cover">
                        </figure>
                    </div>
                </div>

                <!-- Right Column: Product Details -->
                <div class="space-y-6">
                    <!-- Title -->
                    <h1 class="text-3xl font-bold">{{ $product->title }}</h1>

                    <!-- Price -->
                    <p id="variant-price" class="text-2xl font-semibold text-primary">
                        ${{ number_format($product->price, 2) }}
                    </p>

                    <p id="variant-sku" class="text-sm text-gray-600">
                        SKU: {{ $product->sku ?? 'N/A' }}
                    </p>

                    <!-- Description -->
                    <p class="text-gray-600 leading-relaxed">
                        {{ $product->description }}
                    </p>

                    <!-- Attributes -->
                    <div class="space-y-4">
                        @foreach ($attributes as $attribute)
                        <div class="mb-4">
                            <label class="font-semibold block mb-1">{{ ucfirst($attribute->title) }}:</label>
                            <div class="flex gap-4">
                                @foreach ($attribute->values as $value)
                                    <label class="inline-flex items-center gap-2 cursor-pointer">
                                        <input type="radio" 
                                            name="attributes[{{ $attribute->id }}]" 
                                            value="{{ $value->id }}" 
                                            required>
                                        <span>{{ $value->title }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    </div>

                    <!-- Quantity & Add to Cart -->
                    <div x-data="cart({{ $product->id }})" class="flex items-center gap-4">
                        <label class="flex items-center gap-2">
                            <span class="font-semibold">Qty:</span>
                            <select x-model.number="quantity"
                                class="select">
                                <template x-for="qty in 10" :key="qty">
                                    <option :value="qty" x-text="qty">
                                    </option>
                                </template>
                            </select>

                        </label>
                        <div>
                        <button type="button" @click="addToCart" class="btn btn-neutral cursor-pointer">
                            Add to Cart
                        </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('scripts')

<script>
    window.variants = @json($product->variants); 
    document.addEventListener('DOMContentLoaded', () => {
        const variants = window.variants || [];
        const priceEl = document.getElementById('variant-price');
        const skuEl = document.getElementById('variant-sku');
        const imageEl = document.getElementById('variant-image');

        function getSelectedAttributeValueIds() {
            const selected = [];
            document.querySelectorAll('input[name^="attributes"]:checked').forEach(input => {
                selected.push(parseInt(input.value));
            });
            return selected.sort((a, b) => a - b);
        }

        function findMatchingVariant(selectedIds) {
            return variants.find(variant => {
                if (variant.attribute_value_ids.length !== selectedIds.length) {
                    return false;
                }
                // Compare sorted arrays
                for (let i = 0; i < selectedIds.length; i++) {
                    if (variant.attribute_value_ids[i] !== selectedIds[i]) return false;
                }
                return true;
            });
        }

        function updateVariantInfo() {
            const selectedIds = getSelectedAttributeValueIds();
            
            // count unique attribute groups by name (like attributes[1], attributes[2])
            const totalAttributes = new Set(
                Array.from(document.querySelectorAll('input[name^="attributes"]'))
                    .map(input => input.name)
            ).size;

            // Only update if all attributes selected
            if (selectedIds.length !== totalAttributes) {
                // Show base product price and SKU if any
                priceEl.textContent = `${{{ number_format($product->price, 2) }}}`;
                skuEl.textContent = `SKU: {{ $product->sku ?? 'N/A' }}`;
                return;
            }
            const variant = findMatchingVariant(selectedIds);
            
            let defaultImage = imageEl.src 
            if (variant) {
                priceEl.textContent = `$${parseFloat(variant.price).toFixed(2)}`;
                skuEl.textContent = `SKU: ${variant.sku}`;
                const cartComponent = Alpine.$data(document.querySelector('[x-data^="cart"]'));
                cartComponent.setVariantId(variant.id);
                imageEl.src = variant.image
            } else {
                // No matching variant found, fallback to base
                priceEl.textContent = `$${{{ number_format($product->price, 2) }}}`;
                skuEl.textContent = `SKU: {{ $product->sku ?? 'N/A' }}`;
                imageEl.src = defaultImage
            }
        }

        // Attach change listeners on all attribute radios
        document.querySelectorAll('input[name^="attributes"]').forEach(input => {
            input.addEventListener('change', updateVariantInfo);
        });
    });
</script>
    
@endpush