<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HistoricalType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'date',
                'date',
                array(
                    'format' => 'MMMM-yyyy  d',
                    'years' => range(1904, 1976),
                    'days' => array(1),
                    'empty_value' => array('year' => 'Select Year', 'month' => 'Select Month', 'day' => false)
                )
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     *
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Historical'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_historical';
    }
}
