# 📚 Grimoire — Gestion Collaborative de Projets de Recherche

**Grimoire** est une application web développée avec **Laravel**, destinée à un laboratoire universitaire pour centraliser la gestion de ses projets de recherche. Elle permet aux chercheurs, superviseurs et étudiants de collaborer au sein de projets partagés, chacun disposant d'un rôle et de permissions spécifiques.

---

## 🎯 Contexte

Le laboratoire gérait auparavant ses projets via des tableurs partagés et des échanges d'e-mails, rendant difficile le suivi des responsabilités, l'affectation des nouveaux membres et l'archivage des rapports de clôture. **Grimoire** répond à ce besoin en centralisant :

- L'authentification et la gestion des utilisateurs
- La gestion fine des rôles par projet (responsable, chercheur, étudiant assistant)
- Le traitement asynchrone des notifications et des rapports de clôture

---

## ✨ Fonctionnalités principales

- 🔐 **Authentification** complète (inscription / connexion) — toutes les routes de gestion sont protégées par le middleware `auth`
- 👥 **Gestion des rôles par projet** via une table pivot (`responsable`, `chercheur`, `étudiant assistant`)
- 📁 **Gestion de projets** : création, édition, archivage (SoftDeletes), clôture
- ✅ **Autorisations** basées sur des **Policies** dédiées (aucun `abort(403)` manuel)
- 📩 **Notifications asynchrones** lors de l'ajout d'un membre à un projet
- 📄 **Génération asynchrone** d'un rapport de synthèse à la clôture d'un projet
- 🚀 **Traitement en file d'attente (Queues)** via Events & Listeners
- 📊 **Optimisation des performances** : élimination des requêtes N+1 (Laravel Debugbar)

---

## 🧩 Rôles et permissions

| Rôle | Permissions |
|---|---|
| **Responsable** | Créer / modifier / archiver un projet, ajouter / retirer des membres, clôturer le projet |
| **Chercheur** | Consulter le projet, mettre à jour l'avancement |
| **Étudiant assistant** | Consultation en lecture seule uniquement |

> Un projet possède toujours **au moins un responsable**. La suppression d'un projet correspond à un **archivage** (SoftDeletes) : il disparaît des listes actives mais reste consultable par un responsable.

---

## 🗄️ Structure de données

**`users`**
`id`, `name`, `email`, `password`

**`projects`**
`id`, `title`, `description`, `status` (`en_cours` / `cloture`), `avancement`, `deleted_at` (SoftDeletes), `timestamps`

**`project_user`** *(table pivot many-to-many)*
`user_id`, `project_id`, `role` (`responsable` / `chercheur` / `etudiant_assistant`), `timestamps`

---

## 🛠️ Stack technique

- **Framework** : Laravel
- **Base de données** : MySQL (ou SGBD compatible)
- **Authentification** : Laravel Breeze / Auth natif
- **Autorisations** : Laravel Policies
- **Traitement asynchrone** : Queues, Events, Listeners
- **Front-end** : Blade Templates
- **Debug / performance** : Laravel Debugbar

---

## ⚙️ Installation

### Prérequis

- PHP >= 8.1
- Composer
- MySQL (ou autre SGBD compatible Laravel)
- Node.js & npm (si compilation des assets)

### Étapes

```bash
# 1. Cloner le dépôt
git clone <lien-du-dépôt-github>
cd grimoire

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances front-end (si nécessaire)
npm install && npm run build

# 4. Copier le fichier d'environnement
cp .env.example .env

# 5. Générer la clé d'application
php artisan key:generate

# 6. Configurer la base de données dans le fichier .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=grimoire
DB_USERNAME=root
DB_PASSWORD=

# 7. Lancer les migrations et les seeders
php artisan migrate --seed

# 8. Créer le lien symbolique de stockage (si besoin)
php artisan storage:link
```

---

## ⏱️ Configuration de la file d'attente (Queues)

Grimoire utilise le système de **Queues** de Laravel pour déporter les traitements chronophages (notification d'ajout de membre, génération du rapport de clôture).

### 1. Configurer le driver de la queue

Dans le fichier `.env` :

```env
QUEUE_CONNECTION=database
```

> Le driver `database` est recommandé pour ce projet. Un driver `redis` peut également être utilisé en environnement de production.

### 2. Créer la table des jobs (si driver `database`)

```bash
php artisan queue:table
php artisan migrate
```

### 3. Lancer le worker de la queue

```bash
php artisan queue:work
```

> ⚠️ Cette commande doit rester active pour que les notifications et rapports soient bien traités. En production, il est recommandé de superviser ce processus avec un outil comme **Supervisor**.

### Events & Listeners asynchrones

| Event | Listener | Déclenché lorsque... |
|---|---|---|
| `MembreAjouteAuProjet` | `EnvoyerNotificationMembre` (`ShouldQueue`) | un membre est ajouté à un projet |
| `ProjetCloture` | `GenererRapportCloture` (`ShouldQueue`) | un projet est clôturé |

---

## ▶️ Lancer l'application

```bash
php artisan serve
```

L'application est accessible à l'adresse : `http://127.0.0.1:8000`

Dans un terminal séparé, lancer le worker de la queue :

```bash
php artisan queue:work
```

---

## 📄 Pages principales (Blades)

- **Commun** : Connexion / Inscription
- **Responsable** : Tableau de bord, Fiche projet, Création/édition de projet, Ajout de membre, Projets archivés
- **Chercheur** : Tableau de bord, Fiche projet (lecture + mise à jour de l'avancement)
- **Étudiant assistant** : Tableau de bord, Fiche projet en lecture seule

---

## ✅ Critères qualité respectés

- Middleware `auth` appliqué sur toutes les routes de gestion
- Layout unique (`layouts/app.blade.php`) avec navigation conditionnelle `@auth` / `@guest`
- Policies couvrant l'ensemble des actions sensibles (aucun `abort(403)` manuel)
- Directives `@can` utilisées dans les vues pour l'affichage conditionnel des actions
- `Form Request` dédiée pour chaque formulaire (validation)
- `@csrf` présent sur tous les formulaires
- Aucune requête N+1 (vérifié via Laravel Debugbar, usage systématique de `with()`)
- Redirection vers `/login` vérifiée pour tout utilisateur non authentifié

---

## 👥 Équipe

Projet réalisé en équipe de 3 à 4 personnes dans le cadre de la formation *Développeur Web et Web Mobile*.

---

## 📌 Livrables associés

- Lien Jira du suivi de projet
- Dépôt GitHub avec historique de commits réguliers
- Migrations et seeders (`users`, `projects`, `project_user`)
- Fichiers Policies, Events, Listeners et Form Requests
- Présent fichier README (configuration de la queue et lancement de l'application)

---

## 📝 Licence

Projet pédagogique réalisé dans le cadre de la formation *Développeur Web et Web Mobile* — usage interne / démonstration.