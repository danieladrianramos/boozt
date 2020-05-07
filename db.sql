-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Vært: 127.0.0.1
-- Genereringstid: 07. 05 2020 kl. 15:05:21
-- Serverversion: 10.4.11-MariaDB
-- PHP-version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`) VALUES
(1, 'Daniel', 'Ramos', 'daniel@mail.com'),
(2, 'Marcela', 'Damico', 'marcela@mail.com');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `purchase_date` datetime NOT NULL,
  `country` varchar(64) NOT NULL,
  `device` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `purchase_date`, `country`, `device`) VALUES
(1, 1, '2020-04-01 09:00:00', 'denmark', 'pc'),
(2, 1, '2020-04-11 09:00:00', 'denmark', 'pc'),
(3, 1, '2020-04-21 09:00:00', 'denmark', 'pc'),
(4, 1, '2020-05-01 09:00:00', 'denmark', 'pc'),
(5, 2, '2020-04-01 22:00:00', 'argentina', 'android'),
(6, 2, '2020-04-15 22:00:00', 'argentina', 'android'),
(7, 2, '2020-05-01 22:00:00', 'argentina', 'android');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `ean` varchar(13) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(9,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `ean`, `quantity`, `price`) VALUES
(1, 1, '0100000200001', 1, '100.00'),
(2, 2, '0100000200001', 2, '100.00'),
(3, 2, '0100000200002', 2, '75.00'),
(4, 3, '0100000200001', 1, '100.00'),
(5, 3, '0100000200002', 1, '75.00'),
(6, 3, '0100000200003', 1, '50.00'),
(7, 4, '0100000200004', 4, '25.00'),
(8, 5, '0100000200001', 4, '100.00'),
(9, 6, '0100000200002', 2, '75.00'),
(10, 7, '0100000200001', 1, '100.00'),
(11, 7, '0100000200002', 2, '75.00');

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indeks for tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tilføj AUTO_INCREMENT i tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tilføj AUTO_INCREMENT i tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Begrænsninger for tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;
