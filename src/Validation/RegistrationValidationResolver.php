<?php

namespace App\Validation;

use Symfony\Component\Form\FormInterface;

class RegistrationValidationResolver {
    public function __invoke(FormInterface $form):array
    {
        $groups = [];

        return $groups;
    }
}