DELIMITER $$

CREATE PROCEDURE insert_buku(
    IN p_kategori_buku INT,
	IN p_judul_buku VARCHAR(255),
    IN p_pengarang VARCHAR(255),
    IN p_tahun_terbit YEAR,
    IN p_stok INT
)
BEGIN
    -- Memasukkan data ke dalam tabel buku
    INSERT INTO buku (kategori_buku, judul_buku ,pengarang, tahun_terbit, stok)
    VALUES (p_kategori_buku,p_judul_buku, p_pengarang, p_tahun_terbit, p_stok);
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE update_buku(
    IN p_id_buku INT,            -- ID buku yang akan diupdate
    IN p_kategori_buku INT, -- Kategori buku baru
    IN p_judul_buku VARCHAR(255),
    IN p_pengarang VARCHAR(255),     -- Nama pengarang baru
    IN p_tahun_terbit YEAR,          -- Tahun terbit baru
    IN p_stok INT                  -- Stok buku baru
)
BEGIN
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


DELIMITER $$

CREATE PROCEDURE GetBukuById(IN p_id INT)
BEGIN
    SELECT *
    FROM buku
    WHERE id_buku = p_id;
END$$

DELIMITER ;


CREATE VIEW rent AS
SELECT
    p.id_peminjaman,
    p.create_date,
    p.status,
    a.nama_admin AS created_by,        
    b.judul_buku AS buku_judul,             
    pi.nama_peminjam AS peminjam_nama  
FROM
    peminjaman p
JOIN
    admins a ON p.admin_id = a.id_admin  
JOIN
    buku b ON p.buku_id = b.id_buku    
JOIN
    peminjam pi ON p.peminjam_id = pi.id_peminjam  
WHERE
    p.status = 0;  

DELIMITER $$

DELIMITER $$

CREATE PROCEDURE update_buku_with_stok(
    IN id_buku INT,
    IN input_stok INT,
    IN input_kategori_buku_id INT,
    IN input_judul_buku VARCHAR(255),
    IN input_pengarang VARCHAR(255),
    IN input_tahun_terbit YEAR
)
BEGIN
    DECLARE done INT DEFAULT 0;
    DECLARE rent INT DEFAULT 0;
    DECLARE done_peminjaman INT DEFAULT 0;
    DECLARE stok_buku INT;

    -- Deklarasi cursor untuk menghitung jumlah peminjaman dengan status 0 (rent), 1 (done), dan 2 (rent)
    DECLARE buku_cursor CURSOR FOR
    SELECT b.id_buku,
            COALESCE(SUM(CASE WHEN p.status IN (0, 2) THEN p.jumlah ELSE 0 END), 0) AS rent,
            COALESCE(SUM(CASE WHEN p.status = 1 THEN p.jumlah ELSE 0 END), 0) AS done,
           b.stok
    FROM buku b
    LEFT JOIN peminjaman p ON b.id_buku = p.buku_id
    WHERE b.id_buku = id_buku
    GROUP BY b.id_buku;

    -- Handler untuk menandakan akhir data
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    -- Membuka cursor
    OPEN buku_cursor;

    -- Looping untuk mengambil data dari cursor
    FETCH buku_cursor INTO id_buku, rent, done_peminjaman, stok_buku;
    
    -- Cek apakah data ditemukan
    IF done THEN
        -- Jika data tidak ditemukan, keluar dari cursor
        CLOSE buku_cursor;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Buku dengan id_buku tidak ditemukan';
    END IF;

    -- Periksa jika stok buku cukup untuk peminjaman yang sedang berlangsung
    IF stok_buku - rent > 0 THEN
        -- Stok cukup, lakukan update stok dan data buku
        UPDATE buku
        SET 
            stok = input_stok,
            kategori_buku_id = input_kategori_buku_id,
            judul_buku = input_judul_buku,
            pengarang = input_pengarang,
            tahun_terbit = input_tahun_terbit
        WHERE id_buku = id_buku;
    ELSE
        -- Stok tidak cukup, batalkan update
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stok tidak cukup untuk melakukan perubahan';
    END IF;

    -- Menutup cursor
    CLOSE buku_cursor;

END$$

DELIMITER ;


DELIMITER $$

CREATE PROCEDURE GetBookStock()
BEGIN
    -- Deklarasi variabel
    DECLARE done INT DEFAULT 0;
    DECLARE book_id INT;
    DECLARE book_title VARCHAR(255);
    DECLARE book_author VARCHAR(255);  -- Menambahkan pengarang
    DECLARE book_year INT;
    DECLARE book_category_name VARCHAR(255);  -- Menambahkan nama kategori
    DECLARE total_stok INT;
    DECLARE stok_terpakai INT;
    DECLARE stok_tersisa INT;
    
    -- Deklarasi cursor untuk mengambil data dari tabel book dan kategori
    DECLARE book_cursor CURSOR FOR
        SELECT b.id_buku, b.judul_buku, b.pengarang, b.tahun_terbit, b.stok, k.nama_kategori_buku
        FROM book b
        JOIN kategori k ON b.kategori_buku_id = k.id_kategori_buku;
    
    -- Handler untuk mengatasi ketika cursor sudah mencapai akhir
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
    
    -- Membuka cursor
    OPEN book_cursor;
    
    -- Looping untuk mengambil data dari cursor
    read_loop: LOOP
        FETCH book_cursor INTO book_id, book_title, book_author, book_year, total_stok, book_category_name;
        
        IF done THEN
            LEAVE read_loop;
        END IF;
        
        -- Menghitung stok yang terpakai berdasarkan peminjaman yang belum dikembalikan (status != 1)
        SELECT SUM(jumlah) INTO stok_terpakai
        FROM peminjaman
        WHERE book_id = book_id AND status != 1;
        
        -- Jika tidak ada peminjaman yang belum dikembalikan, stok terpakai 0
        IF stok_terpakai IS NULL THEN
            SET stok_terpakai = 0;
        END IF;
        
        -- Menghitung stok tersisa
        SET stok_tersisa = total_stok - stok_terpakai;
        
        -- Menampilkan hasil
        SELECT book_id AS id_buku, 
               book_title AS judul_buku, 
               book_author AS pengarang, 
               book_year AS tahun_terbit, 
               total_stok AS stok, 
               stok_terpakai, 
               stok_tersisa,
               book_category_name AS nama_kategori;
    END LOOP;
    
    -- Menutup cursor
    CLOSE book_cursor;
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE GetBookStock(
    OUT total_buku INT,           -- OUT: Menyimpan total jumlah buku yang dihitung
    OUT total_stok INT,           -- OUT: Menyimpan total stok seluruh buku
    OUT total_stok_terpakai INT,  -- OUT: Menyimpan total stok yang terpakai
    OUT total_stok_tersisa INT    -- OUT: Menyimpan total stok yang tersisa
)
BEGIN
    -- Deklarasi variabel
    DECLARE done INT DEFAULT 0;
    DECLARE book_id INT;
    DECLARE total_stok_buku INT;
    DECLARE stok_terpakai INT;
    DECLARE stok_tersisa INT;
    
    -- Deklarasi cursor untuk mengambil data dari tabel book
    DECLARE book_cursor CURSOR FOR
        SELECT b.id_buku, b.stok
        FROM book b;
    
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
        SELECT SUM(id_buku) INTO stok_terpakai
        FROM peminjaman
        WHERE book_id = book_id AND status != 1;
        
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
END $$

DELIMITER ;


