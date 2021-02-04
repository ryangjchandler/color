<?php

use function Puny\ok;
use function Puny\test;
use RyanChandler\Color\Color;

test('it can be formatted as an array', function () {
    $color = new Color(255, 254, 253);

    ok($color->toArray() === [255, 254, 253], 'correctly formats array');
});

test('it can be formatted as a string', function () {
    $color = new Color(255, 254, 253);

    ok($color->toString() === '(255, 254, 253)', 'correctly formats string');
    ok((string) $color === '(255, 254, 253)', 'correctly formats string using cast');

    $color->alpha = 0.5;

    ok($color->toString() === '(255, 254, 253, 0.5)', 'correctly formats string with alpha');
    ok((string) $color === '(255, 254, 253, 0.5)', 'correctly formats string with alpha using cast');
});

test('it can be formatted as a hex', function () {
    $color = Color::hex('#819758');

    ok($color->toHex() === '#819758', 'correctly formats hex');
    ok($color->toString(true) === '#819758', 'correctly formats hex from toString');
});

test('it can be formatted as an 8-digit hex', function () {
    $color = Color::new(255, 255, 255, 0.5);

    ok($color->toHex() === '#ffffff80', 'correctly formats hex with alpha');
    ok($color->toString(true) === '#ffffff80', 'correctly formats hex with alpha from toString');
});

test('it can be formatted as hsl', function () {
    $hsl = Color::new(255, 255, 0)->toHsl();
    $hslAlpha = Color::new(255, 255, 0, 0.5)->toHsl();

    ok($hsl === [60, 100, 50], 'correctly formats hsl');
    ok($hslAlpha === [60, 100, 50, 0.5], 'correctly formats hsl with alpha');

    $hslMono = Color::new(255, 255, 255)->toHsl();
    $hslMonoAlpha = Color::new(255, 255, 255, 0.5)->toHsl();

    ok($hslMono === [0, 0, 100], 'correctly formats monochrome hsl');
    ok($hslMonoAlpha === [0, 0, 100, 0.5], 'correctly formats monochrome hsl with alpha');
});