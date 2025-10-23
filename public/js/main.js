let root = document.documentElement;
let toggleSidebar = document.querySelector(".header__toggle-sidebar");
let sidebar = document.querySelector(".sidebar");
let sidebarTitle = document.querySelector(".sidebar__title");
let container_mainContent = document.querySelector(".container_mainContent");

toggleSidebar.addEventListener("click", function () {

    sidebar.classList.toggle("active");
    container_mainContent.classList.toggle("active");
    sidebar.classList.toggle("collapsed");

})


// // ================== FORM ADD/EDIT ==================
const formInput = document.querySelector(".formInput");
const btnCloseForm = document.querySelectorAll(".btnCloseForm");
const buttonAddForm = document.querySelector(".buttonAddForm");

if (formInput) {
    buttonAddForm.addEventListener("click", function (e) {
        e.preventDefault();
        formInput.classList.add('active');
    });
}

// Đóng form
if (btnCloseForm.length > 0) {
    btnCloseForm.forEach(btn => {
        btn.addEventListener('click', function() {
            // Tìm phần tử cha gần nhất có class 'formInput' hoặc 'formUpdate'
            const formContainer = this.closest('.formInput') || this.closest('.formUpdate');
            if (formContainer) {
                formContainer.classList.remove('active'); // Ẩn form
            }
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
