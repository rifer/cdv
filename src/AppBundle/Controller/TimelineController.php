<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Historical;
use AppBundle\Form\HistoricalType;

/**
 * Historical controller.
 *
 */
class TimelineController extends Controller
{

    /**
     * @Route("/history")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Historical')->findAll();

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem($this->get('translator')->trans("Historia"));

        return $this->render('AppBundle:Timeline:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * @Route("/history/{slug}")
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Historical')->findOneBy(array(
            'slug' => $slug
        ));

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem($this->get('translator')->trans("Historia"), $this->get("router")->generate("app_timeline_index"));
        $breadcrumbs->addItem($entity);

        return $this->render('AppBundle:Timeline:show.html.twig', array(
            'entity'      => $entity,
        ));
    }
}
