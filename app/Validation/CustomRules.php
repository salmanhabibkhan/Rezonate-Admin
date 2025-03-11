<?php
namespace App\Validation;

class CustomRules
{


    public function less_than_maximum(string $str, string $fields, array $data): bool
    {
        return isset($data['maximum_salary']) && $str < $data['maximum_salary'];
    }
    




}