<?php

namespace RestoDonBundle\Controller;

use RestoDonBundle\Entity\TarifResto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $role = $user->getRoles()[0];
        $id = $user->getId();
        if ($role == "ROLE_RES"){

            try {
                $TarifResto = $this->getDoctrine()->getRepository(TarifResto::class)->findByIdResto($id)[0];
                $tarif = (float)$TarifResto->getTarif();
                $porteF = (float)$TarifResto->getPortefeuilleVirtuel();

                if (floor($porteF / $tarif) >= 1){
                    $couleurPortefeuille = "var(--my-color)";
                    $couleurPT = "white";
                } else {
                    $couleurPortefeuille = "#B33A3A";
                    $couleurPT = "black";
                }

                return $this->render('@RestoDon/Default/index.html.twig', array(
                    'tarif'=>$tarif,
                    'porteFeuille'=>$porteF,
                    'couleurPortefeuille'=>$couleurPortefeuille,
                    'couleurPT'=>$couleurPT,
                ));
            } catch(\Exception $e) {
                if ($role == "ROLE_RES") {
                    return $this->render('@RestoDon/Default/index.html.twig', array(
                        'tarif' => "Ajoutez un tarif",
                        'porteFeuille' => "0.000",
                        'couleurPortefeuille' => "white",
                        'couleurPT' => "gray",
                    ));
                } else {
                    return $this->render('@RestoDon/Default/autre.html.twig', array(

                    ));
                }
            }


        } else {
            return $this->render('@RestoDon/Default/autre.html.twig', array(

            ));
        }



    }
}
