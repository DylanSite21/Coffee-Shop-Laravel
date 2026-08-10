function updateCartQuantity(cartItemId, newQuantity) {
    const form = document.getElementById('updateCart-' + cartItemId);
    if (!form) return;

    const quantityInput = form.querySelector('input[name="quantity"]');
    if (quantityInput) {
        quantityInput.value = newQuantity;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken || ''
        },
        body: formData
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        throw new Error('Network response was not ok');
    })
    .then(data => {
        if (data.success) {
            // Update subtotal for this item
            const subtotalElem = document.getElementById('subtotal-' + cartItemId);
            if (subtotalElem) {
                subtotalElem.textContent = data.item_subtotal;
            }
            // Update cart total
            const totalElem = document.getElementById('cart-total');
            if (totalElem) {
                totalElem.textContent = data.cart_total;
            }
            // Update navbar cart badge
            const badgeElem = document.querySelector('.cart-badge');
            if (badgeElem) {
                if (data.cart_count > 0) {
                    badgeElem.textContent = data.cart_count > 99 ? '99+' : data.cart_count;
                    badgeElem.style.display = 'flex';
                } else {
                    badgeElem.style.display = 'none';
                }
            } else if (data.cart_count > 0) {
                const cartLink = document.querySelector('a[href*="cart"]');
                if (cartLink) {
                    const newBadge = document.createElement('span');
                    newBadge.className = 'cart-badge';
                    newBadge.textContent = data.cart_count > 99 ? '99+' : data.cart_count;
                    cartLink.appendChild(newBadge);
                }
            }
        } else {
            form.submit();
        }
    })
    .catch(error => {
        console.warn('AJAX cart update failed, falling back to form submit:', error);
        form.submit();
    });
}

function removeCartItem(cartItemId) {
    const form = document.getElementById('removeCart-' + cartItemId);
    if (form) {
        form.submit();
    }
}

function incrementQuantity(input) {
    const currentValue = parseInt(input.value) || 1;
    input.value = currentValue + 1;
    input.dispatchEvent(new Event('input', { bubbles: true }));
}

function decrementQuantity(input) {
    const currentValue = parseInt(input.value) || 1;
    if (currentValue > 1) {
        input.value = currentValue - 1;
        input.dispatchEvent(new Event('input', { bubbles: true }));
    }
}

function autoUpdateCart(input, cartItemId) {
    let timeout;
    input.addEventListener('input', function() {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            updateCartQuantity(cartItemId, input.value);
        }, 400);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.cart-quantity-input').forEach(input => {
        const cartItemId = input.dataset.cartItemId;
        if (cartItemId) {
            autoUpdateCart(input, cartItemId);
        }
    });
});
