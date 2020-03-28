<?php

namespace RestoDonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@RestoDon/Default/index.html.twig');
    }
}
