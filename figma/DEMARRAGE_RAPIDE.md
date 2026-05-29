# 🚀 Démarrage Rapide - Application RFID

## Installation en 5 minutes

```bash
# 1. Créer le projet Laravel
composer create-project laravel/laravel mon-app-rfid
cd mon-app-rfid

# 2. Copier TOUS les fichiers du dossier laravel-rfid dans le projet

# 3. Configuration
cp .env.example .env
# Éditez .env et configurez votre base de données

# 4. Base de données
mysql -u root -p
CREATE DATABASE rfid_attendance;
EXIT;

# 5. Installation
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed

# 6. Tailwind CSS
npm install
npm run dev  # Laisser tourner dans un terminal

# 7. Lancer le serveur (nouveau terminal)
php artisan serve
```

Ouvrez http://localhost:8000 🎉

## 🔑 Comptes de test

### Professeur
```
Email: prof@ecole.fr
Mot de passe: password
```

### Élèves
```
Email: jean.martin@ecole.fr (ou autre élève créé)
Mot de passe: password
Codes RFID: RFID001, RFID002, RFID003, etc.
```

## 📱 Parcours utilisateur

### 1️⃣ Scanner un badge (Page d'accueil - Public)

```
┌─────────────────────────────────────┐
│          SCANNER RFID               │
│                                     │
│         [Icône Badge]               │
│                                     │
│   Scannez votre badge pour pointer  │
│                                     │
│   [____________________]            │
│   Scannez votre badge...            │
│                                     │
│         🕐 14:32:15                 │
│    Jeudi 29 mai 2026                │
│                                     │
│   Se connecter à l'espace →        │
└─────────────────────────────────────┘
```

**Actions :**
1. Scanner votre badge ou taper le code (ex: RFID001)
2. Appuyez sur Entrée
3. Feedback visuel :
   - ✅ Vert pour une entrée
   - 👋 Orange pour une sortie

### 2️⃣ Interface Élève

**Connexion → /student/dashboard**

```
┌─────────────────────────────────────────────────────┐
│  📚 Mon Espace            Jean Martin   [Déconnexion]│
├─────────────────────────────────────────────────────┤
│                                                     │
│  Bonjour, Jean Martin 👋                            │
│  Terminale S1                                       │
│                                                     │
│  ┌─────────────────────────────────────┐            │
│  │ Statut aujourd'hui    ✅ Présent    │            │
│  │ 29/05/2026                          │            │
│  └─────────────────────────────────────┘            │
│                                                     │
│  ┌──────────────┐  ┌──────────────────┐            │
│  │ Aujourd'hui  │  │ Cette semaine    │            │
│  │              │  │                  │            │
│  │ 📥 Entrée    │  │ 29/05 - 08:30   │            │
│  │ 08:30:15     │  │ 28/05 - 08:25   │            │
│  │              │  │ 27/05 - 08:35   │            │
│  │ 📤 Sortie    │  │ ...             │            │
│  │ 12:00:42     │  │                 │            │
│  └──────────────┘  └──────────────────┘            │
│                                                     │
│         [📋 Scanner mon badge]                      │
└─────────────────────────────────────────────────────┘
```

### 3️⃣ Interface Professeur

**Connexion → /teacher/dashboard**

```
┌──────────────────────────────────────────────────────────────┐
│  🎓 Espace Professeur        M. Dupont      [Déconnexion]    │
│  Tableau de bord | Élèves | Historique                       │
├──────────────────────────────────────────────────────────────┤
│                                                              │
│  Tableau de Bord                                             │
│  Jeudi 29 mai 2026                                           │
│                                                              │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐                   │
│  │   25     │  │   18     │  │    7     │                   │
│  │  Total   │  │ Présents │  │ Absents  │                   │
│  └──────────┘  └──────────┘  └──────────┘                   │
│                                                              │
│  Mes Classes                                                 │
│  ┌──────────────────┐  ┌──────────────────┐                 │
│  │ Terminale S1     │  │ Première ES2     │                 │
│  │ Terminale        │  │ Première         │                 │
│  │                  │  │                  │                 │
│  │ ✅ 12 présents   │  │ ✅ 6 présents    │                 │
│  │ 15 élèves        │  │ 10 élèves        │                 │
│  └──────────────────┘  └──────────────────┘                 │
│                                                              │
│  Activité Récente                                            │
│  ┌────────────────────────────────────────────────┐          │
│  │ Élève          │ Classe      │ Action │ Heure  │          │
│  ├────────────────────────────────────────────────┤          │
│  │ Jean Martin    │ Terminale   │ ENTRÉE │ 08:30  │          │
│  │ Marie Dubois   │ Terminale   │ ENTRÉE │ 08:25  │          │
│  │ Emma Moreau    │ Première    │ ENTRÉE │ 08:28  │          │
│  └────────────────────────────────────────────────┘          │
└──────────────────────────────────────────────────────────────┘
```

**Cliquer sur une classe → Vue détaillée**

```
┌──────────────────────────────────────────────────────────────┐
│  ← Retour                                                     │
│                                                              │
│  Terminale S1                                                │
│  Terminale                          Total: 15 élèves         │
│                                     Présents: 12             │
│                                                              │
│  ┌────┐  ┌────┐  ┌────┐  ┌────┐                             │
│  │ 15 │  │ 12 │  │ 3  │  │ 80%│                             │
│  │Tot.│  │Prés.│  │Abs.│  │Taux│                             │
│  └────┘  └────┘  └────┘  └────┘                             │
│                                                              │
│  Liste des Élèves                                            │
│  ┌──────────────────────────────────────────────────────┐    │
│  │ Nom           │ Statut    │ Dernière  │ Pointages   │    │
│  ├──────────────────────────────────────────────────────┤    │
│  │ Jean Martin   │✅ Présent │ 08:30:15  │ → ←         │    │
│  │ Marie Dubois  │✅ Présent │ 08:25:30  │ →           │    │
│  │ Pierre Leroy  │⚪ Absent  │ -         │ -           │    │
│  └──────────────────────────────────────────────────────┘    │
└──────────────────────────────────────────────────────────────┘
```

## 🎯 Fonctionnalités clés

### Pour les Élèves
- ✅ Scanner rapide et simple
- ✅ Feedback visuel immédiat
- ✅ Historique personnel
- ✅ Pas besoin de compte pour scanner

### Pour les Professeurs
- ✅ Vue d'ensemble multi-classes
- ✅ Statistiques en temps réel
- ✅ Liste détaillée par classe
- ✅ Gestion complète des élèves
- ✅ Historique avec filtres
- ✅ Export possible (à implémenter)

## 🔧 Test du scanner RFID

1. Allez sur http://localhost:8000
2. Tapez un code RFID (ex: RFID001)
3. Appuyez sur Entrée

**Résultat attendu :**
```
┌─────────────────────────────┐
│           ✅                │
│                             │
│       Bienvenue !           │
│                             │
│      Jean Martin            │
│      Terminale S1           │
│   ENTRÉE • 14:32:15         │
└─────────────────────────────┘
```

## 📊 Flux de données

```
Badge RFID
    ↓
Scanner (/)
    ↓
POST /api/scan
    ↓
Vérifie le code dans DB
    ↓
Détermine action (ENTREE/SORTIE)
    ↓
Crée AttendanceLog
    ↓
Retourne feedback
```

## 🎨 Personnalisation rapide

### Changer les couleurs

Éditez `tailwind.config.js` :

```javascript
theme: {
  extend: {
    colors: {
      primary: '#3b82f6', // Changez ici
    },
  },
}
```

### Ajouter une classe

```php
// Dans DatabaseSeeder.php
Classe::create([
    'name' => 'Seconde A',
    'level' => 'Seconde',
    'teacher_id' => $teacher->id,
]);
```

### Ajouter un élève

Via l'interface professeur :
1. Menu "Élèves"
2. Bouton "+ Ajouter un élève"
3. Remplir le formulaire

## 🐛 Problèmes courants

**Le scanner ne fonctionne pas**
- Vérifiez que npm run dev est lancé
- Vérifiez la console navigateur (F12)
- Vérifiez que le code RFID existe en DB

**Les styles ne s'affichent pas**
- Relancez npm run dev
- Videz le cache navigateur (Ctrl+Shift+R)

**Erreur 404 sur les routes**
- Vérifiez que routes/web.php est bien copié
- Exécutez php artisan route:clear

## 📚 Prochaines étapes

1. ✅ Testez le scanner avec tous les codes RFID
2. ✅ Connectez-vous en tant que professeur
3. ✅ Consultez les différentes classes
4. ✅ Ajoutez un nouvel élève
5. ✅ Consultez l'historique

Pour plus de détails, consultez :
- `GUIDE_COMPLET.md` - Documentation complète
- `FICHIERS_CONFIG.md` - Configuration Tailwind CSS
- `README.md` - Vue d'ensemble

---

**Bon démarrage ! 🚀**
