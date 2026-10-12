export default {
  testEnvironment: 'jsdom',
  roots: ['<rootDir>/tests', '<rootDir>/resources'],
  testMatch: ['**/tests/**/*.test.js'],
  moduleNameMapper: {
    '\\.(css|scss)$': '<rootDir>/tests/__mocks__/styleMock.js',
  },
  setupFilesAfterEnv: ['<rootDir>/tests/setup.js'],
  // Tests run as native ES modules (see the test:js scripts). An empty transform
  // stops Jest from falling back to its default babel-jest transform.
  transform: {},
  coverageProvider: 'v8',
  collectCoverageFrom: [
    'resources/js/**/*.js',
    '!resources/js/**/*.test.js',
  ],
};
