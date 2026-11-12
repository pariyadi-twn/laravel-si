// [P03] Vite mengompilasi CSS/JavaScript Bootstrap untuk Blade.
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
export default defineConfig({
  plugins: [laravel({ input: ['resources/css/app.css', 'resources/js/app.js'], refresh: true })]
});
