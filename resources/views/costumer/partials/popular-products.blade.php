<section class="popular-products">
    <div class="title">
        <h1>Sản phẩm nổi bật</h1>
    </div>

    <div class="main-content">
        <div class="slider-container">
            <button class="slide-btn prev">&#10094;</button>

            <div class="product-slider">
                @for ($i = 1; $i <= 10; $i++)
                    <div class="product-card">
                        <div class="product-image">
                            <a href="#">
                                <img src="{{ asset('images/products/capheden.svg') }}" alt="Cà phê đen">
                            </a>
                        </div>

                        <div class="product-info">
                            <a href="#" class="product-name">Cà Phê Đen</a>
                            <p class="price">55.000đ</p>
                        </div>

                        <button class="add-cart-btn" title="Thêm vào giỏ hàng">
                            <img src="{{ asset('images/icons/cart.svg') }}" alt="Thêm vào giỏ hàng">
                        </button>
                    </div>
                @endfor
            </div>

            <button class="slide-btn next">&#10095;</button>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const slider = document.querySelector(".product-slider");
            const prevBtn = document.querySelector(".slide-btn.prev");
            const nextBtn = document.querySelector(".slide-btn.next");
            if (!slider) return;

            const isDesktop = () => window.innerWidth > 992;

            function getStep() {
                const card = slider.querySelector(".product-card");
                if (!card) return 0;
                const gap = parseInt(getComputedStyle(slider).gap) || 0;
                return card.offsetWidth + gap;
            }

            // ===== Prev/Next (desktop) =====
            const onNext = () => slider.scrollBy({ left: getStep(), behavior: "smooth" });
            const onPrev = () => slider.scrollBy({ left: -getStep(), behavior: "smooth" });

            if (nextBtn) nextBtn.addEventListener("click", onNext);
            if (prevBtn) prevBtn.addEventListener("click", onPrev);

            // ===== Drag to scroll (desktop only) =====
            let isDown = false, startX = 0, scrollLeft = 0;

            function onMouseDown(e) {
                if (!isDesktop()) return;
                isDown = true;
                slider.classList.add("dragging");
                startX = e.pageX - slider.getBoundingClientRect().left;
                scrollLeft = slider.scrollLeft;
            }
            function onMouseMove(e) {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - slider.getBoundingClientRect().left;
                const walk = x - startX;
                slider.scrollLeft = scrollLeft - walk;
            }
            function onMouseUpLeave() {
                isDown = false;
                slider.classList.remove("dragging");
            }

            slider.addEventListener("mousedown", onMouseDown);
            slider.addEventListener("mousemove", onMouseMove);
            slider.addEventListener("mouseup", onMouseUpLeave);
            slider.addEventListener("mouseleave", onMouseUpLeave);

            // ===== Wheel behavior =====
            // Mục tiêu:
            // - Desktop: để cuộn dọc TRANG bình thường. Chỉ cuộn ngang khi người dùng
            //   + thật sự cuộn ngang (deltaX lớn hơn), hoặc
            //   + giữ Shift rồi lăn (tuỳ chọn).
            // - Mobile (<=992): không làm gì (grid 2 cột).
            function onWheel(e) {
                if (!isDesktop()) return; // grid mode: để trình duyệt xử lý mặc định

                const absX = Math.abs(e.deltaX);
                const absY = Math.abs(e.deltaY);

                // Nếu người dùng đang lăn DỌC (thường xuyên nhất) => để trang cuộn, KHÔNG preventDefault.
                if (absY >= absX && !e.shiftKey) {
                    return; // do nothing -> page scrolls vertically as normal
                }

                // Trường hợp muốn hỗ trợ cuộn NGANG:
                // 1) Trackpad cuộn ngang thật sự (absX > absY), hoặc
                // 2) Người dùng giữ Shift + lăn
                if (absX > absY || e.shiftKey) {
                    e.preventDefault(); // cần passive:false khi addEventListener
                    const delta = absX > absY ? e.deltaX : e.deltaY;
                    slider.scrollLeft += delta;
                }
            }
            slider.addEventListener("wheel", onWheel, { passive: false });

            // ===== Resize guard: khi chuyển về desktop/mobile thì reset state =====
            function onResize() {
                if (isDesktop()) {
                    // desktop: nothing; để slider hoạt động
                } else {
                    // mobile/tablet: đảm bảo không còn trạng thái kéo
                    isDown = false;
                    slider.classList.remove("dragging");
                }
            }
            window.addEventListener("resize", onResize);
            onResize();
        });
    </script>


</section>