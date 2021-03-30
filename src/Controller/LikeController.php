<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    /**
     * @Route("/like/{id}", name="like")
     */
    public function likes(Question $question):Response{

        $currentuser= $this->getUser();

        if(!$currentuser instanceof User){
            return "false";
           // return new Response([],Response::HTTP_UNAUTHORIZED);
        }
        $question->addLike($currentuser);
        $this->getDoctrine()->getManager()->flush();

    }

    /**
     * @Route("/unlike/{id}", name="unlike")
     */
    public function ulikes(Question $question){


    }
}
