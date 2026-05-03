-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 02, 2026 at 11:37 AM
-- Server version: 11.8.6-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u479303946_pondasikita_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `toko_id` int(11) DEFAULT NULL,
  `status` enum('open','closed','pending_admin') NOT NULL DEFAULT 'open',
  `start_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `customer_id`, `admin_id`, `toko_id`, `status`, `start_time`) VALUES
(1, 16, NULL, 1, 'open', '2026-05-02 06:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(10) UNSIGNED NOT NULL,
  `province_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `province_id`, `name`) VALUES
(1, 1, 'KOTA JAKARTA PUSAT'),
(2, 1, 'KOTA JAKARTA UTARA'),
(3, 1, 'KOTA JAKARTA BARAT'),
(4, 1, 'KOTA JAKARTA SELATAN'),
(5, 1, 'KOTA JAKARTA TIMUR'),
(6, 2, 'KOTA BOGOR'),
(7, 2, 'KOTA DEPOK'),
(8, 2, 'KOTA BEKASI'),
(9, 2, 'KABUPATEN BOGOR'),
(10, 2, 'KABUPATEN BEKASI'),
(11, 2, 'KABUPATEN KARAWANG'),
(12, 3, 'KOTA TANGERANG'),
(13, 3, 'KOTA TANGERANG SELATAN'),
(14, 3, 'KABUPATEN TANGERANG'),
(15, 1, 'KAB. ADM. KEPULAUAN SERIBU'),
(21, 2, 'KABUPATEN SUBANG');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(10) UNSIGNED NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `city_id`, `name`) VALUES
(1, 1, 'Gambir'),
(2, 1, 'Sawah Besar'),
(3, 1, 'Kemayoran'),
(4, 1, 'Senen'),
(5, 1, 'Cempaka Putih'),
(6, 1, 'Menteng'),
(7, 1, 'Tanah Abang'),
(8, 1, 'Johar Baru'),
(9, 2, 'Penjaringan'),
(10, 2, 'Tanjung Priok'),
(11, 2, 'Koja'),
(12, 2, 'Kelapa Gading'),
(13, 2, 'Pademangan'),
(14, 2, 'Cilincing'),
(15, 3, 'Cengkareng'),
(16, 3, 'Grogol Petamburan'),
(17, 3, 'Taman Sari'),
(18, 3, 'Tambora'),
(19, 3, 'Kebon Jeruk'),
(20, 3, 'Kalideres'),
(21, 3, 'Palmerah'),
(22, 3, 'Kembangan'),
(23, 4, 'Tebet'),
(24, 4, 'Setiabudi'),
(25, 4, 'Mampang Prapatan'),
(26, 4, 'Pasar Minggu'),
(27, 4, 'Kebayoran Lama'),
(28, 4, 'Cilandak'),
(29, 4, 'Kebayoran Baru'),
(30, 4, 'Pancoran'),
(31, 4, 'Jagakarsa'),
(32, 4, 'Pesanggrahan'),
(33, 5, 'Matraman'),
(34, 5, 'Pulo Gadung'),
(35, 5, 'Jatinegara'),
(36, 5, 'Duren Sawit'),
(37, 5, 'Kramat Jati'),
(38, 5, 'Makasar'),
(39, 5, 'Pasar Rebo'),
(40, 5, 'Ciracas'),
(41, 5, 'Cipayung'),
(42, 5, 'Cakung'),
(43, 15, 'Kepulauan Seribu Utara'),
(44, 15, 'Kepulauan Seribu Selatan'),
(45, 6, 'Bogor Selatan'),
(46, 6, 'Bogor Timur'),
(47, 6, 'Bogor Utara'),
(48, 6, 'Bogor Tengah'),
(49, 6, 'Bogor Barat'),
(50, 6, 'Tanah Sareal'),
(51, 7, 'Pancoran Mas'),
(52, 7, 'Cimanggis'),
(53, 7, 'Sawangan'),
(54, 7, 'Limo'),
(55, 7, 'Sukmajaya'),
(56, 7, 'Beji'),
(57, 7, 'Cipayung'),
(58, 7, 'Cilodong'),
(59, 7, 'Cinere'),
(60, 7, 'Tapos'),
(61, 7, 'Bojongsari'),
(62, 8, 'Bekasi Timur'),
(63, 8, 'Bekasi Barat'),
(64, 8, 'Bekasi Utara'),
(65, 8, 'Bekasi Selatan'),
(66, 8, 'Rawalumbu'),
(67, 8, 'Medan Satria'),
(68, 8, 'Bantar Gebang'),
(69, 8, 'Pondok Gede'),
(70, 8, 'Jatiasih'),
(71, 8, 'Jatisampurna'),
(72, 8, 'Mustika Jaya'),
(73, 8, 'Pondok Melati'),
(74, 9, 'Cibinong'),
(75, 9, 'Gunung Putri'),
(76, 9, 'Citeureup'),
(77, 9, 'Sukaraja'),
(78, 9, 'Babakan Madang'),
(79, 9, 'Jonggol'),
(80, 9, 'Cileungsi'),
(81, 9, 'Cariu'),
(82, 9, 'Sukamakmur'),
(83, 9, 'Parung'),
(84, 9, 'Gunung Sindur'),
(85, 9, 'Kemang'),
(86, 9, 'Bojonggede'),
(87, 9, 'Leuwiliang'),
(88, 9, 'Ciampea'),
(89, 9, 'Cibungbulang'),
(90, 9, 'Pamijahan'),
(91, 9, 'Rumpin'),
(92, 9, 'Jasinga'),
(93, 9, 'Parung Panjang'),
(94, 9, 'Nanggung'),
(95, 9, 'Cigudeg'),
(96, 9, 'Tenjo'),
(97, 9, 'Ciawi'),
(98, 9, 'Cisarua'),
(99, 9, 'Megamendung'),
(100, 9, 'Caringin'),
(101, 9, 'Cijeruk'),
(102, 9, 'Ciomas'),
(103, 9, 'Dramaga'),
(104, 9, 'Tamansari'),
(105, 9, 'Klapanunggal'),
(106, 9, 'Ciseeng'),
(107, 9, 'Rancabungur'),
(108, 9, 'Tajurhalang'),
(109, 9, 'Cigombong'),
(110, 9, 'Leuwisadeng'),
(111, 9, 'Tenjolaya'),
(112, 9, 'Tanjungsari'),
(113, 9, 'Sukajaya'),
(114, 10, 'Cikarang Pusat'),
(115, 10, 'Cikarang Selatan'),
(116, 10, 'Cikarang Utara'),
(117, 10, 'Cikarang Barat'),
(118, 10, 'Cibitung'),
(119, 10, 'Setu'),
(120, 10, 'Tambun Selatan'),
(121, 10, 'Tambun Utara'),
(122, 10, 'Cibarusah'),
(123, 10, 'Serang Baru'),
(124, 10, 'Karangbahagia'),
(125, 10, 'Pebayuran'),
(126, 10, 'Sukakarya'),
(127, 10, 'Sukatani'),
(128, 10, 'Sukawangi'),
(129, 10, 'Tambelang'),
(130, 10, 'Babelan'),
(131, 10, 'Tarumajaya'),
(132, 10, 'Muara Gembong'),
(133, 10, 'Cabangbungin'),
(134, 10, 'Kedungwaringin'),
(135, 10, 'Bojongmangu'),
(136, 11, 'Karawang Barat'),
(137, 11, 'Karawang Timur'),
(138, 11, 'Klari'),
(139, 11, 'Rengasdengklok'),
(140, 11, 'Kutawaluya'),
(141, 11, 'Batujaya'),
(142, 11, 'Telukjambe Timur'),
(143, 11, 'Telukjambe Barat'),
(144, 11, 'Cikampek'),
(145, 11, 'Jatisari'),
(146, 11, 'Cilamaya Wetan'),
(147, 11, 'Cilamaya Kulon'),
(148, 11, 'Lemahabang'),
(149, 11, 'Rawamerta'),
(150, 11, 'Tempuran'),
(151, 11, 'Tirtajaya'),
(152, 11, 'Pedes'),
(153, 11, 'Cibuaya'),
(154, 11, 'Pakisjaya'),
(155, 11, 'Tirtamulya'),
(156, 11, 'Cilebar'),
(157, 11, 'Jayakerta'),
(158, 11, 'Majalaya'),
(159, 11, 'Banyusari'),
(160, 11, 'Kotabaru'),
(161, 11, 'Ciampel'),
(162, 11, 'Pangkalan'),
(163, 11, 'Tegalwaru'),
(164, 11, 'Purwasari'),
(165, 11, 'Telagasari'),
(166, 12, 'Tangerang'),
(167, 12, 'Batuceper'),
(168, 12, 'Benda'),
(169, 12, 'Cibodas'),
(170, 12, 'Ciledug'),
(171, 12, 'Cipondoh'),
(172, 12, 'Jatiuwung'),
(173, 12, 'Karangtengah'),
(174, 12, 'Karawaci'),
(175, 12, 'Larangan'),
(176, 12, 'Neglasari'),
(177, 12, 'Periuk'),
(178, 12, 'Pinang'),
(179, 13, 'Serpong'),
(180, 13, 'Serpong Utara'),
(181, 13, 'Pondok Aren'),
(182, 13, 'Ciputat'),
(183, 13, 'Ciputat Timur'),
(184, 13, 'Pamulang'),
(185, 13, 'Setu'),
(186, 14, 'Balaraja'),
(187, 14, 'Cikupa'),
(188, 14, 'Cisauk'),
(189, 14, 'Cisoka'),
(190, 14, 'Curug'),
(191, 14, 'Gunung Kaler'),
(192, 14, 'Jambe'),
(193, 14, 'Jayanti'),
(194, 14, 'Kelapa Dua'),
(195, 14, 'Kemiri'),
(196, 14, 'Kresek'),
(197, 14, 'Kronjo'),
(198, 14, 'Legok'),
(199, 14, 'Mauk'),
(200, 14, 'Mekar Baru'),
(201, 14, 'Pagedangan'),
(202, 14, 'Pakuhaji'),
(203, 14, 'Panongan'),
(204, 14, 'Pasar Kemis'),
(205, 14, 'Rajeg'),
(206, 14, 'Sepatan'),
(207, 14, 'Sepatan Timur'),
(208, 14, 'Sindang Jaya'),
(209, 14, 'Solear'),
(210, 14, 'Sukadiri'),
(211, 14, 'Sukamulya'),
(212, 14, 'Teluknaga'),
(213, 14, 'Tigaraksa'),
(214, 14, 'Kosambi'),
(215, 21, 'Pagaden'),
(216, 21, 'Cinangsi'),
(217, 21, 'Pagaden'),
(218, 21, 'Soklat');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `message_text` text NOT NULL,
  `message_type` enum('text','image','file','audio') NOT NULL DEFAULT 'text',
  `file_url` varchar(255) DEFAULT NULL COMMENT 'Menyimpan link gambar/voice note/file',
  `is_read` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = Belum dibaca, 1 = Sudah dibaca',
  `read_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `chat_id`, `sender_id`, `message_text`, `message_type`, `file_url`, `is_read`, `read_at`, `deleted_at`, `timestamp`) VALUES
(1, 1, 16, 'oi', 'text', NULL, 1, '2026-05-02 07:28:16', NULL, '2026-05-02 06:34:04'),
(2, 1, 16, '', 'audio', '/storage/chat_media/chat_1777705579_69f5a26badbb2.webm', 1, '2026-05-02 07:28:16', NULL, '2026-05-02 07:06:19'),
(3, 1, 16, 'surat-perjanjian.pdf', 'file', '/storage/chat_media/chat_1777705596_69f5a27cb2e9e.pdf', 1, '2026-05-02 07:28:16', NULL, '2026-05-02 07:06:36'),
(4, 1, 16, '', 'image', '/storage/chat_media/chat_1777705609_69f5a2897db31.png', 1, '2026-05-02 07:28:16', NULL, '2026-05-02 07:06:49'),
(5, 1, 16, 'oi ooio oi', 'text', NULL, 1, '2026-05-02 07:28:16', NULL, '2026-05-02 07:07:21'),
(6, 1, 1, 'gilaa bisa chat euy\\', 'text', NULL, 1, '2026-05-02 07:29:21', NULL, '2026-05-02 07:28:35'),
(7, 1, 16, 'anjay', 'text', NULL, 1, '2026-05-02 07:29:41', NULL, '2026-05-02 07:29:38'),
(8, 1, 16, 'tapi kok ini gk auto ya?', 'text', NULL, 1, '2026-05-02 07:29:52', NULL, '2026-05-02 07:29:51'),
(9, 1, 1, 'gtw tuh', 'text', NULL, 1, '2026-05-02 07:36:54', NULL, '2026-05-02 07:29:58'),
(10, 1, 16, 'oi oi oi', 'text', NULL, 1, '2026-05-02 07:36:17', NULL, '2026-05-02 07:35:55'),
(11, 1, 1, 'oi oi oi', 'text', NULL, 1, '2026-05-02 07:36:54', NULL, '2026-05-02 07:36:17'),
(12, 1, 1, 'oi', 'text', NULL, 1, '2026-05-02 07:36:54', NULL, '2026-05-02 07:36:32'),
(13, 1, 1, '', 'image', '/storage/chat_media/seller_1777707402_69f5a98ae3e30.jpg', 1, '2026-05-02 07:36:54', NULL, '2026-05-02 07:36:42'),
(14, 1, 16, 'makasih bg winda', 'text', NULL, 1, '2026-05-02 07:37:08', NULL, '2026-05-02 07:37:06'),
(15, 1, 16, 'sam sama', 'text', NULL, 1, '2026-05-02 07:37:16', NULL, '2026-05-02 07:37:14'),
(16, 1, 16, 'ce ce ce ce', 'text', NULL, 1, '2026-05-02 07:37:24', NULL, '2026-05-02 07:37:21'),
(17, 1, 16, 'anjayy', 'text', NULL, 1, '2026-05-02 07:37:36', NULL, '2026-05-02 07:37:35'),
(18, 1, 1, '', 'audio', '/storage/chat_media/seller_1777707487_69f5a9df47400.webm', 1, '2026-05-02 07:38:11', NULL, '2026-05-02 07:38:07'),
(19, 1, 16, '', 'audio', '/storage/chat_media/chat_1777707500_69f5a9ec8110c.webm', 1, '2026-05-02 07:38:24', NULL, '2026-05-02 07:38:20'),
(20, 1, 1, 'cek', 'text', NULL, 1, '2026-05-02 07:47:41', NULL, '2026-05-02 07:47:28'),
(21, 1, 1, 'cek', 'text', NULL, 1, '2026-05-02 07:47:41', NULL, '2026-05-02 07:47:31'),
(22, 1, 1, 'cek', 'text', NULL, 1, '2026-05-02 07:47:41', NULL, '2026-05-02 07:47:34'),
(23, 1, 16, 'mana', 'text', NULL, 1, '2026-05-02 07:48:04', NULL, '2026-05-02 07:48:01'),
(24, 1, 1, '', 'image', '/storage/chat_media/seller_1777708096_69f5ac4044912.png', 1, '2026-05-02 07:54:41', NULL, '2026-05-02 07:48:16'),
(25, 1, 1, 'cek', 'text', NULL, 1, '2026-05-02 07:54:41', NULL, '2026-05-02 07:49:27'),
(26, 1, 1, '', 'image', '/storage/chat_media/seller_1777708213_69f5acb51198c.png', 1, '2026-05-02 07:54:41', NULL, '2026-05-02 07:50:13'),
(27, 1, 1, 'ini bagiannya a', 'text', NULL, 1, '2026-05-02 07:54:41', NULL, '2026-05-02 07:50:13'),
(28, 1, 1, '', 'audio', '/storage/chat_media/seller_1777708228_69f5acc4df16e.webm', 1, '2026-05-02 07:54:41', NULL, '2026-05-02 07:50:28'),
(29, 1, 1, 'oi', 'text', NULL, 1, '2026-05-02 08:03:18', NULL, '2026-05-02 08:03:10');

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `name`) VALUES
(1, 'DKI JAKARTA'),
(2, 'JAWA BARAT'),
(3, 'BANTEN');

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id` int(11) NOT NULL,
  `toko_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `kode_barang` varchar(50) DEFAULT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `merk_barang` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar_utama` varchar(255) DEFAULT NULL,
  `harga` decimal(15,2) NOT NULL,
  `tipe_diskon` enum('NOMINAL','PERSEN') DEFAULT NULL,
  `nilai_diskon` decimal(15,2) DEFAULT NULL,
  `diskon_mulai` datetime DEFAULT NULL,
  `diskon_berakhir` datetime DEFAULT NULL,
  `satuan_unit` varchar(20) NOT NULL DEFAULT 'pcs',
  `min_order` int(11) NOT NULL DEFAULT 1,
  `stok` int(11) NOT NULL DEFAULT 0,
  `stok_di_pesan` int(11) NOT NULL DEFAULT 0,
  `berat_kg` decimal(10,2) NOT NULL DEFAULT 1.00,
  `panjang_cm` decimal(8,2) DEFAULT 0.00,
  `lebar_cm` decimal(8,2) DEFAULT 0.00,
  `tinggi_cm` decimal(8,2) DEFAULT 0.00,
  `status_moderasi` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `alasan_penolakan` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_barang`
--

INSERT INTO `tb_barang` (`id`, `toko_id`, `kategori_id`, `kode_barang`, `nama_barang`, `merk_barang`, `deskripsi`, `gambar_utama`, `harga`, `tipe_diskon`, `nilai_diskon`, `diskon_mulai`, `diskon_berakhir`, `satuan_unit`, `min_order`, `stok`, `stok_di_pesan`, `berat_kg`, `panjang_cm`, `lebar_cm`, `tinggi_cm`, `status_moderasi`, `alasan_penolakan`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'SMA-1-SBG', 'Genteng merah', 'gg', 'aku sih bagus ini cocok banget lah pokoknya bisa ini mah gaskennnn', '1772380837.png', 20000.00, 'PERSEN', 12.00, '2026-03-01 23:22:00', '2026-03-02 23:23:00', 'Pcs', 1, 99, 0, 0.60, 0.00, 0.00, 0.00, 'approved', NULL, 1, '2026-03-01 09:00:37', '2026-04-19 08:08:32', NULL),
(2, 48, 1, NULL, 'sapu mahal', 'Agung Galer', 'gacor kingggggggg sapuuuu lidi galerxxxxx', '1772596701.jpg', 120000.00, 'PERSEN', NULL, NULL, NULL, 'pcs', 1, 10, 0, 1.00, 0.00, 0.00, 0.00, 'approved', NULL, 1, '2026-03-03 20:58:21', '2026-03-04 04:03:21', NULL),
(3, 49, 3, NULL, 'my bini', 'My', 'my bini gacorrrr enakkkkkkkkk', '1772760243.jpg', 12000000.00, 'PERSEN', 10.00, '2026-03-06 08:45:00', '2026-03-07 08:45:00', 'pcs', 1, 1, 0, 45.00, 0.00, 0.00, 0.00, 'approved', NULL, 1, '2026-03-05 18:24:03', '2026-03-06 02:43:13', NULL),
(4, 49, 6, NULL, 'enakkk', 'Agung Galer', 'produk enakkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk', '1773202812.jpg', 120000.00, 'PERSEN', NULL, NULL, NULL, 'pcs', 1, 12, 0, 1.00, 0.00, 0.00, 0.00, 'approved', NULL, 1, '2026-03-10 21:20:12', '2026-03-10 21:22:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang_variasi`
--

CREATE TABLE `tb_barang_variasi` (
  `id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `nama_variasi` varchar(255) NOT NULL,
  `kode_sku` varchar(50) DEFAULT NULL,
  `harga_tambahan` decimal(15,2) DEFAULT 0.00,
  `stok` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_biaya_pengiriman`
--

CREATE TABLE `tb_biaya_pengiriman` (
  `id` int(11) NOT NULL,
  `zona_id` int(11) NOT NULL,
  `tipe_biaya` enum('per_km','flat') NOT NULL DEFAULT 'flat',
  `biaya` decimal(15,2) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_transaksi`
--

CREATE TABLE `tb_detail_transaksi` (
  `id` int(11) NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  `toko_id` int(11) NOT NULL,
  `barang_id` int(11) DEFAULT NULL,
  `nama_barang_saat_transaksi` varchar(255) NOT NULL,
  `harga_saat_transaksi` decimal(15,2) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `metode_pengiriman` varchar(50) NOT NULL DEFAULT 'DIKIRIM',
  `kurir_terpilih` varchar(100) DEFAULT NULL,
  `biaya_pengiriman_item` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status_pesanan_item` enum('diproses','siap_kirim','dikirim','sampai_tujuan','dibatalkan','pengajuan_pengembalian','pengembalian_disetujui','pengembalian_ditolak') NOT NULL DEFAULT 'diproses',
  `resi_pengiriman` varchar(100) DEFAULT NULL,
  `catatan_pembeli` text DEFAULT NULL,
  `catatan_penjual` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_detail_transaksi`
--

INSERT INTO `tb_detail_transaksi` (`id`, `transaksi_id`, `toko_id`, `barang_id`, `nama_barang_saat_transaksi`, `harga_saat_transaksi`, `jumlah`, `subtotal`, `metode_pengiriman`, `kurir_terpilih`, `biaya_pengiriman_item`, `status_pesanan_item`, `resi_pengiriman`, `catatan_pembeli`, `catatan_penjual`) VALUES
(1, 7, 49, 3, 'my bini', 12000000.00, 1, 12000000.00, 'DIKIRIM', NULL, 0.00, 'dikirim', NULL, NULL, NULL),
(2, 8, 49, 3, 'my bini', 12000000.00, 1, 12000000.00, 'DIKIRIM', NULL, 0.00, 'diproses', NULL, NULL, NULL),
(3, 9, 1, 1, 'Genteng merah', 20000.00, 1, 20000.00, 'DIKIRIM', NULL, 0.00, 'diproses', NULL, NULL, NULL),
(4, 10, 1, 1, 'Genteng merah', 20000.00, 1, 20000.00, 'DIKIRIM', NULL, 0.00, 'diproses', NULL, NULL, NULL),
(5, 11, 1, 1, 'Genteng merah', 20000.00, 1, 20000.00, 'DIKIRIM', NULL, 0.00, 'dikirim', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_flash_sale_events`
--

CREATE TABLE `tb_flash_sale_events` (
  `id` int(11) NOT NULL,
  `nama_event` varchar(255) NOT NULL,
  `banner_event` varchar(255) DEFAULT NULL,
  `tanggal_mulai` datetime NOT NULL,
  `tanggal_berakhir` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_flash_sale_produk`
--

CREATE TABLE `tb_flash_sale_produk` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `toko_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `harga_flash_sale` decimal(15,2) NOT NULL,
  `stok_flash_sale` int(11) NOT NULL,
  `status_moderasi` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_gambar_barang`
--

CREATE TABLE `tb_gambar_barang` (
  `id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `is_utama` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kategori`
--

CREATE TABLE `tb_kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `icon_class` varchar(100) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_kategori`
--

INSERT INTO `tb_kategori` (`id`, `nama_kategori`, `deskripsi`, `icon_class`, `parent_id`) VALUES
(1, 'Bahan Bangunan Dasar', 'Material utama untuk konstruksi', 'fas fa-warehouse', NULL),
(2, 'Semen', 'Berbagai jenis semen untuk konstruksi', 'fas fa-layer-group', 1),
(3, 'Semen Portland', 'Semen jenis umum', 'fas fa-industry', 2),
(4, 'Semen Putih', 'Semen untuk finishing dan dekorasi', 'fas fa-fill-drip', 2),
(5, 'Pasir', 'Pasir untuk campuran bangunan', 'fas fa-wind', 1),
(6, 'Batu', 'Berbagai jenis batu untuk konstruksi', 'fas fa-cubes', 1),
(7, 'Besi & Baja', 'Material besi dan baja untuk struktur', 'fas fa-bars', NULL),
(8, 'Besi Beton', 'Besi untuk tulangan beton', 'fas fa-grip-lines-vertical', 7),
(9, 'Baja Ringan', 'Baja untuk rangka atap', 'fas fa-bars', 7),
(10, 'Cat & Pelapis', 'Produk untuk finishing dan perlindungan permukaan', 'fas fa-paint-roller', NULL),
(11, 'Cat Tembok', 'Cat untuk dinding interior dan eksterior', 'fas fa-paint-roller', 10),
(12, 'Cat Kayu & Besi', 'Cat untuk permukaan kayu dan besi', 'fas fa-paint-roller', 10),
(13, 'Keramik & Granit', 'Material penutup lantai dan dinding', 'fas fa-th-large', NULL),
(14, 'Keramik Lantai', 'Keramik untuk lantai', 'fas fa-th-large', 13),
(15, 'Keramik Dinding', 'Keramik untuk dinding', 'fas fa-th-large', 13),
(16, 'Granit', 'Material granit untuk lantai dan dinding', 'fas fa-th-large', 13),
(17, 'Pipa & Perlengkapan Air', 'Sistem perpipaan dan sanitasi', 'fas fa-faucet', NULL),
(18, 'Pipa PVC', 'Pipa plastik PVC', 'fas fa-faucet', 17),
(19, 'Pipa Besi', 'Pipa dari bahan besi', 'fas fa-faucet', 17),
(20, 'Perlengkapan Sanitasi', 'Kloset, wastafel, shower', 'fas fa-bath', 17),
(21, 'Kelistrikan', 'Peralatan dan material instalasi listrik', 'fas fa-bolt', NULL),
(22, 'Kabel Listrik', 'Berbagai tipe kabel NYA, NYM, NYY', 'fas fa-bolt', 21),
(23, 'Saklar & Stop Kontak', 'Alat pemutus dan penyambung arus', 'fas fa-toggle-on', 21),
(24, 'Lampu & Penerangan', 'Bohlam LED, Lampu Panel, Downlight', 'fas fa-lightbulb', 21),
(25, 'Panel & Box MCB', 'Kotak pengaman arus listrik', 'fas fa-box', 21),
(26, 'Kaca & Jendela', 'Berbagai jenis kaca bangunan dan komponen jendela', 'fas fa-window-maximize', NULL),
(27, 'Kaca Polos & Riben', 'Kaca bening dan kaca gelap berbagai ketebalan', 'fas fa-border-none', 22),
(28, 'Kaca Tempered', 'Kaca keamanan dengan kekuatan tinggi', 'fas fa-shield-halved', 22),
(29, 'Kusen Aluminium', 'Frame jendela berbahan aluminium berkualitas', 'fas fa-border-all', 22),
(30, 'Aksesori Jendela', 'Engsel, kunci, dan grendel jendela', 'fas fa-key', 22);

-- --------------------------------------------------------

--
-- Table structure for table `tb_keranjang`
--

CREATE TABLE `tb_keranjang` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_keranjang`
--

INSERT INTO `tb_keranjang` (`id`, `user_id`, `barang_id`, `jumlah`, `created_at`) VALUES
(8, 15, 1, 1, '2026-04-10 03:59:54'),
(9, 5, 1, 1, '2026-04-19 10:43:08'),
(10, 1, 1, 1, '2026-04-19 11:22:49'),
(11, 16, 2, 1, '2026-05-01 17:10:37'),
(12, 16, 1, 1, '2026-05-02 06:29:10');

-- --------------------------------------------------------

--
-- Table structure for table `tb_komisi`
--

CREATE TABLE `tb_komisi` (
  `id` int(11) NOT NULL,
  `detail_transaksi_id` int(11) NOT NULL,
  `jumlah_penjualan` decimal(15,2) NOT NULL,
  `persentase_komisi` decimal(5,2) NOT NULL,
  `jumlah_komisi` decimal(15,2) NOT NULL,
  `status` enum('unpaid','paid') NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_komplain`
--

CREATE TABLE `tb_komplain` (
  `id` int(11) NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Pembeli yang komplain',
  `toko_id` int(11) NOT NULL COMMENT 'Toko yang dikomplain',
  `jenis_komplain` enum('barang_rusak','barang_kurang','tidak_sesuai','lainnya') NOT NULL,
  `alasan_komplain` text NOT NULL,
  `bukti_foto_1` varchar(255) DEFAULT NULL,
  `bukti_foto_2` varchar(255) DEFAULT NULL,
  `bukti_video` varchar(255) DEFAULT NULL,
  `status_komplain` enum('investigasi','menunggu_tanggapan_toko','refund_pembeli','teruskan_dana_toko','selesai') NOT NULL DEFAULT 'investigasi',
  `keputusan_admin` text DEFAULT NULL COMMENT 'Catatan admin saat mengambil keputusan',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kurir_toko`
--

CREATE TABLE `tb_kurir_toko` (
  `id` int(11) NOT NULL,
  `toko_id` int(11) NOT NULL,
  `nama_kurir` varchar(100) NOT NULL,
  `estimasi_waktu` varchar(50) DEFAULT NULL,
  `biaya` decimal(15,2) NOT NULL,
  `tipe_kurir` enum('TOKO','PIHAK_KETIGA') NOT NULL DEFAULT 'PIHAK_KETIGA',
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_mutasi_saldo`
--

CREATE TABLE `tb_mutasi_saldo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `toko_id` int(11) NOT NULL,
  `transaksi_id` int(11) DEFAULT NULL,
  `payout_id` int(11) DEFAULT NULL,
  `jenis_mutasi` enum('KREDIT','DEBIT') NOT NULL COMMENT 'KREDIT = Uang Masuk, DEBIT = Uang Keluar',
  `nominal` decimal(15,2) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `saldo_akhir` decimal(15,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_payouts`
--

CREATE TABLE `tb_payouts` (
  `id` int(11) NOT NULL,
  `toko_id` int(11) NOT NULL,
  `jumlah_payout` decimal(15,2) NOT NULL,
  `status` enum('pending','completed','rejected') NOT NULL DEFAULT 'pending',
  `tanggal_request` datetime NOT NULL DEFAULT current_timestamp(),
  `tanggal_proses` datetime DEFAULT NULL,
  `catatan_admin` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengaturan`
--

CREATE TABLE `tb_pengaturan` (
  `setting_nama` varchar(50) NOT NULL,
  `setting_nilai` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pengaturan`
--

INSERT INTO `tb_pengaturan` (`setting_nama`, `setting_nilai`) VALUES
('aktifkan_fitur_live_chat', '1'),
('alamat_pusat', 'Jl. Jenderal Sudirman Kav. 52-53, Jakarta Selatan, DKI Jakarta 12190'),
('api_active_couriers', '[\"indah\",\"wahana\",\"sentral\",\"rex\",\"jne\",\"jnt\",\"sicepat\",\"pos\",\"tiki\",\"ninja\",\"anteraja\",\"lion\",\"sap\",\"ide\"]'),
('app_name', 'Pondasikita'),
('auto_approve_products', '0'),
('auto_approve_stores', '0'),
('bank_rekening_platform', 'BCA'),
('commission_official_percent', '4.0'),
('commission_power_percent', '2.0'),
('commission_regular_percent', '0.5'),
('customer_service_fee', '1000'),
('deskripsi_website', 'Platform Jual Beli Bahan Bangunan Terlengkap se-Indonesia'),
('dp_percent', '50'),
('durasi_preorder_maks_hari', '30'),
('email_kontak', 'kontak@pondasikita.com'),
('enable_custom_fleet', '1'),
('enable_dp_system', '0'),
('enable_emergency_delivery', '1'),
('enable_store_pickup', '1'),
('enable_welcome_popup', '1'),
('fee_qris_percent', '1.5'),
('fee_va_flat', '5000'),
('free_shipping_threshold', '0'),
('google_maps_api_key', ''),
('hero_image', 'C:\\Users\\2qist\\AppData\\Local\\Temp\\php23D3.tmp'),
('hero_image_1', 'banners/1777652948_hero_image_1.png'),
('hero_subtitle', 'Temukan ribuan supplier material terpercaya.'),
('hero_subtitle_1', NULL),
('hero_subtitle_2', NULL),
('hero_subtitle_3', NULL),
('hero_subtitle_4', NULL),
('hero_title', 'Pusat Belanja Material Seluruh Indonesia'),
('hero_title_1', NULL),
('hero_title_2', NULL),
('hero_title_3', NULL),
('hero_title_4', NULL),
('link_facebook', 'https://facebook.com/pondasikita'),
('link_instagram', 'https://instagram.com/pondasikita'),
('link_kebijakan_privasi', '/halaman/kebijakan-privasi'),
('link_syarat_ketentuan', '/halaman/syarat-ketentuan'),
('link_youtube', 'https://youtube.com/pondasikita'),
('maintenance_mode', '0'),
('maks_berat_pesanan_kg', '50'),
('maks_foto_produk', '8'),
('max_custom_fleet_distance', '50'),
('midtrans_client_key', 'SB-Mid-client-ejWh_qCa9cClgKRm'),
('midtrans_is_production', '0'),
('midtrans_server_key', 'SB-Mid-server-KfGZdmNmRhhouinEJzESiAjl'),
('min_heavy_cargo_weight', '0'),
('min_nominal_dp', '10000000'),
('nama_rekening_platform', 'PT Pondasi Kita Indonesia'),
('nama_website', 'Pondasikita'),
('nomor_rekening_platform', '8881234567'),
('persentase_komisi', '5'),
('popup_frequency', 'always'),
('popup_image', 'banners/1777652948_popup_image.jpg'),
('popup_link', NULL),
('prefix_invoice', 'PNDSK'),
('rajaongkir_active_couriers', '[]'),
('rajaongkir_api_key', 'QMV142AXaddf48150aef9f08mFVSy161'),
('rajaongkir_last_sync', NULL),
('seller_fixed_fee', '0'),
('seo_description', NULL),
('show_best_selling', '1'),
('show_top_stores', '1'),
('social_facebook', NULL),
('social_instagram', NULL),
('support_email', 'super@pondasikita.com'),
('telepon_kontak', '081234567890');

-- --------------------------------------------------------

--
-- Table structure for table `tb_review_produk`
--

CREATE TABLE `tb_review_produk` (
  `id` int(11) NOT NULL,
  `detail_transaksi_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `ulasan` text DEFAULT NULL,
  `gambar_ulasan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_stok_histori`
--

CREATE TABLE `tb_stok_histori` (
  `id` bigint(20) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `variasi_id` int(11) DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `tipe_pergerakan` enum('initial','sale','sale_return','adjustment','stock_in') NOT NULL,
  `referensi` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_toko`
--

CREATE TABLE `tb_toko` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_toko` varchar(100) NOT NULL,
  `slogan` varchar(255) DEFAULT NULL,
  `slug` varchar(120) NOT NULL,
  `deskripsi_toko` text DEFAULT NULL,
  `catatan_toko` text DEFAULT NULL,
  `kebijakan_retur` text DEFAULT NULL,
  `logistics_preferences` text DEFAULT NULL,
  `active_api_couriers` text DEFAULT NULL,
  `dekorasi_desktop` longtext DEFAULT NULL,
  `logo_toko` varchar(255) DEFAULT NULL,
  `banner_toko` varchar(255) DEFAULT NULL,
  `alamat_toko` text NOT NULL,
  `province_id` int(10) UNSIGNED DEFAULT NULL,
  `city_id` int(10) UNSIGNED DEFAULT NULL,
  `district_id` int(10) UNSIGNED DEFAULT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `telepon_toko` varchar(20) NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `status` enum('pending','active','suspended') NOT NULL DEFAULT 'pending',
  `status_operasional` enum('Buka','Tutup') NOT NULL DEFAULT 'Buka',
  `saldo_aktif` decimal(15,2) NOT NULL DEFAULT 0.00,
  `rekening_bank` varchar(50) DEFAULT NULL,
  `nomor_rekening` varchar(50) DEFAULT NULL,
  `atas_nama_rekening` varchar(100) DEFAULT NULL,
  `tier_toko` enum('regular','power_merchant','official_store') NOT NULL DEFAULT 'regular',
  `dokumen_nib` varchar(255) DEFAULT NULL,
  `dokumen_npwp` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_toko`
--

INSERT INTO `tb_toko` (`id`, `user_id`, `nama_toko`, `slogan`, `slug`, `deskripsi_toko`, `catatan_toko`, `kebijakan_retur`, `logistics_preferences`, `active_api_couriers`, `dekorasi_desktop`, `logo_toko`, `banner_toko`, `alamat_toko`, `province_id`, `city_id`, `district_id`, `kode_pos`, `telepon_toko`, `latitude`, `longitude`, `status`, `status_operasional`, `saldo_aktif`, `rekening_bank`, `nomor_rekening`, `atas_nama_rekening`, `tier_toko`, `dokumen_nib`, `dokumen_npwp`, `created_at`, `updated_at`) VALUES
(1, 1, 'QISAStoree666', 'yang bener aja', 'qisastoree666', 'asduhhhhhhhhhhhhhhhhhhhhhhh', NULL, NULL, NULL, NULL, '{\"template\":\"Kanvas Desktop Kosong\",\"header\":\"bg-slate-800\",\"layout\":[{\"uid\":\"mnscifny175vdml5x0k\",\"type\":\"banner\",\"config\":{\"title\":\"Promo Spesial\",\"textColor\":\"#ffffff\",\"images\":[\"data:image\\/png;base64,\\/9j\\/4AAQSkZJRgABAQAAAQABAAD\\/2wCEAAkGBxMTEhUSEhMTFhUVFxoVGBYWGBcZHhcdGBcYFxcXFxUbKCggGBomHRgYITEhJykrLi4uGB8zODMtNygtLisBCgoKDg0OGxAQGyslICUtLTAvNS0tMi0tLS0wLS0tLS0tLS0xLS0tLS0vLS0tLS0tLS0tLS0tLS0tLS0tLS0tLf\\/AABEIALIBGwMBEQACEQEDEQH\\/xAAbAAEAAgMBAQAAAAAAAAAAAAAABAUCAwYBB\\/\\/EAEQQAAIBAgMEBwUFBwMDBAMAAAECAwARBBIhBTFBUQYTImFxgZEUMkJSsSMzgqHwB2JyksHR4SRzohXC8RZjstJDU5P\\/xAAaAQEAAwEBAQAAAAAAAAAAAAAAAQMEAgUG\\/8QAOhEAAgECBAIJAwMCBgIDAAAAAAECAxEEEiExQVEFEyJhcYGRofCxwdEUMuFCUhUjM2Jy8ZLSgqKy\\/9oADAMBAAIRAxEAPwD7jQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUBSbR+8by+goC7oBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKApNo\\/eN5fQUBd0AoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAUm0fvG8voKAu6AUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgKTaP3jeX0FAXdAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQFJtH7xvL6CgLugFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgNGLxQjFyL+FAaBtNCpKnW2inTXgKmwOYxHSPGIShijYFNHW5yte2q31FrHhW79Ph6sX1c8r7\\/Dy495UpSj+5X8DF+kuNBVupQx2uxtY6EDLa97nXXLbUcqrq4OG0Kquua381oiIynfXbw\\/k8XptJ1iJ1KsXDnKua4Cj3iddLkDdXdTo2rGDmpx0tvdavv1+hCqNyNrdOclusgILMEVQ2pZt17gab\\/wAq4XR9dwusrdr6P72HWyvqiQnTZAjvJE6hBfQg6XA7tbkVzHBYl7xV+V9SXVtw9GTMJ0qicDsSBjuUhb2te5N7CqY0K7TbptW8PbU6z9wj6YYQoJM5Aa9tLnQ2OgvxrPOqqbyzTT71+C2MKsleMJPwTf0Jn\\/X8PlDGQAHdcNr+Vc\\/qaVr3KOvgt3YsY3DAEbiLjzq5NNXRandXRlUkigFAKAUBSbR+8by+goC7oBQCgFAKAUAoBQCgFAKAUAoBQCgFAKA5Lp3tBwYMPGSvWFpJGDZbRxWJBYaqGJGtuBHGs2Jm0lFcTZhKad5NXt9WcHB0jxjOR102VQZGAa1uS3O8d1\\/7VkVaf9xveHpr+lGY6V4uQtnlYrGtyerjGp3BtAbaHdrXSxFXmcywlHl7szwvS6e7fdZUtrkaxJ5sDYflvrtYqp3FbwVLbUzh6XSF2YxxnLoRdgSTuCncPzrv9XLkcPAQ2zM2y9Ms5I6gAL732lyfAWH6NdLGf7Th4D\\/d7ErBdMIGkSIRyAsQgJy7yCbCxJO4k8rXq2GJU5ZUmU1cJKnFybRaRYZXbM6q1jcXANjzF9xrXGpKP7W0ZLI479oG2isyYNAOrjVWlUW7RJzBL8LAA\\/jFet0ZFvNVe+yKqnBIsDtIjCT4m1iy5EA+aTsi3lc+VaMRFRkoevkc0U5PQqNrKYoerT31VYV73Jyg\\/wD9Xe\\/hXyFap1lRzfF38j65S\\/TYWU+S9zpcbGsKxQr7sMYFhyQAD\\/try68rvU+EazzUX5llhukEjIXVZAFOXVltuv8ANy7qiMZyV1V\\/+\\/8AJ9J12E\\/uX\\/jL8G3CdIcQ4JRHNgSb20tv3nwq6k6t9Ku2r7SeiOHVwje+ngzsdnTF4o3YWLKrEcri9etSnngpc0ZZWu8uxIqwgUAoCk2j943l9BQF3QCgFAKAUAoBQCgFAKA8LAb6i4MTKvMetSDE4hPmFAYNjox8QoDU21Yh8VAan25CPioCNN0ngUXvu76DfY4HpBtMuHnfRsQAVB3pAh+zXuLm7HxIryas87cuf0Pcw9JQWXlv4\\/wVDr1UXa99+245fKn65d9VsvWrueyp1UQB99u2\\/ifdX6egqCVq7iaIRRBT7x7bd5O5f13UC1dzCXDiKHKQLntuPoPUfkDUkLV3NLYQRxWYat227vPnw\\/D31NyLJkroVs8NM7kX6oAknXtyA5VvzWMkn\\/dFehhIaZ2eXjqizKC8zv0yxozubKil2PIKLk\\/rlWwwHw98U2IleZvemctbkCbqv4RkXyr6jBUskIx8zLUe532PjCex4a1witi5BzEY+zHmwt+KvK6Qr2hUnz7K+5u6PpZpr1IuDh63HYeIm4jzYiQ8D1YyqfOR834a+YlpF+h6vTdXLQjS56vwRYbUkzda\\/M5fqf14V4+Il7s+Uw\\/aqZjTsfCuiNKpJRyd5vZtF3cuXieVQneCuj3p1c9GMJr9umnLn4lpsPEMYcUdezC5HO9uendV9Cmss3\\/tZzChBTp21TaXufQtkfcQ\\/wC2nf8ACONe9QSVOKXJfQpqK034kurTgUAoCk2j943l9BQF3QCgFAKAUAoBQCgFAKA5LbmILSkcFNh3fo3r4rpKvKpipa\\/tdl3eHfc9fDU1Gmu8rsS8txlcgEX\\/AL19RgMQ69CMpb7PxR51enkqNLYhvn4yGtlyqxpdrf8A5CajMTY0ySDix9aXIsRpZ04n86XFiNFaaaOBULB2u+tgEXtPdtbXAt51RWldKPP6GnDRs3Plt48CNJtAYjFZmVyovKyqB2FT3F1I0Atuve3GsNru56ieSFkIcWks5Z27KDrDlBIv8KlgLKBwvbcK5ytnbkoxsjbh5FknJdl+zGcrcAsTuCrvsPy0qEr6kyeVZUbIEMspdvcj7bW58APDh35aLcmTsrI8ROtl10VO23IfKPIAm37tuNFqG8qsQds4tRnkf3I16xh3DRIx3scqjxrqEXOSijic1Tg5Pgdb0M2e0WEj6z72UmeX+OQ3t4AZV\\/DXsxSirI8CUnJ3ZG\\/ahtHqsD1IPbxTiL8C9qU+gy\\/jrVhKeeqkcSdkcN0SwBlxMaW4g\\/r1HpX00pKnSlPyMj1aR1EuIEk+JnHumRYI\\/wCCAAlh3F+pB86+T6SnZQp+b8WfR9FUb6\\/Pm5j0S3Y3FncWXDIe6IFnt+N2H4a8Wu7Rt81\\/g8vpvEZ68rbLT8mzGRHqx4XPi2teVUg278DHhqElS6x7My2LBljZizL2iQFBsSQdC17VKacbXRuqV4zhZMtsAFEMqkFTIjJuHHQ6+FWUbxU0t2rI5w+fOpR1a1PoWzlAijA3BFAvyyi1fRQVopdxEm222SK7IFAKApNo\\/eN5fQUBd0AoBQCgFAKAUAoBQGLOBvIqG0txY4zbkWZ3sxHaDBl8QfAjhXxmKgo4qb31fvqexSf+XEqNs4ixUDkT6m39K9boyeShbvZmrq8yokxJ516HXFOUjPiP3qjrhlIs2LUb2\\/OnWsjKiunxsfzC5031PWSIyo6LDxDDYQudJcULDmsIOp\\/GdO8Cq5Sus3F\\/T+TfSp2ajy3\\/AOX8GhB1OHLNo83bb92Me6vn\\/wDYVVsjSu1LwPcnUYc5tHm+0fuUe6vrp5HnUbILtSvyPFwywYezKA0p6x7aWAPZHcbi3dY86nZBWlLuQjwSxQZmBEspzljqygcLnyFu5xTgFrK\\/I9w2GKQFy7Z5TcXJtlFjqm61svfqdezTgRvLwKePBnET4fDuSeul9odRoohhzAZhv7bXA\\/h7xWrCQ1cjFjp7QPrMS3OnH\\/wP13V6B5p8n\\/aPtIT7RaMH7PCoIR\\/E1nlPiAFXyr2OjKdk5lVR8Cd0PbqIMTjG06uM5T+83ZX\\/AJNfyrfjtoUue\\/1ZVSV5XMsa\\/suFGbfFFmYfvsOtkAPEEui+MdfHYmp11Zy5s+wwqVCg5vgvnv8AUtMFgzBgsJhm99lEkn8UhMj39Wry8TO8tPnI+HxU3OXezbOA1hzYD1tWacdFHwPcqwyUlDkTOp9kitI79W0nZbKp13AE3Bvv\\/wA1bKg6Erva\\/k\\/ve3kYXHKZSYoSAMOR8\\/SojU6ycpWNODd5Nn0XBj7NP4V+gr31sVm6pAoBQFJtH7xvL6CgLugPCwG+obsDWcSg+JfUVw61NbyR1llyNLbRjHxX8KreKpLidKlLkYHaY4Kx9KreMjwTJ6p8zU20zwUDxNVvGy\\/tOlRXM0vtJ+YHgP71VLGztwO1Ria2xrn4jXEsTUlxJVOK4GAlPNj4kmq+sbe782dZUYlt9cqe7JsQsXGW3VhxNPO80dy6EraM43a3R\\/FSMznFRIPl6trgeZ1q6li6dOKhkfn\\/ANHEqcpO9yqHRy5s2NkY8kQD6g1asZJ\\/tp\\/VkdQ+LNydFIfibFv4tl+lqtjPFS2h7fk5caa3l7nkvRfDoL+zu38c5\\/7jarVTxj3svQ4vR8SPg9l4Y4iKFMNCWdrt1NpHVE7Tm97KbC3PXS5FdqjVUkpzvfkyym4azS258+BNxu1YsVixnYLF71tbLHHYKluHC97ceJqXeUrmqP8Alwst\\/uZI4xGJ7ZAVB1rC+5V91QONredu+uN3csfYjZbmUf8AqMQS2iJ9o\\/EAKOwnfYC\\/fl76JXdyX2I2QH+oxGuiDttfUKqjsKeegueYU0WrD7EbGUxOJnCD3TYkHggNlUnv0ufE1FszF8kTXtfEK72zZYwCWb5Y0BZ3I5kXPiam2Z2RF1TjmkY\\/s8QzPPjmWxlYRRL8iJYBR4AKv4TXq04qKsjxKk3J3Z3eIx64eCbEv7sMbP4kDsgd5\\/rViV3Y4PhOBzMpkfV5SZHPNpCXY+mnnX1ODpWjFefoZpvc+gPhguHweFOgmkM8v+3CCxv3HtjyFef0jX1qT5Ky8X\\/BqwNPNJFbtuI4mfDYU78RODIN9lQmaYeRuK+U2u+X1Z73SlRUsKoL+r6L4jq8XJ1uIlewKxqTbhb3Ru8P+VYorrKvzZHx1JdZXXr6EKXpJEDl6iJSDe+Ut+RNeh+jUoqSSPSq17txb9S2w22lmWzCBg3DLv8AJh9L1bFJpwqr0\\/D\\/ACcqM5aqUfO+vmvwSVygWVUTuEaW\\/IaVfSo4dOyin7P0f5K59dFXV4+Sa9V90dHh8S4t2gRy0P8AQGrJWX9LFNSltNfPQmxY4fFby\\/zVV1wNChNbkhJlO4ipIsbKApNo\\/eN5fQUA6S4gqEysQSTuvrpbcN+8VixkrJJMvoRvcpP+oHXMOPIg28Na85tPc0qPI2DaCk7iPA3+lG8wytG9JlN7Nu5mubEam1f1apWm5AY+NG\\/EI04jFLGMzZiLgdlS+\\/jZbm3fwpCF5W08\\/wAkt6GwzqdQQR3G\\/wBK1Swv90kipVOSZi+NRfea3j2f\\/lanVUlvP0QzTe0SIu0OsbLFIxv8iow83swHnUxVLZKTIlnW9kThhJCvAnxW58bZRVqpUb3lH7lTqztoyFi8BIqMzmNQOLEqANNb3YHjp\\/etMIUm0oL0Sb+xROrUim5P1bS+5zZkeS3UhmB0LaBQddDI4tw36eVX1KOR2c3fkkm\\/bYrp4hzV1BW5ttLy5mGI2c40ac5tRZA1tNNW0uPK3fVMMJVn+5l8sbShtEiL0aMvuyXNviW2\\/dreksFl3fsTDpDNtH3\\/AILPY3RuTDR4h8yNPMojVl+BPjtxzH8tKp6t66mlYiGmj5u3t6FT7F7JFL1mQTTHKQCCVjA425j8m7qz2cUzdGcaklYiwbPjiwpdlHWYghgTqURdVKk6r3W5nlUXsjuylPwGGwPVYYys79bOcwJY2CLqMyCysLW4fEdxWnAbz8DPARSx4ZpWftTt93YAFRY+9YsNApve3bGm+mlhq5+Bs2VJKmHknZVAlbKAL5wuouDuOgYW0sH3m4olZESbc0uRzXSHGOcPZFt7TIIxckMyR2JVUtopkaME34Wtvtfho6uRmxk9FE+mbA2cIII4R8CgE82OrH1zGt62POKH9r+Oy4bDYFfexMnWSd0cdjb1yn8BrVhKeeocSZyWysIZJY4wN5Bt4kH6BfWvqI2hCUuWhklqdji3DYrENoUhVMGnEHKOsnHmEIv\\/AO5XyfSNTsRi+Paf29j6Doqjd3+fLlf0WOfH4rEm5GEgESn\\/ANyc3JB52Fj414tWWWn7\\/gp6dr3q5VtFW8\\/n0JqY1lR1RVcyqS8YYCXJcZXjUjtDs6jfWWg3FtrwPI6Op3zTfgc1JHnJaJg5+Q9l17sh97yNepRxMGoxnpa3evXgaalKSblHUQ41gvV8BvBFiNb\\/AFrmUs0nIthC0UiSNsyovYcjdv1G8bgd1cyk7GvCU11qvyf0Z3nR6Z5sOkjPIGa98vcxA335VdCUsq1ZxXdONRpQj6FvHg773mPiw\\/sKnL4+px18lsoryRJGCT5WPix\\/vU5UR+oqc16Il7OQK4C3A10zMRuv7u6ukrHE6kp\\/uNe0fvG8voK6KyP0yQZUYnKASLk2XtW0PM6aaVgxydk0jThnq0UGU2018Ld3BdAPGvOuajEDmNO7d66C\\/drTQamY13nj5eV7fSpT7yAsrczx47\\/X+gpd8ULI2rjJBxG7cRYbt9958hUq3gRY5\\/F9Ipr6Nu00VRfzNzXXVk6FVjNrzEkM0mh3Fjp5aCu8liE+R0+x+jClA880QLdrqwy6afFwJ3Xt316FGjCOsotv2\\/kwVq85dmMkl7\\/wX7Rug0xcKpoFGawXgANSO61q1Z6b\\/ofoYnGov616kAzSF2RsXHGqXUnOLswJuFvbduJsbG44VMbVP9Km35aexEm4f6tRR89fcnYaXCe608btqNXOubkGNmP60qupha2bNkfp+NjuGKo2y54+vy5U4+WORwI2PEDMc2bXhc3G61uN63UqcoR7SXkrW9vcxVKkZy7L9Xe\\/v7EzZoYPkAL2942Fr+JF+Glv81xVyuN9i2i5KWXV89jZ0n21DhkZTaSYKGERIsAWAu1uV727q8\\/O81lp3nouCy3epwg6T46ZiyZgFVmsg0tYi9txAudeYFRJRSs3qdxcpPRaFZsjZrz4gCVyRYvIWN7KNTc9\\/HuueFUznGXZitDbRpSpf5knrskXE3+rxIQaJvN9Msabgbbr7z4sap\\/czX\\/pw+bnuLPteIWNQcp0tutGp48ixPq5o+09CV\\/lw1Mtpt18ywx+77i2HwDVmA5sb2H7wFH2noI9iN3v8+hu202Z0w8VtLRrbdmPvNf5Ra1+SCktXZEQ0WaXictsALjdpB11w+GFou9YyQjEc3kLyenKvRpQypI8mrUc5OTPrGBgzMq8zr9T+Q\\/5VcVHyDpXtL2zauIlB+zhthYz3KSCfAnrD4MK9no6nZZn4lFR8C76E2V5cUw7MKNIL8wOwvrlFejjezRVPjLT13KoLNM3wN1WGVnJuUaeQnnJaVr94RYv5jXxuOqdZXk1tsj7Ho+CpU80uCv89zzoxE0ey0ci0uOmkxJ8CckY8DofOvNxcrafND43H1nOTk+LbKHaW3ImneGZOxG2SOaPSSLLZSb\\/ABLcE27+OlKdO0EasMurpJPx9SdjcDLZGxK9ZG9gmMi3i+7rQP6+pNLrga9TbNs6dMvWquIhOglS5K+J95fO476KdleOhOV3MsX0eLLfDvm3HI9lbffRvdb8qmOIUtHoaaDUJ3ltZ+6O26KxMmFiRwVYA3Ukgg5jw4Vvp\\/tRlru9WTXMvI2Hd63qwpNwt3fyk1JBIwH3g8+FuFSga9o\\/eN5fQVJBL2\\/AHw8gPyk892um\\/heqMTG9JllJ2mj5xFhlOsbIT3EoR5L\\/AFWvFuekZmSdDvJt8yh\\/Vlsw9Km5FkzbFtTeMl7\\/ACNcix+VrPRMOBsXHRajNlPJwUPobD1NLHNmbZJAqlhrpoAbA6aC+n5XqULXOIxMc1yMqrrx07t7GxNXKURl5kWHAtI6oZwC7BdCdLkC\\/ZFtK6TvsiHZa3O2bowzORHi8ORYDtrIGOlj7rADUnhXq06yUVmv5JW9zx6lK8nlS82xF0fe+UYnCFVGUCNzmFiNO2WG4W3c+dWuot9f\\/H8MqyN6JLyl\\/Bax4fEwJljj60MzyMVaI2MjlyLEg21rEp5G0m7afQ2Zc6TaVyhh6fxGRonRgyEqwMQNiCQRcDXUVbnmtbv1OMkXwRbL0lwbr23Uc88QHl7oqViJx4v1ZxLDxnul6JmEe38NHFK+Gmj61UYqqSXUmxt9kxOtKuJnU7L9ePqTSwsafaXprb0ODlwZMnX4qUqGJNtS8m64ty3a9\\/Cq4vMrQV7fNy2Tyu83b5yImNwHWzCWJWjBAGupBBI947iRaq7RjdaPwL1Uk0mrrxNy4wxFhE73cDOTcKwF7DKfS+h1PA2J0sqbZbTxOeaW9jdsjakiYeWQ9X9s1siglwg0uHuBbQi1tz79SKqy6aGlzvJN7In7F2iY8NJiGjZFmYxrKxGi2I1XeoIDi+u\\/W3Zuy2XedOWaavsiX0bx8YSScE52Jji7LAG3FXIs1rMxsd6r31yllVyZSU5KK2KDpFtYRQSZHHXTE4aMAi6KwHXyEbx2SEB\\/fPKrcNC7zcinGVLRUFxOg\\/ZpssR4bPaxlNx3IvZX6E+db4nms6jpBtf2PA4nFDRlTq4\\/9ySyr6EjyU13FZmkcs+L7EgyQDmwLHxfQf8AAFvOvp8JT0S5v2RmmzuMPhrYKKDc2MnCn\\/bj7Tn8wfw1n6Tr5Zyl\\/avd6IvwVPNNEHpziWaLqo\\/fxMixIP8AcIsLdyBENfHQ\\/dfzPp8dPqcG1xlp+fv6nSbftE4hjAK4WFYoxzMahVXxLsB5Vgrdqpl8vyfD1V1lVQ8ij2H0ZGMgKY5ZIMYugktY5fhZ00DrvFx+RvV06ijLs7HuKnmWu50GzYZ8EoilsyWtmGquLcuOnDf5VRJ2d0XxjdWJ0eHH3mFYITqYyeyf4Tw8PpS6FuDNMKwzm6\\/ZScbe6T4cP1rUWTJs495NSSaHRxdee8f4qYzqUnoQ4xmWWEx6sQozXOvC3rW+hi1UkotalFSi4q5Pv4+v9q2lBI2YftPI8SeVSga9o\\/eN5fQVJBu6Q4jLEQDYscvlx14aVjxs8tO19y\\/DxvPwOFmwBPx37pFzejCzV4+Y9FNcj1omW2pFhuU5x\\/K2v50crbhJMyYFh2gj+Oh487j0qVJEWsanwyWsQ6C+7Ur\\/ACnMD+VdXI1EWzfkK7t6Eof+F19RU5gznttxlHAy+8M12ZWubkm5Xxq6GqOJaGHRrZE2Kka2QCOzFSGF77luNwuN9wbbjWinGDl2tiirOaj2dzssXBKpv7MLjjHKwvu+Ekgcd54DnWpQpPaRjc6nGJQbU6N6NJldNbnrDGw1sfgYHfpu4VesROKsp+xQ8PBu7h7mnovszGhPaMMuGuxeIK0zAkLIVLZSNASl997Gq6leVZZJuy32LIUIUXngrvxGH6CYvrJpp4gzSszWjYWGYG9mOY7+7Tvq6DgkrSXuUzzu\\/ZfsXWC2DOjBlhdWPAWst2uO1ZLaHu413Kokv6X85M4UG3\\/UvH8pk3amAn6l2lS5BDZ3ZLIqKbtm1y3vuF91Y8Q4zy5FzvobKEZQzZ37nC47HoXQuyBVuAWNrsRewZu5T41T1ckrPiW9ZFvTgU+K252h1XbKniCFHMAbzr4edWOOlkiIvW8n6EDGzSFVDAjNvNiAOJ15+NQ9WaKaUVoboQzlIk0aUhR+6o7vC58Sa5aLYnV7UxQkMeGgtlS0KcidA7k8QALX5KDxqmW9jRTVlmZK6RhESPBILiIC44mQ7hpuYX4fEz0m7aIU45ryfH6fPaxxW2YRLi48FDYrh\\/sSw1zTSEde9+IW2XwjvxrdThljbiebWqZ5trbgfYMJh1jRVUdlVCgdyjd9B51eUbnBftlx5ZsJs5Drfr5P4nJRL+F5CR4VrwkLyzcjibKGJMxRVGhNwO73EHkFPrX1OHio37lb8mWbOxxNvaWT4cLAsA\\/jl1lI\\/eVTJ\\/LXyfSla8f+Tb8loj3eiaDbuVuyLYjbEOa3V4OKTFuOF7dkeRMZFeOnaDk\\/li3p2slUjTW0V8+3qR+lGLcqpHvTYhCWtcAIwkLEcs5W\\/hWGgk5tvgn7nzWDi5Vc3L6s7\\/AYtz2Jk90XDD3eV0Y6qd3ZPlffXEktz6BXLFpFC2azId6t\\/bge8VypNaMm19iiMeScLCzBT2spsb77gczpw18a5b5HduZr2pgY4\\/tY8yEWuN6m5tx3an\\/xXWa6IV+JtTpEqxqDmJc2XIQR63v5V3Fu1jmUdbkvDbTQh2SPM6C50GtwDqBuOp3WqFN05Jx3IcMysy3weJEkayLax5DiDYjyIIr1qFdVFbiZJ03Fk\\/Z0naO\\/d3d1aCo17Qf7Q+X0FSCyxuFEi5W\\/8eHKq5RUlZo7Tad0c9iej0i\\/duCN+Vhb8xp6g1lngqcttC+OIktyoxEEqH7SNgOa9ofle3oKySwVSO2vzkXxxEWeRyqdQQbc+H+fMVllTcd19ixSvszZ1Y3DTXx9T57rmuTq5mkA058xbTvCtb11qbshtHEdKcejtoZuzcDKVCsL+9z+la6UWkcSZK6Ey9XHLKtku1iCwOYIAQTnI3Frabs3EmvVwdNOLb1uzysbUamknsjpxtnEn3LMgJW4JYaIxG42FyFHnWh0afHf+TMq0\\/ngVPSaeY9UJdCFZ7WIsSCCDcnlXMqcVSll7vqTGcnUjm7znujseMdSscsYVHYASx5hqxPvKwI9Kyuy1ua730aLDE7XxbucNMOr6nKethdhcMjHcTfLoeZqyg2m5Kz8fErrxi0ou614eBMwuHmY2GPkRuCvK4J0vYfrhVznLjTi\\/ngUKnHZVJL54lnisRjI8LJE8E+JVla0yyRP7wsOznLkDfu3VlnedRNJR+eBphaFNrNmORbAdWvWYjKW+GPeE8RuZz+uQlzV7Q83z7lyQjBvWXkuXe+bJ3RbZEOIkdmILixKAi+vGw1I04V5uPqYqnFdTG64u17eRsoqk32nqda2xICMrYdGA+ZM31r56eLxV9ZyXsa8seCRHxXR+LSSFUjdGW5SGMlgWF4ySOypHEbrA1v6P62vSrSlOTai7ave25XUmoSiuDepV7YlGGmEvVRgxqct7ADdcALvY6D+HP4VZ0ZSr003N3Xjf77F1WamkobHJf8AVjDFLjWN3Q2jv8U8t8h78oDSH+Ec69ihTzSu+BxiaihTyrd\\/T5oY\\/sw2MWZpCdVX3jvzy6XvzCkH8Vb1G7seapqCva+1uW\\/HnfY7rZythSY2kMoaQWaViMu7Qk3stxeuoUsitdvxJxOMeIqZlCMdLWirI+c7Wmjxk7bRjZyZGMZDbg2UIoXQWGXWxvvHfXrdHp58rXeZJu25Y9FlRsR1jfdxAuf4I1v\\/APFfzr3KzdLDN8X9WULtTsTcFOep6xz25nedz3yEhT4ZFf8Anr4XpCopVnFbR09P5PtuiaOWCb8fnsYfs\\/BeDGYmxz4uURIbbo4ipbyJdV\\/D3VixMssVDj8ufP1aFXHzqTg0tePf5PgjVt\\/oxiJ2jKSBFRNQQ+pJztdQNd4Gmt1I7jnoVYQi8yvc7odDVqSazRu3wv8Ag67CgIiRlWZbAMhF1G8XU8rjda2o90XNVZ09zfHBVEt0Y7RwrPAywzlUZWBVkDlQy6qMxBU2O43t3U6xJptfYrlRkm4t\\/cq4dmYnCyYUCWBogwRQ0bIxPVtZS4Yi5GbUDfwNTnpzUnZ38e85tJWV0XW0NvSQypHNhVD4jLGgWXMBYtdiSoPHlTLFptPbuOdSu6OYLGwYabDkQS5SQZSWUjMl7hLEMRm5ruA767nKm5ZkmRaS0bIuFxo2TBJGzxSyy2NvdIzB7N1YubX4nTvrpXqSvbQ5atxO06Fw5sMl3EilQxIIBDMc7glbcSdK04SDzOTRTXkrWOnwuFRdy\\/U\\/WvQMxC2io6xvL6CpBdlaiwMSlRYm5iYqixNyuxuxYZNWQX5jQ+oqGr6MlO2xUYno0w1ik8nF\\/wDkLH61nnhKcttC2NeS31IM2HmQENETcEXXtDdyFj+RrLLAzX7dfYuWIi9zhpNhYhxlEB8TYfW\\/0q6OHlfUiVeJ1PRjonKsGV2VblrhSRodQQQOdgeGnr6FOUaUEnq9zy68Z1aja0Wxer0fKqiIVsrdYWJa+bQHua6gLrzJ41Z+pXavfVW+ctddCr9LLs2a0d+O\\/wB9NNfE5Xb+DaNo4399lZ3FwQSFYl9OZLDXXsirq1WM6c3Hbh6rTysU0KUoVIKW\\/H0d353OT6JYHDSYmc4maYASEKiTOg4b8vnXnp2tovQ9KSbWjO4HRrBMbpLNrrcMjbgQA19+hO\\/nVyrR\\/sXldfczdRP+9+dn9jb\\/AOl1uCk3aWxBaI6W3aIwH5VKqQemq81919yHTmrXs\\/J\\/Z\\/Y1DZc+GUSZIjHGCM4dr9rMoBRlDDWTdc7uFV15uUWr3v5cb82uBbRhFSUrWt58LdzOE6Qzhr72y3ux0HFdBuA9Sapisu+5ovmvZaFd0Xc5yVVmPALbeCAOyT2hrwuRyqzO76HUYQTWbY+obHkxBeIHrgjHeGe1rXB32qqVWp\\/VFGp0cLlcqc9eV\\/jLKWMRyNnkJBMYAc3AJcBDl0uwa1vEnhXUbzg0xR0vZf8AXFX4XX0OY\\/aAivPDAZQrStrcFsrBSMpI+G6nThqdxFZ504wpvK7LiaaGKp0JKVWnmSvb2aduOm\\/8Fc\\/QeQhUebCst7gMZLZjYXClSMxsB5Cs0W2+xUXq\\/wAHqrprouas6V\\/\\/AIR\\/JbbJiODingAjZg6uXAta+UEA2vwvWylUnBqLd9Vz4ux5mPWGrrraMMiSatZatK99DKB3kLGVbRkAoRlLAjifG54nhpVD6YoReWzzK93q79yRgWArSbvbLpbZW77lX0h2qgCwXADG9yosLcyLkHwFXzx7rUJOmpJ6Lk9+Gp1hsGqNeOdp79\\/AoyHCToikmUJGvVqzZVLXkYkDQWAGvBq19EYqWSanKTSs1dvhfa\\/Et6QhB1IbLdcONty+k2Ok0eW5ClSgGoNsvV27vdU+ZrxqlecZu+\\/xnuppwcY\\/tatpy7ix2PgUggSBR2Yi+S2ujtnbNfeb8eVVzrKou3v3GSjhOok3S2dr3fFctCST4+n+a5jGEpJXeumy\\/JdOdWEXJpaK+7\\/BiWHM+n+a5fV3td+i\\/J0nWavlXq\\/\\/AFKnbOzDOQG6vIAeBzG\\/AsOGnfv7rHuNRR\\/a387iqWHztyml89CNtXCGOEuOvmaMKYUDyNldTZWVCSAQCdR31NOV5WbSvuUYnDwhTcop6d5EjRcTFh5MZFjHxSyIGd0xC9UnWgSWYDJ7t9xvrzFqtlKUW1Fq3ijAoxdtNTpsMmBQSDALPKxVjl63FdWz2tlkLXj4Aa3riTk9JfYiKKfZ2CxkEzzSrhXKxqMqs4tdifiU3PZYcN4qZSptJK+5Npdx9Q2RGwTtgBtxVTmUW5GwP5VuwUUotq+plrvWxbxLW0pKnaP3jeX0FSQXdAKAUB5aosDBkpYk0SR0BEmQDU2AG8nQDxNQ9EDT1qsuWOZL8CCp4EbuP+KqVRJ3aI6ttWUjLB4eZSc7hxpbTUWH9Tr5V3KpTktFYrhTqxfalc4XpDNmMk28uxRRyRLbvE2HkauxHZUaS4avxZTh+3KVV8XZeCOT2BhCJG65GAY33Hjv1FZKsbHoU2aNurOmKPssasq2GZlbiguLqRfeefCopxzLiTN2ZlNtHEkAN1i24xSPH+Wtd9V3nGZcjtMAubDq0jSFZFVmQyMe+1zyI3i1ZZ3jKyNEYxkjjcd0JxmJfrAUEXZKoHAC3UXuPmvfU3NVQxtFLjdb6MiVOV\\/oXWw+g0sLKSubeSyuLg6EZfMV0uksL\\/d7MrlSqPuOsw+HljdLRqqrvOe53W3Xt6VmeLwSeZN38GRDCtNNIrOkmFeSVZcypkIPvWJswaw8bDiK24bpXBv\\/ACrScpaJpftvpe72sWyoV12lot3321OU6SP\\/AKvDl9e0G8DYm5v71zqb79a0TopQ6uleVtNdWzhzlOpd8fbhZdx9CZbPEoyrcC+T4hcWB3cuZ4153U5K2+qaWmi9PqIKEodbBOV33JLm9N0VG02b\\/VlRvsg36szIAL7u8eBrbbtp96+ppcl+na43f\\/5ORnGKuFMUa\\/Fdu0Ba28gm3DSuZNUnaUvnkKdOdZXhH3JmzejM4kWaRkaMBgQhYjUFTwFiDXOIWei3HXb6neFlkxCUtN\\/oXQwyA3Asb30JGobN9b+p515qjUWqT9D2HUpNWcl6o3vNfXTyFvpXTdRu7h7FcVRirKpp\\/wAkYiTu+td5ZZL5Nb8nyK3KHW5es0tzXMdZ+ta5XWJ3yezO2qUk06m\\/ejAyDu\\/P+9Q87\\/o9mdLq1p1vuvwcv0m2w8TARuy3HFSQe1drN3BgN9Wwou15KxmqVpZ3GnK9rcn9EedHekGJkdYVCdZqRLKGPM9qMZeAI31E6UIrM9uS+MrnKs1Zs6DZ8uPxEEkPXYeNYpmVpRExYnOXJCsxUDtcb7q4k6cWtG7rmZssr3uStnkYLDnBri4iSzZpLKHGZblrXKgiw3g121ObbUH7nHZ0u9iPszo7hnXrmxU7O7tdOvfW0jBSUB3W1tYDU11JV3oo+xzmgnv7n0XZUdkA1PiST6nWvRw1OUKaUtzNVkpSui2QVoKim2j943l9BUgu6AUAoBQCgPCKAjYvBLIpRrEMLEEXuDzFAcZif2YwE3SSRPA7t+7lvNTmZxkiZQdCcVFbqsfMAOBJIrlpPgiUrcWT8L0Uc2OIl61hpfLbzPM1GRXbOtlYtI9iou4V0DyTZKHeBQEaTYUR3oPSoBFxeyo1W2XS1rAnd4VTKlFu9tS2NSSVitwiFI5k1JlkZweCggBVt3AfnXzEMQqUcjWq0ZulHO00Rv8A1DEiBOtzMoCkrrcgWJ0uL1zTwFaTzZXb0R3KrA0wYyOZ1UtMAdLg2GvM+9+dW1Oj8RlcnlduH4WwjiYrSJrxHQxJyDmcFHdl473zWPcLWHdX0XR1TLhYqG0oq\\/oebiY56t5cHoexfs8LSB5pM4UqQACNwsQTv1ufWtMZOLvE5Ta2OubYyFkYBgU3dq4\\/WtUKhBScuLd\\/M6o1HRg6cNE7++5BxPRcsJO2byMpPgpBsBu4b99S6faumWdf2MjXN+qsQR0Uljv1eQg8yR\\/Q1mxWGlVmpJrY14LGU6EHGSe99DFuj+J5J\\/Mf7Vl\\/w+pzXubf8Uof2v0X5NLbAxPJf5j\\/AGp+gq816sldKYf+1+i\\/JiNg4nkm4fEeQ7q7qYOrKV01w58iuj0jQhDK4vjwXFtj\\/oOI\\/d\\/mP9q4\\/QVea9X+C3\\/FMP8A2v0X5PBsLEXHu7x8R\\/tXdPB1YzUm1o1xZVW6RoTpygovVNbLl4mC9H8R+7\\/Mf7Vz+hq816ssXSeHt+1+i\\/JmOjuJ\\/c\\/mP9qfoavNer\\/A\\/wAUocn6L8m2DotKxtMIynEXJ8NLVdh8JOnPNKxlxmPpVaWSKd7lrhOikKAgRgA71F7HxXca3ZVe9jysz2LKDYsa7kUeVdEEyLZ6jco9KAlxw2qSDdUgpNo\\/eN5fQUBd0AoBQCgFAKAUAoBQCgFAeWoDwoKA1yYZTvFRYEOTYUB3xqfKq3Qpt5sqv4HfWSta5gvRzDDdEvpXeVHOZmQ2Dh\\/\\/ANa0yInMyZDhEXRRbj61zTpQpxywVkJScndm3IK7scnuUUsBlpYDLSwGUUsDzIKWB51QpYXPOpFLE3HUilhcdUOVLC5l1Y5UsQMgpYHuUVIPbUAoBQCgKTaP3jeX0FAXdAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQFJtH7xvL6CgLugFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoBQCgFAKAUAoCk2j943l9BQGv2h\\/mb1NAPaH+ZvU0A9of5m9TQD2h\\/mb1NAPaH+ZvU0A9of5m9TQD2h\\/mb1NAPaH+ZvU0A9of5m9TQD2h\\/mb1NAPaH+ZvU0A9of5m9TQD2h\\/mb1NAPaH+ZvU0A9of5m9TQD2h\\/mb1NAPaH+ZvU0A9of5m9TQD2h\\/mb1NAPaH+ZvU0A9of5m9TQD2h\\/mb1NAPaH+ZvU0A9of5m9TQD2h\\/mb1NAPaH+ZvU0A9of5m9TQD2h\\/mb1NAPaH+ZvU0A9of5m9TQD2h\\/mb1NAPaH+ZvU0A9of5m9TQD2h\\/mb1NAPaH+ZvU0BUY+dusPabhxPIUB\\/\\/9k=\"],\"maxImages\":3,\"ratio\":\"4:1\"}},{\"uid\":\"mnsciaqzjj2yldh8g6\",\"type\":\"produk\",\"config\":{\"title\":\"Produk Rekomendasi\",\"textColor\":\"#1e293b\",\"productSource\":\"auto\",\"layout\":\"horizontal\",\"selectedProducts\":[]}},{\"uid\":\"mnsb60k3q20txe4vfi\",\"type\":\"video\",\"config\":{\"title\":\"Produk unggulan\",\"textColor\":\"#1e293b\",\"videoSource\":\"youtube\",\"videoUrl\":\"https:\\/\\/youtu.be\\/fVQgAonobrM?si=SVC65q05S1Agm45z\",\"videoFile\":null}},{\"uid\":\"mnzhfaszok8rd0278fg\",\"type\":\"carousel\",\"config\":{\"title\":\"Banyak Foto Grid\",\"textColor\":\"#1e293b\",\"images\":[],\"maxImages\":5,\"gridType\":\"5\"}},{\"uid\":\"mnsciuz22t8r25obqiy\",\"type\":\"carousel\",\"config\":{\"title\":\"Banyak Foto Grid\",\"textColor\":\"#1e293b\",\"images\":[],\"maxImages\":5,\"gridType\":\"5\"}}]}', 'logo_toko_oDwbVZjWKE.jpg', 'banner_toko_EwgFpkr3K8.jpg', 'Jalan Tol Jakarta–Cikampek, Duren, Klari, Karawang, Jawa Barat, Jawa, 41371, Indonesia', 2, 21, 215, '41371', '85156677227', -6.37715350, 107.37458800, 'active', 'Buka', 0.00, NULL, NULL, NULL, 'official_store', NULL, NULL, '2026-02-18 04:15:43', '2026-05-02 04:56:29'),
(48, 8, 'toko ucok', NULL, 'toko-ucok', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'planet mars', 2, 21, 217, NULL, '08888', NULL, NULL, 'active', 'Buka', 0.00, NULL, NULL, NULL, 'power_merchant', NULL, NULL, '2026-03-03 20:42:45', '2026-03-03 21:00:33'),
(49, 10, 'toko gacor999', NULL, 'toko-gacor999', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'planet mars', 2, 21, 216, NULL, '08888', NULL, NULL, 'active', 'Buka', 0.00, NULL, NULL, NULL, 'regular', NULL, NULL, '2026-03-05 18:21:36', '2026-03-05 18:21:36'),
(50, 13, 'Toko Uji tst5', NULL, 'toko-uji-tst5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'planet mars', 2, 21, 217, NULL, '081222222223', NULL, NULL, 'active', 'Buka', 0.00, NULL, NULL, NULL, 'regular', NULL, NULL, '2026-04-08 20:41:00', '2026-04-08 20:41:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_toko_dekorasi`
--

CREATE TABLE `tb_toko_dekorasi` (
  `id` int(11) NOT NULL,
  `toko_id` int(11) NOT NULL,
  `tipe_komponen` enum('BANNER','PRODUK_UNGGULAN','TEKS_GAMBAR') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `konten_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_toko_jam_operasional`
--

CREATE TABLE `tb_toko_jam_operasional` (
  `id` int(11) NOT NULL,
  `toko_id` int(11) NOT NULL,
  `hari` tinyint(1) NOT NULL,
  `is_buka` tinyint(1) NOT NULL DEFAULT 0,
  `jam_buka` time DEFAULT NULL,
  `jam_tutup` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_toko_pengaturan`
--

CREATE TABLE `tb_toko_pengaturan` (
  `toko_id` int(11) NOT NULL,
  `notif_email_pesanan` tinyint(1) NOT NULL DEFAULT 1,
  `notif_email_chat` tinyint(1) NOT NULL DEFAULT 1,
  `notif_email_produk` tinyint(1) NOT NULL DEFAULT 1,
  `notif_email_promo` tinyint(1) NOT NULL DEFAULT 1,
  `chat_terima_otomatis` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_toko_review`
--

CREATE TABLE `tb_toko_review` (
  `id` int(11) NOT NULL,
  `toko_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `ulasan` text DEFAULT NULL,
  `balasan_penjual` text DEFAULT NULL,
  `is_anonymous` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `id` int(11) NOT NULL,
  `kode_invoice` varchar(50) NOT NULL,
  `sumber_transaksi` enum('ONLINE','OFFLINE') NOT NULL DEFAULT 'ONLINE',
  `user_id` int(11) NOT NULL,
  `total_harga_produk` decimal(15,2) NOT NULL,
  `total_diskon` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_final` decimal(15,2) NOT NULL,
  `tipe_pembayaran` enum('LUNAS','DP') NOT NULL DEFAULT 'LUNAS',
  `jumlah_dp` decimal(15,2) DEFAULT 0.00,
  `sisa_tagihan` decimal(15,2) DEFAULT 0.00,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `status_pembayaran` enum('pending','paid','dp_paid','failed','expired','cancelled') NOT NULL DEFAULT 'pending',
  `status_pesanan_global` enum('menunggu_pembayaran','diproses','dikirim','selesai','dibatalkan','komplain') NOT NULL DEFAULT 'menunggu_pembayaran',
  `payment_deadline` datetime DEFAULT NULL,
  `shipping_label_alamat` varchar(100) DEFAULT NULL,
  `shipping_nama_penerima` varchar(255) DEFAULT NULL,
  `shipping_telepon_penerima` varchar(20) DEFAULT NULL,
  `shipping_alamat_lengkap` text DEFAULT NULL,
  `shipping_kecamatan` varchar(100) DEFAULT NULL,
  `shipping_kota_kabupaten` varchar(100) DEFAULT NULL,
  `shipping_provinsi` varchar(100) DEFAULT NULL,
  `shipping_kode_pos` varchar(10) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `voucher_digunakan` varchar(255) DEFAULT NULL,
  `biaya_pengiriman` decimal(15,2) DEFAULT 0.00,
  `tipe_pengambilan` enum('pengiriman','ambil_di_toko') NOT NULL DEFAULT 'pengiriman',
  `snap_token` varchar(255) DEFAULT NULL,
  `customer_service_fee` decimal(15,2) DEFAULT 0.00,
  `customer_handling_fee` decimal(15,2) DEFAULT 0.00,
  `midtrans_fee` decimal(15,2) DEFAULT 0.00,
  `tanggal_transaksi` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`id`, `kode_invoice`, `sumber_transaksi`, `user_id`, `total_harga_produk`, `total_diskon`, `total_final`, `tipe_pembayaran`, `jumlah_dp`, `sisa_tagihan`, `metode_pembayaran`, `status_pembayaran`, `status_pesanan_global`, `payment_deadline`, `shipping_label_alamat`, `shipping_nama_penerima`, `shipping_telepon_penerima`, `shipping_alamat_lengkap`, `shipping_kecamatan`, `shipping_kota_kabupaten`, `shipping_provinsi`, `shipping_kode_pos`, `catatan`, `voucher_digunakan`, `biaya_pengiriman`, `tipe_pengambilan`, `snap_token`, `customer_service_fee`, `customer_handling_fee`, `midtrans_fee`, `tanggal_transaksi`) VALUES
(1, 'INV-1772771222-695', 'ONLINE', 9, 20000.00, 0.00, 35000.00, 'LUNAS', 0.00, 0.00, NULL, 'pending', 'menunggu_pembayaran', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'pengiriman', NULL, 0.00, 0.00, 0.00, '2026-03-06 04:27:02'),
(2, 'INV-1772771297-977', 'ONLINE', 9, 20000.00, 0.00, 35000.00, 'LUNAS', 0.00, 0.00, NULL, 'pending', 'menunggu_pembayaran', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'pengiriman', NULL, 0.00, 0.00, 0.00, '2026-03-06 04:28:17'),
(3, 'INV-1772771856-984', 'ONLINE', 9, 120000.00, 0.00, 135000.00, 'LUNAS', 0.00, 0.00, NULL, 'pending', 'menunggu_pembayaran', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'pengiriman', NULL, 0.00, 0.00, 0.00, '2026-03-06 04:37:36'),
(4, 'INV-1773024376-402', 'ONLINE', 9, 12000000.00, 0.00, 12015000.00, 'LUNAS', 0.00, 0.00, NULL, 'pending', 'menunggu_pembayaran', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'pengiriman', NULL, 0.00, 0.00, 0.00, '2026-03-09 02:46:16'),
(5, 'INV-1773024604-716', 'ONLINE', 9, 12000000.00, 0.00, 12015000.00, 'LUNAS', 0.00, 0.00, NULL, 'pending', 'menunggu_pembayaran', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'pengiriman', NULL, 0.00, 0.00, 0.00, '2026-03-09 02:50:04'),
(6, 'INV-1773026446-840', 'ONLINE', 9, 12000000.00, 0.00, 12015000.00, 'LUNAS', 0.00, 0.00, NULL, 'pending', 'menunggu_pembayaran', NULL, 'Alamat Baru Manual', 'ucok resing', '08888', 'planet mars', 'PAGADEN', 'KOTA TANGERANG', 'BANTEN', '121212', NULL, NULL, 15000.00, 'pengiriman', NULL, 0.00, 0.00, 0.00, '2026-03-09 03:20:46'),
(7, 'INV-1773026719-257', 'ONLINE', 9, 12000000.00, 0.00, 12015000.00, 'LUNAS', 0.00, 0.00, NULL, 'pending', 'menunggu_pembayaran', NULL, 'Alamat Baru Manual', 'ucok resing', '08888', 'planet mars', 'PAGADEN', 'KOTA TANGERANG', 'BANTEN', '1212121', NULL, NULL, 15000.00, 'pengiriman', 'b88ea5a6-fda5-4a7b-a380-6896e3f5c39d', 0.00, 0.00, 0.00, '2026-03-09 03:25:19'),
(8, 'INV-1775754871-758', 'ONLINE', 14, 12000000.00, 0.00, 12015000.00, 'LUNAS', 0.00, 0.00, NULL, 'pending', 'menunggu_pembayaran', NULL, 'Alamat Baru Manual', 'zyo zyo', '18010101010', 'bandung', 'majalaya', 'cibubur', 'west java', '401111', NULL, NULL, 15000.00, 'pengiriman', 'a4b83e9c-d096-4249-bff8-827d8410281a', 0.00, 0.00, 0.00, '2026-04-09 17:14:31'),
(9, 'INV-1775786071-948', 'ONLINE', 1, 20000.00, 0.00, 35000.00, 'LUNAS', 0.00, 0.00, NULL, 'pending', 'menunggu_pembayaran', NULL, 'Alamat Baru Manual', 'budi', '0812234567', 'subang', 'pagaden', 'subang', 'jawa barat', '401234', NULL, NULL, 15000.00, 'pengiriman', '4af89e86-24d4-49b8-8c9b-a8c33ef5d0d8', 0.00, 0.00, 0.00, '2026-04-10 01:54:31'),
(10, 'INV-1775790543-752', 'ONLINE', 15, 20000.00, 0.00, 35000.00, 'LUNAS', 0.00, 0.00, NULL, 'pending', 'menunggu_pembayaran', NULL, 'Alamat Baru Manual', 'budi', '08122222', 'subang', 'pagaden', 'subang', 'jawa barat', '401222', NULL, NULL, 15000.00, 'pengiriman', '95ed14f4-fed8-4114-82c3-8c9a3e513d44', 0.00, 0.00, 0.00, '2026-04-10 03:09:03'),
(11, 'INV-1775793268-618', 'ONLINE', 15, 20000.00, 0.00, 35000.00, 'LUNAS', 0.00, 0.00, NULL, 'pending', 'menunggu_pembayaran', NULL, 'Alamat Baru Manual', 'zee xz', '0816212131', 'subang', 'pagaden', 'subang', 'jawa barat', '122123', NULL, NULL, 15000.00, 'pengiriman', 'd9104a6b-0a4c-443e-b1cb-75aa6d20fcc1', 0.00, 0.00, 0.00, '2026-04-10 03:54:28');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `profile_picture_url` varchar(255) DEFAULT NULL,
  `status` enum('online','offline','typing') NOT NULL DEFAULT 'offline',
  `last_activity_at` timestamp NULL DEFAULT current_timestamp(),
  `level` enum('admin','seller','customer','bot') NOT NULL,
  `admin_role` enum('super','finance','cs') DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `is_banned` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `status_online` enum('online','offline') NOT NULL DEFAULT 'offline'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id`, `username`, `password`, `google_id`, `nama`, `email`, `no_telepon`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `profile_picture_url`, `status`, `last_activity_at`, `level`, `admin_role`, `is_verified`, `is_banned`, `created_at`, `updated_at`, `reset_token`, `reset_token_expires_at`, `status_online`) VALUES
(1, 'QISAAA', '$2y$12$9QcPenKKl9IhyAdwilkAau9grUjuT15Vstogi2RIgIXfLRZfDozWW', NULL, 'Prabu Alam Tian Try Suherman', 'prabualamtian@gmail.com', '085156677227', NULL, NULL, NULL, NULL, 'offline', '2026-02-18 11:15:43', 'seller', NULL, 1, 0, '2026-02-18 04:15:43', '2026-03-01 03:56:49', NULL, NULL, 'offline'),
(5, 'superadmin', '$2y$12$mw4TqQo9UShVw69GF4V2dOhLidAgWcKoT.GoW5VBjsUXDuCLdEwaW', NULL, 'Bos Super Admin', 'super@pondasikita.com', NULL, NULL, NULL, NULL, NULL, 'offline', '2026-03-01 10:29:48', 'admin', 'super', 1, 0, '2026-03-01 10:29:48', '2026-03-01 03:31:11', NULL, NULL, 'offline'),
(6, 'adminfinance', '$2y$12$0u/uKUVEjH6Fw2dXOpfD/ezGKtCWjX8CwYBsVCje6yb7/TQP7qm2y', NULL, 'Siska Finance', 'finance@pondasikita.com', NULL, NULL, NULL, NULL, NULL, 'offline', '2026-03-01 10:29:48', 'admin', 'finance', 1, 0, '2026-03-01 10:29:48', '2026-03-01 03:32:08', NULL, NULL, 'offline'),
(7, 'admincs', '$2y$12$qzHpP57wpkEdaoXL9nl8pujf6/UbNX0Maext4WG9VZxwlPXw7MevC', NULL, 'Doni CS', 'cs@pondasikita.com', NULL, NULL, NULL, NULL, NULL, 'offline', '2026-03-01 10:29:48', 'admin', 'cs', 1, 0, '2026-03-01 10:29:48', '2026-03-01 03:34:34', NULL, NULL, 'offline'),
(8, 'ucok', '$2y$12$C8rm71dVyfu8mVtsfp.ZB.l9qxwi7dis/p.uzNNZb8LUNYbcQbWJW', NULL, 'ucok resing', 'sellertest@gmail.com', '08888', NULL, NULL, NULL, NULL, 'offline', '2026-03-04 03:42:45', 'seller', NULL, 1, 0, '2026-03-03 20:42:45', '2026-03-08 19:24:57', NULL, NULL, 'offline'),
(9, 'test', '$2y$12$Y7KGvsX1rHQ..LyUR9Hzv.Vrbkh3WJVJHTjgMSU2Mej5cTyFgO1BG', NULL, 'kiki juji', 'test@gmail.com', NULL, NULL, NULL, NULL, NULL, 'offline', '2026-03-05 15:11:33', 'customer', NULL, 1, 0, '2026-03-05 08:11:33', '2026-03-08 19:26:23', NULL, NULL, 'offline'),
(10, 'jojo', '$2y$12$0Ib/wn7eAxoeJNkaEh.freTUTgecUYYpORNmqm3XCjFA3fxU8PRTu', NULL, 'joo jojo', 'jojo@gmail.com', '08888', NULL, NULL, NULL, NULL, 'offline', '2026-03-06 01:21:36', 'seller', NULL, 1, 0, '2026-03-05 18:21:36', '2026-03-05 18:21:36', NULL, NULL, 'offline'),
(12, 'test99', '$2y$12$qoCcMGe42Q3RC05OFY0osOav91DbIjGKlYGD7lp8dCGU.ewPgkMo.', NULL, 'kiki', 'test99@gmail.com', NULL, NULL, NULL, NULL, NULL, 'offline', '2026-04-09 01:50:00', 'customer', NULL, 1, 0, '2026-04-08 18:50:00', '2026-04-08 18:50:00', NULL, NULL, 'offline'),
(13, 'Kiboy', '$2y$12$iTJpra.f5bgNBiQO/K8en.gyWDD1m4olbxaw52WBeu1a0mecBzaW.', NULL, 'kiki resing', 'kiboyyy@gmail.com', '081222222223', NULL, NULL, NULL, NULL, 'offline', '2026-04-09 03:41:00', 'seller', NULL, 1, 0, '2026-04-08 20:41:00', '2026-04-08 20:41:00', NULL, NULL, 'offline'),
(14, 'zyo-zyo-7IF0', '$2y$12$hvMdamrIcdH7Rv9qVH5bkOkSggFVAP8PrCLVaYrg6D3AJhAM6vy5W', '115224347161440682343', 'zyo zyo', 'zyoz472@gmail.com', NULL, NULL, NULL, NULL, NULL, 'offline', '2026-04-09 17:10:08', 'customer', NULL, 0, 0, '2026-04-09 10:10:08', '2026-04-09 10:10:08', NULL, NULL, 'offline'),
(15, 'zee-xz-0DOu', '$2y$12$/8OBjyT76uxjF/ZGV7mPSOg1NCFwrVYddSVSHe3LsQ8Ru6AjxmZ5C', '101941019015156751945', 'zee xz', 'zeexz7362@gmail.com', NULL, NULL, NULL, NULL, NULL, 'offline', '2026-04-10 01:09:43', 'customer', NULL, 0, 0, '2026-04-09 18:09:43', '2026-04-09 18:09:43', NULL, NULL, 'offline'),
(16, 'prabuganteng', '$2y$12$Cc3egzSoRcbyr3x4YdOPAOfjp.G.5R1BwV2pzLYd0WJLgkhtDHH1K', NULL, 'Qisty Sauva Prabu', 'prabualamtian999@gmail.com', '0851566772277', NULL, NULL, NULL, NULL, 'offline', '2026-05-01 16:27:08', 'customer', NULL, 1, 0, '2026-05-01 16:27:08', '2026-05-01 17:16:55', NULL, NULL, 'offline');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_alamat`
--

CREATE TABLE `tb_user_alamat` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `label_alamat` varchar(50) NOT NULL,
  `nama_penerima` varchar(100) NOT NULL,
  `telepon_penerima` varchar(20) NOT NULL,
  `alamat_lengkap` text NOT NULL,
  `province_id` int(10) UNSIGNED DEFAULT NULL,
  `city_id` int(10) UNSIGNED DEFAULT NULL,
  `district_id` int(10) UNSIGNED DEFAULT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `is_utama` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_zona_pengiriman`
--

CREATE TABLE `tb_zona_pengiriman` (
  `id` int(11) NOT NULL,
  `nama_zona` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_zona_pengiriman`
--

INSERT INTO `tb_zona_pengiriman` (`id`, `nama_zona`, `deskripsi`, `created_at`) VALUES
(1, 'Jabodetabek', 'Mencakup Jakarta, Bogor, Depok, Tangerang, Bekasi', '2025-07-09 06:59:57'),
(2, 'Bandung Raya', 'Mencakup Kota Bandung, Kabupaten Bandung, Cimahi', '2025-07-09 06:59:57'),
(3, 'Surabaya Metropolitan', 'Mencakup Surabaya, Sidoarjo, Gresik', '2025-07-09 06:59:57'),
(4, 'Jogja Raya', 'Mencakup Yogyakarta, Sleman, Bantul, Kulon Progo, Gunungkidul', '2025-07-11 03:00:20'),
(5, 'Solo Raya', 'Mencakup Kota Solo, Karanganyar, Sukoharjo, Boyolali, Klaten, Sragen', '2025-07-11 03:00:20'),
(6, 'Semarang Raya', 'Mencakup Kota Semarang, Kabupaten Semarang, Kendal, Demak, Ungaran', '2025-07-11 03:00:20'),
(7, 'Medan Metropolitan', 'Mencakup Medan, Binjai, Deli Serdang', '2025-07-11 03:00:20'),
(8, 'Makassar Raya', 'Mencakup Makassar, Gowa, Maros, Takalar', '2025-07-11 03:00:20'),
(9, 'Bali', 'Mencakup seluruh wilayah di Provinsi Bali', '2025-07-11 03:00:20'),
(10, 'Balikpapan-Samarinda', 'Mencakup Balikpapan, Samarinda, dan sekitarnya', '2025-07-11 03:00:20'),
(11, 'Batam dan Kepulauan Riau', 'Mencakup Batam, Tanjungpinang, dan kabupaten di Kepri', '2025-07-11 03:00:20'),
(12, 'Papua', 'Mencakup Jayapura, Timika, dan wilayah lainnya di Papua', '2025-07-11 03:00:20'),
(13, 'Maluku', 'Mencakup Ambon, Tual, dan daerah lain di Maluku', '2025-07-11 03:00:20'),
(14, 'Banjarmasin Raya', 'Mencakup Banjarmasin, Banjarbaru, dan Kabupaten Banjar', '2025-07-11 03:00:20'),
(15, 'Pontianak Raya', 'Mencakup Pontianak, Singkawang, dan sekitarnya', '2025-07-11 03:00:20'),
(16, 'Padang Raya', 'Mencakup Kota Padang, Bukittinggi, Payakumbuh, dan sekitarnya', '2025-07-11 03:00:20');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(11) NOT NULL,
  `toko_id` int(11) DEFAULT NULL,
  `kode_voucher` varchar(12) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `tipe_diskon` enum('RUPIAH','PERSEN') NOT NULL,
  `nilai_diskon` decimal(15,2) NOT NULL,
  `maks_diskon` decimal(15,2) DEFAULT NULL,
  `min_pembelian` decimal(15,2) DEFAULT 0.00,
  `kuota` int(11) NOT NULL,
  `kuota_terpakai` int(11) DEFAULT 0,
  `tanggal_mulai` datetime NOT NULL,
  `tanggal_berakhir` datetime NOT NULL,
  `status` enum('AKTIF','TIDAK_AKTIF','HABIS') DEFAULT 'AKTIF'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `toko_id`, `kode_voucher`, `deskripsi`, `tipe_diskon`, `nilai_diskon`, `maks_diskon`, `min_pembelian`, `kuota`, `kuota_terpakai`, `tanggal_mulai`, `tanggal_berakhir`, `status`) VALUES
(1, 49, 'PROMOGACOR', 'voucher promo hemat', 'PERSEN', 20.00, 10000000.00, 100000.00, 20, 0, '2026-03-06 08:48:00', '2026-03-07 08:48:00', 'AKTIF');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `toko_id` (`toko_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `province_id` (`province_id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_id` (`chat_id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_kode_barang_toko` (`toko_id`,`kode_barang`),
  ADD KEY `fk_barang_toko` (`toko_id`),
  ADD KEY `fk_barang_kategori` (`kategori_id`);

--
-- Indexes for table `tb_barang_variasi`
--
ALTER TABLE `tb_barang_variasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `tb_biaya_pengiriman`
--
ALTER TABLE `tb_biaya_pengiriman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zona_id` (`zona_id`);

--
-- Indexes for table `tb_detail_transaksi`
--
ALTER TABLE `tb_detail_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id` (`transaksi_id`),
  ADD KEY `toko_id` (`toko_id`);

--
-- Indexes for table `tb_flash_sale_events`
--
ALTER TABLE `tb_flash_sale_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_flash_sale_produk`
--
ALTER TABLE `tb_flash_sale_produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fs_event` (`event_id`),
  ADD KEY `fk_fs_toko` (`toko_id`),
  ADD KEY `fk_fs_barang` (`barang_id`);

--
-- Indexes for table `tb_gambar_barang`
--
ALTER TABLE `tb_gambar_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kategori_parent` (`parent_id`);

--
-- Indexes for table `tb_keranjang`
--
ALTER TABLE `tb_keranjang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `tb_komisi`
--
ALTER TABLE `tb_komisi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_transaksi_id` (`detail_transaksi_id`);

--
-- Indexes for table `tb_komplain`
--
ALTER TABLE `tb_komplain`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_komplain_transaksi` (`transaksi_id`),
  ADD KEY `fk_komplain_user` (`user_id`),
  ADD KEY `fk_komplain_toko` (`toko_id`);

--
-- Indexes for table `tb_kurir_toko`
--
ALTER TABLE `tb_kurir_toko`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kurir_toko` (`toko_id`);

--
-- Indexes for table `tb_mutasi_saldo`
--
ALTER TABLE `tb_mutasi_saldo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `toko_id` (`toko_id`);

--
-- Indexes for table `tb_payouts`
--
ALTER TABLE `tb_payouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `toko_id` (`toko_id`);

--
-- Indexes for table `tb_pengaturan`
--
ALTER TABLE `tb_pengaturan`
  ADD PRIMARY KEY (`setting_nama`);

--
-- Indexes for table `tb_review_produk`
--
ALTER TABLE `tb_review_produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_transaksi_id` (`detail_transaksi_id`);

--
-- Indexes for table `tb_stok_histori`
--
ALTER TABLE `tb_stok_histori`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `tb_toko`
--
ALTER TABLE `tb_toko`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_toko_user` (`user_id`),
  ADD KEY `fk_toko_province` (`province_id`),
  ADD KEY `fk_toko_city` (`city_id`),
  ADD KEY `fk_toko_district` (`district_id`);

--
-- Indexes for table `tb_toko_dekorasi`
--
ALTER TABLE `tb_toko_dekorasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dekorasi_toko` (`toko_id`);

--
-- Indexes for table `tb_toko_jam_operasional`
--
ALTER TABLE `tb_toko_jam_operasional`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `toko_hari_unik` (`toko_id`,`hari`);

--
-- Indexes for table `tb_toko_pengaturan`
--
ALTER TABLE `tb_toko_pengaturan`
  ADD PRIMARY KEY (`toko_id`);

--
-- Indexes for table `tb_toko_review`
--
ALTER TABLE `tb_toko_review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_review_toko_id` (`toko_id`),
  ADD KEY `fk_review_user_id` (`user_id`),
  ADD KEY `fk_review_transaksi_id` (`transaksi_id`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_invoice` (`kode_invoice`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tb_user_alamat`
--
ALTER TABLE `tb_user_alamat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_alamat_user` (`user_id`);

--
-- Indexes for table `tb_zona_pengiriman`
--
ALTER TABLE `tb_zona_pengiriman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_voucher` (`kode_voucher`),
  ADD KEY `fk_voucher_toko` (`toko_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_barang`
--
ALTER TABLE `tb_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_barang_variasi`
--
ALTER TABLE `tb_barang_variasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_biaya_pengiriman`
--
ALTER TABLE `tb_biaya_pengiriman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_detail_transaksi`
--
ALTER TABLE `tb_detail_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_flash_sale_events`
--
ALTER TABLE `tb_flash_sale_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_flash_sale_produk`
--
ALTER TABLE `tb_flash_sale_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_gambar_barang`
--
ALTER TABLE `tb_gambar_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tb_keranjang`
--
ALTER TABLE `tb_keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_komisi`
--
ALTER TABLE `tb_komisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_komplain`
--
ALTER TABLE `tb_komplain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_kurir_toko`
--
ALTER TABLE `tb_kurir_toko`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_mutasi_saldo`
--
ALTER TABLE `tb_mutasi_saldo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_payouts`
--
ALTER TABLE `tb_payouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_review_produk`
--
ALTER TABLE `tb_review_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_stok_histori`
--
ALTER TABLE `tb_stok_histori`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_toko`
--
ALTER TABLE `tb_toko`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tb_toko_dekorasi`
--
ALTER TABLE `tb_toko_dekorasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_toko_jam_operasional`
--
ALTER TABLE `tb_toko_jam_operasional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_toko_review`
--
ALTER TABLE `tb_toko_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_user_alamat`
--
ALTER TABLE `tb_user_alamat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_zona_pengiriman`
--
ALTER TABLE `tb_zona_pengiriman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `fk_chat_customer` FOREIGN KEY (`customer_id`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_chat_toko` FOREIGN KEY (`toko_id`) REFERENCES `tb_toko` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `fk_cities_province` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `fk_districts_city` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_message_chat` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD CONSTRAINT `fk_barang_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `tb_kategori` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_barang_toko` FOREIGN KEY (`toko_id`) REFERENCES `tb_toko` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_barang_variasi`
--
ALTER TABLE `tb_barang_variasi`
  ADD CONSTRAINT `fk_variasi_barang` FOREIGN KEY (`barang_id`) REFERENCES `tb_barang` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_biaya_pengiriman`
--
ALTER TABLE `tb_biaya_pengiriman`
  ADD CONSTRAINT `fk_biaya_zona` FOREIGN KEY (`zona_id`) REFERENCES `tb_zona_pengiriman` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_detail_transaksi`
--
ALTER TABLE `tb_detail_transaksi`
  ADD CONSTRAINT `fk_detail_transaksi_toko` FOREIGN KEY (`toko_id`) REFERENCES `tb_toko` (`id`),
  ADD CONSTRAINT `fk_detail_transaksi_utama` FOREIGN KEY (`transaksi_id`) REFERENCES `tb_transaksi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_flash_sale_produk`
--
ALTER TABLE `tb_flash_sale_produk`
  ADD CONSTRAINT `fk_fs_barang` FOREIGN KEY (`barang_id`) REFERENCES `tb_barang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_fs_event` FOREIGN KEY (`event_id`) REFERENCES `tb_flash_sale_events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_fs_toko` FOREIGN KEY (`toko_id`) REFERENCES `tb_toko` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_gambar_barang`
--
ALTER TABLE `tb_gambar_barang`
  ADD CONSTRAINT `fk_gambar_barang` FOREIGN KEY (`barang_id`) REFERENCES `tb_barang` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD CONSTRAINT `fk_kategori_parent` FOREIGN KEY (`parent_id`) REFERENCES `tb_kategori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_keranjang`
--
ALTER TABLE `tb_keranjang`
  ADD CONSTRAINT `fk_keranjang_barang` FOREIGN KEY (`barang_id`) REFERENCES `tb_barang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_keranjang_user` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_komisi`
--
ALTER TABLE `tb_komisi`
  ADD CONSTRAINT `fk_komisi_detail` FOREIGN KEY (`detail_transaksi_id`) REFERENCES `tb_detail_transaksi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_komplain`
--
ALTER TABLE `tb_komplain`
  ADD CONSTRAINT `fk_komplain_toko` FOREIGN KEY (`toko_id`) REFERENCES `tb_toko` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_komplain_transaksi` FOREIGN KEY (`transaksi_id`) REFERENCES `tb_transaksi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_komplain_user` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_kurir_toko`
--
ALTER TABLE `tb_kurir_toko`
  ADD CONSTRAINT `fk_kurir_toko` FOREIGN KEY (`toko_id`) REFERENCES `tb_toko` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_mutasi_saldo`
--
ALTER TABLE `tb_mutasi_saldo`
  ADD CONSTRAINT `fk_mutasi_toko` FOREIGN KEY (`toko_id`) REFERENCES `tb_toko` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_payouts`
--
ALTER TABLE `tb_payouts`
  ADD CONSTRAINT `fk_payout_toko` FOREIGN KEY (`toko_id`) REFERENCES `tb_toko` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_review_produk`
--
ALTER TABLE `tb_review_produk`
  ADD CONSTRAINT `fk_review_detail` FOREIGN KEY (`detail_transaksi_id`) REFERENCES `tb_detail_transaksi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_toko`
--
ALTER TABLE `tb_toko`
  ADD CONSTRAINT `fk_toko_city` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_toko_district` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_toko_province` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_toko_user` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_toko_dekorasi`
--
ALTER TABLE `tb_toko_dekorasi`
  ADD CONSTRAINT `fk_dekorasi_toko` FOREIGN KEY (`toko_id`) REFERENCES `tb_toko` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_toko_jam_operasional`
--
ALTER TABLE `tb_toko_jam_operasional`
  ADD CONSTRAINT `fk_jam_toko` FOREIGN KEY (`toko_id`) REFERENCES `tb_toko` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_toko_pengaturan`
--
ALTER TABLE `tb_toko_pengaturan`
  ADD CONSTRAINT `fk_pengaturan_toko` FOREIGN KEY (`toko_id`) REFERENCES `tb_toko` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_toko_review`
--
ALTER TABLE `tb_toko_review`
  ADD CONSTRAINT `fk_review_toko_id` FOREIGN KEY (`toko_id`) REFERENCES `tb_toko` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_review_transaksi_id` FOREIGN KEY (`transaksi_id`) REFERENCES `tb_transaksi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_review_user_id` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD CONSTRAINT `fk_transaksi_user` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tb_user_alamat`
--
ALTER TABLE `tb_user_alamat`
  ADD CONSTRAINT `fk_alamat_user` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD CONSTRAINT `fk_voucher_toko` FOREIGN KEY (`toko_id`) REFERENCES `tb_toko` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
