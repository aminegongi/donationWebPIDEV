<?php


namespace AideBundle\Controller;


use AideBundle\Entity\ParticipationAide;
use AideBundle\Entity\ReactionAide;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ReactionAideMobileController extends Controller
{

    public function addAction(Request $request){

        $reactionAide = new ReactionAide();
        $reactionAide->setIdUser($this->getUtilisateur($request->get('user')));
        $reactionAide->setIdDemande($this->getDemande($request->get('demande')));

        $em = $this->getDoctrine()->getManager();
        $em->persist($reactionAide);
        $em->flush();

        $serializer= new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($reactionAide);

        return new JsonResponse($formated);
    }


    // return all reactionAide for a specific demande
    public function findAllForOneAction($id){
        $em = $this->getDoctrine()->getManager();

        $reactionAides = $em->getRepository('AideBundle:ReactionAide')->findByIdDemande($id);

        $res = array(
            'reactionAides' => $reactionAides,
        );
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($res);
        return new JsonResponse($formated);

    }


    public function deleteAction(Request $request){
        $idDmnd = $this->getDemande($request->get('demande'));
        $idUser = $this->getUtilisateur($request->get('user'));


        $em = $this->getDoctrine()->getManager();

        $reactionAide = $em->getRepository('AideBundle:ReactionAide')->findOneBy(array('idUser' => $idUser, 'idDemande' => $idDmnd));

        $em->remove($reactionAide);
        $em->flush();

        return $this->findAllForOneAction($idDmnd);
    }


    public function getDemande($id){
        $em = $this->getDoctrine()->getManager();
        $demandeAide = $em->getRepository('AideBundle:DemandeAide')->find($id);
        return $demandeAide;
    }


    public function getUtilisateur($id){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->find($id);
        return $user;
    }
}