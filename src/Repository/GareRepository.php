<?php
/**
 * Created by PhpStorm.
 * User: Sylva
 * Date: 22/01/2018
 * Time: 21:57
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;

class GareRepository extends EntityRepository
{
    public function getGares()
    {
        $query = $this->createQueryBuilder('s')
            ->select('s.uic, s.realName, s.slug');

        return $query->getQuery()->getArrayResult();
    }

}