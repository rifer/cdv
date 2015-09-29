<?php
/**
 * CDV
 * User: paco
 * Date: 28/09/15
 * Time: 21:39
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * AppBundle\Entity\Testimony
 *
 * @ORM\Table(name="testimony")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TestimonyRepository")
 */

class Testimony
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

}