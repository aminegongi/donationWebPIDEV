<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Conversation;
use UserBundle\Entity\User;

class ConversationController extends Controller
{
    public function send_addAction(Request $req)
    {

        $conv = new Conversation();
        $sender = $this->container->get('security.token_storage')->getToken()->getUser();
        $idr=$req->request->get('to');
        $receiver = $this->getDoctrine()->getRepository(User::class)->find($idr);
        $conv->setReceiver($receiver);
        $conv->setSender($sender);
        $conv->setMessage($req->request->get('msg'));
        $conv->setDateEnvoi(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $em->persist($conv);
        $em->flush();
        return new JsonResponse(array('ok'=>"ok"));
    }

    public function getConvsAction(Request $req)
    {
        $idr=$req->request->get('to');
        $me = $this->container->get('security.token_storage')->getToken()->getUser();
        $idme=$me->getId();

        $ar = $this->getDoctrine()->getRepository(Conversation::class)->getSRConversation($idr,$idme);

        $code='';
        foreach ($ar as $conv ){
            if($conv->getReceiver()->getId() == $idme){
                $img = $conv->getSender()->getImage();
                $code .= '<div class="media w-50 mb-3"><img src="../../uploads/UserImg/'.$img.'" alt="user" width="50" class="rounded-circle">';
                $code .= '<div class="media-body ml-3"> <div class="bg-light rounded py-2 px-3 mb-2">';
                $code .= '<p class="text-small mb-0 text-muted"> '.$conv->getMessage().'</p> </div>';
                $code .= '<p class="small text-muted">'.$conv->getDateEnvoi()->format('d M | H:i').'</p></div></div>';
            }
            else{
                $code .= '<div class="media w-50 ml-auto mb-3">';
                $code .= '<div class="media-body"> <div class="bg-primary rounded py-2 px-3 mb-2">';
                $code .= '<p class="text-small mb-0 text-white"> '.$conv->getMessage().'</p> </div>';
                $code .= '<p class="small text-muted">'.$conv->getDateEnvoi()->format('d M | H:i').'</p></div></div>';
            }

        }

        return new JsonResponse(array(
            'ch'=>$code
        ));
    }
/*
<!-- Sender Message-->
<div class="media w-50 mb-3"><img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user" width="50" class="rounded-circle">
<div class="media-body ml-3">
<div class="bg-light rounded py-2 px-3 mb-2">
<p class="text-small mb-0 text-muted">Test, which is a new approach to have</p>
</div>
<p class="small text-muted">12:00 PM | Aug 13</p>
</div>
</div>

<!-- Reciever Message-->
<div class="media w-50 ml-auto mb-3">
<div class="media-body">
<div class="bg-primary rounded py-2 px-3 mb-2">
<p class="text-small mb-0 text-white">Apollo University, Delhi, India Test</p>
</div>
<p class="small text-muted">12:00 PM | Aug 13</p>
</div>
</div>
*/
}
