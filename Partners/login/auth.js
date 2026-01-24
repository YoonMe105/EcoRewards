/* ---------- LOGIN PAGE ---------- */
const loginForm = document.getElementById("loginForm");

if (loginForm) {
  loginForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const errorMsg = document.getElementById("error-msg");

    if (!email || !password) {
      errorMsg.textContent = "Please fill in all fields.";
      return;
    }

    fetch("auth/login.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      credentials: "include",
      body: JSON.stringify({ email, password })
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === "success") {
        window.location.href = "homepage.html";
      } else {
        errorMsg.textContent = data.message;
      }
    });
  })
}


/* ---------- FORGOT PASSWORD ---------- */
const forgotForm = document.getElementById("forgotForm");

if (forgotForm) {
  forgotForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const email = document.getElementById("email").value;
    const newPassword = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
    const errorMsg = document.getElementById("error-msg");

    if (!email || !newPassword || !confirmPassword) {
      errorMsg.textContent = "Please fill in all fields.";
      return;
    }

    if (newPassword !== confirmPassword) {
      errorMsg.textContent = "Passwords do not match.";
      return;
    }

    fetch("http://127.0.0.1:5000/forgot_password", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ email, newPassword })
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === "success") {
        window.location.href = "login.html";
      } else {
        errorMsg.textContent = data.message;
      }
    })
    .catch(() => errorMsg.textContent = "Server error.");
  });
}

/* ---------- CHANGE PASSWORD ---------- */
const changePassForm = document.getElementById("changePassForm");

if (changePassForm) {
  changePassForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const newPassword = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
    const errorMsg = document.getElementById("error-msg");

    if (newPassword !== confirmPassword) {
      errorMsg.textContent = "Passwords do not match.";
      return;
    }

    fetch("http://127.0.0.1:5000/change_password", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ newPassword })
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === "success") {
        window.location.href = "setting.html";
      } else {
        errorMsg.textContent = data.message;
      }
    });
  });
}

/* ---------- CHANGE PHONE NUMBER ---------- */
const changePhoneNoForm = document.getElementById("changePhoneNoForm");

if (changePhoneNoForm) {
  changePhoneNoForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const newPhoneNo = document.getElementById("newPhoneNo").value;
    const errorMsg = document.getElementById("error-msg");

    if (!newPhoneNo) {
      errorMsg.textContent = "Please fill in all fields.";
      return;
    }

    fetch("http://127.0.0.1:5000/change_phone", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        phone: newPhoneNo
      })

    })
    .then(res => res.json())
    .then(data => {
      if (data.status === "success") {
        window.location.href = "setting.html";
      } else {
        errorMsg.textContent = data.message;
      }
    });
  });
}

