<?php

namespace PortalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TranscoNatureOpeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('workType')
            ->add('gammeGroup')
            ->add('counter')
            ->add('purpose')
            ->add('natureInterCode')
            ->add('programmingMode')
            ->add('segmentationName')
            ->add('segmentationValue')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PortalBundle\Entity\TranscoNatureOpe',
            'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return '';
    }
}
