CREATE DATABASE notational;
USE notational;

CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(6) NOT NULL CHECK (code REGEXP '^[A-Z0-9]{6}$'),
    title VARCHAR(255) NOT NULL,
    contents TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modified_at TIMESTAMP NOT NULL
);

CREATE INDEX idx_code ON notes(code);