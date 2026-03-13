<p align="center">
  <a href="https://roots.io/sage/"><img alt="Sage" src="https://cdn.roots.io/app/uploads/logo-sage.svg" height="100"></a>
</p>

<p align="center">
  <a href="https://packagist.org/packages/roots/sage"><img alt="Packagist Installs" src="https://img.shields.io/packagist/dt/roots/sage?label=projects%20created&colorB=2b3072&colorA=525ddc&style=flat-square"></a>
  <a href="https://github.com/roots/sage/actions/workflows/main.yml"><img alt="Build Status" src="https://img.shields.io/github/actions/workflow/status/roots/sage/main.yml?branch=main&logo=github&label=CI&style=flat-square"></a>
  <a href="https://bsky.app/profile/roots.dev"><img alt="Follow roots.dev on Bluesky" src="https://img.shields.io/badge/follow-@roots.dev-0085ff?logo=bluesky&style=flat-square"></a>
</p>

# Sage

**Advanced hybrid WordPress starter theme with Laravel Blade, SASS, and Bootstrap**

- 🔧 Clean, efficient theme templating with Laravel Blade
- ⚡️ Modern front-end development workflow powered by Vite
- 🎨 Style and layout quickly with SASS and Bootstrap
- 🚀 Harness the power of Laravel with [Acorn integration](https://github.com/roots/acorn)
- 📦 Create page builder modules using ACF flexible content and compose fields programatically with ACF Composer

Sage brings proper PHP templating and modern JavaScript tooling to WordPress themes. Write organized, component-based code using Laravel Blade, enjoy instant builds and CSS hot-reloading with Vite, and leverage Laravel's robust feature set through Acorn.

<p align="center">
  <a href="https://roots.io/"><strong><code>Website</code></strong></a> &nbsp;&nbsp; <a href="https://roots.io/sage/docs/installation/"><strong><code>Documentation</code></strong></a> &nbsp;&nbsp; <a href="https://github.com/roots/sage/releases"><strong><code>Releases</code></strong></a> &nbsp;&nbsp; <a href="https://discourse.roots.io/"><strong><code>Support</code></strong></a>
</p>

## Requirements

Make sure all dependencies have been installed before moving on:

- [Acorn](https://roots.io/acorn/docs/installation/) v5
- [WordPress](https://wordpress.org/) >= 6.6.1
- [PHP](https://secure.php.net/manual/en/install.php) >= 8.2
- [Composer](https://getcomposer.org/download/)
- [Node.js](http://nodejs.org/) >= 20

## Theme installation

- Clone the repo into the themes directory.
- Install Composer dependencies:

```sh
$ composer install
```

Make sure that you have [Acorn installed](https://roots.io/acorn/docs/installation/).

## Theme setup

Edit `app/setup.php` to enable or disable theme features, setup navigation menus, post thumbnail sizes, and sidebars.

## Theme development

- Run `npm install` from the theme directory to install dependencies
- Update `vite.config.js` with your local base path (`base: '/app/themes/goldie-initiative/public/build/',`)
- Create a `.env` file in the theme root with the following variables:

```sh
APP_URL=http://sage-boilerplate.local   # Your local site URL (used by Vite)
WP_PLUGIN_GF_KEY=your-license-key       # Gravity Forms license key (required for composer install)
```

Your Gravity Forms license key can be found in your [Gravity Forms account](https://www.gravityforms.com/my-account/).

> **Note:** `.env` is gitignored and must be created manually on each environment. Never commit it to version control.

### Premium plugins

The following plugins are managed via Composer but require credentials or manual steps:

- **Gravity Forms** — installed via `composer install` using your `WP_PLUGIN_GF_KEY` env var
- **ACF Pro** — installed via `composer install` using the WPEngine Composer repository (credentials managed automatically in CI)
- **WP Migrate DB Pro** — must be installed manually; not available via Composer


### Build commands

- `npm run dev` — Compile assets when file changes are made with instant reload (no refresh required)
- `npm run build` — Compile assets for production

## Theme structure

```sh
themes/your-theme-name/   # → Root of your Sage based theme
├── app/                  # → Theme PHP
│   ├── Providers/        # → Service providers
│   ├── View/             # → View models
│   ├── filters.php       # → Theme filters
│   └── setup.php         # → Theme setup
├── composer.json         # → Autoloading for `app/` files
├── public/               # → Built theme assets (never edit)
├── functions.php         # → Theme bootloader
├── index.php             # → Theme template wrapper
├── node_modules/         # → Node.js packages (never edit)
├── package.json          # → Node.js dependencies and scripts
├── postcss.config.js     # → PurgeCSS and PostCSS config (edit PurgeCSS safelist)
├── resources/            # → Theme assets and templates
│   ├── fonts/            # → Theme fonts
│   ├── images/           # → Theme images
│   ├── js/               # → Theme javascript
│       ├── modules/      # → Module javascript (imported dynamically, file name must match the module ACF layout name with dashes, i.e. example-module.js)
│   ├── css/              # → Theme stylesheets
│       ├── common/       # → Global styles, variables, and mixins
│       ├── components/   # → Component styles
│       ├── layouts/      # → Layout styles
│       ├── modules/      # → Module styles
│       ├── app.scss/     # → App stylesheet (import all stylesheets)
│       ├── editor.scss/  # → Editor styles
│   └── views/            # → Theme templates
│       ├── components/   # → Component templates
│       ├── forms/        # → Form templates
│       ├── layouts/      # → Base templates
│       ├── modules/      # → Module templates
│       ├── partials/     # → Partial templates
        └── sections/     # → Section templates
├── screenshot.png        # → Theme screenshot for WP admin
├── style.css             # → Theme meta information
├── vendor/               # → Composer packages (never edit)
└── vite.config.js         # → Bud configuration
```
