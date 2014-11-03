<?php

namespace Kermesse\KermesseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Kermesse\KermesseBundle\Entity\Sales;
use Kermesse\KermesseBundle\Form\SalesType;

use Kermesse\KermesseBundle\Entity\SalesLines;

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

        if (true/*$form->isValid()*/) {
            $em = $this->getDoctrine()->getManager();

            $tktTpl = $this->getTicketTpl();

            $allTkts = '';

            $sales = $request->get('kermesse_kermessebundle_sales');
            foreach ($sales['salesLines'] as $salesLine) {
                if (!empty($salesLine['count']) && $salesLine['count'] > 0) {
                    $product = $em->getRepository('KermesseBundle:Products')->find($salesLine['products']);

                    $prodTkts = str_repeat($tktTpl, $salesLine['count']);
                    $prodTkts = str_replace('{{product}}', $product->getName(), $prodTkts);

                    $allTkts .= $prodTkts;
                }
            }

            $this->convertToPdf($allTkts);

            //$em->persist($entity);
            //$em->flush();

            //return $this->redirect($this->generateUrl('sales_show', array('id' => $entity->getId())));
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
        $em = $this->getDoctrine()->getManager();

        $entity = new Sales();

        $products = $em->getRepository('KermesseBundle:Products')->findAll();
        foreach ($products as $product) {
            $sl = new SalesLines();
            $sl->setProducts($product);
            $sl->setPriceUnit($product->getPrice());
            $entity->getSalesLines()->add($sl);
        }

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

    private function getTicketTpl()
    {
        return '<page format="80x35" orientation="L">
<table  style="width: 100%; height: 100%;">
    <tr>
        <td style="width: 100%; text-align: center; padding: 0 0 0 0; font-weight: bold; font-size: 14px;">- KERMESSE 2014 - </td>
    </tr>
    <tr>
        <td style="width: 100%; text-align: center; padding: 10px 0 10px 0; font-weight: bold; font-size: 35px;">{{product}}</td>
    </tr>
    <tr>
        <td style="width: 100%; text-align: center; padding: 0 0 15px 0; font-size: 14px;">Iglesia Anglicana San Salvador</td>
    </tr>
</table></page>';
    }

    private function convertToPdf($content)
    {
        // convert in PDF
        try
        {
            $html2pdf = new \HTML2PDF('P', array(80, 35), 'es', true, 'UTF-8', array(0, 5, 0, 0));
            $html2pdf->setDefaultFont('Helvetica');
            $html2pdf->writeHTML($content);
            //$html2pdf->Output(__DIR__.'/../../../../app/cache/exemple00.pdf', 'F');
            $html2pdf->Output('exemple00.pdf');

            //lp -d EPSON-TM-T20 -o media=Custom.72x35mm -o fit-to-page -o source=PageFeedCut ticket2.pdf

            exit;
        }
        catch(\HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
}
