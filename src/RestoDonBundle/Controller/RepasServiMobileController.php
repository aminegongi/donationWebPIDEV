<?php


namespace RestoDonBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use RestoDonBundle\Entity\RepasServi;
use RestoDonBundle\Entity\TarifResto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class RepasServiMobileController extends Controller
{
//    RestoDon/newRepasMobile?resto=x
    public function newAction(Request $request)
    {
        $repasServi = new Repasservi();
        $repasServi->setDate(new \DateTime("-1 hour"));
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get("resto"));
        $repasServi->setIdResto($user);
        try {

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
                'erreur'=>'resto',
                'title' => "Vous devez ajouter un tarif à votre restaurant",
                'state' => 'disabled',
                'couleur' => "#B33A3A",
            );
            $serializer = new serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($thisArray);
            $formatted = json_encode($formatted, JSON_UNESCAPED_SLASHES);
            $response = new Response();
            $response->setContent($formatted);
            return $response;
        }


        if ($count>0) {
            try {

                $tarifResto = $this->getDoctrine()->getRepository(TarifResto::class)->findByIdResto($user)[0];
                $porteF = (float)$tarifResto->getPortefeuilleVirtuel();
                $tarif = (float)$tarifResto->getTarif();
                $newPortF = $porteF - $tarif;
                $this->getDoctrine()->getRepository(TarifResto::class)->UpdatePorteFeuille($newPortF, $user)->execute();
            } catch (\Exception $e) {
                $thisArray= array(
                    'erreur'=>'resto',
                    'title' => "Vous devez ajouter un tarif à votre restaurant",
                    'state' => 'disabled',
                    'couleur' => "#B33A3A",
                );
                $serializer = new serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($thisArray);
                $formatted = json_encode($formatted, JSON_UNESCAPED_SLASHES);
                $response = new Response();
                $response->setContent($formatted);
                return $response;
            }
            $repasServi->setDate(new \DateTime("-1 hour"));
            $em = $this->getDoctrine()->getManager();
            $em->persist($repasServi);
            $em->flush();

            $thisArray = array(
                'erreur'=>'null',
                'idRepas' => $repasServi->getIdRepas()
            );
            $serializer = new serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($thisArray);
            $formatted = json_encode($formatted, JSON_UNESCAPED_SLASHES);
            $response = new Response();
            $response->setContent($formatted);
            return $response;
        } else {
            $thisArray = array('erreur' => 'solde');
            $serializer = new serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($thisArray);
            $formatted = json_encode($formatted, JSON_UNESCAPED_SLASHES);
            $response = new Response();
            $response->setContent($formatted);
            return $response;
        }


    }
}