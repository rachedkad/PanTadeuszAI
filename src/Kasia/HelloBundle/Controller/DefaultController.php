<?php

namespace Kasia\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($firstname, $lastname)
    {
        return $this->render('KasiaHelloBundle:Default:index.html.twig', array('firstname'=>$firstname, 'lastname'=>$lastname));
    }
}
