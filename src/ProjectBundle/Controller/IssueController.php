<?php

namespace ProjectBundle\Controller;

use AppBundle\Entity\Issue;
use AppBundle\Entity\Project;
use AppBundle\Form\IssueType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Ob\HighchartsBundle\Highcharts\Highchart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use AppBundle\Entity\Notification;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Issue controller.
 *
 * @Route("issue")
 */
class IssueController extends Controller
{
    /**
     * Lists all issue entities.
     *
     * @Route("/", name="issue_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $issues = $em->getRepository('AppBundle:Issue')->findAll();

        return $this->render('@Project/issue/index.html.twig', array(
            'issues' => $issues,
        ));
    }

    /**
     * Creates a new issue entity.
     *
     * @Route("/new", name="issue_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $issue = new Issue();
        $form = $this->createForm('AppBundle\Form\IssueType', $issue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($issue);
            $em->flush();

            return $this->redirectToRoute('issue_show', array('id' => $issue->getId()));
        }

        return $this->render('@Project/issue/new.html.twig', array(
            'issue' => $issue,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a issue entity.
     *
     * @Route("/{id}", name="issue_show")
     * @Method("GET")
     */
    public function showAction(Issue $issue)
    {
        $deleteForm = $this->createDeleteForm($issue);

        return $this->render('@Project/issue/show.html.twig', array(
            'issue' => $issue,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing issue entity.
     *
     * @Route("/{id}/edit", name="issue_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Issue $issue)
    {
        $deleteForm = $this->createDeleteForm($issue);
        $editForm = $this->createForm('AppBundle\Form\IssueType', $issue);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('issue_edit', array('id' => $issue->getId()));
        }

        return $this->render('@Project/issue/edit.html.twig', array(
            'issue' => $issue,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }





    /**
     * @Route("issue/delete/{id}", name="issue_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Issue');
        $issue = $repository->find($id);

        $form = $this->createDeleteForm($issue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($issue);
            $em->flush();
        }

        return $this->redirectToRoute('issue_index');
    }

    /**
     *
     * @param Issue $issue
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Issue $issue)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('issue_delete', array('id' => $issue->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }


public function rechercheIssueByStatusAction(Request $request)

{
$em=$this->getDoctrine()->getManager();
$issues = $em->getRepository(Issue::class)->findAll();
if($request->isMethod("POST"))
{
$status = $request->get('status');
$issues = $em->getRepository("AppBundle:Issue")->findBy(array('status'=>$status));
}

return$this->render('@Project/issue/index.html.twig',array('issues'=>$issues));
}











/*public function statAction()
{
    $pieChart = new PieChart();


    $pieChart->getData()->setArrayToDataTable(
        [['Task', 'Hours per Day'],
            ['Bug',     11],
            ['Story',      2],
            ['Task',  4],
            ['SubTask',    7]
        ]
    );

    $pieChart->getOptions()->setTitle('Types of issues');
    $pieChart->getOptions()->setHeight(500);
    $pieChart->getOptions()->setWidth(900);
    $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
    $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
    $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
    $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
    $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

    return $this->render('@Project/issue/stat.html.twig', array('piechart' => $pieChart));
}*/





    public function statIssuesAction()
    {
        $type=$this->container->get('security.token_storage')->getToken()->getUser();
        $list=$this->getDoctrine()->getManager()->getRepository(\AppBundle\Entity\Issue::class)->findby(array('type'=>$type));

        $final=array();

        foreach ($list as $ls)
        {
            array_push($final,array($ls->getIssue()->getType(),sizeof($ls->getUser())));
        }
        $series = array(
            array("type"=>"pie","name" => "Types of issues","data"=>$final)
        );

        $ob = new Highchart();
        $ob->chart->renderTo('linechart');  // The #id of the div where to render the chart
        $ob->title->text('Types of issues');
        $ob->xAxis->title(array('text'  => "Issues"));
        $ob->yAxis->title(array('text'  => "Types"));
        $ob->series($series);

        return $this->render('@Project/Issue/stat.html.twig', array(
            'chart' => $ob
        ));
    }



    public function AjouterMobileAction(Request $request)
    {

        $type = $request->query->get('type');
        $description = $request->query->get('description');
        $summary = $request->query->get('summary');
        $priority = $request->query->get('priority');
        $status = $request->query->get('status');

        $issues = new Issue();
        $project=$this->getDoctrine()->getRepository(Project::class)->find(intval($request->get('project_id')));
        $issues->setType($type);
        $issues->setDescription($description);
        $issues->setSummary($summary);
        $issues->setPriority($priority);

        $issues->setStatus($status);

        $issues->setProject($project);
        $em = $this->getDoctrine()->getManager();

        try {
            $em->persist($issues);
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
        return $this->json(array('title' => 'successful', 'message' => "Issue added successfully"), 200);



    }


    public function affichageMobileAction()
    {

        $conn = $this->getDoctrine()->getEntityManager()->getConnection();
        $sql = "select  * from Issue   ";

        $stmt = $conn->prepare($sql);

        $stmt->execute();
        $this->getDoctrine()->getManager()->flush();
        $result = $stmt->fetchAll();
        $response = new Response(json_encode($result));
        return $response;


    }


    public function SupprimerMobileAction(Request $request)
    {
        $id = $request->query->get('id');
        $project = $this->getDoctrine()->getRepository('AppBundle:Issue')->findOneById($id);
        if ($project) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($project);
            $em->flush();
            $response = array("body" => "Issue delete");
        } else {
            $response = array("body" => "Error");
        }
        return new JsonResponse($response);
    }

    public function modifMobileAction(Request $request)
    {


        $id = $request->query->get('id');
        $em = $this->getDoctrine()->getManager();
        $issue = $em->getRepository(Issue::class)->find($id);
        $type = $request->query->get('type');
        $description = $request->query->get('description');
        $summary = $request->query->get('summary');
        $priority = $request->query->get('priority');
        $status = $request->query->get('status');
        $project=$this->getDoctrine()->getRepository(Project::class)->find(intval($request->get('idProject')));



        $issue->setType( $type);
        $issue->setDescription($description);
        $issue->setSummary( $summary);
        $issue->setPriority($priority);
        $issue->setStatus($status);
        $issue->setProject( $project);

        try {
            $em->persist($issue);
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
        return $this->json(array('title' => 'successful', 'message' => "Issue Edited successfully"), 200);
    }

}


