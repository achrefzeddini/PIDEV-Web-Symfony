<?php

namespace GroupsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GroupsBundle:Default:index.html.twig');
    }
}
