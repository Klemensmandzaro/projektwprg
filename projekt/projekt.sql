-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 14 Cze 2024, 22:11
-- Wersja serwera: 10.4.22-MariaDB
-- Wersja PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `projekt`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dzien`
--

CREATE TABLE `dzien` (
  `id` int(11) NOT NULL,
  `dzien` int(11) NOT NULL,
  `miesiac` text NOT NULL,
  `rok` int(11) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `imie` text NOT NULL,
  `nazwisko` text NOT NULL,
  `cena` int(11) NOT NULL,
  `ocena` int(11) NOT NULL,
  `opinia` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `dzien`
--

INSERT INTO `dzien` (`id`, `dzien`, `miesiac`, `rok`, `mail`, `imie`, `nazwisko`, `cena`, `ocena`, `opinia`) VALUES
(15, 6, '6', 2024, 'kamil.klemiato@wp.pl', 'Kamil', 'Klemiato', 100, 7, 'git'),
(17, 25, '6', 2024, 'kamil.klemiato@gmail.com', 'Kamil', 'Klemiato', 90, 0, ''),
(18, 16, '6', 2024, 'kamil.klemiato@wp.pl', 'Kamil', 'Klemiato', 100, 0, ''),
(20, 30, '6', 2024, 'kamil.klemiato@wp.pl', 'Kamil', 'Klemiato', 100, 0, ''),
(24, 26, '6', 2024, 'kamil.klemiato@wp.pl', 'Kamil', 'Klemiato', 100, 0, ''),
(25, 19, '6', 2024, 'kamil.klemiato@wp.pl', 'Kamil', 'Klemiato', 600, 0, ''),
(26, 20, '7', 2024, 'kamil.klemiato@wp.pl', 'Kamil', 'Klemiato', 100, 0, ''),
(27, 26, '7', 2024, 'kamil.klemiato@wp.pl', 'Kamil', 'Klemiato', 100, 0, '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kolejka`
--

CREATE TABLE `kolejka` (
  `id` int(11) NOT NULL,
  `dzien` int(11) NOT NULL,
  `miesiac` int(11) NOT NULL,
  `rok` int(11) NOT NULL,
  `mail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `kolejka`
--

INSERT INTO `kolejka` (`id`, `dzien`, `miesiac`, `rok`, `mail`) VALUES
(2, 21, 6, 2024, 'kamil.klemiato@wp.pl'),
(4, 28, 6, 2024, 'kamil.klemiato@wp.pl'),
(5, 28, 6, 2024, 'kamil.klemiato@wp.pl');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `dzien`
--
ALTER TABLE `dzien`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `kolejka`
--
ALTER TABLE `kolejka`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `dzien`
--
ALTER TABLE `dzien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT dla tabeli `kolejka`
--
ALTER TABLE `kolejka`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
