(function () {
    const sidebar = document.querySelector(".menu-sidebar");
    if (!sidebar) return;

    const catsEl = sidebar.querySelector("ul");
    const formEl = sidebar.querySelector(".menu-search");
    const CONTENT_SEL = "#menu-content";

    function getContentEl() {
        return document.querySelector(CONTENT_SEL);
    }

    function setLoading(on) {
        const el = getContentEl();
        if (!el) return;
        el.style.opacity = on ? "0.6" : "";
        el.setAttribute("aria-busy", on ? "true" : "false");
    }

    async function loadAndSwap(url, push = true) {
        try {
            setLoading(true);
            const res = await fetch(url, {
                headers: { "X-Requested-With": "XMLHttpRequest" },
            });
            const html = await res.text();

            const doc = new DOMParser().parseFromString(html, "text/html");
            const next = doc.querySelector(CONTENT_SEL);
            const cur = getContentEl();
            if (!next || !cur) throw new Error("Không tìm thấy #menu-content");

            cur.replaceWith(next); // DOM updated
            if (push) history.pushState({ ajax: true }, "", url);
        } catch (e) {
            // fallback nếu có lỗi
            location.href = url;
        } finally {
            setLoading(false);
        }
    }

    // Click danh mục
    if (catsEl) {
        catsEl.addEventListener("click", function (e) {
            const a = e.target.closest("a");
            if (!a) return;
            if (e.metaKey || e.ctrlKey || e.shiftKey || e.button === 1) return; // mở tab mới thì kệ

            e.preventDefault();

            // giữ keyword hiện tại
            const q = formEl?.querySelector('[name="q"]')?.value || "";
            const url = new URL(a.href, location.origin);
            if (q) url.searchParams.set("q", q);

            // đánh dấu active ở sidebar
            catsEl
                .querySelectorAll("a.active")
                .forEach((x) => x.classList.remove("active"));
            a.classList.add("active");

            loadAndSwap(url.toString(), true);
        });
    }

    // Tìm kiếm
    if (formEl) {
        formEl.addEventListener("submit", function (e) {
            e.preventDefault();
            const url = new URL(formEl.action, location.origin);
            const q = formEl.querySelector('[name="q"]')?.value || "";
            if (q) url.searchParams.set("q", q);
            loadAndSwap(url.toString(), true);
        });

        // Debounce khi gõ
        let t = null;
        const input = formEl.querySelector('[name="q"]');
        if (input) {
            input.addEventListener("input", function () {
                clearTimeout(t);
                t = setTimeout(() => {
                    const url = new URL(formEl.action, location.origin);
                    const q = input.value || "";
                    if (q) url.searchParams.set("q", q);
                    loadAndSwap(url.toString(), true);
                }, 350);
            });
        }
    }

    // Back/Forward
    window.addEventListener("popstate", function () {
        loadAndSwap(location.href, false);
    });
})();
