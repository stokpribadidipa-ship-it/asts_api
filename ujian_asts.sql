-- =========================================================
-- Database: ujian_asts
-- Tabel: users
-- Sumber data awal: https://jsonplaceholder.typicode.com/users
-- =========================================================

CREATE DATABASE IF NOT EXISTS ujian_asts CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE ujian_asts;

DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id      INT AUTO_INCREMENT PRIMARY KEY,
    name    VARCHAR(100) NOT NULL,
    nisn    VARCHAR(20)  NOT NULL,
    ttl     VARCHAR(100) NOT NULL,   -- Tempat, Tanggal Lahir
    gender  VARCHAR(10)  NOT NULL,   -- MALE / FEMALE
    email   VARCHAR(100) NOT NULL,
    address TEXT         NOT NULL
) ENGINE=InnoDB;

INSERT INTO users (name, nisn, ttl, gender, email, address) VALUES
('Leanne Graham', '123131444', 'PONOROGO, 12 Agustus 2010', 'MALE', 'Sincere@april.biz', 'Kulas Light, Apt. 556, Gwenborough, 92998-3874'),
('Ervin Howell', '262363463', 'PONOROGO, 12 Agustus 2010', 'FEMALE', 'Shanna@melissa.tv', 'Victor Plains, Suite 879, Wisokyburgh, 90566-7771'),
('Clementine Bauch', '632641362', 'PONOROGO, 12 Agustus 2010', 'MALE', 'Nathan@yesenia.net', 'Douglas Extension, Suite 847, McKenziehaven, 59590-4157'),
('Patricia Lebsack', '441278965', 'PONOROGO, 12 Agustus 2010', 'FEMALE', 'Julianne.OConner@kory.org', 'Hoeger Mall, Apt. 692, South Elvis, 53919-4257'),
('Chelsey Dietrich', '552391847', 'PONOROGO, 12 Agustus 2010', 'FEMALE', 'Lucio_Hettinger@annie.ca', 'Skiles Walks, Suite 351, Roscoeview, 33263'),
('Mrs. Dennis Schulist', '663452918', 'PONOROGO, 12 Agustus 2010', 'FEMALE', 'Karley_Dach@jasper.info', 'Norberto Crossing, Apt. 950, South Christy, 23505-1337'),
('Kurtis Weissnat', '774563029', 'PONOROGO, 12 Agustus 2010', 'MALE', 'Telly.Hoeger@billy.biz', 'Rex Trail, Suite 280, Howemouth, 58804-1099'),
('Nicholas Runolfsdottir V', '885674130', 'PONOROGO, 12 Agustus 2010', 'MALE', 'Sherwood@rosamond.me', 'Ellsworth Summit, Suite 729, Aliyaview, 45169'),
('Glenna Reichert', '996785241', 'PONOROGO, 12 Agustus 2010', 'FEMALE', 'Chaim_McDermott@dana.io', 'Dayna Park, Suite 449, Bartholomebury, 76495-3109'),
('Clementina DuBuque', '107896352', 'PONOROGO, 12 Agustus 2010', 'FEMALE', 'Rey.Padberg@karina.biz', 'Kattie Turnpike, Suite 198, Lebsackbury, 31428-2261');
