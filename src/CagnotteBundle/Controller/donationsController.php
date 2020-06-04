<?php

namespace CagnotteBundle\Controller;

use CagnotteBundle\Entity\donations;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class donationsController extends Controller{
//'nom' => "test2", 'user' => 1, 'methode' => "Stripe", 'montant' => $montant
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
}
