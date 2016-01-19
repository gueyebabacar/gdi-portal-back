<?php

namespace TranscoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TranscoOpticType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codeTypeOptic')
            ->add('opticLabel')
            ->add('codeNatInter')
            ->add('labelNatInter')
            ->add('segmentationCode')
            ->add('segmentationLabel')
            ->add('finalCode')
            ->add('finalLabel')
            ->add('shortLabel')
            ->add('programmingMode')
            ->add('calibre')
            ->add('gmaos')
            ->add('disco')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TranscoBundle\Entity\TranscoOptic',
            'csrf_protection' => false
        ));
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
