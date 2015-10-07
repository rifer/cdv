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
        return $this->render('AppBundle:Testimonial:index.html.twig');
    }


}