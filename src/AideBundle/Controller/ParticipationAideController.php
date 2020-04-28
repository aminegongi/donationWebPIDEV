<?php

namespace AideBundle\Controller;

use AideBundle\Entity\DemandeAide;
use AideBundle\Entity\ParticipationAide;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Participationaide controller.
 *
 */
class ParticipationAideController extends Controller
{
    /**
     * Lists all participationAide entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $participationAides = $em->getRepository('AideBundle:ParticipationAide')->findAll();

        return $this->render('participationaide/index.html.twig', array(
            'participationAides' => $participationAides,
        ));
    }

    /**
     * Creates a new participationAide entity.
     *
     */
    public function newAction(Request $request, $id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $idDmnd = $this->getDoctrine()->getRepository(DemandeAide::class)->find($id);

//        var_dump($idDmnd);
//        die();



        $participationAide = new Participationaide();
        $form = $this->createForm('AideBundle\Form\ParticipationAideType', $participationAide);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $participationAide->setIdDemande($idDmnd);
            $participationAide->setIdUser($user);
        }


        if ($form->isSubmitted() && $form->isValid()) {

//            $participationAide->setIdDemande($idDmnd);
//            $participationAide->setIdUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($participationAide);
            $em->flush();

            return $this->redirectToRoute('participationaide_show', array('id' => $participationAide->getId()));
        }

        return $this->render('participationaide/new.html.twig', array(
            'participationAide' => $participationAide,
            'form' => $form->createView(),
            'idDmnd'=> $id,

        ));
    }

    /**
     * Finds and displays a participationAide entity.
     *
     */
    public function showAction(ParticipationAide $participationAide)
    {
        $deleteForm = $this->createDeleteForm($participationAide);

        return $this->render('participationaide/show.html.twig', array(
            'participationAide' => $participationAide,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing participationAide entity.
     *
     */
    public function editAction(Request $request, ParticipationAide $participationAide)
    {
        $deleteForm = $this->createDeleteForm($participationAide);
        $editForm = $this->createForm('AideBundle\Form\ParticipationAideType', $participationAide);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('participationaide_edit', array('id' => $participationAide->getId()));
        }

        return $this->render('participationaide/edit.html.twig', array(
            'participationAide' => $participationAide,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a participationAide entity.
     *
     */
    public function deleteAction(Request $request, ParticipationAide $participationAide)
    {
        $form = $this->createDeleteForm($participationAide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($participationAide);
            $em->flush();
        }

        return $this->redirectToRoute('participationaide_index');
    }

    /**
     * Creates a form to delete a participationAide entity.
     *
     * @param ParticipationAide $participationAide The participationAide entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ParticipationAide $participationAide)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('participationaide_delete', array('id' => $participationAide->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
