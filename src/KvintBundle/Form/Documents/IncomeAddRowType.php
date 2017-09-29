<?php

namespace KvintBundle\Form\Documents;

use Doctrine\ORM\EntityRepository;
use KvintBundle\Entity\Catalogs\Manager;
use KvintBundle\Entity\Klient;
use KvintBundle\Entity\Tovar;
use KvintBundle\Repository\SkladRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotEqualTo;

class IncomeAddRowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'id',
                HiddenType::class
            )
            ->add(
                'activeFlg',
                CheckboxType::class,
                [
                    'label' => 'Активный',
                    'mapped' => false,
                    'data' => true,
                    'required' => false,
                ]
            )
            ->add(
                'tovar',
                ChoiceType::class,
                [
                    'choices' =>  [(is_null($builder->getData()->getTovar())) ? (new Tovar())->initEmptyForChoice() : $builder->getData()->getTovar()],
                    'choice_label' => 'tname',
                    'choice_value' => function($v) {
                        return $v->getKod();
                    },
                    'label' => 'Товар',
                ]
            )
            ->add(
                'supplier',
                ChoiceType::class,
                [
                    'choices' => [$builder->getData()->getSupplier()],
                    'choice_label' => 'kname',
                    'choice_value' => function($v) {
                        return $v->getKod();
                    },
                    'label' => 'Поставщик',
                    'attr' => [
                        'readonly' => true,
                    ],
                ]
            )
            ->add(
                'incomeQuantity',
                NumberType::class,
                [
                    'scale' => 3,
                    'label' => 'Количество',
                    'required' => false,
                ]
            )
            ->add(
                'costPrice',
                NumberType::class,
                [
                    'scale' => 6,
                    'label' => 'Цена учетная',
                    'required' => false,
                ]
            );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,

            function (FormEvent $event) use ($options) {
                $form = $event->getForm();
                $data = $event->getData();
                if ($form->has('tovar') && isset($data['tovar'])) {
                    $form->remove('tovar');
                    $form->add(
                        'tovar',
                        ChoiceType::class,
                        [
                            'choices' =>  [($data['tovar'] == 0) ? (new Tovar())->initEmptyForChoice() : $options['em']->getRepository('KvintBundle:Tovar')->findByKod((int)$data['tovar'])],
                            'choice_label' => 'tname',
                            'choice_value' => function($v) {
                                return $v->getKod();
                            },
                            'label' => 'Товар',
                            'constraints' => [
                                new NotEqualTo(
                                    [
                                        'value' => (new Tovar())->initEmptyForChoice(),
                                    ]
                                )
                            ],
                        ]
                    );
                }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'KvintBundle\Entity\Documents\DocRow',
            'em' => null,
        ));
    }

    public function getBlockPrefix()
    {
        return 'kvint_bundle_income_row_add_type';
    }
}