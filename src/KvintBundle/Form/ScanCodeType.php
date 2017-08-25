<?php

namespace KvintBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScanCodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'idScan',
                TextType::class,
                [
                    'label' => 'Штрих-код',
                ]
            )
            ->add(
                'quantity',
                NumberType::class
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'KvintBundle\Entity\ScanCode',
        ));
    }

    public function getBlockPrefix()
    {
        return 'kvint_bundle_scan_code_type';
    }
}
