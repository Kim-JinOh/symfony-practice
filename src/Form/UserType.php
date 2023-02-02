<?php

namespace App\Form;

use App\Entity\User;
use App\Form\Type\AddressType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ])
            ->add('mobileNumber', TextType::class,[
                'attr' => [
                    'placeholder' => 'Mobile Number',
                    'class' => 'form-control form-control-xl'
                ]
            ])
            ->add('address', AddressType::class, [
                'required' => false,
                'address_options'  => ['attr' => [
                    'placeholder' => 'Address',
                    'class' => 'form-control form-control-xl'
                ]],
                'detail_options' =>  ['attr' => [
                    'placeholder' => 'Address Detail',
                    'class' => 'form-control form-control-xl'
                ]],
                'postCode_options' =>  ['attr' => [
                    'placeholder' => 'Post Code',
                    'class' => 'form-control form-control-xl'
                ]],
            ]);
        // ->add('address', FullAddressType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            // 'validation_groups' => $this->registrationResolver,
        ]);
    }
}
