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
