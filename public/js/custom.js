function confirmDelete(message = "Yakin hapus?") {
    return confirm(message);
}

function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (!preview) return;

    const file = input.files && input.files[0];

    // Dibatalkan / bukan gambar: kembalikan gambar asli jika ada, kalau tidak sembunyikan
    if (!file || !file.type.startsWith("image/")) {
        input.value = "";
        if (preview.dataset.original) {
            preview.src = preview.dataset.original;
            preview.style.display = "block";
        } else {
            preview.removeAttribute("src");
            preview.style.display = "none";
        }
        return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
        preview.src = e.target.result;
        preview.style.display = "block";
    };
    reader.readAsDataURL(file);
}
function showToast(message, type = "success") {
    const container =
        document.querySelector(".toast-container") || createToastContainer();
    const textColor =
        type === "warning" || type === "light" ? "text-dark" : "text-white";
    const closeClass = textColor === "text-white" ? "btn-close-white" : "";

    const el = document.createElement("div");
    el.className = `toast align-items-center ${textColor} bg-${type} border-0`;
    el.setAttribute("role", "alert");
    el.innerHTML = `
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close ${closeClass} me-2 m-auto"
                data-bs-dismiss="toast" aria-label="Tutup"></button>
        </div>`;
    el.querySelector(".toast-body").textContent = message; // aman dari XSS

    container.appendChild(el);
    el.addEventListener("hidden.bs.toast", () => el.remove());
    new bootstrap.Toast(el, { delay: 3000 }).show();
}

function createToastContainer() {
    const container = document.createElement("div");
    container.className = "toast-container position-fixed top-0 end-0 p-3";
    container.style.zIndex = 1100;
    document.body.appendChild(container);
    return container;
}

function setLoading(button, isLoading) {
    if (isLoading) {
        button.classList.add("btn-loading");
        button.disabled = true;
    } else {
        button.classList.remove("btn-loading");
        button.disabled = false;
    }
}

function initializeForms() {
    document.querySelectorAll("form").forEach((form) => {
        form.addEventListener("submit", function (e) {
            // Jangan kunci tombol jika submit dibatalkan (mis. konfirmasi hapus ditolak)
            if (e.defaultPrevented) return;

            const submitBtn = form.querySelector(
                'button[type="submit"], button:not([type])',
            );
            if (submitBtn) setLoading(submitBtn, true);
        });
    });
}

// Reset tombol saat halaman dipulihkan dari cache (tombol Back browser)
window.addEventListener("pageshow", function (e) {
    if (e.persisted) {
        document
            .querySelectorAll(".btn-loading")
            .forEach((b) => setLoading(b, false));
    }
});

document.addEventListener("DOMContentLoaded", function () {
    initializeForms();

    // Tutup otomatis hanya untuk pesan sementara; error/peringatan tetap tampil
    setTimeout(function () {
        document
            .querySelectorAll(".alert-success, .alert-info")
            .forEach(function (alert) {
                bootstrap.Alert.getOrCreateInstance(alert).close();
            });
    }, 5000);
});
