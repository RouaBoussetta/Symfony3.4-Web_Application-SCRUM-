<?php

namespace ProductBacklogBundle\Controller;

use ProductBacklogBundle\Entity\Feature;
use ProductBacklogBundle\Entity\UserStory;
use ProductBacklogBundle\Form\UserStoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Response;

class UserStoryController extends Controller
{
    public function refrechProgress($idff){
        $em =$this->getDoctrine()->getManager();
        $us =$em->getRepository("ProductBacklogBundle:UserStory")->SERCHUS($idff);
        $f =$em->getRepository("ProductBacklogBundle:Feature")->find($idff);
        $t =$em->getRepository("ProductBacklogBundle:Theme")->find(33);

        $tatalEsmatation=0;
        $toatalDoing=0;
        foreach( $us as $value) {
            // $sum++;
            $tatalEsmatation=$tatalEsmatation+$value->getTotalEstimationUserstoryJours();
             $toatalDoing=$toatalDoing+$value->getDoing();
        }


        $f->setTotalEstimationFeatureJours($tatalEsmatation);
        if ($toatalDoing==$tatalEsmatation)
        {
            $f->setStatue('2');
        }
        if (($toatalDoing>0) and ($toatalDoing<$tatalEsmatation) )
        {
            $f->setStatue('1');
        }
        $em->persist($f);
        $em->flush();

    }



    public function ajoutUserStoryAction(Request $request,$idFeature)
    {


        $us= new UserStory();
        $form = $this->createForm(UserStoryType::class,$us);
        $form->handleRequest($request);




        //   $theme->setIdBacklog(2);
        if ($form->isSubmitted())
        {
            $em =$this->getDoctrine()->getManager();
            $etat = $em->getRepository(Feature::class)->find($idFeature);
            $us->setIdFeature($etat);
            $em->persist($us);
            $em->flush();
            $this->addFlash('successt', 'Succesful ! User Story Created! !');
            return $this->redirectToRoute('userStoryOpen',['idFeature' => $idFeature] );
        }



     //   $manager = $this->get('mgilet.notification');
       // $notif = $manager->createNotification('Hello world !');
        //$notif->setMessage('This a notification.');
       //$notif->setLink('http://symfony.com/');
        // or the one-line method :
        // $manager->createNotification('Notification subject','Some random text','http://google.fr');

        // you can add a notification to a list of entities
        // the third parameter ``$flush`` allows you to directly flush the entities
      //  $manager->addNotification(array($this->getUser()), $notif, true);




        return $this->render("@ProductBacklog/UserStory/addUserStory.html.twig",array('form'=>$form->createView()));





    }

    public function afficheUserStoryAction($idFeature)

    {

        $em =$this->getDoctrine()->getManager();
        $us =$em->getRepository("ProductBacklogBundle:UserStory")->findBy(array('idFeature'=>$idFeature));

        return $this->render("@ProductBacklog/UserStory/afficheUserStory.html.twig",array('us'=>$us));


    }

    public function  test1(){
        var_dump("it works");
    }

    public function updateAction($idus, Request $request)
    {
        $input=$request->get('val');
        // var_dump($input);
       // var_dump($idus);

        $em = $this->getDoctrine()->getManager();
        $us =$em->getRepository("ProductBacklogBundle:UserStory")->find($idus);
        $estimUS=$us->getTotalEstimationUserstoryJours();
        $doingActual=$us->getDoing();
        $idf=$us->getIdFeature();

        if ($request->isMethod('POST')) {
            if ($input <= $estimUS and $input >= $doingActual )
            {
                $us->setDoing($input);
                $em->persist($us);
                $em->flush();
                $this->refrechProgress($idf);

                $this->addFlash('update', 'Succesful ! User Story Upadated! !');
              //  return $this->redirectToRoute('userStoryOpen',['idFeature' => $idFeature] );

                return $this->afficheUserStoryAction($idf);
            } else
                $this->addFlash('updateError', 'Oops ! User Story progress value no valid !');
                return $this->render("@ProductBacklog/UserStory/updoing.html.twig",array('us'=>$us));


        }

        return $this->render("@ProductBacklog/UserStory/updoing.html.twig",array('us'=>$us));

    }


    public function updateprocessAction($idus, $val)
    {
        $entityManager = $this->getDoctrine()->getManager();
        // $product = $entityManager->getRepository(Product::class)->find($productId);
        $us=$idus;

        return $this->render("@ProductBacklog/UserStory/updoing.html.twig",array('us'=>$us));

    }






    /////////////Api user story
    public function afficheeUserStoryAction($idFeature)

    {

        $em =$this->getDoctrine()->getManager();
        $us =$em->getRepository("ProductBacklogBundle:UserStory")->findBy(array('idFeature'=>$idFeature));

        $data = $this->get('jms_serializer')->serialize($us, 'json',SerializationContext::create()->setGroups(array('listuser')));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;


    }






    public function ajouttUserStoryAction($userStoryDescription,$totalEstimationUserstoryJours,$priority,$idFeature)
    {


        $us= new UserStory();

            $em =$this->getDoctrine()->getManager();
            $etat = $em->getRepository(Feature::class)->find($idFeature);
            $us->setIdFeature($etat);
        $us->setUserStoryDescription($userStoryDescription);
        $us->setTotalEstimationUserstoryJours($totalEstimationUserstoryJours);
        $us->setPriority($priority);

            $em->persist($us);
            $em->flush();


        return  setStatusCode(Response::HTTP_OK);





    }




    public function updateeAction($idus, $input)
    {
       // $input = $request->get('val');
        // var_dump($input);
        // var_dump($idus);

        $em = $this->getDoctrine()->getManager();
        $us = $em->getRepository("ProductBacklogBundle:UserStory")->find($idus);
        $estimUS = $us->getTotalEstimationUserstoryJours();
        $doingActual = $us->getDoing();
        $idf = $us->getIdFeature();


            if ($input <= $estimUS and $input >= $doingActual) {
                $us->setDoing($input);
                $em->persist($us);
                $em->flush();
                $this->refrechProgress($idf);

              //  $this->addFlash('update', 'Succesful ! User Story Upadated! !');
                //  return $this->redirectToRoute('userStoryOpen',['idFeature' => $idFeature] );

                return setStatusCode(Response::HTTP_OK);
            } else
                //$this->addFlash('updateError', 'Oops ! User Story progress value no valid !');
                return setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);




    }
}
