<?php

return [

    'characters' => '012346789abcdefghijklmnopqrstuvwxyz',

    'default'   => [
        'length'    => 6,
        'width'     => 120,
        'height'    => 36,
        'quality'   => 90,
        'math'      => false,
    ],

    'flat'   => [
        'length'    => 6,
        'width'     => 160,
        'height'    => 46,
        'quality'   => 100,
        'lines'     => 1,
        'bgImage'   => true,
        'bgColor'   => '#ecf2f4',
        'fontColors'=> ['#2c3e50', '#c0392b', '#16a085', '#c0392b', '#8e44ad', '#303f9f', '#008d4c', '#795548'],
        'contrast'  => -5,
    ],

    'mini'   => [
        'length'    => 6,
        'width'     => 60,
        'height'    => 32,
    ],

    'inverse'   => [
        'length'    => 6,
        'width'     => 120,
        'height'    => 36,
        'quality'   => 90,
        'sensitive' => true,
        'angle'     => 12,
        'sharpen'   => 10,
        'blur'      => 2,
        'invert'    => false,
        'contrast'  => -5,
    ]

];
