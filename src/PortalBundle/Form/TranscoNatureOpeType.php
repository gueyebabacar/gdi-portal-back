<?php

namespace PortalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('workType', TextType::class)
            ->add('gammeGroup', TextType::class)
            ->add('counter', TextType::class)
            ->add('purpose', TextType::class)
            ->add('natureInterCode', TextType::class)
            ->add('programmingMode', TextType::class)
            ->add('segmentationName', TextType::class)
            ->add('segmentationValue', TextType::class)
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

    public function getBlockPrefix()
    {
        return '';
    }
}
