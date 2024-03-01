/*for (var ii = 4, jj = 3; jj >= 0; ii++, jj--) {
    document.writeln(ii + " * " + jj + " = " + ii * jj + "<br>")
    document.writeln(ii + " / " + jj + " = " + ii / jj + "<br>")
    document.writeln("log(" + jj + ") = " + Math.log(jj) + "<br>")
    document.writeln("sqrt(" + (jj - 1) + ") = " + Math.sqrt(jj - 1) + "<br><br>")  
}*/

/*(1) Program diatas berhasil melakukan operasi matematika sederhana bertipe float dengan banyak
angka dibelakang koma. Untuk mengubah nya menjadi hanya 3 angka dibelakang koma, maka bisa digunakan
fungsi toFixed() dengan parameter banyaknya angka dibelakang koma yang diinginkan seperti contoh berikut: */

for (var ii = 4, jj = 3; jj >= 0; ii++, jj--) {
    document.writeln(ii + " * " + jj + " = " + (ii * jj).toFixed(3) + "<br>");
    document.writeln(ii + " / " + jj + " = " + (ii / jj).toFixed(3) + "<br>");
    document.writeln("log(" + jj + ") = " + Math.log(jj).toFixed(3) + "<br>");
    document.writeln("sqrt(" + (jj - 1) + ") = " + Math.sqrt(jj - 1).toFixed(3) + "<br><br>");
}

/*(2) Kemudian, perintah modul untuk memasukan operasi berikut ini */
x = 1.275
y = 1.27499999999999991118
document.writeln(x + " and " + y + " are " + ((x == y) ? "equal" : "not equal") + "<br>") // hasilnya equal

/*(3) Dalam kasus ini, meskipun seharusnya x dan y tidak identik karena perbedaan kecil yang muncul 
dalam representasi floating point, perbandingan (x == y) masih menghasilkan true. Hal ini disebabkan 
oleh cara JavaScript menangani perbandingan antara angka floating point. Meskipun secara teknis, dalam
 matematika presisi x dan y tidak sama, namun perbedaan antara keduanya sangat kecil sehingga 
 JavaScript memperlakukan mereka sebagai sama ketika dibandingkan menggunakan operator ==. */


 