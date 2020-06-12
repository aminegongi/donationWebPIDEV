<?php

namespace AideBundle\Controller;

use AideBundle\Entity\CategorieAide;
use AideBundle\Entity\DemandeAide;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


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


        $total = $this->nbDmndEachCat();
        $totalSig = $this->nbDmndSigEachCat();
        $totalConf = $this->nbDmndConfEachCat();
        $rating = $this->getCatRating();

        return $this->render('categorieaide/index.html.twig', array(
            'categorieAides' => $categorieAides,
            'total' => $total,
            'totalSig'=>$totalSig,
            'totalConf'=>$totalConf,
            'rating'=>$rating,

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


            $imageFile = $form->get('icone')->getData();
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
                $categorieAide->setIcone($newFilename);
            }









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

        $icn = $categorieAide->getIcone();
        $deleteForm = $this->createDeleteForm($categorieAide);
        $editForm = $this->createForm('AideBundle\Form\CategorieAideType', $categorieAide);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {




            $imageFile = $editForm->get('icone')->getData();
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
                $categorieAide->setIcone($newFilename);
            }
            else {
                $categorieAide->setIcone($icn);
            }

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

    // retourne le nombre de demandes totale pour chaque categorie
    public function nbDmndEachCat(){

        $em = $this->getDoctrine()->getManager();
        $categorieAides = $em->getRepository('AideBundle:CategorieAide')->findAll();

        $arrIdCat= array();
        //initialized with one element at index 0
        //to start adding later from index 1 not 0 same IDs as categories index = id of one categorie
        //prevent view's error
        $arrRes= array('a');

        foreach ($categorieAides as $categorie) {

            array_push($arrIdCat, $categorie->getId());
        }

        foreach ($arrIdCat as $idCategorie) {
            $nbDmnds = $em->getRepository('AideBundle:DemandeAide')->nbDmndParCat($idCategorie);
            array_push($arrRes, [$idCategorie => $nbDmnds]);
        }

        return $arrRes;

    }

    // retourne le nombre de demandes signalées pour chaque categorie
    public function nbDmndSigEachCat(){

        $em = $this->getDoctrine()->getManager();
        $categorieAides = $em->getRepository('AideBundle:CategorieAide')->findAll();

        $arrIdCat= array();
        //initialized with one element at index 0
        //to start adding later from index 1 not 0 same IDs as categories index = id of one categorie
        //prevent view's error
        $arrRes= array('a');

        foreach ($categorieAides as $categorie) {

            array_push($arrIdCat, $categorie->getId());
        }

        foreach ($arrIdCat as $idCategorie) {
            $nbDmnds = $em->getRepository('AideBundle:DemandeAide')->nbDmndSigParCat($idCategorie);
            array_push($arrRes, [$idCategorie => $nbDmnds]);
        }

        return $arrRes;

    }


    // retourne le nombre de demandes confirmées pour chaque categorie
    public function nbDmndConfEachCat(){

        $em = $this->getDoctrine()->getManager();
        $categorieAides = $em->getRepository('AideBundle:CategorieAide')->findAll();

        $arrIdCat= array();
        //initialized with one element at index 0
        //to start adding later from index 1 not 0 same IDs as categories index = id of one categorie
        //prevent view's error
        $arrRes= array('a');

        foreach ($categorieAides as $categorie) {

            array_push($arrIdCat, $categorie->getId());
        }

        foreach ($arrIdCat as $idCategorie) {
            $nbDmnds = $em->getRepository('AideBundle:DemandeAide')->nbDmndConfParCat($idCategorie);
            array_push($arrRes, [$idCategorie => $nbDmnds]);
        }

        return $arrRes;

    }

   // pour l' app mobile
    public function allAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categorieAides = $em->getRepository('AideBundle:CategorieAide')->findAll();

        $serializer= new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize( $categorieAides);
        return new JsonResponse($formated);
    }

    //retourne le rating du categorie pour remplir les "etoiles"
    public function getCatRating(){
         //initialized with one element at index 0
        //to start adding later from index 1 not 0 same IDs as categories index = id of one categorie
        //prevent view's error
        $arrRes= array('a');
        $arrIdCat= array();
        $em = $this->getDoctrine()->getManager();
        $categorieAides = $em->getRepository('AideBundle:CategorieAide')->findAll();

        $nbrTotaleDmnd = $this->nbDmndEachCat();
        $nbrConfDmnd = $this->nbDmndConfEachCat();

        $rating=0;




        foreach ($categorieAides as $categorie) {

            array_push($arrIdCat, $categorie->getId());
        }






        foreach ($arrIdCat as $idCategorie) {
        //$nbDmnds = $em->getRepository('AideBundle:DemandeAide')->nbDmndConfParCat($idCategorie);

            if($nbrTotaleDmnd[$idCategorie][$idCategorie] == 0)
                $rating=0;
else {
        $moy = ($nbrConfDmnd[$idCategorie][$idCategorie]/ $nbrTotaleDmnd[$idCategorie][$idCategorie]);

        if ($moy == 0)
          $rating = 0;

      elseif ($moy > 0.75)
          $rating = 4;

      elseif ($moy > 0.5)
            $rating = 3;
      elseif ($moy > 0.25)
          $rating = 2;
      else
          $rating = 1;
            }


        array_push($arrRes, [$idCategorie => $rating]);
}


        return $arrRes;


    }


    }
