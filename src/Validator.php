<?php 

namespace Core;


class InputValidator {

    protected $input;

    protected $errors = [];
    
    protected $rules = [
        'required' => 'validateRequired',
        'alphanum' => 'validateAlphanum',
        'email' => 'validateEmail',
        'phone' => 'validatePhone'
    ];

    public function __construct($input) 
    {
        $this->input = $input;
    }

    public function validate() 
    {
        foreach ($this->input as $field => $rules) {
            $rules = explode('|', $rules);

            foreach ($rules as $rule) {
                $value = isset($_POST[$field]) ? $_POST[$field] : null;

                if (isset($this->rules[$rule])) {
                    $method = $this->rules[$rule];
                    $this->$method($field, $value);
                } else if (preg_match('/^min:(\d+)$/', $rule, $matches)) {
                    $min = $matches[1];
                    $this->validateMin($field, $value, $min);
                } else if (preg_match('/^max:(\d+)$/', $rule, $matches)) {
                    $max = $matches[1];
                    $this->validateMax($field, $value, $max);
                } else {
                    $this->addError("$field has an invalid validation rule: $rule");
                }
            }
        }

        return empty($this->errors);
    }

    public function getErrors() 
    {
        return $this->errors;
    }

    protected function validateRequired($field, $value) 
    {
        if (empty($value)) {
            $this->addError("$field is required.");
        }
    }

    protected function validateAlphanum($field, $value) 
    {
        if (!ctype_alnum($value)) {
            $this->addError("$field must contain only alphanumeric characters.");
        }
    }

    protected function validateMin($field, $value, $min) 
    {
        if (strlen($value) < $min) {
            $this->addError("$field must be at least $min characters long.");
        }
    }

    protected function validateMax($field, $value, $max) 
    {
        if (strlen($value) > $max) {
            $this->addError("$field must be no more than $max characters long.");
        }
    }

    protected function validateEmail($field, $value) 
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError("$field must be a valid email address.");
        }
    }

    protected function validatePhone($field, $value) 
    {
        // TODO: Use a better phone number validation
        if (!preg_match('/^[0-9]{10}$/', $value)) {
            $this->addError("$field must be a valid phone number.");
        }
    }

    protected function addError($error) 
    {
        $this->errors[] = $error;
    }
}
