// ================== DROPDOWN SIDEBAR ==================
const sidebarItemDropdown = document.querySelectorAll('.sidebar__link-dropdown');
const sidebarSubmenuAll = document.querySelectorAll(".sidebar__submenu--hidden");

if (sidebarItemDropdown.length > 0) {
    sidebarItemDropdown.forEach(item => {
        item.addEventListener("click", function (e) {
            e.preventDefault();

            sidebarSubmenuAll.forEach(submenu => {
                if (submenu !== this.parentElement.querySelector(".sidebar__submenu--hidden")) {
                    submenu.classList.remove('dropdown-active');
                }
            });

            const sidebarSubmenu = this.parentElement.querySelector(".sidebar__submenu--hidden");
            if (sidebarSubmenu) {
                sidebarSubmenu.classList.toggle('dropdown-active');
            }
        });
    });
}


// ================== FORM ADD/EDIT ==================
const buttonAddForm = document.querySelector(".buttonAddForm");
const buttonEditForm = document.querySelectorAll(".buttonEditForm");
const formInput = document.querySelector(".formInput");
const formUpdate = document.querySelector(".formUpdate");
const btnCloseForm = document.querySelectorAll(".btnCloseForm");
const formUpdateCategory = document.getElementById('categoryupdateForm');

if (buttonAddForm && formInput) {
    buttonAddForm.addEventListener("click", function (e) {
        e.preventDefault();
        formInput.classList.add('active');
    });
}

if (buttonEditForm.length > 0 && formUpdate) {
    buttonEditForm.forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            const id = this.dataset.id; // data-id="{{ $category->idCategory }}"
            const name = this.dataset.name; // data-name="{{ $category->NameCategory }}"
            const desc = this.dataset.desc; // data-desc="{{ $category->description }}"
            const status = this.dataset.status; // data-status="{{ $category->Status }}"

            // Điền dữ liệu vào form
            document.getElementById('editNameCategory').value = name;
            document.getElementById('editdescription').value = desc;
            document.getElementById('editstatus').value = status;

            formUpdateCategory.action = routeUpdateTemplate.replace(':id', id);

            // Hiển thị form
            formUpdate.classList.add("active");
        });
    });
}

if (btnCloseForm.length > 0) {
    btnCloseForm.forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            formInput?.classList.remove("active");
            formUpdate?.classList.remove("active");
        });
    });
}


// ================== ẢNH CHÍNH SẢN PHẨM ==================
const mainImageInput = document.getElementById("mainImage");
const mainImagePreview = document.getElementById("mainImagePreview");
const mainImageBox = document.getElementById("mainImageBox");

if (mainImageInput && mainImagePreview && mainImageBox) {
    mainImageBox.addEventListener("click", () => mainImageInput.click());
    mainImageInput.addEventListener("change", () => {
        const file = mainImageInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                mainImagePreview.src = e.target.result;
                mainImagePreview.style.display = "block";
                const placeholder = mainImageBox.querySelector(".product-form__image-placeholder");
                if (placeholder) placeholder.style.display = "none";
            };
            reader.readAsDataURL(file);
        }
    });
}


// ================== ẢNH PHỤ ==================
const additionalImagesInput = document.getElementById("additionalImage");
const additionalImagesPreview = document.getElementById("additionalImagesPreview");
const additionalAction = document.querySelector(".product-form__additional-action");

if (additionalImagesInput && additionalImagesPreview && additionalAction) {
    additionalAction.addEventListener("click", () => additionalImagesInput.click());
    additionalImagesInput.addEventListener("change", () => {
        const files = additionalImagesInput.files;
        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.classList.add("product-form__image-list--item");
                additionalImagesPreview.prepend(img);
            };
            reader.readAsDataURL(file);
        });
        // additionalImagesInput.value = "";
    });
}
