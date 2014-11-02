<?php

namespace Kermesse\KermesseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Kermesse\KermesseBundle\Entity\Sales;
use Kermesse\KermesseBundle\Form\SalesType;

/**
 * Sales controller.
 *
 */
class SalesController extends Controller
{

    /**
     * Lists all Sales entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KermesseBundle:Sales')->findAll();

        return $this->render('KermesseBundle:Sales:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Sales entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Sales();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('sales_show', array('id' => $entity->getId())));
        }

        return $this->render('KermesseBundle:Sales:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Sales entity.
     *
     * @param Sales $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Sales $entity)
    {
        $form = $this->createForm(new SalesType(), $entity, array(
            'action' => $this->generateUrl('sales_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Sales entity.
     *
     */
    public function newAction()
    {
        $entity = new Sales();
        $form   = $this->createCreateForm($entity);

        return $this->render('KermesseBundle:Sales:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Sales entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KermesseBundle:Sales')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sales entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('KermesseBundle:Sales:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Sales entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KermesseBundle:Sales')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sales entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('KermesseBundle:Sales:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Sales entity.
    *
    * @param Sales $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Sales $entity)
    {
        $form = $this->createForm(new SalesType(), $entity, array(
            'action' => $this->generateUrl('sales_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Sales entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KermesseBundle:Sales')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sales entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('sales_edit', array('id' => $id)));
        }

        return $this->render('KermesseBundle:Sales:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Sales entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KermesseBundle:Sales')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Sales entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('sales'));
    }

    /**
     * Creates a form to delete a Sales entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sales_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
