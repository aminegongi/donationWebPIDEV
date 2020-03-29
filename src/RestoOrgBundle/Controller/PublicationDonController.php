<?php

namespace RestoOrgBundle\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use RestoOrgBundle\Entity\PublicationDon;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Publicationdon controller.
 *
 */
class PublicationDonController extends Controller
{
    /**
     * Lists all publicationDon entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $publicationDons = $em->getRepository('RestoOrgBundle:PublicationDon')->findAll();

        return $this->render('@RestoOrg/publicationdon/index.html.twig', array('publicationDons' => $publicationDons,'connectedUser'=>$this->getUser()));
    }

    /**
     * Creates a new publicationDon entity.
     *
     */
    public function newAction(Request $request)
    {
        $publicationDon = new Publicationdon();

        $form = $this->createForm('RestoOrgBundle\Form\PublicationDonType', $publicationDon);
        $tab=$this->getUser()->getRoles();
        $userRole=$tab[0];
        //dump($userRole);
        if($userRole=='ROLE_RES')
            $form->add('type', HiddenType::class, ['required'=> false,'empty_data' => 'OffreDon']);
        elseif ($userRole=='ROLE_ORG')
            $form->add('nbrePlat',null, ['attr' => ['class' => 'form-control'],])
                ->add('type', HiddenType::class, ['required'=> false,'empty_data' => 'AppelAuDon']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            dump($this->getUser());
            $publicationDon->setAjoutePar($this->getUser());
            $em->persist($publicationDon);
            $em->flush();

            return $this->redirectToRoute('publicationdon_index');
        }

        return $this->render('@RestoOrg/publicationdon//new.html.twig', array(
            'publicationDon' => $publicationDon,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a publicationDon entity.
     *
     */
    public function showAction(PublicationDon $publicationDon)
    {
        $deleteForm = $this->createDeleteForm($publicationDon);

        return $this->render('@RestoOrg/publicationdon//show.html.twig', array(
            'publicationDon' => $publicationDon,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing publicationDon entity.
     *
     */
    public function editAction(Request $request, PublicationDon $publicationDon)
    {
        $deleteForm = $this->createDeleteForm($publicationDon);
        $editForm = $this->createForm('RestoOrgBundle\Form\PublicationDonType', $publicationDon);
        $tab=$this->getUser()->getRoles();
        $userRole=$tab[0];
        if($userRole=='ROLE_RES')
            $editForm->add('type', HiddenType::class, ['required'=> false,'empty_data' => 'OffreDon']);
        elseif ($userRole=='ROLE_ORG')
            $editForm->add('nbrePlat')->add('type', HiddenType::class, ['required'=> false,'empty_data' => 'AppelAuDon']);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publicationdon_edit', array('id' => $publicationDon->getId()));
        }

        return $this->render('@RestoOrg/publicationdon//edit.html.twig', array(
            'publicationDon' => $publicationDon,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a publicationDon entity.
     *
     */
    public function deleteAction(Request $request, PublicationDon $publicationDon)
    {
        $form = $this->createDeleteForm($publicationDon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($publicationDon);
            $em->flush();
        }

        return $this->redirectToRoute('publicationdon_index');
    }

    /**
     * Creates a form to delete a publicationDon entity.
     *
     * @param PublicationDon $publicationDon The publicationDon entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PublicationDon $publicationDon)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('publicationdon_delete', array('id' => $publicationDon->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
