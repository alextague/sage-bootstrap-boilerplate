// Configure PurgeCSS and safelist
import { createRequire } from 'module';
import purgecssWordPress from 'purgecss-with-wordpress';
import autoprefixer from 'autoprefixer';

const require = createRequire(import.meta.url);
const purgecssPlugin = require('@fullhuman/postcss-purgecss').default || require('@fullhuman/postcss-purgecss');
const isBuild = process.argv.includes('build');

export default {
  plugins: [
    ...(isBuild ? [
      purgecssPlugin({
        content: [
          './app/**/*.php',
          './resources/views/**/*.php',
          './resources/js/**/*.js',
          './node_modules/@fancyapps/ui/dist/fancybox/fancybox.css',
        ],
        defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || [],
        safelist: [
          ...purgecssWordPress.safelist,
          /svg.*/,
          /fa.*/,
          /fancybox.*/,
          /axis-.*/,
          /splide/,
          /hamburger/,
          /headroom/,
          /gform.*/,
          /gfield.*/,
        ],
      }),
    ] : []),
    autoprefixer,
  ],
};

