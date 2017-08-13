<?php

namespace KvintBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupTovarType extends AbstractType
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
                'gname',
                TextType::class,
                [
                    'label' => 'Наименование',
                    'attr' => [
                        'placeholder' => 'Группа',
                    ],
                ]
            )
            ->add(
                'gname2',
                TextType::class,
                [
                    'label' => 'Наименование',
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Подгруппа',
                    ],
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
            'data_class' => 'KvintBundle\Entity\GroupTovar',
        ));
    }

    public function getBlockPrefix()
    {
        return 'kvint_bundle_group_tovar_type';
    }
}
