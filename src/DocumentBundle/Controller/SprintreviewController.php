<?php

namespace  DocumentBundle\Controller;

use AppBundle\Entity\Sprintreview;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Sprintreview controller.
 *
 */
class SprintreviewController extends Controller
{
    /**
     * Lists all sprintreview entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //$result = $em->getRepository('DocDocumentBundle:Sprintreview')->findAll();

        $dql   = "SELECT sr FROM AppBundle:Sprintreview sr";
        $query = $em->createQuery($dql);
        /**
         * @var $paginator \knp\component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit', 5)
        );

        return $this->render('@Document/sprintreview/index.html.twig',
            array('sprintreviews' => $result,
            ));

    }

    /**
     * Creates a new sprintreview entity.
     *
     */
    public function newAction(Request $request)
    {
        $sprintreview = new Sprintreview();
        $sprintreview->setDateCreation(new \DateTime('now'));
        $sprintreview->setTimeCreation(new \DateTime('now'));
        $sprintreview->setDateModification(new \DateTime('now'));
        $sprintreview->setTimeModification(new \DateTime('now'));

        $idType = 4;
        $sprintreview->setIdType($idType);

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $sprintreview->setUser($user);

        $form = $this->createForm('AppBundle\Form\SprintreviewType', $sprintreview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sprintreview);
            $em->flush();

            return $this->redirectToRoute('sprintreview_show', array('idReview' => $sprintreview->getIdreview()));
        }

        return $this->render('@Document/sprintreview/new.html.twig', array(
            'sprintreview' => $sprintreview,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sprintreview entity.
     *
     */
    public function showAction(Sprintreview $sprintreview)
    {
        $deleteForm = $this->createDeleteForm($sprintreview);

        return $this->render('@Document/sprintreview/show.html.twig', array(
            'sprintreview' => $sprintreview,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sprintreview entity.
     *
     */
    public function editAction(Request $request, Sprintreview $sprintreview)
    {
        $deleteForm = $this->createDeleteForm($sprintreview);
        $sprintreview->setDateModification(new \DateTime('now'));
        $sprintreview->setTimeModification(new \DateTime('now'));

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $sprintreview->setUser($user);

        $editForm = $this->createForm('AppBundle\Form\SprintreviewType', $sprintreview);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sprintreview_edit', array('idReview' => $sprintreview->getIdreview()));
        }

        return $this->render('@Document/sprintreview/edit.html.twig', array(
            'sprintreview' => $sprintreview,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sprintreview entity.
     *
     */
    public function deleteAction(Request $request, Sprintreview $sprintreview)
    {
        $form = $this->createDeleteForm($sprintreview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sprintreview);
            $em->flush();
        }

        return $this->redirectToRoute('sprintreview_index');
    }

    public function DeleteRevAction(Request $request){
        $id=$request->get('idReview');
        $em=$this->getDoctrine()->getManager();
        $m=$em->getRepository('AppBundle:Sprintreview')->find($id);
        $em->remove($m);
        $em->flush();

        return $this->redirectToRoute('sprintreview_index');

    }

    /**
     * Creates a form to delete a sprintreview entity.
     *
     * @param Sprintreview $sprintreview The sprintreview entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sprintreview $sprintreview)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sprintreview_delete', array('idReview' => $sprintreview->getIdreview())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /* --------------- Mobile functions --------------------*/

    public function ListMobileAction()
    {
        $conn = $this->getDoctrine()->getEntityManager()->getConnection();
        $sql = "select  * from sprintreview   ";

        $stmt = $conn->prepare($sql);

        $stmt->execute();
        $this->getDoctrine()->getManager()->flush();
        $result = $stmt->fetchAll();
        $response = new Response(json_encode($result));
        return $response;


    }
}
