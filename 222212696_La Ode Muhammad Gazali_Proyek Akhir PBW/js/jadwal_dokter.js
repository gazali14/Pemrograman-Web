document.addEventListener("DOMContentLoaded", function () {
  const calendarTitle = document.getElementById("calendar-title");
  const calendarGrid = document.getElementById("calendar");

  const daysInMonth = (month, year) => new Date(year, month, 0).getDate();
  const startDay = (month, year) => new Date(year, month - 1, 1).getDay();

  const today = new Date();
  let month = today.getMonth() + 1; // getMonth() returns 0-11
  let year = today.getFullYear();

  let events = []; // Menyimpan data jadwal dari server

  // Ambil data jadwal dokter dari server menggunakan fetch API
  function fetchSchedule() {
    fetch("fetch_jadwal_dokter.php")
      .then((response) => response.json())
      .then((data) => {
        events = data; // Simpan data jadwal dari server ke dalam variabel events
        renderCalendar(); // Panggil fungsi renderCalendar setelah mendapatkan data
      })
      .catch((error) => console.error("Error fetching schedule:", error));
  }

  // Panggil fungsi fetchSchedule() untuk mengambil data jadwal dari server
  fetchSchedule();

  // Fungsi untuk merender kalender berdasarkan data jadwal yang telah diambil dari server
  function renderCalendar() {
    calendarGrid.innerHTML = "";

    // Update calendar title
    const monthNames = [
      "Januari",
      "Februari",
      "Maret",
      "April",
      "Mei",
      "Juni",
      "Juli",
      "Agustus",
      "September",
      "Oktober",
      "November",
      "Desember",
    ];
    calendarTitle.innerText = `Jadwal Praktek Dokter - ${monthNames[month - 1]} ${year}`;

    // Render day names
    const dayNames = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    dayNames.forEach((dayName) => {
      const dayElement = document.createElement("div");
      dayElement.className = "day-header";
      dayElement.innerText = dayName;
      calendarGrid.appendChild(dayElement);
    });

    const days = daysInMonth(month, year);
    const start = startDay(month, year);

    // Fill in the blank days at the start of the month
    for (let i = 0; i < start; i++) {
      const blankDay = document.createElement("div");
      blankDay.className = "day";
      calendarGrid.appendChild(blankDay);
    }

    // Render the days of the month
    for (let day = 1; day <= days; day++) {
      const dayElement = document.createElement("div");
      dayElement.className = "day";

      const dayNumber = document.createElement("div");
      dayNumber.className = "day-number";
      dayNumber.innerText = day;
      dayElement.appendChild(dayNumber);

      // Mark today's date
      const todayDate = new Date();
      if (
        year === todayDate.getFullYear() &&
        month === todayDate.getMonth() + 1 &&
        day === todayDate.getDate()
      ) {
        dayElement.classList.add("today");
      }

      const dateString = `${year}-${String(month).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
      events.forEach((event) => {
        if (event.date === dateString) {
          const eventElement = document.createElement("div");
          eventElement.className = "event";
          const startTime = event.start_time.substring(0, 5); // Ambil 5 karakter pertama (hh:mm)
          const endTime = event.end_time.substring(0, 5); // Ambil 5 karakter pertama (hh:mm)
          const doctorId = event.doctor_id;
          const scheduleId = event.id;
          eventElement.innerText = `${event.doctor_name} (${startTime} - ${endTime})`;
          
          // Tambahkan logika untuk memeriksa apakah tanggal jadwal telah lewat
          if (new Date(dateString) >= todayDate) {
            eventElement.classList.add("appointable");
            eventElement.onclick = function () {
              createAppointment(doctorId, scheduleId); // Panggil fungsi createAppointment saat tombol diklik
            };
          } else {
            eventElement.classList.add("expired");
          }

          eventElement.onmouseover = function () {
            showEventDetail(event, eventElement);
          };
          dayElement.appendChild(eventElement);
        }
      });

      calendarGrid.appendChild(dayElement);
    }
  }

  function showEventDetail(event, eventElement) {
    let detailContainer = document.querySelector(".event-detail");
    if (!detailContainer) {
      detailContainer = document.createElement("div");
      detailContainer.className = "event-detail";
      document.body.appendChild(detailContainer);
    }
    // Ubah format waktu menjadi hh:mm
    const startTime = event.start_time.substring(0, 5); // Ambil 5 karakter pertama (hh:mm)
    const endTime = event.end_time.substring(0, 5); // Ambil 5 karakter pertama (hh:mm)

    detailContainer.innerHTML = `
                <strong>${event.doctor_name}</strong>
                <span>Waktu: ${startTime} - ${endTime}</span><br>
                <span class="status ${event.status}">${getStatusText(
      event.status
    )}</span>
            `;

    const rect = eventElement.getBoundingClientRect();
    detailContainer.style.top = `${rect.bottom + window.scrollY}px`;
    detailContainer.style.left = `${rect.left + window.scrollX}px`;
    detailContainer.style.display = "block";
    setTimeout(() => {
      detailContainer.style.display = "none";
    }, 3000);
  }

  function getStatusText(status) {
    switch (status) {
      case "on-time":
        return "Tepat Waktu";
      case "delayed":
        return "Terlambat";
      case "cancelled":
        return "Dibatalkan";
      default:
        return "";
    }
  }

  function createAppointment(doctorId, scheduleId) {
    // Lakukan pengalihan ke halaman pembuatan appointment dengan meneruskan doctorId dan scheduleId
    window.location.href = `appointment.php?doctor_id=${doctorId}&schedule_id=${scheduleId}`;
  }

  window.prevMonth = function () {
    if (month === 1) {
      month = 12;
      month -= 1;
    } else {
      month -= 1;
    }
    fetchSchedule();
  };

  window.nextMonth = function () {
    if (month === 12) {
      month = 1;
      year += 1;
    } else {
      month += 1;
    }
    fetchSchedule();
  };
});
