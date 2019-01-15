<?php

namespace AppBundle\Controller;

use AppBundle\Entity\News;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Controller\Pagination;

class DefaultController extends Controller
{
    /**
     * @Route("/{page}", name="home", requirements={"id": "[0-9]+"})
     *
     * @Template()
     */

    public function indexAction($page = 1)
    {
        $numInList = 5;

        $page = $page * $numInList - $numInList;

        $lastNewsList = $this->getDoctrine()->getRepository('AppBundle:News')
            ->findBy(
                ['active' => '1'],
                ['date' => 'DESC'],
                $numInList,
                $page
            );

        if (!$lastNewsList){
            throw $this->createNotFoundException('Sorry. There is no so page.');
        }

        $allNews = $this->getDoctrine()->getRepository('AppBundle:News')
            ->findBy(
                ['active' => '1']
            );

        $numOfNews = count($allNews);

        $pagin = ceil($numOfNews/$numInList);

        for ($i = 1; $i <= $pagin; $i++ ) {
                $pages[] = $i;
    }

// todo add categories in db
//        $categories = 'Consumer Services Technology Energy Health Care Finance Capital Goods Basic
//        Industries Transportation Miscellaneous Public Utilities Consumer Non-Durables Consumer Durables';


        return [
            'last_news_list' => $lastNewsList,
            'pages' => $pages,

        ];
    }

    /**
     * @Route("/news/{id}", name="news_item", requirements={"id": "[0-9]+"})
     * @Template()
     * @param News $news
     * @return array
     */
    public function showAction(News $news)
    {

        if (!$news->isActive()){
            throw $this->createNotFoundException('News is not active');
        }

        $pages = [];

        return ['news' => $news, 'pages' => $pages];
    }

}
