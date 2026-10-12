// Setup file for Jest tests
// Add global test setup here if needed

import { jest } from '@jest/globals';

// Mock jQuery if not available
if (typeof jQuery === 'undefined') {
  global.jQuery = jest.fn((selector) => {
    // Return a mock jQuery object with common methods
    return {
      on: jest.fn().mockReturnThis(),
      html: jest.fn().mockReturnThis(),
      css: jest.fn().mockReturnThis(),
      attr: jest.fn().mockReturnThis(),
      data: jest.fn().mockReturnThis(),
      closest: jest.fn(),
    };
  });
  global.jQuery.fn = {};
}
