<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Question;
use App\Entity\Reply;
use App\Form\QuestionType;
use App\Form\ReplyType;
use App\Repository\QuestionRepository;
use App\Repository\ReplyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/question", name="question")
 */
class QuestionController extends AbstractController
{

    /**
     * @Route("/", name="question")
     * @param QuestionRepository $questionRepository
     * @return Response
     */
    public function index(QuestionRepository $questionRepository,Request $request): Response
    {




        $like=new Like();
        $form =$this->createFormBuilder()
            ->getForm();

        $form->handleRequest($request);
        $em=$this->getDoctrine()->getManager();

        if($form->isSubmitted()){
            dd($like);
            $em->persist($like);
            $em->flush();
        }


        $question=$questionRepository->findAll();
        return $this->render('question/index.html.twig', [
            'questions'=>$question,
            'form'=>$form->createView()
        ]);
    }

//    /**
//     * @Route(/{id})
//     * @param $id
//     */
//    public function reply($id,QuestionRepository $questionRepository){
//
//    }

    /**
     * @Route("/create",name="create")
     * @param Request $request
     * @return Response
     */

    public function create(Request $request)
    {
        $question=new Question();
        $user=$this->getUser();
        $question->setUser($user);
        $form=$this->createForm(QuestionType::class,$question);
        $em= $this->getDoctrine()->getManager();
        $form->handleRequest($request);


        if($form->isSubmitted()){
            $em->persist($question);
            $em->flush();

            return $this->redirect('/question');
        }
        return $this->render('question/create_question.html.twig',
            [
                'form'=>$form->createView()
            ]
        );
    }

    /**
     * @Route ("/edit/{id}",name="edit")
     * @param Request $request
     * @param Question $question
     */
    public function edit(Request $request,Question $question){
        $form=$this->createForm(QuestionType::class,$question);
        $form->handleRequest($request);
        $user=$this->getUser();
        $question->setUser($user);
        $entitymanager=$this->getDoctrine()->getManager();
        if($form->isSubmitted() && $form->isValid()){
            $entitymanager->persist($question);
            $entitymanager->flush();
            return $this->redirect('/question');

        }
        return $this->render('question/create_question.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route ("delete/{id}",name="delete")
     * @param Request $request
     * @param Question $question
     */
    public function delete(Request $request,Question $question,QuestionRepository $repository){
        $user=$this->getUser();
        $em=$this->getDoctrine()->getManager();
        $userid=$question->getUser();
        if($user==$question->getUser()){
            $em->remove($question);
            $em->flush();
          return  $this->redirect('/question');
        }else{
            return $this->redirect('/question', Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * @Route ("/show/{id}",name="show")
     *
     */
    public function show(Question $question,Request $request){
        $reply=new Reply();
        $reply->setQuestion($question);
        $form=$this->createForm(ReplyType::class,$reply);
        $em=$this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($reply);
            $em->flush();
        }

        return $this->render('question/show.html.twig',[
            'question'=>$question,
            'form'=>$form->createView()
        ]);

    }
}
