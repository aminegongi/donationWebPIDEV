<?php

namespace EmploiBundle\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use EmploiBundle\Entity\CategorieEmploi;
use EmploiBundle\Entity\Emplois;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class emploimobController extends Controller
{
    public function showAction(Request $req)
    {
        $list = $this->getDoctrine()->getRepository(Emplois::class)->findAll();
        $ser = new Serializer([new ObjectNormalizer()]);
        $json = $ser->normalize($list);
        return new JsonResponse($json);
    }

    public function singleEmploiAction($id)
    {
        $list = $this->getDoctrine()->getRepository(Emplois::class)->find($id);
        $ser = new Serializer([new ObjectNormalizer()]);
        $json = $ser->normalize($list);
        return new JsonResponse($json);
    }

    public function MesShowAction($id)
    {
        $list = $this->getDoctrine()->getRepository(Emplois::class)->findBy(['id_utilisateur'=>$id]);
        $ser = new Serializer([new ObjectNormalizer()]);
        $json = $ser->normalize($list);
        return new JsonResponse($json);
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository(Emplois::class)->find($id);
        $em->remove($cat);
        $em->flush();
        $ser = new Serializer([new ObjectNormalizer()]);
        $json = $ser->normalize('delete Ok');
        return new JsonResponse($json);
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

    public function addAction(Request $request)
    {


        $titre = $request->get('titre');
        $description = $request->get('desc');
        $typeContrat = $request->get('tcon');
        $typeEmploi = $request->get('temp');
        $salaire = $request->get('sal');
        $empl = $request->get('emp');
        $photo = $request->get('photo');
        $user = $request->get('user');
        $cat = $request->get('cat');
        $emp = new Emplois();
        $emp->setDescription($description);
        $emp->setTitre($titre);
        $emp->setTypeDemploi($typeEmploi);
        $emp->setTypeContrat($typeContrat);
        $emp->setSalaire($salaire);
        $emp->setEmplacement($empl);
        $emp->setPhoto($photo);
        //$emp->setPhoto('donation.jpeg');
        $emp->setIdUtilisateur($user = $this->getDoctrine()->getRepository('UserBundle:User')->find($user));
        $emp->setIdcategorie($user = $this->getDoctrine()->getRepository(CategorieEmploi::class)->find(1));

            $em = $this->getDoctrine()->getManager();
            $em->persist($emp);
            $em->flush();

        $ser = new Serializer([new ObjectNormalizer()]);
        $json = $ser->normalize('add Ok');
        return new JsonResponse($json);

    }


    public function SEmploiEnAction($id)
    {
        $lisst = $this->getDoctrine()->getRepository(Emplois::class)->find($id);
        $tr = new GoogleTranslate();
        $tr->setSource(null); // Detect automatically the language
        $tr->setTarget('en'); // Translate to Spanish


        $lisst->setTitre($tr->translate($lisst->getTitre()));
        $lisst->setDescription($tr->translate($lisst->getDescription()));
        $lisst->setEmplacement($tr->translate($lisst->getEmplacement()));
        $lisst->setTypeContrat($tr->translate($lisst->getTypeContrat()));
        $lisst->setTypeDemploi($tr->translate($lisst->getTypeDemploi()));

        $ser = new Serializer([new ObjectNormalizer()]);
        $json = $ser->normalize($lisst);
        return new JsonResponse($json);
    }
}
