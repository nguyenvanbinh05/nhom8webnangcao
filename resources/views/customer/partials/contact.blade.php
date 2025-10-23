<section class="contact-section" id="contact">
    <div class="main-content">
        <div class="body">
            <!-- Cột thông tin bên trái -->
            <div class="contact-info">
                <h3 class="contact-title">Liên Hệ Với Chúng Tôi</h3>
                <p class="contact-desc">
                    Nếu bạn có bất kỳ câu hỏi hay góp ý nào, đừng ngần ngại liên hệ với chúng tôi qua thông tin bên dưới
                    hoặc gửi tin nhắn trực tiếp.
                </p>

                <p><strong>Địa chỉ:</strong> 123 Đường ABC, Quận 1, TP. Hồ Chí Minh</p>
                <p><strong>Email:</strong> caphe@shop.com</p>
                <p><strong>Hotline:</strong> 0373526354</p>
                <p><strong>Giờ mở cửa:</strong> 7:00 - 22:00 (Thứ 2 - Chủ Nhật)</p>
            </div>

            <!-- Cột form liên hệ bên phải -->
            <div class="contact-form">
                <h4 class="form-title">Gửi tin nhắn trực tiếp cho chúng tôi</h4>

                <div id="contact-alert" class="contact-alert" hidden></div>

                <form id="contact-form" action="{{ route('contact.send') }}" method="post" novalidate>
                    @csrf
                    <input type="email" name="email"
                        placeholder="Email của bạn. (chúng tôi sẽ liên hệ với bạn qua email này !)" required>
                    <input type="text" name="subject" placeholder="Tiêu đề">
                    <textarea name="message" placeholder="Nội dung" rows="4" required></textarea>
                    <button type="submit" class="btn-submit">Gửi</button>
                </form>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const form = document.getElementById('contact-form');
                    const alert = document.getElementById('contact-alert');
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const btn = form.querySelector('button[type="submit"]');

                    function showAlert(text, type = 'success') {
                        alert.hidden = false;
                        alert.textContent = '';
                        alert.innerHTML = text;
                        alert.className = 'contact-alert ' + (type === 'success' ? 'is-success' : 'is-error');
                    }

                    form.addEventListener('submit', async (e) => {
                        e.preventDefault();

                        btn.disabled = true;
                        btn.dataset.oldText = btn.textContent;
                        btn.textContent = 'Đang gửi...';

                        const formData = new FormData(form);

                        try {
                            const res = await fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': token,
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: formData
                            });

                            if (res.status === 422) {
                                const data = await res.json();
                                const list = Object.values(data.errors).flat().map(e => `<li>${e}</li>`).join('');
                                showAlert(`<ul>${list}</ul>`, 'error');
                            } else if (!res.ok) {
                                showAlert('Có lỗi xảy ra. Vui lòng thử lại.', 'error');
                            } else {
                                const data = await res.json();
                                showAlert(data.message || 'Gửi thành công!', 'success');
                                form.reset();
                            }
                        } catch (err) {
                            showAlert('Không thể kết nối máy chủ. Vui lòng thử lại.', 'error');
                        } finally {
                            btn.disabled = false;
                            btn.textContent = btn.dataset.oldText || 'Gửi';
                        }
                    });
                });
            </script>
        </div>
    </div>
</section>