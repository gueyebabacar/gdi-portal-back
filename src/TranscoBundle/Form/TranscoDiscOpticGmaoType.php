<?php

namespace TranscoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TranscoDiscOpticGmaoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codeObject', TextType::class)
            ->add('natOp', TextType::class)
            ->add('natOpLabel', TextType::class)
            ->add('workType', TextType::class)
            ->add('groupGame', TextType::class)
            ->add('counter', TextType::class)
            ->add('codeTypeOptic', TextType::class)
            ->add('opticLabel', TextType::class)
            ->add('codeNatInter', TextType::class)
            ->add('segmentationCode', TextType::class)
            ->add('SegmentationLabel', TextType::class)
            ->add('finalCode', TextType::class)
            ->add('finalLabel', TextType::class)
            ->add('shortLabel', TextType::class)
            ->add('programmingMode', TextType::class)
            ->add('calibre', TextType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TranscoBundle\Entity\TranscoDiscOpticGmao',
            'csrf_protection' => false
        ));
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
