@extends('frontend.app')
@push('styles')
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <style>
        .preview-container img {
            max-height: 400px;
            object-fit: contain;
        }
        .thumbs-swiper img {
            cursor: pointer;
            border-radius: 6px;
            transition: transform 0.2s ease;
        }
        .thumbs-swiper img:hover {
            transform: scale(1.05);
        }

        .swiper-button-prev,
        .swiper-button-next {
            width: 30px;
            height: 30px;
            background: rgba(0,0,0,0.5);
            border-radius: 50%;
            color: white;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .swiper-button-prev::after,
        .swiper-button-next::after {
            font-size: 14px; /* arrow size */
        }

        /* Make preview zoomable */
        .preview {
            position: relative;
            overflow: hidden;
            cursor: zoom-in !important;
        }

        #mainPreview {
            transition: transform 0.3s ease;
            transform-origin: center center;
        }

        .preview.zoom-active #mainPreview {
            transform: scale(1.5); /* zoom level */
            cursor: zoom-in;
        }
    </style>
@endpush
@section('content')
    <section class="page-container">
        <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                <!-- Left Column: Product Image -->
                <div class="w-full">
                    <div class="card bg-base-100 shadow-xl">
                        {{-- <figure>
                            <img id="variant-image" src="{{ $product->image ? asset($product->image) : 'https://placehold.co/400' }}"
                                alt="{{ $product->title }}" class="w-full h-auto object-cover">
                        </figure> --}}
                        <div class="product-gallery w-full mx-auto">
                        <!-- Preview -->
                        <div class="preview mb-4">
                            <img id="mainPreview" src="{{ $product->image ? $product->image : 'https://placehold.co/400' }}" class="w-full h-auto object-cover rounded-lg shadow" />
                        </div>

                        <!-- Thumbnails Slider -->
                        <div class="relative">
                            <!-- Navigation Buttons -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>

                            @php $images = collect([$product->image])->merge($product->variants->pluck('image'))->filter() @endphp
                            <!-- Thumbnails Slider -->
                            <div class="swiper thumbs-swiper">
                                <div class="swiper-wrapper">
                                    @foreach ($images as $image)
                                            <div class="swiper-slide"><img src="{{ $image ?? 'https://placehold.co/400' }}" /></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
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
                        {{ $product->short_description }}
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
            <!-- Tabs Section -->
                <div class="mt-12">
                    <div role="tablist" class="tabs tabs-box">
                        <input type="radio" name="product_tabs" role="tab" class="tab" aria-label="Description" checked>
                        <div role="tabpanel" class="tab-content p-4">
                            <div class="prose max-w-none">
                                {!! $product->description !!}
                            </div>
                        </div>

                        <input type="radio" name="product_tabs" role="tab" class="tab" aria-label="Additional Information">
                        <div role="tabpanel" class="tab-content p-4">
                            @if(!empty($product->additional_info))
                                @php
                                    $additionalInfo = is_array($product->additional_info) 
                                        ? $product->additional_info 
                                        : json_decode($product->additional_info, true);
                                @endphp
                                <table class="table table-zebra w-full">
                                    <tbody>
                                        @foreach($additionalInfo as $key => $value)
                                            <tr>
                                                <th class="w-1/3">{{ $key }}</th>
                                                <td>{{ $value }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No additional information available.</p>
                            @endif
                        </div>

                        <input type="radio" name="product_tabs" role="tab" class="tab" aria-label="Reviews">
                        <div role="tabpanel" class="tab-content p-4">
                            <p>No reviews yet.</p>
                            {{-- You can later add a review form here --}}
                        </div>
                    </div>
                </div>
        </div>
    </section>
@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    window.variants = @json($product->variants); 
    document.addEventListener('DOMContentLoaded', () => {
        const variants = window.variants || [];
        const priceEl = document.getElementById('variant-price');
        const skuEl = document.getElementById('variant-sku');
        const imageEl = document.getElementById('mainPreview');

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

        // --- Default to first variant ---
        if (variants.length > 0) {
            const firstVariant = variants[0];
            firstVariant.attribute_value_ids.forEach(id => {
                const radio = document.querySelector(`input[name^="attributes"][value="${id}"]`);
                if (radio) radio.checked = true;
            });
            updateVariantInfo();
        }
    });
</script>
    

<script>
    const previewImg = document.getElementById("mainPreview");

    // Initialize Swiper for thumbnails
    const thumbsSwiper = new Swiper(".thumbs-swiper", {
        slidesPerView: 4,
        spaceBetween: 10,
        loop: true,
        autoplay: {
            delay: 3000, // time between slides in ms
            disableOnInteraction: false // keeps autoplay after manual interaction
        },
        breakpoints: {
            640: { slidesPerView: 5 },
            1024: { slidesPerView: 6 }
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        },
        breakpoints: {
            640: { slidesPerView: 5 },
            1024: { slidesPerView: 6 }
        }
    });

    // Change preview on click
    document.querySelectorAll(".thumbs-swiper img").forEach(img => {
        img.addEventListener("click", () => {
            previewImg.src = img.src;
        });
    });

    thumbsSwiper.on('slideChange', () => {
        const activeSlide = thumbsSwiper.slides[thumbsSwiper.activeIndex];
        const img = activeSlide.querySelector("img");
        if (img) previewImg.src = img.src;
    });
</script>
<script>
    const previewContainer = document.querySelector(".preview");
    const previewImage = document.getElementById("mainPreview");

    previewContainer.addEventListener("mousemove", (e) => {
        const { left, top, width, height } = previewContainer.getBoundingClientRect();
        const x = ((e.pageX - left) / width) * 100;
        const y = ((e.pageY - top) / height) * 100;
        previewImage.style.transformOrigin = `${x}% ${y}%`;
        previewContainer.classList.add("zoom-active");
    });

    previewContainer.addEventListener("mouseleave", () => {
        previewContainer.classList.remove("zoom-active");
        previewImage.style.transformOrigin = "center center";
    });
</script>
@endpush