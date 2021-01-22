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