<?php

namespace UserBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em=$this->getDoctrine()->getRepository(User::class);
        $list = $em->findAll();
        $usersss  = $this->get('knp_paginator')->paginate(
            $list,
            $request->query->get('page', 1),
            5
        );
        return $this->render('@User/Default/index.html.twig',array(
            'listU'=>$usersss
        ));
    }

    public function showAction()
    {

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $cc = ['#ff586d','#feae06','#c500b0','#79eeac','#5988fd'];
        $i= random_int(0,4);
        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $user,'code' =>$cc[$i]
        ));
    }

    public function showOUserAction($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        $cc = ['#ff586d','#feae06','#c500b0','#79eeac','#5988fd'];
        $i= random_int(0,4);
        return $this->render('@User/Default/user_id.html.twig', array(
            'user' => $user,'code' =>$cc[$i]
        ));
    }


}
