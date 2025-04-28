# Biblio Tech

![Bannière](assets/images/bilbio-banner.png)

🌼Bienvenue dans notre adorable <mark style="background-color:hsl(79, 42.70%, 60%);color: #1F4746 ;padding: 1px 3px; border-radius: 3px">**bibliothèque**</mark> !🌼

## Table des matières

1. [Équipe](#1-équipe)
2. [Stack technique](#2-stack-technique)
3. [Lancer le projet](#3-lancer-le-projet)
4. [Modèle Conceptuel des Données (MCD)](#4-modèle-conceptuel-des-données-mcd)
5. [Remarques](#5-remarques)
6. [Références](#6-références)

## 1. Équipe

- 🌻**Frouin Oriane** : [@orinaya](https://www.github.com/orinaya)
- 🌷**Marsaud Marilou** : [@mariloumars](https://github.com/mariloumars)
- 🌼**Norvez Audrey** : [@TaupeInHambourg](https://github.com/TaupeInHambourg)

## 2. Fonctionnalités

Cette application permet de gérer les emprunts de livres dans une bibliothèque.
Voici les principales fonctionnalités :

- <mark style="color:#a9c56d; background-color: transparent ">**Consulter les livres**</mark> : Les utilisateurs authentifiés peuvent voir la liste des livres disponibles, consulter les détails (ISBN, titre, auteur(s), résumé, etc...).
- <mark style="color:#a9c56d; background-color: transparent">**Réservation de livres**</mark> : Les utilisateurs peuvent réserver jusqu’à 5 livres simultanément, mais un livre ne peut être réservé que par une seule personne à la fois.
- <mark style="color:#a9c56d; background-color: transparent">**Gestion des livres pour l’administrateur**</mark> : L’administrateur peut ajouter, éditer ou supprimer des livres.

## 2. Stack technique

| Catégorie  | Technologie                                                                                                     |
| ---------- | --------------------------------------------------------------------------------------------------------------- |
| Langages   | ![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)                    |
| Frameworks | ![Symfony](https://img.shields.io/badge/Symfony-000000?style=for-the-badge&logo=symfony&logoColor=white)        |
| ORM        | ![Doctrine ORM](https://img.shields.io/badge/Doctrine-FC6A31?style=for-the-badge&logo=doctrine&logoColor=white) |
| Templating | ![Twig](https://img.shields.io/badge/Twig-0F9D58?style=for-the-badge&logo=twig&logoColor=white)                 |
| Outils     | ![Git](https://img.shields.io/badge/Git-F05032?style=for-the-badge&logo=git&logoColor=white)                    |

## 3. Lancer le projet

### 3.1 Prérequis

- PHP >= 8.2
- Composer (gestionnaire de dépendances PHP)
- Docker (pour gérer l'environnement de développement)
- Docker Compose (pour la gestion des services Docker)

### 3.2 Installation

📦 Installez les dépendances du projet

```bash
composer install
```

📄 Il vous faudra ensuite créer à la racine du projet un fichier `.env` à partir du fichier `.env.example`

```bash
cp .env.example .env

```

📚 Créez la base de données et appliquez les migrations

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

▶️ Lancez le serveur Symfony

```bash
symfony server:start -d
```

▶️ Lancez les services Docker avec Docker Compose

```bash
docker compose up -d
```

### 3.3 Liens utiles

#### Application

➡️ http://localhost:8000 : Accédez à l'application

#### Adminer

➡️ http://localhost:8080 : **Adminer** permet de gérer facilement la base de données via une interface web. Une fois Docker démarré,vous pouvez donc accéder à Adminer via le lien suivant

**Paramètres de connexion pour Adminer**

```
Système : PostgreSQL
Serveur : database (défini dans .env)
Utilisateur : utilisateur (défini dans .env)
Mot de passe : motdepasse (défini dans .env)
Base de données : nombasededonnées (défini dans .env)
```

### 4. Modèle Conceptuel des Données (MCD)

![MCD](assets/images/biblio-MCD.png)

### 5. Remarques

### 6. Références
