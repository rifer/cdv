<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Gallery;
use AppBundle\Form\GalleryType;

/**
 * Gallery controller.
 *
 */
class GalleryController extends Controller
{

    /**
     * Lists all Gallery entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Gallery')->findAll();

        return $this->render('AppBundle:Gallery:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Gallery entity.
     *
     */
    public function createAction(Request $request, $foreign_key, $object_class)
    {
        $entity = new Gallery();
        $form = $this->createCreateForm($entity, $foreign_key, $object_class);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $entity->setForeignKey($foreign_key);
            $entity->setObjectClass($object_class);
            $em->persist($entity);
            $em->flush();

            if ($this->get('request')->isXmlHttpRequest())
            {
                return $this->redirect($this->generateUrl($entity->getObjectClass() . "_edition", array('id' => $foreign_key, 'object_class' => $entity->getObjectClass())));
            }
            return $this->redirect($this->generateUrl($entity->getObjectClass() . '_show', array('id' => $entity->getForeignKey())));
        }

        return $this->render('AppBundle:Gallery:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Gallery entity.
     *
     * @param Gallery $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Gallery $entity, $foreign_key, $object_class)
    {
        $form = $this->createForm(new GalleryType(), $entity, array(
            'action' => $this->generateUrl('gallery_create', array('foreign_key' => $foreign_key, 'object_class' => $object_class)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Gallery entity.
     *
     */
    public function newAction($foreign_key, $object_class)
    {
        $entity = new Gallery();
        $form = $this->createCreateForm($entity, $foreign_key, $object_class);

        return $this->render('AppBundle:Gallery:new.html.twig', array(
            'entity' => $entity,
            'foreign_key' => $foreign_key,
            'object_class' => $object_class,
            'form' => $form->createView(),
        ));
    }


    private function createCreateSingleForm(Gallery $entity)
    {
        $form = $this->createForm(new GalleryType(), $entity, array(
            'action' => $this->generateUrl('gallery_create_single'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    public function newSingleAction()
    {
        $entity = new Gallery();
        $form = $this->createCreateSingleForm($entity);

        return $this->render('AppBundle:Gallery:new_single.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }


    public function createSingleAction(Request $request)
    {
        $entity = new Gallery();
        $form = $this->createCreateSingleForm($entity);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('gallery_show', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:Gallery:new_single.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Gallery entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Gallery')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find Gallery entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Gallery:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Gallery entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Gallery')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find Gallery entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Gallery:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Gallery entity.
     *
     * @param Gallery $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Gallery $entity)
    {
        $form = $this->createForm(new GalleryType(), $entity, array(
            'action' => $this->generateUrl('gallery_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Gallery entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Gallery')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find Gallery entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid())
        {
            $em->flush();

            return $this->redirect($this->generateUrl('gallery_show', array('id' => $id)));
        }

        return $this->render('AppBundle:Gallery:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Gallery entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Gallery')->find($id);

            if (!$entity)
            {
                throw $this->createNotFoundException('Unable to find Gallery entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('gallery'));
    }

    /**
     * Creates a form to delete a Gallery entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gallery_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }


    public function show_snippetAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        /*
         * en los testimonios no hay galerías, sino que las imágenes están relacionadas a la entidad testimonio (woman),
         * o building o catchall.
         * Entonces hay que coger las imágenes de la entidad (woman) que están agrupadas (single=0)
         */
        $woman = $em->getRepository('AppBundle:Woman')->find($id);
        $images = $em->getRepository('AppBundle:Image')->findWomanGroupedImages($id);

        return $this->render('AppBundle:Gallery:show_snippet.html.twig', array(
            'images' => $images,
            'woman' => $woman
        ));
    }

    public function imageListAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $gallery = $em->getRepository("AppBundle:Gallery")->find($id);

        return $this->render('AppBundle:Gallery:image_list.html.twig', array(
            'gallery' => $gallery,

        ));
    }
}
