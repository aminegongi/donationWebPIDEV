<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em=$this->getDoctrine()->getRepository(User::class);
        $list = $em->findAll();
        return $this->render('@User/Default/index.html.twig',array(
            'listU'=>$list
        ));
    }
}
