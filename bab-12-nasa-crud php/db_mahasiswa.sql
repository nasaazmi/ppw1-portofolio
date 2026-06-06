-- Buat database
CREATE DATABASE IF NOT EXISTS db_mahasiswa;
USE db_mahasiswa;

-- Tabel mahasiswa (untuk CRUD - Soal 1)
CREATE TABLE IF NOT EXISTS mahasiswa (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    nama     VARCHAR(100) NOT NULL,
    nim      VARCHAR(20)  NOT NULL UNIQUE,
    prodi    VARCHAR(50)  NOT NULL,
    ipk      DECIMAL(3,2) NOT NULL,
    semester TINYINT      NOT NULL,
    created_at TIMESTAMP  DEFAULT CURRENT_TIMESTAMP
);

-- Data contoh
INSERT INTO mahasiswa (nama, nim, prodi, ipk, semester) VALUES
('Budi Santoso',   '25/558087/SV/56743', 'Teknologi Rekayasa Perangkat Lunak',   3.75, 5),
('Siti Rahayu',    '25/559088/SV/87654', 'Tenologi Rekayasa Internet',     3.20, 5),
('Ahmad Fauzi',    '25/556708/SV/54324', 'Teknologi Rekayasa Perangkat Lunak',      2.90, 3),
('Dewi Lestari',   '25/559087/SV/56432', 'Teknologi Rekayasa Elektro',2.60, 3),
('Rizky Pratama',  '25/517658/SV/53468', 'Teknologi Rekayasa Instrumentasi dan Kontrol',   1.80, 2);
