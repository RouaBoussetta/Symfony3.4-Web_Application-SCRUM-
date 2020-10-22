<?php

namespace MeetingBundle\Controller;

use AppBundle\Entity\ClaimMeeting;
use AppBundle\Entity\Meeting;
use AppBundle\Entity\Project;
use AppBundle\Entity\User;
use AppBundle\Form\MeetingType;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class MeetingController extends Controller
{


    public function chartAction()
    {
        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $list=$this->getDoctrine()->getManager()->getRepository(\AppBundle\Entity\ClaimMeeting::class)->findby(array('user'=>$user));
        $final=array();

        foreach ($list as $ls)
        {
            array_push($final,array($ls->getMeeting()->getTitleMeeting(),sizeof($ls->getUser())));
        }
        $series = array(
            array("type"=>"pie","name" => "Number of participants","data"=>$final)
        );

        $ob = new Highchart();
        $ob->chart->renderTo('linechart');  // The #id of the div where to render the chart
        $ob->title->text('Participation in meeting events');
        $ob->xAxis->title(array('text'  => "Meetings"));
        $ob->yAxis->title(array('text'  => "Participants"));
        $ob->series($series);

        return $this->render('@Meeting/Meeting/stat.html.twig', array(
            'chart' => $ob
        ));
    }


    public function AdminchartAction()
    {
        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $list=$this->getDoctrine()->getManager()->getRepository(Meeting::class)->findAll();
        $final=array();

        foreach ($list as $ls)
        {
            array_push($final,array($ls->getTitleMeeting(),sizeof($ls->getUsers())));
        }
        $series = array(
            array("type"=>"pie","name" => "Number of participants","data"=>$final)
        );

        $ob = new Highchart();
        $ob->chart->renderTo('linechart');  // The #id of the div where to render the chart
        $ob->title->text('Participation in meeting events');
        $ob->xAxis->title(array('text'  => "Meetings"));
        $ob->yAxis->title(array('text'  => "Participants"));
        $ob->series($series);

        return $this->render('@Meeting/Meeting/AdminDashboard.html.twig', array(
            'chart' => $ob
        ));
    }
    public function searchStaticAction(Request $request)
    {
        $m = new Meeting();
        $m->getTitleMeeting();
        $em = $this->getDoctrine()->getManager();

        $meeting = $em->getRepository("AppBundle:Meeting")
            ->Search($m);
        return $this->render("@Meeting/Meeting/ListMeetings.html.twig", array(
            "meetings" => $meeting

        ));

    }


    public function AddMeetingAction(Request $request, SwiftmailerBundle $mailer = null)
    {

        $meeting = new Meeting();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $meeting->setOrganizedBy($user);
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ef = $this->getDoctrine()->getManager();
            $ef->persist($meeting);
            $ef->flush();


            return $this->redirectToRoute('meeting_calendar');
        }
        return $this->render('@Meeting/Meeting/AddMeeting.html.twig', array('form' => $form->createView()));

    }

/*
    public function ShownbMeetingsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $meeting = $em->getRepository("AppBundle:Meeting")->countMeeting();
        return $this->render('@User/Master/Master.html.twig', [
            'nb' => $meeting
        ]);
    }
*/


    public function RefineMeetingAction(Request $request)
    {
        $type = $request->get('type');
        $em = $this->getDoctrine()->getManager();
        $meeting = $em->getRepository("AppBundle:Meeting")
            ->FindByType($type);
        return $this->render("@Meeting/Meeting/ListMeetings.html.twig", array(
            "meetings" => $meeting

        ));

        $seraliser = new Serializer([new ObjectNormalizer()]);
        $formatted = $seraliser->normalize($meeting);
        return new JsonResponse($formatted);

    }


    public function SortMeetingDescAction()
    {
        $em = $this->getDoctrine()->getManager();
        $meeting = $em->getRepository("AppBundle:Meeting")
            ->findDateOrderDesc();

        return $this->render("@Meeting/Meeting/listMeetings.html.twig", array(
            "meetings" => $meeting,

        ));
    }

    public function SortMeetingASCAction()
    {
        $em = $this->getDoctrine()->getManager();
        $meeting = $em->getRepository("AppBundle:Meeting")
            ->findDateOrderASC();

        return $this->render("@Meeting/Meeting/listMeetings.html.twig", array(
            "meetings" => $meeting,

        ));
    }

    public function ModifyMeetingAction(Request $request, $id)
    {


        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository('AppBundle:Meeting')->find($id);
        $form = $this->createForm(MeetingType::class, $p);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($p);
            $em->flush();
            return $this->redirectToRoute('meeting_listmeetings');

        }
        return $this->render('@Meeting/Meeting/ModifyMeeting.html.twig', array(
            "form" => $form->createView()
        ));
    }


    public function DeleteMeetingAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $m = $em->getRepository('AppBundle:Meeting')->find($id);
        $em->remove($m);
        $em->flush();

        return $this->redirectToRoute('meeting_calendar');

    }


    public function ShowMeetingDetailAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $m = $em->getRepository('AppBundle:Meeting')->find($id);
        return $this->render('@Meeting/Meeting/DetailMeeting.html.twig', array(
            'titleMeeting' => $m->getTitleMeeting(),
            'goal' => $m->getGoal(),
            'issues' => $m->getIssues(),
            'project' => $m->getProject(),
            'type' => $m->getType(),
            'date' => $m->getDate()->format('Y-m-d'),
            'time' => $m->getTime(),
            'users' => $m->getUsers(),
            'duration' => $m->getDuration(),
            'location' => $m->getLocation(),
            'organizedBy' => $m->getOrganizedBy(),

            'id' => $m->getId()

        ));

    }

    public function calendarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $meetings = $em->getRepository('AppBundle:Meeting')->findAll();
        return $this->render('@Meeting/Meeting/calendar.html.twig', array(
            'meetings' => $meetings
        ));
    }

    public function DisplayDailyAction()
    {
        $em = $this->getDoctrine()->getManager();
        $meetings = $em->getRepository('AppBundle:Meeting')->findDailyMeeting();
        return $this->render('@Meeting/Meeting/DailyMeetings.html.twig', array(
            'meetings' => $meetings
        ));
    }

    public function DisplayReviewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $meetings = $em->getRepository('AppBundle:Meeting')->findReviewMeeting();
        return $this->render('@Meeting/Meeting/ReviewMeetings.html.twig', array(
            'meetings' => $meetings
        ));
    }

    public function DisplayRetroAction()
    {
        $em = $this->getDoctrine()->getManager();
        $meetings = $em->getRepository('AppBundle:Meeting')->findRetrospectiveMeeting();
        return $this->render('@Meeting/Meeting/RetrospectiveMeetings.html.twig', array(
            'meetings' => $meetings
        ));
    }

    public function DisplaySprintAction()
    {
        $em = $this->getDoctrine()->getManager();
        $meetings = $em->getRepository('AppBundle:Meeting')->findSprintMeeting();
        return $this->render('@Meeting/Meeting/SprintMeetings.html.twig', array(
            'meetings' => $meetings
        ));
    }

    public function ListMeetingsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $meetings = $em->getRepository('AppBundle:Meeting')->findAll();
        return $this->render('@Meeting/Meeting/ListMeetings.html.twig', array(
            'meetings' => $meetings
        ));
    }

    public function LoadEvCalendarAction()
    {
        $em = $this->getDoctrine()->getManager();

        $listMeetings = $em->getRepository('AppBundle:Meeting')->findAll();
        $listEvJson = array();
        foreach ($listMeetings as $meeting)
            $listEvJson[] = array(
                'title' => $meeting->getTitleMeeting(),
                'start' => "" . ($meeting->getDate()->format('Y-m-d')) . "",
                'end' => "" . ($meeting->getDate()->format('Y-m-d')) . "",
                'id' => "" . ($meeting->getId()) . ""
            );
        return new JsonResponse(array('events' => $listEvJson));
    }

    public function ListMeetingMobileAction()
    {
        /*   $em = $this->getDoctrine()->getManager();
           $query = $em->createQuery(
               'SELECT c
           FROM MeetingBundle:Meeting c'
           );
           $meeting = $query->getArrayResult();

           $response = new Response(json_encode($meeting));

           return $response;*/
        $conn = $this->getDoctrine()->getEntityManager()->getConnection();
        $sql = "select  * from meeting   ";

        $stmt = $conn->prepare($sql);

        $stmt->execute();
        $this->getDoctrine()->getManager()->flush();
        $result = $stmt->fetchAll();
        $response = new Response(json_encode($result));
        return $response;


    }

    public function AddMeetingMobileAction(Request $request)
    {

        $title = $request->query->get('title');
        $goal = $request->query->get('goal');
        $issues = $request->query->get('issues');
        $type = $request->query->get('type');
        $date = $request->query->get('date');
        $x = new \DateTime($date);
        $time = $request->query->get('time');
        $y = new \DateTime($time);

        $duration = $request->query->get('duration');
        $location = $request->query->get('location');
        $organizedBy=$request->query->get('organizedBy');

        $meeting = new Meeting();
        $project=$this->getDoctrine()->getRepository(Project::class)->find(intval($request->get('project_id')));

        $meeting->setTitleMeeting($title);
        $meeting->setGoal($goal);
        $meeting->setIssues($issues);
        $meeting->setType($type);
        $meeting->setDate($x);
        $meeting->setTime($y);
        $meeting->setDuration($duration);
        $meeting->setLocation($location);
        $meeting->setOrganizedBy($organizedBy);
        $meeting->setProject($project);


        $em = $this->getDoctrine()->getManager();

        try {
            $em->persist($meeting);
            $em->flush();

        } catch (\Exception $ex) {
            $data = [
                'title' => 'validation error',
                'message' => 'Some thing went Wrong',
                'errors' => $ex->getMessage()
            ];
            $response = new JsonResponse($data, 400);
            return $response;
        }

        return $this->json(array('title' => 'successful', 'message' => "Meeting added successfully"), 200);


    }


    public function deleteMeetingMobileAction(Request $request)
    {
        $id = $request->query->get('id');
        $meeting = $this->getDoctrine()->getRepository('AppBundle:Meeting')->findOneById($id);
        if ($meeting) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($meeting);
            $em->flush();
            $response = array("body" => "Meeting delete");
        } else {
            $response = array("body" => "Error");
        }
        return new JsonResponse($response);
    }

    public function EditMeetingMobileAction(Request $request)
    {


        $id = $request->query->get('id');
        $em = $this->getDoctrine()->getManager();
        $meeting = $em->getRepository(Meeting::class)->find($id);
        $title = $request->query->get('title');
        $goal = $request->query->get('goal');
        $issues = $request->query->get('issues');
        $type = $request->query->get('type');
        $project=$this->getDoctrine()->getRepository(Project::class)->find(intval($request->get('idProject')));


        $duration = $request->query->get('duration');
        $location = $request->query->get('location');
        $meeting->setTitleMeeting($title);
        $meeting->setGoal($goal);
        $meeting->setIssues($issues);
        $meeting->setType($type);
        $meeting->setDuration($duration);
        $meeting->setLocation($location);
        $meeting->setProject($project);

        try {
            $em->persist($meeting);
            $em->flush();
        } catch (\Exception $ex) {
            $data = [
                'title' => 'validation error',
                'message' => 'Some thing went Wrong',
                'errors' => $ex->getMessage()
            ];
            $response = new JsonResponse($data, 400);
            return $response;
        }
        return $this->json(array('title' => 'successful', 'message' => "Meeting Edited successfully"), 200);
    }


    public function ListProjectMobileAction()
    {

        $conn = $this->getDoctrine()->getEntityManager()->getConnection();
        $sql = "select  * from project   ";

        $stmt = $conn->prepare($sql);

        $stmt->execute();
        $this->getDoctrine()->getManager()->flush();
        $result = $stmt->fetchAll();
        $response = new Response(json_encode($result));
        return $response;


    }

    public function ListUserMobileAction()
    {
        $conn = $this->getDoctrine()->getEntityManager()->getConnection();
        $sql = "select  * from user  ";

        $stmt = $conn->prepare($sql);

        $stmt->execute();
        $this->getDoctrine()->getManager()->flush();
        $result = $stmt->fetchAll();
        $response = new Response(json_encode($result));
        return $response;

    }

    public function ListMemberMobileAction()
    {
        $conn = $this->getDoctrine()->getEntityManager()->getConnection();
        $sql = "select  * from meeting_user  ";

        $stmt = $conn->prepare($sql);

        $stmt->execute();
        $this->getDoctrine()->getManager()->flush();
        $result = $stmt->fetchAll();
        $response = new Response(json_encode($result));
        return $response;

    }

    public function countMeetingMobileAction()
    {
        $conn = $this->getDoctrine()->getEntityManager()->getConnection();
        $sql = "select  count(*) as total from meeting  ";

        $stmt = $conn->prepare($sql);

        $stmt->execute();
        $this->getDoctrine()->getManager()->flush();
        $result = $stmt->fetchAll();
        $response = new Response(json_encode($result));
        return $response;
    }


    public function RefineMeetingMobileAction(Request $request)
    {
        $type = $request->get('type');
        $em = $this->getDoctrine()->getManager();
        $meeting = $em->getRepository("AppBundle:Meeting")
            ->FindByType($type);

        $seraliser = new Serializer([new ObjectNormalizer()]);
        $formatted = $seraliser->normalize($meeting);
        return new JsonResponse($formatted);

    }
}
