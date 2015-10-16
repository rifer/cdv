<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('translations', 'a2lix_translations_gedmo', array(
                    'translatable_class' => "AppBundle\Entity\Document",
                    'fields' => array(
                        'slug'  => array(
                            'display' => false
                        ),
                        'title' => array(
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
                        'content' => array(
                            'locale_options' => array(            // [3.b]
                                'es' => array(
                                    'label' => 'Descripción'
                                ),
                                'en' => array(
                                    'label' => 'Description',
                                    'required'=>false
                                ),
                            )
                        ),

                    )
                )
            )
            ->add('file',null,array(
                "required"=>null===$builder->getData()->getId()?true:false,
                "label"=>"Archivo"
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Document'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_document';
    }
}
