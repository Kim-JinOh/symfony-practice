<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'form-control form-control-xl'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => '비밀번호가 동일하지 않습니다.',
                'required' => true,
                'first_options'  => ['attr' => [
                    'placeholder' => 'Password',
                    'class' => 'form-control form-control-xl'
                ]],
                'second_options' =>  ['attr' => [
                    'placeholder' => 'Confirm Password',
                    'class' => 'form-control form-control-xl'
                ]],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            // 'validation_groups' => $this->registrationResolver,
        ]);
    }
}
