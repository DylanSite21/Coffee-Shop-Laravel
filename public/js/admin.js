function adminSearch() {
    const searchInput = document.getElementById('adminSearch');
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

function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    if (sidebar) {
        sidebar.classList.toggle('show');
    }
}

function initAdminCharts() {
    const revenueData = document.getElementById('revenueChart');
    if (revenueData) {
        console.log('Revenue chart initialized');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    adminSearch();
    initAdminCharts();
});
