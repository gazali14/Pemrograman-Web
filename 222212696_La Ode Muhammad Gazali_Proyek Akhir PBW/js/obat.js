feather.replace();

function searchMedicine() {
  const input = document.getElementById("searchInput").value.toLowerCase();
  const medicineList = document.querySelector(".medicine-list");
  const medicines = medicineList.querySelectorAll(".medicine-card");
  medicines.forEach((medicine) => {
    if (medicine.textContent.toLowerCase().includes(input)) {
      medicine.style.display = "";
    } else {
      medicine.style.display = "none";
    }
  });
}

function showSuggestions() {
  const input = document.getElementById("searchInput").value.toLowerCase();
  const suggestionBox = document.getElementById("suggestionBox");
  suggestionBox.innerHTML = "";
  if (input.length > 0) {
    const medicines = document.querySelectorAll(
      ".medicine-card .medicine-name"
    );
    let suggestions = [];
    medicines.forEach((medicine) => {
      const medicineName = medicine.textContent.toLowerCase();
      if (medicineName.includes(input)) {
        suggestions.push(medicine.textContent);
      }
    });
    if (suggestions.length > 0) {
      suggestions.slice(0, 5).forEach((suggestion) => {
        const suggestionItem = document.createElement("div");
        suggestionItem.textContent = suggestion;
        suggestionItem.onclick = function () {
          document.getElementById("searchInput").value = suggestion;
          suggestionBox.innerHTML = "";
          searchMedicine();
        };
        suggestionBox.appendChild(suggestionItem);
      });
    }
  }
}

// Modal
const modal = document.getElementById("modal");
const closeModal = document.getElementsByClassName("close")[0];
const requestForm = document.getElementById("requestForm");

document.querySelectorAll(".request-button").forEach((button) => {
  button.onclick = function () {
    if (!button.disabled) {
      const medicineId = button.getAttribute("data-id");
      document.getElementById("medicineId").value = medicineId;
      modal.style.display = "block";
    }
  };
});

closeModal.onclick = function () {
  modal.style.display = "none";
};

window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};

requestForm.onsubmit = function (event) {
  event.preventDefault();
  const medicineId = document.getElementById("medicineId").value;
  const quantity = document.getElementById("quantity").value;

  fetch("fetch_update_ketersediaan_obat.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      medicine_id: medicineId,
      quantity: quantity,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert(data.success);
      } else {
        alert(data.error);
      }
      location.reload();
    })
    .catch((error) => console.error("Error:", error));
};
