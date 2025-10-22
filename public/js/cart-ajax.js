(function () {
    function csrf() {
        const m = document.querySelector('meta[name="csrf-token"]');
        return m ? m.getAttribute("content") : "";
    }
    function vnd(n) {
        return Number(n).toLocaleString("vi-VN") + "đ";
    }

    function showToast(payload) {
        const wrap = document.getElementById("cart-toast");
        if (!wrap) return;

        const head = wrap.querySelector(".toast-head");
        const titleEl = wrap.querySelector(".toast-title");
        const body = wrap.querySelector(".toast-body");
        const closeBtn = wrap.querySelector(".toast-close");

        const ok = !!payload.ok;
        head.classList.toggle("error", !ok);
        titleEl.textContent =
            payload.title ||
            (ok ? "Thêm vào giỏ hàng thành công" : "Không thể thêm vào giỏ");

        if (ok && payload.product) {
            const img = payload.product.image || "";
            const imgSrc = /^https?:\/\//i.test(img)
                ? img
                : (window.ASSET_BASE || "") + img;
            body.innerHTML = `
        <div class="row">
          <img src="${imgSrc}" alt="">
          <div>
            <div style="font-weight:600">${payload.product.name || ""}</div>
            ${
                payload.product.size
                    ? `<div>Size: ${payload.product.size}</div>`
                    : ``
            }
          </div>
        </div>
        <div style="height:1px;background:#eee;margin:12px 0"></div>
        <div style="display:flex;gap:10px;align-items:baseline">
          <span>Giỏ hàng hiện có</span>
          <strong style="margin-left:auto;color:#c44">${vnd(
              payload.cart_total || 0
          )}</strong>
        </div>
      `;
        } else {
            body.textContent = payload.message || "Có lỗi xảy ra.";
        }

        wrap.style.display = "block";
        closeBtn.onclick = () => {
            wrap.style.display = "none";
        };
    }
    window.showCartToast = showToast;

    async function postForm(url, formData) {
        const res = await fetch(url, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrf(),
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
            },
            body: formData,
        });
        if (!res.ok) {
            let msg = "Không thể thêm vào giỏ";
            try {
                const j = await res.json();
                msg = j.message || msg;
            } catch {}
            return { ok: false, message: msg };
        }
        const data = await res.json();
        if (!data.ok)
            return {
                ok: false,
                message: data.message || "Không thể thêm vào giỏ",
            };
        return { ok: true, ...data };
    }

    // 1) Bắt form "Thêm vào giỏ" ở trang chi tiết
    document.addEventListener("submit", async function (e) {
        const form = e.target;
        if (!(form instanceof HTMLFormElement)) return;
        const addUrl = window.CART_ADD_URL || "";
        if (!addUrl) return; // chưa cấu hình route

        // chỉ chặn form trỏ tới cart.add
        if (form.getAttribute("action") !== addUrl) return;

        e.preventDefault();
        const fd = new FormData(form);
        const result = await postForm(addUrl, fd);

        if (result.ok) {
            if (result.cart_count != null) {
                const badge = document.getElementById("cart-count");
                if (badge) badge.textContent = result.cart_count;
            }
            showToast({
                ok: true,
                title: "Thêm vào giỏ hàng thành công",
                product: result.product,
                cart_total: result.cart_total,
            });
        } else {
            showToast({
                ok: false,
                title: "Không thể thêm vào giỏ",
                message: result.message,
            });
        }
    });

    // 2) Bắt nút thêm giỏ ở related/menu dùng data-product-id
    document.addEventListener("click", async function (e) {
        const btn = e.target.closest(
            "button.related-cart-btn, button.menu-card-cart"
        );
        if (!btn) return;

        // LẤY product_id (chỉ có ở sản phẩm KHÔNG size)
        const productId = btn.getAttribute("data-product-id");

        // Nếu KHÔNG có productId => đây là LINK sang trang chi tiết -> ĐỪNG chặn
        if (!productId) {
            return; // cho browser điều hướng bình thường
        }

        // Có productId => thêm giỏ bằng AJAX
        e.preventDefault();

        const fd = new FormData();
        fd.append("product_id", productId);

        try {
            const res = await fetch(window.CART_ADD_URL, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
                body: fd,
            });

            if (!res.ok) {
                const text = await res.text();
                let msg = "Không thể thêm vào giỏ";
                try {
                    const j = JSON.parse(text);
                    msg = j.message || msg;
                } catch {}
                return window.showCartToast?.({
                    ok: false,
                    title: "Không thể thêm vào giỏ",
                    message: msg,
                });
            }

            const data = await res.json();
            if (!data.ok) {
                return window.showCartToast?.({
                    ok: false,
                    title: "Không thể thêm vào giỏ",
                    message: data.message || "",
                });
            }

            if (data.cart_count != null) {
                const badge = document.getElementById("cart-count");
                if (badge) badge.textContent = data.cart_count;
            }

            window.showCartToast?.({
                ok: true,
                title: "Thêm vào giỏ hàng thành công",
                product: data.product,
                cart_total: data.cart_total,
            });
        } catch (err) {
            window.showCartToast?.({
                ok: false,
                title: "Không thể thêm vào giỏ",
                message: "Mạng lỗi hoặc máy chủ bận.",
            });
        }
    });
})();
