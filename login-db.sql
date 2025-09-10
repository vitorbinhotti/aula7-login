CREATE DATABASE login_db;

use login_db;

create table usuarios (
	pk INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(120) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

INSERT INTO usuarios (username, senha) VALUES ('admin','123');