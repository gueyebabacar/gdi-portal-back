<?php

namespace PortalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TranscoNatureInterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('opticNatCode')
            ->add('opticSkill')
            ->add('opticNatLabel')
            ->add('pictrelNatOpCode')
            ->add('pictrelNatOpLabel')
            ->add('troncatedPictrelNatOpLabel')
            ->add('app')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PortalBundle\Entity\TranscoNatureInter'
        ));
    }
}
