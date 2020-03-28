<?php

namespace NewsletterBundle\Controller;

use NewsletterBundle\Entity\InscriNews;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsletterInscriController extends Controller
{
    public function ninscrireAction(Request $req)
    {
        if ($req->getMethod() == Request::METHOD_POST) {
            $in = new InscriNews();
            $in->setAMail($req->request->get('_email'));
            $in->setDateInscri(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($in);
            $em->flush();
            $referer = $req->headers->get('referer');
            return $this->redirect($referer);
        }
    }

    public function newsInscriAction()
    {

    }
}
