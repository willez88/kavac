<?php

return [

    'characters' => [
        '2', '3', '4', '6', '7', '8', '9',
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'm', 'n', 'p', 'q', 'r', 't', 'u', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'M', 'N', 'P', 'Q', 'R', 'T', 'U', 'X', 'Y', 'Z'
    ],
    //'characters' => '012346789abcdefghijklmnopqrstuvwxyz',

    'default'   => [
        'length'    => 6,
        'width'     => 160,
        'height'    => 52,
        'quality'   => 90,
        'math'      => false,
    ],

    'math' => [
        'length' => 9,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'math' => true,
    ],

    'flat'   => [
        'length'    => 6,
        'width'     => 160,
        'height'    => 46,
        'quality'   => 100,
        'lines'     => 1,
        'bgImage'   => true,
        'bgColor'   => '#ecf2f4',
        'fontColors'=> ['#2c3e50', '#c0392b', '#16a085', '#c0392b', '#8e44ad', '#303f9f', '#f57c00', '#795548'],
        'contrast'  => -6,
    ],

    'mini'   => [
        'length'    => 6,
        'width'     => 60,
        'height'    => 32,
    ],

    'inverse'   => [
        'length'    => 6,
        'width'     => 160,
        'height'    => 52,
        'quality'   => 90,
        'sensitive' => true,
        'angle'     => 12,
        'sharpen'   => 10,
        'blur'      => 2,
        'invert'    => false,
        'contrast'  => -6,
    ]

];
