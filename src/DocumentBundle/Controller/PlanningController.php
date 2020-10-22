<?php

namespace DocumentBundle\Controller;

use AppBundle\Entity\Planning;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Planning controller.
 *
 */
class PlanningController extends Controller
{
    /**
     * Lists all planning entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $list = $em->getRepository('AppBundle:Planning')->findAll();


        return $this->render('@Document/planning/list.html.twig',
            array('plannings' => $list,
            ));

    }

    /**
     * Creates a new planning entity.
     *
     */
    public function newAction(Request $request)
    {
        $planning = new Planning();
        $planning->setDateCreation(new \DateTime('now'));
        $planning->setDateModification(new \DateTime('now'));
        $planning->setTimeCreation(new \DateTime('now'));
        $planning->setTimeModification(new \DateTime('now'));
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $planning->setUser($user);

        $form = $this->createForm('AppBundle\Form\PlanningType', $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($planning);
            $em->flush();

            return $this->redirectToRoute('planning_show', array('idPlan' => $planning->getIdplan()));
        }

        return $this->render('@Document/planning/new.html.twig', array(
            'planning' => $planning,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a planning entity.
     *
     */
    public function showAction(Planning $planning)
    {
        $deleteForm = $this->createDeleteForm($planning);

        return $this->render('@Document/planning/show.html.twig', array(
            'planning' => $planning,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing planning entity.
     *
     */
    public function editAction(Request $request, Planning $planning)
    {
        $deleteForm = $this->createDeleteForm($planning);
        $planning->setDateModification(new \DateTime('now'));
        $planning->setTimeModification(new \DateTime('now'));

        $idType = 2;
        $planning->setIdType($idType);

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $planning->setUser($user);

        $editForm = $this->createForm('AppBundle\Form\PlanningType', $planning);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('planning_edit', array('idPlan' => $planning->getIdplan()));
        }

        return $this->render('@Document/planning/edit.html.twig', array(
            'planning' => $planning,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a planning entity.
     *
     */
    public function deleteAction(Request $request, Planning $planning)
    {
        $form = $this->createDeleteForm($planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($planning);
            $em->flush();
        }

        return $this->redirectToRoute('planning_index');
    }

    public function DeletePlanAction(Request $request){
        $id=$request->get('idPlan');
        $em=$this->getDoctrine()->getManager();
        $m=$em->getRepository('AppBundle:Planning')->find($id);
        $em->remove($m);
        $em->flush();

        return $this->redirectToRoute('planning_index');

    }

    /**
     * Creates a form to delete a planning entity.
     *
     * @param Planning $planning The planning entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Planning $planning)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('planning_delete', array('idPlan' => $planning->getIdplan())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* --------------- Mobile functions --------------------*/

    public function ListMobileAction()
    {
        $conn = $this->getDoctrine()->getEntityManager()->getConnection();
        $sql = "select  * from planning   ";

        $stmt = $conn->prepare($sql);

        $stmt->execute();
        $this->getDoctrine()->getManager()->flush();
        $result = $stmt->fetchAll();
        $response = new Response(json_encode($result));
        return $response;


    }
}
