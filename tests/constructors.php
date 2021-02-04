<?php

use RyanChandler\Color\Color;

use function Puny\ok;
use function Puny\test;

test('it can be created', function () {
    $color = new Color(255, 254, 253);

    ok($color instanceof Color, 'instantiated correctly');
    ok($color->toString() === '(255, 254, 253)', 'colors are stored correctly');

    $static = Color::new(255, 254, 253);

    ok($static instanceof Color, 'statically instantiated correctly');
    ok($static->toString() === '(255, 254, 253)', 'colors are stored correctly statically');
});

test('it can limit RGBA colors', function () {
    $color = new Color(256, 257, 258, 2.0);

    ok($color->alpha === 1.0, 'colors alpha value limited to 1.0');
    ok($color->toString() === '(255, 255, 255)', 'colors are limited to 255');
});

test('it can be created using ::random()', function () {
    $random = Color::random();

    ok($random instanceof Color, 'instantiated correctly');
});

test('it can be created using ::hex()', function () {
    $hex = Color::hex('#819758');

    ok($hex instanceof Color, 'instantiated correctly');
    ok($hex->toString() === '(129, 151, 88)', 'hex converted correctly.');
});

test('it can be created using ::hex() with alpha', function () {
    $hex = Color::hex('#81975880');

    ok($hex instanceof Color, 'instantiated correctly');
    ok($hex->toString() === '(129, 151, 88, 0.5)', 'hex converted correctly.');
});

test('it can be created using abbreviated hex values', function () {
    $hex = Color::hex('#aaa');

    ok($hex instanceof Color, 'instantiated correctly');
    ok($hex->toString() === '(170, 170, 170)', 'hex converted correctly.');
});

test('it can be created using ::hsl()', function () {
    $hsl = Color::hsl(60, 100, 50);
    $hslMono = Color::hsl(0, 0, 50);

    ok($hsl instanceof Color, 'instantiated correctly');
    ok($hslMono instanceof Color, 'monochrome instantiated correctly');
    ok($hsl->toString() === '(255, 255, 0)', 'color hsl converted correctly.');
    ok($hslMono->toString() === '(128, 128, 128)', 'monochrome hsl converted correctly.');
});

test('it can be created using ::hsl() with alpha', function () {
    $hsl = Color::hsl(60, 100, 50, 0.5);
    $hslMono = Color::hsl(0, 0, 50, 0.5);

    ok($hsl instanceof Color, 'instantiated correctly');
    ok($hslMono instanceof Color, 'monochrome instantiated correctly');
    ok($hsl->toString() === '(255, 255, 0, 0.5)', 'hex converted correctly.');
    ok($hslMono->toString() === '(128, 128, 128, 0.5)', 'monochrome hsl converted correctly.');
});

test('it can limit HSLA values', function () {
    $color = Color::hsl(400, 120, 120, 2.0);

    ok($color->alpha === 1.0, 'colors alpha value limited to 1.0');
    ok($color->toString() === '(255, 255, 255)', 'colors are limited to 255');
});