<?php

namespace CagnotteBundle\Controller;

use CagnotteBundle\Entity\cagnotte;
use CagnotteBundle\Form\cagnotteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class cagnotteController extends Controller{
    public function indexAction(){
        $tab=$this->getUser()->getRoles();
        $userRole=$tab[0];
        if ($userRole == 'ROLE_US'){
            $em = $this->getDoctrine()->getManager();

            $cagnottes = $em->getRepository('CagnotteBundle:cagnotte')->findAll();

            return $this->render('@Cagnotte/Cagnotte/index.html.twig', array(
                'cagnottes' => $cagnottes,
                'userRole' => $userRole));
        }
        else{
            return $this->render('@Cagnotte/Cagnotte/error.html.twig');
        }
    }

    public function newAction(Request $request){
        $tab=$this->getUser()->getRoles();
        $userRole=$tab[0];
        if ($userRole == 'ROLE_US'){
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
        else{
            return $this->render('@Cagnotte/Cagnotte/error.html.twig');
        }
    }

    public function editAction(Request $request, $id){
        $tab=$this->getUser()->getRoles();
        $userRole=$tab[0];
        if ($userRole == 'ROLE_US'){
            $em = $this->getDoctrine()->getManager();
            $cagnotte = $em->getRepository('CagnotteBundle:cagnotte')->find($id);
            $form = $this->createForm(cagnotteType::class, $cagnotte);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($cagnotte);
                $em->flush();
                $this->addFlash('info', 'Created Successfully !');
                return $this->redirectToRoute('cagnotte_homepage');
            }

            return $this->render('@Cagnotte/Cagnotte/modifierCagnotte.html.twig', array('form' => $form->createView()));
        }
        else{
            return $this->render('@Cagnotte/Cagnotte/error.html.twig');
        }
    }

    public function deleteAction($id){
        $tab=$this->getUser()->getRoles();
        $userRole=$tab[0];
        if ($userRole == 'ROLE_US'){
            $em = $this->getDoctrine()->getManager();
            $cagnotte = $em->getRepository('CagnotteBundle:cagnotte')->find($id);
            $em->remove($cagnotte);
            $em->flush();
            return $this->redirectToRoute('cagnotte_homepage');
        }
        else{
            return $this->render('@Cagnotte/Cagnotte/error.html.twig');
        }
    }

    public function paymentAction(Request $request, $id){
       /* // Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey('sk_test_7tajuF5Z10s0ok3SuF49voRi00w7jjH6x0');

        // Token is created using Stripe Checkout or Elements!
        // Get the payment token ID submitted by the form:
        $charge = \Stripe\Charge::create([
            'amount' => 999,
            'currency' => 'usd',
            'description' => 'Example charge',
            'source' => $request->request->get('stripeToken'),
        ]);*/
        return $this->render('@Cagnotte/Cagnotte/payment.html.twig',array('id' => $id));
    }
}
