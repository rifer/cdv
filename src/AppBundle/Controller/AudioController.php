<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Audio;
use AppBundle\Form\AudioType;

/**
 * Audio controller.
 *
 */
class AudioController extends Controller
{

    /**
     * Lists all Audio entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Audio')->findAll();

        return $this->render('AppBundle:Audio:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Audio entity.
     *
     */
    public function createAction(Request $request,$foreign_key,$object_class)
    {
        $entity = new Audio();
        $form = $this->createCreateForm($entity,$foreign_key,$object_class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setForeignKey($foreign_key);
            $entity->setObjectClass($object_class);
            $em->persist($entity);
            $em->flush();

            if ($this->get('request')->isXmlHttpRequest())
            {
                return $this->redirect($this->generateUrl($entity->getObjectClass()."_edition",array('id'=>$foreign_key,'object_class'=>$entity->getObjectClass())));
            }
            return $this->redirect($this->generateUrl($entity->getObjectClass().'_show', array('id' => $entity->getForeignKey())));

        }

        return $this->render('AppBundle:Audio:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Audio entity.
     *
     * @param Audio $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Audio $entity,$foreign_key,$object_class)
    {
        $form = $this->createForm(new AudioType(), $entity, array(
            'action' => $this->generateUrl('audio_create',array('foreign_key'=>$foreign_key,'object_class'=>$object_class)),
            'method' => 'POST',
        ));

        $form->add('button', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Audio entity.
     *
     */
    public function newAction($foreign_key,$object_class)
    {
        $entity = new Audio();

        $form   = $this->createCreateForm($entity,$foreign_key,$object_class);

        return $this->render('AppBundle:Audio:new.html.twig', array(
            'entity' => $entity,
            'foreign_key'=> $foreign_key,
            'object_class'=>$object_class,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Audio entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Audio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Audio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Audio:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Audio entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Audio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Audio entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Audio:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Audio entity.
    *
    * @param Audio $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Audio $entity)
    {
        $form = $this->createForm(new AudioType(), $entity, array(
            'action' => $this->generateUrl('audio_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Audio entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Audio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Audio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('audio_show', array('id' => $id)));
        }

        return $this->render('AppBundle:Audio:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Audio entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Audio')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Audio entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('audio'));
    }

    /**
     * Creates a form to delete a Audio entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('audio_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function show_snippetAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Audio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Audio entity.');
        }

        return $this->render('AppBundle:Audio:show_snippet.html.twig', array(
            'entity'      => $entity,

        ));
    }
}
