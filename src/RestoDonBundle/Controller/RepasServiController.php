<?php

namespace RestoDonBundle\Controller;

use RestoDonBundle\Entity\RepasServi;
use RestoDonBundle\Entity\TarifResto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Repasservi controller.
 *
 */
class RepasServiController extends Controller
{
    /**
     * Lists all repasServi entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repasServis = $em->getRepository('RestoDonBundle:RepasServi')->findAll();

        return $this->render('@RestoDon/repasservi/index.html.twig', array(
            'repasServis' => $repasServis,
        ));
    }

    /**
     * Creates a new repasServi entity.
     *
     */
    public function newAction(Request $request)
    {
        $repasServi = new Repasservi();
        $repasServi -> setDate(new \DateTime("-1 hour"));
        $form = $this->createForm('RestoDonBundle\Form\RepasServiType', $repasServi);
        $form->handleRequest($request);

        try {
            $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
            $tarifResto = $this->getDoctrine()->getRepository(TarifResto::class)->findByIdResto($user)[0];
            $porteF = (float)$tarifResto->getPortefeuilleVirtuel();
            $tarif = (float)$tarifResto->getTarif();
            $repasServi->setTarif($tarif);
            if ($porteF >= $tarif){
                $x = $porteF / $tarif;
                $count = floor($x);
                $state = "";
                $couleur= 'var(--my-color)';
            } else {
                $count = 0;
                $state = "disabled";
                $couleur= '#B33A3A';
            }
            $title = "$count Repas à servir!";
        } catch (\Exception $e){
            return $this->render('@RestoDon/repasservi/new.html.twig', array(
                'repasServi' => $repasServi,
                'form' => $form->createView(),
                'user' => $user = $this->get('security.token_storage')->getToken()->getUser()->getId(),
                'time' => strftime("%d-%m-%Y %H:%M"),
                'title' => "Vous devez ajouter un tarif à votre restaurant",
                'state' => 'disabled',
                'couleur' => "#B33A3A",
            ));
        }


        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
                $tarifResto = $this->getDoctrine()->getRepository(TarifResto::class)->findByIdResto($user)[0];
                $porteF = (float)$tarifResto->getPortefeuilleVirtuel();
                $tarif = (float)$tarifResto->getTarif();
                $repasServi->setTarif($tarif);
                $newPortF = $porteF - $tarif;
                $this->getDoctrine()->getRepository(TarifResto::class)->UpdatePorteFeuille($newPortF,$user)->execute();
            } catch (\Exception $e){
                var_dump("erreur servir repas");
            }
            $repasServi -> setDate(new \DateTime("-1 hour"));
            $em = $this->getDoctrine()->getManager();
            $em->persist($repasServi);
            $em->flush();

            return $this->redirectToRoute('resto_don_homepage', array('idRepas' => $repasServi->getIdRepas()));

        }

        return $this->render('@RestoDon/repasservi/new.html.twig', array(
            'repasServi' => $repasServi,
            'form' => $form->createView(),
            'user' => $user = $this->get('security.token_storage')->getToken()->getUser()->getId(),
            'time' => strftime("%d-%m-%Y %H:%M"),
            'title' => $title,
            'state' => $state,
            'couleur' => $couleur,
        ));
    }

    /**
     * Finds and displays a repasServi entity.
     *
     */
    public function showAction(RepasServi $repasServi)
    {
        $deleteForm = $this->createDeleteForm($repasServi);

        return $this->render('@RestoDon/repasservi/show.html.twig', array(
            'repasServi' => $repasServi,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing repasServi entity.
     *
     */
    public function editAction(Request $request, RepasServi $repasServi)
    {
        $deleteForm = $this->createDeleteForm($repasServi);
        $editForm = $this->createForm('RestoDonBundle\Form\RepasServiType', $repasServi);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('repasservi_edit', array('idRepas' => $repasServi->getIdRepas()));
        }

        return $this->render('@RestoDon/repasservi/edit.html.twig', array(
            'repasServi' => $repasServi,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a repasServi entity.
     *
     */
    public function deleteAction(Request $request, RepasServi $repasServi)
    {
        $form = $this->createDeleteForm($repasServi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($repasServi);
            $em->flush();
        }

        return $this->redirectToRoute('repasservi_index');
    }

    /**
     * Creates a form to delete a repasServi entity.
     *
     * @param RepasServi $repasServi The repasServi entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RepasServi $repasServi)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('repasservi_delete', array('idRepas' => $repasServi->getIdRepas())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
