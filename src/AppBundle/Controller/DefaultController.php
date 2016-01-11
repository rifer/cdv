<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:Default:index.html.twig');
    }

    /**
     * @Route("/building", name="building")
     */
    public function buildingAction()
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("AppBundle:Category")->find(2);
        $building = $em->getRepository("AppBundle:Woman")->findBuilding($category);

        return $this->render('AppBundle:Default:building.html.twig', array(
            'building'=>$building
        ));
    }

    /**
     * @Route("/catchall", name="catchall")
     */
    public function catchallAction()
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("AppBundle:Category")->find(3);
        $catchall = $em->getRepository("AppBundle:Woman")->findCatchAll($category);

        return $this->render('AppBundle:Default:catchall.html.twig', array(
            'catchall'=>$catchall
        ));
    }

     /**
     * @Route("/gallery", name="gallery")
     */
    public function galleryAction()
    {
        $em = $this->getDoctrine()->getManager();
        $galleries = $em->getRepository("AppBundle:Gallery")->findAllSingle();


        return $this->render('AppBundle:Default:gallery.html.twig',array(
            'galleries'=>$galleries
        ));
    }

}
