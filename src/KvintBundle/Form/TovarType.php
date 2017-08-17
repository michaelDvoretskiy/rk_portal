<?php

namespace KvintBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TovarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'kod',
                IntegerType::class,
                [
                    'label' => 'Код',
                    'mapped' => false,
                    'data' => $builder->getData()->getKod(),
                    'attr' => [
                        'placeholder' => '0',
                        'disabled' => true,
                    ],
                ]
            )
            ->add(
                'tname',
                TextType::class,
                [
                    'label' => 'Наименование',
                    'attr' => [
                        'placeholder' => 'Наименование',
                    ],
                ]
            )
            ->add(
                'flagAutoExtraCharge1',
                CheckboxType::class,
                [
                    'label' => 'Автонаценка (' . array_search(1, KvintListedEntities::Prices()) . ")",
                    'required' => false,
                ]
            )
            ->add(
                'percentAutoExtraCharge1',
                NumberType::class,
                [
                    'scale' => 2,
                    'label' => 'Процент автонаценки (' . array_search(1, KvintListedEntities::Prices()) . ")",
                    'required' => false,
                ]
            )
            ->add(
                'flagAutoExtraCharge2',
                CheckboxType::class,
                [
                    'label' => 'Автонаценка (' . array_search(2, KvintListedEntities::Prices()) . ")",
                    'required' => false,
                ]
            )
            ->add(
                'percentAutoExtraCharge2',
                NumberType::class,
                [
                    'scale' => 2,
                    'label' => 'Процент автонаценки (' . array_search(2, KvintListedEntities::Prices()) . ")",
                    'required' => false,
                ]
            )
            ->add(
                'flagAutoExtraCharge3',
                CheckboxType::class,
                [
                    'label' => 'Автонаценка (' . array_search(3, KvintListedEntities::Prices()) . ")",
                    'required' => false,
                ]
            )
            ->add(
                'percentAutoExtraCharge3',
                NumberType::class,
                [
                    'scale' => 2,
                    'label' => 'Процент автонаценки (' . array_search(3, KvintListedEntities::Prices()) . ")",
                    'required' => false,
                ]
            )
            ->add(
                'flagAutoExtraCharge4',
                CheckboxType::class,
                [
                    'label' => 'Автонаценка (' . array_search(4, KvintListedEntities::Prices()) . ")",
                    'required' => false,
                ]
            )
            ->add(
                'percentAutoExtraCharge4',
                NumberType::class,
                [
                    'scale' => 2,
                    'label' => 'Процент автонаценки (' . array_search(4, KvintListedEntities::Prices()) . ")",
                    'required' => false,
                ]
            )
            ->add(
                'flagAutoExtraCharge5',
                CheckboxType::class,
                [
                    'label' => 'Автонаценка (' . array_search(5, KvintListedEntities::Prices()) . ")",
                    'required' => false,
                ]
            )
            ->add(
                'percentAutoExtraCharge5',
                NumberType::class,
                [
                    'scale' => 2,
                    'label' => 'Процент автонаценки (' . array_search(5, KvintListedEntities::Prices()) . ")",
                    'required' => false,
                ]
            )
            ->add(
                'flagAutoExtraCharge6',
                CheckboxType::class,
                [
                    'label' => 'Автонаценка (' . array_search(6, KvintListedEntities::Prices()) . ")",
                    'required' => false,
                ]
            )
            ->add(
                'percentAutoExtraCharge6',
                NumberType::class,
                [
                    'scale' => 2,
                    'label' => 'Процент автонаценки (' . array_search(6, KvintListedEntities::Prices()) . ")",
                    'required' => false,
                ]
            )
            ->add(
                'ok',
                SubmitType::class
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'KvintBundle\Entity\Tovar',
        ));
    }

    public function getBlockPrefix()
    {
        return 'kvint_bundle_tovar_type';
    }
}
