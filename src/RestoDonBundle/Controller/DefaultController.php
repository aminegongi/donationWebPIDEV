<?php

namespace RestoDonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use RestoDonBundle\Entity\DonRestaurant;
use RestoDonBundle\Entity\TarifResto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;

class DefaultController extends Controller
{



    public function indexAction()
    {


//        try {
            $user = $this->get('security.token_storage')->getToken()->getUser();
//        } catch (\Exception $exception){
//            return $this->render('@RestoDon/Default/autre.html.twig', array(
//            'allRestoJSON' => $this->jsonRestaurant()
//        ));
//        }
//        var_dump($user);
//        die();

        if ($user == 'anon.'){
            return $this->render('@RestoDon/Default/autre.html.twig', array(
            'allRestoJSON' => $this->jsonRestaurant(),
                'etatDonate'=>'hidden'
        ));
        } else {

            $role = $user->getRoles()[0];


            $id = $user->getId();

            if ($role == "ROLE_ADMIN") {
                $tarifrestos=$this->getDoctrine()->getRepository(TarifResto::class)->findAll();

//                var_dump($tarifrestos{2});
//                die();

                return $this->render('@RestoDon/Default/backRestoDon.html.twig',array(
                    'tarifrestos'=>$tarifrestos
                ));

            } else {
                if ($role == "ROLE_RES") {

                    try {
                        $TarifResto = $this->getDoctrine()->getRepository(TarifResto::class)->findByIdResto($id)[0];
                        $idTarif = $TarifResto->getIdTarif();
                        $tarif = (float)$TarifResto->getTarif();
                        $porteF = (float)$TarifResto->getPortefeuilleVirtuel();
//                $etat_tarif = 'path(\'tarifresto_edit\', '. '{' . '\'idTarif\' : ' . $idTarif . ' } )';
//                $etat_tarif = htmlentities($etat_tarif);
//                var_dump($etat_tarif);
//                die();

                        if (floor($porteF / $tarif) >= 1) {
                            $couleurPortefeuille = "var(--my-color)";
                            $couleurPT = "white";
                        } else {
                            $couleurPortefeuille = "#B33A3A";
                            $couleurPT = "black";
                        }

                        return $this->render('@RestoDon/Default/index.html.twig', array(
                            'tarif' => $tarif,
                            'idTarif' => $idTarif,
                            'etat_tarif' => 'edit',
                            'porteFeuille' => $porteF,
                            'couleurPortefeuille' => $couleurPortefeuille,
                            'couleurPT' => $couleurPT,
                        ));
                    } catch (\Exception $e) {
                        if ($role == "ROLE_RES") {
                            return $this->render('@RestoDon/Default/index.html.twig', array(
                                'tarif' => "      Ajoutez un tarif    ",
                                'etat_tarif' => 'new',
                                'porteFeuille' => "0.000",
                                'couleurPortefeuille' => "white",
                                'couleurPT' => "gray",
                            ));
                        } else {
                            return $this->render('@RestoDon/Default/autre.html.twig', array(
                                'allRestoJSON' => $this->jsonRestaurant()
                            ));
                        }

                    }


                } else {
                    return $this->render('@RestoDon/Default/autre.html.twig', array(
                        'allRestoJSON' => $this->jsonRestaurant(),
                        'etatDonate'=>''
                    ));
                }

            }
        }
    }

    public function jsonRestaurant(){

//        $allResto = $this->getDoctrine()->getRepository(tarifResto::class)->findAll();
        $allResto = $this->getDoctrine()->getRepository(User::class)->findAll();
        $numResto = 1;
        $allRestoArray = array();
        foreach ($allResto as $item) {

            if (($item->getRoles()[0]) == "ROLE_RES") {
//            $restoFor = $allResto[$item];
                //$restoID = $item->getIdResto();
                $role = $item->getRoles();
                $longitude = $item->getLongitude();
                $latitude = $item->getLatitude();
                $web = $item->getSiteWeb();
                $fb = $item->getPageFB();
                $img = $item->getImage();


//                $type = json_encode($type);


                $properties = array('web' => $web,
                    'fb' => $fb,
                    'icon' => $img);

//                $properties = json_encode(array('properties' => $properties));

                $geometry = array('type' => 'point',
                    'coordinates' => [$longitude, $latitude]);

//                $geometry = json_encode(array('geometry' => $geometry));


                $singleResto = array('type' => 'Feature',
                    'properties' => $properties,
                    'geometry' => $geometry);

//            $singleResto = json_encode($singleResto);
//                var_dump($singleResto);

                if ($numResto === 1) {
                    array_push($allRestoArray, $singleResto);
//            print_r($allRestoArray);
                } else {
                    array_push($allRestoArray, $singleResto);
//                print_r($allRestoArray);
                }

//            $json = "{
//                    'type': 'Feature',
//                    'properties': {
//                        'web': $web,
//                        'fb': $fb,
//                        'icon': 'resto'
//                        },
//                    'geometry': {
//                        'type': 'Point',
//                        'coordinates': [$longitude, $latitude]
//                        }
//                    },";
//            var_dump($longitude);
                $numResto++;
            }
        }
        $allRestoJSON = json_encode($allRestoArray, JSON_UNESCAPED_SLASHES);
        $geoJson = json_encode(array( 'type' => 'FeatureCollection',
            'features' => $allRestoArray), JSON_UNESCAPED_SLASHES);
//        var_dump($allRestoJSON);
//        die();
        return $geoJson;
    }

        public function jsonRestaurantAction(Request $request){
            $jsonRestaurantList = $this->jsonRestaurant();
            $serializer = new serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($jsonRestaurantList);
            $response = new Response();
            $response->setContent($formatted);
            return $response;
        }

        public function mobileMapAction(){
            return $this->render('@RestoDon/Default/mobileMapAllResto.html', array(
                'allRestoJSON' => $this->jsonRestaurant()
            ));
        }

    public function jsonRestaurantMobile(){

//        $allResto = $this->getDoctrine()->getRepository(tarifResto::class)->findAll();
        $allResto = $this->getDoctrine()->getRepository(User::class)->findAll();
        $numResto = 1;
        $allRestoArray = array();
        foreach ($allResto as $item) {
            if ($item->getRoles()[0] == "ROLE_RES") {
//            $restoFor = $allResto[$item];
                //$restoID = $item->getIdResto();
                $username = $item->getUsername();
                $role = $item->getRoles();
                $longitude = $item->getLongitude();
                $latitude = $item->getLatitude();
                $web = $item->getSiteWeb();
                $fb = $item->getPageFB();
                $img = $item->getImage();


//                $type = json_encode($type);


                $properties = array(
                    'username' => $username,
                    'web' => $web,
                    'fb' => $fb,
                    'icon' => $img);

//                $properties = json_encode(array('properties' => $properties));

                $geometry = array('type' => 'point',
                    'longitude' => $longitude,
                    'latitude' => $latitude
                );

//                $geometry = json_encode(array('geometry' => $geometry));


                $singleResto = array('type' => 'Feature',
                    'properties' => $properties,
                    'geometry' => $geometry);

//            $singleResto = json_encode($singleResto);
//                var_dump($singleResto);

                if ($numResto === 1) {
                    array_push($allRestoArray, $singleResto);
//            print_r($allRestoArray);
                } else {
                    array_push($allRestoArray, $singleResto);
//                print_r($allRestoArray);
                }

//            $json = "{
//                    'type': 'Feature',
//                    'properties': {
//                        'web': $web,
//                        'fb': $fb,
//                        'icon': 'resto'
//                        },
//                    'geometry': {
//                        'type': 'Point',
//                        'coordinates': [$longitude, $latitude]
//                        }
//                    },";
//            var_dump($longitude);
                $numResto++;
            }
        }
        $allRestoJSON = json_encode($allRestoArray, JSON_UNESCAPED_SLASHES);
        $geoJson = json_encode(array( 'type' => 'FeatureCollection',
            'features' => $allRestoArray), JSON_UNESCAPED_SLASHES);
//        var_dump($allRestoJSON);
//        die();
        return $geoJson;
    }

    public function jsonRestaurantMobileAction(Request $request){
        $jsonRestaurantList = $this->jsonRestaurantMobile();
        $serializer = new serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($jsonRestaurantList);
        $response = new Response();
        $response->setContent($formatted);
        return $response;
    }

    public function donatePageAction(Request $request){
        $form = $this->createFormBuilder()
            // ...
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // perform some action...
            $resto = $user = $this->get('security.token_storage')->getToken()->getUser()->getUserName();
            $montant = $request->get("montant");

            return $this->redirect('http://127.0.0.1:8000/qr-code/' . $resto . '-' . $montant . '.png');
        }

        return $this->render('@RestoDon/Default/donateResto.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function donateAction(Request $request){
        return $this->render('@RestoDon/Default/donateResto.html.twig', array(
            'etat'=>""
        ));
    }
}
