<?php

namespace ProductBacklogBundle\Controller;

//use AncaRebeca\FullCalendarBundle\Service\Serializer;
use JMS\Serializer\SerializationContext;
use ProductBacklogBundle\Entity\ProductBacklog;
use ProductBacklogBundle\Form\ProductBacklogType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class ProductBacklogController extends Controller
{
    public function addProductBacklogAction(Request $request){

    $pb=new ProductBacklog();
    $form1 =$this->createForm(ProductBacklogType::class,$pb);
    $form1->handleRequest($request);
    if ($form1->isSubmitted())
    {
        $em =$this->getDoctrine()->getManager();
        $em->persist($pb);
        $em->flush();



    }

        return $this->render("@ProductBacklog/ProductBacklog/addProductBacklog.html.twig",array('form'=>$form1->createView()));

    }

    public function testuserAction($idff)
    {
        $idgff=$idff;

        $query = $this->getDoctrine()->getEntityManager()
            ->createQuery(
                'SELECT u FROM MeetingBundle:User u WHERE u.roles LIKE :role'
            )->setParameter('role', '%"ROLE_DEVELOPER"%'
            );
        $users = $query->getResult();


        return $this->render("@ProductBacklog/Feature/test.html.twig", array('users' => $users,'idf' =>$idgff) );
    }


    public function afficheAction()
    {

        $em =$this->getDoctrine()->getManager();
        $PBs =$em->getRepository("ProductBacklogBundle:ProductBacklog")->findAll();
       return $this->render("@ProductBacklog/ProductBacklog/afficheProductBacklog.html.twig",array('ProductBacklog'=>$PBs));
    }


    //Service Web productbacklog entity ReadAll
    public function alllAction()
    {
        $em =$this->getDoctrine()->getManager();
        $PBs =$em->getRepository("ProductBacklogBundle:ProductBacklog")->findAll();




        $serializer = new Serializer([new ObjectNormalizer()]);
    //

        $formatted = $serializer->normalize($PBs);
        return new JsonResponse($formatted);

    }




    public function accueilAction()
    {
        return $this->render("@ProductBacklog/ProductBacklog/accueil.html.twig");
    }


    public function adddProductBacklogAction(Request $request){

        $pb=new ProductBacklog();
        $form1 =$this->createForm(ProductBacklogType::class,$pb);
        $form1->handleRequest($request);
        if ($form1->isSubmitted())
        {
            $em =$this->getDoctrine()->getManager();
            $em->persist($pb);
            $em->flush();



        }

        return $this->render("@ProductBacklog/ProductBacklog/addProductBacklog.html.twig",array('form'=>$form1->createView()));

    }



    public function allDevlopperAction()
    {
        //$idgff=$idff;



        $query = $this->getDoctrine()->getEntityManager()
            ->createQuery(
                'SELECT u FROM MeetingBundle:User u WHERE u.roles LIKE :role'
            )->setParameter('role', '%"ROLE_DEVELOPER"%'
            );
        $users = $query->getResult();



      //  $em =$this->getDoctrine()->getManager();
    //    $users =$em->getRepository("MeetingBundle:User")->findAll();






        foreach ($users as $member)
        {

                $arrayCollection[] = array(
                    'id' => $member->getId(),
                    'firstname'=>$member->getName(),
                    'lastname'=>$member->getLastname(),
                   // 'post'=>$member->getName(),
                    //'roles'=>$member->getRoles(),


                    // ... Same for each property you want
                );
            }

            return new JsonResponse($arrayCollection,200);









        //$data = $this->get('jms_serializer')->serialize($users, 'json',SerializationContext::create()->setGroups(array('list')));
     //   $data = $this->get('jms_serializer')->serialize($users, 'json');

        //$response = new Response($data);
        //$response->headers->set('Content-Type', 'application/json');

        //return $response;

       // return $this->render("@ProductBacklog/Feature/test.html.twig", array('users' => $users,'idf' =>$idgff) );
    }









}
