<?php

namespace ProjectBundle\Controller;

use AppBundle\Entity\Issue;
use AppBundle\Entity\Notification;
use AppBundle\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\TableChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\OrgChart;
use Symfony\Component\HttpFoundation\Response;

/**
 * Project controller.
 *
 * @Route("project")
 */
class ProjectController extends Controller
{
    /**
     * Lists all project entities.
     *
     * @Route("/", name="project_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $projects = $em->getRepository('AppBundle:Project')->findAll();

        return $this->render('@Project/project/index.html.twig', array(
            'projects' => $projects,
        ));
    }

    /**
     * Creates a new project entity.
     *
     * @Route("/new", name="project_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $project = new Project();
        $form = $this->createForm('AppBundle\Form\ProjectType', $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();


            return $this->redirectToRoute('project_show', array('idProject' => $project->getIdproject()));
        }

        return $this->render('@Project/project/new.html.twig', array(
            'project' => $project,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a project entity.
     *
     * @Route("/{idProject}", name="project_show")
     * @Method("GET")
     */
    public function showAction(Project $project)
    {
        $deleteForm = $this->createDeleteForm($project);

        return $this->render('@Project/project/show.html.twig', array(
            'project' => $project,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing project entity.
     *
     * @Route("/{idProject}/edit", name="project_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Project $project)
    {
        $deleteForm = $this->createDeleteForm($project);
        $editForm = $this->createForm('AppBundle\Form\ProjectType', $project);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('project_edit', array('idProject' => $project->getIdproject()));
        }

        return $this->render('@Project/project/edit.html.twig', array(
            'project' => $project,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }





    /**
     * @Route("project/delete/{idProject}", name="project_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $idProject)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Project');
        $project = $repository->find($idProject);

        $form = $this->createDeleteForm($project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($project);
            $em->flush();
        }

        return $this->redirectToRoute('project_index');
    }

    /**
     *
     * @param Project $project
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Project $project)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('project_delete', array('idProject' => $project->getIdProject())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }




    public function rechercheProjectByCategoryAction(Request $request)

    {
        $em=$this->getDoctrine()->getManager();
        $projects = $em->getRepository(Project::class)->findAll();
        if($request->isMethod("POST"))
        {
            $category = $request->get('category');
            $projects = $em->getRepository("AppBundle:Project")->findBy(array('category'=>$category));
        }

        return $this->render('@Project/project/index.html.twig', array(
            'projects' => $projects,
        ));

    }





    public function AjouterMobileAction(Request $request)
    {


        $title = $request->query->get('projectTitle');
        $description = $request->query->get('description');
        $category = $request->query->get('category');
        $version = $request->query->get('version');
        $date = $request->query->get('date_creation');
        $x = new \DateTime($date);
        $time = $request->query->get('time_creation');
        $y = new \DateTime($time);

        $deadline = $request->query->get('deadline');
        $d=new \DateTime($deadline);

        $project = new Project();
        $project->setProjectTitle($title);
        $project->setDescription($description);
        $project->setCategory($category);
        $project->setVersion($version);

        $project->setDateCreation($x);
        $project->setTimeCreation($y);
        $project->setDeadLine($d);

        $em = $this->getDoctrine()->getManager();

        try {
            $em->persist($project);
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
        return $this->json(array('title' => 'successful', 'message' => "Project added successfully"), 200);

    }










    public function affichageMobileAction()
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



    public function SupprimerMobileAction(Request $request)
    {
        $idProject = $request->query->get('idProject');
        $project = $this->getDoctrine()->getRepository('AppBundle:Project')->findOneById($idProject);
        if($project){
            $em = $this->getDoctrine()->getManager();
            $em->remove($project);
            $em->flush();
            $response = array("body"=> "Project delete");
        }else{
            $response = array("body"=>"Error");
        }
        return new JsonResponse($response);

    }



    public function modifMobileAction(Request $request)
    {



        $idProject = $request->query->get('idProject');
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository(Project::class)->find($idProject);
        $projectTitle = $request->query->get('projectTitle');
        $description = $request->query->get('description');
        //$deadLine = $request->query->get('deadLine');
        $category = $request->query->get('category');
        $version = $request->query->get('version');
       // $date_creation = $request->query->get('date_creation');
       // $time_creation = $request->query->get('time_creation');


        $project->setProjectTitle($projectTitle);
        $project->setDescription($description);
        //$project->setDeadLine($deadLine);
        $project->setCategory($category);
        $project->setVersion($version);
       // $project->setDateCreation($date_creation);
       // $project->setTimeCreation($time_creation);
        try {
            $em->persist($project);
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
        return $this->json(array('title' => 'successful', 'message' => "Project Edited successfully"), 200);
    }




    public function CountProjectAction()
    {
        $repository=$this->getDoctrine()->getManager()->getRepository(Project::class);

        $projects = $repository->count();

        return new \Symfony\Component\HttpFoundation\Response($projects);
    }

























}
