<?php

namespace KvintBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntType extends AbstractType
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
                'name',
                TextType::class,
                [
                    'label' => 'Название',
                    'attr' => [
                        'placeholder' => 'Организация',
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
            'data_class' => 'KvintBundle\Entity\Ent',
        ));
    }

    public function getBlockPrefix()
    {
        return 'kvint_bundle_ent_type';
    }
}
