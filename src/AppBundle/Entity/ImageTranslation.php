<?php
/**
 * Created by diphda.net.
 * User: paco
 * Date: 5/10/15
 * Time: 21:46
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="image_translations",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="lookup_unique_idx", columns={
 *         "locale", "object_id", "field"
 *     })}
 * )
 */

class ImageTranslation extends AbstractPersonalTranslation
{

    /**
     * Convinient constructor
     *
     * @param string $locale
     * @param string $field
     * @param string $content
     */
    public function __construct($locale = null, $field = null, $content = null)
    {
        $this->setLocale($locale);
        $this->setField($field);
        $this->setContent($content);
    }
    /**
     * @ORM\ManyToOne(targetEntity="Image", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;
}
