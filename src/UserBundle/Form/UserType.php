<?php

namespace UserBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\User;

class UserType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array('label' => 'GAIA'))
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', TextType::class)
            ->add('password', TextType::class)
            ->add('phone1', TextType::class)
            ->add('phone2', TextType::class)
            ->add('entity', ChoiceType::class, [
                'choices' => User::getEntities(),
                'choices_as_values' => true,
            ])
            ->add('agency', EntityType::class,
                [
                    'class' => 'PortalBundle:Agency'
                ])
            ->add('roles', TextType::class)
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
