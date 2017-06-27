<?php

namespace KvintBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkladType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
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
//                    'property_path' => 'kod',
                    'attr' => [
                        'placeholder' => '0',
//                        'readonly' => true,
                        'disabled' => true,
                    ],
                ]
            )
            ->add(
                'sname',
                TextType::class,
                [
                    'label' => 'Название',
                    'attr' => [
                        'placeholder' => 'Склад',
                    ],
                ]
            )
            ->add(
                'rozn',
                CheckboxType::class,
                [
                    'label' => 'Розничный',
                    'required' => false,
                ]
            )
            ->add(
                'obpRozn',
                CheckboxType::class,
                [
                    'label' => 'Общепит',
                    'required' => false,
                ]
            )
            ->add(
                'autoClose',
                ChoiceType::class,
                [
                    'label' => 'Автозакрытие',
                    'choices' => [
                        'Нет' => "F",
                        'Обычное' => "T",
                        'Общепит' => "O",
                    ],
                ]
            )
            ->add(
                'entKod',
                EntityType::class,
                [
                    'label' => 'Организация',
                    'class' => 'KvintBundle\Entity\Ent',
                    'choice_label' => 'name',
                ]
            )
            ->add(
                'zoneKod',
                EntityType::class,
                [
                    'label' => 'Торговая зона',
                    'class' => 'KvintBundle\Entity\TradeZone',
                    'choice_label' => 'name',
                ]
            )
            ->add(
                'ok',
                SubmitType::class
            );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'KvintBundle\Entity\Sklad'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'kvintbundle_sklad';
    }


}
