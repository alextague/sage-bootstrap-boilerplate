import js from '@eslint/js';
import eslintConfigPrettier from 'eslint-config-prettier';

export default [
  {
    ignores: ['build/**', 'dist/**', 'vendor/**', 'node_modules/**'],
  },
  {
    ...js.configs.recommended,
    files: ['resources/js/**/*.js'],
    languageOptions: {
      ...js.configs.recommended.languageOptions,
      ecmaVersion: 'latest',
      sourceType: 'module',
      globals: {
        console: 'readonly',
        document: 'readonly',
        window: 'readonly',
        jQuery: 'readonly',
        AbortController: 'readonly',
        ResizeObserver: 'readonly',
        fetch: 'readonly',
      },
    },
  },
  eslintConfigPrettier,
];
