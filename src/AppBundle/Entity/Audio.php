<?php
/**
 * Created by diphda.net.
 * User: paco
 * Date: 30/09/15
 * Time: 21:22
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * AppBundle\Entity\Audio
 *
 * @ORM\Table(name="audio")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AudioRepository")
 */
class Audio
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $objectClass
     *
     * @ORM\Column(name="object_class", type="string", length=255)
     */
    protected $objectClass;

    /**
     * @var string $foreignKey
     *
     * @ORM\Column(name="foreign_key", type="string", length=64)
     */
    protected $foreignKey;


    /**
     * @var string $title
     * @Assert\NotBlank
     * @Assert\Length(max="255", min="5")
     * @Gedmo\Translatable
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;


    /**
     * @var string $html_content
     * @Assert\NotBlank
     * @ORM\Column(name="html_content", type="text")
     */
    private $html_content;

    /**
     * @var dateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var dateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @var string $slug
     * @Gedmo\Slug(fields={"title"})
     * @Gedmo\Translatable
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set objectClass
     *
     * @param string $objectClass
     *
     * @return Audio
     */
    public function setObjectClass($objectClass)
    {
        $this->objectClass = $objectClass;

        return $this;
    }

    /**
     * Get objectClass
     *
     * @return string
     */
    public function getObjectClass()
    {
        return $this->objectClass;
    }

    /**
     * Set foreignKey
     *
     * @param string $foreignKey
     *
     * @return Audio
     */
    public function setForeignKey($foreignKey)
    {
        $this->foreignKey = $foreignKey;

        return $this;
    }

    /**
     * Get foreignKey
     *
     * @return string
     */
    public function getForeignKey()
    {
        return $this->foreignKey;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Audio
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set htmlContent
     *
     * @param string $htmlContent
     *
     * @return Audio
     */
    public function setHtmlContent($htmlContent)
    {
        $this->html_content = $htmlContent;

        return $this;
    }

    /**
     * Get htmlContent
     *
     * @return string
     */
    public function getHtmlContent()
    {
        return $this->html_content;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Audio
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Audio
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Audio
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
