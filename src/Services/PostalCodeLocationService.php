<?php

namespace App\Services;

use Doctrine\ORM\EntityManager;

class PostalCodeLocationService extends AbstractDbService
{
        const LIMIT_PAGE=10;

        public function __construct(EntityManager $em, $entityName)
        {
            $this->entityName   = $entityName;
            $this->em    = $em;
            $this->model = $em->getRepository($this->entityName);
        }

        /**
         * @param string $field
         * @param string $value
         * @param int $page
         * @param string $order
         * @param int $limit
         * @return array|int|string
         */
        public function PostalCodeLocationSearchfield(string $field,string  $value,int $page,string $order='asc',int  $limit=self::LIMIT_PAGE):array
        {

            $offset=self::LIMIT_PAGE*($page-1);

            return $this->searchfield("tabel.id,tabel.lat,tabel.lng,CONCAT(tabel.name ,' ',tabel.postalCode) as text ",$field, $value,$offset,$order, $limit);

        }

}
