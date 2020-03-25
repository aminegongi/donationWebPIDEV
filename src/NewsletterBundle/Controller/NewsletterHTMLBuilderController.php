<?php

namespace NewsletterBundle\Controller;

use NewsletterBundle\Entity\NewsHTMLBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsletterHTMLBuilderController extends Controller
{
    public function addAction(Request $req)
    {
        $for = new NewsHTMLBuilder();
        if ($req->getMethod() == Request::METHOD_POST) {

            $nbh = new NewsHTMLBuilder();
            $nbh->setTitre($req->request->get('_titre'));
            $nbh->setCorpsHTML($req->request->get('_cHTML'));
            $nbh->setDateAjout(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($nbh);
            $em->flush();
        }
        //var_dump($req->request);
        //die();
        return $this->render('@Newsletter/admin/newsletterHTML.html.twig');
    }
}
