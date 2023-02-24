<?php

namespace Core;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class Validator
{
    protected $input;
    protected $errors = [];

    protected $rules = [
        'max'      => 'validateMax',
        'min'      => 'validateMin',
        'date'     => 'validateDate',
        'phone'    => 'validatePhone',
        'email'    => 'validateEmail',
        'array'    => 'validateArray',
        'numeric'  => 'validateNumeric',
        'required' => 'validateRequired',
        'alphanum' => 'validateAlphanum',
        'url'      => 'validateUrl',
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
            if (!empty($value) || in_array('required', $rulesArray)) {
                // Only validate the field if it's not empty or if it's required
                $violations = $validator->validate($value, $constraints);

                if ($violations->count() > 0) {
                    // foreach ($violations as $violation) {
                    //     // $message = $violation->getMessage();
                    //     dd($messages[$field][$violation->getConstraint()->getTargets()[0]]);
                    //     if (isset($messages[$field][$violation->getConstraint()->getTargets()[0]][$violation->getCode()])) {
                    //         $message = $messages[$field][$violation->getConstraint()->getTargets()[0]][$violation->getCode()];
                    //     }
                    //     $this->addError($field, $message);
                    // }
                    foreach ($violations as $violation) {
                        $message = $violation->getMessage();

                        if (isset($messages[$field]) && isset($messages[$field][$this->getRuleNameFromCode($violation->getCode())])) {
                            $message = $messages[$field][$this->getRuleNameFromCode($violation->getCode())];
                        }
                        $this->addError($field, $message);
                    }
                }
            }
        }

        return empty($this->errors);
    }

    protected function getRuleNameFromCode($code)
    {
        $map = [
            Assert\NotBlank::IS_BLANK_ERROR    => 'required',
            Assert\Length::TOO_SHORT_ERROR     => 'min',
            Assert\Length::TOO_LONG_ERROR      => 'max',
            Assert\Date::INVALID_FORMAT_ERROR  => 'date',
            Assert\Regex::REGEX_FAILED_ERROR   => 'phone',
            Assert\Email::INVALID_FORMAT_ERROR => 'email',
            Assert\Type::INVALID_TYPE_ERROR    => 'array',
            Assert\Url::INVALID_URL_ERROR      => 'url',
        ];

        return isset($map[$code]) ? $map[$code] : null;
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

    protected function validateArray()
    {
        return new Assert\Type(['type' => 'array']);
    }

    protected function validateUrl()
    {
        return new Assert\Url();
    }

    protected function addError($field, $error)
    {
        $this->errors[$field][] = $error;
    }
}
