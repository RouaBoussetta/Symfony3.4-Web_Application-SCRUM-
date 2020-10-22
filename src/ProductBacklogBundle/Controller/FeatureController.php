<?php

namespace ProductBacklogBundle\Controller;

use JMS\Serializer\SerializationContext;
use ProductBacklogBundle\Entity\Feature;
use ProductBacklogBundle\Entity\Theme;
use ProductBacklogBundle\Form\FeatureType;
use ProductBacklogBundle\Model\progress;
use ProductBacklogBundle\Repository\UserStoryRepository;
use ProductBacklogBundle\Form\ThemeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class FeatureController extends Controller
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

public function affectUserToFeatreAction($iduser,$idf)
{
    $em =$this->getDoctrine()->getManager();
    $f =$em->getRepository("ProductBacklogBundle:Feature")->find($idf);
    $f->setIdUserRespensability($iduser);
    $em->persist($f);
    $em->flush();

    return $this->render("@ProductBacklog/ProductBacklog/accueil.html.twig");

}


    public function testuserAction()
    {
        $query = $this->getDoctrine()->getEntityManager()
            ->createQuery(
                'SELECT u FROM AppBundle:User u WHERE u.roles LIKE :role'
            )->setParameter('role', '%"ROLE_DEVELOPER"%'
            );
        $users = $query->getResult();


        return $this->render("@ProductBacklog/Feature/test.html.twig", array('users' => $users));
    }



    public function ajoutFeatureAction(Request $request ,$idTheme )


    {
        $feature= new Feature();
        $form = $this->createForm(FeatureType::class,$feature);
        $form->handleRequest($request);


        $query = $this->getDoctrine()->getEntityManager()
            ->createQuery(
                'SELECT u FROM MeetingBundle:User u WHERE u.roles LIKE :role'
            )->setParameter('role', '%"ROLE_DEVELOPER"%'
            );
        $users = $query->getResult();


        //   $theme->setIdBacklog(2);
        if ($form->isSubmitted())
        {
            $em =$this->getDoctrine()->getManager();
            $etat = $em->getRepository(Theme::class)->find($idTheme);
            $feature->setIdTheme($etat);
            $em->persist($feature);
            $em->flush();
            $this->addFlash('successf', 'Succesful ! Feature Created! !');
            return $this->redirectToRoute('featureAfgiche',['idTheme' => $idTheme] );
        }

        return $this->render("@ProductBacklog/Feature/addFeature.html.twig",array('form'=>$form->createView(),$users));


    }

    public function afficheFeatureAction($idTheme)

    {

        $em =$this->getDoctrine()->getManager();
        $Feature =$em->getRepository("ProductBacklogBundle:Feature")->findBy(array('idTheme'=>$idTheme));
        $th =$em->getRepository("ProductBacklogBundle:Theme")->find($idTheme);
      //  $us =$em->getRepository("ProductBacklogBundle:UserStory")->SERCHUS();

       //$sum=0;
        $s=0;
      foreach( $Feature as $value) {
           // $sum++;
           $s=$s+$value->getTotalEstimationFeatureJours();

     }
        $th->setTotalEstimationThemeJours($s);

        $em->persist($th);
        $em->flush();




        $query = $this->getDoctrine()->getEntityManager()
            ->createQuery(
                'SELECT u FROM MeetingBundle:User u WHERE u.roles LIKE :role'
            )->setParameter('role', '%"ROLE_DEVELOPER"%'
            );
        $users = $query->getResult();



        return $this->render("@ProductBacklog/Feature/afficheFeature.html.twig",array('Feature'=>$Feature ,'users'=>$users));


    }








    public function ProressAction(Request $request,$idFeature)
    {
        $em =$this->getDoctrine()->getManager();
          $us =$em->getRepository("ProductBacklogBundle:UserStory")->SERCHUS($idFeature);

            $tatalEsmatation=0;
          $toatalDoing=0;
         foreach( $us as $value) {
        // $sum++;



             $tatalEsmatation=$tatalEsmatation+$value->getTotalEstimationUserstoryJours();
             $toatalDoing=$toatalDoing+$value->getDoing();
            }



         $toDO=$tatalEsmatation-$toatalDoing;




        //$a=4;
       // $b=7;
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['done',     $toatalDoing],
                ['to do',    $toDO]
            ]
        );
        $pieChart->getOptions()->setTitle('My Daily Activities');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render("@ProductBacklog/Feature/progress.html.twig", array('piechart' => $pieChart));
    }









    public function afficheThemeAction($idBacklog)

    {
        // $theme= new Theme();

        $em =$this->getDoctrine()->getManager();
        $Themes =$em->getRepository("ProductBacklogBundle:Theme")->findBy(array('idBacklog'=>$idBacklog));

        $sum = 0;
      //  foreach( $Themes as $value) {
            //$value->getNomTheme();

       // }

     //   return $sum;


        return $this->render("@ProductBacklog/Theme/afficheTheme.html.twig",array('Theme'=>$Themes));


    }



////////////////// Partie service web
// Raead Feature by id


    public function APIafficheFeatureAction($idTheme)

    {

        $em =$this->getDoctrine()->getManager();
        $Feature =$em->getRepository("ProductBacklogBundle:Feature")->findBy(array('idTheme'=>$idTheme));
        $th =$em->getRepository("ProductBacklogBundle:Theme")->find($idTheme);
        //  $us =$em->getRepository("ProductBacklogBundle:UserStory")->SERCHUS();

        //$sum=0;
        $s=0;
        foreach( $Feature as $value) {
            // $sum++;
            $s=$s+$value->getTotalEstimationFeatureJours();

        }
        $th->setTotalEstimationThemeJours($s);

        $em->persist($th);
        $em->flush();




        $query = $this->getDoctrine()->getEntityManager()
            ->createQuery(
                'SELECT u FROM MeetingBundle:User u WHERE u.roles LIKE :role'
            )->setParameter('role', '%"ROLE_DEVELOPER"%'
            );
        $users = $query->getResult();



        $data = $this->get('jms_serializer')->serialize($Feature, 'json',SerializationContext::create()->setGroups(array('listf')));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;


       // return $this->render("@ProductBacklog/Feature/afficheFeature.html.twig",array('Feature'=>$Feature ,'users'=>$users));


    }





    public function APIProressAction(Request $request,$idFeature)
    {
        $em =$this->getDoctrine()->getManager();
        $us =$em->getRepository("ProductBacklogBundle:UserStory")->SERCHUS($idFeature);

        $tatalEsmatation=0;
        $toatalDoing=0;
        foreach( $us as $value) {
            // $sum++;
            $tatalEsmatation=$tatalEsmatation+$value->getTotalEstimationUserstoryJours();
            $toatalDoing=$toatalDoing+$value->getDoing();
        }



        $toDO=$tatalEsmatation-$toatalDoing;




        //$a=4;
        // $b=7;
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['done',     $toatalDoing],
                ['to do',    $toDO]
            ]
        );
       // $pieChart->getOptions()->setTitle('My Daily Activities');
        //$pieChart->getOptions()->setHeight(500);
        //$pieChart->getOptions()->setWidth(900);
        //$pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        //$pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        //$pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        //$pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        //$pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);


        $progress = new progress();

        $progress->setTodo($toatalDoing);
        $progress->setTotaldone($toDO);


        $data = $this->get('jms_serializer')->serialize($progress, 'json');



        $serializer = new Serializer([new ObjectNormalizer()]);
        //

        $formatted = $serializer->normalize($progress);
        return new JsonResponse($formatted);












        //$serializer = new Serializer([new ObjectNormalizer()]);
        //

        //$formatted = $serializer->normalize(55);
        //return new JsonResponse($formatted);


     //   return $this->render("@ProductBacklog/Feature/progress.html.twig", array('piechart' => $pieChart));
    }





    public function ajouttFeatureAction($nomFeature ,$idTheme )


    {
            $feature= new Feature();
            $em =$this->getDoctrine()->getManager();
            $etat = $em->getRepository(Theme::class)->find($idTheme);
            $feature->setIdTheme($etat);
            $feature->setNomFeature($nomFeature);
            $em->persist($feature);
            $em->flush();
        return  setStatusCode(Response::HTTP_OK);


    }




    public function affectUserToFeatureAction($iduser,$idf)
    {
        $em =$this->getDoctrine()->getManager();
        $f =$em->getRepository("ProductBacklogBundle:Feature")->find($idf);
        $f->setIdUserRespensability($iduser);
        $em->persist($f);
        $em->flush();

        //return 200;
        return new JsonResponse("''c bon",200);

    }




}
