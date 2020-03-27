<?php

namespace NewsletterBundle\Controller;

use NewsletterBundle\Entity\NewsHTMLBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsletterHTMLBuilderController extends Controller
{
    public function NBHAction(Request $req)
    {
        $for = new NewsHTMLBuilder();
        if ($req->getMethod() == Request::METHOD_POST) {
            $nbh = new NewsHTMLBuilder();
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $nbh->setAddBy($user);
            $nbh->setTitre($req->request->get('_titre'));
            $nbh->setCorpsHTML($req->request->get('_cHTML'));
            $nbh->setDateAjout(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($nbh);
            $em->flush();
        }

        $em=$this->getDoctrine()->getRepository(NewsHTMLBuilder::class);
        $list = $em->findAll();
        return  $this->render('@Newsletter/admin/newsletterHTML.html.twig',array(
            'listNHB'=>$list
        ));
    }

    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $nhb = $em->getRepository(NewsHTMLBuilder::class)->find($id);
        $em->remove($nhb);
        $em->flush();
        var_dump($id);
        die();
        return  $this->redirectToRoute('newsletterHTMLBuilder');
    }
}
