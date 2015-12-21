<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Image;
use AppBundle\Form\ImageType;

/**
 * Image controller.
 *
 */
class ImageController extends Controller
{

    /**
     * Lists all Image entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Image')->findAll();

        return $this->render('AppBundle:Image:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Image entity.
     *
     */
    public function createAction(Request $request, $foreign_key, $object_class,$single)
    {
        $entity = new Image();
        $form = $this->createCreateForm($entity, $foreign_key, $object_class,$single);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $entity->setForeignKey($foreign_key);
            $entity->setObjectClass($object_class);
            $entity->setSingle($single);
            $em->persist($entity);
            $em->flush();

            if ($this->get('request')->isXmlHttpRequest())
            {
                return $this->redirect($this->generateUrl($entity->getObjectClass() . "_edition", array('id' => $foreign_key, 'object_class' => $entity->getObjectClass())));
            }
            return $this->redirect($this->generateUrl($entity->getObjectClass() . '_show', array('id' => $entity->getForeignKey())));
        }

        return $this->render('AppBundle:Image:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Image entity.
     *
     * @param Image $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Image $entity, $foreign_key, $object_class,$single)
    {
        $form = $this->createForm(new ImageType(), $entity, array(
            'action' => $this->generateUrl('image_create', array('foreign_key' => $foreign_key, 'object_class' => $object_class,'single'=>$single)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Image entity.
     *
     */
    public function newAction($foreign_key, $object_class,$single)
    {
        $entity = new Image();
        $form = $this->createCreateForm($entity, $foreign_key, $object_class,$single);

        return $this->render('AppBundle:Image:new.html.twig', array(
            'entity' => $entity,
            'foreign_key' => $foreign_key,
            'single'=>$single,
            'object_class' => $object_class,
            'form' => $form->createView(),
        ));
    }


      public function newInGalleryAction($foreign_key, $object_class,$single,$gallery_id)
    {
        $entity = new Image();
        $form = $this->createCreateInGalleryForm($entity, $foreign_key, $object_class,$single,$gallery_id);

        return $this->render('AppBundle:Image:new_in_gallery.html.twig', array(
            'entity' => $entity,
            'foreign_key' => $foreign_key,
            'single'=>$single,
            'gallery_id'=>$gallery_id,
            'object_class' => $object_class,
            'form' => $form->createView(),
        ));
    }

    private function createCreateInGalleryForm(Image $entity, $foreign_key, $object_class,$single,$gallery_id)
    {
        $form = $this->createForm(new ImageType(), $entity, array(
            'action' => $this->generateUrl('image_in_gallery_create', array('foreign_key' => $foreign_key, 'object_class' => $object_class,'single'=>$single,'gallery_id'=>$gallery_id)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    public function createInGalleryAction(Request $request, $foreign_key, $object_class,$single,$gallery_id)
    {
        $entity = new Image();
        $form = $this->createCreateForm($entity, $foreign_key, $object_class,$single);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $gallery=$em->getRepository("AppBundle:Gallery")->find($gallery_id);
            $entity->setForeignKey($foreign_key);
            $entity->setObjectClass($object_class);
            $entity->setGallery($gallery);
            $entity->setSingle($single);
            $em->persist($entity);
            $em->flush();

            if ($this->get('request')->isXmlHttpRequest())
            {
                return $this->redirect($this->generateUrl("gallery_image_list", array('id' => $gallery_id)));
            }

        }

        return $this->render('AppBundle:Image:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }
    /**
     * Finds and displays a Image entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Image')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find Image entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Image:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Image entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Image')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find Image entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Image:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Image entity.
     *
     * @param Image $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Image $entity)
    {
        $form = $this->createForm(new ImageType(), $entity, array(
            'action' => $this->generateUrl('image_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Image entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Image')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find Image entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid())
        {
            $entity->setModified(1);
            $em->persist($entity);
            $entity->setModified(0);
            $em->flush();

            return $this->redirect($this->generateUrl('gallery_show', array('id' => $entity->getGallery()->getId())));
        }

        return $this->render('AppBundle:Image:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Image entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Image')->find($id);

            if (!$entity)
            {
                throw $this->createNotFoundException('Unable to find Image entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('image'));
    }

    /**
     * Creates a form to delete a Image entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('image_delete', array('id' => $id)))
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

        $image = $em->getRepository('AppBundle:Image')->find($id);

        return $this->render('AppBundle:Image:show_snippet.html.twig', array(
            'image' => $image,
        ));
    }
}
