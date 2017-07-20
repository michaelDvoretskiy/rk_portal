<?php

namespace KvintBundle\Form;

use KvintBundle\Entity\KvintListedEntities;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
                'filial',
                TextType::class,
                [
                    'label' => 'Код филиала',
                    'required' => false,
                ]
            )
            ->add(
                'ediniyNalog',
                CheckboxType::class,
                [
                    'label' => 'Единый налог',
                    'required' => false,
                ]
            )
            ->add(
                'fisLitso',
                CheckboxType::class,
                [
                    'label' => 'Физ.лицо',
                    'required' => false,
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'e-mail',
                    'required' => false,
                ]
            )
            ->add(
                'priceNum',
                ChoiceType::class,
                [
                    'label' => 'Цена по умолчанию',
                    'choices' => array_merge([ 'Нет' => '0',], KvintListedEntities::Prices()),
                ]
            )
            ->add(
                'dogovorNumber',
                TextType::class,
                [
                    'label' => 'Номер',
                    'required' => false,
                ]
            )
            ->add(
                'dogovorData',
                DateType::class,
                [
                    'label' => 'Дата',
                    'required' => false,
                    'widget' => 'single_text',
                    'html5' => false,
                    'attr' => ['class' => 'js-datepicker'],
                    'property_path' => 'dogovorDate',
                ]
            )
//            ->add(
//                'dogovorData',
//                TextType::class,
//                [
//                    'label' => 'Дата',
//                    'required' => false,
//                    'attr' => ['class' => 'js-datepicker'],
//                ]
//            )
            ->add(
                'dogovorType',
                TextType::class,
                [
                    'label' => 'Вид',
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
