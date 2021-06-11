<?php

namespace App\Form\User;

use App\Entity\User\User;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('identity', IdentityType::class)
            ->add('isActive')
            ->add('roles', ChoiceType::class, [
                'choices' => User::ARRAY_ROLES,
                'multiple' => true,
                'expanded' => true,
                'label' => 'form.roles',
                'translation_domain' => 'form',
            ])
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
