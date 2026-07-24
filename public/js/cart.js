function updateCartQuantity(cartItemId, newQuantity) {
    const form = document.getElementById('updateCart-' + cartItemId);
    if (form) {
        const quantityInput = form.querySelector('input[name="quantity"]');
        if (quantityInput) {
            quantityInput.value = newQuantity;
            form.submit();
        }
    }
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
}

function decrementQuantity(input) {
    const currentValue = parseInt(input.value) || 1;
    if (currentValue > 1) {
        input.value = currentValue - 1;
    }
}

function autoUpdateCart(input, cartItemId) {
    let timeout;
    input.addEventListener('input', function() {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            updateCartQuantity(cartItemId, input.value);
        }, 800);
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
