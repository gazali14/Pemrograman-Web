-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 30, 2024 at 08:39 AM
-- Server version: 10.11.7-MariaDB
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dscfexio_klinikstis`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `admin_id`, `answer`, `created_at`) VALUES
(16, 26, 1, 'promag', '2024-06-12 05:07:01'),
(19, 27, 2, 'Move on', '2024-06-30 06:56:21'),
(21, 31, 53, 'Selingi proses belajar dengan hal-hal yang anda senangi', '2024-06-30 08:19:35');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `schedule_id` int(11) DEFAULT NULL,
  `patient_name` varchar(100) DEFAULT NULL,
  `complaint` text DEFAULT NULL,
  `additional_info` text DEFAULT NULL,
  `status` enum('Disetujui','Pending','Ditolak') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `doctor_id`, `schedule_id`, `patient_name`, `complaint`, `additional_info`, `status`) VALUES
(38, 2, 3, 'La Ode', 'Sakit Hati', 'Habis Putus', 'Ditolak'),
(41, 1, 5, 'syawaludin', 'Sakit hati', 'ada yang confess tapi ga tau orangnya', 'Pending'),
(42, 2, 6, 'iman alifa', 'batuk', 'sudah 2 hari', 'Disetujui'),
(43, 2, 6, 'iman alifa', 'kena mental', 'dibantai tugas\r\n', 'Pending'),
(48, 1, 8, 'La Ode Gazali', 'Sakit kepala', 'insomnia', 'Disetujui');

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `konten` text NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id`, `judul`, `tanggal`, `konten`, `gambar`) VALUES
(1, 'Manfaat dan Tips untuk Hidrasi Optimal', '2024-05-10', 'Hidrasi optimal merupakan faktor penting dalam menjaga kesehatan tubuh. Air merupakan komponen utama tubuh manusia, yang berperan dalam berbagai fungsi vital seperti menjaga keseimbangan suhu, membantu pencernaan, dan mengangkut nutrisi ke seluruh sel tubuh. Salah satu manfaat utama dari hidrasi optimal adalah peningkatan kinerja fisik dan mental. Ketika tubuh terhidrasi dengan baik, otot dan sendi bekerja lebih efisien, mengurangi risiko kram dan kelelahan. Selain itu, hidrasi yang baik juga membantu fungsi otak, meningkatkan konsentrasi, dan memperbaiki suasana hati. Hidrasi yang cukup juga penting untuk menjaga kesehatan kulit, membuatnya tetap lembab dan elastis, serta membantu mengeluarkan racun dari tubuh melalui keringat dan urin. \r\n\r\nUntuk mencapai hidrasi optimal, penting untuk memahami kebutuhan air harian setiap individu, yang bisa bervariasi tergantung pada usia, jenis kelamin, tingkat aktivitas, dan kondisi kesehatan. Rata-rata, orang dewasa disarankan untuk mengonsumsi sekitar 2 hingga 3 liter air per hari. Namun, kebutuhan ini bisa meningkat jika seseorang melakukan aktivitas fisik berat atau berada di lingkungan panas. Mengonsumsi air putih secara teratur sepanjang hari adalah cara terbaik untuk tetap terhidrasi. Memulai hari dengan segelas air, minum sebelum dan sesudah berolahraga, serta selalu membawa botol air saat bepergian adalah beberapa langkah praktis yang bisa dilakukan. Selain itu, mengonsumsi makanan yang kaya kandungan air seperti buah-buahan dan sayuran juga bisa membantu memenuhi kebutuhan hidrasi. \r\n\r\nAda beberapa tips untuk memastikan hidrasi yang optimal sepanjang hari. Pertama, buatlah jadwal minum air secara rutin, misalnya setiap jam, untuk mencegah lupa. Gunakan aplikasi pengingat di ponsel jika diperlukan. Kedua, cobalah variasi dalam konsumsi cairan, seperti teh herbal atau air yang diberi potongan buah, untuk membuatnya lebih menarik. Ketiga, perhatikan tanda-tanda dehidrasi seperti mulut kering, urin berwarna gelap, dan rasa lelah. Jika mengalami gejala ini, segera tingkatkan asupan cairan. Keempat, bagi mereka yang sering berolahraga atau berada di bawah sinar matahari, penting untuk mengonsumsi minuman yang mengandung elektrolit untuk menggantikan mineral yang hilang melalui keringat. Dengan mengikuti tips ini, setiap individu dapat menjaga hidrasi tubuh mereka dengan optimal, mendukung kesehatan dan kesejahteraan secara keseluruhan.', 'anm1.png'),
(2, ' Strategi Mengelola Stres bagi Mahasiswa STIS', '2024-05-26', 'Mengelola stres merupakan keterampilan penting yang perlu dikuasai oleh setiap mahasiswa di lingkungan akademik yang sering kali menantang. Tekanan dari tugas-tugas akademik, ujian, dan tenggat waktu yang ketat seringkali dapat menyebabkan tingkat stres yang tinggi di kalangan mahasiswa. Namun, dengan strategi yang tepat, stres ini dapat dikelola dengan efektif sehingga tidak mengganggu kesejahteraan fisik dan mental mahasiswa. Salah satu strategi yang efektif adalah dengan merencanakan waktu secara baik dan menetapkan prioritas dalam menyelesaikan tugas-tugas. Selain itu, penting bagi mahasiswa untuk mengambil waktu untuk istirahat dan relaksasi, serta melakukan aktivitas yang menyenangkan di luar lingkungan akademik. Mendapatkan dukungan sosial juga dapat membantu mengurangi stres, baik dari teman sejawat maupun dari keluarga dan teman-teman terdekat. Dengan mengimplementasikan strategi-strategi ini, mahasiswa dapat mengelola stres dengan lebih baik dan menjaga keseimbangan dalam kehidupan akademik dan pribadi mereka', 'anm2.png'),
(3, 'Menjaga Kesehatan Mental Mahasiwa dengan Olahraga', '2024-05-26', 'Menjaga kesehatan mental menjadi prioritas utama bagi mahasiswa di tengah-tengah tantangan akademik yang membebani. Jadwal yang padat, tenggat waktu yang ketat, dan persaingan yang sengit dapat memicu stres, kecemasan, dan depresi. Untuk menghadapi tantangan ini, penting bagi mahasiswa untuk memiliki strategi yang efektif dalam menjaga kesehatan mental mereka. Ini mencakup mengenali tanda-tanda stres dan kesehatan mental yang buruk, membangun jaringan dukungan sosial yang kuat, menjaga keseimbangan antara tuntutan akademik dan kegiatan sosial, serta mempraktikkan teknik relaksasi dan koping untuk mengatasi stres secara efektif. Dengan menerapkan langkah-langkah ini, mahasiswa dapat menjaga kesehatan mental mereka dan tetap sukses dalam perjalanan akademik mereka.', 'anm3.png'),
(4, 'Manfaat Telemedicine bagi Mahasiswa STIS', '2024-05-26', 'Telemedicine telah mengubah cara mahasiswa mengakses layanan kesehatan, memberikan kemudahan dan efisiensi yang belum pernah terjadi sebelumnya. Dengan teknologi telemedicine, mahasiswa dapat dengan mudah berkonsultasi dengan dokter atau spesialis melalui video call atau aplikasi mobile, tanpa perlu meninggalkan kampus atau tempat tinggal mereka. Hal ini sangat bermanfaat terutama bagi mahasiswa yang tinggal jauh dari pusat layanan kesehatan atau memiliki jadwal yang padat. Selain itu, telemedicine juga memungkinkan mahasiswa untuk mendapatkan diagnosis cepat, mengelola kondisi kesehatan kronis, dan mendapatkan resep obat dengan lebih mudah, tanpa harus menghadiri klinik atau rumah sakit secara langsung. Dengan demikian, telemedicine tidak hanya meningkatkan aksesibilitas terhadap layanan kesehatan, tetapi juga mengurangi hambatan-hambatan yang sering kali menghalangi mahasiswa untuk mendapatkan perawatan medis yang tepat waktu.', 'anm4.png');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `specialization`) VALUES
(1, 'Dr. Ihsan Ahmad', 'Dokter Umum'),
(2, 'Dr. Adam Irawan', 'Dokter Umum'),
(3, 'Dr. Saraswati', 'Dokter Umum'),
(4, 'Dr. Ayala Hasim', 'Dokter Umum');

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id` int(11) NOT NULL,
  `nama_obat` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `aturan_pakai` text NOT NULL,
  `ketersediaan` int(11) NOT NULL,
  `path_gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id`, `nama_obat`, `deskripsi`, `aturan_pakai`, `ketersediaan`, `path_gambar`) VALUES
(1, 'Paracetamol', 'Obat Penurun demam', '3 kali sehari setelah makan.', 18, 'paracetamol.jpg'),
(2, 'Mixagrip', 'Obat pereda flu dan batuk', '2 kali sehari sebelum makan.', 17, 'mixagrip.jpg'),
(3, 'Entrostop', 'Obat pereda sakit perut akibat diare', '1 kali sehari sebelum tidur.', 19, 'entrostop.jpg'),
(4, 'Amoxicillin Tryhydrate', 'Obat antibiotik untuk mengatasi bakteri', '2 kali sehari dengan jeda 8 jam', 12, 'Amoxicillin.jpg'),
(5, 'Asam Mefenamat', 'Obat pereda nyeri', '2-3 kali sehari setelah makan', 13, 'asam mefenamat.jpg'),
(6, 'Vitamin C', 'Meningkatkan daya tahan tubuh', ' Dosis 250 mg 3 kali sehari, selama 1 minggu', 45, 'vitC.jpg'),
(9, 'Bodrex', 'Obat sakit kepala', '2 kali sehari', 30, 'bodrex.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Belum Dijawab','Sudah Dijawab') NOT NULL DEFAULT 'Belum Dijawab'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `user_id`, `question`, `created_at`, `status`) VALUES
(26, 48, 'dok, kalau sakit mag obatnya apa?', '2024-06-12 05:06:23', 'Sudah Dijawab'),
(27, 48, 'obat jatuh cinta apa ya dok?', '2024-06-12 07:55:57', 'Sudah Dijawab'),
(31, 52, 'Dok, Bagaimana cara menghilangkan stress akibat Academic Preassure?', '2024-06-30 08:19:22', 'Sudah Dijawab');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `status` varchar(20) DEFAULT 'on-time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `doctor_id`, `date`, `start_time`, `end_time`, `status`) VALUES
(1, 1, '2024-05-15', '09:00:00', '12:00:00', 'on-time'),
(3, 3, '2024-05-03', '11:00:00', '14:00:00', 'on-time'),
(4, 2, '2024-05-31', '08:00:00', '11:00:00', 'cancelled'),
(5, 1, '2024-06-20', '08:00:00', '10:00:00', 'delayed'),
(6, 2, '2024-06-17', '10:00:00', '12:00:00', 'on-time'),
(8, 1, '2024-07-01', '08:00:00', '12:00:00', 'on-time'),
(11, 4, '2024-07-03', '10:00:00', '12:00:00', 'on-time'),
(12, 1, '2024-07-05', '14:00:00', '16:00:00', 'on-time'),
(13, 2, '2024-07-09', '08:00:00', '11:00:00', 'on-time'),
(14, 4, '2024-07-11', '08:30:00', '10:30:00', 'cancelled'),
(15, 3, '2024-07-15', '10:00:00', '13:00:00', 'on-time'),
(17, 2, '2024-07-17', '13:00:00', '15:00:00', 'on-time'),
(18, 1, '2024-07-19', '08:00:00', '12:00:00', 'on-time'),
(19, 4, '2024-06-30', '09:00:00', '14:00:00', 'on-time');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `is_admin` int(11) NOT NULL DEFAULT 0,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `is_admin`, `profile_image`) VALUES
(1, 'gazali', 'gazali.1494@gmail.com', '77d21476728c6a8edeb9809eeb6ff30c', 1, NULL),
(2, 'admin', 'admin@gmail.com', '0192023a7bbd73250516f069df18b500', 1, NULL),
(3, 'La Ode', 'laode@gmail.com', 'e57ea680ed8c2984d236c34bfeb6141c', 0, NULL),
(48, 'syawaludin', 'syawal@gmail.com', 'f2708ae6af0d7c461e8234ac495436be', 0, NULL),
(49, 'iman alifa', 'iman@gmail.com', 'dbe4f7a38136336bf6bd6c3628a0f8f8', 0, './img/syawal.jpg'),
(50, 'lazandik', 'zandik@stis.ac.id', '36f17c3939ac3e7b2fc9396fa8e953ea', 0, NULL),
(52, 'La Ode Gazali', 'laode@gmail.com', 'e57ea680ed8c2984d236c34bfeb6141c', 0, './img/syawal.jpg'),
(53, 'Dr Ihsan Ahmad', 'ihsanahmad@stis.ac.id', 'ea1e2b66eb6f4d6a8c6d8555e1b46cea', 1, NULL),
(54, 'Dr Saraswati', 'saraswati@stis.ac.id', '931476b5d4c91c516a8fec6eea5ff55d', 1, NULL),
(55, 'Dr Adam Irawan', 'adamirawan@stis.ac.id', '3e7b522b9756d2578d3a86d8f366be6e', 1, NULL),
(56, 'Dr Ayala Hasim', 'ayalah@stis.ac.id', 'e2b1ad070ad79d3ca4377fb85e0e7b5d', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
