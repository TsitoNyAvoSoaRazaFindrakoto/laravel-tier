-- Insertion dans la table crypto
INSERT INTO crypto (crypto) VALUES
('Bitcoin'),
('Ethereum'),
('Litecoin'),
('Dogecoin'),
('Ripple'),
('Cardano'),
('Polkadot'),
('Solana'),
('Avalanche'),
('Chainlink');

-- Insertion dans la table transCrypto
INSERT INTO transCrypto (idUtilisateur, entree, sortie, dateTransaction, idCrypto) VALUES
(10, 388.36, 446.36, '2025-01-07 09:09:53', 5),
(9, 503.32, 138.90, '2025-01-10 09:09:53', 4),
(1, 246.59, 434.04, '2025-01-10 09:09:53', 7),
(7, 480.17, 466.29, '2025-01-09 09:09:53', 8),
(3, 597.81, 120.05, '2025-01-09 09:09:53', 9),
(2, 102.18, 184.29, '2025-01-08 09:09:53', 2),
(8, 370.14, 269.58, '2025-01-07 09:09:53', 6),
(5, 121.78, 413.07, '2025-01-06 09:09:53', 1),
(4, 299.21, 185.49, '2025-01-06 09:09:53', 3),
(6, 563.43, 187.53, '2025-01-08 09:09:53', 10);

-- Insertion dans la table fondUtilisateur
INSERT INTO fondUtilisateur (entree, sortie, idUtilisateur) VALUES
(4827.33, 1379.19, 8),
(2389.08, 1124.38, 4),
(1639.98, 1459.37, 4),
(1610.52, 204.72, 10),
(1114.21, 1537.79, 1),
(2905.43, 729.15, 7),
(2047.36, 895.87, 2),
(1209.84, 470.32, 3),
(1985.91, 329.41, 5),
(3549.02, 1523.77, 6);
