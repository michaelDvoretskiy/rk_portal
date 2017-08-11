<?php

namespace KvintBundle\Form;

use KvintBundle\Entity\GroupTovar;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupTovarListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $groupList =  $options['em']->getRepository('KvintBundle:GroupTovar')->getGroupsWithAllFirst();
        $data = $groupList[0];
        if (!is_null($options['grp'])) {
            $data = $options['em']->getRepository('KvintBundle:GroupTovar')->findByKod((int)$options['grp']);
            if (is_null($data)) {
                $data = $groupList[0];
            }
        }
//        dump($data);
        $builder
            ->add(
                'groupFilter',
                ChoiceType::class,
                [
//                    'class' => 'KvintBundle\Entity\GroupTovar',
                    'choices' =>  $groupList,
                    'choice_label' => 'gname',
                    'choice_value' => function($v) {
                        if ($v instanceof GroupTovar) {
                            return $v->getKod();
                        }
                        if (count($v)) {
                            return $v[0]->getKod();
                        }
                        return -1;
                    },
                    'label' => 'Группа ',
                    'data' => $data,
                ]
            );
//        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
    }

//    function onPreSetData(FormEvent $event) {
//        dump(new \DateTime());
//        dump($event);
//    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'em' => null,
            'grp' => null,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'kvint_bundle_group_tovar_list_type';
    }
}
