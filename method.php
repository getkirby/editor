<?php

return function ($field) {
    return Kirby\Editor\Blocks::factory($field->value(), $field->parent());
};
