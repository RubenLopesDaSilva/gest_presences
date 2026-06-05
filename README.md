
ATTENTION CE README N'EST PAS ENCORE À JOURS - MERCI DE NE PAS VOUS FIER À CELUI CI POUR LE MOMENT

# 🎓 Système de Gestion de Présence RFID - Laravel

Application Laravel complète avec **deux interfaces distinctes** pour la gestion de présence par badge RFID dans un contexte scolaire.

## 🎯 Deux Interfaces

### 👨‍🎓 Interface Élève
- Scanner RFID public (sans connexion)
- Tableau de bord personnel
- Historique des pointages
- Statut présence en temps réel

### 👨‍🏫 Interface Professeur
- Vue d'ensemble des classes
- Gestion complète des élèves
- Statistiques de présence
- Historique détaillé avec filtres
- Activité en temps réel

## 🚀 Installation Rapide

### 1. Créer le projet


### 2. Copier tous les fichiers


### 3. Configuration


# Installer dépendances
composer install
npm install -D tailwindcss postcss autoprefixer
npm install

# Migrations
php artisan migrate
php artisan db:seed

# Lancer

```

## 🔐 Comptes par défaut

**Professeur :**
- Email: `prof@ecole.fr`
- Password: `password`

**Élèves :**
- Email: `jean.martin@ecole.fr` (ou autre élève)
- Password: `password`
- Codes RFID: `RFID001` à `RFID009`

## 📱 Routes principales

**Public :**
- `/` - Scanner RFID (page d'accueil)
- `/login` - Connexion

**Élève (authentifié) :**
- `/student/dashboard` - Tableau de bord personnel

**Professeur (authentifié) :**
- `/teacher/dashboard` - Vue d'ensemble
- `/teacher/classe/{id}` - Détail d'une classe
- `/teacher/students` - Gestion des élèves
- `/teacher/history` - Historique complet

## 🏗️ Structure

### Modèles
- **User** - Utilisateurs (élèves et professeurs) avec rôles
- **Classe** - Classes avec professeur assigné
- **AttendanceLog** - Logs de présence (entrées/sorties)

### Contrôleurs
- **AuthController** - Authentification
- **StudentController** - Interface élève
- **TeacherController** - Interface professeur

## ✨ Fonctionnalités

✅ Scanner RFID avec feedback visuel
✅ Authentification par rôle (élève/professeur)
✅ Tableau de bord élève simple et clair
✅ Gestion complète des classes pour professeurs
✅ Statistiques en temps réel
✅ Historique avec filtres
✅ Design moderne avec Tailwind CSS
✅ Interface responsive
✅ Support lecteur RFID USB

## 📚 Documentation

Consultez `GUIDE_COMPLET.md` pour :
- Architecture détaillée
- Guide d'utilisation complet
- Personnalisation
- Dépannage
- Déploiement

## 🎨 Technologies

- Laravel 14
- Tailwind CSS
- MySQL/PostgreSQL
- Vite
- Blade Templates

server nginx: 157.23.98.220:80