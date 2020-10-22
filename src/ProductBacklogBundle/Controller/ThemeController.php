<?php

namespace ProductBacklogBundle\Controller;

use ProductBacklogBundle\Entity\ProductBacklog;
use ProductBacklogBundle\Entity\Theme;
use ProductBacklogBundle\Form\ThemeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializationContext;



class ThemeController extends Controller
{

    public function ajoutThemeAction(Request $request ,$idBacklog)
    {
        $auth_chek = $this->container->get('security.authorization_checker');

       // if ($auth_chek->isGranted('ROLE_MASTER')) {
     //   $em =$this->getDoctrine()->getManager();
            $theme = new Theme();
            $form = $this->createForm(ThemeType::class, $theme);
            $form->handleRequest($request);


            //   $theme->setIdBacklog(2);
            if ($form->isSubmitted()) {
                $em = $this->getDoctrine()->getManager();
                $etat = $em->getRepository(ProductBacklog::class)->find($idBacklog);
                $theme->setIdBacklog($etat);
                $em->persist($theme);
                $em->flush();

                $Themes =$em->getRepository("ProductBacklogBundle:Theme")->findBy(array('idBacklog'=>$idBacklog));
                $test = 'c est aniis';
                $this->addFlash('success', 'Succesful ! Theme Created! !');
                return $this->render("@ProductBacklog/Theme/afficheTheme.html.twig",array('Theme'=>$Themes,'tes'=>$test));
            }

            return $this->render("@ProductBacklog/Theme/addTheme.html.twig", array('form' => $form->createView()));

        //} else
        // return   $this->addFlash('info', "formulaire non disponible");
        // return   ( 'tu na pas le droit');

    }

        public function afficheThemeAction($idBacklog)

    {
       // $theme= new Theme();

        $em =$this->getDoctrine()->getManager();
        $Themes =$em->getRepository("ProductBacklogBundle:Theme")->findBy(array('idBacklog'=>$idBacklog));

        $test = 'c est aniis';


      //  return $sum;


        return $this->render("@ProductBacklog/Theme/afficheTheme.html.twig",array('Theme'=>$Themes,'tes'=>$test));


    }





    /////////// Partie API
    // Read Theme by Id
    public function APIafficheThemeAction($idBacklog)

    {
        // $theme= new Theme();

        $em =$this->getDoctrine()->getManager();
        $Themes =$em->getRepository("ProductBacklogBundle:Theme")->findBy(array('idBacklog'=>$idBacklog));



     //   foreach ($Themes as $member)
       // {

           // $arrayCollection[] = array(
             //   'id' => $member->getId(),
                //'firstname'=>$member->getName(),
               // 'lastname'=>$member->getLastname(),

        //    );
        //}





       // $data = $this->get('jms_serializer')->serialize($Themes, 'json');


        $data = $this->get('jms_serializer')->serialize($Themes, 'json',SerializationContext::create()->setGroups(array('list')));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;


    }


    public function ajouttThemeAction($nomTheme ,$idBacklog)
    {

        $theme = new Theme();


            $em = $this->getDoctrine()->getManager();
            $etat = $em->getRepository(ProductBacklog::class)->find($idBacklog);
            $theme->setIdBacklog($etat);
            $theme->setNomTheme($nomTheme);
            $em->persist($theme);
            $em->flush();

            $Themes =$em->getRepository("ProductBacklogBundle:Theme")->findBy(array('idBacklog'=>$idBacklog));
            $test = 'c est aniis';

          return  setStatusCode(Response::HTTP_OK);

      //  return $this->render("@ProductBacklog/Theme/addTheme.html.twig", array('form' => $form->createView()));

        //} else
        // return   $this->addFlash('info', "formulaire non disponible");
        // return   ( 'tu na pas le droit');

    }



}
