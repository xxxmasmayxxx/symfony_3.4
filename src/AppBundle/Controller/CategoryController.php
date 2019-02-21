<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{
    /**
     * @Route("/{category}", name="category")
     */


    public function indexAction($category)
    {
        $em = $this->getDoctrine()->getRepository('AppBundle:Category');

        $category = $em->getCategoryByName($category);

        $lastNewsInCategory = $em->getLastNewsByCategory($category, 5);

        return $this->render('category/showCategory.html.twig',[
            'category' => $category,
            'lastNewsInCategory' => $lastNewsInCategory,
        ]);
    }

}
