<?php

namespace PubBundle\Controller;

use PubBundle\Entity\Publicite_country;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class Publicite_countryController extends Controller
{
    public function updateMapAction($idPub)
    {



            $for= $this->getDoctrine()->getRepository(Publicite_country::class)->getPubsStats($idPub);

            return  $this->render('@Pub/Publicite_country/update_map.html.twig',array(
                'stats'=>$for
            ));


        return $this->render('@Pub/Publicite_country/update_map.html.twig');
    }

}
