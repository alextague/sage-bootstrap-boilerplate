# Sage Vite with Bootstrap Boilerplate — WordPress Theme

This is a **Roots Sage 11.2** WordPress theme using Laravel Acorn 6 (Laravel 13 components), Blade templating, Vite 8, Bootstrap 5, and ACF (Advanced Custom Fields) for page building.

## ⚠️ CRITICAL: File Change Authorization Rules

**NEVER make file changes without EXPLICIT user approval.**

**This applies when:**
- User asks to "review", "check", or "look at" something
- You identify a problem, bug, or issue
- You know exactly what the fix should be
- The fix seems obvious or simple

**Required workflow when finding issues:**
1. **Report** what you found
2. **Describe** what the fix would be
3. **Ask**: "Would you like me to make this change?"
4. **WAIT** for explicit approval ("yes", "fix it", "do it", "go ahead")
5. **Only then** use file editing tools

**Never:**
- Make changes during a "review" without asking first
- Auto-fix issues you discover
- Assume the user wants you to fix what you found
- Make changes "while you're at it"

Violating these rules wastes user time through unwanted changes, merge conflicts, and broken code reviews.

## ⚠️ CRITICAL: Scope and File Editing Rules

**NEVER MAKE UNAUTHORIZED EDITS TO FILES OUTSIDE THE CURRENT TASK**

When working on a specific module or feature:
1. **ONLY edit files directly related to the task** — Do not make formatting changes, style improvements, or refactoring to unrelated files
2. **ASK PERMISSION FIRST** before editing any file that is not explicitly part of the current work
3. **IMMEDIATELY INFORM the user** of all files that will be edited before making changes
4. **STAY FOCUSED** — Do not fix, clean up, or improve code in files that are not part of the current task, even if you notice issues
5. **NO BATCH FORMATTING** — Never run code formatters or fixers across multiple files without explicit instruction. Note that `composer lint:fix` and `npm run lint:fix` rewrite files; `composer lint` and `npm run lint` only check.

**Example of WRONG behavior**: Working on a module and editing 50+ unrelated PHP files to "fix formatting"
**Example of RIGHT behavior**: Working on a module and ONLY editing that module's files

This is not optional — unauthorized edits create merge conflicts, complicate code reviews, and waste the user's time.

## Architecture

### Core Stack
- **PHP Framework**: Laravel components via Roots Acorn 6 (IoC container, service providers, Blade views). Requires PHP 8.4.
- **Templating**: Laravel Blade (`.blade.php` files in `resources/views/`)
- **Page Builder**: ACF Flexible Content with modular layouts
- **Editor**: The block editor (Gutenberg) is disabled for all post types and widgets in `app/setup.php`, and block library and global styles are dequeued on the front end. There is no `theme.json` and no editor stylesheet or script. Do not add Gutenberg blocks, block styles, `theme.json`, or editor assets.
- **Styles**: SCSS using the Sass module system (`@use`/`@forward`) with Bootstrap 5 (custom 24-column grid). See **SCSS Module System** below.
- **Build Tool**: Vite 8 with the Laravel plugin and hot module reload. Requires Node `^20.19.0 || >=22.12.0`.
- **JavaScript**: ES modules with dynamic imports for module-specific code

### File Structure Patterns

**ACF Module System** (Critical):
1. PHP field definition: `app/Fields/Partials/CardGrid.php` (using ACF Composer)
2. PHP field registration: `app/Fields/Builder.php` adds layout with `->addLayout('card_grid')`
3. Blade template: `resources/views/modules/card-grid.blade.php` (underscores → dashes)
4. SCSS: `resources/css/modules/_card-grid.scss` (loaded with `@use` in `app.scss`, or imported by the module's JS file)
5. JS (optional): `resources/js/modules/card-grid.js` (auto-loaded when body has `card-grid-js` class)

**View Composers** in `app/View/Composers/` prepare data for Blade views (e.g., `PageBuilder.php` processes ACF flexible content into `$page_builder` variable).

**Blade Components** in `app/View/Components/` like `AcfImage.php` are used with `<x-acf-image :image-id="$id"/>` syntax.

**CRITICAL: Blade Output Syntax**:
- **Visible text/HTML content**: Use `{!! !!}` (unescaped) — for titles, copy, WYSIWYG content, any text displayed to users
- **HTML attributes**: Use `{{ }}` (escaped) — for `href`, `src`, `class`, `id`, `data-*` attributes
- **Never wrap WordPress editor content** with `nl2br(e())` — use `{!! !!}` directly to preserve HTML

**Examples**:
```blade
{{-- CORRECT --}}
<h3>{!! $module->title !!}</h3>
<p>{!! $post->post_content !!}</p>
<div>{!! $module->copy !!}</div>
<a href="{{ $button['url'] }}" class="{{ $classes }}">{!! $button['title'] !!}</a>

{{-- WRONG --}}
<h3>{{ $module->title }}</h3>  {{-- Escapes HTML entities --}}
<p>{!! nl2br(e($content)) !!}</p>  {{-- Unnecessary wrapper --}}
<a href="{!! $url !!}">{!! $title !!}</a>  {{-- Don't unescape URLs --}}
```

## Development Workflow

### Setup & Build
```bash
composer install              # Install PHP dependencies (also installs the Local site's plugins, see below)
npm ci                        # Install JS dependencies from the lockfile
npm run dev                   # Vite dev server with HMR
npm run build                 # Production build
```

**IMPORTANT**: Do NOT run `npm run build` during development. This project uses Vite with HMR (Hot Module Reload), so changes to SCSS/JS are automatically compiled and reflected in the browser without building. Only run build commands when explicitly requested by the user.

**After switching branches**, run `npm ci` (and `composer install`) — `node_modules` and `vendor` are not switched with the branch, so a stale install can build with the wrong package versions.

### Composer and WordPress Plugins
- The WordPress plugins in `require-dev` (ACF Pro, Yoast, Gravity Forms, WP Migrate DB Pro, etc.) install into the site's `wp-content/plugins/` folder via `installer-paths`. Running `composer update` updates those plugins on the Local site too, so don't run a full update unless asked.
- Gravity Forms' version is fixed in its package definition in the `repositories` section of `composer.json`.
- `pestphp/pest` and `laravel/pint` are intentionally in `require`, not `require-dev`. Deployments previously failed without them, so don't move them without validating the deploy workflow first.
- Don't add `pestphp/pest-plugin-laravel`: it pulls the full `laravel/framework` into the theme, which conflicts with Acorn and WordPress (e.g. a `Cannot redeclare function __()` fatal error).
- After removing a Composer package that registers a service provider, clear Acorn's cache (`wp acorn optimize:clear`), or the site will 500 looking for the removed provider.

### Testing and Linting
```bash
npm test                      # Run all tests (JS + PHP)
npm run test:js               # Run JavaScript tests with Jest
npm run test:js:watch         # Run Jest in watch mode
npm run test:js:coverage      # Generate coverage report (V8)
composer test                 # Run PHP tests with Pest
composer lint                 # Check PHP formatting with Pint (no changes)
composer lint:fix             # Fix PHP formatting with Pint
npm run lint                  # Check JS (ESLint) and SCSS (stylelint)
npm run lint:fix              # Fix JS and SCSS lint issues
```

Tests and linters run automatically on pull requests into `develop` and `main` via GitHub Actions. The JS and PHP test steps pass when there are no tests.

### Configuration
- Update `vite.config.js` `base` path to match the theme's folder name: `/wp-content/themes/your-theme-name/public/build/`. If it doesn't match the folder the theme is installed in, lazy-loaded module JS and CSS font/image URLs will 404.
- Set `APP_URL` in `.env` to match your site URL (for Local, use the site's development URL)
- ACF fields are programmatically generated via ACF Composer (see below)

### Adding a New Module
1. Create field partial: `app/Fields/Partials/YourModule.php` extending `Partial`
   - Use two-tab structure: `->addTab('content')` for module fields, `->addTab('settings')` for ID/custom_classes/custom_styles
   - **CRITICAL**: Return the FieldsBuilder object directly — DO NOT call `->build()` (the Builder class handles this)
   - Example: `return $yourModule;` NOT `return $yourModule->build();`
2. Register in `app/Fields/Builder.php`: `->addLayout('your_module')->addFields($this->get(YourModule::class))`
3. Create Blade: `resources/views/modules/your-module.blade.php`
   - Conditionally render ID, custom_classes, and custom_styles attributes on root element
   - **CRITICAL**: Any HTML IDs used within a module MUST be unique. Always use the module's `$module->uid` property to create unique IDs (e.g., `id="videoModal-{{ $module->uid }}"`). Multiple instances of the same module may exist on a page, so hardcoded IDs will cause conflicts.
4. Add SCSS: `resources/css/modules/_your-module.scss`
   - Start the file with `@use '../common/tools' as *;` if it uses theme variables, `rem-calc()`, or breakpoint mixins (see **SCSS Module System**)
   - **If module has JS**:
     - Import CSS in the JS file (`import '../../css/modules/_your-module.scss';`) for automatic lazy loading
     - Import third-party CSS in the JS file if needed
     - Do NOT load module CSS in `app.scss`
   - **If module has no JS**:
     - Load it in `app.scss` with `@use 'modules/your-module';`
5. Add JS if needed: `resources/js/modules/your-module.js` (auto-loads when the page builder includes the module, see **JavaScript Module Loading**)
   - Import third-party CSS first (so module styles can override)
   - Import module CSS second
   - Import JS dependencies last
   - Example structure:
     ```javascript
     // Import third-party styles first
     import 'third-party-library/css';

     // Import module styles (can override third-party defaults)
     import '../../css/modules/_your-module.scss';

     // Import JS dependencies
     import ThirdParty from 'third-party-library';
     ```
6. Add tests if needed: `tests/js/modules/your-module.test.js` (see Testing Modules section below)
   - **CRITICAL**: Any module with complex JavaScript (event handlers, DOM manipulation, carousels, video modals, etc.) MUST have tests created

### Testing Modules
**When to create tests**:
- ✅ **REQUIRED**: Module has JavaScript interactivity (DOM manipulation, events, dynamic behavior, video modals, etc.)
- ✅ **Recommended**: Complex data transformation in view composers, Blade components, or custom business logic
- ❌ **Optional**: Simple markup-only modules without JS or complex logic

**JavaScript Tests** (`tests/js/**/*.test.js`):
- Test DOM interactions, event handlers, and dynamic behavior
- Jest runs tests as **native ES modules** (`--experimental-vm-modules`) with **no Babel** — `jest.config.js` sets `transform: {}`. Don't add Babel, `babel-jest`, or a Babel config.
- Import Jest APIs from `@jest/globals` (the `jest` global isn't injected in ES-module mode)
- The test environment is jsdom; shared setup lives in `tests/setup.js`, and stylesheet imports are mocked by `tests/__mocks__/styleMock.js`
- Run with: `npm run test:js` or `npm run test:js:watch`

**PHP Tests** (`tests/Unit/*Test.php` or `tests/Feature/*Test.php`):
- Test view composer logic, Blade components, or data processing with Pest
- Only files ending in `Test.php` are run (`phpunit.xml`)
- Tests run without WordPress. Stub the WordPress functions a class needs in `tests/Stubs/wordpress.php` and control their return values with `$GLOBALS['wp_stubs']` (see `tests/Unit/ResponsiveImageComponentsTest.php`)
- Run with: `composer test`

**Test Structure Example**:
```javascript
import { beforeEach, describe, expect, test } from '@jest/globals';

describe('Your Module', () => {
  beforeEach(() => {
    document.body.innerHTML = `<div class="your-module">...</div>`;
  });

  test('should initialize correctly', () => {
    const module = document.querySelector('.your-module');
    expect(module).toBeTruthy();
  });
});
```

## Project-Specific Conventions

### Naming Conventions
- **ACF Layout Names**: snake_case in PHP (`card_grid`)
- **Blade Files**: kebab-case (`card-grid.blade.php`)
- **Body Classes**: Add `-js` suffix for JS module loading (e.g., `card-grid-js`)
- **CSS Classes**: ALWAYS use kebab-case with dashes only — NEVER use underscores (e.g., `text-left`, `single-full`, NOT `text_left` or `single_full`)
- **CSS Classes**: Use `sage-*` prefix for spacing utilities (e.g., `sage-mb-20`, `sage-py-50`)

### SCSS Module System
The theme's SCSS uses `@use` and `@forward`. **Never use `@import`** — stylelint blocks it outside `resources/css/vendor/`, and Dart Sass 3 will remove it.

- **`common/_tools.scss`** forwards the shared variables (`_variables.scss`), functions (`rem-calc()`, `unitless-calc()`, `strip-unit()`), mixins (`responsive-font`), and Bootstrap's breakpoint mixins (`_breakpoints.scss`, which default to the theme's `$grid-breakpoints`). It outputs **no CSS**, so any partial can load it, including lazy-loaded module styles:
  ```scss
  @use '../common/tools' as *;
  ```
- **`vendor/_bootstrap.scss`** holds the included Bootstrap components and the theme's overrides for Bootstrap's `!default` variables (grid, container widths, `$white`, `$black`). Bootstrap 5 isn't written for Sass modules, so this is the only file that still uses `@import`. To include another Bootstrap component, uncomment it there. If a theme variable shares a name with a Bootstrap variable, pass it through at the top of that file.
- **`vendor/_hamburgers.scss`** configures Hamburgers from the `$hamburger-*` theme variables with `@use ... with (...)`. Only variables that hamburgers 1.2.1 defines can be passed.
- **Bootstrap members** (e.g. `$spacer`, or extending Bootstrap classes) come from `@use '../vendor/bootstrap';` and are namespaced: `bootstrap.$spacer`. Only load it in partials that are part of `app.scss` — it outputs all of Bootstrap's CSS, so never load it in lazy-loaded module styles.
- **`@extend` only reaches modules the file loads.** A partial that extends a selector must `@use` the module where that selector is styled. For example, `components/_forms.scss` loads `vendor/bootstrap`, `common/helper`, and `buttons` because it extends `.btn`, `.row`, and `.mb-3`. Bootstrap's own `.h1`–`.h6`, `.small` and `.mark` extends are repeated at the end of `app.scss` so they also apply to the theme's heading styles.
- **Built-in functions**: use the `sass:` modules — `@use 'sass:math';` for `math.div()`, `@use 'sass:map';` for `map.get()`, etc. — not global functions like `map-get()` or `unit()` (stylelint enforces this). Use `@if`/`@else` instead of the `if()` function.
- **`app.scss`** loads every partial with `@use`, and the order of those rules is the order the CSS is output in.
- **Fonts** are loaded once in `common/_fonts.scss` via `app.scss`. Don't load fonts in module styles.
- `vite.config.js` sets `quietDeps` (hides deprecation warnings from inside npm packages) and silences only the `import` deprecation for the Bootstrap wrapper. Fix new Sass warnings in theme code rather than silencing them.

### Bootstrap Grid Customization
- **24-column grid** instead of default 12 (see `resources/css/common/_variables.scss`)
- Custom breakpoints: `xs(0), sm(768), md(992), lg(1200), xl(1440), xxl(1600)`
- Example: `col-md-20 offset-md-2` centers 20 columns with 2-column margins

### Custom Spacing System
Generated utility classes in `resources/css/common/_helper.scss`:
- `.sage-mb-{0-220}` (margin-bottom in 5px increments)
- `.sage-py-{0-220}` (padding-y in 5px increments)
- `.sage-mt-{0-220}`, `.sage-pt-{0-220}`, etc.

### Color System
Color variables are defined in `resources/css/common/_variables.scss` using **descriptive appearance-based names** — the variable name describes what the color looks like, not an abstract role.

**SCSS Variable Convention**: `$color-{appearance}` (e.g., `$color-dark-blue`, `$color-gold`, `$color-off-white`). White and black follow the same convention (`$color-white`, `$color-black`); `$white` and `$black` are aliases kept for Bootstrap, Hamburgers and existing partials.
**CSS Utility Class Convention**: `.color-{appearance}` (or `.{appearance}-color`) for text color, `.bg-color-{appearance}` for background color, `.border-color-{appearance}` for border color

**Adding a color**: Define the `$color-{appearance}` variable and add it to `$colors-map` with the same name. The utility classes are generated from the map by a loop in `_global.scss` — never write color utility classes by hand.

**Examples**:
```scss
// _variables.scss — Define per project
$color-dark-blue: #1c3665;
$color-gold: #c9a227;

$colors-map: (
  'dark-blue': $color-dark-blue,
  'gold': $color-gold,
);
```
```scss
// _global.scss — generates .color-{name}, .{name}-color, .bg-color-{name} and .border-color-{name}
@each $name, $value in $colors-map { ... }
```
```blade
{{-- Usage in Blade templates --}}
<div class="color-dark-blue">Text</div>
<div class="bg-color-dark-blue border border-color-gold">Background and border</div>
```

The generated classes are safelisted in `postcss.config.js`, so they can be built dynamically (e.g. `bg-color-{{ $module->background_color }}` from an ACF select whose values match the map names).

**Module Rule**: Always use color utility classes in Blade templates — never hardcode hex values in module SCSS.

### Custom Gutter Classes
- `.sage-g-{0-50}` — Custom row gutter classes (in 5px increments: `.sage-g-10`, `.sage-g-20`, `.sage-g-30`, etc.)
- Automatically adds negative margin to row and padding to columns
- Responsive variants: `.sage-g-sm-{size}`, `.sage-g-md-{size}`, `.sage-g-lg-{size}`, `.sage-g-xl-{size}`
- Example: `.sage-g-10` creates 20px gap between columns (10px padding on each side)
- **CRITICAL**: Use these gutter classes instead of manual padding/margin solutions

### Button Styles
Button styles are defined in `resources/css/components/_buttons.scss`. Button classes use standard Bootstrap-style syntax:
- Base button: `.btn.btn-primary` (note: both classes required)
- Add color/style variants as needed per project and document them here

Reference existing button classes when adding buttons to modules. If a module requires a button style that does not exist, add it to the buttons CSS following the conventions there.

### JavaScript Module Loading
Modules auto-load based on body classes:
- The `body_class` filter in `app/filters.php` adds `{module-name}-js` for each page builder module on the page that has a matching `resources/js/modules/{module-name}.js` file
- `resources/js/app.js` reads the `-js` body classes and dynamically imports the matching module via `import.meta.glob`
- Example: a page with an Accordion module gets the `accordion-js` body class, which loads `resources/js/modules/accordion.js`
- To load module JS on a template that isn't built with the page builder (e.g. a custom post type single), add the `-js` body class for it in the `body_class` filter
- **CRITICAL**: The `-js` class suffix is dynamically added to the `<body>` element, NOT to the module's wrapper div. Never add module JS classes to the module template itself.

### Slider / Carousel Library
**This project uses [Splide](https://splidejs.com/) for all carousels and sliders** — NOT Swiper.

Splide was chosen for its lower bug surface and fewer conflicts with Bootstrap. Use it for all new slider/carousel modules.

```javascript
// Import Splide styles first
import '@splidejs/splide/css';

// Import module styles
import '../../css/modules/_your-carousel.scss';

// Import Splide
import Splide from '@splidejs/splide';

document.querySelectorAll('.splide').forEach(el => {
  new Splide(el, {
    type: 'loop',
    perPage: 1,
  }).mount();
});
```

### ACF Composer Configuration
All ACF fields are **programmatically defined** using ACF Composer (no GUI field exports):

**Field Organization**:
- `app/Fields/Builder.php` — Flexible content layouts for page builder modules
- `app/Fields/Headers.php` — Page header configurations
- `app/Fields/PostSettings.php` — Post-specific field groups
- `app/Fields/Partials/` — Reusable field partials (one per module)
- `app/Options/ThemeSettings.php` — Theme options page
- `config/acf.php` — Default field type settings (UI preferences, return formats, layouts)

**How it works**:
1. Partials extend `Log1x\AcfComposer\Partial` and define field schemas using `FieldsBuilder`
2. `Builder.php` imports partials and registers them as flexible content layouts: `->addLayout('card_grid')->addFields($this->get(CardGrid::class))`
3. Default field behaviors set in `config/acf.php` (e.g., all images return IDs, trueFalse fields use UI toggle)
4. ACF Composer auto-registers these on theme boot — no JSON sync files needed

**CRITICAL: Never add default field configurations**:
- DO NOT add `'return_format' => 'id'` to image/gallery fields — this is already the default in `config/acf.php`
- Only add configuration options that differ from defaults
- Check `config/acf.php` before adding field options

**CRITICAL: Message field syntax**:
- The correct syntax for addMessage is: `->addMessage('field_name', 'message', ['label' => 'Label Text', 'message' => 'Message content'])`
- The second parameter must be the string `'message'`
- Both label and message content go inside the config array
- Incorrect syntax will silently break ALL flexible content layouts from appearing in the page builder

**Standard Module Structure** (All page builder modules follow this pattern):
All ACF field partials use a two-tab structure:
1. **Content Tab** (`->addTab('content')`) — Module-specific fields like title, copy, images, repeaters
2. **Settings Tab** (`->addTab('settings')`) — Standard fields plus optional custom settings:
   - `ID` — HTML ID attribute for anchor links
   - `custom_classes` — Additional CSS classes
   - `custom_styles` — Inline CSS styles
   - Optional: Module-specific settings (e.g., layout options, column configurations)

Example from `Text.php`:
```php
$text
    ->addTab('content')
        ->addText('title')
        ->addWysiwyg('copy')
    ->addTab('settings')
        ->addSelect('columns', [...]) // Optional module-specific setting
        ->addText('ID')
        ->addText('custom_classes')
        ->addText('custom_styles');
```

**Blade View Implementation**:
Module views conditionally render ID, classes, and styles from settings:
```blade
<div {{ $module->ID ? 'id="'.$module->ID.'"' : ''}}
     class="container-fluid module-name {{ $module->custom_classes ? $module->custom_classes : 'default-spacing-classes' }}"
     {{ $module->custom_styles ? 'style="'.$module->custom_styles.'"' : '' }}>
```

**CRITICAL: Conditional Spacing Pattern**:
Default margin/padding utilities should only apply when `custom_classes` is empty:
```blade
{{-- CORRECT - Default spacing only when custom_classes is empty --}}
class="module-name {{ $module->custom_classes ? $module->custom_classes : 'sage-py-100 sage-my-50' }}"

{{-- WRONG - Default spacing always applies, conflicts with custom_classes --}}
class="module-name sage-py-100 sage-my-50 {{ $module->custom_classes }}"
```
This ensures users can fully override module spacing without fighting default classes.

**Adding Fields to a Module**:
- Edit the corresponding partial in `app/Fields/Partials/YourModule.php`
- Use chaining methods: `->addText('title')`, `->addImage('background')`
- Always maintain content/settings tab structure
- Fields are immediately available — no export/import step

### Module Documentation
All page builder modules must be documented. See `.github/MODULE-DOCUMENTATION-GUIDE.md` for the complete process. When adding a new module, complete ALL four steps:

1. **Developer docs** (`docs/MODULE-NAME.md`) — Technical reference for developers
2. **In-module help message** (ACF partial content tab) — Brief help for content editors
3. **Help tab** (ACF partial settings tab) — Detailed usage guide and best practices
4. **Admin docs** (`app/admin-docs.php`) — Centralized admin documentation page entry

Use the `ModuleDocumentation` trait (`app/Fields/Traits/ModuleDocumentation.php`) in all field partials to generate consistent help messages and help tabs.

### Custom Post Types

**Pattern for adding Custom Post Types**:
1. Register in `config/post-types.php` (create it if it doesn't exist yet) using `roots/acorn-post-types` (Extended CPTs)
2. Create ACF field group in `app/Fields/{PostType}Settings.php` extending `Field`
3. For archives: Create `archive-{post-type}.blade.php` template
4. For components: Create class-based component in `app/View/Components/` that fetches its own data
5. Add admin columns and sorting in `app/filters.php`
6. Configure archive header fields in `app/Options/ThemeSettings.php`

### ACF Data Integration
- **Field returns**: Images use `'return_format' => 'id'` by default (process with `<x-acf-image>` component)
- **Page Builder**: Processed in `app/View/Composers/PageBuilder.php`, accessed as `$page_builder` in Blade
- **Layout rendering**: `resources/views/partials/page-builder.blade.php` loops modules and includes corresponding Blade files
- **Module data access**: In Blade, access fields via `$module->field_name` (e.g., `$module->title`, `$module->cards`)
- **View Composers**: All data processing, queries, and logic must be handled in View Composers, NOT in Blade templates
- **Blade Template Rule**: Blade templates should only handle presentation/markup — no PHP logic blocks, variable assignments, or function calls for data retrieval

**CRITICAL: Composer data and `override()`**:
- Acorn only exposes a composer's public methods to its views automatically when `with()` and `override()` both return nothing.
- If a composer returns data from `with()` or `override()`, every variable the view needs must be in that array. To pass a method that the view both calls and echoes (like `$pagination()` / `{!! $pagination !!}`), use `$this->createInvokableVariable('methodName')` (see `app/View/Composers/Post.php`).

**CRITICAL: Keep PageBuilder Composer Clean**:
- The `PageBuilder.php` composer should remain minimal — it only loops through modules and creates objects
- **Complex module logic MUST be in dedicated module composers** (e.g., `VideoSection.php`)
- Each module composer targets its specific Blade view: `protected static $views = ['modules.your-module']`
- Module composers receive `$module` data via `$this->data->get('module')` and process/transform it
- Return processed data as new variables

**Example — Dedicated Module Composer**:
```php
// app/View/Composers/YourModule.php
namespace App\View\Composers;
use Roots\Acorn\View\Composer;

class YourModule extends Composer
{
    protected static $views = ['modules.your-module'];

    public function with()
    {
        $module = $this->data->get('module');
        return [
            'sorted_items' => $this->sortItemsAlphabetically($module->items),
        ];
    }

    protected function sortItemsAlphabetically($items)
    {
        usort($items, fn($a, $b) => strcasecmp($a['name'], $b['name']));
        return $items;
    }
}
```

**When to Create a Dedicated Module Composer**:
- ✅ Module needs data transformation, sorting, or filtering
- ✅ Module queries posts/custom post types
- ✅ Module has conditional logic for data display
- ✅ Module processes repeater fields or complex ACF structures
- ❌ Module only displays static fields without processing (simple text, images)

**Example — Clean Blade Template**:
```blade
{{-- Good: Data already processed by composer --}}
@if ($module->testimonials)
  @foreach ($module->testimonials as $testimonial)
    <p>{{ $testimonial->post_title }}</p>
  @endforeach
@endif

{{-- Bad: Logic in template --}}
@php
  $testimonials = get_posts(['post_type' => 'testimonial']);
@endphp
```

### Responsive Images
- `<x-acf-image :image-id="$id" size="full" srcset-sizes="100vw"/>` for ACF image IDs, and `<x-featured-image :image-id="$post_id" srcset-sizes="100vw"/>` for a post's featured image. Both render `resources/views/components/responsive-image.blade.php`.
- `srcset-sizes` sets the `sizes` attribute (default `100vw`); it's only output when the image has a `srcset`. Pass a narrower value for images that don't span the viewport (e.g. `(min-width: 992px) 50vw, 100vw`).
- Both components must accept a `$srcsetSizes` constructor parameter and declare a public `$sizes` property — `tests/Unit/ResponsiveImageComponentsTest.php` checks this.

### Asset References
**In Blade templates**: Use `Vite::asset()` method for images and static assets:
```blade
<img src="{{ Vite::asset('resources/images/example.svg') }}">
```

**In CSS/SCSS**: Use `@images` alias for image paths:
```scss
background-image: url("@images/example.svg");
```

**In PHP**: Use Vite facade:
```php
use Illuminate\Support\Facades\Vite;
$asset = Vite::asset('resources/images/example.svg');
```

Images and fonts in `resources/images/` and `resources/fonts/` are included in the build through the `assets` option in `vite.config.js`.

### Styling Guidelines
**CRITICAL: Always use utility classes in Blade templates — NEVER write these styles in SCSS files:**

**Bootstrap Utilities** (Always use these in Blade, not SCSS):
- **Position**: `.position-relative`, `.position-absolute`, `.position-fixed`, `.position-sticky`
- **Display**: `.d-block`, `.d-flex`, `.d-inline`, `.d-inline-block`, `.d-none`, `.d-grid`
- **Flexbox**: `.justify-content-start`, `.justify-content-center`, `.justify-content-end`, `.justify-content-between`, `.align-items-start`, `.align-items-center`, `.align-items-end`
- **Text**: `.text-start`, `.text-center`, `.text-end`, `.text-white`, `.text-muted`, `.fw-bold`, `.fw-normal`, `.fst-italic`
- **Size**: `.w-100`, `.h-100`, `.h-auto`, `.mw-100`, `.mh-100`
- **Border**: `.border`, `.border-0`, `.border-top`, `.border-bottom`, `.rounded`, `.rounded-0`, `.rounded-circle`
- **Background**: `.bg-transparent`, `.bg-white`, `.bg-dark`
- **Overflow**: `.overflow-hidden`, `.overflow-auto`, `.overflow-scroll`
- **Gap**: `.gap-1`, `.gap-2`, `.gap-3`, `.gap-4`, `.gap-5`
- **Margin/Padding**: `.m-0`, `.p-0`, `.mb-0`, `.mt-3`, `.px-4`, etc.

**Sage Spacing Utilities** (Always use these in Blade, not SCSS):
- `.sage-mb-{0-220}` (margin-bottom), `.sage-mt-{0-220}` (margin-top)
- `.sage-py-{0-220}` (padding-y), `.sage-px-{0-220}` (padding-x)
- `.sage-pt-{0-220}`, `.sage-pb-{0-220}`, `.sage-pl-{0-220}`, `.sage-pr-{0-220}`
- Values are in 5px increments (e.g., `.sage-mb-30` = 30px margin-bottom)
- Responsive variants: `.sage-mb-md-40`, `.sage-py-lg-60`, etc.

**Color Utilities** (Generated from `$colors-map`, always use as classes in Blade, not SCSS):
- `.color-{appearance}` or `.{appearance}-color` for text color (e.g., `.color-dark-blue`, `.color-gold`)
- `.bg-color-{appearance}` for background color (e.g., `.bg-color-dark-blue`, `.bg-color-off-white`)
- `.border-color-{appearance}` for border color (combine with Bootstrap's `.border` utilities)
- **Module Rule**: Always use color utility classes in Blade templates; never hardcode hex values

**Typography Utilities** (Always use these in Blade, not SCSS):
- `.sage-h1`, `.sage-h2`, `.sage-h3`, `.sage-h4`
- `.sage-p`, `.sage-p2`, `.sage-p3`
- `.fw-bold`, `.fw-normal`, `.fst-italic`
- `.sage-ls-30`, `.sage-ls-60`, `.sage-ls-100` (letter-spacing utilities)
- **CRITICAL**: Modules should NEVER use `<h2>` tags for titles. Always use `<h3>` tags to ensure proper SEO hierarchy, then apply the appropriate typography utility class (e.g., `<h3 class="sage-h2">`) to style them correctly.
- **CRITICAL**: Do NOT add redundant utility classes when the HTML tag matches the desired style. Use `<h3>` alone (not `<h3 class="sage-h3">`). Only add typography utility classes when you need different styling than the element's default (e.g., `<h3 class="sage-h2">` to make an h3 look like an h2).

**Custom Gutter Classes** (Always use these for grid gaps, not SCSS):
- `.sage-g-{0-50}` — Custom row gutter classes (in 5px increments)
- Automatically adds negative margin to row and padding to columns
- Responsive variants: `.sage-g-sm-{size}`, `.sage-g-md-{size}`, `.sage-g-lg-{size}`, `.sage-g-xl-{size}`
- **CRITICAL**: Use these gutter classes instead of manual padding/margin solutions

**Grid & Layout**:
- Bootstrap 24-column grid: `col-24`, `col-md-12`, `col-lg-8`, `offset-md-2`, etc.
- Use `container` and `container-fluid` classes for layout structure

**WHAT BELONGS IN MODULE SCSS FILES**:
Module SCSS files should contain ONLY:
- Custom gradients, shadows, and complex backgrounds
- Transform, transition, and animation properties
- Z-index values (when not standard Bootstrap utilities)
- Pseudo-elements (`::before`, `::after`) with unique content/styling
- Complex positioning calculations (top, right, bottom, left with specific values)
- Width/height values that aren't 100% or auto
- Module-specific structural styles that don't have utility class equivalents
- Opacity values (when not 0 or 1)
- Custom media query breakpoint logic

**SCSS Nesting Convention**:
- **Use nested classes, NOT BEM notation** (e.g., `.module-name { .element { } }`, not `.module-name__element`)
- Classes should be nested under the parent module class for proper scoping

**Responsive Breakpoints**:
- **CRITICAL: NEVER use raw @media queries** — Always use the breakpoint mixins from `common/tools`
- Use `@include media-breakpoint-up(breakpoint)` for min-width queries
- Use `@include media-breakpoint-down(breakpoint)` for max-width queries
- Use `@include media-breakpoint-between(lower, upper)` for range queries
- Use `@include media-breakpoint-only(breakpoint)` for a single breakpoint range
- Available breakpoints: `xs`, `sm`, `md`, `lg`, `xl`, `xxl`
- Example: `@include media-breakpoint-down(md)` NOT `@media (width <= 991px)`

**Clean Markup Rule**:
- Avoid creating elements solely for visual presentation — apply styles directly to the module wrapper or existing semantic elements
- Use pseudo-elements (`::before`, `::after`) for decorative elements instead of extra divs
- Keep markup as clean and minimal as possible

**Module SCSS Example** (What's allowed):
```scss
@use '../common/tools' as *;

.my-module {
  background: linear-gradient(90deg, #b88508 0%, #fdde92 100%);

  &::after {
    content: '';
    width: rem-calc(633px);
    height: rem-calc(747px);
    opacity: 0.3;
    background-image: url("@images/pattern.svg");
  }

  .slider-card {
    background: rgba($white, 0.8);
    transition: transform 0.3s ease;

    &:hover {
      transform: translateY(-5px);
    }
  }
}
```

**Module SCSS Anti-Example** (NEVER do this):
```scss
// ❌ WRONG — Use utility classes in Blade instead
.my-module {
  position: relative;           // Use .position-relative
  display: flex;                // Use .d-flex
  justify-content: center;      // Use .justify-content-center
  padding: rem-calc(40px);      // Use .sage-p-40
  margin-bottom: rem-calc(20px);// Use .sage-mb-20
  color: $color-dark-blue;      // Use .color-dark-blue
  font-weight: 700;             // Use .fw-bold
  text-align: center;           // Use .text-center
  border: 0;                    // Use .border-0
  overflow: hidden;             // Use .overflow-hidden
  background: transparent;      // Use .bg-transparent
}
```

**CRITICAL SCSS Rules**:
1. **NEVER use raw @media queries** — Always use the breakpoint mixins (`@include media-breakpoint-down(md)`)
2. **NEVER add CSS properties that have utility class equivalents** — Check the utility classes list first
3. **NEVER re-add CSS that has been removed** — If CSS is removed, assume it was intentional unless explicitly told otherwise
4. **NEVER use manual padding/margin for grid gaps** — Use `.sage-g-{size}` custom gutter classes instead
5. **NEVER add unnecessary default values** — Don't add `height: auto` or similar defaults
6. **ALWAYS check existing project utilities** — The project has extensive utility classes and custom helpers
7. **NEVER use `@import`** — Use `@use`/`@forward` (see **SCSS Module System**)

**Line Height**: Always express as a unitless decimal value calculated by dividing the pixel line-height by the pixel font-size. For example: if line-height is 81px and font-size is 64px, use `line-height: 1.265625;` (81 ÷ 64)

**Font Sizing**:
- Use `rem-calc()` function for responsive sizing: `font-size: rem-calc(20px);`
- **CRITICAL**: When using `rem-calc()` for multi-value properties, pass all values inside the function: `padding: rem-calc(30px 40px 10px 0);` NOT `padding: rem-calc(30px) rem-calc(40px) rem-calc(10px) 0;`
- Prefer global `.sage-p`, `h2`, etc. classes over custom sizes

### PostCSS & PurgeCSS
- PurgeCSS runs on production builds only and scans: `app/**/*.php`, `resources/views/**/*.php`, `resources/js/**/*.js`
- Safelist in `postcss.config.js`: WordPress classes, FontAwesome, Fancybox, Splide, Hamburgers, and the generated color utilities
- Add dynamic classes to safelist if they're being stripped incorrectly

## Key Integration Points

- **WordPress → Acorn**: `functions.php` boots Acorn container with `ThemeServiceProvider`
- **Acorn → Views**: Service provider registers view composers and components
- **Views → ACF**: Composers fetch ACF data, Blade templates render with `$module->field_name`
- **Vite → WordPress**: Laravel Vite plugin generates manifest, Sage helpers inject assets
- **Body Classes → JS**: Dynamic module loading based on WordPress body classes

## Critical Files

- `app/Fields/Builder.php` — ACF flexible content registration
- `app/View/Composers/PageBuilder.php` — Processes ACF data for templates
- `resources/views/partials/page-builder.blade.php` — Main module loop
- `app/setup.php` — Theme supports, menus, sidebars, and block editor removal
- `app/filters.php` — Body classes for module JS loading, admin customizations
- `resources/css/app.scss` — Loads all stylesheets with `@use`, in output order
- `resources/css/common/_tools.scss` — Shared SCSS variables, functions, and mixins
- `resources/css/common/_variables.scss` — Grid system and colors
- `resources/css/vendor/_bootstrap.scss` — Included Bootstrap components and overrides
- `vite.config.js` — Build configuration (update `base` path per project)
- `postcss.config.js` — PurgeCSS safelist (add dynamic classes here)

## Deployment

### WPEngine Deployment via GitHub Actions
The theme deploys automatically to WPEngine when code is pushed to `main` (production) or `develop` (staging). Pull requests labelled `deploy-dev` deploy to the dev environment, and any environment can be deployed manually from the Actions tab (`workflow_dispatch`).

**Deployment Process**:
1. Push/merge to `main` or `develop` (or a `deploy-dev` label, or a manual run) triggers the GitHub Actions workflow
2. Workflow builds assets (`npm run build`) and installs production Composer dependencies
3. Deploys theme via rsync to the configured WPEngine environment. Development files (`.github/`, `tests/`, `CLAUDE.md`, `.claude/`, lint configs, etc.) are excluded.
4. Runs `.github/scripts/post-deploy.sh` to activate theme (if needed) and rebuild Acorn caches

**Per-Project Setup** (set once in GitHub → Settings, no workflow file edits needed):

GitHub → Settings → **Secrets and variables → Actions → Variables**:
| Variable | Example | Description |
|---|---|---|
| `THEME_SLUG` | `my-client-theme` | Folder name of the theme on WPEngine |
| `WPE_ENV_PRODUCTION` | `myclientprod` | WPEngine install name for production |
| `WPE_ENV_STAGING` | `myclientstg` | WPEngine install name for staging |
| `WPE_ENV_DEV` | `myclientdev` | WPEngine install name for dev |

GitHub → Settings → **Secrets and variables → Actions → Secrets**:
| Secret | Description |
|---|---|
| `WPE_SSHG_KEY_PRIVATE` | SSH private key for WPEngine Git Push access |

**Generating the SSH Key**:
1. Generate a key pair: `ssh-keygen -t rsa -b 4096 -C "deploy@github-actions"`
2. Add the **public key** to WPEngine portal → SSH Keys
3. Add the **private key** as the `WPE_SSHG_KEY_PRIVATE` secret in GitHub

**Also update in `vite.config.js`**:
- Set the `base` path to match the theme slug: `/wp-content/themes/my-client-theme/public/build/`

**Post-Deployment** (automated via `post-deploy.sh`):
- Activates the theme if not already active
- Purges Varnish cache
- Runs `wp acorn optimize:clear` and `wp acorn view:cache`

**Build Steps** (automated in workflow):
```bash
npm ci --include=optional                         # Install dependencies (plus a check for Rolldown's Linux binary)
composer install --no-dev --optimize-autoloader  # Production dependencies
npm run build                                    # Build assets
```

## Documentation

- **[Roots Sage Documentation](https://roots.io/sage/docs/installation/)** — Complete guide for the Sage base theme including installation, file structure, and best practices
- **[Acorn Documentation](https://roots.io/acorn/docs/)** — View composers, Blade components, and upgrade guides
- **Module Documentation Guide**: `.github/MODULE-DOCUMENTATION-GUIDE.md` — Complete process for documenting page builder modules

## External Dependencies

- **Roots Acorn 6** (WordPress/Laravel bridge)
- **ACF Composer** (log1x/acf-composer) — Programmatic field definitions
- **Blade Font Awesome** (owenvoke/blade-fontawesome 3, Font Awesome 7) — Icon components such as `<x-fab-facebook-f/>`
- **Frontend Libraries**: Bootstrap 5.3 (wrapped in `resources/css/vendor/_bootstrap.scss`), Fancybox, Splide, Hamburgers, Headroom.js
- **Bootstrap Nav Walker**: `app/BootstrapNav.php` for WordPress menus
