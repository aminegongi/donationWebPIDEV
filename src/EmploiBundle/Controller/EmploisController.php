<?php

namespace EmploiBundle\Controller;

use EmploiBundle\Entity\CategorieEmploi;
use EmploiBundle\Entity\Emplois;
use EmploiBundle\Entity\filtreEmploi;
use EmploiBundle\Form\EmploisType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EmploisController extends Controller
{

    public function showAction(Request $req)
    {
        $listCat = $this->getDoctrine()->getRepository(CategorieEmploi::class)->findAll();

        $rech = $req->get('rech');
        $te = $req->get('t');
        $co = $req->get('c');
        $oo = $req->get('oo');
        $cate = $req->get('cat');
        $i=0;


        if(empty($rech) && empty($te)&& empty($co)&& empty($cate) && empty($oo)) {
            $list = $this->getDoctrine()->getRepository(Emplois::class)->findAll();
        }
        else{
            if(!empty($cate)){
                foreach ($cate as $c) {
                    $cate[$i] = $this->getDoctrine()->getRepository(CategorieEmploi::class)->getIdTitre($c);
                    $cate[$i] = $cate[$i]['0']['id'];
                    $i++;
                }
            }

            $list = $this->getDoctrine()->getRepository(Emplois::class)->rechFiltre($rech,$te,$co,$cate,$oo);
        }

        return $this->render('@Emploi/Emplois/show.html.twig',array(
            'listEmp'=>$list,
            'listCat'=>$listCat,
        ));
    }

    public function singleEmploiAction($id)
    {
        $list = $this->getDoctrine()->getRepository(Emplois::class)->find($id);
        return $this->render('@Emploi/Emplois/SingleEmploi.html.twig',array(
            'Emp'=>$list
        ));
    }

    public function MesShowAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($user == "anon."){
            return $this->render('@Emploi/Emplois/messhow.html.twig',array(
                'listEmp'=> 1
            ));
        }
        $list = $this->getDoctrine()->getRepository(Emplois::class)->findBy(['id_utilisateur'=>$user->getId()]);
        return $this->render('@Emploi/Emplois/messhow.html.twig',array(
            'listEmp'=>$list
        ));
    }

    public function addAction(Request $request)
    {
        $emp = new Emplois();
        $form = $this->createForm(EmploisType::class, $emp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('photo')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL

                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('EmploiImages_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $emp->setPhoto($newFilename);
            }
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $emp->setIdUtilisateur($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($emp);
            $em->flush();

            return $this->redirectToRoute('Emp_MesShow');
        }


        return $this->render('@Emploi/Emplois/add.html.twig',array(
            'form' => $form->createView(),
        ));
    }
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository(Emplois::class)->find($id);

        $em->remove($cat);
        $em->flush();

        return $this->redirectToRoute('Emp_MesShow');
    }

    public function updateAction(Request $request , $id)
    {
        $emp = $this->getDoctrine()->getRepository(Emplois::class)->find($id);
        $form = $this->createForm(EmploisType::class, $emp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('photo')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL

                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('EmploiImages_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $emp->setPhoto($newFilename);
            }

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('Emp_MesShow');
        }


        return $this->render('@Emploi/Emplois/update.html.twig',array(
            'form' => $form->createView(),
        ));
    }
}
