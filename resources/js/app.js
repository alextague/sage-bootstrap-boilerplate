import.meta.glob([
  '../images/**',
  '../fonts/**',
]);

// Import Headroom.js
import Headroom from 'headroom.js';

// Import Bootstrap Offcanvas for mobile menu
// eslint-disable-next-line no-unused-vars
import { Offcanvas } from 'bootstrap';

// Load all modules with import.meta.glob
const modules = import.meta.glob('./modules/*.js');

// Get body classes
let classNames = [];
let bodyClasses = document.body.getAttribute('class').split(' ');

bodyClasses.forEach(el => {
  if(el.includes('-js')) {
    classNames.push(el.replace('-js', ''));
  }
});

// Dynamically load matching modules
classNames.forEach(async (className) => {
  const modulePath = `./modules/${className}.js`;
  if (modules[modulePath]) {
    await modules[modulePath]();
  }
});

//------------------------------------------------//
//------------ HEADROOM.JS STICKY HEADER -----------//
//------------------------------------------------//
// Uses headroom.js to hide and show the sticky header on scroll

var stickyHeader = document.querySelector("header");

if (stickyHeader) {
  var options = {
    // vertical offset in px before element is first unpinned
    offset : 150,
  }

  var headroom  = new Headroom(stickyHeader, options);

  headroom.init();

  // Make headroom instance globally accessible for other modules
  window.headroomInstance = headroom;
}
