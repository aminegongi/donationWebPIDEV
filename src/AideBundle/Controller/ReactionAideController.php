<?php

namespace AideBundle\Controller;

use AideBundle\Entity\ReactionAide;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Reactionaide controller.
 *
 */
class ReactionAideController extends Controller
{
    /**
     * Lists all reactionAide entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reactionAides = $em->getRepository('AideBundle:ReactionAide')->findAll();

        return $this->render('reactionaide/index.html.twig', array(
            'reactionAides' => $reactionAides,
        ));
    }

    /**
     * Creates a new reactionAide entity.
     *
     */
    public function newAction(Request $request)
    {
        $reactionAide = new Reactionaide();
        $form = $this->createForm('AideBundle\Form\ReactionAideType', $reactionAide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reactionAide);
            $em->flush();

            return $this->redirectToRoute('reactionaide_show', array('id' => $reactionAide->getId()));
        }

        return $this->render('reactionaide/new.html.twig', array(
            'reactionAide' => $reactionAide,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a reactionAide entity.
     *
     */
    public function showAction(ReactionAide $reactionAide)
    {
        $deleteForm = $this->createDeleteForm($reactionAide);

        return $this->render('reactionaide/show.html.twig', array(
            'reactionAide' => $reactionAide,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reactionAide entity.
     *
     */
    public function editAction(Request $request, ReactionAide $reactionAide)
    {
        $deleteForm = $this->createDeleteForm($reactionAide);
        $editForm = $this->createForm('AideBundle\Form\ReactionAideType', $reactionAide);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reactionaide_edit', array('id' => $reactionAide->getId()));
        }

        return $this->render('reactionaide/edit.html.twig', array(
            'reactionAide' => $reactionAide,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reactionAide entity.
     *
     */
    public function deleteAction(Request $request, ReactionAide $reactionAide)
    {
        $form = $this->createDeleteForm($reactionAide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reactionAide);
            $em->flush();
        }

        return $this->redirectToRoute('reactionaide_index');
    }

    /**
     * Creates a form to delete a reactionAide entity.
     *
     * @param ReactionAide $reactionAide The reactionAide entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ReactionAide $reactionAide)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reactionaide_delete', array('id' => $reactionAide->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
