<?php

namespace MeetingBundle\Controller;

use AppBundle\Entity\ClaimMeeting;
use AppBundle\Entity\Meeting;
use AppBundle\Entity\User;
use AppBundle\Form\ClaimMeetingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClaimMeetingController extends Controller
{


    public function AddClaimAction(Request $request)
    {

        $claim = new ClaimMeeting();
        $form = $this->createForm(ClaimMeetingType::class, $claim);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //if it s parent who sent this reclam he will be saved to database
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            if($user!=null){
                $claim->setUser($user);
            }
            $em = $this->getDoctrine()->getManager();
            $claim->setName($this->getUser()->getUsername());
            $time=new \DateTime();
            $claim->setDate($time);

            $em->persist($claim);
            $em->flush();
            $this->redirectToRoute('Show_Claim');
        }

        return $this->render('@Meeting/Claim/AddClaim.html.twig', array(
            'claim' => $claim,
            'form' => $form->createView(),
        ));
    }
    public function AddClaimMeetingAction(Request $request)
    {

        $claim = new ClaimMeeting();
        $form = $this->createForm(ClaimMeetingType::class, $claim);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //if it s parent who sent this reclam he will be saved to database
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            if($user!=null){
                $claim->setUser($user);

            }


            $em = $this->getDoctrine()->getManager();
            $claim->setName($this->getUser()->getUsername());
            $time=new \DateTime();
            $claim->setDate($time);
            $claim->setMail($this->getUser()->getEmail());
            $claim->setLastname($this->getUser()->getUsername());
            $em->persist($claim);
            $em->flush();
            $this->redirectToRoute('Show_Claim');

        }

        return $this->render('@Meeting/Claim/AddClaim.html.twig', array(
            'claim' => $claim,
            'form' => $form->createView(),
        ));
    }

    public function ShowClaimAction(){
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $claim = $em->getRepository('AppBundle:ClaimMeeting')->myfindClaim($user);
        return $this->render('@Meeting/Claim/DisplayClaim.html.twig', array(
            'claim'=>$claim
        ));


    }

    public function CountClaimSessionAction()
    {

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $repository=$this->getDoctrine()->getManager()->getRepository(ClaimMeeting::class);

        $claims = $repository->countBySession($user);

        return new \Symfony\Component\HttpFoundation\Response($claims);
    }
    /* ***************************** Admin *******************************************************  */
    public function CountClaimAction()
    {
        $repository=$this->getDoctrine()->getManager()->getRepository(ClaimMeeting::class);

        $claims = $repository->count();

        return new \Symfony\Component\HttpFoundation\Response($claims);
    }

    /* **********************************************************************************  */

    public function ShowDetailAction($id){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $em=$this->getDoctrine()->getManager();
        $m=$em->getRepository('AppBundle:ClaimMeeting')->find($id);
        return $this->render('@Meeting/Claim/DetailClaim.html.twig',array(
            'name'=>$m->getName($user),
            'lastname'=>$m->getLastname($user),
            'tel'=>$m->getTel($user),
            'mail'=>$m->getMail($user),
            'meeting'=>$m->getMeeting(),
            'available'=>$m->getAvailable(),
            'other'=>$m->getOther(),
            'reason'=>$m->getReason(),
            'id'=>$m->getId()

        ));

    }

    public function DeleteClaimAction(Request $request){
        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $m=$em->getRepository('AppBundle:ClaimMeeting')->find($id);
        $em->remove($m);
        $em->flush();

        return $this->redirectToRoute('Show_Claim');

    }

    public function ModifyClaimAction(Request $request, $id){


        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository('AppBundle:ClaimMeeting')->find($id);
        $form = $this->createForm(ClaimMeetingType::class, $p);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($p);
            $em->flush();
            return $this->redirectToRoute('Show_Claim');

        }
        return $this->render('@Meeting/Claim/ModifyClaim.html.twig', array(
            "form" => $form->createView()
        ));
    }

    public function printAction(Request $request)
    {


    }
    public function downloadClaimAction(Request $request) {

    }



    public function  AddClaimMobileAction(Request $request){

        $name = $request->query->get('name');
        $lastname = $request->query->get('lastname');
        $mail = $request->query->get('mail');
        $tel = $request->query->get('tel');
        $available = $request->query->get('available');
        $other = $request->query->get('other');
        $reason = $request->query->get('reason');
        $date = $request->query->get('date');
        $d=new \DateTime($date);

        $claim =new ClaimMeeting();
        $meeting=$this->getDoctrine()->getRepository(Meeting::class)->find(intval($request->get('meeting')));
        $user=$this->getDoctrine()->getRepository(User::class)->find(intval($request->get('user')));

        $claim->setName($name);
        $claim->setLastname($lastname);
        $claim->setMail($mail);
        $claim->setTel($tel);
        $claim->setAvailable($available);
        $claim->setOther($other);
        $claim->setReason($reason);
        $claim->setDate($d);
        $claim->setMeeting($meeting);
        $claim->setUser($user);

        $em=$this->getDoctrine()->getManager();

        try {
            $em->persist($claim);
            $em->flush();

        } catch(\Exception $ex)
        {
            $data = [
                'title' => 'validation error',
                'message' => 'Some thing went Wrong',
                'errors' => $ex->getMessage()
            ];
            $response = new JsonResponse($data,400);
            return $response;
        }

        return $this->json(array('title'=>'successful','message'=> "Claim added successfully"),200);



    }

    public function ListClaimMobileAction(){
        $conn = $this->getDoctrine()->getEntityManager()->getConnection();
        $sql = "select  * from claim_meeting  ";

        $stmt = $conn->prepare($sql);

        $stmt->execute();
        $this->getDoctrine()->getManager()->flush();
        $result=  $stmt->fetchAll();
        $response = new Response(json_encode($result));
        return $response;

    }

    public function deleteClaimMobileAction(Request $request)
    {
        $id = $request->query->get('id');
        $claim = $this->getDoctrine()->getRepository('AppBundle:ClaimMeeting')->findOneById($id);
        if($claim){
            $em = $this->getDoctrine()->getManager();
            $em->remove($claim);
            $em->flush();
            $response = array("body"=> "Claim delete");
        }else{
            $response = array("body"=>"Error");
        }
        return new JsonResponse($response);
    }
    public function  EditClaimMobileAction(Request $request){


        $id = $request->query->get('id');
        $em=$this->getDoctrine()->getManager();
        $claim=$em->getRepository(ClaimMeeting::class)->find($id);
        $name = $request->query->get('name');
        $lastname = $request->query->get('lastname');
        $mail = $request->query->get('mail');
        //$project = $request->query->get('project');
        $tel = $request->query->get('tel');

        $available = $request->query->get('availability');
        $other = $request->query->get('other');
        $reason = $request->query->get('reason');
        $date = $request->query->get('date');
        $d=new \DateTime($date);
        $claim->setName($name);
        $claim->setLastname($lastname);
        $claim->setMail($mail);
        $claim->setTel($tel);
        $claim->setAvailable($available);
        $claim->setOther($other);
        $claim->setReason($reason);
        $claim->setDate($d);
        try {
            $em->persist($claim);
            $em->flush();
        }
        catch(\Exception $ex)
        {
            $data = [
                'title' => 'validation error',
                'message' => 'Some thing went Wrong',
                'errors' => $ex->getMessage()
            ];
            $response = new JsonResponse($data,400);
            return $response;
        }
        return $this->json(array('title'=>'successful','message'=> "Claim Edited successfully"),200);
    }



}
