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
