<?php

namespace haytBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $authChecker=$this->container->get('security.authorization_checker');

        if ($authChecker->isGranted('ROLE_ADMIN'))
        {
            return $this->render('@hayt/Default/haytBackHome.html.twig');
        }
        else
        {
            return $this->render('@hayt/Default/haytFrontHome.html.twig');
        }

    }
}
