function userSearch() {
    const searchInput = document.getElementById('userSearch');
    if (searchInput) {
        searchInput.addEventListener('input', debounce(function() {
            const form = this.closest('form');
            if (form) {
                form.submit();
            }
        }, 500));
    }
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function addToCart(menuId, quantity) {
    const form = document.getElementById('addToCartForm');
    if (form) {
        const menuIdInput = form.querySelector('input[name="menu_id"]');
        const quantityInput = form.querySelector('input[name="quantity"]');
        if (menuIdInput && quantityInput) {
            menuIdInput.value = menuId;
            quantityInput.value = quantity || 1;
            form.submit();
        }
    }
}

/**
 * QRIS Checkout Modal Logic
 * Intercepts checkout form submission when QRIS is selected,
 * shows QR code popup, and submits form after user confirms payment.
 */
function initCheckoutQris() {
    const checkoutForm = document.getElementById('checkoutForm');
    const paymentSelect = document.getElementById('paymentMethodSelect');
    const qrisModal = document.getElementById('qrisPaymentModal');
    const qrisConfirmBtn = document.getElementById('qrisConfirmBtn');

    if (!checkoutForm || !paymentSelect || !qrisModal || !qrisConfirmBtn) return;

    let shouldSubmit = false;

    checkoutForm.addEventListener('submit', function(e) {
        // If user already confirmed QRIS payment, allow normal submit
        if (shouldSubmit) return;

        const selectedMethod = paymentSelect.value;

        if (selectedMethod === 'qris') {
            e.preventDefault();

            // Validate form first before showing modal
            if (!checkoutForm.checkValidity()) {
                checkoutForm.reportValidity();
                return;
            }

            // Show QRIS modal
            const modal = new bootstrap.Modal(qrisModal);
            modal.show();
        }
        // For cash and transfer, allow normal submit
    });

    // When user clicks "OK, Sudah Bayar"
    qrisConfirmBtn.addEventListener('click', function() {
        shouldSubmit = true;

        // Close the modal
        const modal = bootstrap.Modal.getInstance(qrisModal);
        if (modal) modal.hide();

        // Submit the form
        checkoutForm.submit();
    });
}

document.addEventListener('DOMContentLoaded', function() {
    userSearch();
    initCheckoutQris();
});
