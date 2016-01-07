<?php

namespace TranscoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('opticNatCode', TextType::class)
            ->add('opticSkill', TextType::class)
            ->add('opticNatLabel', TextType::class)
            ->add('pictrelNatOpCode', TextType::class)
            ->add('pictrelNatOpLabel', TextType::class)
            ->add('troncatedPictrelNatOpLabel', TextType::class)
            ->add('counter', TextType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TranscoBundle\Entity\TranscoNatureInter',
            'csrf_protection' => false
        ));
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
