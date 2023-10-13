-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pát 13. říj 2023, 09:02
-- Verze serveru: 10.4.28-MariaDB
-- Verze PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `chords_db`
--
CREATE DATABASE IF NOT EXISTS `chords_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_czech_ci;
USE `chords_db`;

-- --------------------------------------------------------

--
-- Struktura tabulky `chords`
--

CREATE TABLE IF NOT EXISTS `chords` (
  `chord_id` int(11) NOT NULL AUTO_INCREMENT,
  `chord_name` varchar(15) NOT NULL,
  `chord_image_path` varchar(155) NOT NULL,
  PRIMARY KEY (`chord_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `chords`
--

INSERT INTO `chords` (`chord_id`, `chord_name`, `chord_image_path`) VALUES
(1, 'A', 'images/A.jpg'),
(2, 'A7', 'images/A7.jpg'),
(3, 'Ami', 'images/Ami.jpg'),
(4, 'C', 'images/C.jpg'),
(5, 'Cmaj7', 'images/Cmaj7.jpg'),
(6, 'D', 'images/D.jpg'),
(7, 'Dmi', 'images/Dmi.jpg'),
(8, 'E', 'images/E.jpg'),
(9, 'Emi', 'images/Emi.jpg'),
(10, 'F', 'images/F.jpg'),
(11, 'G', 'images/G.jpg'),
(12, 'G7', 'images/G7.jpg'),
(13, 'H', 'images/H.jpg'),
(14, 'Hmi', 'images/Hmi.jpg');

-- --------------------------------------------------------

--
-- Struktura tabulky `chord_song`
--

CREATE TABLE IF NOT EXISTS `chord_song` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chord_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `chord_id` (`chord_id`),
  KEY `song_id` (`song_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `chord_song`
--

INSERT INTO `chord_song` (`id`, `chord_id`, `song_id`) VALUES
(2, 3, 1),
(3, 4, 1),
(4, 12, 1),
(5, 3, 2),
(6, 4, 2),
(7, 6, 2),
(8, 8, 2),
(9, 10, 2),
(10, 6, 3),
(11, 1, 3),
(12, 11, 3),
(13, 8, 3),
(17, 3, 8),
(18, 4, 8),
(19, 7, 8),
(20, 10, 8);

-- --------------------------------------------------------

--
-- Struktura tabulky `songs`
--

CREATE TABLE IF NOT EXISTS `songs` (
  `song_id` int(11) NOT NULL AUTO_INCREMENT,
  `strumming_pattern` text NOT NULL,
  `artist` varchar(155) NOT NULL,
  `title` varchar(155) NOT NULL,
  `lyrics` text NOT NULL,
  `url` varchar(155) NOT NULL,
  PRIMARY KEY (`song_id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `songs`
--

INSERT INTO `songs` (`song_id`, `strumming_pattern`, `artist`, `title`, `lyrics`, `url`) VALUES
(1, '↓-↓↑↓-↓-↓↑↓-↓-↓', 'Karel Kryl', 'Anděl', '1.\r\nC       Ami            C          G7\r\nZ rozmlácenýho kostela v krabici s kusem mýdla\r\nC       Ami             C     G7\r\npřinesl jsem si anděla, polámali mu křídla.\r\nC        Ami           C           G7\r\nDíval se na mě oddaně, já měl jsem trochu trému,\r\nC          Ami              C        G7\r\ntak vtiskl jsem mu do dlaně lahvičku od parfému.\r\nR:\r\nC        Ami             C             G7\r\nA proto, prosím, věř mi, chtěl jsem ho žádat,\r\nC      Ami         C      G7\r\naby mi mezi dveřmi pomohl hádat,\r\nC          Ami G7        C          Ami G7    C\r\nco mě čeká     a nemine, co mě čeká     a nemine.\r\n2.\r\nC        Ami             C     G7\r\nPak hlídali jsme oblohu, pozorujíce ptáky,\r\nC      Ami        C       G7\r\ndebatujíce o Bohu a hraní na vojáky.\r\nC        Ami              C        G7\r\nDo tváře jsem mu neviděl, pokoušel se ji schovat,\r\nC      Ami             C        G7\r\nto asi ptákům záviděl, že mohou poletovat.\r\nR:\r\n3.\r\nC         Ami            C      G7\r\nKdyž novinky mi sděloval u okna do ložnice,\r\nC         Ami            C         G7\r\njá křídla jsem mu ukoval z mosazný nábojnice.\r\nC          Ami            C        G7\r\nA tak jsem pozbyl anděla, on oknem odletěl mi,\r\nC           Ami          C        G7\r\nvšak přítel prý mi udělá novýho z mojí helmy.\r\nR:', 'angel'),
(2, '↓--↓--  ', 'The Animals', 'Dům U vycházejícího slunce', '        Ami      C      D      F\r\n1. Snad znáš ten dům za New Orleans,\r\n      Ami   C           E\r\n   ve štítu znak slunce má,\r\n         Ami       C      D          F\r\n   je to dům, kde lká sto chlapců ubohých\r\n     Ami      E           Ami C D F Ami E Ami E\r\n   a v němž jsem zkejs\' i já.\r\n      Ami  C        D     F\r\n2. Mý mámě Bůh dal věnem\r\n        Ami    C        E\r\n   jen prát a šít blue jeans,\r\n   Ami  C       D      F\r\n   táta můj se flákal jen\r\n   Ami    E      Ami  C D F Ami E Ami E\r\n   sám po New Orleans.\r\n         Ami    C         D       F\r\n3. Bankrotář se zhroutil před hernou,\r\n         Ami   C          E\r\n   jenom bídu svou měl a chlast,\r\n         Ami      C       D        F\r\n   k putykám pak táh\' tu pouť mizernou\r\n   Ami          E      Ami C D F Ami E Ami E\r\n   a znal jenom pít a krást.\r\n       Ami          C        D     F\r\n4. Být matkou, tak dám svým synům\r\n         Ami      C         E\r\n   lepší dům, než má kdo z vás,\r\n       Ami       C        D           F\r\n   ten dům, kde spím, má emblém sluneční,\r\n     Ami             E      Ami C D F Ami E Ami E\r\n   ale je v něm jen sníh a mráz.\r\n           Ami     C             D       F\r\n5. Kdybych směl se hnout z těch kleští,\r\n      Ami     C        E\r\n   pěstí vytrhnout tu mříž,\r\n            Ami         C      D     F\r\n   já jak v snách bych šel do New Orleans\r\n     Ami      E        Ami  C D F Ami E Ami E \r\n   a měl tam k slunci blíž.\r\n6.=1.', 'animals-slunce'),
(3, '↓-↓↑↓↑↓↑', 'Pavel Dydovič', 'Bláznova ukolébavka', '  D               A           G              D\r\n1. Máš, má ovečko, dávno spát, už píseň ptáků končí,\r\n                   A             G         D   \r\n   kvůli nám přestal i vítr vát, jen můra zírá zvenčí,\r\n    A                   G   \r\n   já znám její zášť, tak vyhledej skrýš,\r\n    A                  G       A\r\n   zas má bílej plášť a v okně je mříž.\r\n\r\n    D              A\r\nR: Máš, má ovečko, dávno spát,\r\n   G                   E   \r\n   a můžeš hřát, ty mě můžeš hřát,\r\n         D         G                D          G \r\n   vždyť přijdou se ptát, zítra zas přijdou se ptát,\r\n               D           G       D\r\n   jestli ty v mých představách už mizíš.\r\n   \r\n   D               A           G              D\r\n2. Máš, má ovečko, dávno spát, už máme půlnoc temnou,\r\n                   A            G              D\r\n   zítra budou nám bláznům lát, že ráda snídáš se mnou,\r\n   A                       G\r\n   proč měl bych jim lhát, že jsem tady sám,\r\n   A                  G         A\r\n   když tebe mám rád, když tebe tu mám.\r\n\r\nR:\r\n', 'blaznova-ukolebavka'),
(8, '↓-↓-↓↑↓↑', 'Hop-Trop', 'Tři kříže', '1.\r\nDmi               C            Ami\r\nDávám sbohem všem břehům proklatejm,\r\n        Dmi        Ami   Dmi\r\nkterý v drápech má ďábel sám,\r\n            C         Ami\r\nbílou přídí šalupa My Grave\r\n        Dmi     Ami   Dmi\r\nmířím k útesům, který znám.\r\nR:\r\n        F         C        Ami\r\nJen tři kříže z bílýho kamení\r\n      Dmi      Ami   Dmi\r\nněkdo do písku poskládal.\r\n       F             C         Ami\r\nSlzy v očích měl a v ruce znavený,\r\n      Dmi       Ami        Dmi\r\nlodní deník, co sám do něj psal.\r\n2.\r\n              C             Ami\r\nPrvní kříž má pod sebou jen hřích,\r\n     Dmi    Ami    Dmi\r\nsamý pití a rvačky jen.\r\n                   C             Ami\r\nChřestot nožů, při kterym přejde smích,\r\n       Dmi    Ami   Dmi\r\nsrdce-kámen a jméno Sten.\r\nR:\r\n3.\r\nDmi                C           Ami\r\nJá, Bob Green, mám tváře zjizvený,\r\n       Dmi            Ami     Dmi\r\nštěkot psa zněl, když jsem se smál.\r\n                C             Ami\r\nDruhej kříž mám a spím v podzemí,\r\n        Dmi     Ami   Dmi\r\nže jsem falešný karty hrál.\r\nR:\r\n4.\r\n                C          Ami\r\nTřetí kříž snad vyvolá jen vztek,\r\n      Dmi        Ami         Dmi\r\nFatty Rogers těm dvoum život vzal.\r\n             C             Ami\r\nSvědomí měl, vedle nich si klek.\r\nRecitál:\r\n\"Já vím, trestat je lidský, ale odpouštět božský.\r\nAť mi tedy bůh odpustí.\"\r\nR:\r\n        F         C        Ami\r\nJen tři kříže z bílýho kamení\r\n         Dmi      Ami   Dmi\r\njsem jim do písku poskládal.\r\n       F             C         Ami\r\nSlzy v očích měl a v ruce znavený,\r\n      Dmi        Ami          Dmi/D\r\nlodní deník, a v něm, co jsem psal.', 'krize');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin` int(11) NOT NULL DEFAULT 0,
  `name` varchar(155) NOT NULL,
  `password` varchar(155) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`user_id`, `admin`, `name`, `password`) VALUES
(1, 1, 'swacza', '$2y$10$MfKMXxRmiYWul3A3yywvAOk4yJEhI66hH8kdVsXxBvVlLMSSmQ80q');

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `chord_song`
--
ALTER TABLE `chord_song`
  ADD CONSTRAINT `chord_song_ibfk_1` FOREIGN KEY (`chord_id`) REFERENCES `chords` (`chord_id`),
  ADD CONSTRAINT `chord_song_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
