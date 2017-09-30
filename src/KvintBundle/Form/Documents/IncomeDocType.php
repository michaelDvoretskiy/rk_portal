<?php

namespace KvintBundle\Form\Documents;

use Doctrine\ORM\EntityRepository;
use KvintBundle\Entity\Catalogs\Manager;
use KvintBundle\Entity\Klient;
use KvintBundle\Entity\KvintListedEntities;
use KvintBundle\Repository\SkladRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IncomeDocType extends AbstractType
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
                        'readonly' => true,
                    ],
                ]
            )
            ->add(
                'number',
                TextType::class,
                [
                    'label' => 'Номер',
                    'attr' => [
                        'placeholder' => 'Номер',
                    ],
                ]
            )
            ->add(
                'docDate',
                DateType::class,
                [
                    'label' => 'Дата',
                    'required' => false,
                    'widget' => 'single_text',
                    'format' => 'dd.MM.yyyy',
                    'attr' => [
                        'class' => 'form-control input-inline datepicker',
                        'data-provide' => 'datepicker',
                        'data-date-format' => 'dd.mm.yyyy',
                        'data-date-autoclose' => true,
                        'data-date-today-highlight' => true,
                    ],
//                    'property_path' => 'docDate',
                ]
            )
            ->add(
                'wareHouse',
                EntityType::class,
                [
                    'label' => 'Склад',
                    'class' => 'KvintBundle\Entity\Sklad',
                    'choice_label' => 'sname',
                    'query_builder' => function (SkladRepository $er) {
                        return $er->createQueryBuilder('s')
                            ->orderBy('s.sname', 'ASC');
                    },
                ]
            )
            ->add(
                'customer',
                ChoiceType::class,
                [
                    'choices' =>  [(is_null($builder->getData()->getCustomer())) ? (new Klient())->initEmptyForChoice() : $builder->getData()->getCustomer()],
                    'choice_label' => 'kname',
                    'choice_value' => function($v) {
                        if (is_null($v)) {
                            $v = (new Klient())->initEmptyForChoice();
                        }
                        return $v->getKod();
                    },
                    'label' => 'Клиент ',
                    'data' => $builder->getData()->getCustomer(),
                    'empty_data' => (new Klient())->initEmptyForChoice(),
                ]
            )
            ->add(
                'manager',
                ChoiceType::class,
                [
                    'choices' =>  $options['em']->getRepository('KvintBundle:Catalogs\Manager')->getManagersWithEmpty(),
                    'choice_label' => 'name',
                    'choice_value' => function($v) {
                        if (is_null($v)) {
                            $v = (new Manager())->initEmptyForChoice();
                        }
                        return $v->getKod();
                    },
                    'label' => 'Менеджер',
//                    'data' => $data2,
                ]
            )
//            ->add(
//                'manager',
//                EntityType::class,
//                [
//                    'label' => 'Менеджер',
//                    'class' => 'KvintBundle\Entity\Catalogs\Manager',
//                    'choice_label' => 'name',
//                    'query_builder' => function (EntityRepository $er) {
//                        return $er->createQueryBuilder('m')
//                            ->orderBy('m.name', 'ASC');
//                    },
//                ]
//            )
            ->add(
                'allowedToPass',
                CheckboxType::class,
                [
                    'label' => 'Разрешено к проводке',
                    'required' => false,
                ]
            )
            ->add(
                'digitalInput',
                CheckboxType::class,
                [
                    'label' => 'Электронная накладная',
                    'required' => false,
                ]
            )
            ->add(
                'salesPriceNeedUpdate',
                CheckboxType::class,
                [
                    'label' => 'Изменение отпускных цен',
                    'required' => false,
                ]
            )
            ->add(
                'sumOfCostPrice',
                NumberType::class,
                [
                    'scale' => 2,
                    'label' => 'Сумма учетная',
                    'required' => false,
                    'attr' => [
                        'readonly' => true,
                    ],
                ]
            )
            ->add(
                'sumOfNDS',
                NumberType::class,
                [
                    'scale' => 2,
                    'label' => 'Сумма НДС',
                    'required' => false,
                    'attr' => [
                        'readonly' => true,
                    ],
                ]
            )
            ->add(
                'sumOfTara',
                NumberType::class,
                [
                    'scale' => 2,
                    'label' => 'Сумма тары',
                    'required' => false,
                    'attr' => [
                        'readonly' => true,
                    ],
                ]
            )
            ->add(
                'sumOfSalePrice',
                NumberType::class,
                [
                    'scale' => 2,
                    'label' => 'Итого по накладной',
                    'required' => false,
                    'attr' => [
                        'readonly' => true,
                    ],
                ]
            )
            ->add(
                'sumOfFare',
                NumberType::class,
                [
                    'scale' => 2,
                    'label' => 'Транспортные расходы',
                    'required' => false,
                ]
            )
            ->add(
                'basis',
                TextType::class,
                [
                    'label' => 'Основание',
                    'required' => false,
                ]
            )
            ->add(
                'proxyPerson',
                TextType::class,
                [
                    'label' => 'Через',
                    'required' => false,
                ]
            )
            ->add(
                'proxyPaper',
                TextType::class,
                [
                    'label' => 'Доверенность',
                    'required' => false,
                ]
            )
            ->add(
                'hiddenDoc',
                CheckboxType::class,
                [
                    'label' => 'Скрытый',
                    'required' => false,
                ]
            )
            ->add(
                'innerDocument',
                CheckboxType::class,
                [
                    'label' => 'Внутренний',
                    'required' => false,
                ]
            )
            ->add(
                'termOfPayment',
                DateType::class,
                [
                    'label' => 'Срок оплаты',
                    'required' => false,
                    'widget' => 'single_text',
                    'format' => 'dd.MM.yyyy',
                    'attr' => [
                        'class' => 'form-control input-inline datepicker',
                        'data-provide' => 'datepicker',
                        'data-date-format' => 'dd.mm.yyyy',
                        'data-date-autoclose' => true,
                        'data-date-today-highlight' => true,
                    ],
                ]
            )
            ->add(
                'ok',
                SubmitType::class
            );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($options) {
                $form = $event->getForm();
                $data = $event->getData();
                if ($form->has('customer')) {
                    if (!isset($data['customer'])) {
                        $data['customer'] = 0;
                    }
                    $form->remove('customer');
                    $form->add(
                        'customer',
                        ChoiceType::class,
                        [
                            'choices' =>  [($data['customer'] == "0" || is_null($data['customer'])) ? (new Klient())->initEmptyForChoice() : $options['em']->getRepository('KvintBundle:Klient')->findByKod((int)$data['customer'])],
                            'choice_label' => 'kname',
                            'choice_value' => function($v) {
                                if (is_null($v)) {
                                    $v = (new Klient())->initEmptyForChoice();
                                }
                                return $v->getKod();
                            },
                            'label' => 'Клиент ',
                        ]
                    );
                }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'KvintBundle\Entity\Documents\IncomeDocument',
            'em' => null,
        ));
    }

    public function getBlockPrefix()
    {
        return 'kvint_bundle_income_document_type';
    }
}