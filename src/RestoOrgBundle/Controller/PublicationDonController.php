<?php

namespace RestoOrgBundle\Controller;
use \Datetime;
use PubBundle\Entity\Pub;
use PubBundle\Entity\Publicite_country;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use RestoOrgBundle\Entity\PublicationDon;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\User;


/**
 * Publicationdon controller.
 *
 */
class PublicationDonController extends Controller
{
    /**
     * Lists all publicationDon entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $publicationDons = $em->getRepository('RestoOrgBundle:PublicationDon')->findAll();

        return $this->render('@RestoOrg/publicationdon/index.html.twig', array('publicationDons' => $publicationDons,'connectedUser'=>$this->getUser(),"ip"=> $_SERVER['REMOTE_ADDR']));
    }

    /**
     * Creates a new publicationDon entity.
     *
     */
    public function newAction(Request $request)
    {
        $publicationDon = new Publicationdon();

        $form = $this->createForm('RestoOrgBundle\Form\PublicationDonType', $publicationDon);
        $tab=$this->getUser()->getRoles();
        $userRole=$tab[0];
        //dump($userRole);
        if($userRole=='ROLE_RES')
            $form->add('type', HiddenType::class, ['required'=> false,'empty_data' => 'OffreDon']);
        elseif ($userRole=='ROLE_ORG')
            $form->add('nbrePlat',null, ['attr' => ['class' => 'form-control'],])
                ->add('type', HiddenType::class, ['required'=> false,'empty_data' => 'AppelAuDon']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //dump($this->getUser());
            $publicationDon->setAjoutePar($this->getUser());
            $publicationDon->setDatePublication(new \DateTime());
            $publicationDon->setEtat(1);
            
            $em->persist($publicationDon);
            $em->flush();

            return $this->redirectToRoute('publicationdon_index');
        }

        return $this->render('@RestoOrg/publicationdon//new.html.twig', array(
            'publicationDon' => $publicationDon,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a publicationDon entity.
     *
     */
    public function showAction(PublicationDon $publicationDon)
    {
        $deleteForm = $this->createDeleteForm($publicationDon);

        return $this->render('@RestoOrg/publicationdon//show.html.twig', array(
            'publicationDon' => $publicationDon,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing publicationDon entity.
     *
     */
    public function editAction(Request $request, PublicationDon $publicationDon)
    {
        $deleteForm = $this->createDeleteForm($publicationDon);
        $editForm = $this->createForm('RestoOrgBundle\Form\PublicationDonType', $publicationDon);
        $tab=$this->getUser()->getRoles();
        $userRole=$tab[0];
        if($userRole=='ROLE_RES')
            $editForm->add('type', HiddenType::class, ['required'=> false,'empty_data' => 'OffreDon']);
        elseif ($userRole=='ROLE_ORG')
            $editForm->add('nbrePlat')->add('type', HiddenType::class, ['required'=> false,'empty_data' => 'AppelAuDon']);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publicationdon_edit', array('id' => $publicationDon->getId()));
        }

        return $this->render('@RestoOrg/publicationdon//edit.html.twig', array(
            'publicationDon' => $publicationDon,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a publicationDon entity.
     *
     */
    public function deleteAction(Request $request, PublicationDon $publicationDon)
    {
        $form = $this->createDeleteForm($publicationDon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($publicationDon);
            $em->flush();
        }

        return $this->redirectToRoute('publicationdon_index');
    }

    /**
     * Creates a form to delete a publicationDon entity.
     *
     * @param PublicationDon $publicationDon The publicationDon entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PublicationDon $publicationDon)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('publicationdon_delete', array('id' => $publicationDon->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function afterRequestAction(Request $request){
        #go to the script and get idPub to display , if -1 go to random Pub
        $connectedUser = $this->getUser()->getId();
//        $process = new Process(['python.py', $connectedUser]);#change User Id to Connected User !
//        $process->run();
//        if (!$process->isSuccessful()) {
//            throw new ProcessFailedException($process);
//        }
//        $renderVar=$process->getOutput();
        $renderVar=-1 ; # rendervar forced to 1 ; pour validation seuelemnt .
        if($renderVar==-1)
        {
            $all=$this->getDoctrine()->getRepository(Pub::class)->findAll();
            $pubRec = $all[(array_rand($all))];

        }else{
            $pubRec=$this->getDoctrine()->getRepository(Pub::class)->find($renderVar);
        }
        $titre = $pubRec->getTitre();
        $idPub= $pubRec->getId();
        $imagePub=  $pubRec->getImage();
        $description=$pubRec->getDescription();

        return new JsonResponse(array('image' =>$imagePub,'titre'=>$titre,'idPub'=>$idPub,'description'=>$description));

    }
    public function recAction(Request $request){


        return $this->render('@RestoOrg/publicationdon/recTest.html.twig', array('test'=>"e"
        ));

    }
    public function afterRequestUpdateAction(Request $request){

        $durre = $request->get('durre');
        $idPub= $request->get('idPub');
        $this->getDoctrine()->getRepository(PublicationDon::class)->updateRecSystem($this->getUser()->getId(),$idPub,$durre);#change User Id to Connected User !
        #need some conditions to determine if the result is accurate or not , exp : check if the durre is > to 100  : that means that is not real !
          return new JsonResponse(array('ok'=>"ok"));;

    }
    public function afterRequestIPAction(Request $request){
        $countryCode = $request->get('countryCode');
        $idPub = $request->get('idPub');
        dump($countryCode);
        #Repository
        $this->getDoctrine()->getRepository(Publicite_country::class)->updateNbrClick($idPub,$countryCode);
         return new JsonResponse(array('ok'=>"ok"));
    }
    public function getAllApiAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $publicationDons = $em->getRepository('RestoOrgBundle:PublicationDon')->findAll();
        foreach ($publicationDons as $pd){
            $pd->setDatePublication($pd->getDatePublication()->format('Y-m-d H:i'));
        }
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($publicationDons);
        return new JsonResponse($formatted);
    }
    public function addPublicationApiAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $publicationDon = new Publicationdon();
        $publicationDon->setDatePublication(new \DateTime());
        $publicationDon->setEtat(1);

        $publicationDon->setTitre($request->get("titre"));
        $publicationDon->setDescription($request->get("description"));
        if($request->get("nbrePlat")!=-1) {
            $publicationDon->setNbrePlat($request->get("nbrePlat"));
            $publicationDon->setType("AppelAuDon");
        }
        else{
            $publicationDon->setType("OffreDon");
        }
        $userId = $this->getDoctrine()->getRepository(User::class)->find($request->get("ajoutePar"));
        $publicationDon->setAjoutePar($userId);
        $em->persist($publicationDon);
        $em->flush();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($publicationDon);
        return new JsonResponse($formatted);

    }
}
