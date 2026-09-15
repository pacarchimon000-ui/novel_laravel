-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 07 Sep 2026 pada 19.27
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `novelku`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `novel_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bookmarks`
--

INSERT INTO `bookmarks` (`id`, `user_id`, `novel_id`, `created_at`, `updated_at`) VALUES
(1, 3, 3, '2026-09-02 00:08:51', '2026-09-02 00:08:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `chapters`
--

CREATE TABLE `chapters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `novel_id` bigint(20) UNSIGNED NOT NULL,
  `chapter_number` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `views` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `is_premium` tinyint(1) NOT NULL DEFAULT 0,
  `coin_price` int(10) UNSIGNED NOT NULL DEFAULT 5,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `chapters`
--

INSERT INTO `chapters` (`id`, `novel_id`, `chapter_number`, `title`, `content`, `views`, `is_premium`, `coin_price`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Pemuda Dari Desa Kabut', 'Desa Kabut selalu diselimuti oleh kabut tebal setiap pagi. Lu Feng, seorang pemuda berusia 17 tahun, berjalan menyusuri jalanan berbatu sambil memikul seikat kayu bakar.\n\nHari itu seperti hari-hari biasanya, sampai suara gemuruh dahsyat terdengar dari puncak Gunung Salju Hitam. Suara itu begitu mengerikan hingga membuat burung-burung di hutan terbang berhamburan.\n\n\"Apa yang terjadi di atas sana?\" gumam Lu Feng penasaran. Tanpa ragu, ia membulatkan tekad untuk mendaki gunung yang dikenal angker tersebut.\n\nSetibanya di dekat puncak, tanah tempatnya berdiri runtuh! Lu Feng jatuh ke dalam sebuah goa bawah tanah. Di tengah goa yang remang-remang itu, memancar sinar biru keemasan. Sebuah pedang tua tertancap di atas batu kristal hitam.\n\nSaat jemari Lu Feng menyentuh gagang pedang tersebut, arus energi purba yang sangat dahsyat mengalir deras ke dalam dadanya. Takdirnya telah berubah selamanya.', 233, 0, 5, NULL, '2026-09-02 00:04:20', '2026-09-04 12:51:34'),
(2, 1, 2, 'Sinar Pedang Pertama', 'Energi misterius dari pedang itu memasuki tubuh Lu Feng, menyatukan meridian darahnya yang dulu tersumbat. Rasa sakit bagai terbakar api membakar seluruh tubuhnya sebelum berganti menjadi kehangatan yang luar biasa.\n\nPedang tua itu perlahan terlepas dari batu kristal. Ukiran naga kuno di bilahnya menyala terang.\n\n\"Apakah ini... Senjata Pusaka Kuno?\" bisik Lu Feng terperanjat.\n\nTiba-tiba dari kegelapan goa, muncul sepasang mata merah menyala. Seekor Serigala Bayangan bertanduk satu merayap keluar, mengincar darah pemuda itu.\n\nLu Feng tidak punya waktu untuk takut. Ia mengayunkan pedang barunya secara refleks. Cahaya tebasan berwarna keemasan melintas, membelah kegelapan goa dan memotong sang monster dalam satu gerakan cepat!\n\nPedang Langit telah terbangun, dan kisah Lu Feng baru saja dimulai.', 224, 0, 5, NULL, '2026-09-02 00:04:20', '2026-09-04 12:43:39'),
(3, 2, 1, 'Kedai Kopi Pukul Lima', 'Aroma biji kopi arabika yang diseduh mengisi seluruh sudut Kedai Senja. Maya duduk di sudut favoritnya dekat jendela besar, seperti yang selalu dilakukannya setiap hari Senin hingga Jumat.\n\nDi meja seberang, ada Rehan. Pemuda itu selalu memesan Americano dingin tanpa gula dan sibuk dengan laptopnya. Mereka berdua telah menjadi \'orang asing yang akrab\' selama lebih dari enam bulan.\n\nHari itu, hujan turun sangat deras. Angin kencang bertiup merusak payung milik Maya saat ia mencoba melangkah keluar dari kedai. Rehan yang berada di belakangnya menahan pintu dan menyodorkan payung lipat miliknya.\n\n\"Gunakan payung ini. Kita bisa jalan bareng sampai stasiun,\" ucap Rehan dengan senyum tipis. Hati Maya mendadak berdesir cepat.', 145, 0, 5, NULL, '2026-09-02 00:04:20', '2026-09-02 00:04:20'),
(4, 3, 1, 'Malam Hilangnya Lukisan', 'Sirine polisi meraung-raung melintasi jalanan kota yang basah oleh hujan malam. Gedung Museum Seni Nasional telah dikepung oleh puluhan petugas.\n\nArya melangkah masuk melewati garis polisi. Di ruang pameran utama, bingkai emas lukisan \'Matahari Merah\' tampak kosong melompong. Kaca pelindung tidak retak, alarm tidak berbunyi, dan kamera pengawas hanya merekam rekaman kosong selama 3 menit.\n\n\"Tidak ada sidik jari, tidak ada jejak kaki,\" bisik Asisten Tania. \"Bagaimana mungkin seseorang mengambil lukisan berukuran 2 meter dalam waktu 3 menit tanpa memicu alarm?\"\n\nArya berlutut di depan bingkai. Ia mengambil sebaris jamur berspora biru muda yang menempel tipis di sudut bawah bingkai.\n\n\"Pencurinya tidak masuk dari pintu atau jendela... dia sudah berada di dalam ruangan ini sejak awal,\" kata Arya dengan pandangan tajam.', 245, 0, 5, NULL, '2026-09-02 00:04:20', '2026-09-02 00:04:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `chapter_unlocks`
--

CREATE TABLE `chapter_unlocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `chapter_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `coin_transactions`
--

CREATE TABLE `coin_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(255) NOT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `snap_token` varchar(255) DEFAULT NULL,
  `package_code` varchar(255) NOT NULL,
  `coins` int(10) UNSIGNED NOT NULL,
  `amount` int(10) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'paid',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `coin_transactions`
--

INSERT INTO `coin_transactions` (`id`, `user_id`, `reference`, `order_id`, `snap_token`, `package_code`, `coins`, `amount`, `status`, `paid_at`, `created_at`, `updated_at`) VALUES
(2, 5, 'TOPUP-GGPF7VXT96CT45IL', NULL, NULL, 'starter', 50, 5000, 'paid', NULL, '2026-09-06 19:11:50', '2026-09-06 19:11:50'),
(3, 1, 'TOPUP-OPLRYYT3KBGZOWTB', 'TOPUP-OPLRYYT3KBGZOWTB', NULL, 'starter', 50, 5000, 'pending', NULL, '2026-09-07 09:27:06', '2026-09-07 09:27:06'),
(4, 5, 'TOPUP-79ZUXVZEC7RJIPF1', 'TOPUP-79ZUXVZEC7RJIPF1', NULL, 'starter', 50, 5000, 'pending', NULL, '2026-09-07 09:47:50', '2026-09-07 09:47:50'),
(5, 5, 'TOPUP-6DQVS9NSIP7KOP5C', 'TOPUP-6DQVS9NSIP7KOP5C', NULL, 'starter', 50, 5000, 'pending', NULL, '2026-09-07 09:49:52', '2026-09-07 09:49:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `chapter_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `follows`
--

CREATE TABLE `follows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `follower_id` bigint(20) UNSIGNED NOT NULL,
  `following_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `likes`
--

CREATE TABLE `likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `novel_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `novel_id`, `created_at`, `updated_at`) VALUES
(1, 3, 3, '2026-09-02 00:08:49', '2026-09-02 00:08:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_08_12_112624_add_role_to_users_table', 1),
(5, '2026_08_12_112625_create_novels_table', 1),
(6, '2026_08_12_112626_create_chapters_table', 1),
(7, '2026_08_12_112627_create_bookmarks_table', 1),
(8, '2026_08_12_112628_create_likes_table', 1),
(9, '2026_08_12_112629_create_comments_table', 1),
(10, '2026_08_12_114053_create_reading_histories_table', 1),
(11, '2026_08_12_114054_create_ratings_table', 1),
(12, '2026_08_13_000001_add_platform_features', 1),
(13, '2026_08_31_152834_create_reports_table', 1),
(14, '2026_09_05_000001_create_coin_transactions_table', 2),
(15, '2026_09_05_000001_add_writer_application_details_to_users_table', 3),
(16, '2026_09_05_000002_add_writer_rejection_reason_to_users_table', 3),
(17, '2026_09_07_000001_add_midtrans_fields_to_coin_transactions_table', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('26496e39-6ea3-493e-b095-649dd0c266ef', 'App\\Notifications\\WriterRequestNotification', 'App\\Models\\User', 1, '{\"type\":\"writer_request\",\"user_id\":4,\"user_name\":\"asep\",\"message\":\"Pengajuan menjadi penulis baru dari asep\"}', '2026-09-04 12:50:43', '2026-09-04 11:50:22', '2026-09-04 12:50:43'),
('2f4f2672-4607-4c42-bb66-fc964c0d725a', 'App\\Notifications\\WriterStatusNotification', 'App\\Models\\User', 5, '{\"type\":\"writer_status\",\"user_id\":5,\"status\":\"rejected\",\"reason\":\"gamauahkamu\",\"message\":\"Pengajuan Anda sebagai penulis ditolak.\"}', '2026-09-06 18:57:08', '2026-09-06 18:56:27', '2026-09-06 18:57:08'),
('5431d1e0-b240-4e0f-ba17-778fbf677abe', 'App\\Notifications\\WriterStatusNotification', 'App\\Models\\User', 6, '{\"type\":\"writer_status\",\"user_id\":6,\"status\":\"rejected\",\"reason\":\"Perbaiki ya\",\"message\":\"Pengajuan Anda sebagai penulis ditolak.\"}', '2026-09-04 13:45:16', '2026-09-04 13:44:58', '2026-09-04 13:45:16'),
('5aaa63f1-edf3-4a12-9953-62c727d55055', 'App\\Notifications\\WriterRequestNotification', 'App\\Models\\User', 1, '{\"type\":\"writer_request\",\"user_id\":6,\"user_name\":\"percobaan pengajuan\",\"message\":\"Pengajuan menjadi penulis baru dari percobaan pengajuan\"}', '2026-09-07 09:28:01', '2026-09-04 13:45:27', '2026-09-07 09:28:01'),
('64354c66-be99-4cdb-bbb9-1f446848a9a8', 'App\\Notifications\\WriterRequestNotification', 'App\\Models\\User', 1, '{\"type\":\"writer_request\",\"user_id\":5,\"user_name\":\"Sebastian Botu\",\"message\":\"Pengajuan menjadi penulis baru dari Sebastian Botu\"}', '2026-09-07 09:28:01', '2026-09-04 13:40:30', '2026-09-07 09:28:01'),
('70d3924a-c1a6-4fe3-a199-c487e4bcca1b', 'App\\Notifications\\WriterRequestNotification', 'App\\Models\\User', 1, '{\"type\":\"writer_request\",\"user_id\":6,\"user_name\":\"percobaan pengajuan\",\"message\":\"Pengajuan menjadi penulis baru dari percobaan pengajuan\"}', '2026-09-07 09:28:01', '2026-09-04 13:44:05', '2026-09-07 09:28:01'),
('7ab55769-e24b-45b8-9811-a8900b1b9446', 'App\\Notifications\\WriterStatusNotification', 'App\\Models\\User', 4, '{\"type\":\"writer_status\",\"user_id\":4,\"status\":\"rejected\",\"message\":\"Pengajuan Anda sebagai penulis ditolak.\"}', '2026-09-04 13:18:46', '2026-09-04 13:18:30', '2026-09-04 13:18:46'),
('d2d765f0-d183-463d-b8e8-255965334697', 'App\\Notifications\\WriterStatusNotification', 'App\\Models\\User', 5, '{\"type\":\"writer_status\",\"user_id\":5,\"status\":\"rejected\",\"reason\":\"kasih alasan yang jelas\",\"message\":\"Pengajuan Anda sebagai penulis ditolak.\"}', '2026-09-06 19:02:13', '2026-09-06 19:01:48', '2026-09-06 19:02:13'),
('d598bc2b-c47e-4af9-9e50-081500582eee', 'App\\Notifications\\WriterStatusNotification', 'App\\Models\\User', 3, '{\"type\":\"writer_status\",\"user_id\":3,\"status\":\"approved\",\"message\":\"Pengajuan Anda sebagai penulis telah disetujui.\"}', '2026-09-02 00:18:07', '2026-09-02 00:16:34', '2026-09-02 00:18:07'),
('e4bee59a-9867-4c30-b66f-c392ff3ce5d4', 'App\\Notifications\\WriterRequestNotification', 'App\\Models\\User', 1, '{\"type\":\"writer_request\",\"user_id\":5,\"user_name\":\"Sebastian Botu\",\"message\":\"Pengajuan menjadi penulis baru dari Sebastian Botu\"}', '2026-09-07 09:28:00', '2026-09-06 19:01:11', '2026-09-07 09:28:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `novels`
--

CREATE TABLE `novels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `synopsis` text NOT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `genre` varchar(255) NOT NULL,
  `status` enum('ongoing','completed') NOT NULL DEFAULT 'ongoing',
  `approval_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'approved',
  `views` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `novels`
--

INSERT INTO `novels` (`id`, `user_id`, `title`, `slug`, `synopsis`, `cover`, `genre`, `status`, `approval_status`, `views`, `created_at`, `updated_at`) VALUES
(1, 1, 'Legenda Pedang Langit', 'legenda-pedang-langit', 'Di benua Benua Awan Timur, seorang pemuda desa bernama Lu Feng menemukan sebuah pedang misterius yang tertanam di puncak gunung salju. Tanpa disadarinya, pedang tersebut adalah ciptaan kuno dari Para Dewa Langit yang telah lama punah. Petualangan besar menembus berbagai sekte pedang dan bahaya kegelapan pun dimulai!', NULL, 'Fantasy', 'ongoing', 'approved', 1248, '2026-09-02 00:04:20', '2026-09-04 12:51:35'),
(2, 1, 'Kencan di Ujung Senja', 'kencan-di-ujung-senja', 'Maya dan Rehan selalu bertemu di kedai kopi tua yang sama setiap pukul 5 sore. Namun, mereka tidak pernah saling menyapa hingga suatu hari hujan deras memaksa mereka berbagi satu payung yang sama.', NULL, 'Romance', 'completed', 'approved', 851, '2026-09-02 00:04:20', '2026-09-04 12:58:57'),
(3, 1, 'Detektif Bayangan: Jejak Yang Hilang', 'detektif-bayangan-jejak-yang-hilang', 'Sebuah lukisan ternama hilang dari museum kota tanpa merusak segel pengaman sama sekali. Detektif Arya dipanggil untuk memecahkan kasus yang disebut-sebut melibatkan sihir atau ilusi sempurna.', NULL, 'Mystery', 'ongoing', 'approved', 2103, '2026-09-02 00:04:20', '2026-09-02 00:08:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('admin@novelku.com', '$2y$12$mZIb0ofrkUlQmSfPsyrPwuXgP832b6qNfa0rBRcjnRtz23lZ0mjSG', '2026-09-02 00:11:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `novel_id` bigint(20) UNSIGNED NOT NULL,
  `stars` tinyint(3) UNSIGNED NOT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `reading_histories`
--

CREATE TABLE `reading_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `novel_id` bigint(20) UNSIGNED NOT NULL,
  `chapter_id` bigint(20) UNSIGNED NOT NULL,
  `progress_percent` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reading_histories`
--

INSERT INTO `reading_histories` (`id`, `user_id`, `novel_id`, `chapter_id`, `progress_percent`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 0, '2026-09-02 00:13:50', '2026-09-02 00:13:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(255) NOT NULL,
  `status` enum('pending','resolved','dismissed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','user','writer') NOT NULL DEFAULT 'user',
  `writer_status` varchar(255) NOT NULL DEFAULT 'not_requested',
  `bio` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `coins` int(10) UNSIGNED NOT NULL DEFAULT 50,
  `api_token` varchar(80) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `writer_application_email` varchar(255) DEFAULT NULL,
  `writer_application_motivation` text DEFAULT NULL,
  `writer_application_experience` text DEFAULT NULL,
  `writer_application_genre` varchar(255) DEFAULT NULL,
  `writer_rejection_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `writer_status`, `bio`, `avatar`, `coins`, `api_token`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `writer_application_email`, `writer_application_motivation`, `writer_application_experience`, `writer_application_genre`, `writer_rejection_reason`) VALUES
(1, 'Admin NovelKu', 'admin@novelku.com', 'admin', 'not_requested', 'Pengelola utama NovelKu.', NULL, 50, NULL, NULL, '$2y$12$JFVIlj4ek.nY.Ce2QIoUYODwSpK9N3pYuFVAb6E9QhzkJSgdu1Ng6', 'FrID8Ljcmrr3ZE3B0PIChlGfooCOSwyruU4QR8O9FucHaH3ieQUaNT6xJO6J', '2026-09-02 00:04:19', '2026-09-02 00:04:19', NULL, NULL, NULL, NULL, NULL),
(2, 'Pembaca Setia', 'user@novelku.com', 'user', 'not_requested', 'Suka membaca cerita fantasi dan misteri.', NULL, 50, NULL, NULL, '$2y$12$d4Oap3sEU1Bdl6TN3dwJbeLiC6W6lMmZJmWm/HALtOCCMFZ7S/yT2', NULL, '2026-09-02 00:04:20', '2026-09-02 00:04:20', NULL, NULL, NULL, NULL, NULL),
(3, 'bastian', 'babas@gmail.com', 'writer', 'approved', NULL, NULL, 50, NULL, NULL, '$2y$12$5UfXwm6EE.AD4Pj8fIA2eOllH1fFRiMA3qQqSI3DRmnjBI7A4T9L2', NULL, '2026-09-02 00:08:17', '2026-09-02 00:16:34', NULL, NULL, NULL, NULL, NULL),
(5, 'Sebastian Botu', 'sebastian@gmail.com', 'user', 'rejected', NULL, NULL, 100, NULL, NULL, '$2y$12$EVECGakBv.xdCWsckjdSxuvnlXujLlq/MRbOVPJQygJVBLOn43mCi', NULL, '2026-09-04 13:38:08', '2026-09-06 19:11:50', 'sebastian@gmail.com', 'Karna saya mempunyai bakat dibidang tersebut', 'banyakhahshshsh', 'romance', 'kasih alasan yang jelas'),
(6, 'percobaan pengajuan', 'susbsbsj@gmail.com', 'user', 'pending', NULL, NULL, 50, NULL, NULL, '$2y$12$.7JVbpB0rJvRQMw0I33IUu1c/8CsCxklrvzgFbmZr2d.Uoq6SEctq', NULL, '2026-09-04 13:43:25', '2026-09-04 13:45:27', 'susbsbsj@gmail.com', 'hshsjsnnsndbdhdjdjdj', 'bsbbsnsbsbdbdb', 'hdhdjsnd', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookmarks_user_id_novel_id_unique` (`user_id`,`novel_id`),
  ADD KEY `bookmarks_novel_id_foreign` (`novel_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chapters_novel_id_chapter_number_unique` (`novel_id`,`chapter_number`);

--
-- Indeks untuk tabel `chapter_unlocks`
--
ALTER TABLE `chapter_unlocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chapter_unlocks_user_id_chapter_id_unique` (`user_id`,`chapter_id`),
  ADD KEY `chapter_unlocks_chapter_id_foreign` (`chapter_id`);

--
-- Indeks untuk tabel `coin_transactions`
--
ALTER TABLE `coin_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coin_transactions_reference_unique` (`reference`),
  ADD UNIQUE KEY `coin_transactions_order_id_unique` (`order_id`),
  ADD KEY `coin_transactions_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_chapter_id_foreign` (`chapter_id`),
  ADD KEY `comments_parent_id_foreign` (`parent_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `follows_follower_id_following_id_unique` (`follower_id`,`following_id`),
  ADD KEY `follows_following_id_foreign` (`following_id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `likes_user_id_novel_id_unique` (`user_id`,`novel_id`),
  ADD KEY `likes_novel_id_foreign` (`novel_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indeks untuk tabel `novels`
--
ALTER TABLE `novels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `novels_slug_unique` (`slug`),
  ADD KEY `novels_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ratings_user_id_novel_id_unique` (`user_id`,`novel_id`),
  ADD KEY `ratings_novel_id_foreign` (`novel_id`);

--
-- Indeks untuk tabel `reading_histories`
--
ALTER TABLE `reading_histories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reading_histories_user_id_novel_id_unique` (`user_id`,`novel_id`),
  ADD KEY `reading_histories_novel_id_foreign` (`novel_id`),
  ADD KEY `reading_histories_chapter_id_foreign` (`chapter_id`);

--
-- Indeks untuk tabel `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_user_id_foreign` (`user_id`),
  ADD KEY `reports_comment_id_foreign` (`comment_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_api_token_unique` (`api_token`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `chapter_unlocks`
--
ALTER TABLE `chapter_unlocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `coin_transactions`
--
ALTER TABLE `coin_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `follows`
--
ALTER TABLE `follows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `novels`
--
ALTER TABLE `novels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `reading_histories`
--
ALTER TABLE `reading_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_novel_id_foreign` FOREIGN KEY (`novel_id`) REFERENCES `novels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookmarks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `chapters_novel_id_foreign` FOREIGN KEY (`novel_id`) REFERENCES `novels` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `chapter_unlocks`
--
ALTER TABLE `chapter_unlocks`
  ADD CONSTRAINT `chapter_unlocks_chapter_id_foreign` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chapter_unlocks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `coin_transactions`
--
ALTER TABLE `coin_transactions`
  ADD CONSTRAINT `coin_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_chapter_id_foreign` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_follower_id_foreign` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `follows_following_id_foreign` FOREIGN KEY (`following_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_novel_id_foreign` FOREIGN KEY (`novel_id`) REFERENCES `novels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `novels`
--
ALTER TABLE `novels`
  ADD CONSTRAINT `novels_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_novel_id_foreign` FOREIGN KEY (`novel_id`) REFERENCES `novels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reading_histories`
--
ALTER TABLE `reading_histories`
  ADD CONSTRAINT `reading_histories_chapter_id_foreign` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reading_histories_novel_id_foreign` FOREIGN KEY (`novel_id`) REFERENCES `novels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reading_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
