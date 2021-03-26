<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     */
    public function index(QuestionRepository $questionRepository): Response
    {
        $question=$questionRepository->findAll();

        return $this->render('question/index.html.twig', [
            'questions'=>$question
        ]);
    }

    /**
     * @Route("/question/create",name="create")
     * @param Request $request
     * @return Response
     */

    public function create(Request $request)
    {
        $question=new Question();
        $form=$this->createForm(QuestionType::class,$question);
        $em= $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($question);
            $em->flush();
        }


        return $this->render('question/create_question.html.twig',
            [
                'form'=>$form->createView()
            ]
        );
    }
}
