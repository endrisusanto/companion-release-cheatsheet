-- Buat database
CREATE DATABASE IF NOT EXISTS companion_release_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Gunakan database
USE companion_release_db;

-- Tabel users untuk autentikasi
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel release_cheatsheets untuk data companion release
CREATE TABLE IF NOT EXISTS release_cheatsheets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    model VARCHAR(50) NOT NULL,
    ole_version VARCHAR(50) NOT NULL,
    qb_user VARCHAR(50) NOT NULL,
    oxm_olm_new_version VARCHAR(100) NOT NULL,
    ap VARCHAR(50) NOT NULL,
    cp VARCHAR(50) NOT NULL,
    csc VARCHAR(50) NOT NULL,
    qb_csc_user VARCHAR(50) NOT NULL,
    additional_cl VARCHAR(50) DEFAULT '-',
    new_build_xid VARCHAR(100) NOT NULL,
    qb_csc_user_xid VARCHAR(50) NOT NULL,
    qb_csc_eng VARCHAR(50) NOT NULL,
    release_note_format TEXT NOT NULL,
    ap_mapping VARCHAR(100) NOT NULL,
    cp_mapping VARCHAR(100) NOT NULL,
    csc_version_up VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_model (model),
    INDEX idx_ole_version (ole_version),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;