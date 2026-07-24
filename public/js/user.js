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

document.addEventListener('DOMContentLoaded', function() {
    userSearch();
});
