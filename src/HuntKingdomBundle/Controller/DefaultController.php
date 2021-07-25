<?php

namespace HuntKingdomBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@HuntKingdom/Default/index.html.twig');
    }
}
