<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @param CategoryRepository $categoryRepository
     * @return JsonResponse
     */
    public function index(CategoryRepository $categoryRepository,Request $request)
    {
        $categories=$categoryRepository->findAll();
        if($request->isXmlHttpRequest() || $request->query->get('showJson') == 1){
            $jsonData=array();
            $idx = 0;
            foreach($categories as $category) {
                $temp = array(
                    'name' => $category->getName(),
                );
                $jsonData[$idx++] = $temp;
            }
            return new JsonResponse($jsonData);
        }else{
            return $this->render('category/index.html.twig', [
                'categories'=>$categories
            ]);
        }

    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $category=new Category();


        $form=$this->createForm(CategoryType::class, $category);
        $em= $this->getDoctrine()->getManager();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $data=$category;
            $em->persist($category);
            $em->flush();
        }
        return $this->render('category/add_category.html.twig',['form'=>$form->createView()]);

    }

    /**
     * @Route ("/edit/{id}", name="edit")
     * @param Category $category
     * @param Request $request
     * @return Response
     */
    public function edit(Category $category,Request $request): Response
    {
        $form=$this->createForm(CategoryType::class, $category);
        $em= $this->getDoctrine()->getManager();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $data=$category;
            $em->persist($category);
            $em->flush();
        }
        return $this->render('category/add_category.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("/show/{id}" , name="show")
     * @param Category $category
     * @return Response
     */

    public function show(Category $category){
        dump($category); die;

        return $this->render(
            'show_category'
        );

    }

    /**
     * @Route ("/delete/{id}",name="delete")
     * @param Category $category
     */

    public function remove(Category $category){
        $em= $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        $this->addFlash('success','Deleted!!');
        return $this->redirect($this->generateUrl('categorycategory'));

    }
}
