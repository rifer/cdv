<?php
/**
 * Created by diphda.net.
 * User: paco
 * Date: 29/09/15
 * Time: 12:29
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * AppBundle\Entity\Womam
 *
 * @ORM\Table(name="woman")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\WomamRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\WomamTranslation")
 */
class Woman
{

}