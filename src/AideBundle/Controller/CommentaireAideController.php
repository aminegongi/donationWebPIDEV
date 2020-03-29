<?php

namespace AideBundle\Controller;

use AideBundle\Entity\CommentaireAide;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Commentaireaide controller.
 *
 */
class CommentaireAideController extends Controller
{
    /**
     * Lists all commentaireAide entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commentaireAides = $em->getRepository('AideBundle:CommentaireAide')->findAll();

        return $this->render('commentaireaide/index.html.twig', array(
            'commentaireAides' => $commentaireAides,
        ));
    }

    /**
     * Creates a new commentaireAide entity.
     *
     */
    public function newAction(Request $request)
    {
        $commentaireAide = new Commentaireaide();
        $form = $this->createForm('AideBundle\Form\CommentaireAideType', $commentaireAide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaireAide);
            $em->flush();

            return $this->redirectToRoute('commentaireaide_show', array('id' => $commentaireAide->getId()));
        }

        return $this->render('commentaireaide/new.html.twig', array(
            'commentaireAide' => $commentaireAide,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commentaireAide entity.
     *
     */
    public function showAction(CommentaireAide $commentaireAide)
    {
        $deleteForm = $this->createDeleteForm($commentaireAide);

        return $this->render('commentaireaide/show.html.twig', array(
            'commentaireAide' => $commentaireAide,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commentaireAide entity.
     *
     */
    public function editAction(Request $request, CommentaireAide $commentaireAide)
    {
        $deleteForm = $this->createDeleteForm($commentaireAide);
        $editForm = $this->createForm('AideBundle\Form\CommentaireAideType', $commentaireAide);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commentaireaide_edit', array('id' => $commentaireAide->getId()));
        }

        return $this->render('commentaireaide/edit.html.twig', array(
            'commentaireAide' => $commentaireAide,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commentaireAide entity.
     *
     */
    public function deleteAction(Request $request, CommentaireAide $commentaireAide)
    {
        $form = $this->createDeleteForm($commentaireAide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commentaireAide);
            $em->flush();
        }

        return $this->redirectToRoute('commentaireaide_index');
    }

    /**
     * Creates a form to delete a commentaireAide entity.
     *
     * @param CommentaireAide $commentaireAide The commentaireAide entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CommentaireAide $commentaireAide)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commentaireaide_delete', array('id' => $commentaireAide->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
