<?php

use function Puny\ok;

use function Puny\test;
use RyanChandler\Color\Color;

test('it can calculate the relative luminance', function () {
    $hex = Color::hex('#aaa');

    ok(round($hex->relativeLuminance(), 10) === 0.4019777798, 'correctly calculates relative luminance');
});

test('it can calculate the contrast ratio score for two colors', function () {
    $color1 = Color::hex('#f4f4f4');
    $color2 = Color::hex('#202730');

    $contrast = Color::contrastScore($color1, $color2);

    ok($contrast->ratio === 13.69, 'correctly calculates the contrast ratio');
    ok($contrast->score === 'AAA', 'correctly scores the contrast ratio');
});
