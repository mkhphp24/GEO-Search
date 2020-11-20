<?php

namespace App\Services;

use Doctrine\ORM\EntityManager;

class PartnerService extends AbstractDbService
{
        const LIMIT_PAGE=10;

        public function __construct(EntityManager $em, $entityName)
        {
            $this->entityName   = $entityName;
            $this->em    = $em;
            $this->model = $em->getRepository($this->entityName);
        }

        /**
         * @param string $lat
         * @param string $lng
         * @param int $distance
         * @return array
         */
        public function findDistance(string $lat,string $lng,int $distance):array
        {

            $query = $this->model->createQueryBuilder('tabel')
                ->select('tabel.name,tabel.thoroughfare,tabel.lat,tabel.lng,ST_Distance_Sphere(POINT(tabel.lat,tabel.lng), POINT(:lat,:lng))  as distance ')
                ->setParameter('lat', $lat)
                ->setParameter('lng', $lng)
                ->having('distance <='."'$distance'")
                ->add('groupBy', 'tabel.id')
                ->orderBy('distance','ASC');

            $result=$query->getQuery()->getArrayResult();
            return $result;
        }


}
