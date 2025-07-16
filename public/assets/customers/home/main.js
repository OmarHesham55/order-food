// Initialize cart from localStorage or as an empty array
let cart = JSON.parse(localStorage.getItem('cart')) || [];

/**
 * Updates the cart item count displayed in the navbar.
 */
function updateCartCount() {
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    document.getElementById('cart-item-count').textContent = totalItems;
}

/**
 * Renders the cart items in the offcanvas and updates the total price.
 */
function renderCartItems() {
    const cartList = document.getElementById('cart-items-list');
    cartList.innerHTML = ''; // Clear existing items
    let totalPrice = 0;

    if (cart.length === 0) {
        cartList.innerHTML = '<li class="list-group-item text-center text-muted">السلة فارغة.</li>';
    } else {
        cart.forEach(item => {
            const listItem = document.createElement('li');
            listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
            listItem.innerHTML = `
                        <div>
                            ${item.name} <span class="badge bg-secondary">${item.quantity}x</span>
                        </div>
                        <div>
                            $${(item.price * item.quantity).toFixed(2)}
                            <button class="btn btn-sm btn-outline-danger ms-2 remove-from-cart-btn" data-meal-id="${item.id}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    `;
            cartList.appendChild(listItem);
            totalPrice += item.price * item.quantity;
        });
    }

    document.getElementById('cart-total-price').textContent = `$${totalPrice.toFixed(2)}`;
    updateCartCount();
    localStorage.setItem('cart', JSON.stringify(cart)); // Save cart to localStorage
}

/**
 * Adds a meal to the cart or increments its quantity if already present.
 * @param {object} meal - The meal object to add.
 */
function addToCart(meal) {
    const existingItem = cart.find(item => item.id === meal.id);

    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({
            id: meal.id,
            name: meal.name,
            price: meal.price,
            quantity: 1
        });
    }
    renderCartItems(); // Re-render cart after adding
}

/**
 * Removes a meal from the cart or decrements its quantity.
 * If quantity becomes 0, the item is removed from the cart.
 * @param {string} mealId - The ID of the meal to remove.
 */
function removeFromCart(mealId) {
    const itemIndex = cart.findIndex(item => item.id == mealId); // Use == for comparison as data-meal-id is string

    if (itemIndex > -1) {
        if (cart[itemIndex].quantity > 1) {
            cart[itemIndex].quantity--;
        } else {
            cart.splice(itemIndex, 1); // Remove item if quantity is 1
        }
    }
    renderCartItems(); // Re-render cart after removal
}

/**
 * Clears all items from the cart.
 */
function clearCart() {
    cart = [];
    renderCartItems();
}

// Event Listeners
document.addEventListener('DOMContentLoaded', () => {
    renderCartItems(); // Initial render when page loads

    // Add to Cart buttons
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', (event) => {
            const mealId = event.target.dataset.mealId;
            const mealName = event.target.dataset.mealName;
            const mealPrice = parseFloat(event.target.dataset.mealPrice);

            addToCart({ id: mealId, name: mealName, price: mealPrice });
        });
    });

    // Event delegation for Remove from Cart buttons (inside offcanvas)
    document.getElementById('cart-items-list').addEventListener('click', (event) => {
        if (event.target.classList.contains('remove-from-cart-btn') || event.target.closest('.remove-from-cart-btn')) {
            const button = event.target.closest('.remove-from-cart-btn');
            const mealId = button.dataset.mealId;
            removeFromCart(mealId);
        }
    });

    // Clear Cart button
    document.getElementById('clear-cart-button').addEventListener('click', () => {
        clearCart();
    });

    // Checkout button (simple alert for now)
    document.getElementById('checkout-button').addEventListener('click', () => {
        if (cart.length > 0) {
            // In a real application, you would send this data to the server
            // For now, we'll just log it and clear the cart.
            console.log('Processing checkout for:', cart);
            // alert('تم إتمام عملية الشراء بنجاح! (هذه رسالة تجريبية)');
            // Instead of alert, use a custom message box or toast
            const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('cartOffcanvas'));
            if (offcanvas) offcanvas.hide(); // Hide cart offcanvas
            clearCart();
            // Display a success message to the user (e.g., a Bootstrap Toast)
            alert('تم إتمام عملية الشراء بنجاح!'); // Using alert for simplicity in this example
        } else {
            alert('سلة المشتريات فارغة!'); // Using alert for simplicity in this example
        }
    });
});
