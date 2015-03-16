<?php

namespace Kasia\TadeuszBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('KasiaTadeuszBundle:Default:index.html.twig', array());
    }
public function booksAction($number)
    {
        return $this->render('KasiaTadeuszBundle:Books:book'.$number.'.html.twig', array());
    }
}
