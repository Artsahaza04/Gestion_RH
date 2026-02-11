USE gestion_rh;

INSERT INTO service (nom) VALUES
('Informatique'),
('Ressources Humaines');

INSERT INTO employe (nom, prenom, email, service_id) VALUES
('Rakoto', 'Jean', 'jean@mail.com', 1),
('Rabe', 'Marie', 'marie@mail.com', 2);
