<?php

namespace App\Form\Publication;

use App\Entity\Publication;
use App\Entity\Tag\PublicationTag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('url')
            ->add('description')
            ->add('createdAt', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('publicationTags', EntityType::class, [
                'class' => PublicationTag::class,
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
