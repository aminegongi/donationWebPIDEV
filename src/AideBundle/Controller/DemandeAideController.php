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

        $idcat ='';
        return $this->render('demandeaide/index.html.twig', array(
            'demandeAides' => $demandeAides,
            'categorieAides' => $this->getCategorie($idcat),
            'categories' => $this->allCategories(),
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



            $imageFile = $form->get('photo')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL

                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('AideImages_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $demandeAide->setPhoto($newFilename);
            }







            $em = $this->getDoctrine()->getManager();
            $em->persist($demandeAide);
            $em->flush();

            return $this->redirectToRoute('demandeaide_show', array('id' => $demandeAide->getId()));
        }
        $arr = [1 =>'a', 5 =>'b', 6 =>'c'];
        $a="";

        return $this->render('demandeaide/new.html.twig', array(
            'demandeAide' => $demandeAide,
            'form' => $form->createView(),
            'arr' =>$arr,
            'categories' => $this->allCategories(),
            'user' => $user = $this->get('security.token_storage')->getToken()->getUser()->getId(),
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

            $imageFile = $editForm->get('photo')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL

                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('AideImages_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $demandeAide->setPhoto($newFilename);
            }












            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('demandeaide_edit', array('id' => $demandeAide->getId()));
        }

        return $this->render('demandeaide/edit.html.twig', array(
            'demandeAide' => $demandeAide,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $user = $this->get('security.token_storage')->getToken()->getUser()->getId(),
            'categories' => $this->allCategories(),
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

    public function allCategories(){
        $em = $this->getDoctrine()->getManager();
        $categorieAides = $em->getRepository('AideBundle:CategorieAide')->findAll();
        return $categorieAides;
    }

    public function getCategorie($id){
        $em = $this->getDoctrine()->getManager();
        $categorieAide = $em->getRepository('AideBundle:CategorieAide')->find($id);
        return $categorieAide;
    }
}
