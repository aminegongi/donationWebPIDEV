<?php

namespace CagnotteBundle\Controller;

use CagnotteBundle\Entity\cagnotte;
use CagnotteBundle\Form\cagnotteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class cagnotteMobileController extends Controller
{
    //Cagnotte/getCagnottesMobile?user=x
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $cagnottes = $em->getRepository('CagnotteBundle:cagnotte')->findAll();
        $ret = $cagnottes;
        $ser = new Serializer([new ObjectNormalizer()]);
        $json = $ser->normalize($ret);
        return new JsonResponse($json);
    }

    //Cagnotte/newCagnotteMobile?user=x&nom=x&montant_demande=x&id_categorie=x
    public function newAction(Request $request){
        $cagnotte = new cagnotte();
        $cagnotte->setNom((string)$request->get("nom"));
        $cagnotte->setDateDeDebut(new \DateTime('now'));
        $cagnotte->setDateDeFin(new \DateTime('now'));
        $cagnotte->setMontantDemande((float)$request->get("montant_demande"));

        $cagnotte->setDateDeCreation(new \DateTime('now'));
        $cagnotte->setIdProprietaire((int)$request->get("user"));
        $cagnotte->setMontantActuel(0);
        $cagnotte->setIdOrganisation(0);
        $cagnotte->setEtat(0);

        $em = $this->getDoctrine()->getManager();
        $em->persist($cagnotte);
        $em->flush();
        $ser = new Serializer([new ObjectNormalizer()]);
        $ret = "Cagnotte ajoutee";
        $json = $ser->normalize($ret);
        return new JsonResponse($json);
    }

    //Cagnotte/editCagnotteMobile?user=x&id=x?nom=x&montant_demande=x&id_categorie=x
    //public function editAction(Request $request){
    //    $cagnotte = new cagnotte();
    //    $cagnotte->setNom((string)$request->get("nom"));
    //    $cagnotte->setDateDeDebut(new \DateTime('now'));
    //   $cagnotte->setDateDeFin(new \DateTime('now'));
    //   $cagnotte->setMontantDemande((float)$request->get("montant_demande"));
    //   $cagnotte->setIdOrganisation(0);
    //   $cagnotte->setEtat(0);

    //   $em = $this->getDoctrine()->getManager();
    //   $em->persist($cagnotte);
    //    $em->flush();
    //    $ser = new Serializer([new ObjectNormalizer()]);
    //    $ret = "Cagnotte ajoutee";
    //    $json = $ser->normalize($ret);
    //    return new JsonResponse($json);
    // }

    //public function deleteAction($id){
    //    $tab=$this->getUser()->getRoles();
    //   $userRole=$tab[0];
    //    if (($userRole == 'ROLE_US') || ($userRole == 'ROLE_ORG')){
    //        $em = $this->getDoctrine()->getManager();
    //        $cagnotte = $em->getRepository('CagnotteBundle:cagnotte')->find($id);
    //        $em->remove($cagnotte);
    //       $em->flush();
    //       return $this->redirectToRoute('cagnotte_homepage');
    //   }
    //   else{
    //       return $this->render('@Cagnotte/Cagnotte/error.html.twig');
    //    }
    //}

    //Cagnotte/showCagnotteMobile?user=x&id=x
    public function showAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $selected = $em->getRepository('CagnotteBundle:cagnotte')->find((int)$request->get("id"));
        $ret = $selected;
        $ser = new Serializer([new ObjectNormalizer()]);
        $json = $ser->normalize($ret);
        return new JsonResponse($json);
    }

    //Cagnotte/prendreCagnotteMobile?user=x&id=x
    public function prendreAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $selected = $em->getRepository('CagnotteBundle:cagnotte')->find((int)$request->get("id"));
        $selected->setIdOrganisation((int)$request->get("user"));
        $selected->setEtat(1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($selected);
        $em->flush();
        $ret = "OK";
        $ser = new Serializer([new ObjectNormalizer()]);
        $json = $ser->normalize($ret);
        return new JsonResponse($json);
    }

    //Cagnotte/donateCagnotteMobile?user=x&id=x&montant=x
    public function donateAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $selected = $em->getRepository('CagnotteBundle:cagnotte')->find((int)$request->get("id"));
        $selected->setMontantActuel($selected->getMontantActuel() + (float)$request->get("montant"));
        if ($selected->getMontantActuel() >= $selected->getMontantDemande()){
            $selected->setEtat(2);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($selected);
        $em->flush();
        $ret = "OK";
        $ser = new Serializer([new ObjectNormalizer()]);
        $json = $ser->normalize($ret);
        return new JsonResponse($json);
    }
}
