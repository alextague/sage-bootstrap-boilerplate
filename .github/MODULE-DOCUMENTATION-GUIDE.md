# Module Documentation Guide

This guide outlines the complete process for documenting page builder modules. **ALL documentation must be created** when adding a new module or when requested to document an existing module.

## Complete Documentation Checklist

When asked to create "all the documentation" for a module, complete ALL four steps:

- [ ] **Step 1**: Create developer documentation (`docs/MODULE-NAME.md`)
- [ ] **Step 2**: Add in-module help message (ACF partial)
- [ ] **Step 3**: Add help tab (ACF partial)
- [ ] **Step 4**: Add to centralized admin documentation (`app/admin-docs.php`) **in alphabetical order**

## ⚠️ CRITICAL: Alphabetical Ordering

When adding modules to `app/admin-docs.php`:

1. **ALWAYS verify alphabetical order** before inserting
2. Use the module's **display name** for sorting (not slug)
3. Common mistake: Adding at the top/bottom instead of correct alphabetical position
4. Double-check: Compare first few letters carefully

**Example Order:**
- Accordion (Ac...)
- Animated Numbers (An...)
- Carousel (Ca...)
- CTA Banner (CT...)
- Icon Grid (Ic...)
- Image Text 50/50 (Im...)
- Text (Te...)
- Video Section (Vi...)

## Step 1: Developer Documentation

**File**: `docs/MODULE-NAME.md` (use UPPERCASE with dashes)

**Structure** (complete sections as applicable):

```markdown
# Module Name

## Overview
Brief description of what the module does and its purpose.

## Features
- Bullet list of key features
- Technical capabilities
- Unique selling points

## Module Structure

### Files Created
List all files with brief descriptions:
1. **ACF Field Partial**: `app/Fields/Partials/ModuleName.php`
2. **Blade Template**: `resources/views/modules/module-name.blade.php`
3. **JavaScript Module**: `resources/js/modules/module-name.js` (if applicable)
4. **SCSS Styles**: `resources/css/modules/_module-name.scss`
5. **Tests**: `tests/js/modules/module-name.test.js` (if applicable)

### Files Modified
- `app/Fields/Builder.php` - Registered the `module_name` layout
- Other files modified during implementation

## ACF Field Structure

### Content Tab
List all fields with types, requirements, and descriptions

### Settings Tab
- **HTML ID** (Text) - Optional ID attribute
- **Custom CSS Classes** (Text) - Additional CSS classes
- **Custom Inline Styles** (Text) - Inline styles
- (Include any module-specific settings)

## How It Works

### Data Flow
Explain the flow from ACF → Blade → JS/CSS

### [Key Technical Concepts]
Add sections for important technical details:
- Number formatting logic
- Animation behavior
- Data processing
- API integrations
- etc.

## Styling Details

Document CSS structure and key styles:
- Background/colors used
- Typography classes
- Grid layout/responsive behavior
- Important visual details

## JavaScript Integration (if applicable)

### Module Loading
Explain how JS is loaded and initialized

### Key Functions
Document important JavaScript functions and their behavior

## Usage Instructions

### Adding the Module to a Page
Step-by-step instructions for content editors

### [Feature-Specific Instructions]
Document how to use specific features

### Best Practices
Dos and don'ts for using the module effectively

## Testing (if applicable)

### Test File
Path to test file

### Test Coverage
What is tested

### Running Tests
```bash
npm run test:js
```

## Performance Considerations
Document performance optimizations or considerations

## Common Customizations
Examples of common customization needs

## Troubleshooting
Common issues and solutions

## Design Reference
Link to Figma or describe design source

## Related Modules
List similar or related modules

## Browser Compatibility
Note any browser-specific requirements or considerations

## Future Enhancements
Possible future additions or improvements
```

## Step 2: In-Module Help Message

**File**: `app/Fields/Partials/ModuleName.php`

**Location**: Top of the Content tab (first field after `->addTab('content')`)

**Pattern**:
```php
use App\Fields\Traits\ModuleDocumentation;

class ModuleName extends Partial
{
    use ModuleDocumentation;

    public function fields()
    {
        $moduleName = FieldsBuilder::make('module_name');

        $moduleName
            ->addTab('content')
                ->addFields($this->addModuleHelp(
                    'Module Name',
                    'Brief one-sentence description of what the module does.',
                    'When to use this module (1-2 sentences).',
                    'How to use it (1-2 sentences with key instructions).'
                ))
                // ... rest of content fields
```

**Parameters**:
1. **Name** - Display name of the module
2. **Description** - One sentence explaining what it does
3. **When to Use** - 1-2 sentences on use cases
4. **How to Use** - 1-2 sentences with brief instructions

## Step 3: Help Tab

**File**: `app/Fields/Partials/ModuleName.php`

**Location**: In settings tab after standard fields (ID, custom_classes, custom_styles)

**Pattern**:
```php
->addTab('settings')
    // ... standard fields (ID, custom_classes, custom_styles)
    ->addFields($this->addHelpTab(
        'module-name',
        $this->formatUsageGuide([
            'Section Title' => 'Content for this section explaining how to use a feature.',
            'Another Section' => 'More detailed instructions.',
            'Tips' => 'Helpful tips and notes.',
        ]),
        $this->formatBestPracticesList(
            [
                'Do use clear, descriptive titles',
                'Do keep content concise',
                'Do test on mobile devices',
                // ... more dos
            ],
            [
                'Don\'t use low-resolution images',
                'Avoid very long text blocks',
                // ... more don'ts
            ]
        )
    ));

return $moduleName;
```

**Usage Guide Sections** (customize for module):
- How the module works
- Field instructions
- Data source (if applicable)
- Layout/display options
- Special features

**Best Practices** (aim for 5-10 dos, 2-5 don'ts):
- **Dos**: Positive recommendations, best use cases
- **Don'ts**: Things to avoid, common mistakes

## Step 4: Centralized Admin Documentation

**File**: `app/admin-docs.php`

**⚠️ CRITICAL**: Insert in **CORRECT ALPHABETICAL ORDER** by module name

**Pattern**:
```php
[
    'name' => 'Module Name',
    'slug' => 'module_name',
    'description' => 'One-sentence description of the module.',
    'screenshot' => $template_uri . '/resources/images/admin/module-screenshots/module-name.png',
    'screenshot2' => $template_uri . '/resources/images/admin/module-screenshots/module-name-variation-2.png', // Optional second screenshot
    'screenshot3' => $template_uri . '/resources/images/admin/module-screenshots/module-name-variation-3.png', // Optional third screenshot
    'when_to_use' => 'When to use this module. Include use cases and scenarios.',
    'how_to_use' => 'Step-by-step instructions on how to use the module. Include key field explanations.',
    'best_practices' => [
        'Best practice item 1',
        'Best practice item 2',
        'Best practice item 3',
        // ... typically 7-10 total items
        'Don\'t do this negative example',
        'Avoid this common mistake',
    ],
],
```

**Fields**:
- **name** - Display name (used for alphabetical sorting)
- **slug** - Module slug (snake_case)
- **description** - One-sentence overview
- **screenshot** - Path to primary screenshot PNG/SVG (displays in collapsed view)
- **screenshot2** - (Optional) Path to second screenshot for layout variations
- **screenshot3** - (Optional) Path to third screenshot for layout variations
- **when_to_use** - Use cases and scenarios (1-3 sentences) **⚠️ MUST end with comma**
- **how_to_use** - Instructions for using the module (2-4 sentences)
- **best_practices** - Array of 7-10 items (mix of dos and don'ts)

**Screenshot Display Behavior**:
- **Collapsed view**: Only `screenshot` (primary) displays next to module description
- **Expanded view**: All screenshots (screenshot, screenshot2, screenshot3) display together under "Layout Variations" heading
- Use multiple screenshots when module has layout variations or different modes

**Screenshot Notes**:
- Save in `resources/images/admin/module-screenshots/`
- Use PNG or SVG format
- Name primary: `module-name.png` (matches slug with dashes)
- Name variations: `module-name-variation-2.png`, `module-name-variation-3.png`

**⚠️ CRITICAL: Array Syntax**:
- Every array item MUST end with a comma, including `'when_to_use'`
- Missing commas cause fatal PHP syntax errors
- Double-check commas after adding screenshot2/screenshot3 fields

## Verification Steps

After completing all documentation:

1. **Check developer docs** (`docs/MODULE-NAME.md`):
   - [ ] File exists and is comprehensive
   - [ ] All relevant sections included
   - [ ] Code examples where appropriate
   - [ ] Technical details documented

2. **Check ACF partial** (`app/Fields/Partials/ModuleName.php`):
   - [ ] ModuleDocumentation trait imported and used
   - [ ] Help message at top of content tab
   - [ ] Help tab in settings tab with usage guide and best practices
   - [ ] No syntax errors

3. **Check admin docs** (`app/admin-docs.php`):
   - [ ] Module added in **CORRECT alphabetical position**
   - [ ] All required fields present (name, slug, description, screenshot, when_to_use, how_to_use, best_practices)
   - [ ] Screenshot paths are correct (screenshot, screenshot2, screenshot3 if variations exist)
   - [ ] Array syntax is valid (no missing commas/brackets)
   - [ ] **CRITICAL**: `'when_to_use'` line ends with comma before `'how_to_use'`

4. **Test in WordPress**:
   - [ ] Load page builder — module appears
   - [ ] Help message displays in content tab
   - [ ] Help tab displays correctly
   - [ ] Admin documentation page shows module with primary screenshot
   - [ ] Expand details — all screenshot variations display under "Layout Variations"

## Common Mistakes to Avoid

1. **Alphabetical Ordering**: Not inserting admin docs entry in correct alphabetical position
2. **Incomplete Documentation**: Creating only developer docs or only admin docs (need BOTH)
3. **Array Syntax**: Breaking admin-docs.php with malformed arrays or missing commas
4. **Missing Commas**: Forgetting comma after `'when_to_use'` line when adding screenshot variations
5. **Screenshot Paths**: Using wrong file names or paths for screenshots
6. **ModuleDocumentation Trait**: Forgetting to import/use the trait
7. **Return Statement**: Calling `->build()` on field partials (should return builder object directly)

## Quick Reference: Documentation Locations

| Documentation Type | Location | Required? |
|-------------------|----------|-----------|
| Developer Docs | `docs/MODULE-NAME.md` | ✅ Yes |
| In-Module Help | ACF Partial - Content Tab | ✅ Yes |
| Help Tab | ACF Partial - Settings Tab | ✅ Yes |
| Admin Docs | `app/admin-docs.php` | ✅ Yes |
| Primary Screenshot | `resources/images/admin/module-screenshots/module-name.png` | ✅ Yes |
| Variation Screenshots | `resources/images/admin/module-screenshots/module-name-variation-2.png`, etc. | ⚠️ If module has layout variations |
| Tests | `tests/js/modules/` | ⚠️ If module has JS |

## Template Files

For quick reference, see:
- **Developer Docs Template**: This guide (## Step 1 section)
- **ACF Help Template**: `app/Fields/Traits/ModuleDocumentation.php`
- **Admin Docs Template**: This guide (## Step 4 section)
