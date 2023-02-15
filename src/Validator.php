<?php

namespace Core;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class Validator
{
    protected $input;
    protected $errors = [];

    protected $rules = [
        'required' => 'validateRequired',
        'alphanum' => 'validateAlphanum',
        'email' => 'validateEmail',
        'phone' => 'validatePhone',
        'min' => 'validateMin',
        'max' => 'validateMax'
    ];

    public function __construct($input)
    {
        $this->input = $input;
    }

    public function validate($data)
    {
        $validator = Validation::createValidator();
        
        foreach ($this->input as $field => $rules) {
            $rulesArray = explode('|', $rules);
            $constraints = [];

            foreach ($rulesArray as $rule) {
                if (isset($this->rules[$rule])) {
                    $constraints[] = call_user_func([$this, $this->rules[$rule]]);
                } else if (preg_match('/^min:(\d+)$/', $rule, $matches)) {
                    $min = $matches[1];
                    $constraints[] = $this->validateMin($min);
                } else if (preg_match('/^max:(\d+)$/', $rule, $matches)) {
                    $max = $matches[1];
                    $constraints[] = $this->validateMax($max);
                }
            }
            
            $value = isset($data[$field]) ? $data[$field] : null;
            $violations = $validator->validate($value, $constraints);

            if ($violations->count() > 0) {
                foreach ($violations as $violation) {
                    $this->addError($field, $violation->getMessage());
                }
            }
        }

        return empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    protected function validateRequired()
    {
        return new Assert\NotBlank();
    }

    protected function validateAlphanum()
    {
        return new Assert\Regex(['pattern' => '/^[a-zA-Z0-9]+$/']);
    }

    protected function validateMin($min)
    {
        return new Assert\Length(['min' => $min]);
    }

    protected function validateMax($max)
    {
        return new Assert\Length(['max' => $max]);
    }

    protected function validateEmail()
    {
        return new Assert\Email();
    }

    protected function validatePhone()
    {
        //TODO: Add support for other phone number formats
        return new Assert\Regex(['pattern' => '/^[0-9]{10}$/']);
    }

    protected function addError($field, $error)
    {
        $this->errors[$field][] = $error;
    }
}
