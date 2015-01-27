<?php

namespace Kasia\TadeuszBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('KasiaTadeuszBundle:Default:index.html.twig', array());
    }
}
