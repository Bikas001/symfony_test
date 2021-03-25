<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/category", name="category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="category")
     */
    public function index(CategoryRepository $categoryRepository)
    {
        $categories=$categoryRepository->findAll();
        dump($categories);

        return $this->render('category/index.html.twig', [
            'categories'=>$categories
        ]);
    }
    /**
     * @Route("/create", name="create")
     * @param Request $request
     */
    public function create(Request $request){
        $category = new Category();
        $category->setName('Science');
        $em= $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();

        return new Response('post was created');

    }

    /**
     * @Route("/show/{id}" , name="show")
     * @return Response
     */
    public function show($id, CategoryRepository $categoryRepository){
        $category=$categoryRepository->find($id);
        dump($category);
        return $this->render(
            'show_category'
        );
    }
}
