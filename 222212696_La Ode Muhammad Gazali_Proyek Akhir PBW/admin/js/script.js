document.getElementById('addUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('add_user.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        location.reload();
    })
    .catch(error => console.error('Error:', error));
});

function editUser(id) {
    // Fetch user data and prefill the form for editing
    fetch('get_user.php?id=' + id)
    .then(response => response.json())
    .then(data => {
        document.getElementById('username').value = data.username;
        document.getElementById('email').value = data.email;
        document.getElementById('is_admin').checked = data.is_admin == 1;
        document.getElementById('addUserForm').action = 'edit_user.php';
        document.getElementById('addUserForm').innerHTML += `<input type="hidden" name="id" value="${id}">`;
    })
    .catch(error => console.error('Error:', error));
}

function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        fetch('delete_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    }
}

// Similar functions for doctors and appointments
function editDoctor(id) {
    fetch('get_doctor.php?id=' + id)
    .then(response => response.json())
    .then(data => {
        document.getElementById('name').value = data.name;
        document.getElementById('specialization').value = data.specialization;
        document.getElementById('addDoctorForm').action = 'edit_doctor.php';
        document.getElementById('addDoctorForm').innerHTML += `<input type="hidden" name="id" value="${id}">`;
    })
    .catch(error => console.error('Error:', error));
}

function deleteDoctor(id) {
    if (confirm('Are you sure you want to delete this doctor?')) {
        fetch('delete_doctor.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    }
}

function editAppointment(id) {
    fetch('get_appointment.php?id=' + id)
    .then(response => response.json())
    .then(data => {
        document.getElementById('doctor_id').value = data.doctor_id;
        document.getElementById('schedule_id').value = data.schedule_id;
        document.getElementById('patient_name').value = data.patient_name;
        document.getElementById('complaint').value = data.complaint;
        document.getElementById('addAppointmentForm').action = 'edit_appointment.php';
        document.getElementById('addAppointmentForm').innerHTML += `<input type="hidden" name="id" value="${id}">`;
    })
    .catch(error => console.error('Error:', error));
}

function deleteAppointment(id) {
    if (confirm('Are you sure you want to delete this appointment?')) {
        fetch('delete_appointment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    }
}

document.getElementById('addArticleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('add_article.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        location.reload();
    })
    .catch(error => console.error('Error:', error));
});

function editArticle(id) {
    fetch('get_article.php?id=' + id)
    .then(response => response.json())
    .then(data => {
        document.getElementById('judul').value = data.judul;
        document.getElementById('tanggal').value = data.tanggal;
        document.getElementById('konten').value = data.konten;
        document.getElementById('addArticleForm').action = 'edit_article.php';
        document.getElementById('addArticleForm').innerHTML += `<input type="hidden" name="id" value="${id}"><input type="hidden" name="existing_image" value="${data.gambar}">`;
    })
    .catch(error => console.error('Error:', error));
}

function deleteArticle(id) {
    if (confirm('Are you sure you want to delete this article?')) {
        fetch('delete_article.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    }
}

document.getElementById('answerQuestionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('add_answer.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        location.reload();
    })
    .catch(error => console.error('Error:', error));
});

function answerQuestion(id) {
    fetch('get_question.php?id=' + id)
    .then(response => response.json())
    .then(data => {
        document.getElementById('question_id').value = data.id;
    })
    .catch(error => console.error('Error:', error));
}

function editSchedule(id) {
    // Fetch schedule data and prefill the form for editing
    fetch('get_schedule.php?id=' + id)
    .then(response => response.json())
    .then(data => {
        document.getElementById('doctor_id').value = data.doctor_id;
        document.getElementById('date').value = data.date;
        document.getElementById('start_time').value = data.start_time;
        document.getElementById('end_time').value = data.end_time;
        document.getElementById('status').value = data.status;
        // Set the form action and add a hidden input for schedule ID
        var form = document.getElementById('addScheduleForm');
        form.action = 'edit_schedule.php';
        var idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'id';
        idInput.value = id;
        form.appendChild(idInput);
    })
    .catch(error => console.error('Error:', error));
}

function deleteSchedule(id) {
    if (confirm('Are you sure you want to delete this schedule?')) {
        fetch('delete_schedule.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload(); // Reload the page after deletion
        })
        .catch(error => console.error('Error:', error));
    }
}



