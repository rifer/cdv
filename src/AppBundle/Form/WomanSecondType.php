<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class WomanSecondType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file',null,array(
                "required"=>null===$builder->getData()->getId()?true:false,
                "label"=>"Imagen"
            ))
            ->add('translations', 'a2lix_translations_gedmo', array(
                    'translatable_class' => "AppBundle\Entity\Woman",
                    'fields' => array(
                        'slug'  => array(
                            'display' => false
                        ),
                        'biography' => array(
                            'attr'=>array(
                                'class'=>'tinymce',
                                'data-theme' => 'custom'
                            ),
                            'locale_options' => array(            // [3.b]
                                'es' => array(
                                    'label' => 'Biografía'
                                ),
                                'en' => array(
                                    'label' => 'Biography',
                                    'required'=>false
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
