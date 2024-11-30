-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 30, 2024 at 12:26 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpus`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetBukuById` (IN `p_id` INT)   BEGIN
    SELECT *
    FROM buku
    WHERE id_buku = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_buku` (IN `p_kategori_buku` INT, IN `p_judul_buku` VARCHAR(255), IN `p_pengarang` VARCHAR(255), IN `p_tahun_terbit` YEAR, IN `p_stok` INT)   BEGIN
    -- Memasukkan data ke dalam tabel buku
    INSERT INTO buku (kategori_buku_id, judul_buku ,pengarang, tahun_terbit, stok)
    VALUES (p_kategori_buku,p_judul_buku, p_pengarang, p_tahun_terbit, p_stok);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Recap` (OUT `total_buku` INT, OUT `total_stok` INT, OUT `total_stok_terpakai` INT, OUT `total_stok_tersisa` INT)   BEGIN
    -- Deklarasi variabel
    DECLARE done INT DEFAULT 0;
    DECLARE book_id INT;
    DECLARE total_stok_buku INT;
    DECLARE stok_terpakai INT;
    DECLARE stok_tersisa INT;
    
    -- Deklarasi cursor untuk mengambil data dari tabel book
    DECLARE book_cursor CURSOR FOR
        SELECT b.id_buku, b.stok
        FROM buku b;
    
    -- Handler untuk mengatasi ketika cursor sudah mencapai akhir
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
    
    -- Menyiapkan total stok
    SET total_stok = 0;
    SET total_stok_terpakai = 0;
    SET total_stok_tersisa = 0;
    SET total_buku = 0;
    
    -- Membuka cursor
    OPEN book_cursor;
    
    -- Looping untuk mengambil data dari cursor
    read_loop: LOOP
        FETCH book_cursor INTO book_id, total_stok_buku;
        
        IF done THEN
            LEAVE read_loop;
        END IF;
        
        -- Menghitung stok yang terpakai berdasarkan peminjaman yang belum dikembalikan
        SELECT COUNT(*) INTO stok_terpakai
        FROM peminjaman
        WHERE status != 1;
        
        -- Jika tidak ada peminjaman yang belum dikembalikan, stok terpakai 0
        IF stok_terpakai IS NULL THEN
            SET stok_terpakai = 0;
        END IF;
        
        -- Menghitung stok tersisa
        SET stok_tersisa = total_stok_buku - stok_terpakai;
        
        -- Menambahkan nilai ke total stok
        SET total_stok = total_stok + total_stok_buku;
        SET total_stok_terpakai = total_stok_terpakai + stok_terpakai;
        SET total_stok_tersisa = total_stok_tersisa + stok_tersisa;
        SET total_buku = total_buku + 1;  -- Menghitung jumlah buku
        
    END LOOP;
    
    -- Menutup cursor
    CLOSE book_cursor;
    
    -- Mengembalikan hasil ke pemanggil (output)
    SELECT total_buku AS TotalBuku,
           total_stok AS TotalStok,
           total_stok_terpakai AS StokTerpakai,
           total_stok_tersisa AS StokTersisa;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_buku` (IN `p_id_buku` INT, IN `p_kategori_buku` INT, IN `p_judul_buku` VARCHAR(255), IN `p_pengarang` VARCHAR(255), IN `p_tahun_terbit` YEAR, IN `p_stok` INT)   BEGIN
    -- Update data pada tabel buku berdasarkan id_buku
    UPDATE buku
    SET
        kategori_buku_id = p_kategori_buku,
        judul_buku = p_judul_buku,
        pengarang = p_pengarang,
        tahun_terbit = p_tahun_terbit,
        stok = p_stok
    WHERE id_buku = p_id_buku;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id_admin` int NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama_admin` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id_admin`, `username`, `password`, `nama_admin`) VALUES
(1, 'admin123', 'admin123', 'admin1');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int NOT NULL,
  `kategori_buku_id` int NOT NULL,
  `judul_buku` varchar(255) NOT NULL,
  `pengarang` varchar(255) NOT NULL,
  `tahun_terbit` year NOT NULL,
  `stok` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `kategori_buku_id`, `judul_buku`, `pengarang`, `tahun_terbit`, `stok`) VALUES
(2, 1, 'rrefefef', 'dfefeferf', 2024, 5),
(3, 1, 'buku ajar bahasa indonesia', 'Kemendikbud', 2000, 20),
(4, 3, 'majalah tempo', 'tempo', 2005, 10);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori_buku` int NOT NULL,
  `nama_kategori_buku` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori_buku`, `nama_kategori_buku`) VALUES
(1, 'paket'),
(2, 'lks'),
(3, 'majalah'),
(4, 'koran');

-- --------------------------------------------------------

--
-- Table structure for table `peminjam`
--

CREATE TABLE `peminjam` (
  `id_peminjam` int NOT NULL,
  `nama_peminjam` varchar(255) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telepon` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peminjam`
--

INSERT INTO `peminjam` (`id_peminjam`, `nama_peminjam`, `alamat`, `telepon`) VALUES
(1, 'fer', 'fdfrfgrfgrg', '1234567890123');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int NOT NULL,
  `peminjam_id` int NOT NULL,
  `buku_id` int NOT NULL,
  `status` int NOT NULL,
  `admin_id` int DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `peminjam_id`, `buku_id`, `status`, `admin_id`, `create_date`, `update_date`) VALUES
(13, 1, 4, 0, 1, '2024-11-30 19:01:09', NULL),
(14, 1, 2, 0, 1, '2024-11-30 19:25:52', NULL);

--
-- Triggers `peminjaman`
--
DELIMITER $$
CREATE TRIGGER `set_created_at` BEFORE INSERT ON `peminjaman` FOR EACH ROW BEGIN

    SET NEW.create_date = NOW();
    
    SET NEW.admin_id = @user_id;
    
    SET NEW.status = 0;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_at` BEFORE UPDATE ON `peminjaman` FOR EACH ROW BEGIN

    SET NEW.update_date = NOW();
    
    SET NEW.status = 1;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `rent`
-- (See below for the actual view)
--
CREATE TABLE `rent` (
`buku_judul` varchar(255)
,`create_date` datetime
,`created_by` varchar(255)
,`id_peminjaman` int
,`peminjam_nama` varchar(255)
,`status` int
);

-- --------------------------------------------------------

--
-- Structure for view `rent`
--
DROP TABLE IF EXISTS `rent`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `rent`  AS SELECT `p`.`id_peminjaman` AS `id_peminjaman`, `p`.`create_date` AS `create_date`, `p`.`status` AS `status`, `a`.`nama_admin` AS `created_by`, `b`.`judul_buku` AS `buku_judul`, `pi`.`nama_peminjam` AS `peminjam_nama` FROM (((`peminjaman` `p` join `admins` `a` on((`p`.`admin_id` = `a`.`id_admin`))) join `buku` `b` on((`p`.`buku_id` = `b`.`id_buku`))) join `peminjam` `pi` on((`p`.`peminjam_id` = `pi`.`id_peminjam`))) WHERE (`p`.`status` = 0)  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `FK_id_jenis_buku` (`kategori_buku_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori_buku`);

--
-- Indexes for table `peminjam`
--
ALTER TABLE `peminjam`
  ADD PRIMARY KEY (`id_peminjam`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `FK_admins_id` (`admin_id`),
  ADD KEY `FK_peminjam_id` (`peminjam_id`),
  ADD KEY `FK_buku_id` (`buku_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori_buku` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `peminjam`
--
ALTER TABLE `peminjam`
  MODIFY `id_peminjam` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `FK_id_jenis_buku` FOREIGN KEY (`kategori_buku_id`) REFERENCES `kategori` (`id_kategori_buku`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `FK_admins_id` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id_admin`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_buku_id` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id_buku`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_peminjam_id` FOREIGN KEY (`peminjam_id`) REFERENCES `peminjam` (`id_peminjam`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
