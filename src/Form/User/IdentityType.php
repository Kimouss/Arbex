<?php

namespace App\Form\User;

use App\Entity\User\Identity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class IdentityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', ChoiceType::class, [
                'choices' => ['Mme' => Identity::GENDER_FEMALE, Identity::GENDER_MALE => Identity::GENDER_MALE],
                'multiple' => false,
                'expanded' => true,
                'data' => Identity::GENDER_FEMALE,
                'label' => 'form.civility',
                'translation_domain' => 'form',
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'form.lastname',
                'translation_domain' => 'form',
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'form.firstname',
                'translation_domain' => 'form',
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            ->add('birthdate', DateType::class, [
                'label' => 'form.birthdate',
                'translation_domain' => 'form',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Identity::class,
        ]);
    }
}
