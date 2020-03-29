<?php

namespace AideBundle\Controller;

use AideBundle\Entity\DemandeAide;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Demandeaide controller.
 *
 */
class DemandeAideController extends Controller
{
    /**
     * Lists all demandeAide entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $demandeAides = $em->getRepository('AideBundle:DemandeAide')->findAll();

        return $this->render('demandeaide/index.html.twig', array(
            'demandeAides' => $demandeAides,
        ));
    }

    /**
     * Creates a new demandeAide entity.
     *
     */
    public function newAction(Request $request)
    {
        $demandeAide = new Demandeaide();
        $form = $this->createForm('AideBundle\Form\DemandeAideType', $demandeAide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($demandeAide);
            $em->flush();

            return $this->redirectToRoute('demandeaide_show', array('id' => $demandeAide->getId()));
        }

        return $this->render('demandeaide/new.html.twig', array(
            'demandeAide' => $demandeAide,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a demandeAide entity.
     *
     */
    public function showAction(DemandeAide $demandeAide)
    {
        $deleteForm = $this->createDeleteForm($demandeAide);

        return $this->render('demandeaide/show.html.twig', array(
            'demandeAide' => $demandeAide,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing demandeAide entity.
     *
     */
    public function editAction(Request $request, DemandeAide $demandeAide)
    {
        $deleteForm = $this->createDeleteForm($demandeAide);
        $editForm = $this->createForm('AideBundle\Form\DemandeAideType', $demandeAide);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('demandeaide_edit', array('id' => $demandeAide->getId()));
        }

        return $this->render('demandeaide/edit.html.twig', array(
            'demandeAide' => $demandeAide,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a demandeAide entity.
     *
     */
    public function deleteAction(Request $request, DemandeAide $demandeAide)
    {
        $form = $this->createDeleteForm($demandeAide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($demandeAide);
            $em->flush();
        }

        return $this->redirectToRoute('demandeaide_index');
    }

    /**
     * Creates a form to delete a demandeAide entity.
     *
     * @param DemandeAide $demandeAide The demandeAide entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DemandeAide $demandeAide)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('demandeaide_delete', array('id' => $demandeAide->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
