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

    public function buildingAction()
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("AppBundle:Category")->find(2);
        $building = $em->getRepository("AppBundle:Woman")->findBuilding($category);

        return $this->render('AppBundle:Default:building.html.twig');
    }

    public function catchallAction()
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("AppBundle:Category")->find(3);
        $building = $em->getRepository("AppBundle:Woman")->findCatchAll($category);

        return $this->render('AppBundle:Default:catchall.html.twig');
    }
}
