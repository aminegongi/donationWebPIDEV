<?php

namespace EmploiBundle\Controller;

use EmploiBundle\Entity\CategorieEmploi;
use EmploiBundle\Form\CategorieEmploiType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class CategorieEmploiController extends Controller
{
    public function showAction()
    {
        $list = $this->getDoctrine()->getRepository(CategorieEmploi::class)->findAll();
        return $this->render('@Emploi/CategorieEmploi/show.html.twig',array(
            'listCatEmp'=>$list
        ));
    }

    public function addAction(Request $request)
    {
        $cat = new CategorieEmploi();
        $form = $this->createForm(CategorieEmploiType::class, $cat);
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
                        $this->getParameter('EmploiCatImages_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $cat->setImage($newFilename);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($cat);
            $em->flush();

            return $this->redirectToRoute('CatEmp_show');
        }


        return $this->render('@Emploi/CategorieEmploi/add.html.twig',array(
            'form' => $form->createView(),
        ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository(CategorieEmploi::class)->find($id);

        $em->remove($cat);
        $em->flush();

        return $this->redirectToRoute('CatEmp_show');
    }

    public function updateAction(Request $request , $id)
    {
        $cat = $this->getDoctrine()->getRepository(CategorieEmploi::class)->find($id);
        $form = $this->createForm(CategorieEmploiType::class, $cat);
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
                        $this->getParameter('EmploiCatImages_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $cat->setImage($newFilename);
            }

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('CatEmp_show');
        }


        return $this->render('@Emploi/CategorieEmploi/update.html.twig',array(
            'form' => $form->createView(),
        ));
    }

    public function statAction()
    {
        $nbEmpCat = $this->getDoctrine()->getRepository(CategorieEmploi::class)->findNbEmpParCat();
        $nbEmpReg = $this->getDoctrine()->getRepository(CategorieEmploi::class)->findNbEmpParReg();
        return $this->render('@Emploi/CategorieEmploi/stat.html.twig',array(
            'nbEmpCat'=>$nbEmpCat,
            'nbEmpReg'=>$nbEmpReg
        ));
    }
}
