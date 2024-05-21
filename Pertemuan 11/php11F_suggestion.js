function showHint(str) {
  if (str.length == 0) {
    document.getElementById("txtHint").innerHTML = ""; // Menghapus konten pada elemen txtHint jika text field kosong
    return; // Keluar dari fungsi jika text field kosong
  }
  xhttp = new XMLHttpRequest();

  // Membuat fungsi yang akan dieksekusi ketika respons server sudah siap
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("txtHint").innerHTML = this.responseText; // Menampilkan saran pencarian yang didapat dari server pada elemen txtHint
    }
  };

  // Mengirimkan permintaan ke file di server
  xhttp.open("GET", "php11F_gethint.php?keyword=" + str, true); // Parameter keyword berisi kata kunci pencarian pada txt1
  xhttp.send();
}
