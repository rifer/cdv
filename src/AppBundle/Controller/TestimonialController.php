<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TestimonialController extends Controller
{
    /**
     * @Route("/testimonial")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $dql   = "SELECT a FROM AppBundle:Woman a";
        $query = $em->createQuery($dql);
        $paginator  = $this->get('knp_paginator');
        $testimonials = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem($this->get('translator')->trans("Testimonios"));

        return $this->render('AppBundle:Testimonial:index.html.twig', array(
            'testimonials' => $testimonials
        ));
    }

    /**
     * @Route("/testimonial/{slug}")
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $testimonial = $em->getRepository("AppBundle:Woman")->findOneBy(array(
            'slug' => $slug
        ));

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem($this->get('translator')->trans("Testimonios"), $this->get("router")->generate("app_testimonial_index"));
        $breadcrumbs->addItem($this->get('translator')->trans("Testimonio de ").$testimonial);

        return $this->render('AppBundle:Testimonial:show.html.twig', array(
            'testimonial' => $testimonial
        ));
    }

}