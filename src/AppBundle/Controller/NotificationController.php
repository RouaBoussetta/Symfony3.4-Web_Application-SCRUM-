<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Notification;


class NotificationController extends Controller
{




    public function DisplayNotificationAction(){



        $notification=$this->getDoctrine()->getManager()->getRepository('AppBundle:Notification')->findAll();
        return $this->render('@Meeting/Notification/notification.html.twig',array('notification'=>$notification));
    }



    public function ClearAllAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $m=$em->getRepository('AppBundle:Notification')->findAll();
        $em->clear($m);
        $em->flush();

        return $this->redirectToRoute('notification');


    }
}
