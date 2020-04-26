<?php


namespace RestoDonBundle\Controller;

use RestoDonBundle\Entity\RepasServi;
use RestoDonBundle\Entity\TarifResto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class RepasServiMobileController extends Controller
{
    public function newAction(Request $request)
    {
        $repasServi = new Repasservi();
        $repasServi->setDate(new \DateTime("-1 hour"));

        try {
            $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
            $tarifResto = $this->getDoctrine()->getRepository(TarifResto::class)->findByIdResto($user)[0];
            $porteF = (float)$tarifResto->getPortefeuilleVirtuel();
            $tarif = (float)$tarifResto->getTarif();
            if ($porteF >= $tarif) {
                $x = $porteF / $tarif;
                $count = floor($x);
                $state = "";
                $couleur = 'var(--my-color)';
            } else {
                $count = 0;
                $state = "disabled";
                $couleur = '#B33A3A';
            }
            $title = "$count Repas à servir!";
        } catch (\Exception $e) {
            $thisArray= array(
                'repasServi' => $repasServi,
                'title' => "Vous devez ajouter un tarif à votre restaurant",
                'state' => 'disabled',
                'couleur' => "#B33A3A",
            );
            $serializer = new serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($thisArray);
            return  new JsonResponse($formatted);
        }



            try {
                $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
                $tarifResto = $this->getDoctrine()->getRepository(TarifResto::class)->findByIdResto($user)[0];
                $porteF = (float)$tarifResto->getPortefeuilleVirtuel();
                $tarif = (float)$tarifResto->getTarif();
                $newPortF = $porteF - $tarif;
                $this->getDoctrine()->getRepository(TarifResto::class)->UpdatePorteFeuille($newPortF, $user)->execute();
            } catch (\Exception $e) {
                var_dump("erreur servir repas");
            }
            $repasServi->setDate(new \DateTime("-1 hour"));
            $em = $this->getDoctrine()->getManager();
            $em->persist($repasServi);
            $em->flush();

            return $this->redirectToRoute('repasservi_show', array('idRepas' => $repasServi->getIdRepas()));



        return $this->render('@RestoDon/repasservi/new.html.twig', array(
            'repasServi' => $repasServi,
            'form' => $form->createView(),
            'user' => $user = $this->get('security.token_storage')->getToken()->getUser()->getId(),
            'time' => strftime("%d-%m-%Y %H:%M"),
            'title' => $title,
            'state' => $state,
            'couleur' => $couleur,
        ));
    }
}