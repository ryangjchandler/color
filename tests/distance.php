<?php

use RyanChandler\Color\Color;

use function Puny\ok;
use function Puny\test;

test('it can calculate the distance betweeen 2 colors', function () {
    $one = Color::new(0, 0, 220);
    $two = Color::new(255, 0, 220);

    $distance = Color::distanceBetween($one, $two);

    ok($distance === 65025, 'correctly calculates distance.');
});

test('it can calculate the distance betweeen 2 colors on instance', function () {
    $one = Color::new(0, 0, 220);
    $two = Color::new(255, 0, 220);

    $distance = $one->distanceTo($two);

    ok($distance === 65025, 'correctly calculates distance.');
});