<?php

namespace AppBundle\Controller;

use AppBundle\Form\HistoricalEditType;
use AppBundle\Form\HistoricalSecondType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Historical;
use AppBundle\Form\HistoricalType;

/**
 * Historical controller.
 *
 */
class HistoricalController extends Controller
{

    /**
     * Lists all Historical entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Historical')->findAll();

        return $this->render('AppBundle:Historical:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Historical entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Historical();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('historical_second_step', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:Historical:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Historical entity.
     *
     * @param Historical $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Historical $entity)
    {
        $form = $this->createForm(new HistoricalType(), $entity, array(
            'action' => $this->generateUrl('historical_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Historical entity.
     *
     */
    public function newAction()
    {
        $entity = new Historical();
        $form   = $this->createCreateForm($entity);

        return $this->render('AppBundle:Historical:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Historical entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Historical')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Historical entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Historical:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Historical entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Historical')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Historical entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Historical:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Historical entity.
    *
    * @param Historical $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Historical $entity)
    {
        $form = $this->createForm(new HistoricalEditType(), $entity, array(
            'action' => $this->generateUrl('historical_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Historical entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Historical')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Historical entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('historical_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:Historical:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Historical entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Historical')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Historical entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('historical'));
    }

    /**
     * Creates a form to delete a Historical entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('historical_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }


    public function secondAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Historical')->find($id);
        $galleries = $em->getRepository('AppBundle:Woman')->findMedia("Gallery",$id,"historical");
        $audios = $em->getRepository('AppBundle:Woman')->findMedia("Audio",$id,"historical");
        $videos = $em->getRepository('AppBundle:Woman')->findMedia("Video",$id,"historical");
        $documents = $em->getRepository('AppBundle:Woman')->findMedia("Document",$id,"historical");

        $form   = $this->createSecondForm($entity);

        return $this->render('AppBundle:Historical:second.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'galleries' => $galleries,
            'audios' => $audios,
            'videos' => $videos,
            'documents' => $documents
        ));
    }

    private function createSecondForm(Historical $entity)
    {
        $form = $this->createForm(new HistoricalSecondType(), $entity, array(
            'action' => $this->generateUrl('historical_update_second', array('id'=>$entity->getId())),
            'method' => 'PUT',
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    public function updateSecondAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Historical')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Historical entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createSecondForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('historical_show', array('id' => $id)));
        }

        return $this->render('AppBundle:Historical:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
