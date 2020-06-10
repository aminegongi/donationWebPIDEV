<?php

namespace EmploiBundle\Controller;

use EmploiBundle\Entity\CategorieEmploi;
use EmploiBundle\Entity\Emplois;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class emploimobController extends Controller
{

    public function showAction(Request $req)
    {
        $list = $this->getDoctrine()->getRepository(Emplois::class)->findAll();
        $ser = new Serializer([new ObjectNormalizer()]);
        $json = $ser->normalize($list);
        return new JsonResponse($json);
    }
}
