<?php

namespace CagnotteBundle\Controller;

use CagnotteBundle\CagnotteBundle;
use CagnotteBundle\Entity\cagnotte;
use CagnotteBundle\Entity\donations;
use CagnotteBundle\Form\cagnotteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class cagnotteController extends Controller{
    public function indexAction(){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($user == "anon."){
            return $this->render('@Cagnotte/Cagnotte/error.html.twig');
        }
        $tab = $this->getUser()->getRoles();
        $userRole=$tab[0];
        $userId=$this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();

        $cagnottes = $em->getRepository('CagnotteBundle:cagnotte')->findAll();

        return $this->render('@Cagnotte/Cagnotte/index.html.twig', array(
            'cagnottes' => $cagnottes,
            'userRole' => $userRole,
            'userId' => $userId));
    }

    public function newAction(Request $request){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($user == "anon."){
            return $this->render('@Cagnotte/Cagnotte/error.html.twig');
        }
        $tab=$this->getUser()->getRoles();
        $userRole=$tab[0];
        $userId=$this->getUser()->getId();
        if (($userRole == 'ROLE_US') || ($userRole == 'ROLE_ORG')){
            $cagnotte = new cagnotte();
            $form = $this->createForm(cagnotteType::class, $cagnotte);
            $form->handleRequest($request);

            if ($form->isSubmitted()){
                $em = $this->getDoctrine()->getManager();
                $cagnotte->setDateDeCreation(new \DateTime('now'));
                $cagnotte->setIdProprietaire($userId);
                $cagnotte->setMontantActuel(0);
                $cagnotte->setIdOrganisation(0);
                $cagnotte->setEtat(0);
                $em->persist($cagnotte);
                $em->flush();
                return $this->redirectToRoute('cagnotte_homepage');
            }
            return $this->render("@Cagnotte/Cagnotte/add.html.twig", array('form'=>$form->createView()));
        }
        else{
            return $this->render('@Cagnotte/Cagnotte/error.html.twig');
        }
    }

    public function deleteAction($id){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($user == "anon."){
            return $this->render('@Cagnotte/Cagnotte/error.html.twig');
        }
        $tab=$this->getUser()->getRoles();
        $userRole=$tab[0];
        if (($userRole == 'ROLE_US') || ($userRole == 'ROLE_ORG')){
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

    public function showAction($id){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($user == "anon."){
            return $this->render('@Cagnotte/Cagnotte/error.html.twig');
        }
        $tab=$this->getUser()->getRoles();
        $userRole=$tab[0];
        if (($userRole == 'ROLE_US') || ($userRole == 'ROLE_ORG')){
            $em = $this->getDoctrine()->getManager();

            $selected = $em->getRepository('CagnotteBundle:cagnotte')->find($id);

            return $this->render('@Cagnotte/Cagnotte/show.html.twig', array(
                'selected' => $selected,
                'userRole' => $userRole));
        }
        else{
            return $this->render('@Cagnotte/Cagnotte/error.html.twig');
        }
    }

    public function donateAction($id){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($user == "anon."){
            return $this->render('@Cagnotte/Cagnotte/error.html.twig');
        }
        $em = $this->getDoctrine()->getManager();
        $cagnotte = $em->getRepository('CagnotteBundle:cagnotte')->find($id);
        return $this->render('@Cagnotte/Cagnotte/donate.html.twig',array('selected' => $cagnotte));
    }

    public function chargeAction(Request $request, $id){
        //Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey('sk_test_7tajuF5Z10s0ok3SuF49voRi00w7jjH6x0');

        // Token is created using Stripe Checkout or Elements!
        // Get the payment token ID submitted by the form:
        //$montant = $request->request->get("montant");
        $montant = $_POST["montant"];
        $montant = $montant * 100;
        $charge = \Stripe\Charge::create([
            'amount' => $montant,
            'currency' => 'usd',
            'description' => 'donations.tn',
            'source' => $request->request->get('stripeToken'),
        ]);
        $montant = $montant / 100;
        $em = $this->getDoctrine()->getManager();
        $cagnotte = $em->getRepository('CagnotteBundle:cagnotte')->find($id);
        $cagnotte->setMontantActuel($cagnotte->getMontantActuel() + $montant);
        if ($cagnotte->getMontantActuel() >= $cagnotte->getMontantDemande() ){
            $cagnotte->setEtat(2);
        }
        $em->persist($cagnotte);
        $em->flush();
        return $this->redirectToRoute('donation_new', array(
            'nom' => $cagnotte->getNom(),
            'methode' => 'Stripe',
            'montant' => $montant));
    }

    public function takeAction($id){

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($user == "anon."){
            return $this->render('@Cagnotte/Cagnotte/error.html.twig');
        }
        $tab=$this->getUser()->getRoles();
        $userRole=$tab[0];
        if ($userRole == 'ROLE_ORG'){
            $em = $this->getDoctrine()->getManager();
            $cagnotte = $em->getRepository('CagnotteBundle:cagnotte')->find($id);
            $cagnotte->setEtat(1);
            $cagnotte->setIdOrganisation($this->getUser()->getId());
            $em->persist($cagnotte);
            $em->flush();
        }
        return $this->redirectToRoute('cagnotte_homepage');
    }

    public function successAction(){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($user == "anon."){
            return $this->render('@Cagnotte/Cagnotte/error.html.twig');
        }

        return $this->render('@Cagnotte/Cagnotte/success.html.twig');
    }
}
