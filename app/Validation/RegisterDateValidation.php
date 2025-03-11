<?php
namespace App\Validation;
use App\Models\AuthModel;

class RegisterDateValidation
{


    public function check($str): bool
    {
        // Check if the input is a valid date
        if (!strtotime($str)) {
            return false;
        }

        // Convert the input date string to a timestamp
        $date = strtotime($str);

        // Get the timestamp for 15 years ago
        $fifteenYearsAgo = strtotime('-15 years');

        // Check if the input date is before 15 years ago
        return $date < $fifteenYearsAgo;
    }

    public function getErrorMessage(): string
    {
        return 'The Date of Birth  must be a date before 15 years ago.';
    }
    




}