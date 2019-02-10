<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * NewsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NewsRepository extends EntityRepository
{
    public function getLastNewsList()
    {
        return $this->findBy(
                ['active' => '1'],
                ['date' => 'DESC'],
                3,
                0
            );
    }

    public function getNewsList($limit = 5, $offset = 1)
    {
        return $this->findBy(
            ['active' => '1'],
            ['date' => 'DESC'],
            $limit,
            $offset
        );
    }

    public function getLastNewsByCategory($category, $limit)
    {
        return $this->findBy(
            [
                'active' => '1',
                'category' => $category,
            ],
            ['date' => 'DESC'],
            $limit,
            0
        );
    }
}
