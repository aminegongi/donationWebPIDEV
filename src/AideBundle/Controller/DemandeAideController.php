<?php

namespace AideBundle\Controller;

use AideBundle\Entity\DemandeAide;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
    public function indexAction(Request $request)
    {/*
        $em = $this->getDoctrine()->getManager();

        $demandeAides = $em->getRepository('AideBundle:DemandeAide')->findAll();

        $idcat ='';
        return $this->render('demandeaide/index.html.twig', array(
            'demandeAides' => $demandeAides,
            'categorieAides' => $this->getCategorie($idcat),
            'categories' => $this->allCategories(),
        ));
    */
        $comboCat = $request->get('catCombo');
        $em = $this->getDoctrine()->getManager();
        if($comboCat){
        if ($comboCat == "all")
        {$listeDemandeAides = $em->getRepository('AideBundle:DemandeAide')->findAll();}
        else {
            $listeDemandeAides = $em->getRepository('AideBundle:DemandeAide')->findByIdCategorie($comboCat);
        }
        }
        else{
            $listeDemandeAides = $em->getRepository('AideBundle:DemandeAide')->findAll();
        }
        $demandeAides  = $this->get('knp_paginator')->paginate(
            $listeDemandeAides,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            9/*nbre d'éléments par page*/
        );

        $idcat ='';
        $ConnectedUser = $this->get('security.token_storage')->getToken()->getUser();
        //var_dump($ConnectedUser);
        //die();
        return $this->render('demandeaide/index.html.twig', array(
            'demandeAides' => $demandeAides,
            'categorieAides' => $this->getCategorie($idcat),
            'categories' => $this->allCategories(),
            'utilisateur' => $ConnectedUser,
        ));
    }



    public function mesDmndAction(Request $request){
        $ConnectedUser = $this->get('security.token_storage')->getToken()->getUser();
        $comboCat = $request->get('catCombo');
        $em = $this->getDoctrine()->getManager();
        if($comboCat){
            if ($comboCat == "all")
            {$listeDemandeAides = $em->getRepository('AideBundle:DemandeAide')->findByIdUser($ConnectedUser);}
            else {
               // $listeDemandeAides = $em->getRepository('AideBundle:DemandeAide')->findByIdCategorie($comboCat);
                $listeDemandeAides = $em->getRepository('AideBundle:DemandeAide')->findBy(array('idCategorie' => $comboCat, 'idUser' => $ConnectedUser));
            }
        }
        else{
            $listeDemandeAides = $em->getRepository('AideBundle:DemandeAide')->findByIdUser($ConnectedUser);
        }
        $demandeAides  = $this->get('knp_paginator')->paginate(
            $listeDemandeAides,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            9/*nbre d'éléments par page*/
        );

        $idcat ='';
        $ConnectedUser = $this->get('security.token_storage')->getToken()->getUser();
        return $this->render('demandeaide/indexmine.html.twig', array(
            'demandeAides' => $demandeAides,
            'categorieAides' => $this->getCategorie($idcat),
            'categories' => $this->allCategories(),
            'utilisateur' => $ConnectedUser,
        ));
    }




    public function findAllForOneCatAction(Request $request, $id){

        $em = $this->getDoctrine()->getManager();

        $listeDemandeAides = $em->getRepository('AideBundle:DemandeAide')->findByIdCategorie($id);
        $demandeAides  = $this->get('knp_paginator')->paginate(
            $listeDemandeAides,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            9/*nbre d'éléments par page*/
        );

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

           // return $this->redirectToRoute('demandeaide_show', array('id' => $demandeAide->getId()));
            return $this->redirectToRoute('demandeaide_index');
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


    public function showMaDmndAction(DemandeAide $demandeAide)
    {
        $deleteForm = $this->createDeleteForm($demandeAide);

        $participations = $this->getParticipations($demandeAide->getId());

        return $this->render('demandeaide/showMaDmnd.html.twig', array(
            'demandeAide' => $demandeAide,
            'delete_form' => $deleteForm->createView(),
            'participations' => $participations,
        ));
    }

    /**
     * Displays a form to edit an existing demandeAide entity.
     *
     */
    public function editAction(Request $request, DemandeAide $demandeAide)
    {
        $idCatActual = $demandeAide->getIdCategorie()->getId();
        $photo = $demandeAide->getPhoto();
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

            else {
                $demandeAide->setPhoto($photo);
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
            'catActualId' => $idCatActual,
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

    public function getParticipations($idDmnd){
        $em = $this->getDoctrine()->getManager();
        $participationsAide = $em->getRepository('AideBundle:ParticipationAide')->findByIdDemande($idDmnd);
        return $participationsAide;
    }




}
