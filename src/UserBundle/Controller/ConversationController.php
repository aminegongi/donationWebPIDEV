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
        $pro =$req->request->get('profo');
        $me = $this->container->get('security.token_storage')->getToken()->getUser();
        $idme=$me->getId();
        $ar = $this->getDoctrine()->getRepository(Conversation::class)->getSRConversation($idr,$idme);

        $code='';
        foreach ($ar as $conv ){
            if($conv->getReceiver()->getId() == $idme){
                $img = $conv->getSender()->getImage();
                if(isset($pro))
                    $code .= '<div class="media w-50 mb-3"><img src="../../../uploads/UserImg/'.$img.'" alt="user" width="50" class="rounded-circle">';
                else
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

    public function getlistConvAction(Request $req)
    {

        $me = $this->container->get('security.token_storage')->getToken()->getUser();
        $idme=$me->getId();

        $ar = $this->getDoctrine()->getRepository(Conversation::class)->getlistConDQL($idme);

        $code='';
        foreach ($ar as $conv ){
            if($conv->getSender()->getId() != $idme) {
                $img = $conv->getSender()->getImage();
                $code .= '<a onclick=" to=' . $conv->getSender()->getId() . '" class="list-group-item list-group-item-action list-group-item-light rounded-0">';
                $code .= '<div class="media"><img src="../../uploads/UserImg/' . $img . '" alt="user" width="50" class="rounded-circle">';
                $code .= '<div class="media-body ml-4">';
                $code .= '<div class="d-flex align-items-center justify-content-between mb-1">';
                $code .= '<h6 class="mb-0">' . $conv->getSender()->getUsername() . '</h6><small class="small font-weight">' . $conv->getDateEnvoi()->format('d M') . '</small></div>';
                $code .= '<p class="font-italic mb-0 text-small" style=" font-size: 12px; text-align: left;width: 150px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis; " >' . $conv->getMessage() . '</p></div></div></a>';
            }
        }

        return new JsonResponse(array(
            'conv'=>$code
        ));
    }
/*
 <a href="#" class="list-group-item list-group-item-action list-group-item-light rounded-0">
                            <div class="media"><img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user" width="50" class="rounded-circle">
                                <div class="media-body ml-4">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <h6 class="mb-0">Jason Doe</h6><small class="small font-weight">02-06-2020</small>
                                    </div>
                                    <p class="font-italic mb-0 text-small" style=" font-size: 12px; text-align: left;width: 150px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis; " >Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                                </div>
                            </div>
                        </a>
 */
}
