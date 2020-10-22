<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function AdminAction()
    {
        return $this->render('@User/Admin/admin.html.twig');
    }
    public function MasterAction()
    {
        return $this->render('@User/Master/Master.html.twig');
    }
    public function DeveloperAction()
    {
        return $this->render('@User/Developer/Developer.html.twig');
    }
    public function ProductOwnerAction()
    {

        return $this->render('@User/ProductOwner/ProductOwner.html.twig');
    }

}
