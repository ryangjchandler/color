<?php

use RyanChandler\Color\Color;

use function Puny\ok;
use function Puny\test;

test('it can calculate the distance betweeen 2 colors', function () {
    $one = Color::new(0, 0, 220);
    $two = Color::new(255, 0, 220);

    $distance = Color::distance($one, $two);

    ok($distance === 65025, 'correctly calculates distance.');
});