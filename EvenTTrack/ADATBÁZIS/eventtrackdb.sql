-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2020. Már 31. 21:58
-- Kiszolgáló verziója: 10.4.6-MariaDB
-- PHP verzió: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `eventtrackdb`
--
CREATE DATABASE IF NOT EXISTS `eventtrackdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci;
USE `eventtrackdb`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

DROP TABLE IF EXISTS `felhasznalok`;
CREATE TABLE `felhasznalok` (
  `f_id` int(11) NOT NULL,
  `f_nev` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `f_felhasznalonev` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `f_email` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `f_jelszo` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `f_regdatum` date NOT NULL,
  `f_token` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `f_tokenLejarat` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `f_telefonszam` varchar(15) COLLATE utf8_hungarian_ci NOT NULL,
  `f_kep` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `f_jogosultsag` varchar(10) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- TÁBLA KAPCSOLATAI `felhasznalok`:
--

--
-- A tábla adatainak kiíratása `felhasznalok`
--

INSERT INTO `felhasznalok` (`f_id`, `f_nev`, `f_felhasznalonev`, `f_email`, `f_jelszo`, `f_regdatum`, `f_token`, `f_tokenLejarat`, `f_telefonszam`, `f_kep`, `f_jogosultsag`) VALUES
(4, 'user', 'user', 'admin@admin.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2020-03-28', '', '2020-03-28 14:29:03.486684', '06702223232', 'feltoltesek/EvenTTrack_alapkep.jpg', 'user'),
(5, 'admin', 'admin', 'admin@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2020-03-28', 'hu7z29eqm6', '2020-03-31 16:50:20.000000', '06702223232', 'feltoltesek/adminKep.png', 'admin'),
(10, 'User2', 'User2', 'user2@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2020-03-31', '', '2020-03-31 12:56:32.730820', '02303033030', '../tesztkepek/EvenTTrack_alapkep.jpg', 'user');

--
-- Eseményindítók `felhasznalok`
--
DROP TRIGGER IF EXISTS `after_ins_temaTablaba`;
DELIMITER $$
CREATE TRIGGER `after_ins_temaTablaba` AFTER INSERT ON `felhasznalok` FOR EACH ROW INSERT INTO tema (aktualis_tema,tema_f_id) VALUES("kek",new.f_id)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jegyzetek`
--

DROP TABLE IF EXISTS `jegyzetek`;
CREATE TABLE `jegyzetek` (
  `id` int(11) NOT NULL,
  `jegyzet_id` varchar(114) COLLATE utf8_hungarian_ci NOT NULL,
  `jegyzet_szin` int(11) NOT NULL,
  `jegyzet_szoveg` text COLLATE utf8_hungarian_ci NOT NULL,
  `jegyzetek_f_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- TÁBLA KAPCSOLATAI `jegyzetek`:
--   `jegyzetek_f_id`
--       `felhasznalok` -> `f_id`
--

--
-- A tábla adatainak kiíratása `jegyzetek`
--

INSERT INTO `jegyzetek` (`id`, `jegyzet_id`, `jegyzet_szin`, `jegyzet_szoveg`, `jegyzetek_f_id`) VALUES
(2, '220209', 4, 'adminJegyzet1', 5),
(9, '2202019', 3, 'Admin Jegyzet', 5),
(10, '2202016', 1, 'Admin Jegyzet sok', 5),
(11, '2202024', 5, 'Admin Jegyzet', 5),
(12, '220205', 2, 'Admin Jegyzet', 5),
(13, '2202010', 4, 'UserJegyzet', 4);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tema`
--

DROP TABLE IF EXISTS `tema`;
CREATE TABLE `tema` (
  `id` int(11) NOT NULL,
  `aktualis_tema` varchar(20) COLLATE utf8_hungarian_ci NOT NULL,
  `tema_f_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- TÁBLA KAPCSOLATAI `tema`:
--   `tema_f_id`
--       `felhasznalok` -> `f_id`
--

--
-- A tábla adatainak kiíratása `tema`
--

INSERT INTO `tema` (`id`, `aktualis_tema`, `tema_f_id`) VALUES
(4, 'piros', 4),
(5, 'piros', 5),
(10, 'kek', 10);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`f_id`);

--
-- A tábla indexei `jegyzetek`
--
ALTER TABLE `jegyzetek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jegyzet_f_id` (`jegyzetek_f_id`);

--
-- A tábla indexei `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tema_f_id` (`tema_f_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `jegyzetek`
--
ALTER TABLE `jegyzetek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT a táblához `tema`
--
ALTER TABLE `tema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `jegyzetek`
--
ALTER TABLE `jegyzetek`
  ADD CONSTRAINT `felhasznaloID` FOREIGN KEY (`jegyzetek_f_id`) REFERENCES `felhasznalok` (`f_id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `tema`
--
ALTER TABLE `tema`
  ADD CONSTRAINT `felhasznaloID_tema` FOREIGN KEY (`tema_f_id`) REFERENCES `felhasznalok` (`f_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
