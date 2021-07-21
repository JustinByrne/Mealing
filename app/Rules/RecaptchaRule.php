<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use ReCaptcha\ReCaptcha;

class RecaptchaRule implements Rule
{
    private $errors;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (config('recaptcha.testing') || config('recaptcha.testing') !== null)   {
            return true;
        }
        
        $rScore = 0.5;
        
        if (empty($value))  {
            $this->errors = ':atrribute field is required';

            return false;
        }

        $recaptcha = new Recaptcha(config('recaptcha.secret_key'));

        $resp = $recaptcha->setExpectedHostname($_SERVER['HTTP_HOST'])
                  ->setScoreThreshold($rScore)
                  ->verify($value, $_SERVER['REMOTE_ADDR']);
        
        if (!$resp->isSuccess())    {
            $this->errors = $resp->getErrorCodes();

            return false;
        }

        if ($resp->getScore() < $rScore)    {
            $this->errors = 'Failed to valildate ReCaptcha';

            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->errors;
    }
}
