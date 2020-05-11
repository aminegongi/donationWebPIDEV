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


        $mesDemandesPart = $this->findMesPartDmndAction($request->get('user'));

        $mesDemandesReact = $this->findMesReactDmndAction($request->get('user'));

        $demandesWithStatus = $this->insertStatus($listeDemandeAides,$mesDemandesPart,$mesDemandesReact);

        $idcat ='';
        $res =  array(

            'demandeWithStatus' =>  $demandesWithStatus,

            'demandeAides' => $listeDemandeAides,

            'demandePart' => $mesDemandesPart,

            'demandeReact' => $mesDemandesReact,

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
        $react=array();

        foreach ($listeDemandeAides as $dmnd) {

            $nbReaction = $this->getNbReaction($dmnd->getId());
            $dmndArr = array("demande" => $dmnd, "nbReaction" => $nbReaction);

            array_push($react, $dmndArr);
        }



        $res =  array(
            'demandeAides' => $react,

        );

        $serializer= new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($res);
        return new JsonResponse($formated);
    }

    //mes participations ==> retourne les demandes
    public function findMesPartDmndAction($idUser){
        $em = $this->getDoctrine()->getManager();
        $mesParticipatons = $em->getRepository('AideBundle:ParticipationAide')->findByIdUser($idUser);

        $demandes = array();

        foreach ($mesParticipatons as $part) {
            $dmnd = $part->getIdDemande();
            array_push($demandes, $dmnd);
        }

        return $demandes;
    }


    //mes reactions ==> retourne les demandes
    public function findMesReactDmndAction($idUser){
        $em = $this->getDoctrine()->getManager();
        $mesReactios = $em->getRepository('AideBundle:ReactionAide')->findByIdUser($idUser);

        $demandes = array();

        foreach ($mesReactios as $react) {
            $dmnd = $react->getIdDemande();
            array_push($demandes, $dmnd);
        }

        return $demandes;
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

    //insert status and number of reacts
    public function insertStatus($demandeAides, $mesDemandesPart, $mesDemandesReact){

        $res = array();




        foreach ($demandeAides as $dmnd) {

            $status = "none";

            if (in_array($dmnd, $mesDemandesPart)) {
               $status = "p" ;
            }

            if (in_array($dmnd, $mesDemandesReact)) {
                if($status == "none"){
                    $status = "r" ;
                }
                else {
                    $status = $status . "r";
                }
            }

            $nbReaction = $this->getNbReaction($dmnd->getId());
            $dmndArr = array("demande" => $dmnd, "status" => $status, "nbReaction" => $nbReaction);

            array_push($res, $dmndArr);
        }




        return $res;

    }


    // return nb reaction for specific dmnd
    public function getNbReaction($idDmnd){

        $em = $this->getDoctrine()->getManager();
        $nbReactionAides = $em->getRepository('AideBundle:ReactionAide')->nbReactParDmnd($idDmnd);
        return $nbReactionAides;
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