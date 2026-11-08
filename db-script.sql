/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.8-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: lsp2026
-- ------------------------------------------------------
-- Server version	11.8.8-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `achievements`
--

DROP TABLE IF EXISTS `achievements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `achievements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned NOT NULL,
  `title` varchar(128) NOT NULL,
  `rank` smallint(5) unsigned NOT NULL DEFAULT 0,
  `level` varchar(50) NOT NULL DEFAULT '',
  `isTiered` tinyint(1) NOT NULL,
  `headerImage` varchar(256) DEFAULT NULL,
  `content` text NOT NULL,
  `year` smallint(5) unsigned NOT NULL,
  `month` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Achivements` (`userId`),
  CONSTRAINT `FK_Achivements` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `achievements`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `achievements` WRITE;
/*!40000 ALTER TABLE `achievements` DISABLE KEYS */;
INSERT INTO `achievements` VALUES
(3,1,'Juara Harapan 2 LKS Nasional ITSSB',5,'Nasional',1,'293edd155a21ceb3bf1cf8de5e9ae3df.jpeg','Selamat kepada Naf&#039;an Rizkilah atas pencapaiannya di Lomba Kompetensi Siswa (LKS) mata lomba IT Software Solutions for Business (ITSSB) Tingkat Nasional sebagai peraih urutan ke 5 dari 30 peserta dan peraih Medal of Excellence',2026,7),
(4,1,'Medali Emas LKS ITSSB Prov. Jawa Tengah',1,'Provinsi',1,'750093a41af137a638618b715a0bd367.jpeg','Selamat kepada Naf&#039;an Rizkilah atas pencapaiannya di Lomba Kompetensi Siswa (LKS) mata lomba IT Software Solutions for Business (ITSSB) Provinsi Jawa Tengah sebagai peraih medali emas',2026,4),
(5,1,'Medali Perak LKS Web Technology Prov. Jawa Tengah',2,'Provinsi',1,'12abeb2b9a60a2c4c05641e5b05aa69c.jpeg','Selamat kepada Arya Dwiputra atas pencapaiannya di Lomba Kompetensi Siswa (LKS) mata lomba Web Technology (Teknologi Web) Provinsi Jawa Tengah sebagai peraih medali perak',2026,4),
(6,1,'Medali Perak Bee Fest: GACCI',2,'Nasional',0,'88c1254f8c57b64e737ae60847c0d9f4.jpeg','Selamat kepada Azaria Adila Putri atas pencapaiannya di lomba Game Analysis Creative Challenge of Ideas (GACCI) yang diselenggarakan di BINUS Jakarta sebagai peraih medali perak.',2026,9),
(7,1,'Medali Perunggu Krenova Kab. Batang',3,'Kabupaten',0,'2921206a4a1c0b4c9752a114894cf147.jpeg','Selamat kepada Fayakun Achmad Isa, Gading Arta Pasha Pratama, Wildan Arka Ardiansyah atas pencapaiannya di lomba KRENOVA yang diselenggarakan oleh BAPPERIDA Kabupaten Batang pada tahun 2026 sebagai peraih medali perunggu',2026,5),
(8,1,'Medali Perak LKS Nasional Web Technology',2,'Nasional',1,NULL,'Selamat kepada Amat Qoimam Bilqisti atas pencapaiannya di Lomba Kompetensi Siswa (LKS) mata lomba Web Technology (Teknologi Web) Tingkat Nasional sebagai peraih medali perak',2022,10),
(9,1,'Medali Emas LKS Prov. Jawa Tengah Web Technology',1,'Provinsi',1,NULL,'Selamat kepada Amat Qoimam Bilqisti atas pencapaiannya di Lomba Kompetensi Siswa (LKS) mata lomba Web Technology (Teknologi Web) Tingkat Provinsi Jawa Tengah sebagai peraih medali emas',2022,5);
/*!40000 ALTER TABLE `achievements` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `announcements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned NOT NULL,
  `title` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `expiredAt` datetime DEFAULT NULL,
  `publishedAt` datetime DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `FK_Announcements` (`userId`),
  CONSTRAINT `FK_Announcements` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
INSERT INTO `announcements` VALUES
(2,1,'Jadwal Uji Sertifikasi LSP RPL Tahun 2026','jadwal-uji-sertifikasi-lsp-rpl-tahun-2026','<div>Uji Sertifikasi diselenggarakan oleh <a href=\"https://lspmi.co.id/\" rel=\"noopener noreferrer\">LSPMI</a> (LSP Media Informatika), sebuah Lembaga Sertifikasi Profesi Pihak Ketiga (LSP P3) yang kompeten dalam bidang profesi Teknologi Informasi.<br />Berikut adalah jadwalnya:<br /><br /></div><div><figure data-trix-attachment=\"{&#34;contentType&#34;:&#34;image/jpeg&#34;,&#34;filename&#34;:&#34;IMG-20260921-WA0005.jpg&#34;,&#34;filesize&#34;:115466,&#34;height&#34;:477,&#34;url&#34;:&#34;/assets/uploads/cb9c3f9b40c83e70bd9f583d6527abeb.jpg&#34;,&#34;width&#34;:401}\" data-trix-content-type=\"image/jpeg\" data-trix-attributes=\"{&#34;caption&#34;:&#34;Sesi Pertama&#34;,&#34;presentation&#34;:&#34;gallery&#34;}\"><img src=\"/assets/uploads/cb9c3f9b40c83e70bd9f583d6527abeb.jpg\" width=\"401\" height=\"477\" /><figcaption>Sesi Pertama</figcaption></figure><figure data-trix-attachment=\"{&#34;contentType&#34;:&#34;image/jpeg&#34;,&#34;filename&#34;:&#34;IMG-20260921-WA0004.jpg&#34;,&#34;filesize&#34;:116377,&#34;height&#34;:477,&#34;url&#34;:&#34;/assets/uploads/dcbce4813c427f42539f168d7bf31a7c.jpg&#34;,&#34;width&#34;:401}\" data-trix-content-type=\"image/jpeg\" data-trix-attributes=\"{&#34;caption&#34;:&#34;Sesi Kedua&#34;,&#34;presentation&#34;:&#34;gallery&#34;}\"><img src=\"/assets/uploads/dcbce4813c427f42539f168d7bf31a7c.jpg\" width=\"401\" height=\"477\" /><figcaption>Sesi Kedua</figcaption></figure><figure data-trix-attachment=\"{&#34;contentType&#34;:&#34;image/jpeg&#34;,&#34;filename&#34;:&#34;IMG-20260921-WA0006.jpg&#34;,&#34;filesize&#34;:114432,&#34;height&#34;:477,&#34;url&#34;:&#34;/assets/uploads/e819f4d913173d0fe380f010ef602a6b.jpg&#34;,&#34;width&#34;:401}\" data-trix-content-type=\"image/jpeg\" data-trix-attributes=\"{&#34;caption&#34;:&#34;Sesi Ketiga&#34;,&#34;presentation&#34;:&#34;gallery&#34;}\"><img src=\"/assets/uploads/e819f4d913173d0fe380f010ef602a6b.jpg\" width=\"401\" height=\"477\" /><figcaption>Sesi Ketiga</figcaption></figure></div><div>Ada pun detail kompetensi yang akan diujikan terlampir pada file berikut:<br /><figure data-trix-attachment=\"{&#34;contentType&#34;:&#34;application/pdf&#34;,&#34;filename&#34;:&#34;Tugas Praktek Skema Pemrogram Web Junior.pdf&#34;,&#34;filesize&#34;:148094,&#34;href&#34;:&#34;/assets/uploads/29d9e3d8a949f4c57d7d28698e277a79.pdf&#34;,&#34;url&#34;:&#34;/assets/uploads/29d9e3d8a949f4c57d7d28698e277a79.pdf&#34;}\" data-trix-content-type=\"application/pdf\"><a href=\"/assets/uploads/29d9e3d8a949f4c57d7d28698e277a79.pdf\" rel=\"noopener noreferrer\"><figcaption><span>Tugas Praktek Skema Pemrogram Web Junior.pdf</span> <span>144.62 KB</span></figcaption></a></figure></div>','2026-09-26 12:00:00','2026-09-21 20:49:00','2026-09-21 13:49:11','2026-09-21 13:53:27'),
(3,1,'Simulasi Tes Kompetensi Akademik Tahun 2026','simulasi-tes-kompetensi-akademik-tahun-2026','<div>Simulasi Tes Kompetensi Akademik Tahun 2026 akan dilakukan dari tanggal 21-25 September, harap para murid dan guru bisa melaksanakan dengan sebaik-baiknya.</div>','2026-09-25 12:00:00','2026-09-21 21:03:29','2026-09-21 14:03:29','2026-09-21 14:03:29');
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned NOT NULL,
  `categoryId` int(10) unsigned NOT NULL,
  `title` varchar(256) NOT NULL,
  `slug` varchar(256) NOT NULL,
  `headerImage` varchar(256) NOT NULL,
  `content` text NOT NULL,
  `isReleased` tinyint(1) NOT NULL DEFAULT 1,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `FK_Users_Articles` (`userId`),
  KEY `FK_Categories_Articles` (`categoryId`),
  CONSTRAINT `FK_Categories_Articles` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Users_Articles` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES
(11,1,2,'Perayaan HUT Ke-23 SMK Negeri 1 Kandeman','perayaan-hut-ke-23-smk-negeri-1-kandeman','0e59a0069f247998d56e359f0c8aa024.jpg','<div>Bertambahnya usia bukan sekadar catatan angka pada kalender, melainkan penanda perjalanan panjang penuh perjuangan. Begitu pula yang dirasakan oleh keluarga besar SMK Negeri 1 Kandeman, yang pada tahun 2026 ini genap menginjak usia ke-23. Dengan semangat kebersamaan yang membara, seluruh warga sekolah — dari jajaran guru, tenaga kependidikan, hingga ribuan siswa-siswi — bahu-membahu menghadirkan rangkaian perayaan yang meriah, sarat makna, dan sarat kejutan sepanjang empat hari penuh, terhitung sejak Senin, 27 Juli 2026 hingga puncaknya pada Kamis, 30 Juli 2026.<br /><br /></div><div>Rangkaian HUT ke-23 SMK Negeri 1 Kandeman dibuka pada Senin, 27 Juli 2026, dengan kegiatan yang edukatif, yaitu sosialisasi pemilahan sampah. Seluruh siswa mendapatkan pemahaman mendalam tentang pentingnya memilah sampah organik dan anorganik sebagai wujud kepedulian terhadap lingkungan, sekaligus menjadi fondasi bagi program bank sampah sekolah yang akan diluncurkan pada hari-hari berikutnya.<br /><br /></div><div>Selasa, 28 Juli 2026 menjadi hari yang paling dinantikan oleh seluruh siswa. Jalanan di sekitar lingkungan SMK Negeri 1 Kandeman berubah menjadi lautan warna dan kegembiraan saat karnaval dalam rangka HUT ke-23 sekolah resmi digelar. Mengusung tema unik bertajuk “Mc.Farm”, setiap kelas berlomba menampilkan kreativitas terbaik mereka melalui kostum-kostum lucu dan kreatif bertema peternakan. Barisan siswa berjalan penuh percaya diri mengelilingi rute di sekitar sekolah dan berpusat di Lapangan Kaliongkek untuk lomba yel-yel antarkelas. Sorak-sorai penonton dan warga sekitar turut menambah semarak suasana, menjadikan karnaval ini bukan hanya ajang unjuk kreativitas, tetapi juga wujud nyata kedekatan SMK Negeri 1 Kandeman dengan masyarakat sekitarnya.<br /><figure data-trix-attachment=\"{&#34;contentType&#34;:&#34;image/jpeg&#34;,&#34;filename&#34;:&#34;hut1.jpg&#34;,&#34;filesize&#34;:1022796,&#34;height&#34;:1000,&#34;href&#34;:&#34;/assets/uploads/e606da7672fab2403a5980a20b4a3515.jpg&#34;,&#34;url&#34;:&#34;/assets/uploads/e606da7672fab2403a5980a20b4a3515.jpg&#34;,&#34;width&#34;:1500}\" data-trix-content-type=\"image/jpeg\" data-trix-attributes=\"{&#34;caption&#34;:&#34;Upacara pada 28 Juli 2026&#34;,&#34;presentation&#34;:&#34;gallery&#34;}\"><a href=\"/assets/uploads/e606da7672fab2403a5980a20b4a3515.jpg\" rel=\"noopener noreferrer\"><img src=\"/assets/uploads/e606da7672fab2403a5980a20b4a3515.jpg\" width=\"1500\" height=\"1000\" /><figcaption>Upacara pada 28 Juli 2026</figcaption></a></figure>Memasuki hari ketiga, Rabu, 29 Juli 2026, suasana aula SMK Negeri 1 Kandeman berubah menjadi pusat kegiatan yang lebih serius tapi tak kalah istimewa. Sekolah membuka pintu selebar-lebarnya bagi masyarakat umum melalui gelaran Job Fair, sebuah kesempatan emas bagi para pencari kerja maupun lulusan untuk terhubung langsung dengan berbagai perusahaan mitra. Momen ini sekaligus menjadi ajang pembuktian bahwa SMK Negeri 1 Kandeman senantiasa berkomitmen mencetak lulusan yang siap kerja dan siap bersaing di dunia industri.<br /><br /></div><div>Rangkaian panjang perayaan HUT ke-23 SMK Negeri 1 Kandeman akhirnya mencapai puncaknya pada Kamis, 30 Juli 2026. Acara seremonial yang berlangsung khidmat sekaligus meriah ini menjadi momen penuh haru dan kebanggaan bagi seluruh keluarga besar Skansaka.<br /><figure data-trix-attachment=\"{&#34;contentType&#34;:&#34;image/jpeg&#34;,&#34;filename&#34;:&#34;hut2.jpg&#34;,&#34;filesize&#34;:131481,&#34;height&#34;:683,&#34;href&#34;:&#34;/assets/uploads/d055efaf718362f845bd851c5e8493a5.jpg&#34;,&#34;url&#34;:&#34;/assets/uploads/d055efaf718362f845bd851c5e8493a5.jpg&#34;,&#34;width&#34;:1024}\" data-trix-content-type=\"image/jpeg\" data-trix-attributes=\"{&#34;caption&#34;:&#34;Upacara pada 30 Juli 2026&#34;,&#34;presentation&#34;:&#34;gallery&#34;}\"><a href=\"/assets/uploads/d055efaf718362f845bd851c5e8493a5.jpg\" rel=\"noopener noreferrer\"><img src=\"/assets/uploads/d055efaf718362f845bd851c5e8493a5.jpg\" width=\"1024\" height=\"683\" /><figcaption>Upacara pada 30 Juli 2026</figcaption></a></figure>Di hari yang sama, sekolah juga resmi meluncurkan Nexus, si badak bercula dua, ikon SMK Negeri 1 Kandeman, sebuah simbol identitas baru yang diharapkan mampu memperkuat citra dan kebanggaan bagi seluruh warga sekolah.<br /><br /></div><div>Suasana semakin hangat dan penuh tawa saat digelar lomba vocal grup yang diikuti oleh Bapak dan Ibu Guru serta Tenaga Kependidikan (GTK) antar MGMP. Penampilan penuh semangat dan kekompakan dari para pendidik ini sukses menghangatkan suasana dan membuktikan bahwa kebersamaan tak mengenal batas usia maupun peran.<br /><br /></div><div>Kemeriahan dan kelancaran seluruh rangkaian perayaan HUT ke-23 SMK Negeri 1 Kandeman tidak lepas dari dukungan penuh berbagai pihak yang telah bersinergi bersama sekolah. Melalui kesempatan ini, keluarga besar SMK Negeri 1 Kandeman menyampaikan rasa terima kasih yang setulus-tulusnya kepada seluruh sponsor dan mitra kerja sama yang telah berkontribusi, baik dalam bentuk dana, produk, maupun dukungan tenaga, sehingga acara dapat berjalan meriah dari awal hingga akhir.<br /><br /></div><div>Dukungan tersebut datang dari berbagai kalangan di sekitar wilayah Kandeman dan sekitarnya. Berikut adalah pihak-pihak yang telah berperan sebagai sponsor dalam kesuksesan perayaan HUT ke-23 SMK Negeri 1 Kandeman:</div><ul><li>Bank Jateng</li><li>KITB</li><li>Mile Network</li><li>Universitas Terbuka</li><li>MIPA Tour Batang</li><li>STEKOM</li><li>CV. Solusi Karya Manunggal</li><li>KSU Teknika Mandiri</li><li>Toko Siswa Mitra Mandiri</li><li>PT. SMU Deal</li><li>LPK IJI</li><li>LKM BKD</li><li>Biru Offset</li><li>CV. Pribumi</li></ul><div>Terima kasih yang tak terhingga juga disampaikan kepada seluruh pihak yang tidak dapat disebutkan satu per satu, atas segala bentuk dukungan moril maupun materiil. Sinergi yang terjalin erat inilah yang menjadikan HUT ke-23 SMK Negeri 1 Kandeman berlangsung sukses, meriah, dan penuh makna bagi seluruh warga sekolah maupun masyarakat sekitar.<br /><br /></div><div>Empat hari penuh warna, mulai dari edukasi lingkungan, kreativitas karnaval, semangat kewirausahaan, hingga kemeriahan panggung ceremonial, telah menjadi bukti nyata bahwa SMK Negeri 1 Kandeman terus tumbuh sebagai lembaga pendidikan yang tak hanya unggul dalam akademik dan keterampilan, tetapi juga peduli terhadap lingkungan, masyarakat, dan masa depan bangsa.<br /><br /></div><div>Di usianya yang ke-23, SMK Negeri 1 Kandeman semakin mengukuhkan diri sebagai sekolah kejuruan yang siap mencetak generasi unggul, kreatif, dan berdaya saing tinggi. Selamat Ulang Tahun ke-23, SMK Negeri 1 Kandeman! Teruslah berkarya, berinovasi, dan menginspirasi — karena Skansaka bukan hanya untuk Kandeman, tetapi untuk Indonesia.<br /><br /></div>',1,'2026-07-24 14:37:16','2026-09-22 04:51:01'),
(12,1,2,'Job Fair SMK Negeri 1 Kandeman','job-fair-smk-negeri-1-kandeman','9ba65fed8970b738e9ab342b5c0be9a4.jpg','<div>Batang – SMK Negeri 1 Kandeman menggelar kegiatan Job Fair (Bursa Kerja) dalam rangka memperingati Hari Ulang Tahun (HUT) sekolah tersebut. Kegiatan yang berlangsung pada hari Rabu, 29 Juli 2026 ini bertujuan untuk mempertemukan para pencari kerja, khususnya lulusan SMK, dengan berbagai perusahaan yang membuka lowongan pekerjaan. Acara ini menjadi salah satu wujud komitmen sekolah dalam menjembatani dunia pendidikan dengan dunia industri dan dunia kerja (DUDI).<br /><br /></div><div>Acara pembukaan Job Fair berlangsung meriah dan dihadiri langsung oleh Bupati Batang. Kehadiran orang nomor satu di Kabupaten Batang tersebut menunjukkan dukungan penuh pemerintah daerah terhadap upaya peningkatan kualitas sumber daya manusia serta penyerapan tenaga kerja di wilayah Batang dan sekitarnya. Dalam sambutannya, Bupati mengapresiasi inisiatif SMK Negeri 1 Kandeman yang secara konsisten menyelenggarakan kegiatan bursa kerja sebagai bagian dari peringatan hari jadi sekolah, sekaligus berharap kegiatan ini dapat memberikan manfaat nyata bagi masyarakat, khususnya para pencari kerja.<br /><br /><figure data-trix-attachment=\"{&#34;contentType&#34;:&#34;image/jpeg&#34;,&#34;filename&#34;:&#34;jobfair0.jpg&#34;,&#34;filesize&#34;:62862,&#34;height&#34;:548,&#34;href&#34;:&#34;/assets/uploads/afd37df2bdf2fc7f649cd5f371adf612.jpg&#34;,&#34;url&#34;:&#34;/assets/uploads/afd37df2bdf2fc7f649cd5f371adf612.jpg&#34;,&#34;width&#34;:502}\" data-trix-content-type=\"image/jpeg\" data-trix-attributes=\"{&#34;caption&#34;:&#34;Job Fair&#34;,&#34;presentation&#34;:&#34;gallery&#34;}\"><a href=\"/assets/uploads/afd37df2bdf2fc7f649cd5f371adf612.jpg\" rel=\"noopener noreferrer\"><img src=\"/assets/uploads/afd37df2bdf2fc7f649cd5f371adf612.jpg\" width=\"502\" height=\"548\" /><figcaption>Job Fair</figcaption></a></figure>Job Fair kali ini diikuti oleh 24 perusahaan dan lembaga pelatihan kerja yang berasal dari berbagai sektor industri, mulai dari manufaktur, tekstil, ritel, jasa keuangan, hingga lembaga pelatihan kerja (LPK). Berikut daftar perusahaan dan lembaga yang berpartisipasi:<br /><figure data-trix-attachment=\"{&#34;contentType&#34;:&#34;image/png&#34;,&#34;filename&#34;:&#34;jobfair1.png&#34;,&#34;filesize&#34;:63694,&#34;height&#34;:444,&#34;href&#34;:&#34;/assets/uploads/e7125f1a44e78c47e41dc4cd85a196ba.png&#34;,&#34;url&#34;:&#34;/assets/uploads/e7125f1a44e78c47e41dc4cd85a196ba.png&#34;,&#34;width&#34;:336}\" data-trix-content-type=\"image/png\" data-trix-attributes=\"{&#34;caption&#34;:&#34;Daftar Perusahaan / Lembaga&#34;,&#34;presentation&#34;:&#34;gallery&#34;}\"><a href=\"/assets/uploads/e7125f1a44e78c47e41dc4cd85a196ba.png\" rel=\"noopener noreferrer\"><img src=\"/assets/uploads/e7125f1a44e78c47e41dc4cd85a196ba.png\" width=\"336\" height=\"444\" /><figcaption>Daftar Perusahaan / Lembaga</figcaption></a></figure><br />Animo masyarakat terhadap kegiatan Job Fair ini terbilang sangat tinggi. Tercatat sebanyak 4.685 peserta mendaftar untuk mengikuti bursa kerja tersebut, yang datang tidak hanya dari kalangan lulusan SMK Negeri 1 Kandeman, tetapi juga dari berbagai sekolah dan wilayah di sekitar Kabupaten Batang. Tingginya jumlah pendaftar ini mencerminkan besarnya kebutuhan masyarakat akan akses informasi lowongan kerja yang mudah, cepat, dan terpercaya.<br /><br /></div><div>Penyelenggaraan Job Fair dalam rangka HUT SMK Negeri 1 Kandeman ini menjadi bukti nyata sinergi yang baik antara pihak sekolah, pemerintah daerah, dan dunia usaha maupun dunia industri. Melalui kegiatan semacam ini, diharapkan lulusan SMK dapat lebih siap bersaing di dunia kerja, sekaligus membantu perusahaan-perusahaan mitra dalam memenuhi kebutuhan tenaga kerja yang kompeten di bidangnya masing-masing.<br /><br /></div><div>Pihak sekolah berharap kegiatan Job Fair ini dapat terus dilaksanakan secara berkelanjutan setiap tahunnya, sebagai bagian dari komitmen SMK Negeri 1 Kandeman dalam mencetak lulusan yang siap kerja, mandiri, dan berdaya saing tinggi di tengah tantangan dunia industri yang terus berkembang.<br /><br /></div>',1,'2026-07-24 15:48:21','2026-09-22 04:50:47'),
(13,1,1,'Rekapitulasi Realisasi Penggunaan Dana BOSP Tahap 1 Tahun 2026','rekapitulasi-realisasi-penggunaan-dana-bosp-tahap-1-tahun-2026','13cafb9e938ed34f017bbb38bbb41286.jpeg','<div>Pada tahap 1 penyaluran Dana BOS Tahun 2026, SMKN 1 Kandeman telah merealisasikan anggaran untuk berbagai keperluan operasional dan pengembangan sekolah. Penggunaan dana difokuskan pada peningkatan kualitas layanan pendidikan dan mendukung kegiatan belajar mengajar.<br />Berikut tabel Rekapitulasi Realisasi Penggunaan Dana BOSP Tahap 1 Tahun 2026 SMK Negeri 1 Kandeman:<br /><figure data-trix-attachment=\"{&#34;contentType&#34;:&#34;image/png&#34;,&#34;filename&#34;:&#34;Screenshot_2026-09-19_16-24-35.png&#34;,&#34;filesize&#34;:104425,&#34;height&#34;:588,&#34;href&#34;:&#34;/assets/uploads/8e409478705b483ccd19221ec0f384c4.png&#34;,&#34;url&#34;:&#34;/assets/uploads/8e409478705b483ccd19221ec0f384c4.png&#34;,&#34;width&#34;:937}\" data-trix-content-type=\"image/png\" data-trix-attributes=\"{&#34;caption&#34;:&#34;Tabel Rekapitulasi Realisasi Dana BOSP&#34;,&#34;presentation&#34;:&#34;gallery&#34;}\"><a href=\"/assets/uploads/8e409478705b483ccd19221ec0f384c4.png\" rel=\"noopener noreferrer\"><img src=\"/assets/uploads/8e409478705b483ccd19221ec0f384c4.png\" width=\"937\" height=\"588\" /><figcaption>Tabel Rekapitulasi Realisasi Dana BOSP</figcaption></a></figure><figure data-trix-attachment=\"{&#34;contentType&#34;:&#34;application/pdf&#34;,&#34;filename&#34;:&#34;Rekapitulasi-realisasi-Tahap-1.pdf&#34;,&#34;filesize&#34;:352910,&#34;href&#34;:&#34;/assets/uploads/7fe98b05169deac2469f24337670021f.pdf&#34;,&#34;url&#34;:&#34;/assets/uploads/7fe98b05169deac2469f24337670021f.pdf&#34;}\" data-trix-content-type=\"application/pdf\"><a href=\"/assets/uploads/7fe98b05169deac2469f24337670021f.pdf\" rel=\"noopener noreferrer\"><figcaption><span>Rekapitulasi-realisasi-Tahap-1.pdf</span> <span>344.64 KB</span></figcaption></a></figure></div>',1,'2026-09-19 09:26:40','2026-09-20 13:09:07'),
(15,1,2,'Pelaksanaan SPMB SMK Negeri 1 Kandeman Tahun Ajaran 2026/2027','pelaksanaan-spmb-smk-negeri-1-kandeman-tahun-ajaran-2026-2027','1b9817c01ad9080ee45c87fd559fdef5.png','<div>Sistem Penerimaan Murid Baru (SPMB) Tahun Ajaran 2026/2027 di lingkungan SMA/SMK Negeri Provinsi Jawa Tengah, termasuk di SMK Negeri 1 Kandeman, telah resmi selesai dilaksanakan. Berikut rangkuman informasi seputar proses SPMB tahun ini sebagai bahan dokumentasi dan referensi bagi masyarakat, khususnya calon murid yang akan mendaftar pada tahun-tahun berikutnya.<br /><br /></div><div>SMK Negeri 1 Kandeman merupakan salah satu SMK Pusat Keunggulan di Kabupaten Batang, Jawa Tengah, yang beralamat di Jl. Raya Kandeman Km.4, Kecamatan Kandeman, Kabupaten Batang. Sekolah ini mengusung 5 program keahlian : Teknik Mesin, Teknik Otomotif, Teknik Elektronika, Teknik Ketenagalistrikan, serta Pengembangan Perangkat Lunak dan Gim. Sebagai SMK Pusat Keunggulan, sekolah ini juga telah menjalin kerja sama dengan lebih dari 50 perusahaan dalam berbagai program, termasuk rekrutmen tenaga kerja bagi lulusannya, guna memastikan pembelajaran yang berstandar industri.<br /><br /></div><div>Pelaksanaan SPMB SMA, SMK, dan SLB Negeri se-Jawa Tengah Tahun Ajaran 2026/2027, termasuk di SMK Negeri 1 Kandeman, mengacu pada Petunjuk Operasional Penyelenggaraan (Jukop) SPMB yang diterbitkan oleh Dinas Pendidikan dan Kebudayaan Provinsi Jawa Tengah, berdasarkan Surat Keputusan Gubernur Jawa Tengah Nomor 100.3.3.1/117 Tahun 2026. Seluruh proses pendaftaran dilakukan secara daring melalui laman resmi spmb.jatengprov.go.id.<br /><br /></div><div>Tahapan Pelaksanaan<br /><br /></div><div>Secara umum, tahapan SPMB Jawa Tengah TA 2026/2027 berlangsung sebagai berikut:</div><ol><li>Pengajuan akun secara daring — calon murid baru membuat akun melalui laman resmi SPMB Jawa Tengah (3 – 12 Juni 2026)</li><li>Verifikasi dokumen dan aktivasi akun — verifikasi dokumen wajib dilakukan secara luring (tatap muka) di sekolah negeri terdekat, sementara aktivasi akun dapat dilakukan secara daring (4 – 13 Juni 2026).</li><li>Pendaftaran dan pemilihan sekolah — calon murid memilih sekolah dan jurusan/konsentrasi keahlian sesuai jalur yang diikuti, dilakukan secara daring (15 – 18 Juni 2026)</li><li>Verifikasi akhir dan seleksi — panitia SPMB memverifikasi berkas dan melakukan proses seleksi sesuai jalur pendaftaran masing-masing (19 – 20 Juni 2026).</li><li>Pengumuman hasil — hasil seleksi diumumkan secara daring melalui laman resmi SPMB Jawa Tengah (21 Juni 2026).</li><li>Daftar ulang — calon murid yang dinyatakan lolos wajib melakukan daftar ulang di sekolah tujuan dengan membawa dokumen fisik asli (22 – 25 Juni 2026).</li></ol><div>Calon murid dapat mendaftar melalui beberapa jalur, di antaranya:</div><ul><li>Jalur Domisili sebesar 10% dari daya tampung, diperuntukkan bagi calon murid yang berdomisili di dalam wilayah penerimaan murid baru.</li><li>Jalur Afirmasi sebesar 15% dari daya tampung, diperuntukkan bagi calon murid dari kelompok disabilitas, keluarga ekonomi tidak mampu, anak panti, dan/atau anak tidak sekolah (ATS).</li><li>Jalur Prestasi sebesar 75%.</li></ul><div>Rangkaian pendaftaran resmi dimulai pada pertengahan Juni 2026, dan hasil pengumuman kelulusan SPMB SMA/SMK Negeri se-Jawa Tengah TA 2026/2027 telah dirilis oleh Dinas Pendidikan Provinsi Jawa Tengah pada 21 Juni 2026. Hasil calon murid yang dinyatakan lulus pada masing-masing program keahlian adalah sebagai berikut:</div><ol><li>Teknik Mesin 72 murid</li><li>Teknik Otomotif 180 murid</li><li>Teknik Elektronika 144 murid</li><li>Teknik Ketenagalistrikan 72 murid</li><li>Pengembangan Perangkan Lunak dan Gim 72 murid</li></ol><div>Selamat bergabung di SMK Negeri 1 Kandeman untuk para murid baru. Semoga bertambah semangat mencari ilmu dan mampu menerapkannya di dunia nyata.<br /><br /></div><div>Dokumentasi Pelaksanaan SPMB SMK Negeri 1 Kandeman</div><div><figure data-trix-attachment=\"{&#34;contentType&#34;:&#34;image/png&#34;,&#34;filename&#34;:&#34;spmb0.png&#34;,&#34;filesize&#34;:501329,&#34;height&#34;:354,&#34;href&#34;:&#34;/assets/uploads/9612a607f4b650c2f2b53952f868a174.png&#34;,&#34;url&#34;:&#34;/assets/uploads/9612a607f4b650c2f2b53952f868a174.png&#34;,&#34;width&#34;:473}\" data-trix-content-type=\"image/png\" data-trix-attributes=\"{&#34;caption&#34;:&#34;Gambar 1&#34;,&#34;presentation&#34;:&#34;gallery&#34;}\"><a href=\"/assets/uploads/9612a607f4b650c2f2b53952f868a174.png\" rel=\"noopener noreferrer\"><img src=\"/assets/uploads/9612a607f4b650c2f2b53952f868a174.png\" width=\"473\" height=\"354\" /><figcaption>Gambar 1</figcaption></a></figure><figure data-trix-attachment=\"{&#34;contentType&#34;:&#34;image/png&#34;,&#34;filename&#34;:&#34;spmb1.png&#34;,&#34;filesize&#34;:461240,&#34;height&#34;:356,&#34;href&#34;:&#34;/assets/uploads/40739752815f81a473791291d8aab72a.png&#34;,&#34;url&#34;:&#34;/assets/uploads/40739752815f81a473791291d8aab72a.png&#34;,&#34;width&#34;:473}\" data-trix-content-type=\"image/png\" data-trix-attributes=\"{&#34;caption&#34;:&#34;Gambar 2&#34;,&#34;presentation&#34;:&#34;gallery&#34;}\"><a href=\"/assets/uploads/40739752815f81a473791291d8aab72a.png\" rel=\"noopener noreferrer\"><img src=\"/assets/uploads/40739752815f81a473791291d8aab72a.png\" width=\"473\" height=\"356\" /><figcaption>Gambar 2</figcaption></a></figure><figure data-trix-attachment=\"{&#34;contentType&#34;:&#34;image/png&#34;,&#34;filename&#34;:&#34;spmb2.png&#34;,&#34;filesize&#34;:491643,&#34;height&#34;:355,&#34;href&#34;:&#34;/assets/uploads/5427a88472b00b8073eb4f1e69f52915.png&#34;,&#34;url&#34;:&#34;/assets/uploads/5427a88472b00b8073eb4f1e69f52915.png&#34;,&#34;width&#34;:473}\" data-trix-content-type=\"image/png\" data-trix-attributes=\"{&#34;caption&#34;:&#34;Gambar 3&#34;,&#34;presentation&#34;:&#34;gallery&#34;}\"><a href=\"/assets/uploads/5427a88472b00b8073eb4f1e69f52915.png\" rel=\"noopener noreferrer\"><img src=\"/assets/uploads/5427a88472b00b8073eb4f1e69f52915.png\" width=\"473\" height=\"355\" /><figcaption>Gambar 3</figcaption></a></figure><figure data-trix-attachment=\"{&#34;contentType&#34;:&#34;image/png&#34;,&#34;filename&#34;:&#34;spmb3.png&#34;,&#34;filesize&#34;:446224,&#34;height&#34;:356,&#34;href&#34;:&#34;/assets/uploads/8f8e1fe3d5ba9077b1f1299c222dc7b6.png&#34;,&#34;url&#34;:&#34;/assets/uploads/8f8e1fe3d5ba9077b1f1299c222dc7b6.png&#34;,&#34;width&#34;:473}\" data-trix-content-type=\"image/png\" data-trix-attributes=\"{&#34;caption&#34;:&#34;Gambar 4&#34;,&#34;presentation&#34;:&#34;gallery&#34;}\"><a href=\"/assets/uploads/8f8e1fe3d5ba9077b1f1299c222dc7b6.png\" rel=\"noopener noreferrer\"><img src=\"/assets/uploads/8f8e1fe3d5ba9077b1f1299c222dc7b6.png\" width=\"473\" height=\"356\" /><figcaption>Gambar 4</figcaption></a></figure></div>',1,'2026-06-10 09:55:57','2026-09-22 04:50:21');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(72) NOT NULL,
  `description` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES
(1,'Transparansi',NULL),
(2,'Kegiatan',NULL);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `galleries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `refTable` varchar(64) NOT NULL,
  `refId` int(10) unsigned NOT NULL,
  `isCover` tinyint(1) NOT NULL DEFAULT 0,
  `mediaPath` varchar(64) NOT NULL,
  `description` varchar(384) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `refTable` (`refTable`),
  KEY `refId` (`refId`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galleries`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `galleries` WRITE;
/*!40000 ALTER TABLE `galleries` DISABLE KEYS */;
INSERT INTO `galleries` VALUES
(24,'articles',12,1,'9ba65fed8970b738e9ab342b5c0be9a4.jpg',NULL,'2026-09-18 15:48:21'),
(25,'articles',12,0,'e7125f1a44e78c47e41dc4cd85a196ba.png',NULL,'2026-09-18 15:48:21'),
(26,'articles',13,1,'13cafb9e938ed34f017bbb38bbb41286.jpeg',NULL,'2026-09-19 09:26:40'),
(28,'articles',11,1,'0e59a0069f247998d56e359f0c8aa024.jpg',NULL,'2026-09-19 09:37:38'),
(29,'articles',11,0,'d055efaf718362f845bd851c5e8493a5.jpg',NULL,'2026-09-19 09:37:38'),
(32,'articles',15,1,'1b9817c01ad9080ee45c87fd559fdef5.png',NULL,'2026-09-19 09:55:57'),
(33,'articles',15,0,'8f8e1fe3d5ba9077b1f1299c222dc7b6.png',NULL,'2026-09-19 09:55:57'),
(34,'articles',12,0,'afd37df2bdf2fc7f649cd5f371adf612.jpg',NULL,'2026-09-20 13:07:28'),
(35,'articles',13,0,'8e409478705b483ccd19221ec0f384c4.png',NULL,'2026-09-20 13:09:07'),
(39,'articles',15,0,'9612a607f4b650c2f2b53952f868a174.png',NULL,'2026-09-20 13:22:32'),
(40,'articles',15,0,'40739752815f81a473791291d8aab72a.png',NULL,'2026-09-20 13:22:32'),
(41,'articles',15,0,'5427a88472b00b8073eb4f1e69f52915.png',NULL,'2026-09-20 13:22:32'),
(42,'articles',11,0,'e606da7672fab2403a5980a20b4a3515.jpg',NULL,'2026-09-20 14:20:12');
/*!40000 ALTER TABLE `galleries` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `tmp_files`
--

DROP TABLE IF EXISTS `tmp_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tmp_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(72) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `filename` (`filename`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmp_files`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `tmp_files` WRITE;
/*!40000 ALTER TABLE `tmp_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `tmp_files` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(128) NOT NULL,
  `fullName` varchar(128) NOT NULL,
  `role` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'admin','$2y$12$8bLv1jMrx8XoPsRYQ6s02ef3CAyq2odcyltK0y/8fvkRDDZJdqUny','admin@smkn1kandeman.sch.id','First Admin','admin');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-11-08 17:08:50
