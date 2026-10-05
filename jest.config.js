export default {
  testEnvironment: 'jsdom',
  roots: ['<rootDir>/tests', '<rootDir>/resources'],
  testMatch: ['**/tests/**/*.test.js'],
  moduleNameMapper: {
    '\\.(css|scss)$': '<rootDir>/tests/__mocks__/styleMock.js',
  },
  setupFilesAfterEnv: ['<rootDir>/tests/setup.js'],
  transform: {
    '^.+\\.jsx?$': 'babel-jest',
  },
  collectCoverageFrom: [
    'resources/js/**/*.js',
    '!resources/js/**/*.test.js',
  ],
};
