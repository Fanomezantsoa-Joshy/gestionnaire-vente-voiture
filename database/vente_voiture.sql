-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 02 oct. 2026 à 20:34
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;

--
-- Base de données : `vente_voiture`
--

CREATE DATABASE `vente_voiture`;

USE `vente_voiture`;

-- --------------------------------------------------------

--
-- Structure de la table `achat`
--

CREATE TABLE `achat` (
    `numAchat` varchar(10) NOT NULL,
    `idCli` varchar(10) NOT NULL,
    `idvoit` varchar(10) NOT NULL,
    `date` date NOT NULL,
    `qte` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `achat`
--

INSERT INTO
    `achat` (
        `numAchat`,
        `idCli`,
        `idvoit`,
        `date`,
        `qte`
    )
VALUES (
        'ACH-001',
        'CLI-001',
        'VOI-001',
        '2026-09-01',
        1
    ),
    (
        'ACH-002',
        'CLI-002',
        'VOI-002',
        '2026-08-01',
        1
    ),
    (
        'ACH-003',
        'CLI-003',
        'VOI-003',
        '2026-07-01',
        1
    ),
    (
        'ACH-004',
        'CLI-001',
        'VOI-001',
        '2026-06-05',
        2
    ),
    (
        'ACH-005',
        'CLI-002',
        'VOI-002',
        '2026-05-05',
        2
    ),
    (
        'ACH-006',
        'CLI-003',
        'VOI-003',
        '2026-10-02',
        2
    );

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
    `idcli` varchar(10) NOT NULL,
    `nom` varchar(50) NOT NULL,
    `contact` varchar(20) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO
    `client` (`idcli`, `nom`, `contact`)
VALUES (
        'CLI-001',
        'Joshy',
        '011111111111111'
    ),
    (
        'CLI-002',
        'Fanomezantsoa',
        '022222222222222'
    ),
    (
        'CLI-003',
        'Rakoto',
        '044444444444444'
    );

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
    `nom` varchar(50) NOT NULL,
    `prenoms` varchar(50) NOT NULL,
    `Date_naissance` date NOT NULL,
    `email` varchar(50) NOT NULL,
    `nom_utilisateur` varchar(50) DEFAULT NULL,
    `mdp` varchar(10) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO
    `utilisateur` (
        `nom`,
        `prenoms`,
        `Date_naissance`,
        `email`,
        `nom_utilisateur`,
        `mdp`
    )
VALUES (
        '',
        '',
        '0000-00-00',
        '',
        '',
        ''
    ),
    (
        'RAKOTOARINIRINA',
        'Fanomezantsoa Joshy',
        '2000-01-01',
        'email@gmail.com',
        'Admin',
        'motdepasse'
    );

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE `voiture` (
    `idvoit` varchar(10) NOT NULL,
    `design` varchar(20) NOT NULL,
    `prix` int(11) NOT NULL,
    `nombre` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `voiture`
--

INSERT INTO
    `voiture` (
        `idvoit`,
        `design`,
        `prix`,
        `nombre`
    )
VALUES (
        'VOI-001',
        'Ferrari',
        500000000,
        10
    ),
    (
        'VOI-002',
        'Mercedes',
        200000000,
        10
    ),
    (
        'VOI-003',
        'Toyota',
        100000000,
        10
    );

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
ADD UNIQUE KEY `nom_utilisateur` (`nom_utilisateur`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;