<?php


namespace RestoDonBundle\Controller;

use RestoDonBundle\Entity\TarifResto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\User;

class TarifRestoMobileController extends Controller
{

//    RestoDon/getTarifMobile?resto=x
    public function getAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $resto = $this->getDoctrine()->getRepository(TarifResto::class)->findByIdResto($request->get("resto"))[0];
        try {
            $tarifResto = $em->getRepository('RestoDonBundle:TarifResto')->find($resto);

            $thisArray = array(
                'erreur'=>'null',
                'tarifResto' => $tarifResto
            );
            $serializer = new serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($thisArray);
            $formatted = json_encode($formatted, JSON_UNESCAPED_SLASHES);
            $response = new Response();
            $response->setContent($formatted);
            return $response;
        } catch (\Exception $exception){
            $thisArray = array(
                'erreur' => 'resto'
            );
            $serializer = new serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($thisArray);
            $formatted = json_encode($formatted, JSON_UNESCAPED_SLASHES);
            $response = new Response();
            $response->setContent($formatted);
            return $response;
        }

    }

//    RestoDon/newTarifMobile?resto=x&tarif=x.xxx

    public function newAction(Request $request)
    {
        $resto = $this->getDoctrine()->getRepository(User::class)->findById($request->get("resto"))[0];
        $tarifResto = new Tarifresto();
        $tarifResto->setIdResto($resto);
        $tarifResto->setTarif($request->get("tarif"));

        try {
            $existTarif = $this->getDoctrine()->getRepository(TarifResto::class)->findByIdResto($request->get("resto"))[0];
            $this->getDoctrine()->getRepository(TarifResto::class)->UpdateTarif($request->get("tarif"), $resto)->execute();
            $thisArray = array(
                'action'=> 'update',
            );
            $serializer = new serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($thisArray);
            $formatted = json_encode($formatted, JSON_UNESCAPED_SLASHES);
            $response = new Response();
            $response->setContent($formatted);
            return $response;
        }catch (\Exception $exception){
            $tarifResto->setPortefeuilleVirtuel(0.000);
            $em = $this->getDoctrine()->getManager();
            $em->persist($tarifResto);
            $em->flush();
            $thisArray = array(
                'action'=> 'new',
            );
            $serializer = new serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($thisArray);
            $formatted = json_encode($formatted, JSON_UNESCAPED_SLASHES);
            $response = new Response();
            $response->setContent($formatted);
            return $response;
        }

    }
}