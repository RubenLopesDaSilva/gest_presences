# 📁 Structure des Fichiers - Application RFID

## Vue d'ensemble

```
laravel-rfid/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthController.php          ✅ Gestion authentification
│   │       ├── StudentController.php       ✅ Interface élève
│   │       └── TeacherController.php       ✅ Interface professeur
│   │
│   └── Models/
│       ├── User.php                        ✅ Modèle utilisateur (élèves + profs)
│       ├── Classe.php                      ✅ Modèle classe
│       └── AttendanceLog.php               ✅ Logs de présence
│
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000001_create_classes_table.php         ✅
│   │   ├── 2024_01_01_000002_create_users_table.php           ✅
│   │   └── 2024_01_01_000003_create_attendance_logs_table.php ✅
│   │
│   └── seeders/
│       └── DatabaseSeeder.php              ✅ Données de test
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php               ✅ Layout principal
│       │
│       ├── auth/
│       │   └── login.blade.php             ✅ Page de connexion
│       │
│       ├── student/
│       │   ├── scanner.blade.php           ✅ Scanner RFID public
│       │   └── dashboard.blade.php         ✅ Tableau de bord élève
│       │
│       └── teacher/
│           ├── dashboard.blade.php         ✅ Tableau de bord prof
│           ├── classe.blade.php            ✅ Vue détaillée classe
│           ├── students.blade.php          ✅ Gestion élèves
│           └── history.blade.php           ✅ Historique complet
│
├── routes/
│   └── web.php                             ✅ Toutes les routes
│
├── GUIDE_COMPLET.md                        📚 Documentation complète
├── DEMARRAGE_RAPIDE.md                     🚀 Guide de démarrage
├── FICHIERS_CONFIG.md                      ⚙️  Config Tailwind CSS
├── STRUCTURE_FICHIERS.md                   📁 Ce fichier
└── README.md                               📖 Vue d'ensemble
```

## 📝 Détail des fichiers

### Contrôleurs (app/Http/Controllers/)

#### 1. AuthController.php
```php
Méthodes:
- showLoginForm()  → Affiche le formulaire de connexion
- login()          → Traite la connexion
- logout()         → Déconnexion
```

#### 2. StudentController.php
```php
Méthodes:
- scanner()        → Affiche le scanner RFID (page publique)
- scan()           → API pour traiter le scan d'un badge
- dashboard()      → Tableau de bord personnel de l'élève
```

#### 3. TeacherController.php
```php
Méthodes:
- dashboard()      → Tableau de bord professeur
- showClasse()     → Vue détaillée d'une classe
- students()       → Liste et gestion des élèves
- storeStudent()   → Créer un nouvel élève
- destroyStudent() → Supprimer un élève
- history()        → Historique complet avec filtres
```

### Modèles (app/Models/)

#### 1. User.php
```php
Champs:
- id, name, email, password
- role (student/teacher)
- rfid_code (unique)
- classe_id

Relations:
- belongsTo(Classe)
- hasMany(AttendanceLog)

Méthodes:
- isTeacher()    → Vérifie si professeur
- isStudent()    → Vérifie si élève
- getStatusAttribute() → Calcule le statut actuel
```

#### 2. Classe.php
```php
Champs:
- id, name, level
- teacher_id

Relations:
- belongsTo(User) → teacher
- hasMany(User) → students

Méthodes:
- getPresentStudentsCountAttribute()
- getAbsentStudentsCountAttribute()
```

#### 3. AttendanceLog.php
```php
Champs:
- id, user_id
- action (ENTREE/SORTIE)
- timestamp

Relations:
- belongsTo(User)

Méthodes:
- getActionColorAttribute()
```

### Vues (resources/views/)

#### Layouts
- **app.blade.php** : Layout principal avec navigation

#### Auth
- **login.blade.php** : Formulaire de connexion

#### Student
- **scanner.blade.php** : Scanner RFID avec feedback visuel
- **dashboard.blade.php** : Historique personnel de l'élève

#### Teacher
- **dashboard.blade.php** : Vue d'ensemble de toutes les classes
- **classe.blade.php** : Liste détaillée des élèves d'une classe
- **students.blade.php** : Gestion complète des élèves
- **history.blade.php** : Historique avec filtres

### Routes (routes/web.php)

```php
Routes publiques:
GET  /                  → Scanner RFID
POST /api/scan          → API scan badge
GET  /login             → Formulaire connexion
POST /login             → Traiter connexion
POST /logout            → Déconnexion

Routes élèves (auth):
GET  /student/dashboard → Tableau de bord élève

Routes professeurs (auth):
GET  /teacher/dashboard         → Tableau de bord prof
GET  /teacher/classe/{id}       → Détail classe
GET  /teacher/students          → Liste élèves
POST /teacher/students          → Créer élève
DELETE /teacher/students/{id}   → Supprimer élève
GET  /teacher/history           → Historique
```

### Migrations (database/migrations/)

#### 1. create_classes_table.php
```sql
Table: classes
- id
- name (nom de la classe)
- level (niveau)
- teacher_id (professeur responsable)
- timestamps
```

#### 2. create_users_table.php
```sql
Table: users
- id
- name
- email (unique)
- password
- role (student/teacher)
- rfid_code (unique, nullable)
- classe_id (foreign key)
- timestamps
```

#### 3. create_attendance_logs_table.php
```sql
Table: attendance_logs
- id
- user_id (foreign key)
- action (ENTREE/SORTIE)
- timestamp
```

### Seeder (database/seeders/)

#### DatabaseSeeder.php
Crée :
- 1 professeur : M. Dupont
- 2 classes : Terminale S1, Première ES2
- 9 élèves répartis dans les classes
- Quelques logs de test

## 🎯 Fichiers à copier dans votre projet Laravel

### Obligatoires
✅ Tous les fichiers dans `app/`
✅ Tous les fichiers dans `database/`
✅ Tous les fichiers dans `resources/views/`
✅ Le fichier `routes/web.php`

### À créer manuellement
⚙️ `tailwind.config.js` (voir FICHIERS_CONFIG.md)
⚙️ `postcss.config.js` (voir FICHIERS_CONFIG.md)
⚙️ `vite.config.js` (voir FICHIERS_CONFIG.md)
⚙️ `resources/css/app.css` (voir FICHIERS_CONFIG.md)

### Documentation (optionnel mais recommandé)
📚 `GUIDE_COMPLET.md`
📚 `DEMARRAGE_RAPIDE.md`
📚 `FICHIERS_CONFIG.md`
📚 `README.md`

## 🔄 Flux de l'application

### 1. Scan d'un badge

```
Utilisateur → Scanner (/)
    ↓
Scan badge RFID
    ↓
POST /api/scan
    ↓
StudentController::scan()
    ↓
Vérifie User avec rfid_code
    ↓
Détermine action (ENTREE/SORTIE)
    ↓
Crée AttendanceLog
    ↓
Retourne JSON avec feedback
    ↓
Affichage feedback visuel
```

### 2. Connexion et redirection

```
Utilisateur → /login
    ↓
Saisit email/password
    ↓
POST /login
    ↓
AuthController::login()
    ↓
Vérifie credentials
    ↓
Si teacher → /teacher/dashboard
Si student → /student/dashboard
```

### 3. Consultation d'une classe (Professeur)

```
Professeur → /teacher/dashboard
    ↓
Clic sur une classe
    ↓
GET /teacher/classe/{id}
    ↓
TeacherController::showClasse()
    ↓
Récupère classe + élèves + logs
    ↓
Affiche classe.blade.php
```

## 📊 Schéma de base de données

```
┌─────────────┐         ┌──────────────┐
│   classes   │◄───┐    │    users     │
├─────────────┤    │    ├──────────────┤
│ id          │    │    │ id           │
│ name        │    └────│ classe_id    │
│ level       │         │ name         │
│ teacher_id  │─────────│ email        │
│ timestamps  │         │ role         │
└─────────────┘         │ rfid_code    │
                        │ timestamps   │
                        └──────────────┘
                               │
                               │ 1:N
                               ▼
                        ┌─────────────────┐
                        │ attendance_logs │
                        ├─────────────────┤
                        │ id              │
                        │ user_id         │
                        │ action          │
                        │ timestamp       │
                        └─────────────────┘
```

## 🎨 Architecture MVC

```
Request
  ↓
Routes (web.php)
  ↓
Controller (AuthController, StudentController, TeacherController)
  ↓
Model (User, Classe, AttendanceLog)
  ↓
Database (MySQL/PostgreSQL)
  ↓
View (Blade templates)
  ↓
Response
```

## 🚀 Ordre de création recommandé

Si vous devez recréer le projet de zéro :

1. ✅ Créer les migrations
2. ✅ Créer les modèles
3. ✅ Créer les contrôleurs
4. ✅ Créer les routes
5. ✅ Créer les vues
6. ✅ Créer le seeder
7. ✅ Configurer Tailwind CSS

---

Pour toute question sur la structure, consultez `GUIDE_COMPLET.md`
