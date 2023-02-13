<?php

namespace App\Tests\Validator;

use App\Entity\User;
use App\Validator\User as UserConstraint;
use App\Validator\UserValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class UserValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): UserValidator
    {
        return new UserValidator();
    }

    public function test_validator_user_sucess()
    {
        $user = new User();
        $user->setEmail('test@test.test');
        $user->setPassword('qwe123');
        $this->validator->validate($user, new UserConstraint());
    }
}
