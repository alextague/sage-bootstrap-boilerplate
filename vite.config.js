import { defineConfig, loadEnv } from 'vite'
import laravel from 'laravel-vite-plugin'

// Set APP_URL for the Laravel Vite plugin, which uses it for the dev server's allowed
// CORS origin. Read it from .env (where the README says to set it); the placeholder is
// only a last resort. It must match the site URL exactly, including https.
if (! process.env.APP_URL) {
  process.env.APP_URL = loadEnv('development', process.cwd(), '').APP_URL || 'http://example.test';
}

export default defineConfig({
  base: '/wp-content/themes/sage-vite/public/build/',
  css: {
    postcss: './postcss.config.js',
    preprocessorOptions: {
      scss: {
        // Hide deprecation warnings from inside npm packages (Bootstrap 5 and Hamburgers aren't
        // written for Sass modules). The theme's only @import is the Bootstrap wrapper in
        // resources/css/vendor/_bootstrap.scss, so the import deprecation is silenced for it.
        quietDeps: true,
        silenceDeprecations: ['import'],
      },
    },
  },
  plugins: [
    laravel({
      input: [
        'resources/css/app.scss',
        'resources/js/app.js',
      ],
      refresh: true,
      assets: ['resources/images/**', 'resources/fonts/**'],
    }),
  ],
  resolve: {
    alias: {
      '@scripts': '/resources/js',
      '@styles': '/resources/css',
      '@fonts': '/resources/fonts',
      '@images': '/resources/images',
    },
  },
})
