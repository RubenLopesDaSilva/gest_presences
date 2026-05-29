# Guide d'Installation - Système de Gestion de Présence RFID Laravel

## Étape 1: Créer un nouveau projet Laravel

```bash
composer create-project laravel/laravel laravel-rfid
cd laravel-rfid
```

## Étape 2: Copier les fichiers

Copiez tous les fichiers du dossier `laravel-rfid` dans votre nouveau projet Laravel :

- `app/Models/` → Copiez Employee.php et AttendanceLog.php
- `app/Http/Controllers/` → Copiez tous les contrôleurs
- `database/migrations/` → Copiez les deux fichiers de migration
- `database/seeders/` → Copiez EmployeeSeeder.php
- `resources/views/` → Copiez toutes les vues Blade
- `resources/css/app.css` → Remplacez le contenu
- `routes/web.php` → Remplacez le contenu
- `package.json` → Remplacez le contenu

## Étape 3: Créer les fichiers de configuration JavaScript

Créez les fichiers suivants à la racine du projet (voir FICHIERS_JS.md pour le contenu) :
- `tailwind.config.js`
- `vite.config.js`
- `postcss.config.js`
- `resources/js/app.js`

## Étape 4: Configuration de la base de données

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
CREATE DATABASE rfid_attendance;
EXIT;
```

## Étape 5: Installer les dépendances

```bash
# Dépendances PHP
composer install

# Dépendances NPM
npm install
```

## Étape 6: Exécuter les migrations

```bash
php artisan migrate
```

## Étape 7: Peupler la base de données (optionnel)

Pour ajouter des données de test :

```bash
php artisan db:seed --class=EmployeeSeeder
```

## Étape 8: Compiler les assets

En mode développement :

```bash
npm run dev
```

Ou pour la production :

```bash
npm run build
```

## Étape 9: Générer la clé d'application

```bash
php artisan key:generate
```

## Étape 10: Lancer le serveur

```bash
php artisan serve
```

Visitez `http://localhost:8000` dans votre navigateur.

## Structure des URLs

- `/` - Tableau de bord
- `/scanner` - Scanner RFID
- `/employees` - Gestion des employés
- `/history` - Historique des passages
- `/api/scan` - API POST pour scanner un badge

## Intégration avec un lecteur RFID physique

Pour utiliser un véritable lecteur RFID :

1. La plupart des lecteurs RFID agissent comme des claviers USB
2. Ils envoient automatiquement le code RFID suivi d'une touche Entrée
3. Le scanner dans `/scanner` capture automatiquement ces entrées
4. Aucune configuration supplémentaire n'est nécessaire

## Dépannage

### Erreur "Vite manifest not found"

Assurez-vous que `npm run dev` est en cours d'exécution ou exécutez `npm run build`.

### Erreur de migration

Supprimez toutes les tables et réexécutez :

```bash
php artisan migrate:fresh
php artisan db:seed --class=EmployeeSeeder
```

### Erreur Tailwind CSS ne fonctionne pas

Vérifiez que :
1. `tailwind.config.js` existe et est correct
2. `resources/css/app.css` contient les directives @tailwind
3. Le serveur Vite est en cours d'exécution (`npm run dev`)

## Personnalisation

### Modifier les départements

Éditez `database/seeders/EmployeeSeeder.php` pour ajouter vos propres départements.

### Ajouter des statistiques

Modifiez `app/Http/Controllers/DashboardController.php` pour ajouter de nouvelles métriques.

### Changer le thème

Éditez les classes Tailwind dans les vues Blade pour personnaliser les couleurs et le style.
