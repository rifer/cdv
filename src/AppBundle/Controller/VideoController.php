<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Video;
use AppBundle\Form\VideoType;

/**
 * Video controller.
 *
 */
class VideoController extends Controller
{

    /**
     * Lists all Video entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Video')->findAll();

        return $this->render('AppBundle:Video:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Video entity.
     *
     */
    public function createAction(Request $request, $foreign_key, $object_class)
    {
        $entity = new Video();
        $form = $this->createCreateForm($entity, $foreign_key, $object_class);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $entity->setForeignKey($foreign_key);
            $entity->setObjectClass($object_class);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('video_show', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:Video:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Video entity.
     *
     * @param Video $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Video $entity,$foreign_key,$object_class)
    {
        $form = $this->createForm(new VideoType(), $entity, array(
            'action' => $this->generateUrl('video_create',array('foreign_key'=>$foreign_key,'object_class'=>$object_class)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Video entity.
     *
     */
    public function newAction($foreign_key,$object_class)
    {
        $entity = new Video();
        $form = $this->createCreateForm($entity,$foreign_key,$object_class);

        return $this->render('AppBundle:Video:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Video entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Video')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find Video entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Video:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Video entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Video')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find Video entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Video:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Video entity.
     *
     * @param Video $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Video $entity)
    {
        $form = $this->createForm(new VideoType(), $entity, array(
            'action' => $this->generateUrl('video_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Video entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Video')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find Video entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid())
        {
            $em->flush();

            return $this->redirect($this->generateUrl('video_show', array('id' => $id)));
        }

        return $this->render('AppBundle:Video:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Video entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Video')->find($id);

            if (!$entity)
            {
                throw $this->createNotFoundException('Unable to find Video entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('video'));
    }

    /**
     * Creates a form to delete a Video entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('video_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
