<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em=$this->getDoctrine()->getRepository(User::class);
        $list = $em->findAll();
        $usersss  = $this->get('knp_paginator')->paginate(
            $list,
            $request->query->get('page', 1),/*le numéro de la page à afficher*/
            6/*nbre d'éléments par page*/
        );
        return $this->render('@User/Default/index.html.twig',array(
            'listU'=>$usersss
        ));
    }
}
