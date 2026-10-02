##--Gestionnaire de ventes de voitures--

## --Description--

Application web de gestion des ventes de voitures développée avec Vue.js, PHP et MySQL. Elle permet de gérer les clients, les voitures et les achats, tout en proposant un tableau de bord avec le suivi des recettes.

## --Fonctionnalités--

- Authentification des utilisateurs
- Gestion des clients
- Gestion des voitures
- Gestion des achats
- Génération des factures au format PDF
- Affichage graphique du total des recettes pour chacun des six derniers mois
- Validation dynamique des formulaires avec Vuelidate
- Boîtes d'alerte pour informer l'utilisateur des différentes opérations
- Messages de succès après les opérations réussies

## --Technologies utilisées--

- Vue.js
- JavaScript
- Vuelidate
- HTML5
- CSS3
- PHP
- MySQL
- Apache
- XAMPP
- Node.js et npm

## --Structure du projet--

- frontend : application Vue.js contenant l'interface utilisateur
- backend : fichiers PHP assurant la communication avec la base de données
- database : script SQL permettant de créer et initialiser la base de données
- captures : captures d'écran de l'application
- README.md : documentation du projet
- .gitignore : fichiers et dossiers exclus du dépôt Git

## --Installation--

- Cloner le dépôt GitHub dans le répertoire htdocs de XAMPP
- Installer et démarrer XAMPP
- Démarrer les services Apache et MySQL
- Importer le fichier SQL présent dans le dossier database
- Ouvrir le projet frontend avec Visual Studio Code
- Ouvrir un terminal dans le dossier frontend (cd xampp/htdocs/gestionnaire-vente-voiture/frontend)
- Installer les dépendances avec npm install
- Lancer l'application avec npm run dev
- Ouvrir l'adresse indiquée par Vite dans le navigateur
- Un compte de teste est deja disponible pour explorer le projet sinon pouvez en créer un nouveau compte (Nom : Admin, Mot de passe : motdepasse).

## --Base de données--

La base de données MySQL contient les informations nécessaires à la gestion des clients, des voitures et des achats.

Le script de création et d'initialisation de la base de données est disponible dans le dossier database.

## --Validation des formulaires--

Les formulaires de l'application utilisent Vuelidate afin d'effectuer une vérification dynamique des données saisies.

Les erreurs de saisie sont affichées directement lors de la saisie afin d'aider l'utilisateur à corriger les informations avant leur enregistrement.

## --Facturation--

L'application permet de générer une facture au format PDF à partir des informations relatives à un achat.

## --Tableau de bord--

Le tableau de bord présente un graphique permettant de visualiser le total des recettes pour chacun des six derniers mois.

Cette représentation permet de suivre l'évolution des recettes sur une période récente.

## --Auteur--

Projet réalisé dans le cadre de ma formation en développement informatique.
