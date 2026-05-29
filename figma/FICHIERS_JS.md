# Fichiers JavaScript à créer manuellement

Comme ce projet utilise un hook qui bloque les fichiers .js, voici le contenu des fichiers JavaScript à créer manuellement dans votre projet Laravel :

## tailwind.config.js

Créez le fichier `tailwind.config.js` à la racine du projet avec ce contenu :

```javascript
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
```

## vite.config.js

Créez le fichier `vite.config.js` à la racine du projet avec ce contenu :

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

## resources/js/app.js

Créez le fichier `resources/js/app.js` avec ce contenu :

```javascript
import './bootstrap';
```

## postcss.config.js (optionnel)

Si nécessaire, créez `postcss.config.js` à la racine :

```javascript
export default {
  plugins: {
    tailwindcss: {},
    autoprefixer: {},
  },
}
```
