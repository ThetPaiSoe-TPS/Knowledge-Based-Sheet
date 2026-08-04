-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2026 at 02:44 AM
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
-- Database: `knowledge-based-sheet`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `content`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'This is a test comment!', 1, '2026-08-03 04:48:09', '2026-08-03 04:48:09'),
(2, 2, 2, 'Test comment', 1, '2026-08-03 04:48:51', '2026-08-03 04:48:51');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `title`, `description`, `images`, `created_at`, `updated_at`) VALUES
(1, 'title 924', 'desc 924', '[\"storage\\/uploads\\/8fa82f36-3934-4104-b26d-e9839c7a1668.jpg\",\"storage\\/uploads\\/464d66da-3799-4103-838b-a2aa8882f618.jpg\"]', '2026-07-30 08:27:16', '2026-07-30 09:18:15');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
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

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"e35c57dd-c0b9-4572-a414-da2e8451d646\",\"displayName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"60\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendNewsletterEmail\\\":3:{s:10:\\\"subscriber\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Subscriber\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:10:\\\"newsletter\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Newsletter\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:7:\\\"batchId\\\";s:36:\\\"a26a5010-7500-4d32-921c-5cfd2432b5a3\\\";}\",\"batchId\":\"a26a5010-7500-4d32-921c-5cfd2432b5a3\"},\"createdAt\":1785774935,\"delay\":null}', 0, NULL, 1785774935, 1785774935),
(2, 'default', '{\"uuid\":\"732c608d-59c0-4526-a019-5cddb6715fae\",\"displayName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"60\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendNewsletterEmail\\\":3:{s:10:\\\"subscriber\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Subscriber\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:10:\\\"newsletter\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Newsletter\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:7:\\\"batchId\\\";s:36:\\\"a26a5010-7500-4d32-921c-5cfd2432b5a3\\\";}\",\"batchId\":\"a26a5010-7500-4d32-921c-5cfd2432b5a3\"},\"createdAt\":1785774935,\"delay\":null}', 0, NULL, 1785774935, 1785774935),
(3, 'default', '{\"uuid\":\"d5f1c985-489c-4684-8e31-f0a80b293b4e\",\"displayName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"60\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendNewsletterEmail\\\":3:{s:10:\\\"subscriber\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Subscriber\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:10:\\\"newsletter\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Newsletter\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:7:\\\"batchId\\\";s:36:\\\"a26a53c6-70d7-407c-b836-47bca28068b9\\\";}\",\"batchId\":\"a26a53c6-70d7-407c-b836-47bca28068b9\"},\"createdAt\":1785775557,\"delay\":null}', 0, NULL, 1785775557, 1785775557),
(4, 'default', '{\"uuid\":\"f0413e10-bb5c-419a-81db-620a1e6e665b\",\"displayName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"60\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendNewsletterEmail\\\":3:{s:10:\\\"subscriber\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Subscriber\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:10:\\\"newsletter\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Newsletter\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:7:\\\"batchId\\\";s:36:\\\"a26a53c6-70d7-407c-b836-47bca28068b9\\\";}\",\"batchId\":\"a26a53c6-70d7-407c-b836-47bca28068b9\"},\"createdAt\":1785775557,\"delay\":null}', 0, NULL, 1785775557, 1785775557),
(5, 'default', '{\"uuid\":\"83bb3657-4b5b-412e-a595-e00814874333\",\"displayName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"60\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendNewsletterEmail\\\":3:{s:10:\\\"subscriber\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Subscriber\\\";s:2:\\\"id\\\";i:4;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:10:\\\"newsletter\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Newsletter\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:7:\\\"batchId\\\";s:36:\\\"a26a53c6-70d7-407c-b836-47bca28068b9\\\";}\",\"batchId\":\"a26a53c6-70d7-407c-b836-47bca28068b9\"},\"createdAt\":1785775557,\"delay\":null}', 0, NULL, 1785775557, 1785775557),
(6, 'default', '{\"uuid\":\"a544f788-1bcc-46cc-a1c2-815b8cc0c562\",\"displayName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"60\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendNewsletterEmail\\\":3:{s:10:\\\"subscriber\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Subscriber\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:10:\\\"newsletter\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Newsletter\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:7:\\\"batchId\\\";s:36:\\\"a26a53c6-70d7-407c-b836-47bca28068b9\\\";}\",\"batchId\":\"a26a53c6-70d7-407c-b836-47bca28068b9\"},\"createdAt\":1785775557,\"delay\":null}', 0, NULL, 1785775557, 1785775557),
(7, 'default', '{\"uuid\":\"0eb31ffd-d8cf-420f-b08b-17d5e99498ed\",\"displayName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"60\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendNewsletterEmail\\\":3:{s:10:\\\"subscriber\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Subscriber\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:10:\\\"newsletter\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Newsletter\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:7:\\\"batchId\\\";s:36:\\\"a26a53c6-70d7-407c-b836-47bca28068b9\\\";}\",\"batchId\":\"a26a53c6-70d7-407c-b836-47bca28068b9\"},\"createdAt\":1785775557,\"delay\":null}', 0, NULL, 1785775557, 1785775557),
(8, 'default', '{\"uuid\":\"e43611b0-448a-4ebb-9b6b-303049006d87\",\"displayName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"60\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendNewsletterEmail\\\":3:{s:10:\\\"subscriber\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Subscriber\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:10:\\\"newsletter\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Newsletter\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:7:\\\"batchId\\\";s:36:\\\"a26a53c6-70d7-407c-b836-47bca28068b9\\\";}\",\"batchId\":\"a26a53c6-70d7-407c-b836-47bca28068b9\"},\"createdAt\":1785775557,\"delay\":null}', 0, NULL, 1785775557, 1785775557),
(9, 'default', '{\"uuid\":\"3f0cd569-a379-4674-8ce1-5159e13d2506\",\"displayName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"60\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendNewsletterEmail\\\":3:{s:10:\\\"subscriber\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Subscriber\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:10:\\\"newsletter\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Newsletter\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:7:\\\"batchId\\\";s:36:\\\"a26a53c6-70d7-407c-b836-47bca28068b9\\\";}\",\"batchId\":\"a26a53c6-70d7-407c-b836-47bca28068b9\"},\"createdAt\":1785775557,\"delay\":null}', 0, NULL, 1785775557, 1785775557),
(10, 'default', '{\"uuid\":\"b5e09e21-838b-4946-a631-677a6088579d\",\"displayName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"60\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendNewsletterEmail\\\":3:{s:10:\\\"subscriber\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Subscriber\\\";s:2:\\\"id\\\";i:9;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:10:\\\"newsletter\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Newsletter\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:7:\\\"batchId\\\";s:36:\\\"a26a53c6-70d7-407c-b836-47bca28068b9\\\";}\",\"batchId\":\"a26a53c6-70d7-407c-b836-47bca28068b9\"},\"createdAt\":1785775557,\"delay\":null}', 0, NULL, 1785775557, 1785775557),
(11, 'default', '{\"uuid\":\"847eeb76-b4b3-4f7f-9c05-3448312a7c79\",\"displayName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"60\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendNewsletterEmail\\\":3:{s:10:\\\"subscriber\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Subscriber\\\";s:2:\\\"id\\\";i:10;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:10:\\\"newsletter\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Newsletter\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:7:\\\"batchId\\\";s:36:\\\"a26a53c6-70d7-407c-b836-47bca28068b9\\\";}\",\"batchId\":\"a26a53c6-70d7-407c-b836-47bca28068b9\"},\"createdAt\":1785775557,\"delay\":null}', 0, NULL, 1785775557, 1785775557),
(12, 'default', '{\"uuid\":\"9b440b73-c08c-41d0-88e5-b29bf3c5b9e5\",\"displayName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"60\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendNewsletterEmail\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SendNewsletterEmail\\\":3:{s:10:\\\"subscriber\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Subscriber\\\";s:2:\\\"id\\\";i:11;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:10:\\\"newsletter\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Newsletter\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:7:\\\"batchId\\\";s:36:\\\"a26a53c6-70d7-407c-b836-47bca28068b9\\\";}\",\"batchId\":\"a26a53c6-70d7-407c-b836-47bca28068b9\"},\"createdAt\":1785775557,\"delay\":null}', 0, NULL, 1785775557, 1785775557);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
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

--
-- Dumping data for table `job_batches`
--

INSERT INTO `job_batches` (`id`, `name`, `total_jobs`, `pending_jobs`, `failed_jobs`, `failed_job_ids`, `options`, `cancelled_at`, `created_at`, `finished_at`) VALUES
('a26a5010-7500-4d32-921c-5cfd2432b5a3', '', 2, 2, 0, '[]', 'a:3:{s:4:\"then\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:659:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:10:\"newsletter\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:21:\"App\\Models\\Newsletter\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}}s:8:\"function\";s:230:\"function () use ($newsletter) {\n                // All jobs completed\n                $newsletter->update([\n                    \'status\' => \'completed\',\n                    \'completed_at\' => now()\n                ]);\n            }\";s:5:\"scope\";s:41:\"App\\Http\\Controllers\\NewsletterController\";s:4:\"this\";N;s:4:\"self\";s:32:\"00000000000005ad0000000000000000\";}\";s:4:\"hash\";s:44:\"i4/pibuv8A64KdFnDAmk5+Te0klbTKAp1bFxciHqlX4=\";}}}s:5:\"catch\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:683:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:10:\"newsletter\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:21:\"App\\Models\\Newsletter\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}}s:8:\"function\";s:254:\"function ($batch, $e) use ($newsletter) {\n                // Some jobs failed\n                $newsletter->update([\'status\' => \'failed\']);\n                \\App\\Http\\Controllers\\Log::error(\"❌ Newsletter batch failed: \" . $e->getMessage());\n            }\";s:5:\"scope\";s:41:\"App\\Http\\Controllers\\NewsletterController\";s:4:\"this\";N;s:4:\"self\";s:32:\"00000000000005aa0000000000000000\";}\";s:4:\"hash\";s:44:\"gxEJMGCnR2gzqbB0rKr6bejT7zKfblHr9dmU7//kgig=\";}}}s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:630:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:10:\"newsletter\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:21:\"App\\Models\\Newsletter\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}}s:8:\"function\";s:201:\"function () use ($newsletter) {\n                // Done regardless of success/failure\n                \\App\\Http\\Controllers\\Log::info(\"📊 Newsletter #{$newsletter->id} batch finished\");\n            }\";s:5:\"scope\";s:41:\"App\\Http\\Controllers\\NewsletterController\";s:4:\"this\";N;s:4:\"self\";s:32:\"00000000000005a60000000000000000\";}\";s:4:\"hash\";s:44:\"IsN6zWqMynxwGZDBpq4Ge8SZdWPEHkiAL8VH9Zxu7dY=\";}}}}', NULL, 1785774935, NULL),
('a26a53c6-70d7-407c-b836-47bca28068b9', '', 10, 10, 0, '[]', 'a:3:{s:4:\"then\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:659:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:10:\"newsletter\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:21:\"App\\Models\\Newsletter\";s:2:\"id\";i:3;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}}s:8:\"function\";s:230:\"function () use ($newsletter) {\n                // All jobs completed\n                $newsletter->update([\n                    \'status\' => \'completed\',\n                    \'completed_at\' => now()\n                ]);\n            }\";s:5:\"scope\";s:41:\"App\\Http\\Controllers\\NewsletterController\";s:4:\"this\";N;s:4:\"self\";s:32:\"00000000000005ad0000000000000000\";}\";s:4:\"hash\";s:44:\"mSV3PHO1rZIvyk4J1UvYI1Wc13kjEy64UXMJzi23TGo=\";}}}s:5:\"catch\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:689:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:10:\"newsletter\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:21:\"App\\Models\\Newsletter\";s:2:\"id\";i:3;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}}s:8:\"function\";s:260:\"function ($batch, $e) use ($newsletter) {\n                // Some jobs failed\n                $newsletter->update([\'status\' => \'failed\']);\n                \\Illuminate\\Support\\Facades\\Log::error(\"❌ Newsletter batch failed: \" . $e->getMessage());\n            }\";s:5:\"scope\";s:41:\"App\\Http\\Controllers\\NewsletterController\";s:4:\"this\";N;s:4:\"self\";s:32:\"00000000000005aa0000000000000000\";}\";s:4:\"hash\";s:44:\"a8b4m/PegZLhySwlrSHWKPtjRBw5tvqwAvca/U1KEyo=\";}}}s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:636:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:10:\"newsletter\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:21:\"App\\Models\\Newsletter\";s:2:\"id\";i:3;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}}s:8:\"function\";s:207:\"function () use ($newsletter) {\n                // Done regardless of success/failure\n                \\Illuminate\\Support\\Facades\\Log::info(\"📊 Newsletter #{$newsletter->id} batch finished\");\n            }\";s:5:\"scope\";s:41:\"App\\Http\\Controllers\\NewsletterController\";s:4:\"this\";N;s:4:\"self\";s:32:\"00000000000005a60000000000000000\";}\";s:4:\"hash\";s:44:\"GnbDUku+RPz9uXYdKjmH1H6x+ClApY6ywwFrzwJByZM=\";}}}}', NULL, 1785775557, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_07_30_035721_add_status_to_users_table', 1),
(5, '2026_07_30_094320_create_uploads_table', 1),
(6, '2026_07_30_135258_create_items_table', 2),
(7, '2026_07_31_041014_create_posts_table', 3),
(8, '2026_07_31_041837_create_comments_table', 3),
(9, '2026_08_03_031423_create_notifications_table', 3),
(10, '2026_08_03_094813_create_orders_table', 3),
(11, '2026_08_03_114214_create_personal_access_tokens_table', 4),
(12, '2026_08_03_141425_create_temp_files_table', 5),
(13, '2026_08_03_162613_create_subscribers_table', 6),
(14, '2026_08_03_162641_create_newsletters_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `total_recipients` int(11) NOT NULL DEFAULT 0,
  `sent_count` int(11) NOT NULL DEFAULT 0,
  `failed_count` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `newsletters`
--

INSERT INTO `newsletters` (`id`, `subject`, `content`, `total_recipients`, `sent_count`, `failed_count`, `status`, `scheduled_at`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 'Weekly Newsletter', 'Hello subscribers! This is our weekly newsletter with exciting updates...', 2, 0, 0, 'processing', NULL, NULL, '2026-08-03 10:05:33', '2026-08-03 10:05:33'),
(2, 'Test Newsletter', 'This is a test newsletter content', 10, 0, 0, 'pending', NULL, NULL, '2026-08-03 10:10:04', '2026-08-03 10:10:04'),
(3, 'Weekly Newsletter', 'Hello subscribers! This is our weekly newsletter with exciting updates...', 10, 0, 0, 'processing', NULL, NULL, '2026-08-03 10:15:57', '2026-08-03 10:15:57');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
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
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('4d90b1d1-9e6e-4e87-86b1-bb97e9465295', 'new_comment', 'App\\Models\\User', 1, '{\"comment_id\":1,\"post_id\":1,\"commenter_name\":\"John Doe\",\"comment_content\":\"This is a test comment!\",\"message\":\"John Doe commented on your post\"}', '2026-08-03 05:30:24', '2026-08-03 04:48:36', '2026-08-03 05:30:24'),
('a311442c-a400-4e4f-a639-d0936df0adb9', 'App\\Notifications\\OrderShippedNotification', 'App\\Models\\User', 4, '{\"order_id\":4,\"order_total\":\"150.50\",\"address\":\"123 Main Street, New York, NY 10001\",\"message\":\"Order #4 has been shipped!\",\"type\":\"order_shipped\"}', '2026-08-03 07:13:28', '2026-08-03 05:38:52', '2026-08-03 07:13:28'),
('c8e8c518-eb2d-4ff9-90e9-027c498639ab', 'App\\Notifications\\OrderShippedNotification', 'App\\Models\\User', 2, '{\"order_id\":2,\"order_total\":150.5,\"address\":\"123 Main St, NY\",\"message\":\"Order #2 has been shipped!\",\"type\":\"order_shipped\"}', NULL, '2026-08-03 04:48:51', '2026-08-03 04:48:51'),
('d24e5eb4-76f5-4c5e-97a5-3dd5f94905e7', 'App\\Notifications\\OrderShippedNotification', 'App\\Models\\User', 1, '{\"order_id\":1,\"order_total\":150.5,\"address\":\"123 Main St, NY\",\"message\":\"Order #1 has been shipped!\",\"type\":\"order_shipped\"}', '2026-08-03 05:30:24', '2026-08-03 04:48:14', '2026-08-03 05:30:24'),
('e63c56ab-534d-4bcd-a34d-a6f15c3584e8', 'new_comment', 'App\\Models\\User', 2, '{\"comment_id\":2,\"post_id\":2,\"commenter_name\":\"Test User\",\"comment_content\":\"Test comment\",\"message\":\"Test User commented on your post\"}', NULL, '2026-08-03 04:48:51', '2026-08-03 04:48:51');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `address`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 150.50, '123 Main St, NY', 'pending', '2026-08-03 04:48:13', '2026-08-03 04:48:13'),
(2, 2, 150.50, '123 Main St, NY', 'pending', '2026-08-03 04:48:51', '2026-08-03 04:48:51'),
(3, 1, 150.50, '123 Main St, NY', 'pending', '2026-08-03 05:29:41', '2026-08-03 05:29:41'),
(4, 4, 150.50, '123 Main Street, New York, NY 10001', 'shipped', '2026-08-03 05:34:44', '2026-08-03 05:38:52');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 4, 'auth_token', '26a0636ca32bef8fd370294d6f5ae124243a5004505dfc15e53efb4435b800a4', '[\"*\"]', NULL, NULL, '2026-08-03 05:18:07', '2026-08-03 05:18:07'),
(2, 'App\\Models\\User', 4, 'auth_token', 'c50441b1494227b5c0df57d7275ff1b343abc133124a5fdfc377bb3a7092bc18', '[\"*\"]', '2026-08-03 10:15:57', NULL, '2026-08-03 05:18:57', '2026-08-03 10:15:57');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `content`, `slug`, `is_published`, `created_at`, `updated_at`) VALUES
(1, 1, 'My First Post', 'This is the content of my first post.', 'my-first-post-1785755884', 1, '2026-08-03 04:48:04', '2026-08-03 04:48:04'),
(2, 2, 'Test Post', 'Test content', 'test-post-1785755931', 1, '2026-08-03 04:48:51', '2026-08-03 04:48:51');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('xytvnUDdQAm3penxSdI7r8LkiHeNmRtHCMpMkjJz', NULL, '127.0.0.1', 'PostmanRuntime/7.55.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSEk0bnRWT3JwaXpJSDM5UGlSUjl0MnBJU0UzUVhhTWk4a1g2WXA3eSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9ob21lIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1785418101);

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `subscribed_at` timestamp NULL DEFAULT NULL,
  `unsubscribed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `name`, `is_active`, `subscribed_at`, `unsubscribed_at`, `created_at`, `updated_at`) VALUES
(1, 'user1@example.com', 'User 1', 1, '2026-08-03 10:02:00', NULL, '2026-08-03 10:02:00', '2026-08-03 10:02:00'),
(2, 'user2@example.com', 'User 2', 1, '2026-08-03 10:02:08', NULL, '2026-08-03 10:02:08', '2026-08-03 10:02:08'),
(4, 'user3@example.com', 'User 3', 1, '2026-08-03 10:09:38', NULL, '2026-08-03 10:09:38', '2026-08-03 10:09:38'),
(5, 'user4@example.com', 'User 4', 1, '2026-08-03 10:09:38', NULL, '2026-08-03 10:09:38', '2026-08-03 10:09:38'),
(6, 'user5@example.com', 'User 5', 1, '2026-08-03 10:09:38', NULL, '2026-08-03 10:09:38', '2026-08-03 10:09:38'),
(7, 'user6@example.com', 'User 6', 1, '2026-08-03 10:09:38', NULL, '2026-08-03 10:09:38', '2026-08-03 10:09:38'),
(8, 'user7@example.com', 'User 7', 1, '2026-08-03 10:09:38', NULL, '2026-08-03 10:09:38', '2026-08-03 10:09:38'),
(9, 'user8@example.com', 'User 8', 1, '2026-08-03 10:09:38', NULL, '2026-08-03 10:09:38', '2026-08-03 10:09:38'),
(10, 'user9@example.com', 'User 9', 1, '2026-08-03 10:09:38', NULL, '2026-08-03 10:09:38', '2026-08-03 10:09:38'),
(11, 'user10@example.com', 'User 10', 1, '2026-08-03 10:09:38', NULL, '2026-08-03 10:09:38', '2026-08-03 10:09:38');

-- --------------------------------------------------------

--
-- Table structure for table `temp_files`
--

CREATE TABLE `temp_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_size` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `temp_files`
--

INSERT INTO `temp_files` (`id`, `file_name`, `file_path`, `file_type`, `file_size`, `status`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'file_1.tmp', 'C:\\Project\\Knowledge-Based-Sheet\\storage\\app/temp/file_1.tmp', 'text/plain', 4617, 'active', NULL, '2026-08-03 07:48:31', '2026-08-03 07:48:31'),
(2, 'file_2.tmp', 'C:\\Project\\Knowledge-Based-Sheet\\storage\\app/temp/file_2.tmp', 'text/plain', 3906, 'active', NULL, '2026-08-03 07:48:31', '2026-08-03 07:48:31'),
(3, 'file_3.tmp', 'C:\\Project\\Knowledge-Based-Sheet\\storage\\app/temp/file_3.tmp', 'text/plain', 7592, 'active', NULL, '2026-08-03 07:48:31', '2026-08-03 07:48:31'),
(4, 'file_4.tmp', 'C:\\Project\\Knowledge-Based-Sheet\\storage\\app/temp/file_4.tmp', 'text/plain', 2152, 'active', NULL, '2026-08-03 07:48:31', '2026-08-03 07:48:31'),
(5, 'file_5.tmp', 'C:\\Project\\Knowledge-Based-Sheet\\storage\\app/temp/file_5.tmp', 'text/plain', 4999, 'active', NULL, '2026-08-03 07:48:31', '2026-08-03 07:48:31'),
(6, 'expiring_file.tmp', 'C:\\Project\\Knowledge-Based-Sheet\\storage\\app/temp/expiring_file.tmp', 'text/plain', 2048, 'active', '2026-08-03 05:49:03', '2026-08-03 07:49:03', '2026-08-03 07:49:03');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_size` varchar(255) NOT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('active','inactive','pending','suspend') NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'john1785755879@example.com', 'active', NULL, '$2y$12$xkKOixnw8MaH8B4DlBUUde8ogFMcaq33U.sMNfVlHyyTqjCpBxAR6', NULL, '2026-08-03 04:47:59', '2026-08-03 04:47:59'),
(2, 'Test User', 'test1785755931@example.com', 'active', NULL, '$2y$12$IjQLh0RwusVHudEdNARYEeQfIASuYi6c9D2CvaGlwgR34i74o4Elu', NULL, '2026-08-03 04:48:51', '2026-08-03 04:48:51'),
(3, 'Test User', 'test@example.com', 'active', NULL, '$2y$12$xSmRLCBqtl4tl.1/YMt73e1viyZB0u9AbEWTmmpEKZW8t8Wztg.nK', NULL, '2026-08-03 05:16:21', '2026-08-03 05:16:21'),
(4, 'User1', 'user1@a.com', 'active', NULL, '$2y$12$vdxgsOHAakpXHtnvNil.C.EMnwLj4.c4b2FrpGBhfDHrTJ0w0ajZ.', NULL, '2026-08-03 05:18:07', '2026-08-03 05:18:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_post_id_is_approved_index` (`post_id`,`is_approved`),
  ADD KEY `comments_user_id_index` (`user_id`),
  ADD KEY `comments_created_at_index` (`created_at`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`),
  ADD KEY `posts_user_id_index` (`user_id`),
  ADD KEY `posts_is_published_index` (`is_published`),
  ADD KEY `posts_created_at_index` (`created_at`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscribers_email_unique` (`email`);

--
-- Indexes for table `temp_files`
--
ALTER TABLE `temp_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `temp_files`
--
ALTER TABLE `temp_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
