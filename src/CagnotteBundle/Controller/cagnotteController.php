<?php

namespace CagnotteBundle\Controller;

use CagnotteBundle\Entity\cagnotte;
use CagnotteBundle\Form\cagnotteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class cagnotteController extends Controller{
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();

        $cagnottes = $em->getRepository('CagnotteBundle:cagnotte')->findAll();

        return $this->render('@Cagnotte/Cagnotte/index.html.twig', array(
            'cagnottes' => $cagnottes));
    }

    public function newAction(Request $request){
        $cagnotte = new cagnotte();
        $form = $this->createForm(cagnotteType::class, $cagnotte);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($cagnotte);
            $em->flush();
            return $this->redirectToRoute('cagnotte_homepage');
        }
        return $this->render("@Cagnotte/Cagnotte/ajouterCagnotte.html.twig", array('form'=>$form->createView()));
    }

    public function editAction(Request $request, $id){
        $em=$this->getDoctrine()->getManager();
        $cagnotte = $em->getRepository('CagnotteBundle:cagnotte')->find($id);
        $form=$this->createForm(cagnotteType::class, $cagnotte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cagnotte);
            $em->flush();
            $this->addFlash('info', 'Created Successfully !');
            return $this->redirectToRoute('cagnotte_homepage');
        }

        return $this->render('@Cagnotte/Cagnotte/modifierCagnotte.html.twig',array('form'=> $form->createView()));
    }

    public function deleteAction($id){
        $em= $this->getDoctrine()->getManager();
        $cagnotte = $em->getRepository('CagnotteBundle:cagnotte')->find($id);
        $em->remove($cagnotte);
        $em->flush();
        return $this->redirectToRoute('cagnotte_homepage');
    }
}
