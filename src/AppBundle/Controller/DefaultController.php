<?php

namespace AppBundle\Controller;

use AppBundle\Entity\News;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/{page}", name="home", requirements={"id": "[0-9]+"})
     */

    public function indexAction($page = 1)
    {


        $lastNewsList = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:News')
            ->getLastNewsList();

        if (!$lastNewsList)
        {
            throw $this->createNotFoundException('There is no News List');
        }

        $categoriesOfNews = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findAll();

        $allActiveNews = $this
            ->getDoctrine()
            ->getRepository('AppBundle:News')
            ->findBy(
                ['active' => '1']
            );

        $arrayCategoriesNews = [];
        foreach ($categoriesOfNews as $category)
        {
            $lastNewsInCategory = $this
                ->getDoctrine()
                ->getRepository('AppBundle:News')
                ->getLastNewsByCategory($category, 5);

            foreach ($lastNewsInCategory as $news)
            {
                dump($category->getCategoryName().'-'.$news->getTitle());
//                $arrayCategoriesNews[$category->getCategoryName()] =
//                    [$news->getTitle()
//                    ];
            }

        }
dump($arrayCategoriesNews);


        $numInList = 5;

        $page = $page * $numInList - $numInList;

        $NewsList = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:News')
            ->getNewsList($numInList, $page);

        $numOfNews = count($allActiveNews);

        $pagin = ceil($numOfNews/$numInList);

        for ($i = 1; $i <= $pagin; $i++ )
        {
                $pages[] = $i;
        }

        return $this->render('default/index.html.twig',  [
            'last_news_list' => $lastNewsList,
            'categoriesOfNews' => $categoriesOfNews,
            'arrayCategoriesNews'=> $arrayCategoriesNews,
            'news_list' => $NewsList,
            'pages' => $pages,

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
