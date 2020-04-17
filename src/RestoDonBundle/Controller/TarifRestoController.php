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

        return $this->render('@RestoDon/tarifresto/index.html.twig', array(
            'tarifRestos' => $tarifRestos,
        ));
    }

    /**
     * Creates a new tarifResto entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $tarifResto = new Tarifresto();
        try {
            $resto = $this->getDoctrine()->getRepository(TarifResto::class)->findByIdResto($user)[0];
            $porteF = $resto->getPortefeuilleVirtuel();
            $tarifResto->setPortefeuilleVirtuel($porteF);
        } catch (\Exception $e){
            $tarifResto->setPortefeuilleVirtuel(0.000);
        }


        $form = $this->createForm('RestoDonBundle\Form\TarifRestoType', $tarifResto);
        $form->handleRequest($request);

//

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($tarifResto);
            $em->flush();

            return $this->redirectToRoute('tarifresto_show', array('idTarif' => $tarifResto->getIdtarif()));

        }

        return $this->render('@RestoDon/tarifresto/new.html.twig', array(
            'tarifResto' => $tarifResto,
            'form' => $form->createView(),
            'user' => $user = $this->get('security.token_storage')->getToken()->getUser()->getId(),
        ));

    }

    /**
     * Finds and displays a tarifResto entity.
     *
     */
    public function showAction(TarifResto $tarifResto)
    {
        $deleteForm = $this->createDeleteForm($tarifResto);

        return $this->render('@RestoDon/tarifresto/show.html.twig', array(
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

            return $this->redirectToRoute('tarifresto_edit', array('idTarif' => $tarifResto->getIdTarif()));
        }

        return $this->render('@RestoDon/tarifresto/edit.html.twig', array(
            'tarifResto' => $tarifResto,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $user = $this->get('security.token_storage')->getToken()->getUser()->getId(),
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
            ->setAction($this->generateUrl('tarifresto_delete', array('idTarif' => $tarifResto->getIdTarif())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
