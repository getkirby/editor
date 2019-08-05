<?php

use Kirby\Editor\Blocks;

return function ($field) {
    return Blocks::factory($field->value(), $field->parent());
};
