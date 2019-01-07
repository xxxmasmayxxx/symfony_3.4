<?php

namespace AppBundle\Controller;

use AppBundle\Entity\News;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     *
     * @Template()
     */

    public function indexAction()
    {

        $news = $this->getDoctrine()->getRepository('AppBundle:News')
            ->findBy(
                ['active' => '1'],
                ['date' => 'DESC'],
                5
            );

        return ['news' => $news];
    }

    /**
     * @Route("/news/{id}", name="news_item", requirements={"id": "[0-9]+"})
     * @Template()
     * @param News $news
     * @return array
     */
    public function showAction(
//                                $id
                                 News $news)
    {
//        $news = $this->getDoctrine()->getRepository('AppBundle:News')
//            ->find($id);
//
//        if (!$news){
//            throw $this->createNotFoundException('News not found.');
//        }

        if (!$news->isActive()){
            throw $this->createNotFoundException('News is not active');
        }

       return ['news' => $news];
    }

}
