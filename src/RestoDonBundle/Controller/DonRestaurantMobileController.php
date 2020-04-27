<?php


namespace RestoDonBundle\Controller;

use RestoDonBundle\Entity\DonRestaurant;
use RestoDonBundle\Entity\TarifResto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DonRestaurantMobileController extends Controller
{
//    RestoDon/newDonMobile?resto=x&username=pseudoname&montant=x.xxx
    public function newAction(Request $request)
    {



        $donRestaurant = new Donrestaurant();
        $donRestaurant -> setDate(new \DateTime("-1 hour"));
        $donRestaurant->setMontant((float)$request->get("montant"));
        try {
            $donRestaurant->setIdResto($this->getDoctrine()->getRepository(DonRestaurant::class)->findRestoById($request->get("resto"))[0]);
        }catch (\Exception $exception){
            $theArray = array('errur'=>'resto');
            $serializer = new serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($theArray);
            $formatted = json_encode($formatted, JSON_UNESCAPED_SLASHES);
            $response = new Response();
            $response->setContent($formatted);
            return $response;
        }


//        if ($form->isSubmitted()) {
//            $userName = $donRestaurant -> getIdUser();
//            $ss = $_POST["restodonbundle_donrestaurant"]["idUser"];
//            $idUser = $this->getDoctrine()->getRepository(DonRestaurant::class)->findAllDONATORNAME($ss)[0]->getId();
//            $donRestaurant -> setIdUser($idUser);
//            var_dump($donRestaurant);
//
//        }


            $idResto = $donRestaurant -> getIdResto();
            $ss = $request->get("username");
            try {

                $idUser = $this->getDoctrine()->getRepository(DonRestaurant::class)->findAllDONATORNAME($ss)[0];
                $donRestaurant->setIdUser($idUser);
                $resto = $this->getDoctrine()->getRepository(TarifResto::class)->findByIdResto($idResto)[0];
                $porteF = $resto->getPortefeuilleVirtuel() + $donRestaurant -> getMontant();
                $hh = $this->getDoctrine()->getRepository(TarifResto::class)->UpdatePorteFeuille($porteF,$idResto);
//                var_dump($hh);
//                die();
            } catch (\Exception $e) {
                $theArray = array(
                    'erreur'=>'user'
                );
                $serializer = new serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($theArray);
                $formatted = json_encode($formatted, JSON_UNESCAPED_SLASHES);
                $response = new Response();
                $response->setContent($formatted);
                return $response;
            }


//        if ($form->isSubmitted()){
//            $value = $donRestaurant -> getIdUser();
//            $user = $this->get('fos_user.user_manager')->findUserByUsernameOrEmail($form->get($idUser))->getId();
//            $donRestaurant -> setIdUser($user);
//        }


            $idResto = $donRestaurant -> getIdResto();
            $ss = $request->get("username");
            $idUser = $this->getDoctrine()->getRepository(DonRestaurant::class)->findAllDONATORNAME($ss)[0];
            $donRestaurant -> setIdUser($idUser);
            $donRestaurant -> setDate(new \DateTime("-1 hour"));
            $resto = $this->getDoctrine()->getRepository(TarifResto::class)->findByIdResto($idResto)[0];
            $porteF = $resto->getPortefeuilleVirtuel() + $donRestaurant -> getMontant();
            $this->getDoctrine()->getRepository(TarifResto::class)->UpdatePorteFeuille($porteF,$idResto)->execute();
            $em = $this->getDoctrine()->getManager();
            $em->persist($donRestaurant);
            $em->flush();

            $theArray = array(
                'errur'=>'null',
                'idDon' => $donRestaurant->getIddon(),
            );
            $serializer = new serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($theArray);
            $formatted = json_encode($formatted, JSON_UNESCAPED_SLASHES);
            $response = new Response();
            $response->setContent($formatted);
            return $response;


    }
}