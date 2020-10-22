<?php

namespace DocumentBundle\Controller;

use Doc\DocumentBundle\Entity\Retrospective;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Retrospective controller.
 *
 */
class RetrospectiveController extends Controller
{
    /**
     * Lists all retrospective entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $result = $em->getRepository('AppBundle:Retrospective')->findAll();


        return $this->render('@Document/retrospective/list.html.twig',
            array('retrospectives' => $result,
            ));

    }

    /**
     * Creates a new retrospective entity.
     *
     */
    public function newAction(Request $request)
    {
        $retrospective = new Retrospective();
        $retrospective->setDateCreation(new \DateTime('now'));
        $retrospective->setDateModification(new \DateTime('now'));
        $retrospective->setTimeCreation(new \DateTime('now'));
        $retrospective->setTimeModification(new \DateTime('now'));
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $retrospective->setUser($user);

        $form = $this->createForm('AppBundle\Form\RetrospectiveType', $retrospective);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($retrospective);
            $em->flush();

            return $this->redirectToRoute('retrospective_show', array('idRetro' => $retrospective->getIdretro()));
        }

        return $this->render('@Document/retrospective/new.html.twig', array(
            'retrospective' => $retrospective,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a retrospective entity.
     *
     */
    public function showAction(Retrospective $retrospective)
    {
        $deleteForm = $this->createDeleteForm($retrospective);

        return $this->render('@Document/retrospective/show.html.twig', array(
            'retrospective' => $retrospective,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing retrospective entity.
     *
     */
    public function editAction(Request $request, Retrospective $retrospective)
    {
        $deleteForm = $this->createDeleteForm($retrospective);
        $retrospective->setDateModification(new \DateTime('now'));
        $retrospective->setTimeModification(new \DateTime('now'));

        $idType = 3;
        $retrospective->setIdType($idType);

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $retrospective->setUser($user);

        $editForm = $this->createForm('AppBundle\Form\RetrospectiveType', $retrospective);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('retrospective_edit', array('idRetro' => $retrospective->getIdretro()));
        }

        return $this->render('@Document/retrospective/edit.html.twig', array(
            'retrospective' => $retrospective,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a retrospective entity.
     *
     */
    public function deleteAction(Request $request, Retrospective $retrospective)
    {
        $form = $this->createDeleteForm($retrospective);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($retrospective);
            $em->flush();
        }



        return $this->redirectToRoute('retrospective_index');
    }

    public function DeleteRetroAction(Request $request){
        $id=$request->get('idRetro');
        $em=$this->getDoctrine()->getManager();
        $m=$em->getRepository('AppBundle:Retrospective')->find($id);
        $em->remove($m);
        $em->flush();

        return $this->redirectToRoute('retrospective_index');

    }

    /**
     * Creates a form to delete a retrospective entity.
     *
     * @param Retrospective $retrospective The retrospective entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Retrospective $retrospective)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('retrospective_delete', array('idRetro' => $retrospective->getIdretro())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /* --------------- Mobile functions --------------------*/

    public function ListMobileAction()
    {
        $conn = $this->getDoctrine()->getEntityManager()->getConnection();
        $sql = "select  * from retrospective   ";

        $stmt = $conn->prepare($sql);

        $stmt->execute();
        $this->getDoctrine()->getManager()->flush();
        $result = $stmt->fetchAll();
        $response = new Response(json_encode($result));
        return $response;


    }
}
