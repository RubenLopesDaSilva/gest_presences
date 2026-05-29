# Système de Gestion de Présence RFID - Laravel

## 📋 Vue d'ensemble

Application Laravel complète avec **deux interfaces distinctes** :
- **Interface Élève** : Simple et intuitive pour scanner les badges RFID
- **Interface Professeur** : Complète pour gérer les classes et consulter les présences

## 🎯 Fonctionnalités

### Pour les Élèves
- ✅ Scanner RFID public (sans connexion)
- ✅ Tableau de bord personnel avec historique
- ✅ Visualisation du statut (présent/absent)
- ✅ Historique des pointages (jour et semaine)

### Pour les Professeurs
- ✅ Vue d'ensemble de toutes les classes
- ✅ Statistiques en temps réel (présents/absents)
- ✅ Vue détaillée par classe avec liste des élèves
- ✅ Gestion des élèves (ajout/suppression)
- ✅ Historique complet avec filtres
- ✅ Activité récente en direct

## 🏗️ Architecture

### Modèles
- **User** : Gère les utilisateurs (élèves et professeurs) avec rôles
- **Classe** : Représente une classe avec ses élèves
- **AttendanceLog** : Enregistre tous les pointages (entrées/sorties)

### Contrôleurs
- **AuthController** : Gestion de l'authentification
- **StudentController** : Interface élève (scanner, dashboard)
- **TeacherController** : Interface professeur (classes, gestion, historique)

### Routes principales

**Routes publiques :**
- `/` - Scanner RFID (page d'accueil)
- `/login` - Connexion
- `/api/scan` - API pour scanner un badge

**Routes élèves (authentifiées) :**
- `/student/dashboard` - Tableau de bord élève

**Routes professeurs (authentifiées) :**
- `/teacher/dashboard` - Tableau de bord professeur
- `/teacher/classe/{id}` - Vue détaillée d'une classe
- `/teacher/students` - Gestion des élèves
- `/teacher/history` - Historique complet

## 🚀 Installation

### Prérequis
```bash
- PHP 8.1+
- Composer
- MySQL ou PostgreSQL
- Node.js & NPM
```

### Étape 1 : Créer le projet Laravel

```bash
composer create-project laravel/laravel mon-app-rfid
cd mon-app-rfid
```

### Étape 2 : Copier les fichiers

Copiez tous les fichiers du dossier `laravel-rfid` dans votre nouveau projet :

```bash
# Copier les modèles
laravel-rfid/app/Models/ → app/Models/

# Copier les contrôleurs
laravel-rfid/app/Http/Controllers/ → app/Http/Controllers/

# Copier les migrations
laravel-rfid/database/migrations/ → database/migrations/

# Copier le seeder
laravel-rfid/database/seeders/DatabaseSeeder.php → database/seeders/

# Copier les vues
laravel-rfid/resources/views/ → resources/views/

# Copier les routes
laravel-rfid/routes/web.php → routes/web.php
```

### Étape 3 : Configuration de la base de données

Éditez le fichier `.env` :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rfid_attendance
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

Créez la base de données :

```bash
mysql -u root -p
CREATE DATABASE rfid_attendance CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### Étape 4 : Installer les dépendances

```bash
# Dépendances PHP
composer install

# Générer la clé d'application
php artisan key:generate
```

### Étape 5 : Configurer Tailwind CSS

Installez les dépendances NPM :

```bash
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
npm install
```

Créez le fichier `resources/css/app.css` :

```css
@tailwind base;
@tailwind components;
@tailwind utilities;

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}
```

Créez le fichier `tailwind.config.js` :

```javascript
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
```

Créez le fichier `vite.config.js` :

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

### Étape 6 : Exécuter les migrations

```bash
php artisan migrate
```

### Étape 7 : Peupler avec des données de test

```bash
php artisan db:seed
```

Cela créera :
- **1 professeur** : `prof@ecole.fr` / `password`
- **2 classes** : Terminale S1 et Première ES2
- **9 élèves** avec leurs codes RFID (RFID001 à RFID009)

### Étape 8 : Compiler les assets

En développement :
```bash
npm run dev
```

Pour la production :
```bash
npm run build
```

### Étape 9 : Lancer le serveur

```bash
php artisan serve
```

Visitez `http://localhost:8000`

## 🎓 Utilisation

### Pour les Élèves

1. **Scanner un badge** :
   - Allez sur la page d'accueil (`/`)
   - Le champ de scan est automatiquement focus
   - Scannez votre badge RFID ou tapez le code (ex: RFID001) et appuyez sur Entrée
   - Un feedback visuel confirme l'entrée ou la sortie

2. **Consulter son historique** :
   - Connectez-vous avec vos identifiants élève
   - Accédez à `/student/dashboard`
   - Visualisez vos pointages du jour et de la semaine

### Pour les Professeurs

1. **Connexion** :
   - Email : `prof@ecole.fr`
   - Mot de passe : `password`

2. **Tableau de bord** :
   - Vue d'ensemble de toutes vos classes
   - Statistiques globales (total, présents, absents)
   - Activité récente en temps réel

3. **Consulter une classe** :
   - Cliquez sur une classe dans le tableau de bord
   - Voir la liste complète des élèves avec leur statut
   - Détail des pointages du jour pour chaque élève

4. **Gérer les élèves** :
   - Menu "Élèves" pour voir tous les élèves
   - Bouton "+ Ajouter un élève" pour créer un nouvel élève
   - Possibilité de supprimer des élèves

5. **Consulter l'historique** :
   - Menu "Historique" pour voir tous les pointages
   - Filtres par classe et par date
   - Pagination pour les grands volumes

## 🔐 Sécurité

- **Authentification** : Système Laravel Auth
- **Mots de passe** : Hashés avec bcrypt
- **Protection CSRF** : Activée sur tous les formulaires
- **Validation** : Validation des données côté serveur

## 🎨 Personnalisation

### Changer les couleurs

Éditez `tailwind.config.js` pour modifier le thème :

```javascript
theme: {
  extend: {
    colors: {
      primary: '#3b82f6', // Bleu
      // Ajoutez vos couleurs ici
    },
  },
}
```

### Ajouter des départements/niveaux

Modifiez `database/seeders/DatabaseSeeder.php` pour ajouter vos propres classes.

### Modifier les statistiques

Éditez `app/Http/Controllers/TeacherController.php` pour ajouter de nouvelles métriques.

## 📱 Intégration RFID Physique

La plupart des lecteurs RFID USB fonctionnent comme des claviers :

1. Branchez le lecteur USB
2. Scannez un badge
3. Le code est automatiquement saisi dans le champ et validé
4. Aucune configuration supplémentaire nécessaire

## 🐛 Dépannage

### Erreur "Vite manifest not found"
Assurez-vous que `npm run dev` est en cours ou exécutez `npm run build`.

### Erreur de migration
```bash
php artisan migrate:fresh
php artisan db:seed
```

### Tailwind ne fonctionne pas
Vérifiez que :
1. `tailwind.config.js` existe
2. `resources/css/app.css` contient les directives @tailwind
3. Le serveur Vite est lancé (`npm run dev`)

### Problème d'authentification
Vérifiez que la session est configurée dans `.env` :
```env
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

## 📊 Base de données

### Table `users`
- id, name, email, password
- role (student/teacher)
- rfid_code (unique)
- classe_id (foreign key)

### Table `classes`
- id, name, level
- teacher_id (foreign key)

### Table `attendance_logs`
- id, user_id, action (ENTREE/SORTIE)
- timestamp

## 🚀 Déploiement

Pour déployer en production :

```bash
# Optimiser la configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Compiler les assets
npm run build

# Configurer les permissions
chmod -R 755 storage bootstrap/cache
```

## 📝 Améliorations futures

- [ ] Export Excel des présences
- [ ] Statistiques avancées avec graphiques
- [ ] Notifications email pour les absences
- [ ] API REST complète
- [ ] Application mobile
- [ ] Gestion des retards
- [ ] Justificatifs d'absence

## 👨‍💻 Support

Pour toute question ou problème, consultez la documentation Laravel officielle : https://laravel.com/docs

---

**Développé avec Laravel 11, Tailwind CSS et ❤️**
