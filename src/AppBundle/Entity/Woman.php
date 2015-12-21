<?php
/**
 * Created by diphda.net.
 * User: paco
 * Date: 29/09/15
 * Time: 12:29
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * AppBundle\Entity\Womam
 *
 * @ORM\Table(name="woman")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\WomanRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\WomanTranslation")
 * @ORM\HasLifecycleCallbacks
 */
class Woman
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category", inversedBy="womans")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *
     **/
    private $category;

    /**
     * @Assert\NotBlank
     * @ORM\Column(name="name", type="string", length=128)
     */
    private $name;

    /**
     * @Assert\NotBlank
     * @ORM\Column(name="surname", type="string", length=128)
     */
    private $surname;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(name="biography", type="text", nullable=true)
     */
    private $biography;

    /**
     * @var string $image
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @Assert\File(maxSize="6000000")
     */
    protected $file;

    /**
     * @var int modified
     * @ORM\Column(name="modified", type="boolean", length=1, nullable=true)
     * Lo uso para, cuando se edita la entidad y sólo se modifica el archivo de imagen, indicar que se ha modificado
     * y persistir la entidad, porque el atributo file no se controla mediante doctrine porque no está en la bbdd
     */
    private $modified;


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
     * @Gedmo\Slug(fields={"name","surname"})
     * @Gedmo\Translatable
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(
     *   targetEntity="WomanTranslation",
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


    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getTranslations()
    {
        return $this->translations;
    }

    public function addTranslation(WomanTranslation $t)
    {
        if (!$this->translations->contains($t))
        {
            $this->translations[] = $t;
            $t->setObject($this);
        }
    }

    public function setTranslations($translations)
    {
        $this->translations = $translations;
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
     * Set name
     *
     * @param string $name
     *
     * @return Woman
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return Woman
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set biography
     *
     * @param string $biography
     *
     * @return Woman
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;

        return $this;
    }

    /**
     * Get biography
     *
     * @return string
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Woman
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
     * @return Woman
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
        return $this->name . " " . $this->surname;
    }

    /**
     * Remove translation
     *
     * @param \AppBundle\Entity\WomanTranslation $translation
     */
    public function removeTranslation(\AppBundle\Entity\WomanTranslation $translation)
    {
        $this->translations->removeElement($translation);
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
        return 'uploads/woman/images';
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
     * Set image
     *
     * @param string $image
     *
     * @return Woman
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
     * Set modified
     *
     * @param boolean $modified
     *
     * @return Woman
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

    public function getClass()
    {
        return "Woman";
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Woman
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
