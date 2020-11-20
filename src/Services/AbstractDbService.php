<?php

namespace App\Services;

use Doctrine\ORM\EntityManager;


abstract class AbstractDbService
{
		/**
		 * @var \Doctrine\ORM\EntityRepository
		 */

		protected $model;
		protected $em;
		protected $entityName;


		/**
		 * @return EntityManager
		 */

		protected function entityManager()
		{
			return $this->em;
		}

        /**
         * @param $field
         * @param $value
         * @param $operation
         * @param $order
         * @param $offset
         * @param $limit
         *
         * @return array|int|string
         */

        protected function searchfield($fieldSelect,$field, $value, $offset,$order='asc', $limit='50')
        {
            $query = $this->model->createQueryBuilder('tabel')
                ->select( $fieldSelect)
                ->where(" tabel.$field  LIKE  :value ")
                ->setParameter("value",  $value.'%')
                ->addOrderBy(" tabel.$field ", $order)
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery();

            return $query->getArrayResult();
        }

}
