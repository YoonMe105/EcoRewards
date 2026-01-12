// const toggleBtn = document.getElementById("menuToggle");
// const menu = document.getElementById("verticalMenu");

// toggleBtn.addEventListener("click", () => {
//     menu.classList.toggle("active");
// });


const toggleBtn = document.getElementById("toggleSidebar");
const sidebar = document.getElementById("sidebar");

toggleBtn.addEventListener("click", () => {
    sidebar.classList.toggle("collapsed");
});

document.querySelector('.submenubtn').addEventListener('click', function (e) {
    e.preventDefault(); // prevent #
    this.parentElement.classList.toggle('active');
});





