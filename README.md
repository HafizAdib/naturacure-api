# 🌐 NaturaCure API

Backend API de l’application **NaturaCure (Nature Thérapeutique Cure)**, développé avec Laravel.

Cette API permet de gérer les utilisateurs, les produits thérapeutiques traditionnels, les interactions sociales (likes, commentaires) ainsi que les contenus multimédias (images et vidéos).

---

## 🎯 Objectifs

* Centraliser les données thérapeutiques traditionnelles
* Fournir une API sécurisée pour l’application mobile
* Gérer les interactions utilisateurs
* Assurer la validation et la modération des contenus

---

## 🚀 Fonctionnalités principales

### 🔐 Authentification

* Inscription (Register)
* Connexion (Login)
* Déconnexion (Logout)
* Authentification via Laravel Sanctum

---

### 👤 Gestion des utilisateurs

* Création de compte
* Gestion des profils
* Attribution de rôles (Admin, Contributeur, Utilisateur)

---

### 🌿 Produits thérapeutiques

* CRUD (Créer, Lire, Modifier, Supprimer)
* Informations :

  * Nom
  * Maladie traitée
  * Ingrédients
  * Préparation
  * Posologie
  * Précautions

---

### 🎥 Gestion des médias

* Upload d’images
* Upload de vidéos
* Association des médias aux produits

---

### ❤️ Interaction sociale

* Like des produits
* Commentaires
* Historique des interactions

---

### 🔍 Recherche et filtrage

* Recherche par nom
* Recherche par maladie
* Filtrage des produits

---

## 🛠️ Technologies utilisées

* Laravel
* PHP
* MySQL
* Laravel Sanctum (authentification API)
* REST API

---

## 📂 Structure du projet

app/
├── Models/
├── Http/
│   ├── Controllers/
│   ├── Middleware/

routes/
├── api.php

database/
├── migrations/
├── seeders/

storage/
├── app/public

---

## ⚙️ Installation

1. Cloner le projet

git clone https://github.com/ton-repo/nateracure-api

2. Accéder au dossier

cd nateracure-api

3. Installer les dépendances

composer install

4. Copier le fichier d’environnement

cp .env.example .env

5. Générer la clé

php artisan key:generate

---

## 🗄️ Configuration base de données

Modifier le fichier `.env` :

DB_DATABASE=nateracure
DB_USERNAME=root
DB_PASSWORD=

---

## 🔄 Migration de la base de données

php artisan migrate

---

## ▶️ Lancer le serveur

php artisan serve -host=0.0.0.0

---

## 🔐 Configuration Sanctum

php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

php artisan migrate

---

## 📡 Routes API principales

| Méthode | Endpoint           | Description            |
| ------- | ------------------ | ---------------------- |
| POST    | /api/register      | Inscription            |
| POST    | /api/login         | Connexion              |
| POST    | /api/logout        | Déconnexion            |
| GET     | /api/products      | Liste des produits     |
| POST    | /api/products      | Ajouter un produit     |
| PUT     | /api/products/{id} | Modifier               |
| DELETE  | /api/products/{id} | Supprimer              |
| POST    | /api/like          | Liker un produit       |
| POST    | /api/comment       | Ajouter un commentaire |

---

## 📁 Gestion des fichiers

Créer le lien symbolique pour accéder aux fichiers :

php artisan storage:link

Les fichiers seront accessibles via :

/storage/...

---

## 🧪 Tests

php artisan test

---

## 🔐 Sécurité

* Validation des requêtes
* Authentification via token
* Protection contre les accès non autorisés
* Filtrage des données

---

## ⚠️ Avertissement

Les informations fournies par cette API sont à but informatif uniquement et ne remplacent pas un avis médical professionnel.

---

## 📌 Améliorations futures

* Notifications en temps réel
* WebSockets (chat en direct)
* Système de notation
* Dashboard administrateur
* API versioning

---

## Auteurs

* Abdoul Halim Hafiz Adib
* Idrissou Bouba
* Ngah David Ulrich
* Ngathuessi Tagne Stéphane

Projet académique du Developpement mobile

---

# 🌿 NaturaCure

### La puissance de la nature au service de la santé
