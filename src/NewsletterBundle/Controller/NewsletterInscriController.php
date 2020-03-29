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
            $ip="196.234.1gg40.243";
            $ip = file_get_contents("http://checkip.amazonaws.com/");
            $in->setIp($ip);

            $dataArray = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip)); // wala  http://bot.whatismyipaddress.com
            $pays=$dataArray->geoplugin_countryName;
            $in->setPays($pays);


            $em = $this->getDoctrine()->getManager();
            $em->persist($in);
            $em->flush();
            $referer = $req->headers->get('referer');
            return $this->redirect($referer);
        }
    }

    public function newsInscriAction()
    {
        $em=$this->getDoctrine()->getRepository(InscriNews::class);
        $nb = $em->findNbInscri();
        $nbAj = $em->findNbInscriAj();
        $nbpd = $em->findNbInscriparDate();
        $maxCont =$em->findMaxCountry();
        $lastI = $em->findLastInscri();
        $list = $em->findAll();
        return  $this->render('@Newsletter/admin/newsletterInscri.html.twig',array(
            'listIN'=>$list,'nbin'=>$nb,'nbaj'=>$nbAj,'$nbpd'=>$nbpd,'mxCnt'=>$maxCont,'last'=>$lastI
        ));
    }
}
