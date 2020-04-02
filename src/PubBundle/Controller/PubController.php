<?php

namespace PubBundle\Controller;

use PubBundle\Entity\Apps_countries;
use PubBundle\Entity\Pub;
use PubBundle\Entity\Publicite_country;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


/**
 * Pub controller.
 *
 */
class PubController extends Controller
{
    /**
     * Lists all pub entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pubs = $em->getRepository('PubBundle:Pub')->findAll();

        return $this->render('@Pub/pub/index.html.twig', array(
            'pubs' => $pubs,
        ));
    }

    /**
     * Creates a new pub entity.
     *
     */
    public function newAction(Request $request )
    {
        $pub = new Pub();
        $form = $this->createForm('PubBundle\Form\PubType', $pub);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL

                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('PubImages_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $pub->setImage($newFilename);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($pub);
            $em->flush();
            $countriesList=$this->getDoctrine()->getRepository(Apps_countries::class)->findAll();
            foreach ($countriesList as $c){
                $this->getDoctrine()->getRepository(Publicite_country::class)->insertNewPubCountry($pub->getId(),$c->getId());
            }

            return $this->redirectToRoute('pub_index');
        }

        return $this->render('@Pub/pub/new.html.twig', array(
            'pub' => $pub,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pub entity.
     *
     */
    public function showAction(Pub $pub)
    {
        $deleteForm = $this->createDeleteForm($pub);

        return $this->render('@Pub/pub/show.html.twig', array(
            'pub' => $pub,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pub entity.
     *
     */
    public function editAction(Request $request, Pub $pub)
    {
        $deleteForm = $this->createDeleteForm($pub);
        $editForm = $this->createForm('PubBundle\Form\PubType', $pub);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $imageFile = $editForm->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL

                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('PubImages_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $pub->setImage($newFilename);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pub_index');
        }

        return $this->render('@Pub/pub/edit.html.twig', array(
            'pub' => $pub,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pub entity.
     *
     */
    public function deleteAction(Request $request, Pub $pub)
    {
        $form = $this->createDeleteForm($pub);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pub);
            $em->flush();
        }

        return $this->redirectToRoute('pub_index');
    }

    /**
     * Creates a form to delete a pub entity.
     *
     * @param Pub $pub The pub entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pub $pub)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pub_delete', array('id' => $pub->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function recAction()
    {
        #go to the script and get idPub to display , if -1 go to random Pub
        $process = new Process(['python.py', '27']);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $renderVar=$process->getOutput();
        if($renderVar==-1)
        {   echo "Random Pub";
            $all=$this->getDoctrine()->getRepository(Pub::class)->findAll();
            $pubRec = $all[(array_rand($all))];

        }else{
        $pubRec=$this->getDoctrine()->getRepository(Pub::class)->find($renderVar);
        }


        return $this->render('@Pub/pub/show.html.twig',array('var'=>$pubRec));
    }

}
