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
                toasts: [],
                maxToasts: 5,

                show(type, message, duration = 2000) {
                    type = type ? 'success' : 'error';
                    const id = Date.now() + Math.random().toString(36).substr(2, 9);
                    this.toasts.push({
                        id,
                        type,
                        message: message.trim()
                    });

                    // Limit number of toasts
                    if (this.toasts.length > this.maxToasts) {
                        this.toasts = this.toasts.slice(-this.maxToasts);
                    }

                    // Auto remove toast after duration
                    setTimeout(() => {
                        this.remove(id);
                    }, duration);
                },

                remove(id) {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                },

                removeAll() {
                    this.toasts = [];
                },

                showToasts(type, messageOrArray, staggerDelay = 150) {
                    if (Array.isArray(messageOrArray)) {
                        // Handle array of messages with staggered display
                        messageOrArray.forEach((msg, index) => {
                            setTimeout(() => {
                                this.show(type, msg.trim());
                            }, index * staggerDelay);
                        });
                    } else if (typeof messageOrArray === 'string' && messageOrArray.trim()) {
                        const message = messageOrArray.trim();

                        // Check for pipe separator
                        if (message.includes('|')) {
                            // console.log('Splitting pipe-separated messages:', message);
                            const messages = message.split('|')
                                .filter(msg => msg.trim()) // Remove empty strings
                                .map(msg => msg.trim()); // Trim whitespace

                            // console.log('Split messages:', messages);

                            // Show each message with staggered delay
                            messages.forEach((msg, index) => {
                                setTimeout(() => {
                                    this.show(type, msg);
                                }, index * staggerDelay);
                            });
                        }
                        // Check for period separator as fallback
                        // else if (message.includes('. ') && message.split('. ').length > 1) {
                        //     console.log('Splitting period-separated messages:', message);
                        //     const messages = message.split('. ')
                        //         .filter(msg => msg.trim())
                        //         .map(msg => msg.trim());

                        //     messages.forEach((msg, index) => {
                        //         setTimeout(() => {
                        //             this.show(type, msg);
                        //         }, index * staggerDelay);
                        //     });
                        // }
                        // Single message
                        else {
                            this.show(type, message);
                        }
                    }
                },

                // Convenience methods
                success(message, duration = 2000) {
                    this.show(true, message, duration);
                },

                error(message, duration = 2000) {
                    this.show(false, message, duration);
                },

                // Show multiple with custom delay
                multiple(type, messages, delay = 150) {
                    this.showToasts(type, messages, delay);
                }
            });

            Alpine.data('cart', (productId) => ({
                quantity: 1,
                variantId: null,
                selectedVariantId: '', // Local state for this product
                init() {
                    // Sync with existing selection if any
                    const select = document.querySelector(`#variant-select-${productId}`);
                    if (select) {
                        this.selectedVariantId = select.value || '';
                        this.variantId = this.selectedVariantId;
                        this.updateImage(this.selectedVariantId); // Initialize image
                    }
                },
                setVariantId(id) {
                    this.selectedVariantId = id;
                    this.variantId = id; // Sync with addToCart payload
                },
                updateImage(variantId) {
                    const select = document.querySelector(`#variant-select-${productId}`);
                    if (select) {
                        const imgElement = document.getElementById(`product-image-${productId}`);
                        const selectedOption = select.querySelector(`option[value="${variantId}"]`);
                        const imageUrl = variantId ? (selectedOption ? selectedOption.getAttribute('data-image') : '') : imgElement.dataset.src;
                        if (imgElement) imgElement.src = imageUrl;
                    }
                },
                addToCart() {
                    axios.post('/cart/add', {
                            product_id: productId,
                            quantity: this.quantity,
                            variant_id: this.variantId || null
                        })
                        .then(response => {
                            Alpine.store('cart').reset(response.data.data);
                            Alpine.store('toast').showToasts(true, response.data.message ||
                                'Added to cart!')
                        })
                        .catch(error => {
                            Alpine.store('cart').reset(error?.response?.data?.data);
                            Alpine.store('toast').showToasts(false, error.response?.data?.message ||
                                'Add to cart failed.')
                        });
                }
            }));

        });
    </script>