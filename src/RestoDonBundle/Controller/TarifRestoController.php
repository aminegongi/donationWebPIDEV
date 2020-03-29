<?php

namespace RestoDonBundle\Controller;

use RestoDonBundle\Entity\TarifResto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tarifresto controller.
 *
 */
class TarifRestoController extends Controller
{
    /**
     * Lists all tarifResto entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tarifRestos = $em->getRepository('RestoDonBundle:TarifResto')->findAll();

        return $this->render('tarifresto/index.html.twig', array(
            'tarifRestos' => $tarifRestos,
        ));
    }

    /**
     * Creates a new tarifResto entity.
     *
     */
    public function newAction(Request $request)
    {
        $tarifResto = new Tarifresto();
        $form = $this->createForm('RestoDonBundle\Form\TarifRestoType', $tarifResto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tarifResto);
            $em->flush();

            return $this->redirectToRoute('tarifresto_show', array('idResto' => $tarifResto->getIdresto()));
        }

        return $this->render('tarifresto/new.html.twig', array(
            'tarifResto' => $tarifResto,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tarifResto entity.
     *
     */
    public function showAction(TarifResto $tarifResto)
    {
        $deleteForm = $this->createDeleteForm($tarifResto);

        return $this->render('tarifresto/show.html.twig', array(
            'tarifResto' => $tarifResto,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tarifResto entity.
     *
     */
    public function editAction(Request $request, TarifResto $tarifResto)
    {
        $deleteForm = $this->createDeleteForm($tarifResto);
        $editForm = $this->createForm('RestoDonBundle\Form\TarifRestoType', $tarifResto);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tarifresto_edit', array('idResto' => $tarifResto->getIdresto()));
        }

        return $this->render('tarifresto/edit.html.twig', array(
            'tarifResto' => $tarifResto,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tarifResto entity.
     *
     */
    public function deleteAction(Request $request, TarifResto $tarifResto)
    {
        $form = $this->createDeleteForm($tarifResto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tarifResto);
            $em->flush();
        }

        return $this->redirectToRoute('tarifresto_index');
    }

    /**
     * Creates a form to delete a tarifResto entity.
     *
     * @param TarifResto $tarifResto The tarifResto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TarifResto $tarifResto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tarifresto_delete', array('idResto' => $tarifResto->getIdresto())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
