<?php

namespace  DocumentBundle\Controller;

use AppBundle\Entity\Dailyscrum;
use AppBundle\Entity\Meeting;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Ob\HighchartsBundle\Highcharts\Highchart;
/**
 * Dailyscrum controller.
 *
 */
class DailyscrumController extends Controller
{
    /**
     * Lists all dailyscrum entities.
     *
     */

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository('AppBundle:Dailyscrum')->findAll();

        return $this->render('@Document/dailyscrum/list.html.twig',
            array('dailyscrums' => $result,
            ));

    }


    /**
     * Creates a new dailyscrum entity.
     *
     */
    public function newAction(Request $request)
    {
        $dailyscrum = new Dailyscrum();
        $dailyscrum->setDateCreation(new \DateTime('now'));
        $dailyscrum->setTimeCreation(new \DateTime('now'));
        $dailyscrum->setDateModification(new \DateTime('now'));
        $dailyscrum->setTimeModification(new \DateTime('now'));

        $idType = 1;

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $dailyscrum->setUsername($user);

        $form = $this->createForm('AppBundle\Form\DailyscrumType', $dailyscrum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $dailyscrum->setidType($idType);
            $em->persist($dailyscrum);
            $em->flush();

            return $this->redirectToRoute('dailyscrum_show', array('idDaily' => $dailyscrum->getIddaily()));
        }

        return $this->render('@Document/dailyscrum/new.html.twig', array(
            'dailyscrum' => $dailyscrum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a dailyscrum entity.
     *
     */
    public function showAction(Dailyscrum $dailyscrum)
    {
        $deleteForm = $this->createDeleteForm($dailyscrum);

        return $this->render('@Document/dailyscrum/show.html.twig', array(
            'dailyscrum' => $dailyscrum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing dailyscrum entity.
     *
     */
    public function editAction(Request $request, Dailyscrum $dailyscrum)
    {
        $deleteForm = $this->createDeleteForm($dailyscrum);
        $dailyscrum->setDateModification(new \DateTime('now'));
        $dailyscrum->setTimeModification(new \DateTime('now'));

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $dailyscrum->setUsername($user);

        $editForm = $this->createForm('AppBundle\Form\DailyscrumType', $dailyscrum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dailyscrum_edit', array('idDaily' => $dailyscrum->getIddaily()));
        }

        return $this->render('@Document/dailyscrum/edit.html.twig', array(
            'dailyscrum' => $dailyscrum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a dailyscrum entity.
     *
     */
    public function deleteAction(Request $request, Dailyscrum $dailyscrum)
    {
        $form = $this->createDeleteForm($dailyscrum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dailyscrum);
            $em->flush();
        }

        return $this->redirectToRoute('dailyscrum_index');
    }

    public function DeleteDailyAction(Request $request){
        $id=$request->get('idDaily');
        $em=$this->getDoctrine()->getManager();
        $m=$em->getRepository('AppBundle:Dailyscrum')->find($id);
        $em->remove($m);
        $em->flush();

        return $this->redirectToRoute('dailyscrum_index');

    }

    /**
     * Creates a form to delete a dailyscrum entity.
     *
     * @param Dailyscrum $dailyscrum The dailyscrum entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Dailyscrum $dailyscrum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dailyscrum_delete', array('idDaily' => $dailyscrum->getIddaily())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }



    /* --------------- Mobile functions --------------------*/

    public function ListDailyMobileAction()
    {
        $conn = $this->getDoctrine()->getEntityManager()->getConnection();
        $sql = "select  * from dailyscrum   ";

        $stmt = $conn->prepare($sql);

        $stmt->execute();
        $this->getDoctrine()->getManager()->flush();
        $result = $stmt->fetchAll();
        $response = new Response(json_encode($result));
        return $response;


    }


    public function AddDailyMobileAction(Request $request)
    {

        $title = $request->query->get('title');
        $work = $request->query->get('yesterdaywork');
        $plan = $request->query->get('todayplan');
        $blockers = $request->query->get('blockers');
        $brunt = $request->query->get('hrsbrunt');
        $completed = $request->query->get('hrscompleted');
        $idType = 1;

        $datec = $request->query->get('date_creation');
        $x = new \DateTime($datec);
        $timec = $request->query->get('time_creation');
        $y = new \DateTime($timec);
        $datem = $request->query->get('date_modification');
        $xm = new \DateTime($datem);
        $timem = $request->query->get('time_modification');
        $ym = new \DateTime($timem);


        $daily = new Dailyscrum();
        $daily ->setTitle($title);
        $daily ->setYesterdaywork($work);
        $daily ->setTodayplan($plan);
        $daily ->setBlockers($blockers);
        $daily ->setHrsbrunt($brunt);
        $daily ->setHrscompleted($completed);

        $daily->setDateCreation($x);
        $daily->setTimeCreation($y);
        $daily->setDateModification($xm);
        $daily->setTimeModification($ym);



        $em = $this->getDoctrine()->getManager();
        $daily->setidType($idType);
        try {
            $em->persist($daily );
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

        return $this->json(array('title' => 'successful', 'message' => "DailyScrum file added successfully"), 200);


    }


    public function EditDailyMobileAction(Request $request)
    {


        $id = $request->query->get('idDaily');
        $em = $this->getDoctrine()->getManager();
        $daily = $em->getRepository(Dailyscrum::class)->find($id);
        $title = $request->query->get('title');
        $work = $request->query->get('yesterdaywork');
        $plan = $request->query->get('todayplan');
        $blockers = $request->query->get('blockers');
        $brunt = $request->query->get('hrsbrunt');
        $completed = $request->query->get('hrscompleted');
        $user = $request->query->get('createdby');

        $daily ->setTitle($title);
        $daily ->setYesterdaywork($work);
        $daily ->setTodayplan($plan);
        $daily ->setBlockers($blockers);
        $daily ->setHrsbrunt($brunt);
        $daily ->setHrscompleted($completed);
        $daily->setDateModification(new \DateTime('now'));
        $daily->setTimeModification(new \DateTime('now'));
        $daily->setUsername($user);


        try {
            $em->persist($daily);
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
        return $this->json(array('title' => 'successful', 'message' => "DailyScrum File Edited successfully"), 200);
    }

    public function DeleteMobileAction(Request $request)
    {
        $id = $request->query->get('idDaily');
        $daily = $this->getDoctrine()->getRepository('AppBundle:Dailyscrum')->find($id);
        if ($daily) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($daily);
            $em->flush();
            $response = array("body" => "DailyScrum delete");
        } else {
            $response = array("body" => "Error");
        }
        return new JsonResponse($response);
    }


}
