<?php
/**
 * Created by diphda.net
 * User: paco
 * Date: 29/09/15
 * Time: 12:22
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * @ORM\Table(name="woman_translations", indexes={
 *      @ORM\Index(name="woman_translation_idx", columns={"locale", "object_class", "field", "foreign_key"})
 * })
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 */
class WomanTranslation extends AbstractTranslation
{
    /**
     * All required columns are mapped through inherited superclass
     */
}
