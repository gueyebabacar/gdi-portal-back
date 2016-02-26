<?php

namespace UserBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use UserBundle\Entity\User;

class EditUserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'required' => false
            ])
            ->add('lastName', TextType::class, [
                'required' => false
            ])
            ->add('email', TextType::class, [
                'required' => false
            ])
            ->add('phone1', TextType::class, [
                'required' => false
            ])
            ->add('nni', TextType::class, [
                'required' => false
            ])
            ->add('phone2', TextType::class, [
                'required' => false
            ])
            ->add('entity', ChoiceType::class, [
                'choices' => User::getEntities(),
                'choices_as_values' => true,
                'required' => false
            ])
            ->add('agency')
            ->add('roles')
            ->add('region', EntityType::class,
                [
                    'class' => 'PortalBundle:Region',
                    'choice_label' => 'label',
                    'required' => false
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
            'csrf_protection' => false,
            'method'=> 'PATCH'
        ));
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
