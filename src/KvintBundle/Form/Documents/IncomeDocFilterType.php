<?php

namespace KvintBundle\Form\Documents;

use KvintBundle\Entity\GroupTovar;
use KvintBundle\Entity\Klient;
use KvintBundle\Entity\Sklad;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IncomeDocFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $beginDate = $options['beginDate'];
        if (is_null($beginDate)) {
            $beginDate = new \DateTime();
        }
        $endDate = $options['endDate'];
        if (is_null($endDate)) {
            $endDate = new \DateTime();
        }

        $wareHouses = $options['em']->getRepository('KvintBundle:Sklad')->getListWithAllFirst();
        $wareHouse = $options['wareHouse'];
        if (is_null($wareHouse)) {
            $wareHouse = $wareHouses[0];
        }

        $customer =  $options['customer'];
        $customers = [(is_null($customer)) ? (new Klient())->initEmptyForChoice() : $customer];


        $builder
//            ->add(
//            'beginDate',
//            DateType::class,
//                [
//                    'label' => 'С',
//                    'data' => $beginDate,
//                    'required' => false,
//                    'widget' => 'single_text',
//                    'html5' => false,
//                    'attr' => [
//                        'class' => 'js-datepicker',
//                    ],
//                ]
//            )
            ->add(
                'beginDate',
                DateType::class,
                    [
                        'label' => 'С',
                        'data' => $beginDate,
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
                'endDate',
                DateType::class,
                [
                    'label' => 'По',
                    'data' => $endDate,
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
                'wareHouse',
                ChoiceType::class,
                [
                    'choices' =>  $wareHouses,
                    'choice_label' => 'sname',
                    'choice_value' => function($v) {
                        if ($v instanceof Sklad) {
                            return $v->getKod();
                        }
                        if (count($v)) {
                            return $v[0]->getKod();
                        }
                        return -1;
                    },
                    'label' => 'Склад ',
                    'data' => $wareHouse,
                ]
            )
            ->add(
                'customer',
                ChoiceType::class,
                [
                    'choices' =>  $customers,
                    'choice_label' => 'kname',
                    'choice_value' => function($v) {
                        if ($v instanceof Klient) {
                            return $v->getKod();
                        }
                        if (count($v)) {
                            return $v[0]->getKod();
                        }
                        return -1;
                    },
                    'label' => 'Клиент ',
                    'data' => $customer,
                ]
            )
            ->add(
                'ok',
                ButtonType::class,
                [
                    'attr' => [
                        'class' => 'btn-bottom',
                    ],
                ]
            );;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'em' => null,
            'beginDate' => null,
            'endDate' => null,
            'wareHouse' => null,
            'customer' => null,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'kvint_bundle_group_tovar_list_type';
    }
}
