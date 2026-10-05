import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

// Set APP_URL if it doesn't exist for Laravel Vite plugin
if (! process.env.APP_URL) {
  process.env.APP_URL = 'http://example.test';
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
