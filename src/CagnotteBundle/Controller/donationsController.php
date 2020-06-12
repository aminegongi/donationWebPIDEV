<?php

namespace CagnotteBundle\Controller;

use CagnotteBundle\Entity\donations;
use CagnotteBundle\Entity\cagnotte;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class donationsController extends Controller{
    public function newAction($nom, $methode, $montant){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($user == "anon."){
            return $this->render('@Cagnotte/Cagnotte/error.html.twig');
        }

        $donation = new donations();
        $donation->setNom($nom);
        $donation->setIdUtilisateur($user->getId());
        $donation->setDateDon(new \DateTime('now'));
        $donation->setMethode($methode);
        $donation->setMontant($montant);
        $em = $this->getDoctrine()->getManager();
        $em->persist($donation);
        $em->flush();
        return $this->redirectToRoute('cagnotte_success');
    }

    public function getNombreCagottes(){

    }

    public function dashboardAction(){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($user == "anon."){
            return $this->render('@Cagnotte/Cagnotte/error.html.twig');
        }
        $tab = $this->getUser()->getRoles();
        $userRole=$tab[0];
        if ($userRole != 'ROLE_ADMIN'){
            return $this->render('@Cagnotte/Cagnotte/error.html.twig');
        }

        $em = $this->getDoctrine()->getManager();
        $cagnottes = $em->getRepository('CagnotteBundle:cagnotte')->findAll();

        $nb_cagnottes = 0;
        $montant_collecte = 0;
        $top_cagnotte = 'Error';
        $montant_top_cagnotte = 0;

        foreach ($cagnottes as $cagnotte){
            $nb_cagnottes++;
            $montant_collecte = $montant_collecte + $cagnotte->getMontantActuel();
            if ($cagnotte->getMontantActuel() >= $montant_top_cagnotte){
                $montant_top_cagnotte = $cagnotte->getMontantActuel();
                $top_cagnotte = $cagnotte->getNom();
            }
        }

        $donations = $em->getRepository('CagnotteBundle:donations')->findAll();
        $nb_dons = 0;
        $top_donator = 'Error';
        $top_montant = 0;

        foreach ($donations as $donation){
            $nb_dons++;
            if ($donation->getMontant() >= $top_montant){
                $top_montant = $donation->getMontant();
                $top_donator = $donation->getNom();
            }
        }


        return $this->render('@Cagnotte/donation/dashboard.html.twig', array(
            'nb_cagnottes' => $nb_cagnottes,
            'montant_collecte' => $montant_collecte,
            'top_cagnotte' => $top_cagnotte,
            'montant_top_cagnotte' => $montant_top_cagnotte,
            'nb_dons' => $nb_dons,
            'top_donator' => $top_donator,
            'top_montant' => $top_montant));
    }
}