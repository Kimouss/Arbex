<?php

namespace App\Form\Tag;

use App\Entity\Tag\ParentPublicationTag;
use App\Entity\Tag\PublicationTag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class PublicationTagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parent', EntityType::class, [
                'class' => ParentPublicationTag::class,
                'constraints' => [
                    new Assert\NotNull(),
                ],
                'required' => true,
            ])
            ->add('title', TextType::class, [
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PublicationTag::class,
        ]);
    }
}
