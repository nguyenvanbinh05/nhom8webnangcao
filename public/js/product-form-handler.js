document.addEventListener("DOMContentLoaded", function () {
    // === XEM TRƯỚC ẢNH CHÍNH ===
    const mainImageInput = document.getElementById('mainImage');
    const mainImagePreview = document.getElementById('mainImagePreview');

    if (mainImageInput && mainImagePreview) {
        mainImageInput.addEventListener('change', e => {
            const file = e.target.files[0];
            if (file) {
                mainImagePreview.src = URL.createObjectURL(file);
                mainImagePreview.style.display = 'block';
            }
        });
    }

    // === XEM TRƯỚC ẢNH PHỤ ===
    const additionalInput = document.getElementById('additionalImage');
    let previewContainer = document.querySelector('#additionalImagesPreview');

    // Nếu form thêm mới, có thể chưa có previewContainer -> tự tạo
    if (!previewContainer) {
        previewContainer = document.createElement('div');
        previewContainer.id = 'additionalImagesPreview';
        previewContainer.classList.add('additional-preview-container');
        additionalInput.parentNode.appendChild(previewContainer);
    }

    if (additionalInput) {
        additionalInput.addEventListener('change', e => {
            const files = Array.from(e.target.files);

            // Khi chọn ảnh mới -> xoá ảnh cũ hiển thị sẵn (nếu có)
            previewContainer.innerHTML = '';

            files.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = ev => {
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('preview-item');

                    const img = document.createElement('img');
                    img.src = ev.target.result;
                    img.classList.add('preview-img');

                    const remove = document.createElement('span');
                    remove.innerHTML = '&times;';
                    remove.classList.add('remove-btn');

                    remove.addEventListener('click', () => {
                        files.splice(index, 1);
                        const dt = new DataTransfer();
                        files.forEach(f => dt.items.add(f));
                        additionalInput.files = dt.files;
                        wrapper.remove();
                    });

                    wrapper.appendChild(img);
                    wrapper.appendChild(remove);
                    previewContainer.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        });
    }

    // === CHUYỂN GIỮA SINGLE / MULTIPLE PRICE ===
    const productType = document.getElementById('productType');
    const singlePriceField = document.getElementById('singlePriceField');
    const multipleSizeField = document.getElementById('multipleSizeField');

    productType.addEventListener('change', function() {
        if (this.value === 'single') {
            singlePriceField.style.display = 'block';
            multipleSizeField.style.display = 'none';
        } else if (this.value === 'multiple') {
            singlePriceField.style.display = 'none';
            multipleSizeField.style.display = 'block';
        } else {
            singlePriceField.style.display = 'none';
            multipleSizeField.style.display = 'none';
        }
    });
    
});