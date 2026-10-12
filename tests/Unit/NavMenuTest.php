<?php

use App\BootstrapNav;
use App\View\Components\NavMenu;

require_once __DIR__.'/../Stubs/wordpress.php';

beforeEach(function () {
    $GLOBALS['wp_stubs'] = ['has_nav_menu' => true];

    // Fail the test on any warning, notice or deprecation
    set_error_handler(function ($severity, $message, $file, $line) {
        throw new ErrorException($message, 0, $severity, $file, $line);
    });
});

afterEach(function () {
    restore_error_handler();
    unset($GLOBALS['wp_stubs']);
});

it('returns the menu HTML instead of echoing it', function () {
    ob_start();
    $menu = new NavMenu(menuLocation: 'primary_navigation');
    $echoed = ob_get_clean();

    expect($echoed)->toBe('')
        ->and($GLOBALS['wp_stubs']['wp_nav_menu_args']['echo'])->toBeFalse()
        ->and($menu->nav_menu)->toBe('<ul class="navbar-nav"></ul>');
});

it('uses the BootstrapNav walker and desktop defaults', function () {
    new NavMenu(menuLocation: 'primary_navigation');

    $args = $GLOBALS['wp_stubs']['wp_nav_menu_args'];

    expect($args['theme_location'])->toBe('primary_navigation')
        ->and($args['menu_class'])->toBe('navbar-nav')
        ->and($args['depth'])->toBe(2)
        ->and($args['walker'])->toBeInstanceOf(BootstrapNav::class);
});

it('passes a custom menu class for the mobile menu', function () {
    $menu = new NavMenu(menuLocation: 'primary_navigation', menuClass: 'mobile-nav', ariaLabel: 'Mobile navigation');

    expect($GLOBALS['wp_stubs']['wp_nav_menu_args']['menu_class'])->toBe('mobile-nav')
        ->and($GLOBALS['wp_stubs']['wp_nav_menu_args']['walker'])->toBeInstanceOf(BootstrapNav::class)
        ->and($menu->ariaLabel)->toBe('Mobile navigation')
        ->and($menu->navClass)->toBeNull();
});

it('falls back to BootstrapNav when the walker class is invalid', function (string $walkerClass) {
    new NavMenu(menuLocation: 'primary_navigation', walkerClass: $walkerClass);

    expect($GLOBALS['wp_stubs']['wp_nav_menu_args']['walker'])->toBeInstanceOf(BootstrapNav::class);
})->with([
    'missing class' => ['App\\DoesNotExist'],
    'not a nav walker' => [stdClass::class],
]);

it('omits the walker when disabled', function () {
    new NavMenu(menuLocation: 'primary_navigation', useWalker: false);

    expect($GLOBALS['wp_stubs']['wp_nav_menu_args'])->not->toHaveKey('walker');
});

it('renders nothing when no menu is assigned to the location', function () {
    $GLOBALS['wp_stubs']['has_nav_menu'] = false;

    $menu = new NavMenu(menuLocation: 'primary_navigation');

    expect($menu->nav_menu)->toBeNull()
        ->and($GLOBALS['wp_stubs'])->not->toHaveKey('wp_nav_menu_args');
});
