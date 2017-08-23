<?php

namespace KvintBundle\Form;

use Doctrine\ORM\EntityRepository;
use KvintBundle\Entity\KvintListedEntities;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
                'groupTovar',
                EntityType::class,
                [
                    'label' => 'Группа товара',
                    'class' => 'KvintBundle\Entity\GroupTovar',
                    'choice_label' => function ($groupTovar) {
                        return $groupTovar->getFullName();
                    },
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('g')
                            ->orderBy('g.gname', 'ASC')
                            ->addOrderBy('g.gname2', 'ASC');
                    },
                ]
            )
            ->add(
                'fasov',
                TextType::class,
                [
                    'label' => 'Фасовка',
                    'attr' => [
                        'placeholder' => 'ед.',
                    ],
                ]
            )
            ->add(
                'price1',
                NumberType::class,
                [
                    'scale' => 2,
                    'label' => 'Цена ' . array_search(1, KvintListedEntities::Prices()),
                    'required' => false,
                ]
            )
            ->add(
                'price2',
                NumberType::class,
                [
                    'scale' => 2,
                    'label' => 'Цена ' . array_search(2, KvintListedEntities::Prices()),
                    'required' => false,
                ]
            )
            ->add(
                'price3',
                NumberType::class,
                [
                    'scale' => 2,
                    'label' => 'Цена ' . array_search(3, KvintListedEntities::Prices()),
                    'required' => false,
                ]
            )
            ->add(
                'price4',
                NumberType::class,
                [
                    'scale' => 2,
                    'label' => 'Цена ' . array_search(4, KvintListedEntities::Prices()),
                    'required' => false,
                ]
            )
            ->add(
                'price5',
                NumberType::class,
                [
                    'scale' => 2,
                    'label' => 'Цена ' . array_search(5, KvintListedEntities::Prices()),
                    'required' => false,
                ]
            )
            ->add(
                'price6',
                NumberType::class,
                [
                    'scale' => 2,
                    'label' => 'Цена ' . array_search(6, KvintListedEntities::Prices()),
                    'required' => false,
                ]
            )
            ->add(
                'groupNalog',
                EntityType::class,
                [
                    'label' => 'Налоговая группа',
                    'class' => 'KvintBundle\Entity\GroupNalog',
                    'choice_label' => 'name',
                ]
            )
            ->add(
                'idScan',
                TextType::class,
                [
                    'label' => 'Штрих-код',
                ]
            )
            ->add(
                'active',
                CheckboxType::class,
                [
                    'label' => 'Активный',
                    'required' => false,
                ]
            )
            ->add(
                'kvedRight',
                CheckboxType::class,
                [
                    'label' => 'КВЕД верный',
                    'required' => false,
                ]
            )
            ->add(
                'import',
                CheckboxType::class,
                [
                    'label' => 'Импортный',
                    'required' => false,
                ]
            )
            ->add(
                'kved',
                TextType::class,
                [
                    'label' => 'КВЭД',
                ]
            )
            ->add(
                'dopName',
                TextType::class,
                [
                    'label' => 'Дополнительно',
                ]
            )
            ->add(
                'optQuantity',
                NumberType::class,
                [
                    'scale' => 3,
                    'label' => 'Опт. кол-во',
                    'required' => false,
                ]
            )
            ->add(
                'minQuantity',
                NumberType::class,
                [
                    'scale' => 3,
                    'label' => 'Мин. кол-во',
                    'required' => false,
                ]
            )
            ->add(
                'weight',
                NumberType::class,
                [
                    'scale' => 3,
                    'label' => 'Вес',
                    'required' => false,
                ]
            )
            ->add(
                'volume',
                NumberType::class,
                [
                    'scale' => 3,
                    'label' => 'Объем',
                    'required' => false,
                ]
            )
            ->add(
                'quantityInPack',
                NumberType::class,
                [
                    'scale' => 3,
                    'label' => 'Кол-во в упак.',
                    'required' => false,
                ]
            )
            ->add(
                'returntara',
                CheckboxType::class,
                [
                    'label' => 'Возвратная тара',
                    'required' => false,
                ]
            )
            ->add(
                'unReturnTara',
                CheckboxType::class,
                [
                    'label' => 'Невозвратная тара',
                    'required' => false,
                ]
            )
            ->add(
                'makedProduction',
                CheckboxType::class,
                [
                    'label' => 'Готовая продукция',
                    'required' => false,
                ]
            )
            ->add(
                'weightTovar',
                CheckboxType::class,
                [
                    'label' => 'Весовой товар',
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