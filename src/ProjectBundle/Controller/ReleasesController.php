<?php

namespace ProjectBundle\Controller;

use AppBundle\Entity\Issue;
use AppBundle\Entity\Project;
use AppBundle\Entity\Releases;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Release controller.
 *
 * @Route("releases")
 */
class ReleasesController extends Controller
{
    /**
     * Lists all release entities.
     *
     * @Route("/", name="releases_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $releases = $em->getRepository('AppBundle:Releases')->findAll();

        return $this->render('@Project/releases/index.html.twig', array(
            'releases' => $releases,
        ));
    }

    /**
     * Creates a new release entity.
     *
     * @Route("/new", name="releases_new")
     * @Method({"GET", "POST"})
     */

    public function newAction(Request $request)
    {
        $release = new Releases();
        $form = $this->createForm('AppBundle\Form\ReleasesType', $release);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($release);
            $em->flush();

            return $this->redirectToRoute('releases_show', array('id' => $release->getId()));
        }

        return $this->render('@Project/releases/new.html.twig', array('release' => $release, 'form' => $form->createView(),
        ));
    }





    /**
     * Finds and displays a release entity.
     *
     * @Route("/{id}", name="releases_show")
     * @Method("GET")
     */
    public function showAction(Releases $release)
    {
        $deleteForm = $this->createDeleteForm($release);

        return $this->render('@Project/releases/show.html.twig', array(
            'release' => $release,
            'delete_form' => $deleteForm->createView(),
        ));
    }




    /**
     * Displays a form to edit an existing release entity.
     *
     * @Route("/{id}/edit", name="releases_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Releases $release)
    {
        $deleteForm = $this->createDeleteForm($release);
        $editForm = $this->createForm('AppBundle\Form\ReleasesType', $release);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('releases_edit', array('id' => $release->getId()));
        }

        return $this->render('@Project/releases/edit.html.twig', array(
            'release' => $release,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }




    /**
     * @Route("releases/delete/{id}", name="releases_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Releases');
        $releases= $repository->find($id);

        $form = $this->createDeleteForm($releases);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($releases);
            $em->flush();
        }

        return $this->redirectToRoute('releases_index');
    }

    /**
     *
     * @param Releases $releases
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Releases $releases)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('releases_delete', array('id' => $releases->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }


    public function rechercheReleasesByNameAction(Request $request)

    {
        $em=$this->getDoctrine()->getManager();
        $releases = $em->getRepository(Releases::class)->findAll();
        if($request->isMethod("POST"))
        {
            $name = $request->get('name');
            $releases = $em->getRepository("AppBundle:Releases")->findBy(array('name'=>$name));
        }

        return$this->render('@Project/releases/index.html.twig',array('releases'=>$releases));
    }



    public function AjouterMobileAction(Request $request)
    {


        $name = $request->query->get('name');
        $description = $request->query->get('description');
        $startDate = $request->query->get('startDate');
        $releaseDate = $request->query->get('releaseDate');


        $release = new Releases();
        $project=$this->getDoctrine()->getRepository(Project::class)->find(intval($request->get('project_id')));

        $release->setName($name);
        $release->setDescription($description);
        $release->setStartDate($startDate);
        $release->setReleaseDate($releaseDate);


        $release->setProject($project);
        $em = $this->getDoctrine()->getManager();

        try {
            $em->persist($release);
            $em->flush();
        }catch(\Exception $ex)
        {
            die($ex);
            $data = [
                'title' => 'validation error',
                'message' => 'Some thing went Wrong',
                'errors' => $ex->getMessage()
            ];
            $response = new JsonResponse($data,400);
            return $response;
        }

        return $this->json(array('title'=>'successful','message'=> " Release added"),200);

    }


    public function affichageMobileAction()
    {

        $conn = $this->getDoctrine()->getEntityManager()->getConnection();
        $sql = "select  * from Releases   ";

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
        $release = $this->getDoctrine()->getRepository('AppBundle:Releases')->findOneById($id);
        if ($release) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($release);
            $em->flush();
            $response = array("body" => "Release delete");
        } else {
            $response = array("body" => "Error");
        }
        return new JsonResponse($response);
    }


    public function modifMobileAction(Request $request)
    {


        $id = $request->query->get('id');
        $em = $this->getDoctrine()->getManager();
        $releases = $em->getRepository(Releases::class)->find($id);
        $name = $request->query->get('name');
        $description = $request->query->get('description');
        $startDate = $request->query->get('startDate');
        $releaseDate = $request->query->get('releaseDate');
        $project=$this->getDoctrine()->getRepository(Project::class)->find(intval($request->get('idProject')));



        $releases->setName( $name);
        $releases->setDescription($description);
        $releases->setStartDate($startDate);
        $releases->setReleaseDate($releaseDate);

        $releases->setProject( $project);


        try {
            $em->persist($releases);
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
        return $this->json(array('title' => 'successful', 'message' => "Release Edited successfully"), 200);
    }

}
