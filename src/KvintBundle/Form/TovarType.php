<?php

namespace KvintBundle\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use KvintBundle\Entity\KvintListedEntities;
use KvintBundle\Entity\Tovar;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TovarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        dump($builder->getData());
        dump($builder->getData()->getKod());
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
//                        'disabled' => true,
                        'readonly' => true,
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
                    'required' => false,
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
                    'required' => false,
                ]
            )
            ->add(
                'dopName',
                TextType::class,
                [
                    'label' => 'Дополнительно',
                    'required' => false,
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
                'tovarOfFasovka',
                ChoiceType::class,
                [
                    'choices' =>  [(is_null($builder->getData()->getTovarOfFasovka())) ? (new Tovar())->initEmptyForChoice() : $builder->getData()->getTovarOfFasovka()],
                    'choice_label' => 'tname',
                    'choice_value' => function($v) {
                        if ($v instanceof Tovar) {
                            return $v->getKod();
                        }
                        if (count($v)) {
                            return $v[0]->getKod();
                        }
                        return -1;
                    },
                    'label' => 'Товар фасовки ',
                ]
            )
            ->add(
                'quantityOfFasovka',
                NumberType::class,
                [
                    'scale' => 3,
                    'label' => 'Кол-во расфасовки',
                    'required' => false,
                ]
            )
            ->add(
                'excludedFromExtra',
                CheckboxType::class,
                [
                    'label' => 'исключить из автонаценки',
                    'required' => false,
                ]
            )
            ->add(
                'fiscal',
                CheckboxType::class,
                [
                    'label' => 'фискальный',
                    'required' => false,
                ]
            )
            ->add(
                'discountForbidden',
                CheckboxType::class,
                [
                    'label' => 'запретить диск.скидку',
                    'required' => false,
                ]
            )
            ->add(
                'additionalInfo',
                TextareaType::class,
                [
                    'label' => 'Доп.информация',
                    'required' => false,
                ]
            )
            ->add(
                'manufacturerExtra',
                CheckboxType::class,
                [
                    'label' => 'наценка от произв.',
                    'required' => false,
                ]
            )
            ->add(
                'underExciseIndicative',
                CheckboxType::class,
                [
                    'label' => 'подакцизный индикатев',
                    'required' => false,
                ]
            )
            ->add(
                'excise',
                CheckboxType::class,
                [
                    'label' => 'акцизный товар',
                    'required' => false,
                ]
            )
            ->add(
                'manufacturerPrice',
                NumberType::class,
                [
                    'scale' => 3,
                    'label' => 'Цена производителя',
                    'required' => false,
                ]
            )
            ->add(
                'manufacturerMaxExtra',
                NumberType::class,
                [
                    'scale' => 3,
                    'label' => 'Макс. % наценки',
                    'required' => false,
                ]
            )
            ->add(
                'minimalPrice',
                NumberType::class,
                [
                    'scale' => 2,
                    'label' => 'Минимальная цена',
                    'required' => false,
                ]
            )
            ->add(
                'ok',
                SubmitType::class
            );
//        $builder->get('tovarOfFasovka')->resetViewTransformers();

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,

            function (FormEvent $event) use ($options) {
                $form = $event->getForm();
                $data = $event->getData();
                if ($form->has('tovarOfFasovka') && isset($data['tovarOfFasovka'])) {
                    $form->remove('tovarOfFasovka');
                    $form->add(
                        'tovarOfFasovka',
                        ChoiceType::class,
                        [
                            'choices' =>  [($data['tovarOfFasovka'] == "0") ? (new Tovar())->initEmptyForChoice() : $options['em']->getRepository('KvintBundle:Tovar')->findByKod((int)$data['tovarOfFasovka'])],
                            'choice_label' => 'tname',
                            'choice_value' => function($v) {
                                if ($v instanceof Tovar) {
                                    return $v->getKod();
                                }
                                if (count($v)) {
                                    return $v[0]->getKod();
                                }
                                return -1;
                            },
                            'label' => 'Товар фасовки ',
                        ]
                    );
                }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'KvintBundle\Entity\Tovar',
            'em' => null,
        ));
    }

    public function getBlockPrefix()
    {
        return 'kvint_bundle_tovar_type';
    }
}