<?php

namespace NewsletterBundle\Controller;

use NewsletterBundle\Entity\NewsletterW;
use NewsletterBundle\Form\NewsletterWType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsletterController extends Controller
{
    /*public function newsAction(Request $req)
    {
        $nw = new NewsletterW();
        $form = $this->createForm(NewsletterWType::class,$nw);
        $form=$form->handleRequest($req);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $nw->setDateAjout(new \DateTime());
        $nw->setAddBy($user);
        if($form->isSubmitted() and $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($nw);
            $em->flush();
            return  $this->redirectToRoute('newsletterW');
        }
        return $this->render('@Newsletter/admin/newsletterW.html.twig',array(
            'form'=>$form->createView()
        ));
    }*/

    public function newsAction(Request $req)
    {
        $id=$req->get('id');
        $action=$req->get('action');
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if(isset($action)){
            if($action=="Modifier"){
                $nw = $em->getRepository(NewsletterW::class)->find($id);
            }
            else if ($action=="Supprimer"){
                $nww = $em->getRepository(NewsletterW::class)->find($id);
                $em->remove($nww);
                $em->flush();
                return  $this->redirectToRoute('newsletterW');
            }
            else if ($action=="Envoi"){
                $nw = new NewsletterW();

                $nw = $em->getRepository(NewsletterW::class)->find($id);

                $ss = explode(",",$nw->getListeA());

                $message = (new \Swift_Message($nw->getObjetMail()))
                    ->setFrom(['amine.gongi@esprit.tn' => 'DoNation Newsletter'])
                    ->setTo($ss)
                    ->setBody($nw->getCorpsID()->getCorpsHTML(),'text/html')
                ;

                $this->get('mailer')->send($message);

                $em->getRepository(NewsletterW::class)->setDateEnvoi($id);

                return  $this->redirectToRoute('newsletterW');

            }

            /*
             * ->setTo([
            'vavoxa8807@gotkmail.com',
            'neila.gongi@mfcpole.com.tn',
                    ])
             */

        }
        else{
            $nw = new NewsletterW();
            $action="Ajouter";
            $nw->setDateAjout(new \DateTime());
            $nw->setAddBy($user);
        }

        $form = $this->createForm(NewsletterWType::class,$nw);
        $form=$form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid()){
            $pays = $req->request->get('_qui');
            if($pays == "all")
                $p_m=$em->getRepository(NewsletterW::class)->getMailInscri();
            else
                $p_m=$em->getRepository(NewsletterW::class)->getMailPaysInscri($pays);
            $ar = array();
            foreach ( $p_m as $pp){
                foreach ($pp as $p){
                    array_push($ar,$p);
                }
            }
            $mm = implode(',',$ar);

            $nw->setListeA($mm);
            $em = $this->getDoctrine()->getManager();
            $em->persist($nw);
            $em->flush();

            $action="Ajouter";
            return  $this->redirectToRoute('newsletterW');
        }
        $em=$this->getDoctrine()->getRepository(NewsletterW::class);

        $pays=$em->getPaysInscri();
        $list = $em->findAll();
        return  $this->render('@Newsletter/admin/newsletterW.html.twig',array(
            'listNW'=>$list,'form'=>$form->createView(),'action'=>$action,'pays'=>$pays
        ));
    }

}
