<?php

namespace App\Controller;

use App\Entity\Reply;
use App\Form\ReplyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReplyController extends AbstractController
{
    /**
     * @Route("/reply", name="reply")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $reply=new Reply();
        $form=$this->createForm(ReplyType::class,$reply);
        $em= $this->getDoctrine()->getManager();
        $form->handleRequest($request);


        if($form->isSubmitted()){
            $em->persist($reply);
            $em->flush();
        }
        return $this->render('reply/index.html.twig',
            [
                'form'=>$form->createView()
            ]
        );}


    /**
     * @Route ("/reply/{id}", name="deletereply")
     */
        public function delete(Request $request):Response{
           return $this->redirect('/');
    }



}
