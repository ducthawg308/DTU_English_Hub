-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 09, 2025 lúc 05:42 PM
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
(25, 42, '1.1.1.mp3', 'Where is Jane?'),
(26, 42, '1.1.2.mp3', 'She is in the living room.'),
(27, 42, '1.1.3.mp3', 'What is she doing?'),
(28, 42, '1.1.4.mp3', 'She is playing the piano.'),
(29, 42, '1.1.5.mp3', 'Where is the car?'),
(30, 42, '1.1.6.mp3', 'It is in the garage.'),
(31, 42, '1.1.7.mp3', 'Where is the dog?'),
(32, 42, '1.1.8.mp3', 'The dog is in front of the door.'),
(33, 42, '1.1.9.mp3', 'What is the dog doing?'),
(34, 42, '1.1.10.mp3', 'The dog is eating.'),
(35, 43, '1.2.1.mp3', 'Where are you?'),
(36, 43, '1.2.2.mp3', 'I am in the kitchen.'),
(37, 43, '1.2.3.mp3', 'What are you doing?'),
(38, 43, '1.2.4.mp3', 'I am cooking dinner.'),
(39, 43, '1.2.5.mp3', 'Where are Bill and Mary?'),
(40, 43, '1.2.6.mp3', 'They are in the living room.'),
(41, 43, '1.2.7.mp3', 'What are they doing?'),
(42, 43, '1.2.8.mp3', 'They are watching TV.'),
(43, 43, '1.2.9.mp3', 'Where is the cat?'),
(44, 43, '1.2.10.mp3', 'She is in the dining room.'),
(45, 43, '1.2.11.mp3', 'What is she doing?'),
(46, 43, '1.2.12.mp3', 'She is sleeping.'),
(47, 44, '1.3.1.mp3', 'Who is she?'),
(48, 44, '1.3.2.mp3', 'She is my sister.'),
(49, 44, '1.3.3.mp3', 'What\'s her name?'),
(50, 44, '1.3.4.mp3', 'Her name is Jennifer.'),
(51, 44, '1.3.5.mp3', 'Where is she in this photograph?'),
(52, 44, '1.3.6.mp3', 'She\'s in Toronto.'),
(53, 44, '1.3.7.mp3', 'What is that building behind her?'),
(54, 44, '1.3.8.mp3', 'She\'s standing in front of the CN Tower.'),
(55, 45, '1.4.1.mp3', 'Where is the school?'),
(56, 45, '1.4.2.mp3', 'It\'s between the library and the park.'),
(57, 45, '1.4.3.mp3', 'Where is the post office?'),
(58, 45, '1.4.4.mp3', 'It\'s across from the movie theater.'),
(59, 45, '1.4.5.mp3', 'Where is the royal bank?'),
(60, 45, '1.4.6.mp3', 'It\'s next to the supermarket.'),
(61, 45, '1.4.7.mp3', 'Where is the gas station?'),
(62, 45, '1.4.8.mp3', 'It\'s around the corner from the church.'),
(63, 45, '1.4.9.mp3', 'Where is the barbershop?'),
(64, 45, '1.4.10.mp3', 'It\'s near the bus station.'),
(65, 46, '1.5.1.mp3', 'Excuse me? Can you tell me the way to the nearest bank?'),
(66, 46, '1.5.2.mp3', 'Yes, it\'s on Geneva Street.'),
(67, 46, '1.5.3.mp3', 'As a matter of fact, I\'m going that way myself.'),
(68, 46, '1.5.4.mp3', 'So if you come with me, I will show you.'),
(69, 46, '1.5.5.mp3', 'Thanks very much.'),
(70, 46, '1.5.6.mp3', 'You\'re welcome.'),
(71, 43, '1.2.1.mp3', 'Where are you?'),
(72, 43, '1.2.2.mp3', 'I am in the kitchen.'),
(73, 43, '1.2.3.mp3', 'What are you doing?'),
(74, 43, '1.2.4.mp3', 'I am cooking dinner.'),
(75, 43, '1.2.5.mp3', 'Where are Bill and Mary?'),
(76, 43, '1.2.6.mp3', 'They are in the living room.'),
(77, 43, '1.2.7.mp3', 'What are they doing?'),
(78, 43, '1.2.8.mp3', 'They are watching TV.'),
(79, 43, '1.2.9.mp3', 'Where is the cat?'),
(80, 43, '1.2.10.mp3', 'She is in the dining room.'),
(81, 43, '1.2.11.mp3', 'What is she doing?'),
(82, 43, '1.2.12.mp3', 'She is sleeping.'),
(83, 44, '1.3.1.mp3', 'Who is she?'),
(84, 44, '1.3.2.mp3', 'She is my sister.'),
(85, 44, '1.3.3.mp3', 'What\'s her name?'),
(86, 44, '1.3.4.mp3', 'Her name is Jennifer.'),
(87, 44, '1.3.5.mp3', 'Where is she in this photograph?'),
(88, 44, '1.3.6.mp3', 'She\'s in Toronto.'),
(89, 44, '1.3.7.mp3', 'What is that building behind her?'),
(90, 44, '1.3.8.mp3', 'She\'s standing in front of the CN Tower.'),
(91, 45, '1.4.1.mp3', 'Where is the school?'),
(92, 45, '1.4.2.mp3', 'It\'s between the library and the park.'),
(93, 45, '1.4.3.mp3', 'Where is the post office?'),
(94, 45, '1.4.4.mp3', 'It\'s across from the movie theater.'),
(95, 45, '1.4.5.mp3', 'Where is the royal bank?'),
(96, 45, '1.4.6.mp3', 'It\'s next to the supermarket.'),
(97, 45, '1.4.7.mp3', 'Where is the gas station?'),
(98, 45, '1.4.8.mp3', 'It\'s around the corner from the church.'),
(99, 45, '1.4.9.mp3', 'Where is the barbershop?'),
(100, 45, '1.4.10.mp3', 'It\'s near the bus station.'),
(101, 46, '1.5.1.mp3', 'Excuse me? Can you tell me the way to the nearest bank?'),
(102, 46, '1.5.2.mp3', 'Yes, it\'s on Geneva Street.'),
(103, 46, '1.5.3.mp3', 'As a matter of fact, I\'m going that way myself.'),
(104, 46, '1.5.4.mp3', 'So if you come with me, I will show you.'),
(105, 46, '1.5.5.mp3', 'Thanks very much.'),
(106, 46, '1.5.6.mp3', 'You\'re welcome.'),
(107, 47, '2.1.1.mp3', 'Today is November 26th.'),
(108, 47, '2.1.2.mp3', 'It snowed all day today.'),
(109, 47, '2.1.3.mp3', 'The snow is beautiful.'),
(110, 47, '2.1.4.mp3', 'The snow finally stopped.'),
(111, 47, '2.1.5.mp3', 'My sister and I are excited.'),
(112, 47, '2.1.6.mp3', 'My mom doesn\'t like the snow.'),
(113, 47, '2.1.7.mp3', 'My mom has to shovel the driveway.'),
(114, 47, '2.1.8.mp3', 'My sister and I get to play.'),
(115, 47, '2.1.9.mp3', 'I put on my hat and mittens.'),
(116, 47, '2.1.10.mp3', 'My mom puts on my scarf.'),
(117, 48, '2.2.1.mp3', 'Today is Jessica\'s first day of kindergarten.'),
(118, 48, '2.2.2.mp3', 'Jessica and her parents walk to school.'),
(119, 48, '2.2.3.mp3', 'Jessica\'s mom walks with her to her classroom.'),
(120, 48, '2.2.4.mp3', 'Jessica meets her teacher.'),
(121, 48, '2.2.5.mp3', 'His name is Mr. Parker.'),
(122, 48, '2.2.6.mp3', 'The school bell rings at 8:45 a.m.'),
(123, 48, '2.2.7.mp3', 'Jessica hugs and kisses her mom goodbye.'),
(124, 48, '2.2.8.mp3', 'Jessica\'s mom says I love you.'),
(125, 48, '2.2.9.mp3', 'At 9 a.m, Jessica stands for the national anthem.'),
(126, 48, '2.2.10.mp3', 'Mr. Parker calls out children\'s names.'),
(127, 49, '2.3.1.mp3', 'My name is Anne.'),
(128, 49, '2.3.2.mp3', 'I love flowers.'),
(129, 49, '2.3.3.mp3', 'I have a flower garden.'),
(130, 49, '2.3.4.mp3', 'My garden is in front of my house.'),
(131, 49, '2.3.5.mp3', 'My neighbor has a garden too.'),
(132, 49, '2.3.6.mp3', 'My garden has different types of flowers.'),
(133, 49, '2.3.7.mp3', 'I have roses in my garden.'),
(134, 49, '2.3.8.mp3', 'I have tulips in my garden.'),
(135, 49, '2.3.9.mp3', 'I have petunias in my garden.'),
(136, 49, '2.3.10.mp3', 'My garden has different colors.'),
(137, 50, '2.4.1.mp3', 'The Bright family went camping on the weekend.'),
(138, 50, '2.4.2.mp3', 'The Bright family went to Silent Lake.'),
(139, 50, '2.4.3.mp3', 'The Bright family left on Friday.'),
(140, 50, '2.4.4.mp3', 'They camped for three days.'),
(141, 50, '2.4.5.mp3', 'The Bright family brought a big tent.'),
(142, 50, '2.4.6.mp3', 'They brought a lot of food.'),
(143, 50, '2.4.7.mp3', 'They brought insect repellent.'),
(144, 50, '2.4.8.mp3', 'The Bright family had a campfire on Friday.'),
(145, 50, '2.4.9.mp3', 'They roasted marshmallows.'),
(146, 50, '2.4.10.mp3', 'They sang campfire songs.'),
(147, 51, '2.5.1.mp3', 'I live in a house.'),
(148, 51, '2.5.2.mp3', 'My house is small.'),
(149, 51, '2.5.3.mp3', 'My house has two bedrooms.'),
(150, 51, '2.5.4.mp3', 'My mom and dad sleep in one bedroom.'),
(151, 51, '2.5.5.mp3', 'My sister and I share the other bedroom.'),
(152, 51, '2.5.6.mp3', 'My house has a kitchen.'),
(153, 51, '2.5.7.mp3', 'My mom and dad cook dinner there every night.'),
(154, 51, '2.5.8.mp3', 'My house has a living room.'),
(155, 51, '2.5.9.mp3', 'My family watches television there every night.'),
(156, 51, '2.5.10.mp3', 'My house has a big bathroom.'),
(157, 47, '2.1.1.mp3', 'Today is November 26th.'),
(158, 47, '2.1.2.mp3', 'It snowed all day today.'),
(159, 47, '2.1.3.mp3', 'The snow is beautiful.'),
(160, 47, '2.1.4.mp3', 'The snow finally stopped.'),
(161, 47, '2.1.5.mp3', 'My sister and I are excited.'),
(162, 47, '2.1.6.mp3', 'My mom doesn\'t like the snow.'),
(163, 47, '2.1.7.mp3', 'My mom has to shovel the driveway.'),
(164, 47, '2.1.8.mp3', 'My sister and I get to play.'),
(165, 47, '2.1.9.mp3', 'I put on my hat and mittens.'),
(166, 47, '2.1.10.mp3', 'My mom puts on my scarf.'),
(167, 48, '2.2.1.mp3', 'Today is Jessica\'s first day of kindergarten.'),
(168, 48, '2.2.2.mp3', 'Jessica and her parents walk to school.'),
(169, 48, '2.2.3.mp3', 'Jessica\'s mom walks with her to her classroom.'),
(170, 48, '2.2.4.mp3', 'Jessica meets her teacher.'),
(171, 48, '2.2.5.mp3', 'His name is Mr. Parker.'),
(172, 48, '2.2.6.mp3', 'The school bell rings at 8:45 a.m.'),
(173, 48, '2.2.7.mp3', 'Jessica hugs and kisses her mom goodbye.'),
(174, 48, '2.2.8.mp3', 'Jessica\'s mom says I love you.'),
(175, 48, '2.2.9.mp3', 'At 9 a.m, Jessica stands for the national anthem.'),
(176, 48, '2.2.10.mp3', 'Mr. Parker calls out children\'s names.'),
(177, 49, '2.3.1.mp3', 'My name is Anne.'),
(178, 49, '2.3.2.mp3', 'I love flowers.'),
(179, 49, '2.3.3.mp3', 'I have a flower garden.'),
(180, 49, '2.3.4.mp3', 'My garden is in front of my house.'),
(181, 49, '2.3.5.mp3', 'My neighbor has a garden too.'),
(182, 49, '2.3.6.mp3', 'My garden has different types of flowers.'),
(183, 49, '2.3.7.mp3', 'I have roses in my garden.'),
(184, 49, '2.3.8.mp3', 'I have tulips in my garden.'),
(185, 49, '2.3.9.mp3', 'I have petunias in my garden.'),
(186, 49, '2.3.10.mp3', 'My garden has different colors.'),
(187, 50, '2.4.1.mp3', 'The Bright family went camping on the weekend.'),
(188, 50, '2.4.2.mp3', 'The Bright family went to Silent Lake.'),
(189, 50, '2.4.3.mp3', 'The Bright family left on Friday.'),
(190, 50, '2.4.4.mp3', 'They camped for three days.'),
(191, 50, '2.4.5.mp3', 'The Bright family brought a big tent.'),
(192, 50, '2.4.6.mp3', 'They brought a lot of food.'),
(193, 50, '2.4.7.mp3', 'They brought insect repellent.'),
(194, 50, '2.4.8.mp3', 'The Bright family had a campfire on Friday.'),
(195, 50, '2.4.9.mp3', 'They roasted marshmallows.'),
(196, 50, '2.4.10.mp3', 'They sang campfire songs.'),
(197, 51, '2.5.1.mp3', 'I live in a house.'),
(198, 51, '2.5.2.mp3', 'My house is small.'),
(199, 51, '2.5.3.mp3', 'My house has two bedrooms.'),
(200, 51, '2.5.4.mp3', 'My mom and dad sleep in one bedroom.'),
(201, 51, '2.5.5.mp3', 'My sister and I share the other bedroom.'),
(202, 51, '2.5.6.mp3', 'My house has a kitchen.'),
(203, 51, '2.5.7.mp3', 'My mom and dad cook dinner there every night.'),
(204, 51, '2.5.8.mp3', 'My house has a living room.'),
(205, 51, '2.5.9.mp3', 'My family watches television there every night.'),
(206, 51, '2.5.10.mp3', 'My house has a big bathroom.'),
(207, 52, '3.1.1.mp3', 'Mary'),
(208, 52, '3.1.2.mp3', 'Mary'),
(209, 52, '3.1.3.mp3', 'Anna'),
(210, 52, '3.1.4.mp3', 'Anna'),
(211, 52, '3.1.5.mp3', 'Patricia'),
(212, 52, '3.1.6.mp3', 'Patricia'),
(213, 52, '3.1.7.mp3', 'Sophia'),
(214, 52, '3.1.8.mp3', 'Sophia'),
(215, 52, '3.1.9.mp3', 'Linda'),
(216, 52, '3.1.10.mp3', 'Linda'),
(217, 53, '3.2.1.mp3', 'James'),
(218, 53, '3.2.2.mp3', 'James'),
(219, 53, '3.2.3.mp3', 'Oliver'),
(220, 53, '3.2.4.mp3', 'Oliver'),
(221, 53, '3.2.5.mp3', 'John'),
(222, 53, '3.2.6.mp3', 'John'),
(223, 53, '3.2.7.mp3', 'Harry'),
(224, 53, '3.2.8.mp3', 'Harry'),
(225, 53, '3.2.9.mp3', 'Robert'),
(226, 53, '3.2.10.mp3', 'Robert'),
(227, 54, '3.3.1.mp3', 'Smith'),
(228, 54, '3.3.2.mp3', 'Smith'),
(229, 54, '3.3.3.mp3', 'Jones'),
(230, 54, '3.3.4.mp3', 'Jones'),
(231, 54, '3.3.5.mp3', 'Johnson'),
(232, 54, '3.3.6.mp3', 'Johnson'),
(233, 54, '3.3.7.mp3', 'Davies'),
(234, 54, '3.3.8.mp3', 'Davies'),
(235, 54, '3.3.9.mp3', 'Williams'),
(236, 54, '3.3.10.mp3', 'Williams'),
(237, 55, '3.4.1.mp3', 'Giraffe'),
(238, 55, '3.4.2.mp3', 'Giraffe'),
(239, 55, '3.4.3.mp3', 'Ox'),
(240, 55, '3.4.4.mp3', 'Ox'),
(241, 55, '3.4.5.mp3', 'Koala'),
(242, 55, '3.4.6.mp3', 'Koala'),
(243, 55, '3.4.7.mp3', 'Beaver'),
(244, 55, '3.4.8.mp3', 'Beaver'),
(245, 55, '3.4.9.mp3', 'Butterfly'),
(246, 55, '3.4.10.mp3', 'Butterfly'),
(247, 56, '4.1.1.mp3', '(797) 285-6959'),
(248, 56, '4.1.2.mp3', '(763) 298-0228'),
(249, 56, '4.1.3.mp3', '(784) 838-0179'),
(250, 56, '4.1.4.mp3', '(559) 271-7081'),
(251, 56, '4.1.5.mp3', '(358) 555-4176'),
(252, 56, '4.1.6.mp3', '(214) 474-2572'),
(253, 56, '4.1.7.mp3', '(893) 913-8143'),
(254, 56, '4.1.8.mp3', '(462) 205-0026'),
(255, 56, '4.1.9.mp3', '(811) 972-6619'),
(256, 56, '4.1.10.mp3', '(314) 238-0808'),
(257, 57, '4.2.1.mp3', '53'),
(258, 57, '4.2.2.mp3', '68'),
(259, 57, '4.2.3.mp3', '4'),
(260, 57, '4.2.4.mp3', '95'),
(261, 57, '4.2.5.mp3', '90'),
(262, 57, '4.2.6.mp3', '60'),
(263, 57, '4.2.7.mp3', '5'),
(264, 57, '4.2.8.mp3', '80'),
(265, 57, '4.2.9.mp3', '64'),
(266, 57, '4.2.10.mp3', '10'),
(267, 58, '4.3.1.mp3', '83'),
(268, 58, '4.3.2.mp3', '481'),
(269, 58, '4.3.3.mp3', '948'),
(270, 58, '4.3.4.mp3', '540'),
(271, 58, '4.3.5.mp3', '38'),
(272, 58, '4.3.6.mp3', '90'),
(273, 58, '4.3.7.mp3', '6'),
(274, 58, '4.3.8.mp3', '63'),
(275, 58, '4.3.9.mp3', '45'),
(276, 58, '4.3.10.mp3', '415'),
(277, 59, '4.4.1.mp3', '9,803'),
(278, 59, '4.4.2.mp3', '38'),
(279, 59, '4.4.3.mp3', '732'),
(280, 59, '4.4.4.mp3', '61'),
(281, 59, '4.4.5.mp3', '3'),
(282, 59, '4.4.6.mp3', '310'),
(283, 59, '4.4.7.mp3', '69'),
(284, 59, '4.4.8.mp3', '52'),
(285, 59, '4.4.9.mp3', '106'),
(286, 59, '4.4.10.mp3', '98'),
(287, 60, '5.5.1.mp3', '32,734'),
(288, 60, '5.5.2.mp3', '8,599'),
(289, 60, '5.5.3.mp3', '50,203'),
(290, 60, '5.5.4.mp3', '983'),
(291, 60, '5.5.5.mp3', '119'),
(292, 60, '5.5.6.mp3', '3,182'),
(293, 60, '5.5.7.mp3', '38,529'),
(294, 60, '5.5.8.mp3', '1,362'),
(295, 60, '5.5.9.mp3', '913'),
(296, 60, '5.5.10.mp3', '5,395'),
(297, 61, '5.1.1.mp3', 'Good morning, Jack.'),
(298, 61, '5.1.2.mp3', 'Can you do me a favor and photocopy these documents for me, please?'),
(299, 61, '5.1.3.mp3', 'I need them for the staff meeting tomorrow morning.'),
(300, 61, '5.1.4.mp3', 'There will be fifteen attendees.'),
(301, 61, '5.1.5.mp3', 'Hi, Grace.'),
(302, 61, '5.1.6.mp3', 'Unfortunately, the copy machine is out of order.'),
(303, 61, '5.1.7.mp3', 'The repairman is supposed to be coming this afternoon to have a look after it,'),
(304, 61, '5.1.8.mp3', 'but this is the second time it has broken down in the past two weeks,'),
(305, 61, '5.1.9.mp3', 'so it may not be fixable.'),
(306, 61, '5.1.10.mp3', 'Oh, man.'),
(307, 62, '5.2.1.mp3', 'Have you checked your email?'),
(308, 62, '5.2.2.mp3', 'It looks like Antonio Garks is going to take over as production manager at our factory in Vietnam'),
(309, 62, '5.2.3.mp3', 'while Susan Carter is out on maternity leave.'),
(310, 62, '5.2.4.mp3', 'The post lasts six months.'),
(311, 62, '5.2.5.mp3', 'Wow, I haven\'t seen that email yet.'),
(312, 62, '5.2.6.mp3', 'Did the email say when he was flying out?'),
(313, 62, '5.2.7.mp3', 'Not for a few months, at the beginning of January.'),
(314, 62, '5.2.8.mp3', 'Well the project in Southampton won\'t be finished by January.'),
(315, 62, '5.2.9.mp3', 'I wonder who will fill his position there.'),
(316, 62, '5.2.10.mp3', 'The email didn\'t say, so I\'m assuming they haven\'t made that decision.'),
(317, 63, '5.3.1.mp3', 'Good morning, this is Demi Geard.'),
(318, 63, '5.3.2.mp3', 'Is Mrs. Hayley in? I am a client of hers.'),
(319, 63, '5.3.3.mp3', 'Well. Mrs. Hayley is actually traveling abroad until the end of next week.'),
(320, 63, '5.3.4.mp3', 'Is this an emergency?'),
(321, 63, '5.3.5.mp3', 'I can attempt to contact her at the resort.'),
(322, 63, '5.3.6.mp3', 'No, that is not necessary.'),
(323, 63, '5.3.7.mp3', 'I was just swinging by to give her these documents.'),
(324, 63, '5.3.8.mp3', 'She had asked me to sign them.'),
(325, 63, '5.3.9.mp3', 'Is it okay to leave them with you?'),
(326, 63, '5.3.10.mp3', 'That is no problem!'),
(327, 64, '5.4.1.mp3', 'Hi, I\'m calling to get an update on a claim I filed.'),
(328, 64, '5.4.2.mp3', 'It\'s for an emergency dental surgery I had while on vacation.'),
(329, 64, '5.4.3.mp3', 'Sure, I can help with that.'),
(330, 64, '5.4.4.mp3', 'Do you remember when you submitted the claim?'),
(331, 64, '5.4.5.mp3', 'I filed it on December 27th, so about a month ago.'),
(332, 64, '5.4.6.mp3', 'I see.'),
(333, 64, '5.4.7.mp3', 'Normally, it takes about six weeks to resolve,'),
(334, 64, '5.4.8.mp3', 'but because of the holidays, it might take up to eight weeks.'),
(335, 64, '5.4.9.mp3', 'Can you give me the 8-digit reference number?'),
(336, 64, '5.4.10.mp3', 'I\'ll get back to you within 72 hours with an update.'),
(337, 65, '5.5.1.mp3', 'Good afternoon, this is Harry Stills.'),
(338, 65, '5.5.2.mp3', 'I\'m calling regarding a delivery I was expecting.'),
(339, 65, '5.5.3.mp3', 'I placed an order for a computer yesterday and paid for the expedited shipping.'),
(340, 65, '5.5.4.mp3', 'It was supposed to be here by noon,'),
(341, 65, '5.5.5.mp3', 'but here we are, two hours later, and I am still waiting.'),
(342, 65, '5.5.6.mp3', 'I\'m sorry about that.'),
(343, 65, '5.5.7.mp3', 'The delivery crew actually just called us to let us know he had a flat tire'),
(344, 65, '5.5.8.mp3', 'and was running behind on his deliveries.'),
(345, 65, '5.5.9.mp3', 'He is back on the road and should arrive in the next thirty minutes.'),
(346, 65, '5.5.10.mp3', 'Are you sure?'),
(347, 66, '6.1.1.mp3', 'Now, then, Mr., uh, Vickstad. How can I help you?'),
(348, 66, '6.1.2.mp3', 'Well, I\'m thinking about transferring, but I\'m, I\'m not sure...'),
(349, 66, '6.1.3.mp3', 'I was hoping you could help me make a decision.'),
(350, 66, '6.1.4.mp3', 'I\'ll try.'),
(351, 66, '6.1.5.mp3', 'Where are you thinking of transferring to? And why do you want to leave Kryptos U?'),
(352, 66, '6.1.6.mp3', 'Um... I\'m thinking of going to Central University, because it\'s in my hometown.'),
(353, 66, '6.1.7.mp3', 'I\'ve uh, been kind of homesick this year, and I haven\'t made many friends...'),
(354, 66, '6.1.8.mp3', 'I just feel so lonely.'),
(355, 66, '6.1.9.mp3', 'So, I thought that uh, maybe, it\'d be better to be closer to my parents and friends and all.'),
(356, 66, '6.1.10.mp3', 'I see.'),
(357, 67, '6.2.1.mp3', 'Morning, Myra.'),
(358, 67, '6.2.2.mp3', 'Oh hi, Arthur!'),
(359, 67, '6.2.3.mp3', 'You\'re taking Ecology Three Eleven too?'),
(360, 67, '6.2.4.mp3', 'Looks like it. It\'s my only elective this term.'),
(361, 67, '6.2.5.mp3', 'Really? What happened?'),
(362, 67, '6.2.6.mp3', 'Oh, I just took too many my second year,'),
(363, 67, '6.2.7.mp3', 'and now I\'ve got to pick up all the required courses I\'ve been ignoring.'),
(364, 67, '6.2.8.mp3', 'University\'s just too much fun, I guess.'),
(365, 67, '6.2.9.mp3', 'Too many parties?'),
(366, 67, '6.2.10.mp3', 'No. Well, yeah, that too.'),
(367, 68, '6.3.1.mp3', 'Good morning, Hanna. Thanks for coming in.'),
(368, 68, '6.3.2.mp3', 'How was your holiday?'),
(369, 68, '6.3.3.mp3', 'It was very good, Professor, thanks.'),
(370, 68, '6.3.4.mp3', 'A week in the Appalachians is really therapeutic.'),
(371, 68, '6.3.5.mp3', 'Nothing to do but eat, sleep, and listen to nature.'),
(372, 68, '6.3.6.mp3', 'It\'s beautiful up there in the spring,'),
(373, 68, '6.3.7.mp3', 'the countryside is so green,'),
(374, 68, '6.3.8.mp3', 'and the people are so friendly and laid back.'),
(375, 68, '6.3.9.mp3', 'A good place to unwind.'),
(376, 68, '6.3.10.mp3', 'I envy you.'),
(377, 69, '6.4.1.mp3', 'Hi, I want to get a pass for the Intramural Activities Center this quarter, please.'),
(378, 69, '6.4.2.mp3', 'Sure. I need to see your student ID card, please.'),
(379, 69, '6.4.3.mp3', 'OK, thank you.'),
(380, 69, '6.4.4.mp3', 'Now, which type of IMA pass would you like to buy?'),
(381, 69, '6.4.5.mp3', 'Um, I don\'t know. How many different kinds of passes are there?'),
(382, 69, '6.4.6.mp3', 'Well, there\'s a basic pass.'),
(383, 69, '6.4.7.mp3', 'That allows you to use the basketball courts, the fitness center,'),
(384, 69, '6.4.8.mp3', 'the racquetball courts, the rock-climbing center, and the indoor track.'),
(385, 69, '6.4.9.mp3', 'An IMA super pass lets you use all those things,'),
(386, 69, '6.4.10.mp3', 'and also the swimming pools, tennis courts, and golf driving range.'),
(387, 70, '6.5.1.mp3', 'Good afternoon, Ms. Pennington.'),
(388, 70, '6.5.2.mp3', 'You are in my, um, American History 201 class, right?'),
(389, 70, '6.5.3.mp3', 'How can I help you today?'),
(390, 70, '6.5.4.mp3', 'It\'s about my term paper.'),
(391, 70, '6.5.5.mp3', 'I, uh, I know it\'s due next Monday, but, um, I was hoping...'),
(392, 70, '6.5.6.mp3', 'I don\'t think I can get it done by then.'),
(393, 70, '6.5.7.mp3', 'Could I please turn it in by the end of next week instead?'),
(394, 70, '6.5.8.mp3', 'I have a really good excuse.'),
(395, 70, '6.5.9.mp3', 'Oh I\'m sure you do!'),
(396, 70, '6.5.10.mp3', 'I\'ve been teaching 33 years.'),
(397, 71, '7.1.1.mp3', 'Hello... Flagstone.'),
(398, 71, '7.1.2.mp3', 'Oh hello.'),
(399, 71, '7.1.3.mp3', 'Is that Flagstone Properties?'),
(400, 71, '7.1.4.mp3', 'Yes that\'s right.'),
(401, 71, '7.1.5.mp3', 'Flagstone here. How can I help you?'),
(402, 71, '7.1.6.mp3', 'Hello.'),
(403, 71, '7.1.7.mp3', 'I\'m ringing just to make enquiries about renting a house.'),
(404, 71, '7.1.8.mp3', 'My name\'s Jon Anderson.'),
(405, 71, '7.1.9.mp3', 'Yes, Mr Anderson.'),
(406, 71, '7.1.10.mp3', 'What sort of thing were you looking for?'),
(407, 72, '7.2.1.mp3', 'Hello, Mrs Sutton. Come in.'),
(408, 72, '7.2.2.mp3', 'How are you settling in next door?'),
(409, 72, '7.2.3.mp3', 'Have all your things from Canada arrived yet?'),
(410, 72, '7.2.4.mp3', 'I thought I saw a removals van outside your house yesterday afternoon.'),
(411, 72, '7.2.5.mp3', 'Yes. They came yesterday.'),
(412, 72, '7.2.6.mp3', 'We spent all day yesterday arranging them.'),
(413, 72, '7.2.7.mp3', 'It\'s beginning to feel a bit more like home now.'),
(414, 72, '7.2.8.mp3', 'Oh that\'s good.'),
(415, 72, '7.2.9.mp3', 'Look, come in and sit down.'),
(416, 72, '7.2.10.mp3', 'Are you alright?'),
(417, 73, '7.3.1.mp3', 'Hello. Jonathan Briggs, isn\'t it?'),
(418, 73, '7.3.2.mp3', 'Yes, that\'s right.'),
(419, 73, '7.3.3.mp3', 'Do come in and sit down.'),
(420, 73, '7.3.4.mp3', 'Thanks.'),
(421, 73, '7.3.5.mp3', 'Right.'),
(422, 73, '7.3.6.mp3', 'Well, Jonathan, as we explained in your letter,'),
(423, 73, '7.3.7.mp3', 'in this part of the interview, we like to talk through your application form...'),
(424, 73, '7.3.8.mp3', 'your experience to date, etc....'),
(425, 73, '7.3.9.mp3', 'and then in the second part,'),
(426, 73, '7.3.10.mp3', 'you go for a group interview.'),
(427, 74, '7.4.1.mp3', 'Today\'s Health Counsel is presented by Paula Clayburg,'),
(428, 74, '7.4.2.mp3', 'who is the chief Counsellor at Liverpool\'s famous pain clinic:'),
(429, 74, '7.4.3.mp3', 'The Wilton Clinic.'),
(430, 74, '7.4.4.mp3', 'Paula...'),
(431, 74, '7.4.5.mp3', 'Do you know what Prince Charles, Seve Ballesteros and Elizabeth Taylor have in common?'),
(432, 74, '7.4.6.mp3', 'They all suffer from chronic back pain.'),
(433, 74, '7.4.7.mp3', 'In fact, bad backs are one of the most common health problems today,'),
(434, 74, '7.4.8.mp3', 'affecting people in all walks of life.'),
(435, 74, '7.4.9.mp3', 'The most recent available figures show that about a quarter of a million people'),
(436, 74, '7.4.10.mp3', 'are incapacitated with back pain every day.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `time` int(11) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `level_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `exams`
--

INSERT INTO `exams` (`id`, `name`, `time`, `total_questions`, `level_id`) VALUES
(11, 'Thi thử tốt nghiệp THPT tiếng anh 2025 - Đề minh họa số 8', 15, 11, 1),
(12, 'Bài tập trắc nghiệm thì hiện tại đơn (Simple Present)', 20, 10, 2),
(13, 'Bài tập trắc nghiệm thì hiện tại tiếp diễn (Present Continuous)', 30, 10, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam_answers`
--

CREATE TABLE `exam_answers` (
  `id` int(11) NOT NULL,
  `result_exam_id` int(11) NOT NULL,
  `exam_question_id` int(11) NOT NULL,
  `selected_answer` char(1) NOT NULL,
  `is_correct` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam_questions`
--

CREATE TABLE `exam_questions` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `question` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_answer` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `exam_questions`
--

INSERT INTO `exam_questions` (`id`, `exam_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_answer`) VALUES
(7, 11, 'We sometimes ________ books.', 'read', 'reading', 'reads', 'readly', 'C'),
(8, 11, 'Emily ________ to the disco.', 'go', 'goes', 'went', 'gone', 'B'),
(9, 11, 'It often ________ on Sundays.', 'rain', 'rains', 'reined', 'rainly', 'A'),
(10, 11, 'Pete and his sister ________ the family car.', 'wash', 'washed', 'are washing', 'washes', 'C'),
(11, 11, 'I always ________ to the bus stop.', 'hurry', 'hurries', 'am', 'a', 'A'),
(12, 11, ' I __________ to school every day.', 'go', 'goes', 'went', 'going', 'B'),
(13, 11, 'She __________ to eat vegetables.', 'not like', 'doesn\'t like', 'not liked', 'doesn\'t liked', 'C'),
(14, 11, 'We __________ TV every night', 'watches', 'watching', 'watched', 'watch', 'D'),
(15, 11, 'You __________ ice cream!', 'loving', 'are love', 'love ', 'loves', 'D'),
(16, 11, 'I________ you', 'hate', 'love', 'push', 'go', 'A'),
(17, 11, '11: The printer ________ working well.', 'had not been', 'hadnt', 'had not', 'work', ''),
(18, 12, 'Ask her to come and see me when she ………her work.', 'have been being', 'am', 'was being', 'am being', 'D'),
(19, 12, 'By the age of 25, he …….two famous novels.', 'wrote', 'writes', 'has written', 'had written', 'D'),
(20, 12, 'He said he…….return later.\n', 'can', 'will', 'would be', 'would', 'C'),
(21, 12, 'According to this newspaper, John is said………a new record for the long jump.', 'establishing', 'established', 'to establish', 'A-to have establish', 'A'),
(22, 12, 'I will come and see you before I……..for America.', 'will leave', 'shall leave', 'have left', 'leave', 'C'),
(23, 12, 'I……….at 8 o’clock every morning.', 'got up', 'was getting up', 'is getting up', 'get up', 'D'),
(24, 12, 'The dancing club……..North of the city.', 'located', 'lays', 'lies', 'lain', 'B'),
(25, 12, 'While her husband was in the army, Janet ……. to him twice a week.', 'was written', 'was writing', 'had written', 'wrote', 'C'),
(26, 12, 'By the end of next year, Geoge………English for 2 years.', 'will learn', 'has learned', 'would learn', 'will have learned', 'B'),
(27, 12, 'The theory of relativity ............. by Einstein, who was a famous physicist.', 'is developed', 'developed', 'develops', 'was developed', 'C'),
(28, 13, 'It……..dark.Shall I turn on the light?', 'is getting', 'get', 'got', 'has got', 'B'),
(29, 13, 'We could have caught the last train, but we ............... five minutes late.', 'are', 'have been', 'would be', 'were', 'A'),
(30, 13, 'I think the weather……….nice later.', 'had', 'will be', 'be', 'has been', 'B'),
(31, 13, 'I .................with my aunt when I am on holiday in Ho Chi Minh City next month.', 'stay', 'will be staying', 'will has been staying', 'wil have stayed', 'C'),
(32, 13, 'At 5 o’clock yesterday evening, I………my clothes.', 'am ironing', 'was ironing', 'ironed', 'have ironed', 'D'),
(33, 13, 'The Olympic Games…….every four years.', 'took place', 'taking place', 'takes place', 'ake place', 'D'),
(34, 13, 'Developing new technologies are time-consuming and expensive.', 'developing', 'technologies ', 'are   ', 'time-consuming', 'C'),
(35, 13, 'The assumption that smoking has bad effects on our health have been proved.', 'long enough', 'complete     ', 'that', 'imaginary', 'C'),
(36, 13, 'Not until he got home he realized he had forgotten to give her the present.', 'got', 'he realized', 'her', 'the present', 'B'),
(37, 13, 'The longer the children waited in the long queue, the more impatiently they became', 'the longer ', 'waited  ', 'the long queue', 'impatiently', 'D');

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
(1, 'Dễ'),
(2, 'Trung bình'),
(3, 'Khó');

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
(42, 17, 'At home (1)'),
(43, 17, 'At home (2)'),
(44, 17, 'My Favorite Photographs (1)'),
(45, 17, 'Location (1)'),
(46, 17, 'Location (2)'),
(47, 16, 'First snowfall'),
(48, 16, 'Jessica\'s first day of school'),
(49, 16, 'My flower garden'),
(50, 16, 'Going camping'),
(51, 16, 'My house'),
(52, 22, 'Female Names'),
(53, 22, 'Male Names'),
(54, 22, 'Last Names'),
(55, 22, 'Animal names'),
(56, 21, 'Phone numbers'),
(57, 21, 'Numbers (1)'),
(58, 21, 'Numbers (2)'),
(59, 21, 'Numbers (3)'),
(60, 21, 'Numbers (4)'),
(61, 18, 'Conversation 1'),
(62, 18, 'Conversation 2'),
(63, 18, 'Conversation 3'),
(64, 18, 'Conversation 4'),
(65, 18, 'Conversation 5'),
(66, 20, 'TOEFL Conversation 1'),
(67, 20, 'TOEFL Conversation 2'),
(68, 20, 'TOEFL Conversation 3'),
(69, 20, 'TOEFL Conversation 4'),
(70, 20, 'TOEFL Conversation 5'),
(71, 19, 'Cam3 - Test 1 - Part 1'),
(72, 19, 'Cam3 - Test 1 - Part 2'),
(73, 19, 'Cam3 - Test 1 - Part 3'),
(74, 19, 'Cam3 - Test 1 - Part 4');

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
(14, 28, 19, 299000, 'Thanh toan khoa hoc co id: 19', '2025-03-09 23:36:10', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `result_exams`
--

CREATE TABLE `result_exams` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` int(11) NOT NULL,
  `score` float NOT NULL,
  `total_correct` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

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
  `desc` text NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `topics`
--

INSERT INTO `topics` (`id`, `level_id`, `name`, `desc`, `price`) VALUES
(16, 1, 'Short Stories', 'Bộ sưu tập các bài viết âm thanh giới thiệu về văn hóa, con người, địa điểm, sự kiện lịch sử và cuộc sống thường ngày ở các nước nói tiếng Anh, đặc biệt là Canada và Mỹ.', 0),
(17, 2, 'Conversations', 'Các cuộc hội thoại tiếng Anh ngắn và vui nhộn trong các tình huống thông thường mà bạn có thể gặp phải trong cuộc sống hàng ngày. Bạn sẽ học các cụm từ và cách diễn đạt thông thường mà người bản xứ sử dụng.', 0),
(18, 3, 'TOEIC Listening', 'Trong phần này có rất nhiều cuộc trò chuyện và bài nói ngắn trong cuộc sống hàng ngày và công việc. Hãy cùng luyện tập và cải thiện kỹ năng giao tiếp tiếng Anh của bạn!', 300000),
(19, 3, 'IELTS Listening', 'Nghe các bản ghi âm IELTS sẽ giúp bạn học được nhiều từ vựng và cách diễn đạt về các cuộc trò chuyện hàng ngày và các cuộc nói chuyện học thuật. Các bản ghi âm này chủ yếu bằng giọng Anh và Úc.', 299000),
(20, 3, 'TOEFL Listening', 'Bản ghi âm nghe TOEFL là các cuộc trò chuyện và bài giảng học thuật. Các bản ghi âm này sẽ giúp bạn chuẩn bị tốt hơn nếu bạn đang có kế hoạch học tập tại một quốc gia nói tiếng Anh.', 199000),
(21, 1, 'Numbers', 'Let\'s improve your ability to understand English numbers when they are spoken quickly by an American.', 0),
(22, 1, 'Spelling Names', 'Let\'s learn and practice the English alphabet by spelling some common English names.', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `topic_vocabularys`
--

CREATE TABLE `topic_vocabularys` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `topic_vocabularys`
--

INSERT INTO `topic_vocabularys` (`id`, `user_id`, `name`) VALUES
(40, NULL, 'Lifestyle (Phong cách sống)'),
(41, NULL, 'Student life (Cuộc sống sinh viên)'),
(42, 28, 'Keeping fit (Giữ vóc dáng)'),
(43, 28, 'Growing up (Lớn lên)'),
(52, 28, 'School'),
(53, 18, 'life'),
(54, 18, 'School');

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
(18, 'Nguyen Duc Thang', 'ducthangofficial@gmail.com', '2024-11-21 03:32:29', '$2y$10$LyYw/ExrpnqZ4nDt4m4.w.rhWg7k21RLIGmy2e6Zte8vzQu9tcql.', 'gYCk491C3EB9ZqGEurlcn9VHVTXr4Qz32AyikRgq2rR9Htzq1XonoMbO0Fz5', '2024-11-21 03:32:09', '2024-11-22 03:03:37', 1, NULL),
(21, 'Hoang Thi Loan', 'ducthangofficidasdasal@gmail.com', NULL, '$2y$10$9N91zEGMmsYiMvEe.wvxi.znAedGecAAWtl0owtwiSnirc9y.JzT6', NULL, '2024-11-21 03:53:14', '2024-11-22 05:23:17', 2, NULL),
(28, 'Nguyen Duc Thang', 'ducthangofficial03@gmail.com', '2024-11-25 04:02:28', '$2y$10$POilJyRyemcw4RcvK55ckOCHLgseaXSXrhoQz2Y1tbghAOn4wJZa6', NULL, '2024-11-25 04:02:28', '2024-11-25 04:02:28', 2, NULL),
(31, 'Nguyễn Văn An', 'ducthangofficialchatgpt@gmail.com', '2025-03-02 02:07:22', '$2y$10$ZNAamjS.PfJXRjg2Z.5GtOn7zrac697AZwmESxGkslqLFSdqWtmeC', NULL, '2025-03-02 02:07:05', '2025-03-02 02:07:22', 2, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vocabularys`
--

CREATE TABLE `vocabularys` (
  `id` int(10) NOT NULL,
  `word` varchar(255) NOT NULL,
  `pronounce` varchar(255) NOT NULL,
  `meaning` varchar(255) NOT NULL,
  `example` text NOT NULL,
  `topic_id` int(11) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `vocabularys`
--

INSERT INTO `vocabularys` (`id`, `word`, `pronounce`, `meaning`, `example`, `topic_id`, `type_id`, `image`, `create_at`) VALUES
(35, 'achieve', '/əˈʧiv/', 'đạt được', 'I’ve been studying all day, but I feel as if I’ve achieved nothing.', 40, 2, '1741168081_1740975050_datduoc.jpg', NULL),
(36, 'active', '/ˈæktɪv/', 'chủ động, năng động', 'Freshers should be active at work.', 40, 3, '1741168105_1740975082_nangdong.jpg', NULL),
(37, 'activity', '/ækˈtɪvəti/', 'hoạt động', 'There have been unusual activities in your account.', 40, 1, '1741168111_1740975121_hoatdong.jpg', NULL),
(38, 'appeal', '/əˈpil/', 'kêu gọi, thỉnh cầu', 'We’re appealing for clothes and books to send to the poor students.', 40, 2, '1741168119_1740975136_keugoi.jpg', NULL),
(39, 'aspect', '/ˈæˌspɛkt/', 'khía cạnh, mặt', 'Aspects of life', 40, 1, NULL, NULL),
(40, 'aspect', '/ˈæˌspɛkt/', 'khía cạnh, mặt', 'Aspects of life', 40, 1, NULL, NULL),
(41, 'attitude', '/ˈætəˌtud/', 'thái độ', 'It’s kind of difficult to change someone’s attitude.', 40, 1, NULL, NULL),
(42, 'attract', '/əˈtrækt/', 'thu hút', 'With that dress, he is totally attracted to her.', 40, 2, NULL, NULL),
(43, 'academic', '/ˌækəˈdɛmɪk/', 'thuộc về học thuật', 'I have my own academic standards.', 41, 3, NULL, NULL),
(44, 'adopt', '/əˈdɑpt/', 'áp dụng', 'It’s time to adopt a new policy.', 41, 2, NULL, NULL),
(45, 'assignment', '/əˈsaɪnmənt/', 'sự phân công, nhiệm vụ/ bài tập', 'I’m doing reading assignments right now.', 41, 1, NULL, NULL),
(46, 'background noise', '/ˈbækˌɡraʊnd nɔɪz/', 'tạp âm', 'The room I stayed in had a lot of background noise at night.', 41, 1, NULL, NULL),
(47, 'conduct', '/kənˈdʌkt/', 'chỉ đạo', 'The experiment is conducted by Dr. Rober.', 41, 2, NULL, NULL),
(48, 'curriculum', '/kəˈrɪkjələm/', 'chương trình giảng dạy', 'Standard curriculum', 41, 1, NULL, NULL),
(49, 'acute', '/əˈkjut/', 'nghiêm trọng, cấp tính', 'Acute arthritis', 42, 3, NULL, NULL),
(50, 'allergic', '/əˈlɜrʤɪk/', 'bị dị ứng', 'I’m allergic to peanuts.', 42, 3, NULL, NULL),
(51, 'allergy', '/ˈælərʤi/', 'dị ứng', 'Do you have any allergies?', 42, 1, NULL, NULL),
(52, 'alternate', '/ˈɔltɜrnət/', 'xen kẽ', 'A delicious cake with alternate layers of cream and chiffon.', 42, 3, NULL, NULL),
(53, 'anxiety', '/æŋˈzaɪəti/', 'sự lo lắng, bất an', 'Children normally feel anxiety about their first day at school.', 42, 1, NULL, NULL),
(54, 'accommodate', '/əˈkɑməˌdeɪt/', 'điều chỉnh', 'Family is a miniature society. Each person needs to accommodate themselves to live in harmony.', 43, 2, NULL, NULL),
(55, 'active role', '/ˈæktɪv roʊl/', 'vai trò tích cực', 'My grandmother plays a very active role in my life.', 43, 1, NULL, NULL),
(56, 'adolescence', '/ˌædəˈlɛsəns/', 'tuổi thiếu niên', 'Adolescence is the most rebellious period for young people.', 43, 1, NULL, NULL),
(57, 'adopt', '/əˈdɑpt/', 'nhận nuôi', 'He was adopted 5 years ago.', 43, 2, NULL, NULL),
(58, 'adulthood', '/əˈdʌltˌhʊd/', 'tuổi trưởng thành', 'In adulthood, most people prefer a stable job.', 43, 1, NULL, NULL),
(94, 'Textbook', '/ˈtekstbʊk/', 'Sách giáo khoa', 'I need to buy a new textbook for my math class.', 52, 1, NULL, NULL),
(95, 'Learn', '/lɜːrn/', 'Học', 'I want to learn how to play the guitar.', 52, 2, NULL, NULL),
(96, 'Quiet', '/ˈkwaɪət/', 'Yên tĩnh', 'The library is a very quiet place.', 52, 3, NULL, NULL),
(97, 'Quickly', '/ˈkwɪkli/', 'Nhanh chóng', 'He quickly finished his homework.', 52, 4, NULL, NULL),
(98, 'Among', '/əˈmʌŋ/', 'Ở giữa', 'The teacher walked among the students.', 52, 5, NULL, NULL),
(99, 'Although', '/ɔːlˈðoʊ/', 'Mặc dù', 'Although it was raining, we still went to school.', 52, 6, NULL, NULL),
(100, 'Wow', '/waʊ/', 'Ồ', 'Wow! That\'s an amazing drawing.', 52, 7, NULL, NULL),
(101, 'Everyone', '/ˈevriwʌn/', 'Mọi người', 'Everyone in the class passed the test.', 52, 8, NULL, NULL),
(102, 'That', '/ðæt/', 'Kia, đó', 'That is my school over there.', 52, 9, NULL, NULL),
(103, 'Classroom', '/ˈklæsruːm/', 'Phòng học', 'The students are in the classroom.', 52, 1, NULL, NULL),
(104, 'Challenge', '/ˈtʃælɪndʒ/', 'Thử thách', 'Life is full of challenges.', 53, 1, NULL, NULL),
(105, 'Hope', '/hoʊp/', 'Hy vọng', 'We should always have hope for the future.', 53, 1, NULL, NULL),
(106, 'Remember', '/rɪˈmembər/', 'Ghi nhớ', 'Remember to cherish every moment.', 53, 2, NULL, NULL),
(107, 'Journey', '/ˈdʒɜːrni/', 'Hành trình', 'Life is a journey.', 53, 1, NULL, NULL),
(108, 'Death', '/deθ/', 'Cái chết', 'Death is a natural part of life.', 53, 1, NULL, NULL),
(109, 'Textbook', '/ˈtekstbʊk/', 'Sách giáo khoa', 'I need to buy a new textbook for my history class.', 54, 1, NULL, NULL),
(110, 'Learn', '/lɜːrn/', 'Học hỏi', 'I want to learn a new language.', 54, 2, NULL, NULL),
(111, 'Clever', '/ˈklevər/', 'Thông minh', 'She is a clever student.', 54, 3, NULL, NULL),
(112, 'Quickly', '/ˈkwɪkli/', 'Nhanh chóng', 'He finished the exam quickly.', 54, 4, NULL, NULL),
(113, 'Classroom', '/ˈklæsruːm/', 'Phòng học', 'The classroom is clean and tidy.', 54, 1, NULL, NULL),
(114, 'Teacher', '/ˈtiːtʃər/', 'Giáo viên', 'The teacher is explaining the lesson.', 54, 1, NULL, NULL),
(115, 'Homework', '/ˈhoʊmwɜːrk/', 'Bài tập về nhà', 'I have a lot of homework to do tonight.', 54, 1, NULL, NULL),
(116, 'Exam', '/ɪɡˈzæm/', 'Bài kiểm tra', 'I have an exam next week.', 54, 1, NULL, NULL),
(117, 'Study', '/ˈstʌdi/', 'Học tập', 'I need to study for my exam.', 54, 2, NULL, NULL),
(118, 'Absent', '/ˈæbsənt/', 'Vắng mặt', 'He was absent from school yesterday.', 54, 3, NULL, NULL);

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
-- Chỉ mục cho bảng `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `level_id` (`level_id`);

--
-- Chỉ mục cho bảng `exam_answers`
--
ALTER TABLE `exam_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_question_id` (`exam_question_id`),
  ADD KEY `result_exam_id` (`result_exam_id`);

--
-- Chỉ mục cho bảng `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`);

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
-- Chỉ mục cho bảng `result_exams`
--
ALTER TABLE `result_exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `exam_id` (`exam_id`);

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
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `type_id` (`type_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `audios`
--
ALTER TABLE `audios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=437;

--
-- AUTO_INCREMENT cho bảng `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `exam_answers`
--
ALTER TABLE `exam_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;

--
-- AUTO_INCREMENT cho bảng `exam_questions`
--
ALTER TABLE `exam_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `result_exams`
--
ALTER TABLE `result_exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `topic_vocabularys`
--
ALTER TABLE `topic_vocabularys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT cho bảng `type_vocabularys`
--
ALTER TABLE `type_vocabularys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `vocabularys`
--
ALTER TABLE `vocabularys`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `audios`
--
ALTER TABLE `audios`
  ADD CONSTRAINT `audios_ibfk_1` FOREIGN KEY (`listening_id`) REFERENCES `listening_exercises` (`id`);

--
-- Các ràng buộc cho bảng `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`);

--
-- Các ràng buộc cho bảng `exam_answers`
--
ALTER TABLE `exam_answers`
  ADD CONSTRAINT `exam_answers_ibfk_1` FOREIGN KEY (`exam_question_id`) REFERENCES `exam_questions` (`id`),
  ADD CONSTRAINT `exam_answers_ibfk_2` FOREIGN KEY (`result_exam_id`) REFERENCES `result_exams` (`id`);

--
-- Các ràng buộc cho bảng `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD CONSTRAINT `exam_questions_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`);

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
-- Các ràng buộc cho bảng `result_exams`
--
ALTER TABLE `result_exams`
  ADD CONSTRAINT `result_exams_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `result_exams_ibfk_2` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`);

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
  ADD CONSTRAINT `vocabularys_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `topic_vocabularys` (`id`),
  ADD CONSTRAINT `vocabularys_ibfk_3` FOREIGN KEY (`type_id`) REFERENCES `type_vocabularys` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
