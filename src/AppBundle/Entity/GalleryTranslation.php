<?php
/**
 * Created by diphda.net.
 * User: paco
 * Date: 5/10/15
 * Time: 21:46
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * @ORM\Table(name="gallery_translations", indexes={
 *      @ORM\Index(name="gallery_translation_idx", columns={"locale", "object_class", "field", "foreign_key"})
 * })
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 */
class GalleryTranslation extends AbstractTranslation
{
    /**
     * All required columns are mapped through inherited superclass
     */
}