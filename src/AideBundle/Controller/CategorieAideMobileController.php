<?php


namespace AideBundle\Controller;
use AideBundle\Entity\CategorieAide;
use AideBundle\Entity\DemandeAide;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class CategorieAideMobileController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categorieAides = $em->getRepository('AideBundle:CategorieAide')->findAll();

        $serializer= new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize( $categorieAides);
        return new JsonResponse($formated);
    }

}