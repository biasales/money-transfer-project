<?php

namespace App\Services;

class Validate
{
    public static function validateJsonFields(array $values, array $expectedFields) {
        foreach ($expectedFields as $field) {
            if (!isset($values[$field])) {
                return false;
            }
        }

        return true;
    }

}