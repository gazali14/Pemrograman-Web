//toggle class active
const navbarNav = document.querySelector(".navbar-nav");

//ketika humbergur menu diklik
document.querySelector("#hamburger-menu").onclick = () => {
  navbarNav.classList.toggle("active");
};

//klik diluar sidebar untuk menghilangkan nav
const hamburger = document.querySelector("#hamburger-menu");

document.addEventListener("click", function (e) {
  if (!hamburger.contains(e.target) && !navbarNav.contains(e.target)) {
    navbarNav.classList.remove("active");
  }
});

document.addEventListener("DOMContentLoaded", function () {
  var boxes = document.querySelectorAll(".box-berita .box");

  function checkScroll() {
    boxes.forEach(function (box) {
      var boxPosition = box.getBoundingClientRect().top;
      var screenPosition = window.innerHeight / 1.3;

      if (boxPosition < screenPosition) {
        box.classList.add("animated");
      }
    });
  }

// Panggil fungsi checkScroll ketika halaman di-scroll
window.addEventListener("scroll", checkScroll);
  checkScroll();
});
document.addEventListener("DOMContentLoaded", function () {
  var boxes = document.querySelectorAll(".box-berita .box");

function checkScroll() {
  boxes.forEach(function (box) {
    var boxPosition = box.getBoundingClientRect().top;
    var screenPosition = window.innerHeight / 1.3;
    if (boxPosition < screenPosition) {
      box.classList.add("animated");
    }
  });
}

// Panggil fungsi checkScroll ketika halaman di-scroll
window.addEventListener("scroll", checkScroll);
  checkScroll();
});

let subMenu = document.getElementById("subMenu");

// Untuk user profile togle
function toggleMenu(){
  subMenu.classList.toggle("open-menu");
}

// untuk upload image pada user profile togle
document.addEventListener('DOMContentLoaded', function () {
  const editIcon = document.getElementById('edit-icon');
  const fileInput = document.getElementById('fileInput');
  const profileImage = document.getElementById('profileImage');

  editIcon.addEventListener('click', () => {
      fileInput.click();
  });

  fileInput.addEventListener('change', async () => {
      const formData = new FormData();
      formData.append('file', fileInput.files[0]);

      try {
          const response = await fetch('upload_image.php', {
              method: 'POST',
              body: formData
          });
          const data = await response.json();
          if (data.success) {
              profileImage.src = 'img/' + data.filename;
          } else {
              console.error(data.error);
          }
      } catch (error) {
          console.error('Error uploading image:', error);
      }
  });
});