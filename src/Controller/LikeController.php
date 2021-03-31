<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\User;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    /**
     * @Route("/like/", name="like")
     */
    public function likes(Request $request):Response{

        $currentuser= $this->getUser();
        $this->getDoctrine()->getManager()->flush();

    }

    /**
     * @Route("/unlike/{id}", name="unlike")
     */
    public function ulikes(Question $question){


    }
}
