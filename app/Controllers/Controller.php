<?php

namespace App\Controllers;

class Controller
{
    public static function validate(array $fields, array $rules)
    {
        $validated = true;

        foreach ($fields as $field => $value) {
            if (!isset($rules[$field])) {
                continue;
            }

            $ruleErrorsHandlers = $rules[$field]($value);

            foreach ($ruleErrorsHandlers as $ruleErrorsHandler) {
                [$isValid, $errorMessage] = $ruleErrorsHandler;
                if ($isValid) {
                    continue;
                }
                if (isset($_SESSION['flash']['errors'][$field])) {
                    continue;
                }
                $_SESSION['flash']['errors'][$field] = $errorMessage;
                $validated = false;
            }
        }

        return $validated;
    }
}
