<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CountryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('language')
            ->add('currency')
            ->add('capitalCity')
            ->add('jetLag')
            ->add('bestPeriod')
            ->add('flightDuration')
            ->add('headState')
            ->add('surface')
            ->add('inhabitantsName')
            ->add('population')
            ->add('density')
            ->add('flagFile')
            ->add('costLiving')
            ->add('adapter')
            ->add('areaCode')
            ->add('description');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Country',
            'csrf_protection' => false
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return '';
    }


}
