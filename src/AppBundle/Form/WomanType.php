<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class WomanType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('surname')
            ->add('translations', 'a2lix_translations_gedmo', array(
                    'translatable_class' => "AppBundle\Entity\Woman",
                    'fields' => array(
                        
                        'biography' => array(
                            'locale_options' => array(            // [3.b]
                                'es' => array(
                                    'label' => 'Biografía'            // [4]
                                ),
                                'en' => array(
                                    'label' => 'Biography'            // [4]
                                ),
                            )
                        )

                    )
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Woman'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_woman';
    }
}
