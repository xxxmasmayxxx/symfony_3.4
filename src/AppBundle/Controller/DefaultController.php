<?php

namespace AppBundle\Controller;

use AppBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
//, requirements={"id": "[0-9]+"}

    public function indexAction()
    {
        $em = $this->getDoctrine();

        $lastNewsList = $em
            ->getRepository('AppBundle:News')
            ->getLastNewsList(3);

        if (!$lastNewsList)
        {
            throw $this->createNotFoundException('There is no News List');
        }

        $allActiveNews = $em
            ->getRepository('AppBundle:News')
            ->findBy(
                ['active' => '1']
            );

        $categoriesOfNews = $em
            ->getRepository('AppBundle:Category')
            ->findAll();

        // pagination

//        $numInList = 5;
//
//        $page = $page * $numInList - $numInList;
//
//        $NewsList = $em
//            ->getRepository('AppBundle:News')
//            ->getNewsList($numInList, $page);

        foreach ($categoriesOfNews as $category)
        {

            $news = $em->getRepository('AppBundle:News')
                ->getLastNewsByCategory($category, 5);

            foreach ($news as $newses)
            {
              $newsName[] = $newses->getTitle();
            }

            $categoryName = $category->getCategoryName();

//            dump($newsName);

            $arrayCategoriesNews[] = [$categoryName => $newsName];
//            dump($arrayCategoriesNews);

            unset($newsName);
//            unset($arrayCategoriesNews);

//      $i++;



        }
//dump($arrayCategoriesNews);

//        $page = 1
//
//        $numOfNews = count($allActiveNews);
//
//        $pagin = ceil($numOfNews/$numInList);
//
//        for ($i = 1; $i <= $pagin; $i++ )
//        {
//                $pages[] = $i;
//        }

        return $this->render('default/index.html.twig',  [
            'last_news_list' => $lastNewsList,
            'categoriesOfNews' => $categoriesOfNews,
            'arrayCategoriesNews'=> $arrayCategoriesNews,
//            'news_list' => $NewsList,
//            'pages' => $pages,

        ]);
    }

    /**
     * @Route("/news/{id}", name="news_item", requirements={"id": "[0-9]+"})
     * @param News $news
     * @return Response
     */

    public function showAction(News $news)
    {

        if (!$news->isActive()){
            throw $this->createNotFoundException('News is not active');
        }

        $pages = [];

        return $this->render('default\show.html.twig', [
            'news' => $news, 'pages' => $pages
        ]);
    }

}
