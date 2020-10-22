<?php

namespace UserBundle\Controller;

use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

    public function EditAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $p = $em->getRepository('AppBundle:User')->find($user);
        $form = $this->createForm(RegistrationFormType::class, $p);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $file = $p->getUserPhoto();
            $filename= md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('photos_directory'), $filename);
            $p->setUserPhoto($filename);
            $em= $this->getDoctrine()->getManager();
            $em->persist($p);
            $em->flush();
            return $this->redirectToRoute('profile');
        }
        return $this->render('@User/editProfile.html.twig', array(
            "form" => $form->createView()
        ));
    }



    public function ShowProfileAction(){
        $em=$this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $m=$em->getRepository('AppBundle:User')->find($user);
        return $this->render('@User/Developer/profile.html.twig',array(
            'userPhoto'=>$m->getUserPhoto(),
            'userPhone'=>$m->getUserPhone(),
            'userAddress'=>$m->getUserAddress(),
            'userDayBirth'=>$m->getUserDayBirth(),
            'nationality'=>$m->getNationality(),
            'speciality'=>$m->getSpeciality(),
            'bio'=>$m->getBio(),



        ));

    }


    public function loginMobileAction($username, $password)
    {
        $user_manager = $this->get('fos_user.user_manager');
        $factory = $this->get('security.encoder_factory');

        $data = [
            'type' => 'validation error',
            'title' => 'There was a validation error',
            'errors' => 'username or password invalide'
        ];
        $response = new JsonResponse($data, 400);

        $user = $user_manager->findUserByUsername($username);

        if(!$user)
            return $response;


        $encoder = $factory->getEncoder($user);

        $bool = ($encoder->isPasswordValid($user->getPassword(),$password,$user->getSalt())) ? "true" : "false";
        if($bool=="true")
        {
            $role= $user->getRoles();

            $data=array('type'=>'Login succeed',
                'id'=>$user->getId(),
                'userName'=>$user->getUsername(),
                'lastname'=>$user->getLastname(),
                'userMail'=>$user->getEmail(),
                'userDayOfBirth'=>$user->getUserDayBirth()->format('d-m-Y'),
                'userCin'=>$user->getUserCin(),
                'userPhone'=>$user->getUserPhone(),
                'userPhoto'=>$user->getUserPhoto(),

                'userPassword'=>$user->getUserPassword(),

                'roles'=>$user->getRoles());
            $response = new JsonResponse($data, 200);
            return $response;

        }
        else
        {
            return $response;

        }
    }

}
