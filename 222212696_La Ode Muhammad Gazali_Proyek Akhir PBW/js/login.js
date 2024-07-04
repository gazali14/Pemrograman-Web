const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");
const sign_in_btn2 = document.querySelector("#sign-in-btn2");
const sign_up_btn2 = document.querySelector("#sign-up-btn2");
sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});
sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});
sign_up_btn2.addEventListener("click", () => {
  container.classList.add("sign-up-mode2");
});
sign_in_btn2.addEventListener("click", () => {
  container.classList.remove("sign-up-mode2");
});

function validateSignupForm() {
  const username = document.getElementById("signup-username").value;
  const email = document.getElementById("signup-email").value;
  const password = document.getElementById("signup-password").value;

  let isValid = true;

  // Clear previous error messages
  document.getElementById("usernameError").innerText = "";
  document.getElementById("emailError").innerText = "";
  document.getElementById("passwordError").innerText = "";

  // Validasi
  // Username validation: minumum 5 karakter
  const usernamePattern = /^[A-Za-z\s]{5,}$/;
  if (!usernamePattern.test(username)) {
      document.getElementById("usernameError").innerText = "Username harus terdiri dari minimal 5 karakter dan tanpa angka dan simbol lain.";
      isValid = false;
  }

  // Email validation: harus huruf kecil serta mengandung @ dan .
  const emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/;
  if (!emailPattern.test(email)) {
      document.getElementById("emailError").innerText = "Email tidak valid.";
      isValid = false;
  }

  // Password validation: minimum 6 karakter, huruf kecil dan angka, tanpa simbol atau karakter lain
  const passwordPattern = /^[a-z0-9]{6,}$/;
  if (!passwordPattern.test(password)) {
      document.getElementById("passwordError").innerText = "Password harus terdiri dari minimal 6 karakter, hanya huruf kecil dan angka, tanpa spasi atau simbol.";
      isValid = false;
  }

  return isValid;
}