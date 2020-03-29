<?php

namespace AideBundle\Controller;

use AideBundle\Entity\CategorieAide;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Categorieaide controller.
 *
 */
class CategorieAideController extends Controller
{
    /**
     * Lists all categorieAide entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categorieAides = $em->getRepository('AideBundle:CategorieAide')->findAll();

        return $this->render('categorieaide/index.html.twig', array(
            'categorieAides' => $categorieAides,
        ));
    }

    /**
     * Creates a new categorieAide entity.
     *
     */
    public function newAction(Request $request)
    {
        $categorieAide = new Categorieaide();
        $form = $this->createForm('AideBundle\Form\CategorieAideType', $categorieAide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorieAide);
            $em->flush();

            return $this->redirectToRoute('categorieaide_show', array('id' => $categorieAide->getId()));
        }

        return $this->render('categorieaide/new.html.twig', array(
            'categorieAide' => $categorieAide,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a categorieAide entity.
     *
     */
    public function showAction(CategorieAide $categorieAide)
    {
        $deleteForm = $this->createDeleteForm($categorieAide);

        return $this->render('categorieaide/show.html.twig', array(
            'categorieAide' => $categorieAide,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing categorieAide entity.
     *
     */
    public function editAction(Request $request, CategorieAide $categorieAide)
    {
        $deleteForm = $this->createDeleteForm($categorieAide);
        $editForm = $this->createForm('AideBundle\Form\CategorieAideType', $categorieAide);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorieaide_edit', array('id' => $categorieAide->getId()));
        }

        return $this->render('categorieaide/edit.html.twig', array(
            'categorieAide' => $categorieAide,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a categorieAide entity.
     *
     */
    public function deleteAction(Request $request, CategorieAide $categorieAide)
    {
        $form = $this->createDeleteForm($categorieAide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categorieAide);
            $em->flush();
        }

        return $this->redirectToRoute('categorieaide_index');
    }

    /**
     * Creates a form to delete a categorieAide entity.
     *
     * @param CategorieAide $categorieAide The categorieAide entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CategorieAide $categorieAide)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categorieaide_delete', array('id' => $categorieAide->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
