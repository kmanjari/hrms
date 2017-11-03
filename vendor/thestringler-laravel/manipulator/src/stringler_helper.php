<?php

use TheStringler\Manipulator\Manipulator;

if (! function_exists('manipulate')) {
    function manipulate($string = '') {
        return new Manipulator($string);
    }
}