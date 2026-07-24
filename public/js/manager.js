function managerSearch() {
    const searchInput = document.getElementById('managerSearch');
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

function quickAction(orderId, action) {
    const form = document.getElementById('action-' + action + '-' + orderId);
    if (form) {
        form.submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    managerSearch();
});
