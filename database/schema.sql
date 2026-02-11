-- Création de la base de données
CREATE DATABASE IF NOT EXISTS gestion_rh
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE gestion_rh;

-- Table service
CREATE TABLE service (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Table employe
CREATE TABLE employe (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL,
  prenom VARCHAR(100) NOT NULL,
  email VARCHAR(100),
  service_id INT,
  CONSTRAINT fk_service
    FOREIGN KEY (service_id)
    REFERENCES service(id)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Table conge
CREATE TABLE conge (
  id INT AUTO_INCREMENT PRIMARY KEY,
  employe_id INT NOT NULL,
  date_debut DATE,
  date_fin DATE,
  CONSTRAINT fk_employe
    FOREIGN KEY (employe_id)
    REFERENCES employe(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB;
