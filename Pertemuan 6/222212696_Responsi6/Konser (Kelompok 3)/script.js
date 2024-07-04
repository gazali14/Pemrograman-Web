function invoice() {
  // Mengambil nilai dari input form
  const name = document.getElementById('name').value;
  const email = document.getElementById('email').value;
  const phone = document.getElementById('phone').value;
  const selectconcert = document.getElementById('selectconcert').value;
  const jenistiket = document.getElementById('jenistiket').value;
  const quantity = parseInt(document.getElementById('quantity').value);

  // Validasi input form
  if (name === '' || isNaN(quantity) || quantity <= 0) {
    alert('Silahkan isi form pemesanan tiket terlebih dahulu');
    return;
  }

  // Simpan nilai pada sessionStorage untuk ditampilkan pada halaman invoice
  sessionStorage.setItem('name', name);
  sessionStorage.setItem('email', email);
  sessionStorage.setItem('phone', phone);
  sessionStorage.setItem('selectconcert', selectconcert);
  sessionStorage.setItem('jenistiket', jenistiket);
  sessionStorage.setItem('quantity', quantity);

  // Arahkan pengguna ke halaman invoice
  window.location.href = 'invoice.html';
}
