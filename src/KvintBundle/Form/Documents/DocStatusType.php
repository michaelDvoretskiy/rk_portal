<?php

namespace KvintBundle\Form\Documents;

use KvintBundle\Entity\KvintListedEntities;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocStatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'kod',
                HiddenType::class
            )
            ->add(
                'status',
                ChoiceType::class,
                [
                    'label' => 'Состояние',
                    'choices' => KvintListedEntities::DocStatuses(),
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'KvintBundle\Entity\Documents\GoodsMovingDocument',
            'em' => null,
        ));
    }

    public function getBlockPrefix()
    {
        return 'kvint_bundle_document_status_type';
    }
}