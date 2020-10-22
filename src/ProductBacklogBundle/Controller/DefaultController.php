<?php

namespace ProductBacklogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProductBacklogBundle:Default:index.html.twig');
    }
}
