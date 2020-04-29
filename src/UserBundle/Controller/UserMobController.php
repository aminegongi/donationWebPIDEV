<?php

namespace UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\User;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserMobController extends Controller
{
    public function getUserIdAction(Request $req){
        $idu = $req->get('id');
        $user = $this->getDoctrine()->getRepository(User::class)->find($idu);
        $user->setDateNaissance($user->getDateNaissance()->format('Y-m-d'));

        $ser = new Serializer([new ObjectNormalizer()]);
        $json = $ser->normalize($user);
        return new JsonResponse($json);
    }

    public function getUserMailAction(Request $req){
        $mail = $req->get('mail');
        $user = $this->getDoctrine()->getRepository(User::class)->UserMailR($mail);
        $user->setDateNaissance($user->getDateNaissance()->format('Y-m-d'));
        $ser = new Serializer([new ObjectNormalizer()]);
        $json = $ser->normalize($user);
        return new JsonResponse($json);
    }

    public function loginAction(Request $req){
        $user = new User;
        //encodage bcrypt : $encoded = $encoderService->encodePassword($user, $plainPassword);
        $mail = $req->get('mail');
        $pass = $req->get('pass');
        $userm = $this->getDoctrine()->getRepository(User::class)->UserMailR($mail);
        if(isset($userm) && !empty($userm)){
            $user = $this->getDoctrine()->getRepository(User::class)->find($userm['0']->getId());
            $encoderService = $this->container->get('security.password_encoder');

            $encoded = $encoderService->isPasswordValid($user, $pass);
            if ($encoded == false){
                $userm='paspaspasNon';
            }
        }
        else{
            $userm='paspaspasNon';
        }

        $ser = new Serializer([new ObjectNormalizer()]);
        $json = $ser->normalize($userm);
        return new JsonResponse($json);
    }

    public function activerCompteAction(Request $req){
        $mail = $req->get('mail');
        $token = $req->get('token');
        $checkAct = $this->getDoctrine()->getRepository(User::class)->CheckactiverCompteR($mail,$token);
        $ok='non';

        if(isset($checkAct) && !empty($checkAct)){
            $act = $this->getDoctrine()->getRepository(User::class)->activerCompteR($mail,$token);
            $ok='oui';
        }

        $ser = new Serializer([new ObjectNormalizer()]);
        $json = $ser->normalize($ok);
        return new JsonResponse($json);
    }

    public function generateRandomString($length) {
        $include_chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $charLength = strlen($include_chars);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $include_chars [rand(0, $charLength - 1)];
        }
        return $randomString;
    }

    public function InscriptionAction(Request $req){
        $encoderService = $this->container->get('security.password_encoder');
        $un = $req->get('un');
        $mail = $req->get('mail');
        $tel = $req->get('tel');
        $mdp = $req->get('mdp');
        $role = $req->get('role');
        $yesnews = $req->get('yn');
        $ret ='ok';
        if(isset($un,$mail,$tel,$mdp,$role,$yesnews)){
            $cm = $this->getDoctrine()->getRepository(User::class)->chechMail($mail);
            $cu = $this->getDoctrine()->getRepository(User::class)->chechUsername($un);

            if(!empty($cm) && !empty($cu) ){
                $ret ='existants';
            }
            else if( !empty($cm) ){
                $ret ='mail existant';
            }
            elseif ( !empty($cu)){
                $ret ='username existant';
            }
            else {
                $user = new User();
                $user->setUsername($un);
                $user->setUsernameCanonical(strtolower($un));
                $user->setEmail($mail);
                $user->setEmailCanonical(strtolower($mail));
                $user->setNumTel($tel);
                $encoded = $encoderService->encodePassword($user, $mdp);
                $user->setPassword($encoded);
                $user->setRoles(array($role));
                $user->setYesNews($yesnews);
                $user->setEnabled(false);
                $cc = $this->generateRandomString(5);
                $user->setConfirmationToken($cc);
                $ret = $user;

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                //add mail ou sms confirmation
            }
        }
        else{
            $ret = 'information incomplete';
        }

        $ser = new Serializer([new ObjectNormalizer()]);
        $json = $ser->normalize($ret);
        return new JsonResponse($json);
    }




}
