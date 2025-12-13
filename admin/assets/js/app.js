// const toggleBtn = document.getElementById("menuToggle");
// const menu = document.getElementById("verticalMenu");

// toggleBtn.addEventListener("click", () => {
//     menu.classList.toggle("active");
// });


const toggleBtn = document.getElementById("toggleSidebar");
const sidebar = document.getElementById("sidebar");
const submenuToggle = document.querySelector(".submenu-toggle");

toggleBtn.addEventListener("click", () => {
    sidebar.classList.toggle("collapsed");
});

submenuToggle.addEventListener("click", () => {
    submenuToggle.parentElement.classList.toggle("active");
});

