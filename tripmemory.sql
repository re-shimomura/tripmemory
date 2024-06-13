-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-06-13 10:13:42
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `tripmemory`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `material`
--

CREATE TABLE `material` (
  `id` int(11) NOT NULL,
  `triptitle` varchar(255) NOT NULL,
  `day` date NOT NULL,
  `place` varchar(255) NOT NULL,
  `spot1` varchar(255) NOT NULL,
  `comment1` varchar(255) NOT NULL,
  `spot2` varchar(255) NOT NULL,
  `comment2` varchar(255) NOT NULL,
  `spot3` varchar(255) NOT NULL,
  `comment3` varchar(255) NOT NULL,
  `spot4` varchar(255) NOT NULL,
  `comment4` varchar(255) NOT NULL,
  `spot5` varchar(255) NOT NULL,
  `comment5` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL,
  `flag` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- テーブルのデータのダンプ `material`
--

INSERT INTO `material` (`id`, `triptitle`, `day`, `place`, `spot1`, `comment1`, `spot2`, `comment2`, `spot3`, `comment3`, `spot4`, `comment4`, `spot5`, `comment5`, `remarks`, `userid`, `flag`) VALUES
(1, '大阪usj旅行', '2024-06-12', '大阪府', '串カツ田中', '１０本食べた。', '', '0', '', '', '0', '0', '', '', '旅費の合計は約2万円', 0, 0),
(2, '茨城食べ歩き', '2024-06-01', '茨城県', 'なかみなと', '海鮮丼2000円', '', '0', '', '', '0', '0', '', '', 'ゆっくりできた', 0, 0),
(3, '茨城食べ歩き', '2024-06-01', '茨城県', 'なかみなと', '海鮮丼3000円', '', '0', '', '', '0', '0', '', '', 'ゆっくりできた', 0, 0),
(4, '茨城食べ歩き', '2024-06-01', '茨城県', 'なかみなと', '海鮮丼3000円', '', '0', '', '', '0', '0', '', '', 'ゆっくりできた', 0, 0),
(5, '茨城食べ歩き', '2024-06-01', '茨城県', 'なかみなと', '海鮮丼5000円', '', '0', '', '', '0', '0', '', '', '駐車場があまりない', 0, 0),
(6, '京都食べ歩き家族旅行', '2024-06-15', '京都府', '清水寺', '工事終わっていた', '', '0', '', '', '0', '0', '', '', '新幹線がとても混んでいた', 1234, 1),
(7, '横浜中華街', '2024-06-22', '神奈川県', '小籠包', 'やけどした', '', '0', '', '', '0', '0', '', '', '小籠包は９００円', 1234, 1),
(8, '横浜中華街', '2024-06-22', '神奈川県', '小籠包', 'やけどした', '', '0', '', '', '0', '0', '', '', '小籠包は９００円', 1234, 1),
(9, '横浜中華街', '2024-06-22', '神奈川県', '小籠包', 'やけどした', '', '0', '', '', '0', '0', '', '', '小籠包は９００円', 1234, 1),
(10, '奈良旅行', '2024-06-23', '奈良県', '奈良公園', '鹿が沢山いた', '', '0', '', '', '0', '0', '', '', '鹿せんべいをあげた', 1234, 1),
(11, '北海道', '2024-06-06', '北海道', '函館', '散歩した', '', '0', '', '', '0', '0', '', '', '飛行機が遅延して大変だった', 1234, 1),
(12, '北海道', '2024-06-06', '北海道', '函館', '散歩した', '', '0', '', '', '0', '0', '', '', '飛行機が遅延して大変だった', 1234, 1),
(13, '北海道', '2024-06-06', '北海道', '函館', '散歩した', '', '0', '', '', '0', '0', '', '', '飛行機が遅延して大変だった', 1234, 1),
(14, '北海道', '2024-06-06', '北海道', '函館', '散歩した', '', '0', '', '', '0', '0', '', '', '飛行機が遅延して大変だった', 1234, 1),
(15, '北海道', '2024-06-06', '北海道', '函館', '散歩した', '', '0', '', '', '0', '0', '', '', '飛行機が遅延して大変だった', 1234, 0),
(16, '北海道', '2024-06-06', '北海道', '函館', '散歩した', '', '0', '', '', '0', '0', '', '', '飛行機が遅延して大変だった', 1234, 0),
(17, '北海道', '2024-06-06', '北海道', '函館', '散歩した', '', '0', '', '', '0', '0', '', '', '飛行機が遅延して大変だった', 1234, 0),
(18, '箱根旅行', '2024-06-01', '神奈川県', '彫刻の森美術館', 'すごかった', 'スポット２', 'コメント2', 'スポット３', 'コメント３', 'スポット4', 'コメント４', 'スポット５', 'コメント５', 'バスの移動は大変', 1234, 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `permission` varchar(255) NOT NULL,
  `flag` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `userid`, `password`, `permission`, `flag`) VALUES
(1, 0, '1234', '', 1),
(2, 1234, '1234', '', 0),
(3, 1111, '1111', 'admin', 1);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `material`
--
ALTER TABLE `material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
