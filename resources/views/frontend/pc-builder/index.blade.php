@extends('frontend.app')

@section('content')
    <section class="page-container">
        <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
            <header>
                <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">PC Builder</h2>

                <p class="mt-4 max-w-md text-gray-500">
                    Select your pc parts!
                </p>
            </header>
            <div class="overflow-x-auto mt-8" id="table-container">
                <table class="table w-full text-left text-sm border border-gray-200">
                    <thead class="bg-gray-50 text-xs text-gray-700 uppercase">
                        <tr>
                            <th scope="col" class="p-4 w-1/4">Category</th>
                            <th scope="col" class="p-4 w-2/4">Component</th>
                            <th scope="col" class="p-4 w-1/4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="pc-builder-table-body">
                        <!-- Dynamic rows will be inserted here -->
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50 border-t-2 border-gray-200 font-bold text-gray-800 text-lg">
                            <td class="p-4" colspan="2">Total Cost</td>
                            <td id="total-cost" class="text-right">$0.00</td>
                        </tr>
                    </tfoot>
                </table>

                <div class="float-end mt-8">
                    <button class="btn btn-secondary download-button">Download</button>
                    <button class="btn btn-accent cart-button">Add to Cart</button>
                </div>
            </div>
        </div>
    </section>

    <!-- The Modal -->
    <dialog id="product-modal" class="modal">
        <div class="modal-box w-full max-w-2xl p-6">
            <h3 id="modal-title" class="font-bold text-2xl text-gray-800 mb-4"></h3>
            <div id="modal-content" class="max-h-96 overflow-y-auto space-y-4">
                <!-- Products will be dynamically inserted here -->
            </div>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Close</button>
                </form>
            </div>
        </div>
    </dialog>
@endsection

@push('scripts')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html-to-image/1.11.13/html-to-image.js"
        integrity="sha512-4W7+nCTcMQMFBnTRwvixN7il649NCqZiBfJ7WvzU7gxF12zOnaKwVYTSIzwrjy/cy+CPQxn2lAIVZIes+rPp2Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        class PcBuilder {
            constructor() {
                this.tableBody = document.getElementById('pc-builder-table-body');
                this.modal = document.getElementById('product-modal');
                this.modalTitle = document.getElementById('modal-title');
                this.modalContent = document.getElementById('modal-content');
                this.totalCostEl = document.getElementById('total-cost');
                this.selectedParts = this.loadFromLocalStorage() || {};
                this.categories = [];
                this.products = [];
                this.currentCategory = null;

                this.tableContainer = document.getElementById('table-container');
                this.printContainer = document.querySelector('#table-container table');

                this.initializeEventListeners();
                this.fetchData();
            }

            fetchData() {
                try {
                    // const response = await axios.get('/api/pc-builder-data'); // Replace with real API endpoint
                    // this.categories = response.data.categories;
                    // this.products = response.data.products;
                    const categories = @json($categories); // Replace with real API endpoint
                    const products = @json($products); // Replace with real API endpoint
                    this.categories = categories;
                    this.products = products;
                    this.renderTable();
                } catch (error) {
                    console.error('Error fetching data:', error);
                    this.tableBody.innerHTML =
                        '<tr><td colspan="3" class="p-4 text-center text-red-500">Failed to load data. Please try again later.</td></tr>';
                }
            }

            initializeEventListeners() {
                this.tableContainer.addEventListener('click', (event) => {
                    if (event.target.classList.contains('add-button')) {
                        const categoryId = event.target.dataset.categoryId;
                        const category = this.categories.find(c => c.id == categoryId);
                        if (category) this.openModal(category);
                    } else if (event.target.classList.contains('remove-button')) {
                        const categoryId = event.target.dataset.categoryId;
                        const uniqueId = event.target.dataset.uniqueId;
                        this.handleRemoveProduct(categoryId, uniqueId);
                    } else if (event.target.classList.contains('download-button')) {
                        const btn = event.target;
                        const originalText = btn.textContent;

                        // Set loading state
                        btn.disabled = true;
                        btn.textContent = 'Downloading...';

                        this.downloadBuild().finally(() => {
                            // Reset button after download
                            btn.disabled = false;
                            btn.textContent = originalText;
                        });
                    } else if (event.target.classList.contains('cart-button')) {
                        this.addToCart(); // Placeholder for future cart implementation
                    }
                });

                this.modal.querySelector('form').addEventListener('submit', () => this.closeModal());
            }

            renderTable() {
                this.tableBody.innerHTML = this.categories.map(category => `
                    <tr>
                        <td class="p-4 font-bold text-gray-800">${category.title}</td>
                        <td class="p-4">
                            <div id="parts-for-category-${category.id}" class="flex flex-col space-y-2"></div>
                        </td>
                        <td class="p-4 text-right">
                            <button class="btn btn-primary add-button" data-category-id="${category.id}">Add</button>
                        </td>
                    </tr>
                `).join('');

                // const tfoot = this.tableBody.parentElement.querySelector('tfoot');
                // if (tfoot) {
                //     tfoot.innerHTML = `
                //         <tr class="bg-gray-50 border-t-2 border-gray-200 font-bold text-gray-800 text-lg">
                //             <td class="p-4" colspan="2">Total Cost</td>
                //             <td class="p-4 text-right" id="total-cost">$${Object.values(this.selectedParts).flat().reduce((sum, part) => sum + part.product.price, 0).toFixed(2)}
                //             </td>
                //         </tr>
                //     `;
                // }

                this.totalCostEl.textContent = `$${Object.values(this.selectedParts).flat().reduce((sum, part) => sum + part.product.price, 0).toFixed(2)}`
                this.categories.forEach(category => this.renderSelectedParts(category.id));
            }

            renderSelectedParts(categoryId) {
                const container = document.getElementById(`parts-for-category-${categoryId}`);
                const parts = this.selectedParts[categoryId] || [];
                container.innerHTML = parts.length ?
                    parts.map(part => `
                        <div class="flex items-center gap-4 bg-white rounded-lg p-3 shadow-sm border border-gray-200">
                            <img src="${part.product.image}" alt="${part.product.title}" class="w-10 h-10 rounded object-cover flex-shrink-0" />
                            <div class="flex-grow">
                                <span class="font-semibold text-gray-800">${part.product.title}</span>
                                <p class="text-gray-500">$${part.product.price.toFixed(2)}</p>
                            </div>
                            <button class="btn btn-danger remove-button" data-product-id="${part.product.id}" data-unique-id="${part.id}" data-category-id="${categoryId}">
                                Remove
                            </button>
                        </div>
                    `).join('') :
                    '<span class="text-gray-400 italic">No component selected.</span>';
                this.updateTotalCost();
            }

            updateTotalCost() {
                const totalCost = Object.values(this.selectedParts).flat().reduce((sum, part) => sum + part.product
                    .price, 0);
                this.totalCostEl.textContent = `$${totalCost.toFixed(2)}`;
            }

            openModal(category) {
                this.currentCategory = category;
                this.modalTitle.textContent = `Select a ${category.title}`;
                this.modalContent.innerHTML = '';

                const filteredProducts = this.products.filter(product =>
                    product.category_id === this.currentCategory.id && this.isCompatible(product)
                );

                if (filteredProducts.length > 0) {
                    filteredProducts.forEach(product => {
                        const productDiv = document.createElement('div');
                        productDiv.className =
                            'flex items-center justify-between p-4 rounded-lg cursor-pointer bg-base-100 shadow-sm hover:bg-base-200 transition-all duration-200';
                        productDiv.setAttribute('role', 'button');
                        productDiv.setAttribute('tabindex', '0');
                        productDiv.innerHTML = `
                    <div class="flex items-center gap-4">
                        <img src="${product.image}" alt="${product.title}" class="w-12 h-12 rounded object-cover" />
                        <div>
                            <h4 class="font-semibold text-gray-800">${product.title}</h4>
                            <p class="text-sm text-gray-500">Compatibility: ${product.compatibility_key || 'N/A'}</p>
                        </div>
                    </div>
                    <span class="font-bold text-gray-800">$${product.price.toFixed(2)}</span>
                `;
                        productDiv.addEventListener('click', () => this.handleAddProduct(product));
                        productDiv.addEventListener('keydown', (e) => e.key === 'Enter' && this
                            .handleAddProduct(product));
                        this.modalContent.appendChild(productDiv);
                    });
                } else {
                    this.modalContent.innerHTML = `
                <div class="text-center text-gray-500 p-8" role="alert">
                    <p class="mb-2">No compatible components found.</p>
                    <p>Select a CPU or Motherboard first for compatibility.</p>
                </div>
            `;
                }
                this.modal.showModal();
            }

            closeModal() {
                this.modal.close();
                this.currentCategory = null;
            }

            handleAddProduct(product) {
                const canAddMultiple = ['RAM', 'SSD', 'HDD'].includes(this.currentCategory.title);
                const categoryId = this.currentCategory.id;
                const uniqueId = Date.now() + '-' + Math.random().toString(36).substr(2, 9);

                if (canAddMultiple) {
                    this.selectedParts[categoryId] = this.selectedParts[categoryId] || [];
                    this.selectedParts[categoryId].push({
                        id: uniqueId,
                        product
                    });
                } else {
                    this.selectedParts[categoryId] = [{
                        id: uniqueId,
                        product
                    }];
                }

                this.saveToLocalStorage();
                this.renderSelectedParts(categoryId);
                this.closeModal();
            }

            handleRemoveProduct(categoryId, uniqueId) {
                if (this.selectedParts[categoryId]) {
                    this.selectedParts[categoryId] = this.selectedParts[categoryId].filter(part => part.id !==
                        uniqueId);
                    if (this.selectedParts[categoryId].length === 0) {
                        delete this.selectedParts[categoryId];
                    }
                }
                this.saveToLocalStorage();
                this.renderSelectedParts(categoryId);
            }

            saveToLocalStorage() {
                localStorage.setItem('pcBuilderSelections', JSON.stringify(this.selectedParts));
            }

            loadFromLocalStorage() {
                const saved = localStorage.getItem('pcBuilderSelections');
                return saved ? JSON.parse(saved) : null;
            }


            downloadBuild() {
                if (!this.tableContainer) {
                    console.error('tableContainer is null, cannot generate PNG');
                    alert('Error: Unable to generate PNG. Please refresh the page.');
                    return;
                }

                const exportWrapper = document.createElement('div');
                exportWrapper.style.backgroundColor = '#ffffff';
                exportWrapper.style.padding = '20px';
                exportWrapper.style.textAlign = 'center';
                exportWrapper.style.fontFamily = 'sans-serif';

                const tableWidth = this.printContainer.offsetWidth;
                exportWrapper.style.width = tableWidth + 'px';

                // const originalBg = this.printContainer.style.backgroundColor;
                // this.printContainer.style.backgroundColor = '#ffffff';
                // this.printContainer.style.padding = '20px';
                const title = document.createElement('h2');
                title.innerText = 'Your PC Parts';
                title.style.marginBottom = '20px';
                exportWrapper.appendChild(title);

                // Clone the table
                const clonedTable = this.printContainer.cloneNode(true);
                clonedTable.style.margin = '0 auto';
                exportWrapper.appendChild(clonedTable);
                document.body.appendChild(exportWrapper);

                return htmlToImage.toPng(exportWrapper, {
                        pixelRatio: 2
                    })
                    .then((dataUrl) => {
                        const link = document.createElement('a');
                        link.download = `pc-build-${Date.now()}.png`;
                        link.href = dataUrl;
                        link.click();
                    })
                    .finally(() => {
                        // exportWrapper.style.backgroundColor = originalBg; // restore original
                        document.body.removeChild(exportWrapper);
                    });
            }

            addToCart() {
                const allParts = Object.values(this.selectedParts).flat();
                const products = allParts.map(part => ({
                    product_id: part.product.id,
                    quantity: 1, // or support user qty input
                    variant_id: null // or support variant selection if you have
                }));

                // Call batch add API
                axios.post('/cart/add', { products })
                    .then(response => {
                        Alpine.store('cart').reset(response.data.data);
                        Alpine.store('toast').showToasts(true, response.data.message ||
                            'Added to cart!')
                    })
                    .catch(error => {
                       Alpine.store('toast').showToasts(false, error.response?.data?.message ||
                            'Add to cart failed.')
                    });
            }

            isCompatible(product) {
                if (!product || !this.currentCategory) return true;

                const keyComponentIds = this.categories
                    .filter(cat => cat.compatibility_key === 'CPU' || cat.compatibility_key === 'Motherboard')
                    .map(cat => cat.id);

                const keyComponentId = Object.keys(this.selectedParts).find(id => keyComponentIds.includes(parseInt(
                    id)));
                if (!keyComponentId || this.currentCategory.compatibility_key === 'CPU' || this.currentCategory
                    .compatibility_key === 'Motherboard') {
                    return true;
                }

                const keyComponent = this.selectedParts[keyComponentId]?.[0];
                return keyComponent ? product.compatibility_key === keyComponent.product.compatibility_key : true;
            }
        }

        document.addEventListener('DOMContentLoaded', () => new PcBuilder());
    </script>
@endpush
