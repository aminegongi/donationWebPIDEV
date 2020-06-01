<?php


namespace AideBundle\Controller;

use AideBundle\Entity\DemandeAide;
use AideBundle\Entity\ParticipationAide;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class ParticipationAideMobileController extends Controller
{
    public function addAction(Request $request){

        $participationAide = new ParticipationAide();
        $participationAide->setIdUser($this->getUtilisateur($request->get('user')));
        $participationAide->setIdDemande($this->getDemande($request->get('demande')));

        $em = $this->getDoctrine()->getManager();
        $em->persist($participationAide);
        $em->flush();

        $serializer= new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($participationAide);

        return new JsonResponse($formated);
    }

    // return all participation for a specific demande
    public function findAllForOneAction($id){
        $em = $this->getDoctrine()->getManager();

        $participationAides = $em->getRepository('AideBundle:ParticipationAide')->findByIdDemande($id);

        $res = array(
            'participationAides' => $participationAides,
        );
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($res);
        return new JsonResponse($formated);

    }

    // return all participation for a specific user
    public function findAllforOneUser($idUser){

        $em = $this->getDoctrine()->getManager();

        $participationAides = $em->getRepository('AideBundle:ParticipationAide')->findByIdUser($idUser);

        $res = array(
            'participationAides' => $participationAides,
        );
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($res);
        return new JsonResponse($formated);

    }


    public function deleteAction(Request $request){
        $idDmnd = $this->getDemande($request->get('demande'));
        $idUser = $this->getUtilisateur($request->get('user'));


        $em = $this->getDoctrine()->getManager();

        $participationAide = $em->getRepository('AideBundle:ParticipationAide')->findOneBy(array('idUser' => $idUser, 'idDemande' => $idDmnd));

        $em->remove($participationAide);
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