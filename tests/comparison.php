<?php

use RyanChandler\Color\Color;

use function Puny\ok;
use function Puny\test;

test('it can compare rgb to hex', function () {
    $hex = Color::hex('#aaa');
    $rgb = Color::new(170, 170, 170);
    $differentColor = Color::hex('#bbb');

    ok($hex->equals($rgb), 'RGB can be compared to hex');
    ok($rgb->equals($hex), 'hex can be compared to RGB');
    ok(! $hex->equals($differentColor), 'different colors do not match');
});

test('it can compare two colors', function () {
    $first = Color::hex('#aaa');
    $second = Color::hex('#aaa');
    $differentColor = Color::hex('#bbb');

    ok(Color::bothEqual($first, $second) === true, 'two colors can be compared');
    ok(Color::bothEqual($first, $differentColor) === false, 'different colors do not match');
});
