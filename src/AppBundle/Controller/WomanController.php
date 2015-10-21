<?php

namespace AppBundle\Controller;

use AppBundle\Form\WomanEditType;
use AppBundle\Form\WomanSecondType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Woman;
use AppBundle\Form\WomanType;

/**
 * Woman controller.
 *
 */
class WomanController extends Controller
{

    /**
     * Lists all Woman entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Woman')->findAll();

        return $this->render('AppBundle:Woman:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Woman entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Woman();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('woman_second_step', array('id' => $entity->getId())));
        }
        return $this->render('AppBundle:Woman:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

    }



    /**
     * Creates a form to create a Woman entity.
     *
     * @param Woman $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Woman $entity)
    {
        $form = $this->createForm(new WomanType(), $entity, array(
            'action' => $this->generateUrl('woman_create'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }





    /**
     * Displays a form to create a new Woman entity.
     *
     */
    public function newAction()
    {
        $entity = new Woman();
        $form   = $this->createCreateForm($entity);

        return $this->render('AppBundle:Woman:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    public function secondAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Woman')->find($id);
        $galleries = $em->getRepository('AppBundle:Woman')->findMedia("Gallery",$id,"woman");
        $audios = $em->getRepository('AppBundle:Woman')->findMedia("Audio",$id,"woman");
        $videos = $em->getRepository('AppBundle:Woman')->findMedia("Video",$id,"woman");
        $documents = $em->getRepository('AppBundle:Woman')->findMedia("Document",$id,"woman");

        $form   = $this->createSecondForm($entity);

        return $this->render('AppBundle:Woman:second.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'galleries' => $galleries,
            'audios' => $audios,
            'videos' => $videos,
            'documents' => $documents
        ));
    }


    private function createSecondForm(Woman $entity)
    {
        $form = $this->createForm(new WomanSecondType(), $entity, array(
            'action' => $this->generateUrl('woman_update_second', array('id'=>$entity->getId())),
            'method' => 'PUT',
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    public function updateSecondAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Woman')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Woman entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createSecondForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('woman_show', array('id' => $id)));
        }

        return $this->render('AppBundle:Woman:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Finds and displays a Woman entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Woman')->find($id);



        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Woman entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Woman:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Woman entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Woman')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Woman entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Woman:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Woman entity.
    *
    * @param Woman $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Woman $entity)
    {
        $form = $this->createForm(new WomanEditType(), $entity, array(
            'action' => $this->generateUrl('woman_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Woman entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Woman')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Woman entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('woman_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:Woman:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Woman entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Woman')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Woman entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('woman'));
    }

    /**
     * Creates a form to delete a Woman entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('woman_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }


    public function editionAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Woman')->find($id);
        $galleries = $em->getRepository('AppBundle:Woman')->findMedia("Gallery",$id,"woman");
        $audios = $em->getRepository('AppBundle:Woman')->findMedia("Audio",$id,"woman");
        $videos = $em->getRepository('AppBundle:Woman')->findMedia("Video",$id,"woman");
        $documents = $em->getRepository('AppBundle:Woman')->findMedia("Document",$id,"woman");



        return $this->render('AppBundle:Woman:edition.html.twig', array(
            'entity' => $entity,
            'galleries' => $galleries,
            'audios' => $audios,
            'videos' => $videos,
            'documents' => $documents
        ));
    }

}
