<?php

namespace App\Form\Type;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $mustOptions = ['required' => $options['required']];
        $builder
            ->add('address', TextType::class, array_merge($mustOptions, $options['options'], $options['address_options']))
            ->add('detail', TextType::class, array_merge($mustOptions, $options['options'], $options['detail_options']))
            ->add('postCode', TextType::class, array_merge($mustOptions, $options['options'], $options['postCode_options']));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
            'required' => false,
            'options' => [],
            'address_options' => [],
            'detail_options' => [],
            'postCode_options' => [],
            'invalid_message' => function (Options $options, $previousValue) {
                return ($options['legacy_error_messages'] ?? true)
                    ? $previousValue
                    : 'The values do not match.';
            },
        ]);

        $resolver->setAllowedTypes('options', 'array');
        $resolver->setAllowedTypes('address_options', 'array');
        $resolver->setAllowedTypes('detail_options', 'array');
        $resolver->setAllowedTypes('postCode_options', 'array');
    }
}
