<?php

namespace KvintBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class KlientType extends AbstractType
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
                'kname',
                TextType::class,
                [
                    'label' => 'Наименование',
                    'attr' => [
                        'placeholder' => 'Клиент',
                    ],
                ]
            )
            ->add(
                'fullName',
                TextType::class,
                [
                    'label' => 'Полное наименование',
                    'attr' => [
                        'placeholder' => 'Полное наименование клиента',
                    ],
                    'required' => false,
                ]
            )
            ->add(
                'inn',
                TextType::class,
                [
                    'label' => 'Индивидуальный налоговый номер',
                    'attr' => [
                        'placeholder' => 'ИНН',
                    ],
                    'required' => false,
                ]
            )
            ->add(
                'address',
                TextType::class,
                [
                    'label' => 'Адрес',
                    'required' => false,
                ]
            )
            ->add(
                'telephone',
                TextType::class,
                [
                    'label' => 'Телефон',
                    'required' => false,
                ]
            )
            ->add(
                'bank_name',
                TextType::class,
                [
                    'label' => 'Банк',
                    'required' => false,
                ]
            )
            ->add(
                'bank_okpo',
                TextType::class,
                [
                    'label' => 'ОКПО',
                    'required' => false,
                ]
            )
            ->add(
                'bank_mfo',
                TextType::class,
                [
                    'label' => 'МФО',
                    'required' => false,
                ]
            )
            ->add(
                'bank_schet',
                TextType::class,
                [
                    'label' => 'Счет',
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
            'data_class' => 'KvintBundle\Entity\Klient'
        ));
    }

    public function getBlockPrefix()
    {
        return 'kvint_bundle_klient_type';
    }
}
