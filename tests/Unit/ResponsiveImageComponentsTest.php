<?php

use App\View\Components\AcfImage;
use App\View\Components\FeaturedImage;

require_once __DIR__.'/../Stubs/wordpress.php';

beforeEach(function () {
    $GLOBALS['wp_stubs'] = [
        'thumbnail_id' => 42,
        'image_src' => ['https://example.test/image.jpg', 1920, 1080],
        'srcset' => 'https://example.test/image-768.jpg 768w, https://example.test/image.jpg 1920w',
        'post_title' => 'image-title',
        'alt' => 'Alt text',
    ];

    // Fail the test on any warning, notice or deprecation (e.g. undefined variables or dynamic properties)
    set_error_handler(function ($severity, $message, $file, $line) {
        throw new ErrorException($message, 0, $severity, $file, $line);
    });
});

afterEach(function () {
    restore_error_handler();
    unset($GLOBALS['wp_stubs']);
});

dataset('components', [
    'AcfImage' => [AcfImage::class],
    'FeaturedImage' => [FeaturedImage::class],
]);

it('accepts the srcset-sizes attribute as a constructor parameter', function (string $component) {
    // Blade maps the kebab-case `srcset-sizes` attribute to a `$srcsetSizes` parameter;
    // without it the attribute leaks onto the <img> tag instead of setting `sizes`.
    $parameters = array_map(
        fn (ReflectionParameter $parameter) => $parameter->getName(),
        (new ReflectionMethod($component, '__construct'))->getParameters()
    );

    expect($parameters)->toContain('srcsetSizes');
})->with('components');

it('declares a public sizes property for the responsive image view', function (string $component) {
    $property = new ReflectionProperty($component, 'sizes');

    expect($property->isPublic())->toBeTrue();
})->with('components');

it('uses the passed srcset sizes', function (string $component) {
    $image = new $component(imageId: 42, srcsetSizes: '(min-width: 992px) 50vw, 100vw');

    expect($image->srcset)->toBe($GLOBALS['wp_stubs']['srcset'])
        ->and($image->sizes)->toBe('(min-width: 992px) 50vw, 100vw');
})->with('components');

it('defaults sizes to 100vw when a srcset exists', function (string $component) {
    $image = new $component(imageId: 42);

    expect($image->sizes)->toBe('100vw');
})->with('components');

it('omits sizes when there is no srcset', function (string $component) {
    $GLOBALS['wp_stubs']['srcset'] = false;

    $image = new $component(imageId: 42, srcsetSizes: '100vw');

    expect($image->sizes)->toBeNull();
})->with('components');

it('falls back to a placeholder when the post has no featured image', function () {
    $GLOBALS['wp_stubs']['thumbnail_id'] = 0;

    $image = new FeaturedImage(imageId: 42);

    expect($image->image_alt)->toBe('placeholder')
        ->and($image->sizes)->toBeNull();
});
