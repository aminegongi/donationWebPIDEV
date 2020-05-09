<?php


namespace AideBundle\Controller;

use AideBundle\Entity\DemandeAide;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DemandeAideMobileController extends Controller
{

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $listeDemandeAides = $em->getRepository('AideBundle:DemandeAide')->findAll();

        $idcat ='';
        $res =  array(
            'demandeAides' => $listeDemandeAides,

            'categories' => $this->allCategories(),
        );

        $serializer= new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($res);
        return new JsonResponse($formated);
    }

    public function findAction( $id)
    {
        $em = $this->getDoctrine()->getManager();

        $demandeAide = $em->getRepository('AideBundle:DemandeAide')->find($id);


        $serializer= new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($demandeAide);
        return new JsonResponse($formated);
    }

    public function findAllForOneCatAction($id){
        $em = $this->getDoctrine()->getManager();

        $listeDemandeAides = $em->getRepository('AideBundle:DemandeAide')->findByIdCategorie($id);


        $res =  array(
            'demandeAides' => $listeDemandeAides,

        );

        $serializer= new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($res);
        return new JsonResponse($formated);

    }

    public function findMesDemandesAction($iduser){
        //$idUser = $this->get('security.token_storage')->getToken()->getUser()->getId();

        $em = $this->getDoctrine()->getManager();
        $listeDemandeAides = $em->getRepository('AideBundle:DemandeAide')->findByIdUser($iduser);

        $res =  array(
            'demandeAides' => $listeDemandeAides,

        );

        $serializer= new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($res);
        return new JsonResponse($formated);
    }


    public function addAction(Request $request)
    {


        $em = $this->getDoctrine()->getManager();
        $demandeAide = new Demandeaide();
        $demandeAide->setIdUser($this->getUtilisateur($request->get('user')));
        $demandeAide->setPhoto($request->get('photo'));
        $demandeAide->setTitre($request->get('titre'));
        $demandeAide->setDescription($request->get('description'));
        $demandeAide->setIdCategorie($this->getCategorie($request->get('categorie')));
        $demandeAide->setEtat($request->get('etat'));
        $demandeAide->setNbReactions($request->get('nbreaction'));



        $em->persist($demandeAide);
        $em->flush();


        $serializer= new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($demandeAide);
        return new JsonResponse($formated);
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

    public function getUtilisateur($id){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->find($id);
        return $user;
    }



}