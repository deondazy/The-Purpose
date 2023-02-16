<?php

namespace Core;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class Validator
{
    protected $input;
    protected $errors = [];

    protected $rules = [
        'max' => 'validateMax',
        'min' => 'validateMin',
        'date' => 'validateDate',
        'phone' => 'validatePhone',
        'image' => 'validateImage',
        'email' => 'validateEmail',
        'array' => 'validateArray',
        'numeric' => 'validateNumeric',
        'required' => 'validateRequired',
        'alphanum' => 'validateAlphanum',
    ];

    public function __construct($input)
    {
        $this->input = $input;
    }

    public function validate($data, $messages = [])
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
                    if (isset($violation->getParameters()['{{ type }}'])) {
                        $error = isset($messages[$field][$violation->getParameters()['{{ type }}']])
                        ? $messages[$field][$violation->getParameters()['{{ type }}']]
                        : $violation->getMessage();
                    } else {
                        $error = isset($messages[$field][$violation->getMessageTemplate()])
                            ? $messages[$field][$violation->getMessageTemplate()]
                            : $violation->getMessage();
                }

                    $this->addError($field, $error);
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

    protected function validateDate()
    {
        return new Assert\Date();
    }

    protected function validateNumeric()
    {
        return new Assert\Type(['type' => 'numeric']);
    }

    protected function validateImage()
    {
        return new Assert\Image();
    }

    protected function validateArray()
    {
        return new Assert\Type(['type' => 'array']);
    }

    protected function addError($field, $error)
    {
        $this->errors[$field][] = $error;
    }
}
