<?php
/**
 * Created by diphda.net.
 * User: paco
 * Date: 19/10/15
 * Time: 21:49
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * AppBundle\Entity\Historical
 *
 * @ORM\Table(name="historical")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\HistoricalRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\HistoricalTranslation")
 * @ORM\HasLifecycleCallbacks
 */
class Historical
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
     * @var date $date
     * @Assert\NotBlank
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @Assert\NotBlank
     * @Gedmo\Translatable
     * @ORM\Column(name="head", type="string", length=255)
     */
    private $head;

    /**
     * @Assert\NotBlank
     * @Gedmo\Translatable
     * @ORM\Column(name="intro", type="text")
     */
    private $intro;

    /**
     * @Assert\NotBlank
     * @Gedmo\Translatable
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string $image
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @Assert\NotBlank
     * @Gedmo\Translatable
     * @ORM\Column(name="caption", type="string", length=255)
     */
    private $caption;

    /**
     * @Assert\File(maxSize="6000000")
     */
    protected $file;
    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @var string $slug
     * @Gedmo\Slug(fields={"head"})
     * @Gedmo\Translatable
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(
     *   targetEntity="HistoricalTranslation",
     *   mappedBy="object",
     *   cascade={"persist", "remove"}
     * )
     */

    private $translations;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    /**
     * @var int modified
     * @ORM\Column(name="modified", type="boolean", length=1, nullable=true)
     * Lo uso para, cuando se edita la entidad y sólo se modifica el archivo de imagen, indicar que se ha modificado
     * y persistir la entidad, porque el atributo file no se controla mediante doctrine porque no está en la bbdd
     */
    private $modified;


    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }


    public function getTranslations()
    {
        return $this->translations;
    }

    public function addTranslation(HistoricalTranslation $t)
    {
        if (!$this->translations->contains($t))
        {
            $this->translations[] = $t;
            $t->setObject($this);
        }
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getAbsolutePath()
    {
        return null === $this->image ? null : $this->getUploadRootDir() . '/' . $this->image;
    }

    public function getWebPath()
    {
        return null === $this->image ? null : $this->getUploadDir() . '/' . $this->image;
    }

    protected function getUploadRootDir()
    {
        // la ruta absoluta del directorio donde se deben guardar los archivos cargados
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // se libra del __DIR__ para no desviarse al mostrar `doc/image` en la vista.
        return 'uploads/historical/images';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file)
        {
            // haz cualquier cosa para generar un nombre único
            if ($this->image !== null)
            {
                $this->removeUpload();
            }
            $this->image = uniqid("", true) . '.' . $this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // la propiedad file puede estar vacía si el campo no es obligatorio
        if (null === $this->file)
        {
            return;
        }

        // si hay un error al mover el archivo, move() automáticamente
        // envía una excepción. Esta impedirá que la entidad se persista
        // en la base de datos en caso de error
        $this->file->move($this->getUploadRootDir(), $this->image);

        unset($this->file);
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath())
        {
            unlink($file);
        }
    }



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
     * Set head
     *
     * @param string $head
     *
     * @return Historical
     */
    public function setHead($head)
    {
        $this->head = $head;

        return $this;
    }

    /**
     * Get head
     *
     * @return string
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * Set intro
     *
     * @param string $intro
     *
     * @return Historical
     */
    public function setIntro($intro)
    {
        $this->intro = $intro;

        return $this;
    }

    /**
     * Get intro
     *
     * @return string
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Historical
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Historical
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set caption
     *
     * @param string $caption
     *
     * @return Historical
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Get caption
     *
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Historical
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
     * @return Historical
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
     * @return Woman
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

    public function __toString()
    {
        return $this->head;
    }

    /**
     * Set modified
     *
     * @param boolean $modified
     *
     * @return Historical
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return boolean
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Remove translation
     *
     * @param \AppBundle\Entity\HistoricalTranslation $translation
     */
    public function removeTranslation(\AppBundle\Entity\HistoricalTranslation $translation)
    {
        $this->translations->removeElement($translation);
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Historical
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    public function getStringDate()
    {
        return $this->date->format("F"). " / ".$this->date->format("Y");
    }

    public function getMonth()
    {
        return $this->date->format("F");
    }

    public function getYear()
    {
        return $this->date->format("Y");
    }
}
