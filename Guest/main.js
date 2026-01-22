// hamburger icon
document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.getElementById("hamburger");
    const navMenu = document.getElementById("navMenu");

    hamburger.addEventListener("click", function () {
        navMenu.classList.toggle("active");   // show/hide menu
        hamburger.classList.toggle("open");   // rotate hamburger
    });
});

// Event
document.addEventListener('DOMContentLoaded', function() {
    const pastBtn = document.getElementById('past-btn');
    const upcomingBtn = document.getElementById('upcoming-btn');
    const pastEvents = document.getElementById('past-events');
    const upcomingEvents = document.getElementById('upcoming-events');

    // Toggle Buttons
    pastBtn.addEventListener('click', function() {
        pastEvents.style.display = 'grid';
        upcomingEvents.style.display = 'none';
        pastBtn.classList.add('active');
        upcomingBtn.classList.remove('active');
    });

    upcomingBtn.addEventListener('click', function() {
        pastEvents.style.display = 'none';
        upcomingEvents.style.display = 'grid';
        upcomingBtn.classList.add('active');
        pastBtn.classList.remove('active');
    });
});

// Register
// Open register modal
document.querySelector('.btn-register').addEventListener('click', () => {
    document.getElementById('registerModal').style.display = 'flex';
});

// Close register modal
function closeRegisterModal() {
    document.getElementById('registerModal').style.display = 'none';
    document.getElementById('registerForm').reset();
    document.getElementById('registerSuccess').style.display = 'none';
}

// Handle register submit (AJAX)
function handleRegister(e) {
    e.preventDefault();

    const pass = document.getElementById("regPassword").value;
    const confirm = document.getElementById("regConfirmPassword").value;
    const successMsg = document.getElementById("registerSuccess");
    const form = document.getElementById("registerForm");

    if (pass !== confirm) {
        alert("Passwords do not match");
        return false;
    }

    const formData = new FormData(form);

    fetch("register.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(result => {
        if (result.trim() === "success") {
            successMsg.style.display = "block";

            setTimeout(() => {
                closeRegisterModal();
            }, 2000);
        } else {
            alert(result);
        }
    })
    .catch(() => {
        alert("Registration failed");
    });

    return false;
}

// Close modal when clicking outside
window.addEventListener("click", function(e) {
    const modal = document.getElementById("registerModal");
    if (e.target === modal) closeRegisterModal();
});

//items
let currentIndex = 0;

function slideRight() {
  if (window.innerWidth > 480) return;
  const grid = document.getElementById("itemsGrid");
  const totalItems = grid.children.length;

  if (currentIndex < totalItems - 1) {
    currentIndex++;
    grid.style.transform = `translateX(-${currentIndex * 100}%)`;
  }
}

function slideLeft() {
  if (window.innerWidth > 480) return;
  const grid = document.getElementById("itemsGrid");

  if (currentIndex > 0) {
    currentIndex--;
    grid.style.transform = `translateX(-${currentIndex * 100}%)`;
  }
}

//Partner
function slidePartners(direction) {
    const slider = document.getElementById("partnerSlider");
    const card = slider.querySelector(".partner-card");
    const cardWidth = card.offsetWidth + 20;

    slider.scrollLeft += direction * cardWidth;
}