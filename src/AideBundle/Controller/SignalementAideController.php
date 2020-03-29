<?php

namespace AideBundle\Controller;

use AideBundle\Entity\SignalementAide;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Signalementaide controller.
 *
 */
class SignalementAideController extends Controller
{
    /**
     * Lists all signalementAide entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $signalementAides = $em->getRepository('AideBundle:SignalementAide')->findAll();

        return $this->render('signalementaide/index.html.twig', array(
            'signalementAides' => $signalementAides,
        ));
    }

    /**
     * Creates a new signalementAide entity.
     *
     */
    public function newAction(Request $request)
    {
        $signalementAide = new Signalementaide();
        $form = $this->createForm('AideBundle\Form\SignalementAideType', $signalementAide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($signalementAide);
            $em->flush();

            return $this->redirectToRoute('signalementaide_show', array('id' => $signalementAide->getId()));
        }

        return $this->render('signalementaide/new.html.twig', array(
            'signalementAide' => $signalementAide,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a signalementAide entity.
     *
     */
    public function showAction(SignalementAide $signalementAide)
    {
        $deleteForm = $this->createDeleteForm($signalementAide);

        return $this->render('signalementaide/show.html.twig', array(
            'signalementAide' => $signalementAide,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing signalementAide entity.
     *
     */
    public function editAction(Request $request, SignalementAide $signalementAide)
    {
        $deleteForm = $this->createDeleteForm($signalementAide);
        $editForm = $this->createForm('AideBundle\Form\SignalementAideType', $signalementAide);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('signalementaide_edit', array('id' => $signalementAide->getId()));
        }

        return $this->render('signalementaide/edit.html.twig', array(
            'signalementAide' => $signalementAide,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a signalementAide entity.
     *
     */
    public function deleteAction(Request $request, SignalementAide $signalementAide)
    {
        $form = $this->createDeleteForm($signalementAide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($signalementAide);
            $em->flush();
        }

        return $this->redirectToRoute('signalementaide_index');
    }

    /**
     * Creates a form to delete a signalementAide entity.
     *
     * @param SignalementAide $signalementAide The signalementAide entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SignalementAide $signalementAide)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('signalementaide_delete', array('id' => $signalementAide->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
