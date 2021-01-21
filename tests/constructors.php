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

test('it can be created using ::random()', function () {
    $random = Color::random();

    ok($random instanceof Color, 'instantiated correctly');
});

test('it can be created using ::hex()', function () {
    $hex = Color::hex('#819758');

    ok($hex instanceof Color, 'instantiated correctly');
    ok($hex->toString() === '(129, 151, 88)', 'hex converted correctly.');
});