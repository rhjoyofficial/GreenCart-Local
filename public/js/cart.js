/**
 * Cart Manager - Production Level Cart Management
 */
class CartManager {
    constructor() {
        this.sessionKey = "cart_last_update";
        this.debounceTimeout = null;
        this.debounceDelay = 300;
        this.isInitialized = false;
        this.csrfToken = document.querySelector(
            'meta[name="csrf-token"]',
        )?.content;

        this.selectors = {
            addToCartForm: ".add-to-cart-form",
            cartItemForm: ".cart-item-form",
            quantityInput: ".quantity-input",
            quantityDecrement: ".quantity-decrement",
            quantityIncrement: ".quantity-increment",
            removeItem: ".cart-remove-item",
            clearCart: "#clear-cart-btn",
            cartBadge: ".cart-badge",
            cartCount: ".cart-count-number",
            cartSubtotal: "#cart-subtotal",
            cartTotal: "#cart-total",
            checkoutBtn: ".checkout-btn",
            cartItem: ".cart-item",
        };

        this.init();
    }

    /**
     * Initialize cart manager
     */
    init() {
        if (this.isInitialized) return;

        try {
            this.checkCartStale();
            this.setupEventListeners();
            this.updateQuantityButtons();
            this.updateCheckoutButtons();
            this.updateCartBadges();

            this.isInitialized = true;
            console.log("Cart Manager initialized successfully");
        } catch (error) {
            console.error("Cart Manager initialization failed:", error);
        }
    }

    /**
     * Setup event listeners
     */
    setupEventListeners() {
        // Add to cart forms
        document.addEventListener("submit", (e) => this.handleAddToCart(e));

        // Quantity controls
        document.addEventListener("click", (e) => {
            if (e.target.closest(this.selectors.quantityDecrement)) {
                e.preventDefault();
                this.handleQuantityChange(
                    e.target.closest(this.selectors.quantityDecrement),
                    -1,
                );
            }

            if (e.target.closest(this.selectors.quantityIncrement)) {
                e.preventDefault();
                this.handleQuantityChange(
                    e.target.closest(this.selectors.quantityIncrement),
                    1,
                );
            }
        });

        // Quantity input changes
        document.addEventListener("input", (e) => {
            if (e.target.matches(this.selectors.quantityInput)) {
                this.handleQuantityInputChange(e.target);
            }
        });

        // Remove item
        document.addEventListener("click", (e) => {
            const removeBtn = e.target.closest(this.selectors.removeItem);
            if (removeBtn) {
                e.preventDefault();
                this.handleRemoveItem(removeBtn);
            }
        });

        // Clear cart
        document.addEventListener("click", (e) => {
            const clearBtn = e.target.closest(this.selectors.clearCart);
            if (clearBtn) {
                e.preventDefault();
                this.handleClearCart(clearBtn);
            }
        });
    }

    /**
     * Check if cart data is stale
     */
    checkCartStale() {
        const lastUpdate = localStorage.getItem(this.sessionKey);
        if (lastUpdate) {
            const hoursSinceUpdate =
                (Date.now() - lastUpdate) / (1000 * 60 * 60);
            if (hoursSinceUpdate > 24) {
                this.showFlash(
                    "Your cart may be outdated. Please refresh.",
                    "warning",
                );
            }
        }
    }

    /**
     * Handle add to cart
     */
    async handleAddToCart(event) {
        const form = event.target.closest(this.selectors.addToCartForm);
        if (!form) return;

        event.preventDefault();

        const button = form.querySelector(".add-to-cart-btn");
        if (!button || button.disabled) return;

        await this.processAddToCart(form, button);
    }

    /**
     * Process add to cart request
     */
    async processAddToCart(form, button) {
        try {
            // Prepare request data
            const url = form.action;
            const formData = new FormData(form);
            const quantity = parseInt(
                formData.get("quantity") ||
                    form.querySelector('input[name="quantity"]')?.value ||
                    1,
            );

            // Validate quantity
            if (quantity < 1) {
                this.showFlash("Quantity must be at least 1", "error");
                return;
            }

            // Save original button state
            const originalHTML = button.innerHTML;
            const originalClasses = button.className;

            // Show loading state
            this.setButtonLoading(button, true);

            // Make API request
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": this.csrfToken,
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
                body: JSON.stringify({ quantity }),
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.message || "Failed to add to cart");
            }

            // Update UI
            this.updateCartCount(data.cart_count || 0);
            this.updateCartTotals(data);

            // Show success animation
            this.showSuccessAnimation(button);

            // Show success message
            this.showFlash(
                data.message || "Item added to cart successfully!",
                "success",
            );

            // Reset button after delay
            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.className = originalClasses;
                button.disabled = false;
            }, 1500);

            // Update last cart update time
            localStorage.setItem(this.sessionKey, Date.now());
        } catch (error) {
            console.error("Add to cart error:", error);

            // Show error message
            this.showFlash(
                error.message || "Failed to add to cart. Please try again.",
                "error",
            );

            // Reset button
            this.resetButton(button);
        }
    }

    /**
     * Handle quantity change
     */
    async handleQuantityChange(button, change) {
        const form = button.closest(this.selectors.cartItemForm);
        if (!form || form.dataset.loading === "true") return;

        const input = form.querySelector(this.selectors.quantityInput);
        if (!input) return;

        const productId =
            input.dataset.productId || input.getAttribute("data-product-id");
        const currentQuantity = parseInt(input.value) || 1;
        const min = parseInt(input.min) || 1;
        const max = parseInt(input.max) || 999;
        const newQuantity = currentQuantity + change;

        // Validate boundaries
        if (newQuantity < min || newQuantity > max) {
            this.showFlash(
                `Quantity must be between ${min} and ${max}`,
                "warning",
            );
            return;
        }

        // Update input immediately for better UX
        input.value = newQuantity;
        this.updateQuantityButtons(form);

        // Update via API
        await this.updateCartItem(form, newQuantity, productId);
    }

    /**
     * Handle quantity input change with debounce
     */
    handleQuantityInputChange(input) {
        clearTimeout(this.debounceTimeout);

        this.debounceTimeout = setTimeout(async () => {
            const form = input.closest(this.selectors.cartItemForm);
            const productId =
                input.dataset.productId ||
                input.getAttribute("data-product-id");
            const newQuantity = parseInt(input.value) || 1;
            const min = parseInt(input.min) || 1;
            const max = parseInt(input.max) || 999;

            // Validate boundaries
            if (newQuantity < min || newQuantity > max) {
                this.showFlash(
                    `Quantity must be between ${min} and ${max}`,
                    "warning",
                );
                input.value = Math.max(min, Math.min(newQuantity, max));
                return;
            }

            this.updateQuantityButtons(form);
            await this.updateCartItem(form, newQuantity, productId);
        }, this.debounceDelay);
    }

    /**
     * Update cart item via API
     */
    async updateCartItem(form, quantity, productId) {
        if (!form || form.dataset.loading === "true") return;

        try {
            form.dataset.loading = "true";
            const input = form.querySelector(this.selectors.quantityInput);

            if (input) {
                input.disabled = true;
                input.classList.add("opacity-50", "cursor-not-allowed");
            }

            const url = form.action || form.dataset.url;
            const response = await fetch(url, {
                method: "PUT",
                headers: {
                    "X-CSRF-TOKEN": this.csrfToken,
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
                body: JSON.stringify({ quantity }),
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.message || "Failed to update cart");
            }

            // Update UI
            this.updateCartCount(data.cart_count || 0);
            this.updateCartTotals(data);
            this.updateItemTotal(productId, data.item_total);

            // Show success message
            this.showFlash(
                data.message || "Cart updated successfully",
                "success",
            );
        } catch (error) {
            console.error("Update cart item error:", error);
            this.showFlash(
                error.message || "Failed to update cart. Please try again.",
                "error",
            );

            // Revert to previous value if needed
            const input = form.querySelector(this.selectors.quantityInput);
            if (input && input.hasAttribute("data-previous-value")) {
                input.value = input.getAttribute("data-previous-value");
            }
        } finally {
            // Clean up
            if (form) {
                form.dataset.loading = "false";
            }

            const input = form?.querySelector(this.selectors.quantityInput);
            if (input) {
                input.disabled = false;
                input.classList.remove("opacity-50", "cursor-not-allowed");
                input.setAttribute("data-previous-value", input.value);
            }
        }
    }

    /**
     * Handle remove item
     */
    async handleRemoveItem(button) {
        if (
            !confirm(
                "Are you sure you want to remove this item from your cart?",
            )
        ) {
            return;
        }

        try {
            const form = button.closest("form");
            const url =
                button.dataset.url || (form ? form.action : button.href);
            const itemElement = button.closest(this.selectors.cartItem);

            // Show loading state
            this.setButtonLoading(button, true, "Removing...");

            // Make API request
            const response = await fetch(url, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": this.csrfToken,
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.message || "Failed to remove item");
            }

            // Remove item from UI with animation
            if (itemElement) {
                itemElement.style.transition = "all 0.3s ease";
                itemElement.style.opacity = "0";
                itemElement.style.transform = "translateX(-100%)";

                setTimeout(() => {
                    itemElement.remove();
                    this.checkEmptyCart();
                }, 300);
            }

            // Update cart data
            this.updateCartCount(data.cart_count || 0);
            this.updateCartTotals(data);

            // Show success message
            this.showFlash(data.message || "Item removed from cart", "success");
        } catch (error) {
            console.error("Remove item error:", error);
            this.showFlash(
                error.message || "Failed to remove item. Please try again.",
                "error",
            );
            this.resetButton(button);
        }
    }

    /**
     * Handle clear cart
     */
    async handleClearCart(button) {
        if (!confirm("Are you sure you want to clear your entire cart?")) {
            return;
        }

        try {
            const url = button.dataset.url || button.href;

            // Show loading state
            this.setButtonLoading(button, true, "Clearing...");

            // Make API request
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": this.csrfToken,
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.message || "Failed to clear cart");
            }

            // Update cart data
            this.updateCartCount(data.cart_count || 0);
            this.updateCartTotals(data);

            // Show empty cart message
            this.showEmptyCartMessage();

            // Show success message
            this.showFlash(
                data.message || "Cart cleared successfully",
                "success",
            );

            // Reset button
            setTimeout(() => {
                this.resetButton(button);
            }, 1000);
        } catch (error) {
            console.error("Clear cart error:", error);
            this.showFlash(
                error.message || "Failed to clear cart. Please try again.",
                "error",
            );
            this.resetButton(button);
        }
    }

    /**
     * Update cart count badges
     */
    updateCartCount(count) {
        count = parseInt(count) || 0;

        // Update cart badges
        document.querySelectorAll(this.selectors.cartBadge).forEach((badge) => {
            const oldCount = parseInt(badge.textContent) || 0;
            badge.textContent = count;

            if (count > 0) {
                badge.classList.remove("hidden");

                if (count > oldCount) {
                    badge.classList.add("animate-bounce");
                    setTimeout(
                        () => badge.classList.remove("animate-bounce"),
                        800,
                    );
                }
            } else {
                badge.classList.add("hidden");
            }
        });

        // Update cart count display
        document.querySelectorAll(this.selectors.cartCount).forEach((el) => {
            el.textContent = count;
        });

        // Update checkout buttons
        this.updateCheckoutButtons(count);

        // Update last cart update time
        localStorage.setItem(this.sessionKey, Date.now());
    }

    /**
     * Update cart totals
     */
    updateCartTotals(data) {
        // Update subtotal
        const subtotalElement = document.querySelector(
            this.selectors.cartSubtotal,
        );
        if (subtotalElement && data.cart_subtotal !== undefined) {
            subtotalElement.textContent = `TK${parseFloat(data.cart_subtotal).toFixed(2)}`;
            this.animateElement(subtotalElement);
        }

        // Update total
        const totalElement = document.querySelector(this.selectors.cartTotal);
        if (totalElement && data.cart_total !== undefined) {
            totalElement.textContent = `TK${parseFloat(data.cart_total).toFixed(2)}`;
            this.animateElement(totalElement);
        }
    }

    /**
     * Update item total
     */
    updateItemTotal(productId, itemTotal) {
        const itemElement = document.querySelector(
            `[data-product-id="${productId}"]`,
        );
        if (itemElement && itemTotal !== undefined) {
            const totalElement = itemElement.querySelector(".item-total");
            if (totalElement) {
                totalElement.textContent = `TK${parseFloat(itemTotal).toFixed(2)}`;
                this.animateElement(totalElement);
            }
        }
    }

    /**
     * Update quantity buttons state
     */
    updateQuantityButtons(form = null) {
        const forms = form
            ? [form]
            : document.querySelectorAll(this.selectors.cartItemForm);

        forms.forEach((form) => {
            const input = form?.querySelector(this.selectors.quantityInput);
            const decrementBtn = form?.querySelector(
                this.selectors.quantityDecrement,
            );
            const incrementBtn = form?.querySelector(
                this.selectors.quantityIncrement,
            );

            if (!input || !decrementBtn || !incrementBtn) return;

            const quantity = parseInt(input.value) || 1;
            const min = parseInt(input.min) || 1;
            const max = parseInt(input.max) || 999;

            // Update decrement button
            decrementBtn.disabled = quantity <= min;
            decrementBtn.classList.toggle("opacity-50", decrementBtn.disabled);
            decrementBtn.classList.toggle(
                "cursor-not-allowed",
                decrementBtn.disabled,
            );

            // Update increment button
            incrementBtn.disabled = quantity >= max;
            incrementBtn.classList.toggle("opacity-50", incrementBtn.disabled);
            incrementBtn.classList.toggle(
                "cursor-not-allowed",
                incrementBtn.disabled,
            );
        });
    }

    /**
     * Update checkout buttons
     */
    updateCheckoutButtons(cartCount = null) {
        const buttons = document.querySelectorAll(this.selectors.checkoutBtn);
        if (!buttons.length) return;

        const count = cartCount !== null ? cartCount : this.getCartCount();

        buttons.forEach((btn) => {
            if (count <= 0) {
                btn.classList.add(
                    "opacity-50",
                    "cursor-not-allowed",
                    "pointer-events-none",
                );
                btn.setAttribute("aria-disabled", "true");
            } else {
                btn.classList.remove(
                    "opacity-50",
                    "cursor-not-allowed",
                    "pointer-events-none",
                );
                btn.removeAttribute("aria-disabled");
            }
        });
    }

    /**
     * Update cart badges
     */
    updateCartBadges() {
        // Get current cart count from server if needed
        fetch("/cart/count")
            .then((response) => response.json())
            .then((data) => {
                if (data.count !== undefined) {
                    this.updateCartCount(data.count);
                }
            })
            .catch((error) => {
                console.error("Failed to fetch cart count:", error);
            });
    }

    /**
     * Check if cart is empty and show message
     */
    checkEmptyCart() {
        const cartItems = document.querySelectorAll(this.selectors.cartItem);
        const cartContainer = document.querySelector(".cart-container");

        if (cartItems.length === 0 && cartContainer) {
            this.showEmptyCartMessage();
        }
    }

    /**
     * Show empty cart message
     */
    showEmptyCartMessage() {
        const cartContainer = document.querySelector(".cart-container");
        if (!cartContainer) return;

        cartContainer.innerHTML = `
            <div class="text-center py-12 animate-fade-in">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-600 mb-4">Add some products to get started!</p>
                <a href="/products" class="inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors font-medium">
                    Continue Shopping
                </a>
            </div>
        `;
    }

    /**
     * Get current cart count from DOM
     */
    getCartCount() {
        const countElement = document.querySelector(this.selectors.cartCount);
        return countElement ? parseInt(countElement.textContent) || 0 : 0;
    }

    /**
     * Show success animation on button
     */
    showSuccessAnimation(button) {
        button.innerHTML = `
            <div class="flex items-center justify-center">
                <svg class="w-5 h-5 text-green-500 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>`;
    }

    /**
     * Set button loading state
     */
    setButtonLoading(button, isLoading, text = null) {
        if (isLoading) {
            button.disabled = true;
            button.classList.add("opacity-75", "cursor-not-allowed");

            if (text) {
                button.innerHTML = `
                    <span class="flex items-center">
                        <svg class="animate-spin h-4 w-4 mr-2" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        ${text}
                    </span>`;
            }
        } else {
            button.disabled = false;
            button.classList.remove("opacity-75", "cursor-not-allowed");
        }
    }

    /**
     * Reset button to original state
     */
    resetButton(button) {
        button.disabled = false;
        button.classList.remove("opacity-75", "cursor-not-allowed");

        // Try to restore original text if available
        if (button.dataset.originalText) {
            button.innerHTML = button.dataset.originalText;
        }
    }

    /**
     * Animate element with pulse effect
     */
    animateElement(element) {
        element.classList.add("animate-pulse");
        setTimeout(() => {
            element.classList.remove("animate-pulse");
        }, 1000);
    }

    /**
     * Show flash message
     */
    showFlash(message, type = "success", duration = 3000) {
        // Use existing flash system or console
        if (typeof window.showFlash === "function") {
            window.showFlash(message, type, duration);
        } else if (typeof window.flash === "function") {
            window.flash(message, type, duration);
        } else {
            console.log(`[${type.toUpperCase()}] ${message}`);

            // Create simple toast notification
            this.showToast(message, type, duration);
        }
    }

    /**
     * Show simple toast notification
     */
    showToast(message, type, duration) {
        const toast = document.createElement("div");
        toast.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-y-0 opacity-100 ${
            type === "success"
                ? "bg-green-500 text-white"
                : type === "error"
                  ? "bg-red-500 text-white"
                  : type === "warning"
                    ? "bg-yellow-500 text-white"
                    : "bg-green-500 text-white"
        }`;
        toast.innerHTML = `
            <div class="flex items-center">
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(toast);

        // Remove toast after duration
        setTimeout(() => {
            toast.style.transform = "translateY(-100%)";
            toast.style.opacity = "0";
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, duration);
    }
}

// Initialize cart manager
(function () {
    let cartManager = null;

    function init() {
        if (!window.cartManager) {
            window.cartManager = new CartManager();
        }
    }

    // Initialize based on DOM state
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(init, 100);
        });
    } else {
        setTimeout(init, 100);
    }

    // Export for use in other modules
    if (typeof module !== "undefined" && module.exports) {
        module.exports = CartManager;
    }
})();
