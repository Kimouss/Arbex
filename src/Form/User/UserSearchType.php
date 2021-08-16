<?php

namespace App\Form\User;

use App\Entity\Tag\AffiliationGroupTag;
use App\Entity\Tag\AvailabilityTag;
use App\Entity\Tag\ParentPublicationTag;
use App\Entity\Tag\PublicationTag;
use App\Entity\Tag\TrainingStageTag;
use App\Repository\Tag\PublicationTagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSearchType extends AbstractType
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parent_tag', EntityType::class, [
                'class' => ParentPublicationTag::class,
                'multiple' => false,
            ])
            ->add('publication', EntityType::class, [
                'class' => PublicationTag::class,
                'multiple' => true,
                'expanded' => true,
            ])
        ;

        $formModifier = function (FormInterface $form, $parentTag) use ($options) {
            if ($parentTag) {
                $form
                    ->add('publication', ChoiceType::class, [
                        'choices' => $this->entityManager->getRepository(PublicationTag::class)->findBy(['parent' => $parentTag]),
                        'choice_label' => function ($choice) {
                            return $choice->getTitle();
                        },
                        'multiple' => true,
                        'expanded' => true,
                    ]);
            }
        };

        $builder
            ->add('affiliation_group', EntityType::class, [
                'class' => AffiliationGroupTag::class,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('training_stage', EntityType::class, [
                'class' => TrainingStageTag::class,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('availability', EntityType::class, [
                'class' => AvailabilityTag::class,
                'multiple' => true,
                'expanded' => true,
            ])
            ->setMethod('GET')
            ->getForm()
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $formModifier($event->getForm(), $event->getData());
            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                $formModifier($event->getForm(), $data['parent_tag'] ?? null);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
