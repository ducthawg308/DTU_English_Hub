-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 10, 2025 lúc 03:35 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `daily_dictation`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `audios`
--

CREATE TABLE `audios` (
  `id` int(11) NOT NULL,
  `listening_id` int(11) NOT NULL,
  `audio` varchar(255) NOT NULL,
  `answer_correct` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `audios`
--

INSERT INTO `audios` (`id`, `listening_id`, `audio`, `answer_correct`) VALUES
(2, 22, 't0g0MrfTfIdb6p1xRcTsRsc541DoUt1W2d64Sqcw.mp3', 'Today is November 26th.'),
(3, 22, 'AjvYVKqqcs2xggNi7KzBtlChBFU4FsSFc5LtAhiA.mp3', 'The snow is beautiful.'),
(4, 22, 'nVzBHavPr6tHTdtNy6Hma6MvjIajP7cWgakUrHNM.mp3', 'The snow finally stopped.'),
(5, 22, 'Pv7GdCxjamCunTuaUp8vOEiFzUHB1cJujfiE4o7r.mp3', 'My sister and I are excited.'),
(6, 22, 'oh8rSWx85KPYnlyIU03LIuUVYHBMnMJi3VpeEgJ1.mp3', 'My mom doesn\'t like the snow.'),
(7, 22, 'qjERVvTOmB9d0RjGJQiCj7AvYkMcFhjHjcL35CCF.mp3', 'My mom has to shovel the driveway.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
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
-- Cấu trúc bảng cho bảng `levels`
--

CREATE TABLE `levels` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `levels`
--

INSERT INTO `levels` (`id`, `name`) VALUES
(1, 'Easy'),
(2, 'Medium'),
(3, 'Hard');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `listening_exercises`
--

CREATE TABLE `listening_exercises` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `listening_exercises`
--

INSERT INTO `listening_exercises` (`id`, `topic_id`, `title`) VALUES
(22, 7, '1. First snowfall'),
(23, 7, '2. Jessica\'s first day of school'),
(24, 7, '3. My flower garden'),
(25, 7, '4. Going camping'),
(26, 7, '5. My house'),
(27, 7, '6. My first pet'),
(28, 7, '7. Jennifer the firefighter'),
(29, 7, '8. Mark\'s big game'),
(30, 7, '9. The Easter Egg Hunt'),
(32, 6, '1. At home (1)'),
(33, 6, '2. At home (2)'),
(34, 6, '3. My Favorite Photographs (1)'),
(35, 6, '4. Location'),
(36, 6, '5. Location (2)'),
(37, 6, '6. Color (1)'),
(38, 6, '7. Color (2)'),
(39, 6, '8. No questions'),
(40, 6, '9. Short Answer'),
(41, 6, '10. Telephone call (2)');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_19_040311_create_role_table', 2),
(6, '2024_11_19_040536_add_role_id_to_users_table', 3),
(8, '2024_11_22_112147_add_soft_delete_to_users', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('ducthangofficial@gmail.com', '$2y$10$bE8.osJBBQd8cBgqe56O3eB/F1YHeYhf8J30tyJ5fmJk8QCVlQ7jC', '2025-01-09 17:26:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `purchased_exercises`
--

CREATE TABLE `purchased_exercises` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `topic_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `order_info` varchar(255) NOT NULL,
  `purchase_date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `purchased_exercises`
--

INSERT INTO `purchased_exercises` (`id`, `user_id`, `topic_id`, `price`, `order_info`, `purchase_date`, `status`) VALUES
(11, 18, 6, 200000, 'Thanh toan khoa hoc co id: 6', '2024-12-06 10:53:08', 1),
(12, 28, 7, 599000, 'Thanh toan khoa hoc co id: 7', '2024-12-09 10:15:09', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, NULL),
(2, 'user', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_less` int(11) NOT NULL,
  `desc` text NOT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `topics`
--

INSERT INTO `topics` (`id`, `level_id`, `name`, `total_less`, `desc`, `price`) VALUES
(5, 1, 'Numbers', 9, 'Dictation is a method to learn languages by listening and writing down what you hear. It is a highly effective method!', 399000),
(6, 2, 'Conversations', 100, 'This website contains hundreds of dictation exercises to help English learners practice easily and improve quickly.', 200000),
(7, 2, 'Short Stories', 289, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 599000),
(8, 3, 'TOEIC Listening', 640, 'when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `topic_vocabularys`
--

CREATE TABLE `topic_vocabularys` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `topic_vocabularys`
--

INSERT INTO `topic_vocabularys` (`id`, `user_id`, `name`) VALUES
(6, 18, 'Education'),
(7, 18, 'Environment'),
(8, 18, 'Health'),
(9, 18, 'Family'),
(10, 18, 'Travel'),
(11, 18, 'Technology'),
(12, 18, 'Sports'),
(13, 18, 'Music'),
(14, 18, 'Weather'),
(15, 18, 'Study & Work'),
(20, 28, 'Thang'),
(21, 28, 'People'),
(22, 28, 'sadsdas');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `type_vocabularys`
--

CREATE TABLE `type_vocabularys` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `type_vocabularys`
--

INSERT INTO `type_vocabularys` (`id`, `name`) VALUES
(1, 'Noun'),
(2, 'Verb'),
(3, 'Adjective'),
(4, 'Adverb'),
(5, 'Preposition'),
(6, 'Conjunction'),
(7, 'Interjection'),
(8, 'Pronoun'),
(9, 'Determiner');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role_id`, `deleted_at`) VALUES
(18, 'Nguyen Duc Thang', 'ducthangofficial@gmail.com', '2024-11-21 03:32:29', '$2y$10$LyYw/ExrpnqZ4nDt4m4.w.rhWg7k21RLIGmy2e6Zte8vzQu9tcql.', 'nia9t35K0lvBDEmzKvJWWuOUqKSEiZLtW3xrctIzhhqvVJbC3lAnLKW0O67J', '2024-11-21 03:32:09', '2024-11-22 03:03:37', 1, NULL),
(21, 'Hoang Thi Loan', 'ducthangofficidasdasal@gmail.com', NULL, '$2y$10$9N91zEGMmsYiMvEe.wvxi.znAedGecAAWtl0owtwiSnirc9y.JzT6', NULL, '2024-11-21 03:53:14', '2024-11-22 05:23:17', 2, NULL),
(27, 'Nguyễn Văn Linh', 'ducthangofficialchatgpt@gmail.com', NULL, '$2y$10$D2NyF8XAj4BFfdzMsaEGFuxIe7GSSEvU2NRpygVEk1nhLFI/6V9Hm', NULL, '2024-11-22 05:43:40', '2024-11-24 00:27:07', 2, NULL),
(28, 'Nguyen Duc Thang', 'ducthangofficial03@gmail.com', '2024-11-25 04:02:28', '$2y$10$POilJyRyemcw4RcvK55ckOCHLgseaXSXrhoQz2Y1tbghAOn4wJZa6', NULL, '2024-11-25 04:02:28', '2024-11-25 04:02:28', 2, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vocabularys`
--

CREATE TABLE `vocabularys` (
  `id` int(10) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `word` varchar(255) NOT NULL,
  `pronounce` varchar(255) NOT NULL,
  `meaning` varchar(255) NOT NULL,
  `example` text NOT NULL,
  `topic_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `vocabularys`
--

INSERT INTO `vocabularys` (`id`, `user_id`, `word`, `pronounce`, `meaning`, `example`, `topic_id`, `type_id`, `image`, `create_at`) VALUES
(11, 18, 'Kindergarten', '/ˈkɪndərˌɡɑrtən/', 'Trường mẫu giáo', 'My daughter just started kindergarten.', 6, 4, NULL, NULL),
(12, 18, 'College', '/ˈkɒlɪʤ/', 'Trường cao đẳng', 'My brother wanted to go to college.', 6, 6, NULL, NULL),
(13, 18, 'University', '/ˌjuːnɪˈvɜːsəti/', 'Trường đại học', 'Anh ấy đang học tại một trường đại học danh tiếng.', 6, 6, NULL, NULL),
(14, 18, 'Public school', '/ˈpʌb.lɪk skuːl/', 'Trường công lập', 'Most children in the area go to the local public school.', 6, 8, NULL, NULL),
(15, 18, 'Charter school', '/ˈtʃɑːr.tər skuːl/', 'Trường bán công', 'The new charter school offers a different curriculum.', 6, 3, NULL, NULL),
(16, 18, 'Homeschooling', '/ˈhoʊmˌskuː.lɪŋ/', 'Giáo dục tại nhà', 'Homeschooling allows for a flexible schedule.', 6, 9, NULL, NULL),
(17, 18, 'Online school ', '/ˈɒnˌlaɪn skuːl/', 'Trường học trực tuyến', 'He prefers attending an online school for its flexibility.', 6, 6, NULL, NULL),
(18, 18, 'Doctorate', '/ˈdɑktərɪt/', 'Bằng tiến sĩ', 'She holds a doctorate in chemistry. ', 6, 1, NULL, NULL),
(19, 18, 'Major', '/ˈmeɪdʒər/', 'Chuyên ngành', 'His major is electrical engineering.', 6, 7, NULL, NULL),
(20, 18, 'Credit hours', '/ˈkrɛdɪt aʊərz/', 'Tín chỉ', 'This course is worth three credit hours.', 6, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wordnotes`
--

CREATE TABLE `wordnotes` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `vocabulary_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `audios`
--
ALTER TABLE `audios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listening_id` (`listening_id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `listening_exercises`
--
ALTER TABLE `listening_exercises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `purchased_exercises`
--
ALTER TABLE `purchased_exercises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `purchased_exercises_ibfk_1` (`topic_id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `level_id` (`level_id`);

--
-- Chỉ mục cho bảng `topic_vocabularys`
--
ALTER TABLE `topic_vocabularys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `type_vocabularys`
--
ALTER TABLE `type_vocabularys`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Chỉ mục cho bảng `vocabularys`
--
ALTER TABLE `vocabularys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Chỉ mục cho bảng `wordnotes`
--
ALTER TABLE `wordnotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `vocabulary_id` (`vocabulary_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `audios`
--
ALTER TABLE `audios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `listening_exercises`
--
ALTER TABLE `listening_exercises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `purchased_exercises`
--
ALTER TABLE `purchased_exercises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `topic_vocabularys`
--
ALTER TABLE `topic_vocabularys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `type_vocabularys`
--
ALTER TABLE `type_vocabularys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `vocabularys`
--
ALTER TABLE `vocabularys`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `wordnotes`
--
ALTER TABLE `wordnotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `audios`
--
ALTER TABLE `audios`
  ADD CONSTRAINT `audios_ibfk_1` FOREIGN KEY (`listening_id`) REFERENCES `listening_exercises` (`id`);

--
-- Các ràng buộc cho bảng `listening_exercises`
--
ALTER TABLE `listening_exercises`
  ADD CONSTRAINT `listening_exercises_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`);

--
-- Các ràng buộc cho bảng `purchased_exercises`
--
ALTER TABLE `purchased_exercises`
  ADD CONSTRAINT `purchased_exercises_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`),
  ADD CONSTRAINT `purchased_exercises_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`);

--
-- Các ràng buộc cho bảng `topic_vocabularys`
--
ALTER TABLE `topic_vocabularys`
  ADD CONSTRAINT `topic_vocabularys_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `vocabularys`
--
ALTER TABLE `vocabularys`
  ADD CONSTRAINT `vocabularys_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `vocabularys_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `topic_vocabularys` (`id`),
  ADD CONSTRAINT `vocabularys_ibfk_3` FOREIGN KEY (`type_id`) REFERENCES `type_vocabularys` (`id`);

--
-- Các ràng buộc cho bảng `wordnotes`
--
ALTER TABLE `wordnotes`
  ADD CONSTRAINT `wordnotes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `wordnotes_ibfk_2` FOREIGN KEY (`vocabulary_id`) REFERENCES `vocabularys` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
