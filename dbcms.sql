-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 16, 2025 at 08:36 AM
-- Server version: 9.0.1
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbcms`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int NOT NULL,
  `date` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `date`, `title`, `content`, `picture`) VALUES
(1, '9 Maret 2025', 'Hawa Sejuk dan Spot Instagramable di Taman Selecta, Cocok Buat Healing!', '<p>Malang selalu punya cara bikin orang jatuh cinta, dan Taman Rekreasi Selecta adalah salah satu tempat wisata yang wajib banget kamu kunjungi. Terletak di kawasan Batu, tempat ini terkenal dengan udaranya yang sejuk, pemandangan indah, dan pastinya banyak spot kece buat foto-foto. Kalau kamu lagi cari tempat buat santai, refreshing, atau sekadar melepas penat dari hiruk-pikuk kota, Selecta adalah pilihan yang tepat. Sejarah dan Daya Tarik Taman Selecta Taman Rekreasi Selecta ini bukan tempat wisata baru, lho. Dibangun sejak era kolonial Belanda pada tahun 1930-an, awalnya tempat ini digunakan sebagai tempat peristirahatan bagi pejabat dan orang-orang penting kala itu. Tapi, seiring berjalannya waktu, Selecta berkembang menjadi taman rekreasi yang terbuka untuk umum dan jadi salah satu destinasi wisata favorit di Malang Raya. Begitu sampai di Taman Selecta, kamu langsung disambut udara segar khas pegunungan yang bikin tubuh dan pikiran jadi rileks. Lokasinya yang berada di ketinggian sekitar 1.100 meter di atas permukaan laut bikin tempat ini punya suhu yang adem, bahkan di siang hari sekalipun. Ditambah lagi, taman bunga yang luas dengan warna-warni menawan bikin suasana makin nyaman dan menyenangkan. Spot Instagramable yang Wajib Dikunjungi Selain keindahan alamnya, Selecta juga menawarkan banyak spot Instagramable yang cocok buat mempercantik feed media sosialmu. Ada taman bunga dengan latar belakang perbukitan hijau, jembatan kecil yang dikelilingi tanaman warna-warni, hingga kolam air jernih yang bisa jadi tempat foto estetik. Salah satu spot favorit pengunjung adalah sky bike, yaitu sepeda yang melayang di atas taman, memberikan sensasi unik dan pemandangan spektakuler dari atas. Wahana Seru di Taman Selecta Kalau datang ke sini, jangan lupa juga buat menikmati wahana seru yang ada di dalam taman. Selain sky bike, ada juga wahana perahu ayun, water park, hingga kuda tunggang buat anak-anak maupun dewasa. Kolam renang di Selecta juga cukup menarik karena airnya yang jernih dan sejuk, langsung dari sumber alami di sekitar pegunungan. Kulineran di Taman Selecta Setelah puas jalan-jalan dan bermain, kamu bisa mampir ke restoran atau area kuliner di dalam Selecta untuk menikmati makanan khas Malang, seperti bakso Malang yang terkenal lezat. Ada juga berbagai camilan seperti jagung bakar dan pisang goreng yang pas banget disantap sambil menikmati udara dingin di sini. Kesimpulan Jadi, kalau kamu butuh tempat buat healing dari kesibukan sehari-hari, Taman Selecta adalah pilihan yang sempurna. Dengan udara sejuk, pemandangan indah, dan banyak spot foto keren, tempat ini cocok banget buat liburan santai bersama keluarga, teman, atau bahkan solo trip. Yuk, rencanakan perjalananmu ke Selecta dan rasakan sendiri keindahannya!</p>', 'selecta.jpg'),
(2, '10 Maret 2025', 'Jelajah Museum Angkut: Wisata Edukasi Seru untuk Pecinta Otomotif', '<p>Kalau kamu pecinta kendaraan atau suka dengan sejarah transportasi, Museum Angkut di Batu, Malang, wajib masuk dalam daftar tempat wisata yang harus dikunjungi!</p>\r\n    <p>Museum ini bukan sekadar tempat pajangan mobil dan motor lawas, tapi juga mengajak pengunjung menjelajahi perkembangan dunia otomotif dari masa ke masa dengan cara yang seru dan interaktif.</p>\r\n    <p>Mulai dari kendaraan klasik, pesawat, hingga suasana kota-kota terkenal dunia, semua bisa kamu temukan di sini. Yuk, kita jelajahi Museum Angkut lebih dalam!</p>\r\n\r\n    <p><strong>Sejarah dan Konsep Museum Angkut</strong></p>\r\n    <p>Museum Angkut pertama kali dibuka pada tahun 2014 oleh Jatim Park Group, pengelola beberapa destinasi wisata populer di Batu. Sebagai museum transportasi pertama dan terbesar di Asia Tenggara, tempat ini punya koleksi lebih dari 300 kendaraan dari berbagai era dan negara.</p>\r\n    <p>Bukan hanya mobil dan motor klasik, tapi juga pesawat, sepeda, becak, hingga kendaraan khas berbagai daerah di Indonesia dan dunia.</p>\r\n\r\n    <p>Yang bikin Museum Angkut makin menarik adalah konsepnya yang tematik. Jadi, saat menjelajahi museum ini, kamu seperti berpindah dari satu kota ke kota lain dengan atmosfer yang benar-benar berbeda. Setiap zona dibuat mirip dengan aslinya, lengkap dengan bangunan, lampu, bahkan musik khas yang membuat pengalamanmu semakin seru.</p>\r\n\r\n    <h4><strong>Zona-Zona Menarik di Museum Angkut</strong></h4>\r\n\r\n    <p><strong>1. Zona Hall Utama</strong></p>\r\n    <p>Begitu masuk, kamu langsung disambut dengan berbagai koleksi kendaraan antik yang elegan. Di sini, ada mobil-mobil klasik dari Amerika dan Eropa yang dulu digunakan oleh para pejabat dan orang-orang berpengaruh di dunia. Salah satu yang paling menarik perhatian adalah mobil kepresidenan yang pernah digunakan oleh Presiden Soekarno!</p>\r\n\r\n    <p><strong>2. Zona Edukasi</strong></p>\r\n    <p>Buat kamu yang penasaran dengan sejarah perkembangan transportasi dari zaman ke zaman, zona ini cocok banget untuk dikunjungi. Ada berbagai informasi menarik tentang bagaimana kendaraan berkembang, mulai dari kereta kuda, sepeda, hingga mobil listrik masa kini.</p>\r\n\r\n    <p><strong>3. Zona Sunda Kelapa & Batavia</strong></p>\r\n    <p>Zona ini menggambarkan suasana pelabuhan Sunda Kelapa pada masa kolonial Belanda. Kamu bisa melihat replika kapal besar, becak tempo dulu, dan berbagai kendaraan khas dari era tersebut. Ditambah dengan suasana khas pasar dan pelabuhan zaman dulu, tempat ini cocok buat yang suka berfoto dengan nuansa vintage.</p>\r\n\r\n    <p><strong>4. Zona Amerika</strong></p>\r\n    <p>Kalau kamu penggemar mobil klasik ala Hollywood, zona ini pasti jadi favoritmu! Ada banyak kendaraan khas Amerika seperti Cadillac, Chevrolet, hingga Ford Mustang. Zona ini juga dihiasi dengan suasana kota-kota di Amerika, lengkap dengan replika Hollywood dan Broadway yang ikonik.</p>\r\n\r\n    <p><strong>5. Zona Eropa</strong></p>\r\n    <p>Di sini, kamu bakal merasa seperti sedang berjalan di jalanan kota-kota klasik di Eropa. Mulai dari London dengan bus merah tingkatnya yang khas, Paris dengan suasana romantisnya, hingga Italia yang penuh dengan mobil-mobil sport mewah seperti Ferrari dan Lamborghini.</p>\r\n\r\n    <p><strong>6. Zona Gangster & Broadway</strong></p>\r\n    <p>Buat kamu yang suka suasana film mafia ala Amerika, zona ini menawarkan pengalaman unik. Dengan latar belakang kota gangster tahun 1920-an, lengkap dengan kendaraan klasik dan suasana gelap penuh lampu neon, tempat ini sering jadi spot favorit untuk foto-foto keren.</p>\r\n\r\n    <h4><strong>Wahana dan Atraksi Menarik</strong></h4>\r\n    <p>Selain koleksi kendaraan yang super keren, Museum Angkut juga menawarkan berbagai atraksi yang sayang untuk dilewatkan:</p>\r\n    <ul>\r\n        <li><strong>The Presidential Car</strong> - Koleksi mobil kepresidenan, termasuk replika mobil yang pernah digunakan oleh Presiden Soekarno.</li>\r\n        <li><strong>Zona Flight Simulator</strong> - Kamu bisa merasakan sensasi menerbangkan pesawat dalam simulator yang seru dan realistis.</li>\r\n        <li><strong>Atraksi Parade Kendaraan</strong> - Setiap sore, ada parade kendaraan klasik yang dikendarai oleh staf museum dengan kostum khas sesuai dengan era kendaraannya.</li>\r\n    </ul>\r\n\r\n    <h4><strong>Zona Pasar Apung: Tempat Makan & Belanja Unik</strong></h4>\r\n    <p>Setelah puas menjelajahi berbagai zona di Museum Angkut, jangan lupa mampir ke Pasar Apung Nusantara yang ada di area luar museum. Konsepnya mirip dengan pasar terapung di Kalimantan, di mana berbagai jajanan tradisional dijual dari perahu-perahu kecil.</p>\r\n    <p>Di sini, kamu bisa mencicipi makanan khas Jawa Timur seperti nasi pecel, tahu petis, rujak cingur, hingga es dawet. Selain makanan, Pasar Apung juga menjual berbagai suvenir khas Malang yang cocok buat oleh-oleh.</p>\r\n\r\n    <h4><strong>Tips Berkunjung ke Museum Angkut</strong></h4>\r\n    <ul>\r\n        <li><strong>Datang lebih awal</strong> - Museum ini cukup luas, jadi kalau ingin menjelajahi semua zona dengan puas, sebaiknya datang pagi atau siang hari.</li>\r\n        <li><strong>Gunakan pakaian dan sepatu yang nyaman</strong> - Karena kamu akan banyak berjalan, pakailah pakaian yang santai dan sepatu yang nyaman.</li>\r\n        <li><strong>Bawa kamera atau ponsel dengan baterai penuh</strong> - Ada banyak spot keren yang sayang banget kalau tidak diabadikan.</li>\r\n        <li><strong>Jangan lupa cek jadwal pertunjukan</strong> - Supaya tidak ketinggalan parade kendaraan atau atraksi seru lainnya.</li>\r\n    </ul>\r\n\r\n    <h4><strong>Kesimpulan</strong></h4>\r\n    <p>Museum Angkut bukan sekadar museum biasa, tapi tempat wisata edukasi yang menyenangkan untuk semua usia. Dengan koleksi kendaraan klasik, zona tematik yang keren, dan berbagai wahana interaktif, tempat ini cocok banget buat pecinta otomotif maupun yang sekadar ingin jalan-jalan dan hunting foto keren.</p>\r\n    <p>Jadi, kalau kamu ke Malang atau Batu, jangan lupa mampir ke Museum Angkut. Siapkan kamera, ajak teman atau keluarga, dan nikmati pengalaman menjelajahi dunia otomotif dalam suasana yang unik dan mengesankan!</p>', 'museum.jpg'),
(3, '21 April 2025', 'Manfaat Olahraga bagi Kesehatan Tubuh', '<p>Olahraga adalah aktivitas fisik yang dilakukan secara teratur untuk meningkatkan kebugaran tubuh. Di zaman modern ini, olahraga menjadi semakin penting karena gaya hidup yang semakin tidak sehat dikarenakan banyaknya polusi dan makanan cepat saji yang jika tidak kita imbangi dengan olahraga akan membuat tubuh tidak sehat.</p>\r\n    \r\n    <h2>Manfaat Utama Olahraga</h2>\r\n    <ul>\r\n        <li>Meningkatkan kesehatan jantung dan sistem peredaran darah</li>\r\n        <li>Memperkuat otot dan tulang</li>\r\n        <li>Mengurangi risiko penyakit kronis seperti diabetes</li>\r\n        <li>Meningkatkan kualitas tidur</li>\r\n        <li>Menurunkan tingkat stres</li>\r\n    </ul>\r\n    \r\n    <h2>Jenis Olahraga yang Disarankan</h2>\r\n    <p>Beberapa jenis olahraga yang mudah dilakukan antara lain:</p>\r\n    <ol>\r\n        <li>Jalan cepat atau jogging</li>\r\n        <li>Bersepeda</li>\r\n        <li>Berenang</li>\r\n        <li>Senam aerobik</li>\r\n        <li>Latihan beban ringan</li>\r\n    </ol>\r\n    \r\n    <h2>Kesimpulan</h2>\r\n    <p>Olahraga teratur selama 30 menit per hari sudah cukup memberikan manfaat kesehatan yang signifikan. Mulailah dengan intensitas ringan dan tingkatkan secara bertahap sesuai kemampuan tubuh.</p>\r\n    \r\n    <p><strong>Ingat:</strong> Konsultasikan dengan dokter sebelum memulai program olahraga baru, terutama jika memiliki kondisi kesehatan tertentu.</p>', 'berolahraga.jpg'),
(4, '22 April 2025 ', 'Trend Otomotif Terkini Yang Wajib Diketahui', '<p>Industri otomotif global sedang mengalami transformasi besar menuju elektrifikasi. Produsen-produsen besar seperti Mercedes Benz, Tesla, Toyota, dan Hyundai, Honda dan lainnya terus meluncurkan model-model listrik terbaru dengan teknologi baterai yang semakin canggih.Maka dari itu masyarakat harus mendorong kemajuan teknologi serta mendukungnya</p>\r\n    \r\n    <h2>Fitur Keselamatan Canggih</h2>\r\n    <ul>\r\n        <li>Sistem pengereman otomatis (AEB)</li>\r\n        <li>Peringatan blind spot</li>\r\n        <li>Adaptive cruise control</li>\r\n        <li>Asisten tetap di jalur (lane keeping assist)</li>\r\n    </ul>\r\n    \r\n    <h2>Teknologi Konektivitas</h2>\r\n    <p>Mobil modern kini dilengkapi dengan berbagai fitur konektivitas seperti:</p>\r\n    <ol>\r\n        <li>Apple CarPlay dan Android Auto</li>\r\n        <li>Update software over-the-air</li>\r\n        <li>Koneksi WiFi onboard</li>\r\n        <li>Asisten suara canggih</li>\r\n    </ol>\r\n    \r\n    <h2>Mobil Otonom Level 3</h2>\r\n    <p>Beberapa produsen mulai meluncurkan mobil dengan kemampuan mengemudi otonom level 3 dimana mobil dapat mengambil alih pengendalian dalam kondisi tertentu, meski pengemudi masih harus siap mengambil alih kendali.</p>\r\n    \r\n    <h2>Tips Merawat Kendaraan</h2>\r\n    <p>Beberapa hal dasar yang perlu diperhatikan:</p>\r\n    <ul>\r\n        <li>Servis rutin sesuai jadwal</li>\r\n        <li>Periksa tekanan ban secara berkala</li>\r\n        <li>Ganti oli mesin tepat waktu</li>\r\n        <li>Bersihkan bagian bawah mobil secara rutin</li>\r\n    </ul>\r\n    \r\n    <p><em>Dunia otomotif terus berkembang dengan inovasi-inovasi baru yang membuat berkendara semakin aman, nyaman, dan ramah lingkungan.</em></p>', 'otomotif.jpg'),
(5, '23 April 2025', 'Pendidikan Di Era Revolusi Digital', '<p>Dunia pendidikan saat ini mengalami transformasi besar-besaran seiring perkembangan teknologi digital. Metode pembelajaran konvensional kini mulai dipadukan dengan berbagai teknologi modern untuk menciptakan pengalaman belajar yang lebih interaktif, efisien, serta fleksibel untuk kemajuan pendidikan di negara kita tercinta ini.</p>\r\n    \r\n    <h2>Teknologi Terkini dalam Pendidikan</h2>\r\n    <ul>\r\n        <li>Pembelajaran berbasis <strong>Artificial Intelligence</strong></li>\r\n        <li>Penggunaan <strong>Virtual Reality</strong> untuk simulasi pembelajaran</li>\r\n        <li>Sistem <strong>Learning Management System</strong> (LMS) online</li>\r\n        <li>Aplikasi mobile untuk belajar mandiri</li>\r\n    </ul>\r\n    \r\n    <h2>Keterampilan Penting di Masa Depan</h2>\r\n    <p>Menurut World Economic Forum, beberapa keterampilan kritis yang dibutuhkan di masa depan adalah:</p>\r\n    <ol>\r\n        <li>Kemampuan berpikir kritis dan analitis</li>\r\n        <li>Kreativitas dan inovasi</li>\r\n        <li>Kecerdasan emosional</li>\r\n        <li>Kemampuan teknologi digital</li>\r\n        <li>Kemampuan belajar sepanjang hayat</li>\r\n    </ol>\r\n    \r\n    <h2>Pendidikan Inklusif</h2>\r\n    <p>Sistem pendidikan modern kini lebih berfokus pada pendidikan inklusif yang memberikan kesempatan belajar yang sama bagi semua siswa, termasuk mereka dengan kebutuhan khusus. Teknologi assistive menjadi salah satu solusi penting dalam mewujudkan hal ini.</p>\r\n    \r\n    <h2>Tantangan Pendidikan Digital</h2>\r\n    <p>Beberapa tantangan yang dihadapi:</p>\r\n    <ul>\r\n        <li>Kesenjangan akses teknologi</li>\r\n        <li>Kesiapan guru dalam mengadopsi teknologi baru</li>\r\n        <li>Perlindungan data privasi siswa</li>\r\n        <li>Kualitas konten pendidikan digital</li>\r\n    </ul>\r\n    \r\n    <h2>Tips Belajar Efektif</h2>\r\n    <p>Beberapa strategi belajar efektif di era digital:</p>\r\n    <ol>\r\n        <li>Manajemen waktu yang baik</li>\r\n        <li>Pembelajaran aktif dan kolaboratif</li>\r\n        <li>Pemanfaatan berbagai sumber belajar online</li>\r\n        <li>Evaluasi belajar secara berkala</li>\r\n    </ol>\r\n    \r\n    <p><em>Pendidikan di masa depan akan terus berkembang dengan mengintegrasikan teknologi, namun tetap berfokus pada pengembangan karakter dan kompetensi peserta didik.</em></p>\r\n', 'pendidikan.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `article_author`
--

CREATE TABLE `article_author` (
  `article_id` int NOT NULL,
  `author_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `article_author`
--

INSERT INTO `article_author` (`article_id`, `author_id`) VALUES
(1, 1),
(4, 2),
(2, 3),
(5, 4),
(3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `article_category`
--

CREATE TABLE `article_category` (
  `article_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `article_category`
--

INSERT INTO `article_category` (`article_id`, `category_id`) VALUES
(1, 5),
(2, 5),
(5, 6),
(4, 7),
(3, 8);

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int NOT NULL,
  `level` varchar(50) NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `level`, `nickname`, `email`, `password`) VALUES
(1, 'Admin', 'Abbiyi', 'abbiyi@gmail.com', '11111111'),
(2, 'Admin', 'Deny', 'deny@gmail.com', '22222222'),
(3, 'Author', 'Fauzan', 'fauzan@gmail.com', '33333333'),
(4, 'Author', 'Abyan', 'abyan@gmail.com', '44444444'),
(5, 'Author', 'Rafif', 'rafif@gmail.com', '55555555'),
(6, 'Author', 'Sarim', 'sarim@gmail.com', '66666666'),
(12, 'Admin', 'Isul', 'isul@gmail.com', '88888888'),
(14, 'Admin', 'Margareta', 'margaret@gmail.com', '00000000'),
(15, 'Admin', 'abi', 'abi@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(4, 'Alam', 'Kategori yang mencakup tempat wisata alam seperti gunung, pantai, air terjun, dan hutan wisata.'),
(5, 'Wisata', 'Kategori yang berisi tempat wisata edukasi seperti museum, pusat sains, kebun binatang, dan planetarium.'),
(6, 'Pendidikan', 'Kategori yang mencakup berbagai berita di sektor pendidikan'),
(7, 'Otomotif', 'Kategori berita yang mencakup semua sektor di bidang otomotif'),
(8, 'Olahraga', 'Kategori berita yang mencakup semua sektor di bidang olahraga'),
(10, 'Politik', 'Kategori yang membahas di bidang politik terkini'),
(11, 'Sejarah', 'Kategori yang membahas di bidang sejarah'),
(12, 'Teknologi', 'Kategori yang membahas tentang kemajuan teknologi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article_author`
--
ALTER TABLE `article_author`
  ADD PRIMARY KEY (`article_id`,`author_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `article_category`
--
ALTER TABLE `article_category`
  ADD PRIMARY KEY (`article_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article_author`
--
ALTER TABLE `article_author`
  ADD CONSTRAINT `article_author_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_author_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `article_category`
--
ALTER TABLE `article_category`
  ADD CONSTRAINT `article_category_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
