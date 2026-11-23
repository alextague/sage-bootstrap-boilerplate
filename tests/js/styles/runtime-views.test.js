/**
 * @jest-environment node
 */

import {readdirSync, readFileSync, statSync} from 'node:fs';
import {join} from 'node:path';

import {describe, expect, it} from '@jest/globals';

// On WP Engine a logged-out request can't create .php files, so a view that Laravel writes at
// render time can't be created for visitors. <x-dynamic-component> writes an inline Blade view
// into the compiled-views folder (Component::createBladeViewFromString), and Blade::render() does
// the same, so after a deploy clears that folder logged-out visitors get WordPress's critical
// error page until someone logged in loads a page or something renders from the CLI. Icons render
// through blade-icons' svg() helper instead, which writes nothing.
function bladeFiles(dir) {
  return readdirSync(dir).flatMap((entry) => {
    const path = join(dir, entry);

    if (statSync(path).isDirectory()) {
      return bladeFiles(path);
    }

    return path.endsWith('.blade.php') ? [path] : [];
  });
}

const views = bladeFiles(join(process.cwd(), 'resources/views'));

describe('Views rendered at runtime', () => {
  it("finds the theme's Blade files", () => {
    expect(views.length).toBeGreaterThan(20);
  });

  it('never uses <x-dynamic-component>, which writes a view file at render time', () => {
    const offenders = views.filter((path) =>
      /<x-dynamic-component\b/.test(readFileSync(path, 'utf8')),
    );

    expect(offenders).toEqual([]);
  });

  // blade-icons' component tags (<x-fab-facebook-f/>, <x-icon name="…"/>) return the SVG as a
  // string, which Laravel writes to the compiled-views folder as a view at render time, the same
  // as a dynamic component. The svg() helper returns it directly.
  it('never uses blade-icons component tags, which write the SVG as a view at render time', () => {
    const offenders = views.filter((path) =>
      /<x-(fab|fas|far|icon)[-\s/>]/.test(readFileSync(path, 'utf8')),
    );

    expect(offenders).toEqual([]);
  });

  it('never renders Blade from a string in PHP', () => {
    const phpFiles = readdirSync(join(process.cwd(), 'app'), {recursive: true})
      .filter((entry) => String(entry).endsWith('.php'))
      .map((entry) => join(process.cwd(), 'app', String(entry)));
    const offenders = phpFiles.filter((path) =>
      /Blade::render\(|->render\(\s*['"<]/.test(readFileSync(path, 'utf8')),
    );

    expect(offenders).toEqual([]);
  });
});
