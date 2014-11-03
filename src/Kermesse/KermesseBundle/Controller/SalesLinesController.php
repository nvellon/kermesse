<?php

namespace Kermesse\KermesseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Kermesse\KermesseBundle\Entity\SalesLines;
use Kermesse\KermesseBundle\Form\SalesLinesType;

/**
 * SalesLines controller.
 *
 */
class SalesLinesController extends Controller
{

    /**
     * Lists all SalesLines entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KermesseBundle:SalesLines')->findAll();

        return $this->render('KermesseBundle:SalesLines:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new SalesLines entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new SalesLines();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('saleslines_show', array('id' => $entity->getId())));
        }

        return $this->render('KermesseBundle:SalesLines:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a SalesLines entity.
     *
     * @param SalesLines $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SalesLines $entity)
    {
        $form = $this->createForm(new SalesLinesType(), $entity, array(
            'action' => $this->generateUrl('saleslines_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SalesLines entity.
     *
     */
    public function newAction()
    {
        $entity = new SalesLines();
        $form   = $this->createCreateForm($entity);

        return $this->render('KermesseBundle:SalesLines:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SalesLines entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KermesseBundle:SalesLines')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SalesLines entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('KermesseBundle:SalesLines:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SalesLines entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KermesseBundle:SalesLines')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SalesLines entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('KermesseBundle:SalesLines:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a SalesLines entity.
    *
    * @param SalesLines $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SalesLines $entity)
    {
        $form = $this->createForm(new SalesLinesType(), $entity, array(
            'action' => $this->generateUrl('saleslines_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing SalesLines entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KermesseBundle:SalesLines')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SalesLines entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('saleslines_edit', array('id' => $id)));
        }

        return $this->render('KermesseBundle:SalesLines:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a SalesLines entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KermesseBundle:SalesLines')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SalesLines entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('saleslines'));
    }

    /**
     * Creates a form to delete a SalesLines entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('saleslines_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
