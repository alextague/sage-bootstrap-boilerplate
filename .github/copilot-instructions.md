# Sage Vite with Bootstrap Boilerplate — WordPress Theme

This is a **Roots Sage 11** WordPress theme using Laravel Acorn, Blade templating, Vite, Bootstrap 5, and ACF (Advanced Custom Fields) for page building.

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
5. **NO BATCH FORMATTING** — Never run code formatters, linters, or make style consistency changes across multiple files without explicit instruction

**Example of WRONG behavior**: Working on a module and editing 50+ unrelated PHP files to "fix formatting"
**Example of RIGHT behavior**: Working on a module and ONLY editing that module's files

This is not optional — unauthorized edits create merge conflicts, complicate code reviews, and waste the user's time.

## Architecture

### Core Stack
- **PHP Framework**: Laravel components via Roots Acorn (IoC container, service providers, Blade views)
- **Templating**: Laravel Blade (`.blade.php` files in `resources/views/`)
- **Page Builder**: ACF Flexible Content with modular layouts
- **Styles**: SCSS with Bootstrap 5 (custom 24-column grid)
- **Build Tool**: Vite with Laravel plugin and hot module reload
- **JavaScript**: ES modules with dynamic imports for module-specific code

### File Structure Patterns

**ACF Module System** (Critical):
1. PHP field definition: `app/Fields/Partials/CardGrid.php` (using ACF Composer)
2. PHP field registration: `app/Fields/Builder.php` adds layout with `->addLayout('card_grid')`
3. Blade template: `resources/views/modules/card-grid.blade.php` (underscores → dashes)
4. SCSS: `resources/css/modules/_card-grid.scss` (imported in `app.scss` or via JS file)
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
composer install              # Install PHP dependencies
npm install                   # Install JS dependencies
npm run dev                   # Vite dev server with HMR
npm run build                 # Production build
```

**IMPORTANT**: Do NOT run `npm run build` during development. This project uses Vite with HMR (Hot Module Reload), so changes to SCSS/JS are automatically compiled and reflected in the browser without building. Only run build commands when explicitly requested by the user.

### Testing
```bash
npm test                      # Run all tests (JS + PHP)
npm run test:js               # Run JavaScript tests with Jest
npm run test:js:watch         # Run Jest in watch mode
npm run test:js:coverage      # Generate coverage report
composer test                 # Run PHP tests with Pest
composer lint                 # Run PHP linter (Pint)
npm run lint                  # Run JS/CSS linters
```

Tests run automatically on pull requests via GitHub Actions.

### Configuration
- Update `vite.config.js` `base` path to match your theme's public/build folder path (e.g., `/app/themes/your-theme-name/public/build/`)
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
   - **If module has JS**:
     - Import CSS in the JS file (`import '../../css/modules/_your-module.scss';`) for automatic lazy loading
     - Import third-party CSS in the JS file if needed
     - Add `@import "../common/shared";` at the top of the SCSS file to access Bootstrap mixins, variables, and functions
     - Do NOT import module CSS in `app.scss`
   - **If module has no JS**:
     - Import in `app.scss` (`@import "modules/your-module";`)
5. Add JS if needed: `resources/js/modules/your-module.js` (auto-loads when body has `your-module-js` class)
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
- ✅ **Recommended**: Complex data transformation in view composers or custom business logic
- ❌ **Optional**: Simple markup-only modules without JS or complex logic

**JavaScript Tests** (`tests/js/modules/your-module.test.js`):
- Test DOM interactions, event handlers, and dynamic behavior
- Use Jest framework with DOM testing utilities
- Run with: `npm run test:js` or `npm run test:js:watch`

**PHP Tests** (`tests/Unit/` or `tests/Feature/`):
- Test ACF field validation, view composer logic, or data processing
- Use Pest framework
- Run with: `composer test`

**Test Structure Example**:
```javascript
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

**SCSS Variable Convention**: `$color-{appearance}` (e.g., `$color-dark-blue`, `$color-gold`, `$color-off-white`)
**CSS Utility Class Convention**: `.color-{appearance}` for text color, `.bg-color-{appearance}` for background color

**Examples**:
```scss
// _variables.scss — Define per project
$color-dark-blue: #1c3665;
$color-blue: #2699fb;
$color-gold: #c9a227;
$color-off-white: #f8f6f2;
```
```scss
// _global.scss — Generate utility classes
.color-dark-blue { color: $color-dark-blue; }
.bg-color-dark-blue { background-color: $color-dark-blue; }
```
```blade
{{-- Usage in Blade templates --}}
<div class="color-dark-blue">Text</div>
<div class="bg-color-dark-blue">Background</div>
```

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
- Body class `card-grid-js` → loads `resources/js/modules/card-grid.js`
- Single post types: `single-team` body class → loads `single-team.js`
- Module JS files use dynamic imports via `import.meta.glob`
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
1. Register in `config/post-types.php` with Extended CPTs library
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

**Color Utilities** (Defined per project in `_global.scss`, always use as classes in Blade, not SCSS):
- `.color-{appearance}` for text color (e.g., `.color-dark-blue`, `.color-gold`)
- `.bg-color-{appearance}` for background color (e.g., `.bg-color-dark-blue`, `.bg-color-off-white`)
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
- **CRITICAL: NEVER use raw @media queries** — Always use Bootstrap mixins
- Use `@include media-breakpoint-up(breakpoint)` for min-width queries
- Use `@include media-breakpoint-down(breakpoint)` for max-width queries
- Use `@include media-breakpoint-between(lower, upper)` for range queries
- Available breakpoints: `xs`, `sm`, `md`, `lg`, `xl`, `xxl`
- Example: `@include media-breakpoint-down(md)` NOT `@media (width <= 991px)`

**Clean Markup Rule**:
- Avoid creating elements solely for visual presentation — apply styles directly to the module wrapper or existing semantic elements
- Use pseudo-elements (`::before`, `::after`) for decorative elements instead of extra divs
- Keep markup as clean and minimal as possible

**Module SCSS Example** (What's allowed):
```scss
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
1. **NEVER use raw @media queries** — Always use Bootstrap mixins (`@include media-breakpoint-down(md)`)
2. **NEVER add CSS properties that have utility class equivalents** — Check the utility classes list first
3. **NEVER re-add CSS that has been removed** — If CSS is removed, assume it was intentional unless explicitly told otherwise
4. **NEVER use manual padding/margin for grid gaps** — Use `.sage-g-{size}` custom gutter classes instead
5. **NEVER add unnecessary default values** — Don't add `height: auto` or similar defaults
6. **ALWAYS check existing project utilities** — The project has extensive utility classes and custom helpers

**Line Height**: Always express as a unitless decimal value calculated by dividing the pixel line-height by the pixel font-size. For example: if line-height is 81px and font-size is 64px, use `line-height: 1.265625;` (81 ÷ 64)

**Font Sizing**:
- Use `rem-calc()` function for responsive sizing: `font-size: rem-calc(20px);`
- **CRITICAL**: When using `rem-calc()` for multi-value properties, pass all values inside the function: `padding: rem-calc(30px 40px 10px 0);` NOT `padding: rem-calc(30px) rem-calc(40px) rem-calc(10px) 0;`
- Prefer global `.sage-p`, `h2`, etc. classes over custom sizes

### PostCSS & PurgeCSS
- PurgeCSS scans: `app/**/*.php`, `resources/views/**/*.php`, `resources/js/**/*.js`
- Safelist in `postcss.config.js`: WordPress classes, FontAwesome, Fancybox, Splide, Hamburgers
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
- `resources/css/common/_variables.scss` — Grid system and colors
- `vite.config.js` — Build configuration (update `base` path per project)
- `postcss.config.js` — PurgeCSS safelist (add dynamic classes here)

## Deployment

### WPEngine Deployment via GitHub Actions
The theme deploys automatically to WPEngine when code is pushed to `main` (production) or `develop` (staging).

**Deployment Process**:
1. Push/merge to `main` or `develop` triggers the GitHub Actions workflow
2. Workflow builds assets (`npm run build`) and installs production Composer dependencies
3. Deploys theme via rsync to the configured WPEngine environment
4. Runs `post-deploy.sh` to activate theme (if needed) and rebuild Acorn caches

**Per-Project Setup** (set once in GitHub → Settings, no workflow file edits needed):

GitHub → Settings → **Secrets and variables → Actions → Variables**:
| Variable | Example | Description |
|---|---|---|
| `THEME_SLUG` | `my-client-theme` | Folder name of the theme on WPEngine |
| `WPE_ENV_PRODUCTION` | `myclientprod` | WPEngine install name for production |
| `WPE_ENV_STAGING` | `myclientstg` | WPEngine install name for staging |

GitHub → Settings → **Secrets and variables → Actions → Secrets**:
| Secret | Description |
|---|---|
| `WPE_SSHG_KEY_PRIVATE` | SSH private key for WPEngine Git Push access |

**Generating the SSH Key**:
1. Generate a key pair: `ssh-keygen -t rsa -b 4096 -C "deploy@github-actions"`
2. Add the **public key** to WPEngine portal → SSH Keys
3. Add the **private key** as the `WPE_SSHG_KEY_PRIVATE` secret in GitHub

**Also update in `vite.config.js`**:
- Set the `base` path to match the theme slug: `/app/themes/my-client-theme/public/build/`

**Post-Deployment** (automated via `post-deploy.sh`):
- Activates the theme if not already active
- Purges Varnish cache
- Runs `wp acorn optimize:clear` and `wp acorn view:cache`

**Build Steps** (automated in workflow):
```bash
npm ci                                            # Install dependencies
composer install --no-dev --optimize-autoloader  # Production dependencies
npm run build                                    # Build assets
```

## Documentation

- **[Roots Sage Documentation](https://roots.io/sage/docs/installation/)** — Complete guide for the Sage base theme including installation, file structure, and best practices
- **Module Documentation Guide**: `.github/MODULE-DOCUMENTATION-GUIDE.md` — Complete process for documenting page builder modules

## External Dependencies

- **Roots Acorn** (WordPress/Laravel bridge)
- **ACF Composer** (log1x/acf-composer) — Programmatic field definitions
- **Frontend Libraries**: Bootstrap 5, Fancybox, Splide, Hamburgers
- **Bootstrap Nav Walker**: `app/BootstrapNav.php` for WordPress menus
