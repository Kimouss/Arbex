<?php

namespace App\Form\User;

use App\Entity\User\User;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('identity', IdentityType::class)
            ->add('roles', ChoiceType::class, [
                'choices' => User::ARRAY_ROLES,
                'multiple' => false,
                'expanded' => true,
                'label' => 'form.roles',
                'translation_domain' => 'form',
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            ->add('roles')
            ->add('profile', CKEditorType::class, [
                'required' => false,
                'config_name' => 'main_config',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
