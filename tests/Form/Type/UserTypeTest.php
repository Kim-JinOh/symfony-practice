<?php

namespace App\Tests\Form\Type;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class UserTypeTest extends TypeTestCase
{
    private $objectManager;

    protected function setUp(): void
    {
        $this->objectManager = $this->createMock(ObjectManager::class);

        parent::setUp();
    }

    protected function getExtensions()
    {
        $type = new UserType($this->objectManager);
        // or if you also need to read constraints from annotations
        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping(true)
            ->addDefaultDoctrineAnnotationReader()
            ->getValidator();


        return [
            new PreloadedExtension([$type], []),
            new ValidatorExtension($validator)
        ];
    }
    public function test_submit_validData_success()
    {
        //arrange
        $userFormData = [
            'email' => 'jokim.dev@gmail.com',
            'password' => [
                'first' => 'qwe123',
                'second' => 'qwe123'
            ],
            'mobileNumber' => '01049272678'
        ];

        //action
        $user = new User();
        $form = $this->factory->create(UserType::class, $user);
        $form->submit($userFormData);

        //assert
        $expectedUser = new User();
        $expectedUser->setEmail('jokim.dev@gmail.com');
        $expectedUser->setPassword('qwe123');
        $expectedUser->setMobileNumber('01049272678');

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expectedUser, $user);
    }

    public function test_submit_differentPassword_fail()
    {
        //arrange
        $userFormData = [
            'email' => 'jokim.dev@gmail.com',
            'password' => [
                'first' => 'right-password',
                'second' => 'wrong-password'
            ],
            'mobileNumber' => '01049272678'
        ];

        //action
        $user = new User();
        $form = $this->factory->create(UserType::class, $user);
        $form->submit($userFormData);
        $form->isValid();

        //assert
        $errorMessage = $form->getErrors(true);

        $this->assertFalse($form->isValid());
        $this->assertEquals(1, $errorMessage->count());
        $this->assertEquals("ERROR: 비밀번호가 동일하지 않습니다.\n", (string)$errorMessage);
    }

    public function test_submit_noEmail_fail()
    {
        $userFormData = [
            'password' => [
                'first' => 'right-password',
                'second' => 'right-password'
            ],
            'mobileNumber' => '01049272678'
        ];

        //action
        $user = new User();
        $form = $this->factory->create(UserType::class, $user);
        $form->submit($userFormData);
        $form->isValid();

        //assert
        $errorMessage = $form->getErrors(true);

        $this->assertFalse($form->isValid());
        $this->assertEquals(1, $errorMessage->count());
        $this->assertEquals("ERROR: 이메일은 필수로 입력해야 합니다.\n", (string)$errorMessage);
    }
}
