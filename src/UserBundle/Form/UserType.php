<?php

namespace UserBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', TextType::class)
            ->add('phone1', TextType::class)
            ->add('phone2', TextType::class)
            ->add('entity', TextType::class)
            ->add('agency', EntityType::class,
                [
                    'class' => 'PortalBundle\Entity\Agency'
                ])
            ->add('role', EntityType::class,
                [
                    'class' => 'PortalBundle\Entity\Role'
                ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\User',
            'csrf_protection' => false
        ));
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
