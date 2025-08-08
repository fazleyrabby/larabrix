@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('cart', {
                items: @json(session()->get('cart')['items'] ?? []),
                attributes: @json(session()->get('cart')['attributes'] ?? []),
                total: @json(session()->get('cart')['total'] ?? 0),
                reset(cart) {
                    this.items = cart.items ?? [];
                    this.attributes = cart.attributes ?? [];
                    this.total = cart.total ?? 0
                },

                updateQuantity(productId, quantity) {
                    axios.post('/cart/update', {
                        product_id: productId,
                        quantity: quantity
                    })
                    .then(response => {
                        this.reset(response.data.data);
                        Alpine.store('toast').show(true, response.data.message || 'Cart updated!');
                    })
                    .catch(error => {
                        Alpine.store('toast').show(false, error.response?.data?.message ||
                            'Update failed.');
                    });
                },

                removeItem(productId) {
                    axios.post('/cart/remove', {
                        product_id: productId
                    })
                    .then(response => {
                        this.reset(response.data.data);
                        Alpine.store('toast').show(true, response.data.message || 'Item removed!');
                    })
                    .catch(error => {
                        Alpine.store('toast').show(false, error.response?.data?.message ||
                            'Remove failed.');
                    });
                }
            });


            Alpine.store('toast', {
                visible: false,
                message: '',
                type: 'success', // 'success' or 'error'

                show(success, message) {
                    this.type = success ? 'success' : 'error';
                    this.message = message;
                    this.visible = true;

                    setTimeout(() => {
                        this.visible = false;
                    }, 3000);
                }
            });

            Alpine.data('cart', (productId) => ({
                quantity: 1,
                variantId: null,
                setVariantId(id) {
                    this.variantId = id;
                },
                addToCart() {
                    axios.post('/cart/add', {
                        product_id: productId,
                        quantity: this.quantity,
                        variant_id: this.variantId 
                    })
                    .then(response => {
                        Alpine.store('cart').reset(response.data.data);
                        Alpine.store('toast').show(true, response.data.message ||
                            'Added to cart!');
                    })
                    .catch(error => {
                        Alpine.store('cart').reset(error?.response?.data?.data);
                        Alpine.store('toast').show(false, error.response?.data?.message ||
                            'Add to cart failed.');
                    });
                }
            }));

        });
    </script>
@endpush
