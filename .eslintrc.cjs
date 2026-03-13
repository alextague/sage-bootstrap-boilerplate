module.exports = {
  root: true,
  env: {
    browser: true,
    node: true,
    es2021: true
  },
  extends: [
    'eslint:recommended',
    'eslint-config-prettier' // This must be the last extension to disable conflicting rules
  ],
  parserOptions: {
    ecmaVersion: 'latest',
    sourceType: 'module'
  },
  rules: {
    // You can add custom ESLint rules here
    'prettier/prettier': 'error'
  }
};
