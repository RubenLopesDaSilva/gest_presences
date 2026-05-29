# Fichiers de Configuration pour Tailwind CSS

Créez ces fichiers à la racine de votre projet Laravel :

## 1. tailwind.config.js

```javascript
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#eff6ff',
          100: '#dbeafe',
          200: '#bfdbfe',
          300: '#93c5fd',
          400: '#60a5fa',
          500: '#3b82f6',
          600: '#2563eb',
          700: '#1d4ed8',
          800: '#1e40af',
          900: '#1e3a8a',
        },
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
```

## 2. postcss.config.js

```javascript
export default {
  plugins: {
    tailwindcss: {},
    autoprefixer: {},
  },
}
```

## 3. vite.config.js

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

## 4. resources/css/app.css

```css
@tailwind base;
@tailwind components;
@tailwind utilities;

/* Styles personnalisés */
body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 
                 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* Animation de pulse pour le scanner */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Styles pour les transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}
```

## 5. resources/js/app.js

```javascript
// Fichier JavaScript principal
import './bootstrap';

console.log('Application RFID chargée');

// Ajoutez ici vos scripts JavaScript personnalisés si nécessaire
```

## 6. package.json

Ajoutez ou mettez à jour les scripts et dépendances :

```json
{
    "private": true,
    "type": "module",
    "scripts": {
        "dev": "vite",
        "build": "vite build"
    },
    "devDependencies": {
        "autoprefixer": "^10.4.19",
        "axios": "^1.6.4",
        "laravel-vite-plugin": "^1.0.0",
        "postcss": "^8.4.38",
        "tailwindcss": "^3.4.3",
        "vite": "^5.0.0"
    }
}
```

## Installation

Après avoir créé ces fichiers, exécutez :

```bash
# Installer les dépendances
npm install

# Compiler les assets en mode développement
npm run dev

# Ou pour la production
npm run build
```

## Vérification

Pour vérifier que Tailwind CSS fonctionne correctement :

1. Lancez `npm run dev`
2. Lancez `php artisan serve`
3. Ouvrez `http://localhost:8000`
4. Les styles Tailwind devraient être appliqués

## Dépannage

**Erreur "Vite manifest not found"**
- Solution : Assurez-vous que `npm run dev` est en cours d'exécution

**Les styles Tailwind ne s'appliquent pas**
- Vérifiez que tous les fichiers ci-dessus sont créés
- Redémarrez `npm run dev`
- Vérifiez que `@vite(['resources/css/app.css', 'resources/js/app.js'])` est présent dans vos layouts Blade

**Erreur de compilation**
- Supprimez `node_modules` et `package-lock.json`
- Exécutez `npm install` à nouveau
