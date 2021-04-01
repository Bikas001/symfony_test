<?php

namespace App\Controller;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\User;
use App\Form\SignupType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }


    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @param AuthenticationUtils $utils
     * @return Response
     */
    public function login(Request $request, AuthenticationUtils $utils): Response
    {
        $error = $utils->getLastAuthenticationError();
        $lastUsername= $utils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'error' =>$error,
            'lastUsername'=>$lastUsername
        ]);
    }
    /**
     * @Route ("/signup", name="signup")
     */
    public function signup(Request $request){

        $user=new User();
        $form=$this->createForm(SignupType::class,$user);
        $em=$this->getDoctrine()->getManager();
        $form->handleRequest($request);

        $user->setPassword(
            $this->encoder->encodePassword($user,'password')
        );
        if($form->isSubmitted()){
            $em->persist($user);
            $em->flush();
        }


        return $this->render('security/signup.html.twig',[
            'form'=>$form->createView()
        ]);
    }



    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){

    }

    /**
     * @Route ("/forget", name="forget")
     * @param Request $request
     */
    public function forgetpassword(Request $request,UserRepository $userRepository){

        $form=$this->createFormBuilder()
            ->add('oldPassword')
            ->add('newPassword')
            ->add('retypePassword')
            ->add('change',SubmitType::class)
            ->getForm();

        return $this->render('security/forget.html.twig',[
            'form'=>$form->createView()
        ]);
    }


}
