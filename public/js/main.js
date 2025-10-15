// dropdown trong sidebar
const sidebarItemDropdown = document.querySelectorAll('.sidebar__link-dropdown');
const sidebarSubmenuAll = document.querySelectorAll(".sidebar__submenu--hidden");

sidebarItemDropdown.forEach(item => {
    item.addEventListener("click", function(e){
        e.preventDefault(); // Ngăn link #

        // Đóng tất cả dropdown khác
        sidebarSubmenuAll.forEach(submenu => {
            if(submenu !== this.parentElement.querySelector(".sidebar__submenu--hidden")){
                submenu.classList.remove('dropdown-active');
            }
        });

        // Mở/đóng dropdown của item hiện tại
        const sidebarSubmenu = this.parentElement.querySelector(".sidebar__submenu--hidden");
        if(sidebarSubmenu){
            sidebarSubmenu.classList.toggle('dropdown-active');
        }
    });
});


// hiển thị form thêm mới danh mục, nhà cung cấp
const buttonAddForm = document.querySelector(".buttonAddForm");
const buttonEditForm = document.querySelectorAll(".buttonEditForm");
const formInput = document.querySelector(".formInput");
const formUpdate = document.querySelector(".formUpdate");
const btnCloseForm = document.querySelectorAll(".btnCloseForm");

buttonAddForm.addEventListener("click", function(e){
    e.preventDefault();
    formInput.classList.add('active');
})

buttonEditForm.forEach(btn => {
    btn.addEventListener("click", function(e){
        e.preventDefault();
        const row = btn.closest("tr");
        const name = row.querySelector(".name").textContent;
        const email = row.querySelector(".phone").textContent;
        const phone = row.querySelector(".email").textContent;
        const address = row.querySelector(".address").textContent;
        const note = row.querySelector(".note").textContent;

        
        document.getElementById("editname").value = name;
        document.getElementById("editphone").value = phone;
        document.getElementById("editemail").value = email;
        document.getElementById("editaddress").value = address;
        document.getElementById("editnote").value = note;

        formUpdate.classList.add("active");
    });
});

// ======== ĐÓNG FORM ========
btnCloseForm.forEach(btn => {
    btn.addEventListener("click", function(e){
        e.preventDefault();
        formInput.classList.remove("active");
        formUpdate.classList.remove("active");
    });
});

// hiển thị form chỉnh sửa thông tin danh mục, nhà cung cấp

