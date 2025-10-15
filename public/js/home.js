document.addEventListener("DOMContentLoaded", () => {
    const nav = document.querySelector(".nav");
    const navLinks = document.querySelectorAll(".nav a");

    // ======= Tạo nút toggle =======
    const toggle = document.createElement("button");
    toggle.className = "menu-toggle";
    toggle.innerText = "☰";
    const headerBody = document.querySelector(".header .body");
    headerBody.insertBefore(toggle, nav);

    // ======= Toggle menu =======
    toggle.addEventListener("click", () => {
        nav.classList.toggle("active");
    });

    // ======= Khi click vào link =======
    navLinks.forEach((link) => {
        link.addEventListener("click", () => {
            navLinks.forEach((l) => l.classList.remove("active"));
            link.classList.add("active");
            nav.classList.remove("active");
        });
    });

    // ======= Giữ màu khi load lại trang =======
    const currentURL = new URL(window.location.href);
    const currentPath = currentURL.pathname; // ví dụ: "/", "/menu"
    const currentHash = currentURL.hash; // ví dụ: "", "#about", "#contact"

    navLinks.forEach((link) => {
        const linkURL = new URL(link.href, window.location.origin);
        const linkPath = linkURL.pathname;
        const linkHash = linkURL.hash;

        // Reset hết trước
        link.classList.remove("active");

        // Nếu đang ở các trang riêng như /menu
        if (linkPath === currentPath && linkPath !== "/" && !linkHash) {
            link.classList.add("active");
        }

        // Nếu đang ở trang chủ và không có hash (#)
        if (
            currentPath === "/" &&
            !currentHash &&
            linkPath === "/" &&
            !linkHash
        ) {
            link.classList.add("active");
        }

        // Nếu đang ở trang chủ và có hash (#about, #contact)
        if (
            currentPath === "/" &&
            currentHash &&
            linkPath === "/" &&
            linkHash === currentHash
        ) {
            link.classList.add("active");
        }
    });
});
