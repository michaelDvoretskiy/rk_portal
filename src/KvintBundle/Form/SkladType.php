<?php

namespace KvintBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
