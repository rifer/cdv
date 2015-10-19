<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ListController extends Controller
{
    /**
     * @Route("/list", name="list")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $dql   = "SELECT a FROM AppBundle:Woman a";
        $query = $em->createQuery($dql);
        $paginator  = $this->get('knp_paginator');
        $womans = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );


        return $this->render('AppBundle:List:index.html.twig', array(
            'womans' =>$womans
        ));
    }
}
