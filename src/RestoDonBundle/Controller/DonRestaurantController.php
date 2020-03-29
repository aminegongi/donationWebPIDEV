<?php

namespace RestoDonBundle\Controller;

use RestoDonBundle\Entity\DonRestaurant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Donrestaurant controller.
 *
 */
class DonRestaurantController extends Controller
{
    /**
     * Lists all donRestaurant entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $donRestaurants = $em->getRepository('RestoDonBundle:DonRestaurant')->findAll();

        return $this->render('donrestaurant/index.html.twig', array(
            'donRestaurants' => $donRestaurants,
        ));
    }

    /**
     * Creates a new donRestaurant entity.
     *
     */
    public function newAction(Request $request)
    {
        $donRestaurant = new Donrestaurant();
        $form = $this->createForm('RestoDonBundle\Form\DonRestaurantType', $donRestaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($donRestaurant);
            $em->flush();

            return $this->redirectToRoute('donrestaurant_show', array('idDon' => $donRestaurant->getIddon()));
        }

        return $this->render('donrestaurant/new.html.twig', array(
            'donRestaurant' => $donRestaurant,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a donRestaurant entity.
     *
     */
    public function showAction(DonRestaurant $donRestaurant)
    {
        $deleteForm = $this->createDeleteForm($donRestaurant);

        return $this->render('donrestaurant/show.html.twig', array(
            'donRestaurant' => $donRestaurant,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing donRestaurant entity.
     *
     */
    public function editAction(Request $request, DonRestaurant $donRestaurant)
    {
        $deleteForm = $this->createDeleteForm($donRestaurant);
        $editForm = $this->createForm('RestoDonBundle\Form\DonRestaurantType', $donRestaurant);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('donrestaurant_edit', array('idDon' => $donRestaurant->getIddon()));
        }

        return $this->render('donrestaurant/edit.html.twig', array(
            'donRestaurant' => $donRestaurant,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a donRestaurant entity.
     *
     */
    public function deleteAction(Request $request, DonRestaurant $donRestaurant)
    {
        $form = $this->createDeleteForm($donRestaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($donRestaurant);
            $em->flush();
        }

        return $this->redirectToRoute('donrestaurant_index');
    }

    /**
     * Creates a form to delete a donRestaurant entity.
     *
     * @param DonRestaurant $donRestaurant The donRestaurant entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DonRestaurant $donRestaurant)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('donrestaurant_delete', array('idDon' => $donRestaurant->getIddon())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
