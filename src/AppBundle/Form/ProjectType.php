<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('createdDate')
            ->add('destCountry')
            ->add('departureDate')
            ->add('returnDate')
            ->add('accommodationType')
            ->add('hostType')
            ->add('discoveryActivity')
            ->add('lazingActivity')
            ->add('sportActivity')
            ->add('maximumBudget')
            ->add('config')
            ->add('country')
            ->add('group')
            ->add('user');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Project',
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
