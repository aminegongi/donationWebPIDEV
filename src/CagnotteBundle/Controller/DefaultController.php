<?php

namespace CagnotteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CagnotteBundle:Default:index.html.twig');
    }
}
