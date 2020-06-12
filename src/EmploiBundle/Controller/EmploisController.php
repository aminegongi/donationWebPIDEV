<?php

namespace EmploiBundle\Controller;

use EmploiBundle\Entity\CategorieEmploi;
use EmploiBundle\Entity\Emplois;
use EmploiBundle\Entity\filtreEmploi;
use EmploiBundle\Form\EmploisType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
/**
 * Import the TranslateClient class
 */
use Stichoza\GoogleTranslate\GoogleTranslate;

// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

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

    public function pdfAction($id){
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $list = $this->getDoctrine()->getRepository(Emplois::class)->find($id);

        // Retrieve the HTML generated in our twemploisig file
        $html = $this->renderView('@Emploi/Emplois/pdf.html.twig', [
            'Emp'=>$list
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        $date = new \DateTime('now');
        $dd = $date->format('Y-m-d H:i:s');
        // Output the generated PDF to Browser (force download)
        $dompdf->stream($list->getTitre()."_".$dd.".pdf", [
            "Attachment" => true
        ]);
    }
    public function singleEmploiAction($id  , Request $req)
    {
        $lan = $req->get('langue');

        if($lan == 'fr' || empty($lan)){
            $list = $this->getDoctrine()->getRepository(Emplois::class)->find($id);
            return $this->render('@Emploi/Emplois/SingleEmploi.html.twig',array(
                'Emp'=>$list
            ));
        }
        else if($lan == 'en' ){
            $list = $this->getDoctrine()->getRepository(Emplois::class)->find($id);
            $tr = new GoogleTranslate();
            $tr->setSource(null); // Detect automatically the language
            $tr->setTarget('en'); // Translate to Spanish


            $list->setTitre($tr->translate($list->getTitre()));
            $list->setDescription($tr->translate($list->getDescription()));
            $list->setEmplacement($tr->translate($list->getEmplacement()));
            $list->setTypeContrat($tr->translate($list->getTypeContrat()));
            $list->setTypeDemploi($tr->translate($list->getTypeDemploi()));
            //$list->setIdcategorie()->setTitreCategorie($tr->translate($list->getIdcategorie()->getTitreCategorie()));

            return $this->render('@Emploi/Emplois/SingleEmploi_En.html.twig',array(
                'Emp'=>$list
            ));
        }



        // By default the TranslateClient is from 'auto' to 'en'
        /*$tr = new GoogleTranslate();

        $tr->setSource(null); // Detect automatically the language
        $tr->setTarget('en'); // Translate to Spanish

        $text = $tr->translate('bonjour');

        */
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
