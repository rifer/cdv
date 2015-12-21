<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HistoricalSecondType extends AbstractType
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
                    'translatable_class' => "AppBundle\Entity\Historical",
                    'fields' => array(
                        'slug'  => array(
                            'display' => false
                        ),
                        'head' => array(
                            'required'=>true,
                            'locale_options' => array(            // [3.b]
                                'es' => array(
                                    'label' => 'Título'
                                ),
                                'en' => array(
                                    'label' => 'Title',
                                    'required'=>false
                                ),
                            )
                        ),
                        'intro' => array(
                            'locale_options' => array(            // [3.b]
                                'es' => array(
                                    'label' => 'Resumen'
                                ),
                                'en' => array(
                                    'label' => 'Resume',
                                    'required'=>false
                                ),
                            )
                        ),
                        'content' => array(
                            'attr'=>array(
                                'class'=>'tinymce',
                                'data-theme' => 'custom'
                            ),
                            'locale_options' => array(            // [3.b]
                                'es' => array(
                                    'label' => 'Contenido'
                                ),
                                'en' => array(
                                    'label' => 'Content',
                                    'required'=>false
                                ),
                            )
                        ),
                        'caption' => array(
                            'locale_options' => array(            // [3.b]
                                'es' => array(
                                    'label' => 'Pie de foto'
                                ),
                                'en' => array(
                                    'label' => 'Caption',
                                    'required'=>false
                                ),
                            )
                        )
                    )
                )
            )
        ;
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
