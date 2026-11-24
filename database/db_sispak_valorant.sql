-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2026 at 02:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sispak_valorant`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- --------------------------------------------------------

--
-- Table structure for table `tb_agent`
--

CREATE TABLE `tb_agent` (
  `kode_agent` varchar(5) NOT NULL,
  `nama_agent` varchar(50) NOT NULL,
  `role_agent` enum('Duelist','Initiator','Controller','Sentinel') NOT NULL,
  `deskripsi_singkat` text NOT NULL,
  `strategi_attack` text NOT NULL,
  `strategi_defense` text NOT NULL,
  `gambar` varchar(100) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_agent`
--

INSERT INTO `tb_agent` (`kode_agent`, `nama_agent`, `role_agent`, `deskripsi_singkat`, `strategi_attack`, `strategi_defense`, `gambar`) VALUES
('A01', 'Jett', 'Duelist', 'Duelist mobilitas tinggi yang unggul membuka ruang dan duel sniper.', 'Gunakan Cloudburst lalu Tailwind untuk masuk cepat ke site dan memecah fokus pertahanan musuh.', 'Ambil posisi off-angle agresif dengan Operator atau Sheriff, lalu dash kabur setelah mendapat kill.', 'jett.webp'),
('A02', 'Raze', 'Duelist', 'Duelist eksplosif yang efektif menghancurkan jebakan musuh dan membersihkan sudut sempit.', 'Lempar Paint Shells ke sudut persembunyian Sentinel musuh dan masuk memakai double Blast Pack.', 'Gunakan Boom Bot untuk mendeteksi push musuh di lorong sempit dan perlambat eksekusi mereka.', 'raze.webp'),
('A03', 'Reyna', 'Duelist', 'Duelist mandiri yang mengandalkan kemenangan duel 1v1 untuk bertahan hidup dan snowball.', 'Gunakan Leer untuk membutakan sudut jauh sebelum keluar chokepoint bersama rekan Initiator.', 'Mainkan posisi agresif yang memungkinkan kabur memakai Dismiss segera setelah kill pertama.', 'reyna.webp'),
('A04', 'Phoenix', 'Duelist', 'Duelist serba bisa dengan flash cepat, molly pemulih HP, dan ultimate untuk entry aman.', 'Gunakan Curveball di sudut sempit dan Run It Back untuk membuka site tanpa risiko mati permanen.', 'Tahan lorong sempit dengan Hot Hands dan manfaatkan Blaze untuk memblokir pandangan musuh.', 'phoenix.webp'),
('A05', 'Yoru', 'Duelist', 'Duelist tipu daya dengan teleportasi jarak jauh, klon pengecoh, dan flash pantul.', 'Kirim Gatecrash ke belakang pertahanan musuh dan kombinasikan Blindside untuk serangan dua arah.', 'Gunakan Fakeout untuk memancing utility musuh dan rotasi cepat antar-site memakai Gatecrash.', 'yoru.webp'),
('A06', 'Neon', 'Duelist', 'Duelist berkecepatan tinggi yang unggul mendobrak pertahanan lawan secara instan.', 'Gunakan Fast Lane untuk membelah site dan Relay Bolt untuk men-stun posisi bertahan musuh.', 'Lakukan rotasi cepat saat musuh terdeteksi dan ganggu timing eksekusi lawan dengan tembok listrik.', 'neon.webp'),
('A07', 'Iso', 'Duelist', 'Duelist petarung 1v1 dengan perisai penyerap damage dan ultimate arena duel.', 'Aktifkan Double Tap sebelum entry dan gunakan Contingency untuk maju menembus garis tembak.', 'Isolasi pemain kunci atau pembawa Spike musuh ke dalam Kill Contract saat lawan melakukan push.', 'iso.webp'),
('A08', 'Waylay', 'Duelist', 'Duelist kelincahan cahaya yang mampu menerjang masuk ruang sempit dan kembali ke titik aman.', 'Gunakan Refract dan dash cepat untuk memecah crosshair musuh di dalam site lalu kembali jika terdesak.', 'Ambil duel awal di area mid dengan jaminan bisa mundur instan menggunakan kemampuan rewind-nya.', 'waylay.webp'),
('A09', 'Sova', 'Initiator', 'Initiator pencari informasi jarak jauh dengan panah pemindai dan drone pengintai.', 'Tembakkan Recon Bolt ke dinding tinggi site untuk mengungkap posisi musuh sebelum tim entry.', 'Gunakan Owl Drone di awal ronde untuk mengecek pergerakan musuh dan tahan plant dengan Shock Dart.', 'sova.webp'),
('A10', 'KAY/O', 'Initiator', 'Initiator agresif yang mampu menonaktifkan kemampuan musuh dan memiliki flash efektif.', 'Lempar ZERO/POINT untuk menekan Sentinel musuh agar jebakan mati, lalu pop-flash untuk Duelist.', 'Gunakan pisau suppress di awal ronde untuk menggagalkan rush dan membaca jumlah penyerang.', 'kayo.webp'),
('A11', 'Breach', 'Initiator', 'Initiator pengendali area yang menembus tembok dengan efek stun dan flash.', 'Kombinasikan Fault Line dan Flashpoint untuk memaksa musuh keluar sudut saat eksekusi site.', 'Hentikan push cepat musuh di lorong sempit dengan Aftershock dan Rolling Thunder saat retake.', 'breach.webp'),
('A12', 'Skye', 'Initiator', 'Initiator pendukung dengan flash pengintai, serigala pencari info, dan pemulih HP tim.', 'Gunakan Trailblazer untuk membersihkan sudut dekat dan Guiding Light untuk membuka ruang masuk.', 'Berikan informasi rotasi musuh lewat suara konfirmasi flash dan jaga rekan tim tetap sehat.', 'skye.webp'),
('A13', 'Fade', 'Initiator', 'Initiator pelacak jejak musuh yang memberikan efek tuli dan mengikat pergerakan lawan.', 'Lempar Haunt ke atas atap site untuk menandai musuh lalu kirim Prowler menyapu sudut tersembunyi.', 'Gunakan Seize untuk menjebak penyerang di chokepoint dan kombinasikan dengan utility area tim.', 'fade.webp'),
('A14', 'Gekko', 'Initiator', 'Initiator dengan makhluk pendamping yang dapat mengambil dan memasang Spike secara mandiri.', 'Kirim Wingman untuk memasang Spike sementara tim mengawasi sudut menggunakan Dizzy dan Thrash.', 'Gunakan Dizzy untuk mendeteksi musuh dari jarak aman dan Wingman untuk melakukan defuse.', 'gekko.webp'),
('A15', 'Tejo', 'Initiator', 'Initiator taktis dengan serangan misil terarah dan drone pemindai untuk memaksa musuh pindah.', 'Arahkan Guided Salvo ke posisi bertahan populer di site agar musuh terpaksa keluar sebelum tim masuk.', 'Gunakan Stealth Drone untuk membongkar posisi lurker dan hancurkan rencana eksekusi dari jauh.', 'tejo.webp'),
('A16', 'Omen', 'Controller', 'Controller fleksibel dengan jangkauan smoke luas dan kemampuan teleportasi taktis.', 'Tutup pandangan sniper di Heaven atau CT dengan Dark Cover, lalu bantu entry memakai Paranoia.', 'Manfaatkan Shrouded Step untuk berpindah ke sudut tak terduga dan lakukan fake-smoke pengecoh.', 'omen.webp'),
('A17', 'Brimstone', 'Controller', 'Controller dengan tiga smoke instan sekaligus dan kemampuan menahan post-plant yang kuat.', 'Pasang tiga Sky Smoke serentak untuk menutup titik masuk musuh dan aktifkan Stim Beacon saat rush.', 'Tahan waktu defuse musuh dari jarak aman menggunakan Incendiary atau Orbital Strike saat post-plant.', 'brimstone.webp'),
('A18', 'Clove', 'Controller', 'Controller agresif yang tetap bisa memberikan smoke meskipun sudah tereliminasi.', 'Ikut maju di lini kedua setelah Duelist, gunakan Pick-Me-Up untuk duel, dan tetap aktifkan Ruse saat mati.', 'Bermain agresif di area mid karena kamu tetap bisa membantu rekan di site lain lewat smoke setelah tumbang.', 'clove.webp'),
('A19', 'Viper', 'Controller', 'Controller pengendali area berbasis racun yang sangat kuat membelah site besar.', 'Gunakan Toxic Screen untuk memotong garis pandang site luas dan Poison Cloud untuk menutup sudut.', 'Tahan push musuh dengan efek decay racun dan simpan Snake Bite untuk situasi post-plant.', 'viper.webp'),
('A20', 'Astra', 'Controller', 'Controller kendali global yang mampu menempatkan smoke, stun, dan tarikan gravitasi di seluruh map.', 'Pasang Stars di titik strategis sebelum eksekusi untuk memutus rotasi dan menarik musuh dari perlindungan.', 'Kendalikan tempo seluruh map dari posisi aman dan gagalkan plant musuh menggunakan Gravity Well.', 'astra.webp'),
('A21', 'Harbor', 'Controller', 'Controller pengendali air dengan dinding fleksibel yang sangat efektif untuk mendobrak site terbuka.', 'Gunakan High Tide untuk menutup banyak sudut sekaligus dan Cove sebagai pelindung saat memasang Spike.', 'Perlambat laju masuk musuh di chokepoint dengan Cascade dan manfaatkan Reckoning untuk retake.', 'harbor.webp'),
('A22', 'Cypher', 'Sentinel', 'Sentinel spesialis pengawasan area dengan perangkap kawat tersembunyi dan kamera pengintai.', 'Pasang Trapwire di jalur flank belakang tim agar aman dari sergapan musuh saat eksekusi site.', 'Kunci satu site sendirian dengan setup Trapwire dan Cyber Cage, lalu gunakan Spycam untuk info cepat.', 'cypher.webp'),
('A23', 'Killjoy', 'Sentinel', 'Sentinel pertahanan area dengan turret otomatis dan granat nanobot untuk menahan site.', 'Taruh Alarmbot di jalur rotasi belakang dan gunakan Lockdown untuk memaksa musuh meninggalkan site.', 'Bangun pertahanan berlapis menggunakan Turret dan Nanoswarm untuk menggagalkan plant Spike musuh.', 'killjoy.webp'),
('A24', 'Sage', 'Sentinel', 'Sentinel pendukung dengan kemampuan memperlambat musuh, memblokir jalur, dan memulihkan HP.', 'Gunakan Barrier Orb untuk menutup jalur rotasi musuh saat tim sedang memasang Spike di site.', 'Tutup chokepoint utama dengan tembok es di awal ronde dan gunakan Slow Orb mengulur waktu bantuan.', 'sage.webp'),
('A25', 'Chamber', 'Sentinel', 'Sentinel penembak jitu dengan senjata khusus dan teleportasi cepat untuk menjaga sudut.', 'Pasang Trademark di jalur flank dan cari eliminasi pembuka menggunakan Headhunter.', 'Tahan jalur masuk dengan Tour De Force dan langsung teleportasi ke posisi aman setelah menembak.', 'chamber.webp'),
('A26', 'Deadlock', 'Sentinel', 'Sentinel penahan rush dengan sensor suara dan jaring penghalang yang menghentikan pergerakan.', 'Gunakan Barrier Mesh untuk memotong jalur rotasi musuh dan Annihilation untuk menangkap lawan terakhir.', 'Pasang Sonic Sensor di area plant untuk menghentikan musuh yang langsung menyerbu masuk ke site.', 'deadlock.webp'),
('A27', 'Vyse', 'Sentinel', 'Sentinel pengendali medan logam yang mampu memisahkan musuh dan melucuti senjata utama lawan.', 'Gunakan Shear untuk memotong jalur bantuan musuh setelah tim masuk dan Arc Rose untuk flash tak terduga.', 'Jebak penyerang pertama di dalam site memakai dinding logam dan aktifkan Steel Garden saat musuh rush.', 'vyse.webp');

-- --------------------------------------------------------

--
-- Table structure for table `tb_aturan`
--

CREATE TABLE `tb_aturan` (
  `id_aturan` int(11) NOT NULL,
  `kode_agent` varchar(5) NOT NULL,
  `kode_kriteria` varchar(5) NOT NULL,
  `cf_pakar` decimal(3,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_aturan`
--

INSERT INTO `tb_aturan` (`id_aturan`, `kode_agent`, `kode_kriteria`, `cf_pakar`) VALUES
(1, 'A01', 'K01', 0.85),
(2, 'A01', 'K03', 0.80),
(3, 'A01', 'K05', 0.90),
(4, 'A01', 'K06', 0.90),
(5, 'A01', 'K11', 0.85),
(6, 'A01', 'K13', 0.85),
(7, 'A01', 'K17', 0.90),
(8, 'A01', 'K18', 0.90),
(9, 'A01', 'K24', 0.85),
(10, 'A02', 'K02', 0.90),
(11, 'A02', 'K04', 0.90),
(12, 'A02', 'K07', 0.85),
(13, 'A02', 'K09', 0.85),
(14, 'A02', 'K10', 0.85),
(15, 'A02', 'K12', 0.85),
(16, 'A02', 'K17', 0.90),
(17, 'A02', 'K18', 0.85),
(18, 'A02', 'K24', 0.85),
(19, 'A03', 'K01', 0.75),
(20, 'A03', 'K04', 0.80),
(21, 'A03', 'K05', 0.80),
(22, 'A03', 'K10', 0.80),
(23, 'A03', 'K11', 0.80),
(24, 'A03', 'K12', 0.80),
(25, 'A03', 'K17', 0.80),
(26, 'A03', 'K18', 0.95),
(27, 'A03', 'K24', 0.90),
(28, 'A04', 'K01', 0.80),
(29, 'A04', 'K03', 0.80),
(30, 'A04', 'K08', 0.85),
(31, 'A04', 'K10', 0.80),
(32, 'A04', 'K17', 0.80),
(33, 'A04', 'K18', 0.85),
(34, 'A04', 'K24', 0.80),
(35, 'A05', 'K02', 0.85),
(36, 'A05', 'K06', 0.85),
(37, 'A05', 'K08', 0.80),
(38, 'A05', 'K11', 0.80),
(39, 'A05', 'K17', 0.80),
(40, 'A05', 'K20', 0.85),
(41, 'A05', 'K24', 0.85),
(42, 'A06', 'K03', 0.85),
(43, 'A06', 'K07', 0.90),
(44, 'A06', 'K09', 0.85),
(45, 'A06', 'K10', 0.85),
(46, 'A06', 'K17', 0.90),
(47, 'A06', 'K18', 0.95),
(48, 'A06', 'K24', 0.80),
(49, 'A07', 'K01', 0.80),
(50, 'A07', 'K03', 0.85),
(51, 'A07', 'K05', 0.80),
(52, 'A07', 'K13', 0.80),
(53, 'A07', 'K17', 0.80),
(54, 'A07', 'K18', 0.85),
(55, 'A07', 'K24', 0.80),
(56, 'A08', 'K04', 0.85),
(57, 'A08', 'K09', 0.85),
(58, 'A08', 'K11', 0.85),
(59, 'A08', 'K12', 0.85),
(60, 'A08', 'K17', 0.85),
(61, 'A08', 'K18', 0.90),
(62, 'A08', 'K24', 0.80),
(63, 'A09', 'K01', 0.95),
(64, 'A09', 'K03', 0.85),
(65, 'A09', 'K05', 0.90),
(66, 'A09', 'K06', 0.95),
(67, 'A09', 'K11', 0.90),
(68, 'A09', 'K13', 0.90),
(69, 'A09', 'K15', 0.90),
(70, 'A09', 'K19', 0.85),
(71, 'A09', 'K23', 0.85),
(72, 'A09', 'K24', 0.85),
(73, 'A10', 'K01', 0.85),
(74, 'A10', 'K06', 0.80),
(75, 'A10', 'K08', 0.80),
(76, 'A10', 'K10', 0.80),
(77, 'A10', 'K11', 0.80),
(78, 'A10', 'K12', 0.85),
(79, 'A10', 'K15', 0.85),
(80, 'A10', 'K18', 0.75),
(81, 'A10', 'K21', 0.90),
(82, 'A10', 'K24', 0.80),
(83, 'A11', 'K02', 0.80),
(84, 'A11', 'K03', 0.85),
(85, 'A11', 'K04', 0.85),
(86, 'A11', 'K07', 0.95),
(87, 'A11', 'K09', 0.85),
(88, 'A11', 'K12', 0.85),
(89, 'A11', 'K15', 0.85),
(90, 'A11', 'K19', 0.80),
(91, 'A11', 'K21', 0.90),
(92, 'A12', 'K02', 0.85),
(93, 'A12', 'K03', 0.85),
(94, 'A12', 'K04', 0.85),
(95, 'A12', 'K08', 0.85),
(96, 'A12', 'K15', 0.85),
(97, 'A12', 'K19', 0.90),
(98, 'A12', 'K21', 0.85),
(99, 'A13', 'K04', 0.85),
(100, 'A13', 'K08', 0.85),
(101, 'A13', 'K09', 0.90),
(102, 'A13', 'K10', 0.85),
(103, 'A13', 'K15', 0.85),
(104, 'A13', 'K19', 0.80),
(105, 'A13', 'K23', 0.85),
(106, 'A14', 'K02', 0.85),
(107, 'A14', 'K05', 0.85),
(108, 'A14', 'K08', 0.90),
(109, 'A14', 'K10', 0.90),
(110, 'A14', 'K15', 0.85),
(111, 'A14', 'K19', 0.85),
(112, 'A14', 'K21', 0.80),
(113, 'A15', 'K01', 0.85),
(114, 'A15', 'K07', 0.85),
(115, 'A15', 'K09', 0.85),
(116, 'A15', 'K13', 0.85),
(117, 'A15', 'K15', 0.85),
(118, 'A15', 'K19', 0.85),
(119, 'A15', 'K23', 0.80),
(120, 'A16', 'K01', 0.90),
(121, 'A16', 'K03', 0.90),
(122, 'A16', 'K04', 0.85),
(123, 'A16', 'K09', 0.90),
(124, 'A16', 'K10', 0.90),
(125, 'A16', 'K11', 0.85),
(126, 'A16', 'K12', 0.90),
(127, 'A16', 'K13', 0.85),
(128, 'A16', 'K14', 0.90),
(129, 'A16', 'K19', 0.80),
(130, 'A16', 'K20', 0.75),
(131, 'A16', 'K22', 0.90),
(132, 'A17', 'K02', 0.95),
(133, 'A17', 'K07', 0.95),
(134, 'A17', 'K08', 0.80),
(135, 'A17', 'K14', 0.90),
(136, 'A17', 'K19', 0.85),
(137, 'A17', 'K22', 0.80),
(138, 'A18', 'K02', 0.80),
(139, 'A18', 'K04', 0.80),
(140, 'A18', 'K09', 0.85),
(141, 'A18', 'K10', 0.85),
(142, 'A18', 'K12', 0.85),
(143, 'A18', 'K14', 0.85),
(144, 'A18', 'K18', 0.85),
(145, 'A18', 'K22', 0.85),
(146, 'A19', 'K02', 0.90),
(147, 'A19', 'K05', 0.95),
(148, 'A19', 'K06', 0.95),
(149, 'A19', 'K08', 0.85),
(150, 'A19', 'K09', 0.85),
(151, 'A19', 'K14', 0.85),
(152, 'A19', 'K20', 0.90),
(153, 'A19', 'K24', 0.85),
(154, 'A20', 'K03', 0.85),
(155, 'A20', 'K04', 0.85),
(156, 'A20', 'K08', 0.90),
(157, 'A20', 'K11', 0.90),
(158, 'A20', 'K14', 0.90),
(159, 'A20', 'K19', 0.90),
(160, 'A20', 'K22', 0.85),
(161, 'A20', 'K24', 0.85),
(162, 'A21', 'K05', 0.85),
(163, 'A21', 'K06', 0.85),
(164, 'A21', 'K08', 0.85),
(165, 'A21', 'K11', 0.85),
(166, 'A21', 'K14', 0.80),
(167, 'A21', 'K19', 0.85),
(168, 'A21', 'K22', 0.80),
(169, 'A22', 'K02', 0.90),
(170, 'A22', 'K04', 0.90),
(171, 'A22', 'K06', 0.85),
(172, 'A22', 'K07', 0.85),
(173, 'A22', 'K08', 0.85),
(174, 'A22', 'K10', 0.90),
(175, 'A22', 'K11', 0.85),
(176, 'A22', 'K12', 0.90),
(177, 'A22', 'K16', 0.90),
(178, 'A22', 'K20', 0.80),
(179, 'A22', 'K23', 0.85),
(180, 'A23', 'K01', 0.95),
(181, 'A23', 'K03', 0.85),
(182, 'A23', 'K05', 0.90),
(183, 'A23', 'K08', 0.85),
(184, 'A23', 'K09', 0.90),
(185, 'A23', 'K13', 0.90),
(186, 'A23', 'K16', 0.90),
(187, 'A23', 'K20', 0.85),
(188, 'A23', 'K23', 0.80),
(189, 'A24', 'K02', 0.80),
(190, 'A24', 'K04', 0.85),
(191, 'A24', 'K05', 0.85),
(192, 'A24', 'K13', 0.80),
(193, 'A24', 'K16', 0.75),
(194, 'A24', 'K19', 0.90),
(195, 'A25', 'K03', 0.80),
(196, 'A25', 'K05', 0.80),
(197, 'A25', 'K06', 0.85),
(198, 'A25', 'K09', 0.85),
(199, 'A25', 'K16', 0.75),
(200, 'A25', 'K18', 0.90),
(201, 'A25', 'K24', 0.85),
(202, 'A26', 'K01', 0.80),
(203, 'A26', 'K02', 0.85),
(204, 'A26', 'K04', 0.80),
(205, 'A26', 'K07', 0.80),
(206, 'A26', 'K12', 0.85),
(207, 'A26', 'K16', 0.85),
(208, 'A26', 'K19', 0.85),
(209, 'A27', 'K01', 0.85),
(210, 'A27', 'K04', 0.85),
(211, 'A27', 'K09', 0.85),
(212, 'A27', 'K11', 0.85),
(213, 'A27', 'K12', 0.85),
(214, 'A27', 'K16', 0.90),
(215, 'A27', 'K20', 0.85),
(216, 'A27', 'K23', 0.80);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kriteria`
--

CREATE TABLE `tb_kriteria` (
  `kode_kriteria` varchar(5) NOT NULL,
  `kategori` enum('Map','Kebutuhan Tim','Gaya Bermain','Kondisi Party / OTP') NOT NULL,
  `pertanyaan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_kriteria`
--

INSERT INTO `tb_kriteria` (`kode_kriteria`, `kategori`, `pertanyaan`) VALUES
('K01', 'Map', 'Ascent'),
('K02', 'Map', 'Bind'),
('K03', 'Map', 'Haven'),
('K04', 'Map', 'Split'),
('K05', 'Map', 'Icebox'),
('K06', 'Map', 'Breeze'),
('K07', 'Map', 'Fracture'),
('K08', 'Map', 'Pearl'),
('K09', 'Map', 'Lotus'),
('K10', 'Map', 'Sunset'),
('K11', 'Map', 'Abyss'),
('K12', 'Map', 'Corrode'),
('K13', 'Map', 'Summit'),
('K14', 'Kebutuhan Tim', 'Tim belum memiliki Controller (Smoker penutup pandangan lawan)'),
('K15', 'Kebutuhan Tim', 'Tim belum memiliki Initiator (pencari info posisi lawan / flash)'),
('K16', 'Kebutuhan Tim', 'Tim belum memiliki Sentinel (penjaga flank & penahan push musuh)'),
('K17', 'Kebutuhan Tim', 'Tim kekurangan Duelist (pembuka ruang masuk site / entry fragger)'),
('K18', 'Gaya Bermain', 'Saya suka bermain Agresif (duel cepat, entry pertama, atau ambil off-angle)'),
('K19', 'Gaya Bermain', 'Saya suka bermain Support / Backline (membantu tim lewat smoke, heal, atau recon)'),
('K20', 'Gaya Bermain', 'Saya suka bermain Taktis / Lurker (menjaga flank, membaca rotasi, dan setup jebakan)'),
('K21', 'Kondisi Party / OTP', 'Rekan party mengunci OTP Reyna / Iso (Duelist minim utility pembuka site)'),
('K22', 'Kondisi Party / OTP', 'Rekan party mengunci OTP Jett / Raze (Duelist mobilitas tinggi butuh smoke cepat)'),
('K23', 'Kondisi Party / OTP', 'Rekan party mengunci OTP Chamber (Sentinel minim jebakan flank & info area)'),
('K24', 'Kondisi Party / OTP', 'Saya sendiri sangat menguasai mekanik/lineup Agent role ini (Comfort Pick)');

-- --------------------------------------------------------

--
-- Table structure for table `tb_riwayat`
--

CREATE TABLE `tb_riwayat` (
  `id_riwayat` int(11) NOT NULL,
  `nama_pemain` varchar(50) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `agent_terpilih` varchar(50) NOT NULL,
  `nilai_cf` decimal(5,2) NOT NULL,
  `detail_input` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`detail_input`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_riwayat`
--

INSERT INTO `tb_riwayat` (`id_riwayat`, `nama_pemain`, `tanggal`, `agent_terpilih`, `nilai_cf`, `detail_input`) VALUES
(1, 'Sylph', '2026-11-24 14:35:13', 'Reyna', 99.88, '{\"K15\":\"0.4\",\"K16\":\"0.6\",\"K18\":\"1.0\",\"K20\":\"0.8\",\"K22\":\"1.0\",\"K24\":\"1.0\",\"K01\":1}'),
(2, 'Sylvie', '2026-11-24 14:43:34', 'Neon', 99.93, '{\"K17\":\"1.0\",\"K18\":\"1.0\",\"K23\":\"0.6\",\"K09\":1}'),
(3, 'sylviee', '2026-11-24 15:21:23', 'Killjoy', 99.64, '{\"K15\":\"0.6\",\"K16\":\"1.0\",\"K18\":\"0.6\",\"K23\":\"0.8\",\"K13\":1}'),
(4, 'sylviee', '2026-11-24 15:27:56', 'Killjoy', 99.64, '{\"K15\":\"0.6\",\"K16\":\"1.0\",\"K18\":\"0.6\",\"K23\":\"0.8\",\"K13\":1}'),
(5, 'sylviee', '2026-11-24 15:32:21', 'Killjoy', 99.64, '{\"K15\":\"0.6\",\"K16\":\"1.0\",\"K18\":\"0.6\",\"K23\":\"0.8\",\"K13\":1}'),
(6, 'sylviee', '2026-11-24 15:33:49', 'Killjoy', 99.64, '{\"K15\":\"0.6\",\"K16\":\"1.0\",\"K18\":\"0.6\",\"K23\":\"0.8\",\"K13\":1}'),
(7, 'sylviee', '2026-11-24 15:38:27', 'Killjoy', 99.64, '{\"K15\":\"0.6\",\"K16\":\"1.0\",\"K18\":\"0.6\",\"K23\":\"0.8\",\"K13\":1}'),
(8, 'sylviee', '2026-11-24 15:41:08', 'Killjoy', 99.64, '{\"K15\":\"0.6\",\"K16\":\"1.0\",\"K18\":\"0.6\",\"K23\":\"0.8\",\"K13\":1}'),
(9, 'sylviee', '2026-11-24 15:43:43', 'Killjoy', 99.64, '{\"K15\":\"0.6\",\"K16\":\"1.0\",\"K18\":\"0.6\",\"K23\":\"0.8\",\"K13\":1}'),
(10, 'sylviee', '2026-11-24 15:44:01', 'Killjoy', 99.64, '{\"K15\":\"0.6\",\"K16\":\"1.0\",\"K18\":\"0.6\",\"K23\":\"0.8\",\"K13\":1}'),
(11, 'sylviee', '2026-11-24 15:44:42', 'Killjoy', 99.64, '{\"K15\":\"0.6\",\"K16\":\"1.0\",\"K18\":\"0.6\",\"K23\":\"0.8\",\"K13\":1}'),
(12, 'sylviee', '2026-11-24 15:45:11', 'Killjoy', 99.64, '{\"K15\":\"0.6\",\"K16\":\"1.0\",\"K18\":\"0.6\",\"K23\":\"0.8\",\"K13\":1}'),
(13, 'sylviee', '2026-11-24 15:47:50', 'Killjoy', 99.64, '{\"K15\":\"0.6\",\"K16\":\"1.0\",\"K18\":\"0.6\",\"K23\":\"0.8\",\"K13\":1}'),
(14, 'Naeva', '2026-11-24 15:57:34', 'Sova', 99.52, '{\"K16\":\"0.6\",\"K17\":\"0.4\",\"K19\":\"0.8\",\"K21\":\"1.0\",\"K22\":\"1.0\",\"K24\":\"1.0\",\"K05\":1}'),
(15, 'Naeva', '2026-11-24 15:59:30', 'Sova', 99.52, '{\"K16\":\"0.6\",\"K17\":\"0.4\",\"K19\":\"0.8\",\"K21\":\"1.0\",\"K22\":\"1.0\",\"K24\":\"1.0\",\"K05\":1}'),
(16, 'Mahiru', '2026-11-24 16:33:53', 'Cypher', 98.54, '{\"K14\":\"0.4\",\"K16\":\"0.8\",\"K20\":\"0.6\",\"K24\":\"1.0\",\"K12\":1}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tb_agent`
--
ALTER TABLE `tb_agent`
  ADD PRIMARY KEY (`kode_agent`);

--
-- Indexes for table `tb_aturan`
--
ALTER TABLE `tb_aturan`
  ADD PRIMARY KEY (`id_aturan`),
  ADD KEY `kode_agent` (`kode_agent`),
  ADD KEY `kode_kriteria` (`kode_kriteria`);

--
-- Indexes for table `tb_kriteria`
--
ALTER TABLE `tb_kriteria`
  ADD PRIMARY KEY (`kode_kriteria`);

--
-- Indexes for table `tb_riwayat`
--
ALTER TABLE `tb_riwayat`
  ADD PRIMARY KEY (`id_riwayat`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_aturan`
--
ALTER TABLE `tb_aturan`
  MODIFY `id_aturan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT for table `tb_riwayat`
--
ALTER TABLE `tb_riwayat`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_aturan`
--
ALTER TABLE `tb_aturan`
  ADD CONSTRAINT `tb_aturan_ibfk_1` FOREIGN KEY (`kode_agent`) REFERENCES `tb_agent` (`kode_agent`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_aturan_ibfk_2` FOREIGN KEY (`kode_kriteria`) REFERENCES `tb_kriteria` (`kode_kriteria`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
